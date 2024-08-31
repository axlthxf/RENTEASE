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
            <!-- <tbody>
                <tr>
                    <td>1</td>
                    <td>John Doe</td>
                    <td>johndoe@example.com</td>
                    <td>123-456-7890</td>
                    <td>Active</td>
                    <td>
                        <button class="btn btn-block">Block</button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Jane Smith</td>
                    <td>janesmith@example.com</td>
                    <td>098-765-4321</td>
                    <td>Blocked</td>
                    <td>
                        <button class="btn btn-unblock">Unblock</button>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Michael Johnson</td>
                    <td>michaeljohnson@example.com</td>
                    <td>456-789-0123</td>
                    <td>Active</td>
                    <td>
                        <button class="btn btn-block">Block</button>
                    </td>
                </tr>
            </tbody> -->

    <!-- <?php
    // $dbconnect=mysqli_connect("localhost","root","","rentease");
    // if(!$dbconnect){
    //     die("Connection failed: ". mysqli_connect_error());
    // }

    // $sql="SELECT * FROM `user` WHERE 'usertype' = 'User'";
    // $result = mysqli_query($dbconnect, $sql);

    // if (mysqli_num_rows($result) > 0) {
    //   while($row = mysqli_fetch_assoc($result)) {
    //     echo "<tr>";
    //     echo "<td>" . $row["user_id"] . "</td>";
    //     echo "<td>" . $row["name"] . "</td>";
    //     echo "<td>" . $row["email"] . "</td>";
    //     echo "<td>" . $row["phno"] . "</td>";
    //     echo "<td>" . $row["status"] . "</td>";
    //     echo "<td><div class='action-buttons'>";
    //   }
    //   mysqli_close($dbconnect);
    // }

    ?> -->
    <tbody>
         <?php
                    // Connect to the database
                    $dbconnect = mysqli_connect("localhost", "root", "", "rentease");

                    // Check connection
                    if (!$dbconnect) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    // Fetch tenant details
                    $sql = "SELECT * FROM `user` WHERE `usertype` = 'User'";
                    $result = mysqli_query($dbconnect, $sql);

                    // Check if there are results
                    if (mysqli_num_rows($result) > 0) {
                        // Loop through each row and output it in the table
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