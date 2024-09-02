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
         <a href="home.html"> <img src="./image/renteaseadmin-removebg-preview1.png" alt=""></a>
          <!-- <hr> -->
        </div>
        <div class="sidebar">
          <div class="options">
   
            <a href="#properties">Manage Properties</a>
          </div>
          <div class="options">
            <a href="#landlords">Manage Landlords</a>
          </div>
          <div class="options">
    
            <a href="Tenant.html">Manage Tenants</a>
          </div>
          <div class="options">
  
            <a href="#settings">Log out</a>
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
                            echo "<tr>";
                            echo "<td>" . $row["user_id"] . "</td>";
                            echo "<td>" . $row["name"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . $row["phno"] . "</td>";
                            echo "<td>";
                            echo "<button class='btn btn-block'>Block</button>";
                            // status
                          //   if ($row["status"] == "Active") {
                          //     echo "<button class='block-btn'>Block</button>";
                          // } else {
                          //     echo "<button class='unblock-btn'>Unblock</button>";
                          // }
                          // echo "</div></td>";
                          // echo "</tr>";
                      }
                            echo "</td>";
                            echo "</tr>";
                        }
                    else {
                        echo "<tr><td colspan='6'>No tenants found</td></tr>";
                    }

                    // Close the database connection
                    mysqli_close($dbconnect);
                    ?>
                     </tbody>
                     </table>
                     </div>
</body>
</html>