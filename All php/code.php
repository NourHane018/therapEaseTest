<?php 
include('inc/connections.php');
if(isset($_POST['verify_email'])) {
    $email = $_POST['email'];
    $verification_code = $_POST['verification_code'];
    
    $check_email = "SELECT * FROM users WHERE verification_code = '$verification_code'";
    $result = mysqli_query($conn, $check_email);
    
    if (mysqli_num_rows($result) > 0) {
        header('location:register.php');
        exit(); 
    } else {
        echo "An error occurred while verifying the authenticated email " . mysqli_error($conn) ;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
   <style>
          .btn2{
 width: 15rem;
 margin-bottom: 3rem;
margin-left:1.5rem;
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
   </style> 
<div class="login-container">

 <form method="POST">
  <div class="login-box">   
     <div class="header">
       <h3>Email verification</h3>
     </div>
    <input type="hidden" name="email" >
    <div class="content">
        <div class="input-box">
           <input type="text" name="verification_code" placeholder="" required />
           <span>Enter verification code</span>
           <span></span>
       </div>
       <input type="submit" name="verify_email" value="Verify Email" class="btn2"> 
 
    </div>
  </form>
</div>
</body>
</html>