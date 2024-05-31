<!DOCTYPE html>
<html>
<head>
  <title>Admin</title>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
       <link rel="stylesheet" href="./assets/css/style.css"></link>
  </head>
</head>
<body >
    
        <?php
            include "./adminHeader.php";
            include "./sidebar.php";
           
            include_once "./inc/connections.php";

        ?>

    <div id="main-content" class="container allContent-section py-4">
        <div class="row">
            <div  class="col-sm-3">
                <div  class="card">
                <a href="#patients"  onclick="showPatients()" style="text-decoration: none; color: inherit;">
              <i class="fa fa-users mb-2" style="font-size: 70px;"></i></a>
                    <h4  style="color:white;">Patients</h4>
                    <h5 style="color:white;">
                    <?php
                    $sql = "SELECT * FROM users WHERE isAdmin = 0";
                    $result = $conn->query($sql);
                    if ($result === false) {
                        // Query failed, handle the error
                        echo "Error: " . $conn->error;
                    } else {
                        // Query executed successfully
                        $count = $result->num_rows;
                        echo $count;
                    }

                    
                ?></h5>
                </div>
            </div>

            <div class="col-sm-3">
         <div  class="card">
            <a href="#patients"  onclick="showAdv()" style="text-decoration: none; color: inherit;">
              <i class="fa fa-th-large" style="font-size: 70px;"></i></a>
                    <h4  style="color:white;">advr</h4>
                    <h5 style="color:white;">
                    <?php
                    $sql = "SELECT * FROM advertisements WHERE isAdmin = 0";
                    $result = $conn->query($sql);
                    if ($result === false) {
                        // Query failed, handle the error
                        echo "Error: " . $conn->error;
                    } else {
                        // Query executed successfully
                        $count = $result->num_rows;
                        echo $count;
                    }

                  ?></h5>
         </div></div>



            <div class="col-sm-3">
                <div class="card">
                <a href="#appoitment"   onclick="showAppontment()" style="text-decoration: none; color: inherit;">
                    <i class="fa fa-list mb-2" style="font-size: 70px;"></i></a>
                    <h4 style="color:white;">Appoitment</h4>
                    <h5 style="color:white;">
                    <?php
                       
                       $sql="SELECT * from appointments where isAdmin=0" ;
                       $result=$conn-> query($sql);
                       $count=0;
                       if ($result-> num_rows > 0){
                           while ($row=$result-> fetch_assoc()) {
                   
                               $count=$count+1;
                           }
                       }
                       echo $count;
                   ?>
              
                   </h5>
                </div>
            </div>
        </div>
        
    </div>
       
            
     

    <script type="text/javascript" src="./assets/js/ajaxWork.js"></script>    
    <script type="text/javascript" src="./assets/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
 
</html>