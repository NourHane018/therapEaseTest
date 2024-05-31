<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   <link rel="stylesheet" href="style (1).css">
</head>
<body>
<section>
  <header class="header container">
    <ul class="header__menue">
        <img src="admin_panel/assets/images/logo.svg" class="imgg">
        <div class="notification-icon" onclick="toggleNotifications()">
            <i class="fa-solid fa-bell"></i>
        </div>
        <a href="logout.php"><i class="fa-solid fa-right-from-bracket logout"></i></a>
        <button onclick="toggleAppointments()" class="Show">Show Appointments</button>
        </ul>
        </header>
       
        <div class="outer">
    <div class="inner">
      <div class="bg home">
        <div class="scroll">
          
          <?php 
          include 'cors.php';
            session_start();
            // Include database connection
            include_once "inc/connections.php";

            // Check if user is logged in
            if (isset($_SESSION['id'])) {
                $user_id = $_SESSION['id'];

                // Retrieve user's name from database
                $sql = "SELECT username FROM users WHERE id = $user_id";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $username = $row['username'];
                    echo "<span class='profile-name'>Welcome $username!</span>";
                }
            }
            ?>
        </div>
        <div class="home-content">
          <h1> This is where you'll find the home activities videos. Get down to the next page and watch the right video.</h1>
         
          <ul class="links">
            <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
            <li><a href="#"><ion-icon class="icon" name="logo-instagram"></ion-icon></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <i class="fa-solid fa-computer-mouse mouse-move"></i>
  
</section>
          
        
    </div>
</body>
</head>
<!---   notifications      --->
<div class="notification-dropdown" id="notificationDropdown">
<?php
if (isset($_SESSION['id'])) {
    // Retrieve the user ID
    $user_id = $_SESSION['id'];

// Include database connection
include_once "inc/connections.php";

// Function to calculate relative time
function relative_time($timestamp) {
    $current_time = time();
    $time_difference = $current_time - strtotime($timestamp);

    $seconds = $time_difference;
    $minutes = round($seconds / 60);
    $hours = round($minutes / 60);
    $days = round($hours / 24);
    $weeks = round($days / 7);
    $months = round($weeks / 4.345);
    $years = round($months / 12);

    if ($seconds <= 60) {
        return "just now";
    } elseif ($minutes <= 60) {
        return ($minutes == 1) ? "1 minute ago" : "$minutes minutes ago";
    } elseif ($hours <= 24) {
        return ($hours == 1) ? "1 hour ago" : "$hours hours ago";
    } elseif ($days <= 7) {
        return ($days == 1) ? "1 day ago" : "$days days ago";
    } elseif ($weeks <= 4.345) {
        return ($weeks == 1) ? "1 week ago" : "$weeks weeks ago";
    } elseif ($months <= 12) {
        return ($months == 1) ? "1 month ago" : "$months months ago";
    } else {
        return ($years == 1) ? "1 year ago" : "$years years ago";
    }
}
}
// Check if the user ID is set in the session
if (isset($_SESSION['id'])) {
    // Retrieve the user ID
    $user_id = $_SESSION['id'];

    // Query notifications and check if each one has been read by the user
    $sql = "SELECT notifications.id, notifications.title, notifications.content, notifications.start_date, notifications.end_date, notifications.isAdmin, user_notification_status.is_read, notifications.created_at
            FROM notifications
            LEFT JOIN user_notification_status ON notifications.id = user_notification_status.notifications_id AND user_notification_status.user_id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Open the div for the notification item
            echo "<div class='notification-item" . ($row['isAdmin'] ? ' admin' : '') . ($row['is_read'] ? ' read' : '') . "' data-id='" . $row['id'] . "'>";
    
            // Calculate relative time
            $relative_time = relative_time($row['created_at']);
    
            // Output notification details
            ?>
                        <p><span class="notification-time"><?php echo $relative_time; ?></span></p> <!-- Show relative time here -->

            <h3><?php echo $row['title']; ?></h3>
            <p><?php echo $row['content']; ?></p>
            <p>Start Date: <?php echo $row['start_date']; ?></p>
            <p>End Date: <?php echo $row['end_date']; ?></p>
           
            <?php if (!$row['is_read']): ?>
                <button class="mark-read" onclick="markAsRead(<?php echo $row['id']; ?>)">Mark as Read</button>
            <?php endif; ?>
            <!-- Close the div for the notification item -->
            </div>
            <?php
        }
    } else {
        echo "No notifications found in database";
    }
} else {
    // If user ID is not set in the session, redirect them to the login page
    header("Location: login.php");
    exit(); // Make sure to exit after redirection
}
?>




</div>
<!---   Appointements      --->

<div class="appointments" id="appointmentsSection" style="display: none;">
<?php
// Include database connection
include_once "inc/connections.php";

