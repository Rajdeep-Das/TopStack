<?php
session_start();
require_once 'class.user.php';

$reg_user = new USER();

if($reg_user->is_logged_in()!="")
{
 $reg_user->redirect('dashboard.php');
}


if(isset($_POST['btn-signup']))
{
  $type=trim($_POST['account']);
  $gender=trim($_POST['gender']);
  $phone=trim($_POST['phone']);
 /**************************/   
 $uname = ($_POST['name']);
 $email = trim($_POST['email']);
 $upass = trim($_POST['password']);
 $code = md5(uniqid(rand()));
 
 $stmt = $reg_user->runQuery("SELECT * FROM tbl_users WHERE userEmail=:email_id");
 $stmt->execute(array(":email_id"=>$email));
 $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
 if($stmt->rowCount() > 0)
 {/*
  $msg = "
        <div class='alert alert-error'>
    <button class='close' data-dismiss='alert'>&times;</button>
     <strong>Sorry !</strong>  email allready exists , Please Try another one
     </div>
     ";*/
     $msg="<div class='alert'>
  <span class='closebtn'>&times;</span>  
  <strong>Sorry !</strong>  email allready exists , Please Try another one.
 </div>";
 }
 else
 {
  if($reg_user->register($uname, $email,$phone,$gender,$type, $upass, $code))
  {   
   $id = $reg_user->lasdID();  
   $key = base64_encode($id);
   $id = $key;
   
   $message = "     
      Hello $uname,
      <br /><br />
      <h2>Welcome to TopStack India!</h2><br/>
      To complete your registration  please , just click following link<br/>
      <br /><br />
      <a href='http://www.topstackindia.com/verify.php?id=$id&code=$code'>Click HERE to Activate </a>
      <br /><br />
      Thanks,";
      
   $subject = "Confirm Registration";
      
   $reg_user->send_mail($email,$message,$subject); 
  /* $msg = "
     <div class='alert alert-success'>
      <button class='close' data-dismiss='alert'>&times;</button>
      <strong>Success!</strong>  We've sent an email to $email.
                    Please click on the confirmation link in the email to create your account. 
       </div>
     ";*/

     $msg=" <div class='alert success'>
             <span class='closebtn'>&times;</span>  
            <strong>Success!</strong>  We've sent an email to $email.
                    Please click on the confirmation link in the email to create your account.
            <font color=#fffff> <a href=login.php>Go Back To Login Page</a></font>
             </div>";
  }
  else
  {
   echo "sorry , Query could no execute...";
  }  
 }
}
?>
<!--
<!DOCTYPE html>
<html>
  <head>
    <title>Signup | Coding Cage</title>
    <!-- Bootstrap -->
    <!--
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="assets/styles.css" rel="stylesheet" media="screen">
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!--
    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
  </head>
  <body id="login">
    <div class="container">
    <?php if(isset($msg)) echo $msg;  ?>
      <form class="form-signin" method="post">
        <h2 class="form-signin-heading">Sign Up</h2><hr />
        <input type="text" class="input-block-level" placeholder="Username" name="txtuname" required />
        <input type="email" class="input-block-level" placeholder="Email address" name="txtemail" required />
        <input type="password" class="input-block-level" placeholder="Password" name="txtpass" required />
      <hr />
        <button class="btn btn-large btn-primary" type="submit" name="btn-signup">Sign Up</button>
        <a href="index.php" style="float:right;" class="btn btn-large">Sign In</a>
      </form>

    </div> <!-- /container -->
    <!--
    <script src="vendors/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>-->
