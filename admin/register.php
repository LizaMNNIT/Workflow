
<?php
   include("../functions/connection.php");
   include("../functions/functions.php");
   session_start();


   if(isset($_POST['register']) && $_POST['register'])
   {
    //echo "<script>window.open('admin/admin.php','_self')</script>";
   $eid = $_POST['emp_id'];
   $ename = $_POST['emp_name'];
   $email = $_POST['emp_email'];
   $department = $_POST['dept'];
   $doj = $_POST['date'];
   $team= $_POST['emp_team'];
   $contact = $_POST['phone'];
   $pass = $_POST['password'];



   echo"<script>console.log('register is set');</script>";

   if (($_FILES['Sign']['name']!="")){
   // Where the file is going to be stored
    $target_dir = "../files/";
    $file = $_FILES['Sign']['name'];
    $path = pathinfo($file);
    $filename = $path['filename'];
    $ext = $path['extension'];
    $temp_name = $_FILES['Sign']['tmp_name'];
    $path_filename_ext = $target_dir.$filename.".".$ext;
  }
  else {
  echo"<script>console.log('error in signature file');</script>";
  }

  //echo"<script>console.log('eid=".$eid." ename=".$ename." email=".$email." department=".$department." doj=".$doj." team=".$team." contact=".$contact." pwd=".$pass." sign=".$path_filename_ext." ');</script>";
   $flag = check($eid,$email,$contact,$path_filename_ext);


   //$flag = "done";

   	if( $flag == "done" )
   	{
   		$query = "insert into employee values ('$eid','$ename','$email','$department','$doj','$team','$contact','$pass','$path_filename_ext')";

   		if( !mysqli_query($conn,$query) )
   		{

     echo("Error description: " . mysqli_error($conn));
        // unsuccessful("Error: " . $query . "<br>" . $con->error);
   		}
   		else
   		{
   			echo "<script>";
   			echo "alert('Regitered successfully.')";
   			echo "</script>";

               move_uploaded_file($temp_name,$path_filename_ext);
               echo "Congratulations! File Uploaded Successfully.";
   		}

      $query1="insert into leave_info values (7,7,15,'$eid')";
      if( !mysqli_query($conn,$query1) )
      {

      echo("Error description: " . mysqli_error($conn));
        // unsuccessful("Error: " . $query . "<br>" . $con->error);
      }
      else
      {
        echo "<script>";
        echo "alert('leaves assigned successfully.')";
        echo "</script>";

      }

   	}
   	else
   	{
   		echo "<script>";
   		echo "alert('$flag')";
   		echo "</script>";
   	}
   }

   else if( isset($_POST['login']) && $_POST['login'] )
    {
   echo"<script>console.log('hello');</script>";
     $id = $_POST['login_id'];
     $passwd = $_POST['pwd'];
         $flag1 = check1($id,$passwd);
         if($flag1=="done")
         {
           echo"<script>console.log('hello');</script>";

            $_SESSION["loggedin"] = $id;

           if($_SESSION['loggedin'])
           {
           echo"<script>console.log('hello1');</script>";
           header("location:../examples/employee.php");
           exit;
         }
         }
         else
         {
           echo "<script>";
           echo "alert('$flag1')";
           echo "</script>";
         }
   }

   if(isset($_SESSION['loggedin']))
   {
     header("location: ../examples/employee.php");
     exit;
   }

    ?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Workflow</title>
    <link rel="shortcut icon" type="image/png" href="images/logo.png"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />

    <script>
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="css/owl.carousel.css" type="text/css" media="all" />
    <link rel="stylesheet" href="css/owl.theme.css" type="text/css" media="all" />
    <link href="css/nav.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link href="//fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800" rel="stylesheet" />
     <script>
        function init() {
            var element = $('#exampleModalCenter2').detach();
            $($("form")[0]).append(element);
        }

        window.addEventListener('DOMContentLoaded', init, false);
    </script>
     <script>
        function init() {
            var element = $('#exampleModalCenter').detach();
            $($("form")[0]).append(element);
        }

        window.addEventListener('DOMContentLoaded', init, false);
    </script>

