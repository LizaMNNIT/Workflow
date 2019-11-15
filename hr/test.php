
<? php

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");
    $e = $_POST['eid'];
    $sl= "SELECT `sick` from `leave_info` where `eid`=$e";
   	if(!mysqli_query($conn,$sl))
   	{
   		 echo"<script>console.log('error in test');</script>";
   	}
   	else
   	{
    $row    = mysqli_fetch_assoc($q1) ;
     
      $va= $row['sick'];
      echo "$va";
      echo"<script>console.log('in test');</script>";
  }
     echo array("abc"=>'successfuly registered');
      //echo json_encode(array('Error' => 'PDO fel "$err"'));
      //header("location:../hr/curr_app_hr_by_hod.php");
?>