// Check if the user ID is set in the session
if (isset($_SESSION['id'])) {
    // Retrieve the user ID
    $user_id = $_SESSION['id'];

    // Query appointments for the logged-in user
    $sql_appointments = "SELECT appointments.patient_name, appointments.appointment_date 
                        FROM appointments 
                        INNER JOIN users ON appointments.user_id = users.id 
                        WHERE users.id = $user_id";

    $result_appointments = $conn->query($sql_appointments);

    if ($result_appointments && $result_appointments->num_rows > 0) {
        // Appointments found, display them
        while ($row = $result_appointments->fetch_assoc()) {
            ?>
            <div class="appointment-item">
                <h3>Appointment Date and Time: <?php echo isset($row['appointment_date']) ? $row['appointment_date'] : 'N/A'; ?></h3>
            </div>
            <?php
        }
    } else {
        echo "No appointments found for you.";
    }
} else {
    // If user ID is not set in the session, redirect them to the login page
    header("Location: login.php");
    exit(); 
}
?>
</div>
<section>
  <div class="outer">
    <div class="inner">
      <div class="bg content">
        <div class="swiper">
          <div class="swiper-wrapper">
           
            <div class="swiper-slide">
            <div class="title">
                <h2>Matching activity</h2>
                <p>1/8</p>
              </div>
              <video controls  src="video/video_2024-05-10_00-32-09.mp4" alt="modern talking" width="200rem" height="200rem"></video>
              
            </div>
            <div class="swiper-slide">
              <div class="title">
                <h2>Modern Talking</h2>
                <p>2/8</p>
              </div>
              <video controls  src="video/video_2024-05-10_00-32-15.mp4" alt="modern talking" width="200rem" height="200rem"></video>
              
            </div>
            <div class="swiper-slide">
              <div class="title">
                <h2>Breathing activity</h2>
                <p>3/8</p>
              </div>

              <video controls  src="video/video_2024-05-10_00-32-19.mp4" alt="modern talking" width="200rem" height="200rem"></video>
              
            </div>
            <div class="swiper-slide">
               <div class="title">
                <h2>Screening activity</h2>
                <p>4/8</p>
              </div>
              <video controls  src="video/video_2024-05-10_00-32-25.mp4" alt="modern talking" width="200rem" height="200rem"></video>
             
            </div>
            <div class="swiper-slide">
              <div class="title">
                <h2>Matching activity</h2>
                <p>5/8</p>
              </div>
              <video controls  src="video/video_2024-05-10_00-32-28.mp4" alt="modern talking" width="200rem" height="200rem"></video>
              
            </div>
            <div class="swiper-slide">
             <div class="title">
               <h2>Breathing activity</h2>
                <p>6/8</p>
              </div>
              <video controls  src="video/video_2024-05-10_00-32-32.mp4" alt="modern talking" width="200rem" height="200rem"></video>
             
               
            </div>
            <div class="swiper-slide">
               <div class="title">
                <h2>Modern Talking</h2>
                <p>7/8</p>
              </div>
              <video controls  src="video_2024-05-10_15-50-24.mp4" alt="modern talking" width="200rem" height="200rem"></video>
             
            </div>
            <div class="swiper-slide">
               <div class="title">
                <h2>Modern Talking</h2>
                <p>8/8</p>
              </div>
              <video controls  src="video_2024-05-10_15-50-24.mp4" alt="modern talking" width="200rem" height="200rem"></video>
             
            </div>
           
            <!-- Add other swiper slides here -->
          </div>
          <div class="swiper-pagination"></div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
    function reorderNotifications() {
        var notificationsContainer = document.getElementById('notificationDropdown');
        var notificationItems = notificationsContainer.querySelectorAll('.notification-item');
        var unreadNotifications = [];
        var readNotifications = [];

        // Separate unread and read notifications
        notificationItems.forEach(function(item) {
            if (item.classList.contains('read')) {
                readNotifications.push(item);
            } else {
                unreadNotifications.push(item);
            }
        });

        // Reorder notifications in place
        unreadNotifications.forEach(function(item) {
            notificationsContainer.insertBefore(item, notificationsContainer.firstChild);
        });

        readNotifications.forEach(function(item) {
            notificationsContainer.appendChild(item);
        });
    }

    // Call the reorderNotifications function on page load
    window.onload = function() {
        reorderNotifications();
    };

    // Function to mark notification as read
    function markAsRead(id) {
        var notificationItem = document.querySelector('.notification-item[data-id="' + id + '"]');
        if (notificationItem) {
            // Send an AJAX request to mark the notification as read in the database
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'mark_as_read.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    console.log(xhr.responseText); 
                    if (xhr.status === 200) {
                        // Notification marked as read
                        // Hide the "Mark as Read" button and change its color
                        var markReadButton = notificationItem.querySelector('.mark-read');
                        if (markReadButton) {
                            markReadButton.style.display = 'none';
                        }

                        // Move the notification item to the bottom if it's marked as read
                        notificationItem.classList.add('read');
                        var notificationsContainer = document.getElementById('notificationDropdown');
                        notificationsContainer.appendChild(notificationItem);
                    } else {
                        // Handle error
                    }
                }
            };
            xhr.send('id=' + id);
        }
    }


    function toggleNotifications() {
        var dropdown = document.getElementById('notificationDropdown');
        if (dropdown.style.display === 'none') {
            dropdown.style.display = 'block';
        } else {
            dropdown.style.display = 'none';
        }
    }

    function toggleAppointments() {
        var appointmentsSection = document.getElementById('appointmentsSection');
        if (appointmentsSection.style.display === 'none') {
            appointmentsSection.style.display = 'block';
        } else {
            appointmentsSection.style.display = 'none';
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.1/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.1/ScrollTrigger.min.js"></script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/16327/SplitText3.min.js"></script>
<script src="script.js"></script>
</body>
</html>