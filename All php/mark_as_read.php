<?php
// Include database connection
include_once "inc/connections.php";
session_start();

if(isset($_POST['id'])) {
   
    $notifications_id = intval($_POST['id']);
    $user_id = $_SESSION['id'];
  

    $sql_check = "SELECT * FROM user_notification_status WHERE user_id = ? AND notifications_id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ii", $user_id, $notifications_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    
    if ($result_check->num_rows == 0) {
        $sql_insert = "INSERT INTO user_notification_status (user_id, notifications_id, is_read) VALUES (?, ?, 1)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ii", $user_id, $notifications_id);
        
        if ($stmt_insert->execute()) {
            // If the insertion was successful, send a success response back to the client
           
        } else {
            // If there was an error with the query, send an error response back to the client
           
        }
    } 
} 
?>
