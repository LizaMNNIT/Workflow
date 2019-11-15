
<?php
include('../functions/connection.php');
if($_POST['operation'] == "app")
{
    //HOD = 1
    // HR = -1;
    
$t = $_POST['applicationid'];

//$q3="SELECT leave_type from application where app_no=$t";
// $to = ($data['to_date']);
// $from = ($data['from_date']);
  //
  //$q4="UPDATE application set $q3 = $q3 - $diff where app_no=$t";
$sql="SELECT * FROM employee WHERE eid=(SELECT eid from application WHERE app_no=$t)";
             
              $result = mysqli_query($conn,$sql);
              while($row = mysqli_fetch_assoc($result))
              {
                $department=$row['department'];
                $uname=$row['ename'];
                $id=$row['eid'];
                $team_no=$row['team_no'];
                $sign=$row['sign'];
              }

$sql="SELECT * FROM application WHERE app_no=$t";
             
              $result = mysqli_query($conn,$sql);
              while($row = mysqli_fetch_assoc($result))
              {
                                $leave=$row['leave_type'];
				$to_date=$row['to_date'];
				$from_date=$row['from_date'];
				$reason=$row['reason'];
				$to = new DateTime($to_date);
                     	        $from = new DateTime($from_date);
                                $diff=date_diff($to,$from);
              }
              $sql1="SELECT * from leave_info where eid=(SELECT eid from application WHERE app_no=$t)";
              $result1=mysqli_query($conn,$sql);
              while($row1 = mysqli_fetch_assoc($result))
              {
                $rem_days=$row1[$leave];
              }
$q4="UPDATE leave_info set $leave=$rem_days-$diff->days where eid=(SELECT eid from application WHERE app_no=$t)";
$q3 = mysqli_query($conn,$q4); 
if(!$q3)
{
  echo "<script>console.log('Error');</script>";
}
else
{
  echo "<script>console.log('Al ok');</script>";
}

$query = "UPDATE `application` SET `hr_approved` = 1 WHERE `app_no`=$t";
$q = mysqli_query($conn,$query);
$date=date("d/m/Y");
$sign1="C:/xampp/htdocs/Workflow/files/download.jpg";
    require('fpdf/fpdf.php');
             $pdf= new FPDF();
             $pdf->AddPage();
             $pdf->SetFont("Arial","","14");
             $pdf->Cell(100,10,"Head of Department",0,1);
             $pdf->Cell(100,10,"{$department} Department",0,1);
             $pdf->Cell(100,10,"XYZ Company",0,1);
             $pdf->Cell(300,10,"",0,1);
             $pdf->Cell(100,10,"Date: {$date}",0,1);
             $pdf->Cell(300,10,"",0,1);
             $pdf->Cell(100,10,"Subject: {$leave} Leave Application",0,1);
             $pdf->Cell(300,10,"",0,1);
             $pdf->Cell(100,10,"Dear Sir,",0,1);
             $pdf->Cell(300,10,"My name is {$uname}, employee id {$id}, of {$department} Department, team number {$team_no}.",0,1);
             $pdf->Cell(300,10,"I want to apply for leave from {$from_date} to {$to_date} due to {$reason}.",0,1);
             $pdf->Cell(300,10,"I will be obliged if you consider my application for approval.",0,1);
             $pdf->Cell(300,10,"",0,1);
             $pdf->Cell(300,10,"Yours sincerely,",0,1);
             $pdf->Image($sign,10,160,20,20);
             $pdf->Image($sign1,160,180,40,40);
             $pdf->Cell(300,10,"{$uname}",0,1);
             $filename="C:/xampp/htdocs/Workflow/files/PDF/{$t}.pdf";
             $pdf->Output($filename,'F');



header("location:../hr/curr_app_hr_by_hod.php");
}
if($_POST['operation'] == "rej")
{
    //HOD = 0
    // HR = -1;
    
$t = $_POST['applicationid'];
$query = "UPDATE `application` SET `hr_approved` = 0 WHERE `app_no`=$t";
$q = mysqli_query($conn,$query);
header("location:../hr/curr_app_hr_by_hod.php");
}
if($_POST['operation'] == "det")
{
    //HOD = 1
    // HR = -1;
    echo "<script>console.log('chla to sahi');</script>";
    $e = $_POST['employeeid'];
    echo $e;
    $sql= "SELECT sick,casual,earned from leave_info where eid='$e'";
  $result = mysqli_query($conn,$sql);
      // while($row = mysqli_fetch_assoc($result))
      // {
      //   $va1=$row['sick'];
      //   $va2=$row['casual'];
      //   $va3=$row['earned'];
      //  echo $va;
      // }
      $row = mysqli_fetch_assoc($result);
      $va1=$row['sick'];
        $va2=$row['casual'];
        $va3=$row['earned'];
       echo $va1;
       $msg='Sick leaves :'.$va1.' Casual leaves :'.$va2.' Earned leaves: '.$va3;
       return $msg;
  
    //  header("location:../hr/curr_app_hr_by_hod.php");
}
?>