<!DOCTYPE html>
<html>
<head>
  <title>TopStack-SignUp</title>
  
 
 <style type="text/css">
    body, div, dl, dt, dd, ul, ol, li, h1, h2, h3, h4, h5, h6, 
    pre, form, fieldset, input, textarea, p, blockquote, th, td { 
      padding:0;
      margin:0;}

      fieldset, img {border:0}

      ol, ul, li {list-style:none}

      :focus {outline:none}

      body,
      input,
      textarea,
      select {
        font-family: 'Open Sans', sans-serif;
        font-size: 16px;
        color: #4c4c4c;
      }

      p {
        font-size: 12px;
        width: 150px;
        display: inline-block;
        margin-left: 18px;
      }
      h1 {
        font-size: 32px;
        font-weight: 300;
        color: #4c4c4c;
        text-align: center;
        padding-top: 10px;
        margin-bottom: 10px;
      }

      html{
        background-color: #ffffff;
      }

      .testbox {
        margin: 20px auto;
        width: 343px;  
        height: 564px; 
        -webkit-border-radius: 8px/7px; 
        -moz-border-radius: 8px/7px; 
        border-radius: 8px/7px; 
        background-color: #ebebeb; 
        -webkit-box-shadow: 1px 2px 5px rgba(0,0,0,.31); 
        -moz-box-shadow: 1px 2px 5px rgba(0,0,0,.31); 
        box-shadow: 1px 2px 5px rgba(0,0,0,.31); 
        border: solid 1px #cbc9c9;
      }

      input[type=radio] {
        visibility: hidden;
      }

      form{
        margin: 0 30px;
      }

      label.radio {
        cursor: pointer;
        text-indent: 35px;
        overflow: visible;
        display: inline-block;
        position: relative;
        margin-bottom: 15px;
      }

      label.radio:before {
        background: #3a57af;
        content:'';
        position: absolute;
        top:2px;
        left: 0;
        width: 20px;
        height: 20px;
        border-radius: 100%;
      }

      label.radio:after {
        opacity: 0;
        content: '';
        position: absolute;
        width: 0.5em;
        height: 0.25em;
        background: transparent;
        top: 7.5px;
        left: 4.5px;
        border: 3px solid #ffffff;
        border-top: none;
        border-right: none;

        -webkit-transform: rotate(-45deg);
        -moz-transform: rotate(-45deg);
        -o-transform: rotate(-45deg);
        -ms-transform: rotate(-45deg);
        transform: rotate(-45deg);
      }

      input[type=radio]:checked + label:after {
        opacity: 1;
      }

      hr{
        color: #a9a9a9;
        opacity: 0.3;
      }

      input[type=text],input[type=password],input[type=email]{
        width: 200px; 
        height: 39px; 
        -webkit-border-radius: 0px 4px 4px 0px/5px 5px 4px 4px; 
        -moz-border-radius: 0px 4px 4px 0px/0px 0px 4px 4px; 
        border-radius: 0px 4px 4px 0px/5px 5px 4px 4px; 
        background-color: #fff; 
        -webkit-box-shadow: 1px 2px 5px rgba(0,0,0,.09); 
        -moz-box-shadow: 1px 2px 5px rgba(0,0,0,.09); 
        box-shadow: 1px 2px 5px rgba(0,0,0,.09); 
        border: solid 1px #cbc9c9;
        margin-left: -5px;
        margin-top: 13px; 
        padding-left: 10px;
      }

      input[type=password].repass{
        margin-bottom: 25px;
      }

      #icon {
        display: inline-block;
        width: 30px;
        background-color: #3a57af;
        padding: 8px 0px 8px 15px;
        margin-left: 15px;
        -webkit-border-radius: 4px 0px 0px 4px; 
        -moz-border-radius: 4px 0px 0px 4px; 
        border-radius: 4px 0px 0px 4px;
        color: white;
        -webkit-box-shadow: 1px 2px 5px rgba(0,0,0,.09);
        -moz-box-shadow: 1px 2px 5px rgba(0,0,0,.09); 
        box-shadow: 1px 2px 5px rgba(0,0,0,.09); 
        border: solid 0px #cbc9c9;
      }

      .gender {
        margin-left: 30px;
        margin-bottom: 10px;
      }

      .accounttype{
        margin-left: 8px;
        margin-top: 20px;
      }

      a.button {
        font-size: 14px;
        font-weight: 600;
        color: white;
        padding: 6px 25px 0px 20px;
        margin: 10px 8px 20px 0px;
        display: inline-block;
        float: right;
        text-decoration: none;
        width: 50px; height: 27px; 
        -webkit-border-radius: 5px; 
        -moz-border-radius: 5px; 
        border-radius: 5px; 
        background-color: #3a57af; 
        -webkit-box-shadow: 0 3px rgba(58,87,175,.75); 
        -moz-box-shadow: 0 3px rgba(58,87,175,.75); 
        box-shadow: 0 3px rgba(58,87,175,.75);
        transition: all 0.1s linear 0s; 
        top: 0px;
        position: relative;
      }

      a.button:hover {
        top: 3px;
        background-color:#2e458b;
        -webkit-box-shadow: none; 
        -moz-box-shadow: none; 
        box-shadow: none;

      }

       input[type=submit].button{
       font-size: 14px;
        font-weight: 600;
        color: white;
        padding: 6px 25px 0px 20px;
        margin: 10px 8px 20px 0px;
        display: inline-block;
        float: right;
        text-decoration: none;
        width: 90px; height: 35px; 
        -webkit-border-radius: 5px; 
        -moz-border-radius: 5px; 
        border-radius: 5px; 
        background-color: #3a57af; 
        -webkit-box-shadow: 0 3px rgba(58,87,175,.75); 
        -moz-box-shadow: 0 3px rgba(58,87,175,.75); 
        box-shadow: 0 3px rgba(58,87,175,.75);
        transition: all 0.1s linear 0s; 
        top: 0px;
        position: relative;
      }
      input[type=submit].button:hover {
        top: 3px;
        background-color:#2e458b;
        -webkit-box-shadow: none; 
        -moz-box-shadow: none; 
        box-shadow: none;

      }
