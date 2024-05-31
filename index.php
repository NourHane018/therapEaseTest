<?php
 include 'cors.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel='stylesheet' href="main.css">
</head>
<body>
<div class="login-container">
 <form action="login.php" method="POST">


 <div class="login-box" id="login-box">   
  
       <div class="header" id="Login">
         <h3>LOGIN</h3>
       </div>
  
       <div class="content">
       <?php
      
       if(isset($user_error)){
    echo $user_error;
 }
  ?>
         <div class="input-box">
   
           <input type="text" name="username" id="username" placeholder="" value="<?php if(isset($_COOKIE['username'])) echo $_COOKIE['username'] ; ?>">
           <span>username</span>
           <span></span>
       </div>
   <?php if(isset($pass_error)){
      echo $pass_error;
   }
   ?>
   <div class="input-box">
         <input type="password" name="password" id="password" placeholder='' value="<?php if(isset($_COOKIE['password'])) echo $_COOKIE['password'] ; ?>">
         <span>password</span>
         <span></span>
        </div>
      <label> <input type="checkbox" name="keep" id="keep" value="1" class="Keep">Keep me signed in</label>
      <div class="input-box">       
      <input type="submit" name="login_submit" id="submit" value="SING IN" class="btn">

   </form>
   <div>
         <a href="forgatpassword.php" class="forg__pas">Forgot your password?</a>
        </div>
        <div class="register-box " id ="register-box">
        <div class="header-register" id ="header-register">
            <h3 onclick="window.location.href='register.php';">REGISTER</h3>
          </div>
          </div>
 </div>
</div>
<script>
    <?php if(isset($user_error) || isset($pass_error)) { ?>
        
        document.getElementById('register-box').style.bottom = '26rem';
    <?php } ?>
</script>
</body>
</html>