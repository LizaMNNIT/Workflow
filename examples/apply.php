<html><body><?php
include('../functions/connection.php');

    $ename = @$_POST["ename"];
    $eid = @$_POST["eid"];
	$department = @$_POST["department"];
    $team_no = @$_POST["team_no"];
	$reason = @$_POST["reason"];
    $type = @$_POST["leave"];
	$from_date = @$_POST["from_date"];
    $to_date = @$_POST["to_date"];
    
 $sql="INSERT INTO application (eid, reason, from_date, to_date) VALUES ('$eid', '$reason', '$from_date', '$to_date')";
  mysqli_query($conn,$sql);

?>
</body>
</html>
