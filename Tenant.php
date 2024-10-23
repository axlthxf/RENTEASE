<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="Tenant.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="header">
        <h1>TENANTS</h1>
      </div>
      <div class="menu">
        <div class="logo">
         <a href="admin.php"> <img src="./image/renteaseadmin-removebg-preview1.png" alt=""></a>
          <!-- <hr> -->
        </div>
        <div class="sidebar">
   
          <div class="options">
            <a href="Manageowner.php">Manage Landlords</a>
          </div>
          <div class="options">
    
            <a href="Tenant.php">Manage Tenants</a>
          </div>
          <div class="options">
  
            <a href="login.php">Log out</a>
          </div>
          <!-- <hr> -->
        </div>
    </div>
  
      <div class="content">

  
    <div class="container">
        <div class="nothing">
  
        </div>
        <table>
            <thead>
                <tr>
                    <th>Tenant ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <!-- <th>Status</th> -->
                    <th>Action</th>
                </tr>
            </thead>
          

    <tbody>
         <?php
                    
                    $dbconnect = mysqli_connect("localhost", "root", "", "rentease");

                   
                    if (!$dbconnect) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                   
                    $sql = "SELECT * FROM `user` WHERE `usertype` = 'User'";
                    $result = mysqli_query($dbconnect, $sql);

                    
                    if (mysqli_num_rows($result) > 0) {
                
                        while ($row = mysqli_fetch_assoc($result)) {
                          $id= $row["user_id"];
                            echo "<tr>";
                            echo "<td>" . $row["user_id"] . "</td>";
                            echo "<td>" . $row["name"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . $row["phno"] . "</td>";
                            
                            echo "<td>";
                          
                            if ($row["status"] == "active") {
                              echo "<form method='post'><button name='blockuser' value={$id} type='submit' class='btn btn-block'>Block</button></form>";
                              
                          } else {
                            echo "<form method='post'><button name='unblockuser' value={$id} type='submit' class='btn btn-unblock'>Unblock</button></form>";
                          
                              
                          }
                          echo "</div></td>";
                          echo "</tr>";
                      }
                            echo "</td>";
                            echo "</tr>";
                        }
                    else {
                        echo "<tr><td colspan='6'>No tenants found</td></tr>";
                    }
                    if(isset($_POST['blockuser']))
                    {
                      $user_id=$_POST['blockuser'];
                     $sql1= "UPDATE `user` SET `status` = 'inactive' WHERE `user_id` = $user_id ";
                     $result1= mysqli_query($dbconnect, $sql1); 
                     if (mysqli_query($dbconnect, $sql1)) {
                       echo "Status updated successfully";
                       header("Location: Tenant.php");
                   } else {
                       echo "Error updating status: " . mysqli_error($dbconnect);
                   }
                 }
                 if(isset($_POST['unblockuser']))
                    {
                      $user_id=$_POST['unblockuser'];
                     $sql1= "UPDATE `user` SET `status` = 'active' WHERE `user_id` = $user_id ";
                     $result1= mysqli_query($dbconnect, $sql1); 
                     if (mysqli_query($dbconnect, $sql1)) {
                       echo "Status updated successfully";
                       header("Location: Tenant.php");
                   } else {
                       echo "Error updating status: " . mysqli_error($dbconnect);
                   }
                 }
                    
                          

                    // Close the database connection
                    mysqli_close($dbconnect);
                    ?>
                     </tbody>
                     </table>
                     </div>
</body>
</html>