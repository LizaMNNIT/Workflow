<?php
include('../functions/connection.php');
if($_POST['operation'] == "fwd")
{
$t = $_POST['applicationid'];
$query = "UPDATE `application` SET `hr_approved` = 3 WHERE `app_no`=$t";
$q = mysqli_query($conn,$query);
header("location:../employee/status.php");
}
?>