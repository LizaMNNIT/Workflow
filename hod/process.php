<?php
session_start();
include('../functions/connection.php');

     //echo"<script>console.log($sign1);</script>";
if($_POST['operation'] == "app")
{

$t = $_POST['applicationid'];

$sql="SELECT * FROM employee WHERE eid=(SELECT eid from application WHERE app_no='$t')";

              $result = mysqli_query($conn,$sql);
              while($row = mysqli_fetch_assoc($result))
              {
                $department=$row['department'];
                $uname=$row['ename'];
                $id=$row['eid'];
                $team_no=$row['team_no'];
                $sign=$row['sign'];


              }

$sql="SELECT * FROM application WHERE app_no=$t";

              $result = mysqli_query($conn,$sql);
              while($row = mysqli_fetch_assoc($result))
              {
                $leave=$row['leave_type'];
			        $to_date=$row['to_date'];
			                        	$from_date=$row['from_date'];
				                        $reason=$row['reason'];
			                        	$to = new DateTime($to_date);
                     	        $from = new DateTime($from_date);
                                $diff=date_diff($to,$from);
              }

              $sql1="SELECT * from leave_info where eid=(SELECT eid from application WHERE app_no=$t)";
              $result1=mysqli_query($conn,$sql1);
              while($row1 = mysqli_fetch_assoc($result1))
              {

                if($leave=='sick')
                $rem_days=$row1['sick'];
                else if($leave=='casual')
                $rem_days=$row1['casual'];
              else if($leave=='earned')
                $rem_days=$row1['earned'];
              }
$q4="UPDATE leave_info set $leave=$rem_days-$diff->days where eid=(SELECT eid from application WHERE app_no=$t)";
$q3 = mysqli_query($conn,$q4);

$query = "UPDATE `application` SET `hod_approved` = 1 WHERE `app_no`=$t";
$q = mysqli_query($conn,$query);


 $hod_id=$_SESSION['loggedin'];
 echo"<script>console.log($hod_id);</script>";
 $sql= "SELECT * from employee where eid= '$hod_id'";

      $result = mysqli_query($conn,$sql);
      if(!$result)
      {
      	 echo "<script>console.log('hoja yr');</script>";
      }
else
{
	echo "<script>console.log('hoja yr1');</script>";
	$row = mysqli_fetch_assoc($result);

	$sign2=$row['sign'];
         echo $sign2;
      /*while($row = mysqli_fetch_assoc($result))
      {
        $sign2=$row['sign'];
         echo "<script>console.log($sign2);</script>";
      }*/

    }
$date=date("d/m/Y");

    require('fpdf/fpdf.php');
             $pdf= new FPDF();
             $pdf->AddPage();
             $pdf->SetFont("Arial","","14");

             $pdf->Cell(100,10,"Head of Department",0,1);
             $pdf->Cell(100,10,"{$department} Department",0,1);
             $pdf->Cell(100,10,"XYZ Company",0,1);
             $pdf->Cell(180,10,"",0,1);
             $pdf->Cell(180,10,"Date: {$date}",0,1);
             $pdf->Cell(180,10,"",0,1);
             $pdf->Cell(100,10,"Subject: {$leave} Leave Application",0,1);
             $pdf->Cell(180,10,"",0,1);
             $pdf->Cell(100,10,"Dear Sir,",0,1);
             $pdf->Cell(180,10,"My name is {$uname}, employee id {$id}, of {$department} Department, team number {$team_no}.",0,1);
             $pdf->Cell(180,10,"I want to apply for leave from {$from_date} to {$to_date} due to {$reason}.",0,1);
             $pdf->Cell(180,10,"I will be obliged if you consider my application for approval.",0,1);
             $pdf->Cell(180,10,"",0,1);
             $pdf->Cell(180,10,"Yours sincerely,",0,1);

             $pdf->Image($sign,10,160,20,20);
            $pdf->Image($sign2,160,180,40,40);
             $pdf->Cell(300,10,"{$uname}",0,1);
             $pdf->Cell(180,10,"HOD's Signature",0,1,'R');
             $filename="C:/xampp/htdocs/Workflow/files/PDF/{$t}.pdf";
             $pdf->Output($filename,'F');


    header("location:../hod/curr_app.php");
}

