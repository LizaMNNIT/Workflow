<?php
include('../functions/connection.php');
print_r($_POST);
if($_POST['operation'] == "fwd")
{
    //HOD = 2
    // HR = -1;
$t = $_POST['applicationid'];
$query = "UPDATE `application` SET `hod_approved` = 2 WHERE `app_no`=$t";
$q = mysqli_query($conn,$query);
}
if($_POST['operation'] == "rej")
{
    //HOD = 0
    // HR = -1;
$t = $_POST['applicationid'];
$query = "UPDATE `application` SET `hod_approved` = 0 WHERE `app_no`=$t";
$q = mysqli_query($conn,$query);
}
if($_POST['operation'] == "app")
{
    //HOD = 1
    // HR = -1;
$t = $_POST['applicationid'];
$query = "UPDATE `application` SET `hod_approved` = 1 WHERE `app_no`=$t";
$q = mysqli_query($conn,$query);

}
?>