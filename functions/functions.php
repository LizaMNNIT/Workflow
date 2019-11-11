<?php
include("connection.php");
function check($eid,$email,$contact,$pass,$ext,$date,$c_pass,$path_filename_ext)
{
  global $conn;
  $query="select * from employee where eid='$eid'";
  $query1="select * from employee where email='$email'";
  $query2="select * from employee where contact='$contact'";
if(mysqli_query($conn,$query))
{
  echo"<script>console.log('query running');</script>";
}
  $run=mysqli_query($conn,$query);
  $run1=mysqli_query($conn,$query1);
$run2=mysqli_query($conn,$query2);
 $rowcount=mysqli_num_rows($run);
  $rowcount1=mysqli_num_rows($run1);
   $rowcount2=mysqli_num_rows($run2);
//$obj=mysqli_fetch_object($run);
//echo "'.$rowcount.";
//echo "<script>console.log('run=".$run." run1=".$run1." run2=".$run2."');</script>";
  if($rowcount>0)
  {
    $msg='UserId already exists';
    return $msg;
  }
  if($rowcount1>0)
  {
    $msg='Email already registered';
    return $msg;
  }
  if($rowcount2>0)
  {
    $msg='Contact number already registered';
    return $msg;
  }

  if($pass!=$c_pass)
  {
    $msg='Password and Confirm password do not match';
    return $msg;
  }

  if(strlen($contact)!=10)
  {
    $msg='Contact number invalid';
    return $msg;
  }
  if($ext!='jpg' && $ext!='png')
  {
    $msg='Upload a jpg or png file';
    return $msg;
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $msg = "Invalid email format";
    return $msg;
  }
  $date1=date("y-m-d");
  $stamp1=strtotime($date);
  $stamp2=strtotime($date1);

  //echo "$stamp1";
  //echo "$stamp2";
  if($stamp1 > $stamp2 )
  {
    $msg='Enter a valid date';
    return $msg;
  }
  if (file_exists($path_filename_ext)) {
   $msg= 'Sorry, file already exists';
   return $msg;
   }
  else
  return "done";
}

function check1($des,$id,$passwd)
{
  global $conn;
$query3="select * from employee where eid='$id' and designation='$des'";
$run3=mysqli_query($conn,$query3);
$rowcount3=mysqli_num_rows($run3);
if($rowcount3)
{
  $query4="select * from employee where eid='$id' and pswd='$passwd'";
  $run4=mysqli_query($conn,$query4);
    $row = mysqli_fetch_assoc($run4);
  $rowcount4=mysqli_num_rows($run4);
  if($rowcount4)
  {
    if($row['status']=='1')
  return "done";
  else
  {
    $msg="Account not activated,Check your gmail to activate";
    return $msg;
  }
  }

else
{
$msg="UserId and password do not match";
return $msg;
}
}
else {
  $msg='Email Id not registered as the specified role, Register First';
  return $msg;
}
}

 ?>
