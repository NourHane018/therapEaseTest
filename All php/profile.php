<?php 
include 'cors.php';
// Include database connection
include_once "inc/connections.php";

// Check if user is logged in
session_start();
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
    
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        $current_password = mysqli_real_escape_string($conn, $_POST['current_password']);
        $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
        
        // Check if the current password matches the one in the database
        $check_password_query = "SELECT * FROM users WHERE id = $user_id AND password = '$current_password'";
$check_password_result = mysqli_query($conn, $check_password_query);
        if (mysqli_num_rows($check_password_result) == 1) {
            // Update other user details
            $md5_new_password = md5($new_password);

            // Update both plaintext and hashed passwords
            $update_password_query = "UPDATE `users` SET `password` = '$password', `md5_pass` = '$md5_pass' WHERE `email` = '$email' AND `reset_token` = '$reset_token'";
            $result = mysqli_query($conn, $update_password_query);

            if ($update_user_result) {
                echo "User details updated successfully.";
            } else {
                echo "Error updating user details: " . mysqli_error($conn);
            }
            
            // Update password if new password is provided
            if (!empty($new_password)) {
                // Hash the new password
                $md5_new_password = md5($new_password);
                
                // Update both plaintext and hashed passwords
                $update_password_query = "UPDATE users SET password = '$new_password', md5_pass = '$md5_new_password' WHERE id = $user_id";
                $update_password_result = mysqli_query($conn, $update_password_query);
                
                if (!$update_password_result) {
                    echo "Error updating password: " . mysqli_error($conn);
                }
            }
            
            
        } else {
            echo "Current password is incorrect.";
        }
    }
    
    // Retrieve user details
    $sql = "SELECT * FROM users WHERE id = $user_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

    }
} else {
    echo "User not logged in.";
}
?>
