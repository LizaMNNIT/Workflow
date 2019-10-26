<?php

$servername = "den1.mysql4.gear.host";
$username = "workflow";
$password = "Workflow@123";
$dbname = "workflow";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if($conn)
{
echo "<script>console.log('Connection established');</script>";
}
if (!$conn)
{
    die("Connection failed: " . mysqli_connect_error());
}
?>
