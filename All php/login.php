<?php
 include 'cors.php';

session_start();
include_once('inc/connections.php');

$adminUsername = "admin";
$adminPassword = "admin";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = stripcslashes(htmlspecialchars(strtolower($_POST['username'])));
    $password = stripcslashes(htmlspecialchars($_POST['password']));
    
    // Check if user is admin
    if ($username === $adminUsername && $password === $adminPassword) {
        // Admin login successful, redirect to admin.php
        $_SESSION["user"] = "admin";
        header("Location: ..\admin_panel\admin.php");
        exit;
    } else {
        // Normal user login
        
        if(isset($_POST['keep'])){
            $keep = stripcslashes(htmlspecialchars($_POST['keep']));
            if($keep ==1){
                setcookie('username',$username,time()+3600,'/');
                setcookie('password',$password,time()+3600,'/');
            }
        }
        
        if(empty($username)){
            $user_error = '<p id="error">Please insert username</p>';
            $err_s = 1;
        }
        if(empty($password)){
            $pass_error = '<p id="error">Please insert password</p>';
            $err_s = 1;
            include_once('index.php');
        }
        if(!isset($err_s)){
            $md5_pass = md5($password);
            $sql = "SELECT * FROM users WHERE username='$username' AND password='$password' AND md5_pass='$md5_pass' limit 1";
            $result = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($result);
            $num_rows = mysqli_num_rows($result);
            if($num_rows != 0){
                if($row['status'] == 'pending'){
                    echo "<p>Your account is pending approval from the admin. Please wait.</p>";
                } else {
                    $_SESSION['username']= $row['username'];
                    $_SESSION['id']= $row['id'];
                    header('Location: home.php');
                    exit();
                }
            } else {
                $user_error = '<p id="error">Wrong username or password</p><br>';
                include_once('index.php');
                exit();
            }
        }
    }
}
echo "Data added successfully";
?>
