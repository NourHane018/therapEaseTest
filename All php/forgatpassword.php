<?php 
include('inc/connections.php');
if(isset($_POST['resetpassword'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $check_email = "SELECT * FROM `users` WHERE email='$email'";
    $check_result = mysqli_query($conn, $check_email);
    $num_rows = mysqli_num_rows($check_result);
    if($num_rows == 0){
        $email_error = '<p id="error">Sorry, the email you entered does not exist. Please try again.</p>';
        
    }else{
        require_once('mail.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>resetpassword</title>
 <link rel="stylesheet" href="main.css">
</head>
<body>
    <!-- STYLE D -->
   <style>
       .btn2{
 width: 15rem;
 margin-bottom: 3rem;
margin-left:2.3rem;
     }
     .login-box {
    width:400px;
    height:300px;
  }
  @media (max-width:376px) {
  .login-box {
   
    width: 300px;
    height:300px;
    box-shadow: 2px 4px 4px #dcdcdc, -2px 4px 4px #dcdcdc;
  }
 .login-box h1{
font-size:1.5rem;
 }
 .btn2{
 
margin-left:0rem;
     }
 }
    
/* STYLE F */
   </style>
<div class="login-container">
    <form method="POST">

    <div class="section">
    <?php if(isset($email_error)){
    echo $email_error;
  }  ?>
 <div class="login-box">   
   <div class="header">
       <h1>Resetpassword</h1>
   </div>
   <div class="content">
         <div class="input-box">
           <input type="email" name="email" required placeholder="" >
           <span>Email</span>
           <span></span>
        </div>
    </div>   
  <button type="submit" name="resetpassword" class="input-box btn2 ">send me message</button>
    </form>
</div>
</body>
</html>
