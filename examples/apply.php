<html><body><?php
include('../functions/connection.php');

    $ename = @$_POST["name"];
    $eid = @$_POST["id"];
	$department = @$_POST["department"];
    $team_no = @$_POST["team_no"];
	$reason = @$_POST["reason"];
    $type = @$_POST["leave"];
	$from_date = @$_POST["from_date"];
    $to_date = @$_POST["to_date"];
?>
    <h1>hello!!</h1>
<?php echo $ename;
echo $eid ."<br>";
echo $department . "<br>";
echo $team_no ."<br>";
echo $reason . "<br>";
echo $from_date . "<br>";
echo $to_date . "<br>";
echo $type;
 $sql="INSERT INTO application (eid, reason, from_date, to_date) VALUES ('$eid', '$reason', '$from_date', '$to_date')";
  //  $sql="insert into application (eid, reason, leave_type, from_date, to_date) values ('101', 'fever', '', '$from_date', '$to_date')";
  mysqli_query($conn,$sql);

?>
</body>
</html>
