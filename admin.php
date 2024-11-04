<?php

if($_SERVER["REQUEST_METHOD"] == "GET"){
                      $dbconnect = mysqli_connect("localhost", "root", "", "rentease");

                   
                      if (!$dbconnect) {
                          die("Connection failed: " . mysqli_connect_error());
                      }
                      $sql ="SELECT * FROM user WHERE usertype='Owner'";
                      $result = mysqli_query($dbconnect, $sql);
                    
                    
                      if ($result) {
                       $total_landlords = mysqli_num_rows($result);

                        
                    }
                      $sql ="SELECT * FROM user WHERE usertype='User'";
                      $result = mysqli_query($dbconnect, $sql);
                    
                    
                      if ($result) {
                       $total_tenants = mysqli_num_rows($result);

                    }
                      $sql ="SELECT * FROM property";
                      $result = mysqli_query($dbconnect, $sql);
                    
                    
                      if ($result) {
                       $total_property = mysqli_num_rows($result);

                    }
}
                      
  ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="admin.css" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
  </head>
  <body>
    <div class="header">
      <h1>Admin Dashboard</h1>
    </div>
    <div class="menu">
      <div class="logo">
       <a href="home.html"> <img src="./image/renteaseadmin-removebg-preview1.png" alt=""></a>
        <!-- <hr> -->
      </div>
      <div class="sidebar">
        <!-- <div class="options">
 
          <a href="#properties">Manage Properties</a>
        </div> -->
        <div class="options">
          <a href="Manageowner.php">Manage Landlords</a>
        </div>
        <div class="options">
  
          <a href="Tenant.php" onclick="showSection('manageTenants')">Manage Tenants</a>
        </div>
        <div class="options">
  
          <a href="ManageBooking.php">Manage Bookings</a>
        </div>
        <div class="options">
  
          <a href="feedback.html">View Feedback</a>
        </div>
        <div class="options">
          <a href="home.html">Log out</a>
        </div>
        <!-- <hr> -->
      </div>
  </div>

    <div class="content">
      <!-- Dashboard Overview -->
      <div class="overview">
        <div class="card">
          <img src="./image/house.png" alt="">
          <div class="contents">
          <h3>Total Properties</h3>
          <p><?php echo $total_property; ?></p>
        </div>
        </div>
        <div class="card">
          <img src="./image/boss.png" alt="">
          <div class="contents">
          <h3>Total Landlords</h3>
          <p><?php echo $total_landlords; ?> </p>
        </div>
        </div>
        <div class="card">
          <img src="./image/tenant.png" alt="">
          <div class="contents">
          <h3>Total Tenants</h3>
          <p><?php echo $total_tenants; ?></p>
        </div>
        </div>
      </div>

    </div>
  <!-- <script>
//       function showSection(sectionId) {
     
//           var sections = document.querySelectorAll('.section');
//           sections.forEach(function(section) {
//               section.classList.remove('active');
//           });

//           // Show the selected section
//           var selectedSection = document.getElementById('manageTenants');
//           selectedSection.classList.add('active');
//       } 
//   </script> -->
 
  </body>
</html>
<!-- <?php
                    //   $dbconnect = mysqli_connect("localhost", "root", "", "rentease");

                   
                    //   if (!$dbconnect) {
                    //       die("Connection failed: " . mysqli_connect_error());
                    //   }
                    //   $sql ="SELECT * FROM user WHERE usertype = 'Owner'";
                    //   $result = mysqli_query($dbconnect, $sql);
                    
                    
                    //   if ($result) {
                    //    $total_landlords = mysqli_num_rows($result);
                    //     // $row = mysqli_fetch_assoc($result);
                    //     // $total_landlords = $row['total']; 
                        
                    // }

  
                    //   $sql1 ="SELECT COUNT(*) AS total_tenants  FROM `user` WHERE `usertype` = 'User'";
                    //   $result1 = mysqli_query($dbconnect, $sql1);
                    //   $row1 = mysqli_fetch_assoc($result1);
                    //   $total_tenants = $row1['total_tenants'];
  ?> -->
