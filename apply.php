<html><body><?php
include('../functions/connection.php');

    $ename = @$_POST["ename"];
    $eid = @$_POST["eid"];
	$department = @$_POST["department"];
    $team_no = @$_POST["team_no"];
	$reason = @$_POST["reason"];
    $leave = @$_POST["leave"];
	$from_date = @$_POST["from_date"];
    $to_date = @$_POST["to_date"];
    echo $leave;
 $sql="INSERT INTO application (eid, reason, leave_type, from_date, to_date, hr_approved, hod_approved) VALUES ('$eid', '$reason','$leave' ,'$from_date', '$to_date','-1','-1')";
  mysqli_query($conn,$sql);

?>
</body>
</html>
