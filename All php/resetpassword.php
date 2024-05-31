<?php 
include 'cors.php';
include('inc/connections.php');

if(isset($_POST['newpassword'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Check if reset_token is set before accessing it
    if(isset($_POST['reset_token']) && !empty($_POST['reset_token'])) {
        $reset_token = $_POST['reset_token'];
        $md5_pass = md5($password);
        $check_email_query = "SELECT * FROM `users` WHERE `email` = '$email' AND `reset_token` = '$reset_token'";
    
        $check_email_result = mysqli_query($conn, $check_email_query);
    
        if(mysqli_num_rows($check_email_result)) {
           
            $update_password_query = "UPDATE `users` SET `password` = '$password', `md5_pass` = '$md5_pass' WHERE `email` = '$email' AND `reset_token` = '$reset_token'";
            $result = mysqli_query($conn, $update_password_query);
    
            if ($result) {
                echo "Password updated successfully.";
            } else {
                echo  "An error occurred while updating the password: " . mysqli_error($conn);
            }
        } else {
            echo "The email is not found in the database.";
        }
    } else {
        echo "It is not your email, try again.";
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESET PASSWORD</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
<style>
        .btn2{
 width: 15rem;
 margin-bottom: 3rem;
     }
     .login-box {
    width:400px;
    height:450px;
  }
  @media (max-width:376px) {
  .login-box {
    padding: 8px 20px;
    background: #fff;
    border-radius: 10px;
    width: 300px;
    height:400px;
    box-shadow: 2px 4px 4px #dcdcdc, -2px 4px 4px #dcdcdc;
  }
 .login-box h1{
font-size:1.5rem;
 }
  
 }
    </style>
    <div class="login-container">
<div class="login-box">   
     <div class="header">
     <h1>Reset password</h1>
     </div>
    <form  method="POST">
    <div class="content">
         <div class="input-box">
        <input type="email" name="email" placeholder="" ><span>Email</span>
           <span></span>
       </div>
       <div class="input-box">
         <input type="password" name="password" id="password" placeholder='' value="<?php if(isset($_COOKIE['password'])) echo $_COOKIE['password'] ; ?>">
         <span>password</span>
         <span></span>
        </div>
        <div class="input-box">
        <input type="text" name="reset_token" placeholder="" ><span>Reset token</span>
           <span></span>
       </div>
   
  
       <input type="submit" name="newpassword" id="submit"  value="Reset" class="btn2"> 
       </div>
 </div>
    </form>
   
</body>
</html>