</style>
<style>
       .alert {
    padding: 20px;
    background-color: #f44336;
    color: white;
    opacity: 1;
    transition: opacity 0.6s;
    margin-bottom: 15px;
    }

     .alert.success {background-color: #4CAF50;}
       .alert.info {background-color: #2196F3;}
       .alert.warning {background-color: #ff9800;}

       .closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
       }

      .closebtn:hover {
    color: black;
     }
</style>
  </head>
  <body>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600" rel="stylesheet" type="text/css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
    <!-- Latest compiled and minified CSS -->

    <?php if(isset($msg)) echo $msg;  ?>
    <div class="testbox">
      <h1>Registration</h1>

      <form role="form" id="register-form" autocomplete="off" method="post">
        <hr>
        
        <div class="accounttype">
          <input type="radio" value="Student" id="radioOne" name="account" checked/>
          <label for="radioOne" class="radio" chec>Student</label>
          <input type="radio" value="Personal" id="radioTwo" name="account" />
          <label for="radioTwo" class="radio">Personal</label>
        </div>
        
        <hr>
        <label id="icon" for="email"><i class="icon-envelope "></i></label>
        <input type="email" name="email" id="email" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="xyz@something.com" required/>
        <label id="icon" for="name"><i class="icon-user"></i></label>
        <input type="text" name="name" id="name" placeholder="Name"  required />
        <label id="icon" for="text"><i class="icon-phone"></i></label>
        <input type="text" name="phone" pattern="^\d{10}$"  placeholder="Mobile Number" title="10 numeric characters only" required />
        <label id="icon" for="password"><i class="icon-shield"></i></label>
        <input type="password" name="password" id="password" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required/>
        <label id="icon" for="password"><i class="icon-shield"></i></label>
        <input type="password" class="repass" name="confirm_password" id="confirm_password" placeholder="Confirm Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required/>
        
        <div class="gender">
          <input type="radio" value="Male" id="male" name="gender" checked/>
          <label for="male" class="radio" chec>Male</label>
          <input type="radio" value="Female" id="female" name="gender" />
          <label for="female" class="radio">Female</label>
        </div> 
        <p>By clicking Register, you agree on our <a href="#">terms and condition</a>.</p>
        <!-- <a href="#" class="button">Register</a>-->
        <input type="submit" class="button" value="Register" name="btn-signup"/>
      </form>
    </div>
    <script>
var close = document.getElementsByClassName("closebtn");
var i;

for (i = 0; i < close.length; i++) {
    close[i].onclick = function(){
        var div = this.parentElement;
        div.style.opacity = "0";
        setTimeout(function(){ div.style.display = "none"; }, 600);
    }
}
</script>
  
  </body>
  </html>
  <!-- http://www.codingcage.com/2015/03/html5-form-validations-with-pattern.html -->