</head>
<body>
<form id="Form2" method="post" enctype="multipart/form-data">
    <div class="inner-page" id="home">
        <!--/nav-->
        <div class="top_nav">
            <h1>

            </h1>
            <div class="top-btns">
                <div class="sign-btn">
                    <a href="#" style="color:white" data-toggle="modal" class="btn btn-sm animated-button victoria-two" data-target="#exampleModalCenter">
                        <i class="fas fa-lock"></i> Sign In</a>
                    <a href="#" style="color:white" data-toggle="modal" class="btn btn-sm animated-button victoria-two" data-target="#exampleModalCenter2">
                        <i class="far fa-user"></i> Register</a>
                </div>
            </div>
            <div class="container-btn" id="btn">
                <div class="text">Menu</div>
                <div id="bars">
                    <div class="bar first"></div>
                    <div class="bar second"></div>
                    <div class="bar third"></div>
                </div>
            </div>


            <!-- top-overlay -->
            <div class="top-overlay fade-out" id="menu">
                <nav class="top-overlay-content" id="nav">
                    <span class="top-overlay-close" id="close-btn"> &times; </span>
                    <div class="container" id="container">
                        <div class="first-nav text-center">
                            <ul class="first-nav text-center">

                            <li><a href="Index.aspx" class="active">Home</a></li>
                            <li><a href="Gallery.aspx">Gallery</a></li>

                             <li><a href="">Team</a></li>
                            <li><a href="">Contact</a></li>
                        </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <!--//nav-->
        </div>

    </div>


     <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="login px-4 mx-auto mw-100">
                        <h5 class="text-center mb-4">Register Now</h5>


                            <div class="form-group">
                                <label>Full name</label>

                                <input type="text" name="emp_name" class="form-control" AutoComplete="off">

                            </div>
                            <div class="form-group">
                                <label>User_Id</label>
                                <input type="text" name="emp_id" class="form-control"  AutoComplete="off">


                            </div>

                            <div class="form-group">
                                <label>Email Id</label>
                               <input type="text" name="emp_email" class="form-control"  AutoComplete="off">

                            </div>

                             <div class="form-group">
                                <label>Password</label>
                               <input type="password" name="password" class="form-control" AutoComplete="off">

                            </div>

                            <div class="form-group">
                               <label> Confirm Password</label>
                              <input type="password" ID="c_password" class="form-control" AutoComplete="off">

                           </div>

                           <div class="form-group">
                              <label>Department</label>
                             <input type="text" name="dept" class="form-control" AutoComplete="off">

                          </div>

                          <div class="form-group">
                             <label>Team</label>
                            <input type="text" name="emp_team" class="form-control" AutoComplete="off">

                         </div>

                          <div class="form-group">
                             <label>Date of joining</label>
                            <input type="date" name="date" class="form-control" AutoComplete="off">

                         </div>

                         <div class="form-group">
                            <label>Contact</label>
                           <input type="text" name="phone" class="form-control" AutoComplete="off">

                        </div>


                       <div class="form-group">
                          <label>Signature</label>
                         <input type="file"  name="Sign" class="form-control" AutoComplete="off">

                      </div>

                            <div class="form-group">
                 <input type="submit"  name="register"  value="Register" class="btn btn-primary submit mb-4" >

                        </div>

                    </div>


                </div>

            </div>
        </div>
    </div>

    <!--/Login-->
 <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
              <div class="modal-header text-center">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="login px-4 mx-auto mw-100">
                      <h5 class="text-center mb-4">Login Now</h5>

                       <div class="form-group">
                              <label class="mb-2">Select Role</label>
                                <select name="role" >
                                  <option value="Employee">Employee</option>
                                  <option value="HOD">HOD</option>
                                  <option value="HR">HR</option>
                                </select>


                          <div class="form-group">
                              <label class="mb-2" >Login ID</label>
                              <input type="text" class="form-control" id="exampleInputEmail1" name='login_id'>

                              <small id="emailHelp" class="form-text text-muted">We'll never share your registration number with anyone else.</small>
                          </div>
                          <div class="form-group">
                              <label class="mb-2">Password</label>
                              <input type="password" class="form-control" id="exampleInputPassword1" name='pwd'>

                          </div>
                          <div class="form-group">
                       <input type="submit"  name="login"  value="SignIn" class="btn btn-primary submit mb-4" >
                          </div>


                  </div>

              </div>

          </div>
      </div>
  </div>

  <!--//Login-->


    <!-- js -->
    <script src="js/jquery-2.2.3.min.js"></script>
    <!-- menu -->
    <script src="js/index.js"></script>
    <script src="js/modernizr.custom.js"></script>
    <!-- //menu -->
    <!--slider-->
    <script src="js/jquery.sliderPro.min.js"></script>




    <script>
        $(document).ready(function ($) {
            $('#example1').sliderPro({
                width: 1980,
                height: 800,
                arrows: true,
                buttons: false,
                waitForLayers: true,
                thumbnailWidth: 270,
                thumbnailHeight: 100,
                thumbnailPointer: true,
                autoplay: false,
                autoScaleLayers: false,
                breakpoints: {
                    500: {
                        thumbnailWidth: 120,
                        thumbnailHeight: 50
                    }
                }
            });
        });
    </script>
    <!--//slider-->
    <!-- stats -->
<script src="js/jquery.waypoints.min.js"></script>
<script src="js/jquery.countup.js"></script>
<script>
$('.counter').countUp();
</script>
    <!-- //stats -->

    <!-- carousel -->
    <script src="js/owl.carousel.js"></script>
    <script>
        $(document).ready(function () {
            $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                        nav: true
                    },
                    600: {
                        items: 2,
                        nav: false
                    },
                    900: {
                        items: 3,
                        nav: false
                    },
                    1000: {
                        items: 4,
                        nav: true,
                        loop: false,
                        margin: 20
                    }
                }
            })
        })
    </script>
    <!-- //carousel -->
    <!-- //js -->
    <script src="js/bootstrap.js"></script>
    <!--/ start-smoth-scrolling -->
    <script src="js/move-top.js"></script>
    <script src="js/easing.js"></script>
    <script>
        jQuery(document).ready(function ($) {
            $(".scroll").click(function (event) {
                event.preventDefault();
                $('html,body').animate({
                    scrollTop: $(this.hash).offset().top
                }, 900);
            });
        });
    </script>
    <script>
        $(document).ready(function () {

            $().UItoTop({
                easingType: 'easeOutQuart'
            });

        });
    </script>
    <!--// end-smoth-scrolling -->
    </form>
</body>
</html>
