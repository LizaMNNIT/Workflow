<?php
include('../functions/connection.php');
if($_POST['operation'] == "app")
{
    //HOD = 1
    // HR = -1;
    
$t = $_POST['applicationid'];
$query = "UPDATE `application` SET `hr_approved` = 1 WHERE `app_no`=$t";
$q = mysqli_query($conn,$query);
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

?>