
<?php

   use PHPMailer\PHPMailer\PHPMailer;
   use PHPMailer\PHPMailer\Exception;
   include("../functions/connection.php");
   include("../functions/functions.php");
   session_start();

   if(isset($_GET['code']) AND isset($_GET['user'])){
     //$conn = $pdo->open();
    
     /*$stmt = $conn->prepare();
     $stmt->execute(['code'=>, 'id'=>$_GET['user']]);
     $row = $stmt->fetch();*/

       $code1=$_GET['code'];
       $user1=$_GET['user'];
     $sql= "SELECT *, COUNT(*) AS numrows FROM employee WHERE activate_code='$code1' AND eid='$user1'";

     $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result);


     if($row['numrows'] > 0){
       if($row['status']=='1'){
          echo "<script>";
          echo "alert('Account already activated')";
          echo "</script>";
       }
       else{
         try{
          // $stmt = $conn->prepare("UPDATE employee SET status=:status WHERE id=:id");
          // $stmt->execute(['status'=>1, 'id'=>$row['id']]);

           $sql= "UPDATE employee SET status='1' WHERE eid='$user1'";
           if( !mysqli_query($conn,$sql) )
           {

           echo("Error description: " . mysqli_error($conn));
             // unsuccessful("Error: " . $query . "<br>" . $con->error);
           }
      else{

            echo "<script>";
            echo "alert(' Account activated,You can now login to continue')";
            echo "</script>";
          }
         }
         catch(PDOException $e){
            echo "<script>";
            echo "alert($e->getmessage())";
            echo "</script>";
         }

       }

     }
     else{
        echo "<script>";
        echo "alert(' Cannot Activate Account.')";
        echo "</script>";
     }

     //$pdo->close();
   }


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

      $set='123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $code=substr(str_shuffle($set), 0, 12);
   		$query = "insert into employee values ('$eid','$ename','$email','$department','$doj','$team','$contact','$pass','$path_filename_ext','Employee','$code','0')";

   		if( !mysqli_query($conn,$query) )
   		{

     echo("Error description: " . mysqli_error($conn));
        // unsuccessful("Error: " . $query . "<br>" . $con->error);
   		}
   		else
   		{



				try{
				//	$stmt = $conn->prepare("INSERT INTO users (email, password, firstname, lastname, activate_code, created_on) VALUES (:email, :password, :firstname, :lastname, :code, :now)");
					//$stmt->execute(['email'=>$email, 'password'=>$password, 'firstname'=>$firstname, 'lastname'=>$lastname, 'code'=>$code, 'now'=>$now]);
					//$userid = $conn->lastInsertId();

					$message = "
						<h2>Thank you for Registering.</h2>
						<p>Your Account:</p>
						<p>Email: ".$email."</p>
						<p>Password: ".$pass."</p>
						<p>Please click the link below to activate your account.</p>
						<a href='http://localhost/Workflow/admin/register.php?code=".$code."&user=".$eid."'>Activate Account</a>
					";

					//Load phpmailer
		    		require '../vendor/autoload.php';

		    		$mail = new PHPMailer(true);
				    try {
				        //Server settings
				        $mail->isSMTP();
				        $mail->Host = 'smtp.gmail.com';
				        $mail->SMTPAuth = true;
                $mail->Username = 'harneet.singh.mnnit2017@gmail.com';
 				        $mail->Password = 'mohanamanarora';
				        $mail->SMTPOptions = array(
				            'ssl' => array(
				            'verify_peer' => false,
				            'verify_peer_name' => false,
				            'allow_self_signed' => true
				            )
				        );
				        $mail->SMTPSecure = 'ssl';
				        $mail->Port = 465;

				        $mail->setFrom('Liza@gmail.com');

				        //Recipients
				        $mail->addAddress($email);


				        //Content
				        $mail->isHTML(true);
				        $mail->Subject = ' Leave Application portal Sign Up';
				        $mail->Body    = $message;

				        $mail->send();

				        //$_SESSION['success'] = 'Account created. Check your email to activate.';
				        //header('location: register.php');

                echo "<script>";
                echo "alert('Account created. Check your email to activate')";
                echo "</script>";

				    }
				    catch (Exception $e) {
              echo "catch1";
				        $_SESSION['error'] = 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
				        //header('location: register.php');
                echo "Message could not be sent. Mailer Error: ".$mail->ErrorInfo;
				    }


				}
				catch(PDOException $e){
            echo "catch2";
					$_SESSION['error'] = $e->getMessage();
					//header('location: register.php');
				}



               move_uploaded_file($temp_name,$path_filename_ext);
              // echo "Congratulations! File Uploaded Successfully.";
               $query1="insert into leave_info values (7,7,15,'$eid')";
               if( !mysqli_query($conn,$query1) )
               {

               echo("Error description: " . mysqli_error($conn));
                 // unsuccessful("Error: " . $query . "<br>" . $con->error);
               }
   		}


    /*  else
      {
        echo "<script>";
        echo "alert('leaves assigned successfully.')";
        echo "</script>";

      }*/

   	}
   	else
   	{
   		echo "<script>";
   		echo "alert('$flag')";
   		echo "</script>";
   	}


    	//$output = '';
    /*	if(!isset($_GET['code']) OR !isset($_GET['user'])){
        echo "<script>";
        echo "alert(' Code to activate account not found')";
        echo "</script>";
    	}*/




   }

   else if( isset($_POST['login']) && $_POST['login'] )
    {
   echo"<script>console.log('hello');</script>";
   $des=$_POST['role'];
     $id = $_POST['login_id'];
     $passwd = $_POST['pwd'];
         $flag1 = check1($des,$id,$passwd);
         if($flag1=="done")
         {
           echo"<script>console.log('hello');</script>";

            $_SESSION["loggedin"] = $id;
          $eid= $_SESSION['loggedin'];
           if($_SESSION['loggedin'])
           {

             $sql= "SELECT designation from employee where eid= '$eid'";

             $result = mysqli_query($conn,$sql);
             while($row = mysqli_fetch_assoc($result))
             {
              $var= $row['designation'];
             }
         if($var=='Employee')
           header("location:../employee/employee.php");
           else if($var=='HOD')
              header("location:../HOD/approve.html");
              else if($var=='HR')
                 header("location:../HR/finally.php");
           echo"<script>console.log('hello1');</script>";
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
     $eid= $_SESSION['loggedin'];
     $sql= "SELECT designation from employee where eid= '$eid'";

     $result = mysqli_query($conn,$sql);
     while($row = mysqli_fetch_assoc($result))
     {
      $var= $row['designation'];
     }
 if($var=='Employee')
   header("location:../employee/employee.php");
   else if($var=='HOD')
      header("location:../HOD/approve.html");
      else if($var=='HR')
         header("location:../HR/finally.php");
   echo"<script>console.log('hello1');</script>";
   exit;
   }

    ?>

<form id="Form2" method="post" enctype="multipart/form-data">
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->

    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="keywords" content="Bootstrap, Landing page, Template, Business, Service">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <title>Hello, world!</title>
      </head>
      <body>


        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->





    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="images/2.png" type="image/png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/LineIcons.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/owl.theme.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/nivo-lightbox.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/responsive.css">







  </head>

  <body>
<form id="Form2" method="post" enctype="multipart/form-data">

    <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered" role="document">
           <div class="modal-content">

                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel" style="text-align:center"  >Register</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
               <div class="modal-body">




                           <div class="form-group">
                               <label class="col-form-label">Full name</label>

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

             <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel"  >Login</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>
             </div>
             <div class="modal-body">
                 <div class="login px-4 mx-auto mw-100">
                    <!-- <h5 class="text-center mb-4">Login Now</h5>-->

                      <div class="form-group">
                             <label class="col-form-label"><h6>Select Role</h6></label>
                               <select name="role" >
                                 <option value="Employee">Employee</option>
                                 <option value="HOD">HOD</option>
                                 <option value="HR">HR</option>
                               </select>


                         <div class="form-group">
                             <label class="col-form-label" ><h6>Login ID</h6></label>
                             <input type="text" class="form-control" id="exampleInputEmail1" name='login_id'>

                             <small id="emailHelp"> We will never share your information with anyone else. </small>
                         </div>
                         <div class="form-group">
                             <label class="col-form-label"><h6>Password</h6></label>
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
</div>




<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">New message</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <form>
      <div class="form-group">
        <label for="recipient-name" class="col-form-label">Recipient:</label>
        <input type="text" class="form-control" id="recipient-name">
      </div>
      <div class="form-group">
        <label for="message-text" class="col-form-label">Message:</label>
        <textarea class="form-control" id="message-text"></textarea>
      </div>
    </form>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary">Send message</button>
  </div>
</div>
</div>
</div>

    <!-- Header Section Start -->
    <header id="home" class="hero-area">
      <div class="overlay">

      </div>

      <div class="container">
        <div class="row space-100">
          <div class="col-lg-6 col-md-12 col-xs-12">
            <div class="contents">
          <large>    <h2 class="head-title" style="font-size:50px">Workflow </h2></large>
              <h2 class="head-title">Leave Application Portal </h2>
              <p>Get all the information about your pending leaves<br>Apply for new leaves and get Status Updates</p>
              <div class="header-button">
                <a data-toggle="modal" data-target="#exampleModalCenter2" class="btn btn-border-filled">Register</a>
                <a data-target="#exampleModalCenter" data-toggle="modal" class="btn btn-border-filled">Login</a>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-12 col-xs-12 p-0">
            <div class="intro-img">
              <img src="images/img1.jpg"  height="2000px" alt="">
            </div>
          </div>
        </div>
      </div>
    </header>
    <!-- Header Section End -->
</form>
    </body>
    </html>