if($_POST['operation'] == "fwd")
{
    //HOD = 2
    // HR = -1;
$t = $_POST['applicationid'];
$query = "UPDATE `application` SET `hod_approved` = 2 WHERE `app_no`=$t";
$q = mysqli_query($conn,$query);
header("location:../hod/curr_app.php");
}
if($_POST['operation'] == "rej")
{
    //HOD = 0
    // HR = -1;
    ;
$t = $_POST['applicationid'];
$query = "UPDATE `application` SET `hod_approved` = 0 WHERE `app_no`=$t";
$q = mysqli_query($conn,$query);
header("location:../hod/curr_app.php");
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
WorkFlow  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="../assets/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../assets/demo/demo.css" rel="stylesheet" />
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="white" data-image="../assets/img/sidebar-1.jpg">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
      <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
          WORKFLOW
        </a>
      </div>
      <div class="sidebar-wrapper">

      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <?php
      if($_POST['operation'] == "det")
{
$eid = $_POST['applicationid'];
      include('../functions/connection.php');

      $sql= "SELECT ename from employee where eid= '$eid'";

      $result = mysqli_query($conn,$sql);
      while($row = mysqli_fetch_assoc($result))
      {
        $uname=$row['ename'];
      }
}
      ?>
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <h3 style="color:purple;">Leave Information Of <?php echo $uname ?></h3>
          </div>

          <div class="collapse navbar-collapse justify-content-end">


          </div>
        </div>
      </nav>
      <!-- End Navbar -->

      <div class="content">
        <div class="container-fluid">
          <div class="row"><br><br><br></div>
          <div class="row">
            <div class="col-md-4">
              <div class="card ">
                <div class="card-header card-header-success">
        <div class="card-category">
        <br>
                  <b style="color:purple;font-size:50px">
                  <?php
                            if($_POST['operation'] == "det")
{
$eid = $_POST['applicationid'];
                            $sql= "SELECT sick from leave_info where eid= '$eid'";

                            $result = mysqli_query($conn,$sql);
                            while($row = mysqli_fetch_assoc($result))
                            {
                              echo "{$row['sick']}";
                            }
}
                             ?>
                             </b><b style="font-size:20px">leaves left</b> <br><br></div>
                </div>

                <div class="card-body">
                  <h4 class="card-title">Sick Leaves</h4>
                </div>

              </div>



            </div>
            <div class="col-md-4">
              <div class="card">
                <div class="card-header card-header-warning ">
        <div class="card-category">
        <br>
                  <b style="color:purple;font-size:50px"> <?php
                       if($_POST['operation'] == "det")
{
$eid = $_POST['applicationid'];
                            $sql= "SELECT casual from leave_info where eid= '$eid'";

                            $result = mysqli_query($conn,$sql);
                            while($row = mysqli_fetch_assoc($result))
                            {
                              echo "{$row['casual']}";
                            }
}
                             ?> </b><b style="font-size:20px">leaves left</b> <br><br></div>
                </div>
                <div class="card-body">
                  <h4 class="card-title">Casual Leaves</h4>
                </div>

              </div>
            </div>
            <div class="col-md-4">
              <div class="card">
                <div class="card-header card-header-danger ">
        <div class="card-category">
        <br>
                  <b style="color:purple;font-size:50px"> <?php
      if($_POST['operation'] == "det")
{
$eid = $_POST['applicationid'];
                            $sql= "SELECT earned from leave_info where eid= '$eid'";

                            $result = mysqli_query($conn,$sql);
                            while($row = mysqli_fetch_assoc($result))
                            {
                              echo "{$row['earned']}";
                            }
}
                             ?> </b><b style="font-size:20px">leaves left</b><br><br></div>
                </div>
                <div class="card-body">
                  <h4 class="card-title">Earned Leaves</h4>
                </div>

              </div>
            </div>
          </div>
<div style="text-align: right">
<a href="curr_app.php" style="color:purple;"><--Go back to Current Applications Page</a>
</div>

  <!--   Core JS Files   -->
  <script src="../assets/js/core/jquery.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap-material-design.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!-- Plugin for the momentJs  -->
  <script src="../assets/js/plugins/moment.min.js"></script>
  <!--  Plugin for Sweet Alert -->
  <script src="../assets/js/plugins/sweetalert2.js"></script>
  <!-- Forms Validations Plugin -->
  <script src="../assets/js/plugins/jquery.validate.min.js"></script>
  <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
  <script src="../assets/js/plugins/jquery.bootstrap-wizard.js"></script>
  <!--  Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
  <script src="../assets/js/plugins/bootstrap-selectpicker.js"></script>
  <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
  <script src="../assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
  <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
  <script src="../assets/js/plugins/jquery.dataTables.min.js"></script>
  <!--  Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
  <script src="../assets/js/plugins/bootstrap-tagsinput.js"></script>
  <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
  <script src="../assets/js/plugins/jasny-bootstrap.min.js"></script>
  <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
  <script src="../assets/js/plugins/fullcalendar.min.js"></script>
  <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
  <script src="../assets/js/plugins/jquery-jvectormap.js"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="../assets/js/plugins/nouislider.min.js"></script>
  <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
  <!-- Library for adding dinamically elements -->
  <script src="../assets/js/plugins/arrive.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chartist JS -->
  <script src="../assets/js/plugins/chartist.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/material-dashboard.js?v=2.1.1" type="text/javascript"></script>
  <!-- Material Dashboard DEMO methods, don't include it in your project! -->
  <script src="../assets/demo/demo.js"></script>
  <script>
    $(document).ready(function() {
      $().ready(function() {
        $sidebar = $('.sidebar');

        $sidebar_img_container = $sidebar.find('.sidebar-background');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');

        window_width = $(window).width();

        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

        if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
          if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
            $('.fixed-plugin .dropdown').addClass('open');
          }

        }

        $('.fixed-plugin a').click(function(event) {
          // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
          if ($(this).hasClass('switch-trigger')) {
            if (event.stopPropagation) {
              event.stopPropagation();
            } else if (window.event) {
              window.event.cancelBubble = true;
            }
          }
        });

        $('.fixed-plugin .active-color span').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-color', new_color);
          }

          if ($full_page.length != 0) {
            $full_page.attr('filter-color', new_color);
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.attr('data-color', new_color);
          }
        });

        $('.fixed-plugin .background-color .badge').click(function() {
          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('background-color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-background-color', new_color);
          }
        });

        $('.fixed-plugin .img-holder').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).parent('li').siblings().removeClass('active');
          $(this).parent('li').addClass('active');


          var new_image = $(this).find("img").attr('src');

          if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            $sidebar_img_container.fadeOut('fast', function() {
              $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
              $sidebar_img_container.fadeIn('fast');
            });
          }

          if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $full_page_background.fadeOut('fast', function() {
              $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
              $full_page_background.fadeIn('fast');
            });
          }

          if ($('.switch-sidebar-image input:checked').length == 0) {
            var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
          }
        });

        $('.switch-sidebar-image input').change(function() {
          $full_page_background = $('.full-page-background');

          $input = $(this);

          if ($input.is(':checked')) {
            if ($sidebar_img_container.length != 0) {
              $sidebar_img_container.fadeIn('fast');
              $sidebar.attr('data-image', '#');
            }

            if ($full_page_background.length != 0) {
              $full_page_background.fadeIn('fast');
              $full_page.attr('data-image', '#');
            }

            background_image = true;
          } else {
            if ($sidebar_img_container.length != 0) {
              $sidebar.removeAttr('data-image');
              $sidebar_img_container.fadeOut('fast');
            }

            if ($full_page_background.length != 0) {
              $full_page.removeAttr('data-image', '#');
              $full_page_background.fadeOut('fast');
            }

            background_image = false;
          }
        });

        $('.switch-sidebar-mini input').change(function() {
          $body = $('body');

          $input = $(this);

          if (md.misc.sidebar_mini_active == true) {
            $('body').removeClass('sidebar-mini');
            md.misc.sidebar_mini_active = false;

            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

          } else {

            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

            setTimeout(function() {
              $('body').addClass('sidebar-mini');

              md.misc.sidebar_mini_active = true;
            }, 300);
          }

          // we simulate the window Resize so the charts will get updated in realtime.
          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);

          // we stop the simulation of Window Resize after the animations are completed
          setTimeout(function() {
            clearInterval(simulateWindowResize);
          }, 1000);

        });
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();

    });
  </script>
</body>

</html>
