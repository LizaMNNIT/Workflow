<?php
include('../functions/connection.php');

//if we reach this line, we are connected to the database

$query = "SELECT * FROM `application`,`employee` WHERE application.hod_approved=-1 AND employee.eid = application.eid";
//echo $query;
$data = array();
$q = mysqli_query($conn,$query);
        if($q)
        {
            $rowcount=mysqli_num_rows($q);
			$data['total_data_rows'] = $rowcount;
			while($row = mysqli_fetch_assoc($q)) 
			{
				$data['data'][] = $row;
			}
            //$all_data = mysqli_fetch_all($q,MYSQLI_ASSOC);
            mysqli_free_result($q);
        }
        else
        {
            $data = null;
        }
?>
<html>
<head>
<script type="text/javascript">
function approve(appnid)
{
    var y = appnid.substring(4);
    var hid = document.getElementById("applicationid");
    hid.value = y;
    var operation = appnid.substring(0,3);
    var op = document.getElementById("operation");
    op.value= operation;
    var form = document.getElementById("mainform");
    form.submit();
}
function reject(appnid)
{
    var y = appnid.substring(4);
    var hid = document.getElementById("applicationid");
    hid.value = y;
    var operation = appnid.substring(0,3);
    var op = document.getElementById("operation");
    op.value= operation;
    var form = document.getElementById("mainform");
    form.submit();
}
function forward(appnid)
{
    var y = appnid.substring(4);
    var hid = document.getElementById("applicationid");
    hid.value = y;
    var operation = appnid.substring(0,3);
    var op = document.getElementById("operation");
    op.value= operation;
    var form = document.getElementById("mainform");
    form.submit();
}
</script>
</head>
<body>
<form id="mainform" method="POST" action="./process.php">
<input type="hidden" id="applicationid" name="applicationid" value="0">
<input type="hidden" id="operation" name="operation" value="0">
<table border="1" cellspacing="0" cellpadding="0">
<thead>
<td>
Unique Application ID
</td>

<td>
Employee Name
</td>
<td>
Reason
</td>
<td>
Action Buttons
</td>
</thead>
<tbody>
<?php
//print_r($data);
for($i=0;$i<$data['total_data_rows'];$i++)
{
    $app_no = $data['data']["$i"]['app_no'];
    $emp = $data['data']["$i"]['ename'];
    $sl = $data['data']["$i"]['reason'];
  //  $co = $data['data']["$i"]['leave_type'];
    
    echo "<tr><td>$app_no</td><td>$emp</td><td>$sl</td>";
    echo "<td><input id=\"app_$app_no\" type=\"button\" type=\"button\" onclick=\"javascript:approve(this.id);\" value=\"Approve\"></td>";
    echo "<td><input id=\"rej_$app_no\" type=\"button\" type=\"button\" onclick=\"javascript:reject(this.id);\" value=\"Reject\"></td>";
    echo "<td><input id=\"fwd_$app_no\" type=\"button\" type=\"button\" onclick=\"javascript:forward(this.id);\" value=\"Forward\">;</td></tr>";
}

?>
</tbody>
</table>
</form>
</body>
</html>