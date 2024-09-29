<?php
session_start();
$dbconnect = mysqli_connect("localhost", "root", "", "rentease");
if (isset($_SESSION['user'])) {
  $user_id = $_SESSION['user']; // Assuming 'user' is where you store user_id in session
} else {
  header("Location: login.php");
  exit();
}

if (isset($_POST['submit'])) {
  $property_name = $_POST['property_name'];
  $property_number = $_POST['property_number'];
  $location = $_POST['location'];
  $price = $_POST['price'];
  $bedroom = $_POST['bedroom'];
  $bathroom = $_POST['bathroom'];
  $sqft = $_POST['sqft'];
  $property_image = $_FILES['property_image']['name'];

  // Check if the property number already exists
  $check_property_query = "SELECT * FROM `property` WHERE `property_number` = '$property_number'";
  $result = mysqli_query($dbconnect, $check_property_query);

  if (mysqli_num_rows($result) > 0) {
      echo "<script>alert('A property with this number already exists! Please use a unique property number.');</script>";
  } else {
      // Upload the image to the server
      $target_dir = "image/";
      $target_file = $target_dir . basename($_FILES["property_image"]["name"]);

      if (move_uploaded_file($_FILES["property_image"]["tmp_name"], $target_file)) {
          // Insert the property into the database
          $insert_query = "INSERT INTO `property` (`user_id`, `property_name`, `property_number`, `location`, `price`, `bedroom`, `bathroom`, `sqft`, `image`, `status`) 
                           VALUES ('$user_id', '$property_name', '$property_number', '$location', '$price', '$bedroom', '$bathroom', '$sqft', '$property_image', 'vaccant')";

          if (mysqli_query($dbconnect, $insert_query)) {
              echo "<script>alert('Property listed successfully!');</script>";
          } else {
              echo "<script>alert('Error while listing the property.');</script>";
          }
      } else {
          echo "<script>alert('Failed to upload the image.');</script>";
      }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Owner Dashboard</title>
    <link rel="stylesheet" href="owner.css" />
  </head>
  <body>
    <div class="header">
      <h1>Owner Dashboard - Rentease</h1>
    </div>

    <div class="menu">
      <div class="logo">
        <a href="home.html">
          <img src="./image/renteaseadmin-removebg-preview1.png" alt=""
        /></a>
        <!-- <hr> -->
      </div>
      <div class="sidebar">
        <div class="options">
          <a href="#properties" id="list-properties">Properties</a>
        </div>
        <div class="options">
          <a href="#add-property" id="add-property-btn">Add Property</a>
        </div>
        <!-- <div class="options">
          <a href="Tenant.php" onclick="showSection('manageTenants')"
            >Profile</a
          >
        </div> -->

        <div class="options">
          <a href="home.html">Log Out</a>
        </div>
        <!-- <hr> -->
      </div>
    </div>
    <div class="main-content">
      <!-- Vacancy Overview Section -->
      <section id="overview">
        <div class="overview-grid">
          <div class="box vacant">
            <h2>Vacant Properties</h2>
            <p id="vacant-count">0</p>
          </div>
          <div class="box occupied">
            <h2>Occupied Properties</h2>
            <p id="occupied-count">0</p>
          </div>
        </div>
      </section>

      <!-- My Properties Section -->
      <section id="properties-section" class="hidden">
        <h2>My Properties</h2>
        <table>
          <thead>
            <tr>
              <th>Pid</th>
              <th>name</th>
              <th>property number</th>
              <th>Location</th>
              <th>Price</th>
              <th>bedroom</th>
              <th>bathroom</th>
              <th>sqft</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody id="properties-list">
            <!-- Properties fetched from the database will be displayed here -->
             <?php
               $sql = "SELECT * FROM `property` where `user_id`= '$user_id'";
               $result = mysqli_query($dbconnect, $sql);

               
               if (mysqli_num_rows($result) > 0) {
                 while ($row = mysqli_fetch_assoc($result)) {
                  $id= $row["property_id"];
                       echo "<tr>";
                       echo "<td>" . $row["property_id"] . "</td>";
                       echo "<td>" . $row["property_name"] . "</td>";
                       echo "<td>" . $row["property_number"] . "</td>";
                       echo "<td>" . $row["location"] . "</td>";
                       echo "<td>" . $row["price"] . "</td>";
                       echo "<td>" . $row["bedroom"] . "</td>";
                       echo "<td>" . $row["bathroom"] . "</td>";
                       echo "<td>" . $row["sqft"] . "</td>";
                      
                       echo "<td>";
                       if ($row["status"] == "vacant") {
                        echo "<form method='post'><button name='blockuser' value={$id} type='submit' class='btn btn-block'>occupied</button></form>";
                    } else {
                      echo "<form method='post'><button name='unblockuser' value={$id} type='submit' class='btn btn-unblock'>vacant</button></form>";
                    }
                 }
                       echo "</td>";
                       echo "</tr>";
                }
                       else {
                        echo "<tr><td colspan='6'>No owners found</td></tr>";
                    }
                    if(isset($_POST['blockuser'])) {
  $property_id=$_POST['blockuser'];
  $sql1="UPDATE `property` SET `status` = 'vacant' WHERE `property_id` = $property_id";
  $result1= mysqli_query($dbconnect, $sql1); 
  if (mysqli_query($dbconnect, $sql1)) {
    echo "Status updated successfully";
    header("Location:owner.php");
  } else {
    echo "Error updating status: " . mysqli_error($dbconnect);
  }
}

if(isset($_POST['unblockuser'])) {
  $property_id=$_POST['unblockuser']; // Ensure this is the same variable name for both
  $sql2="UPDATE `property` SET `status` = 'occupied' WHERE `property_id` = $property_id"; // Fix query
  $result2= mysqli_query($dbconnect, $sql2); 
  if (mysqli_query($dbconnect, $sql2)) {
    echo "Status updated successfully";
    header("Location: owner.php");
  } else {
    echo "Error updating status: " . mysqli_error($dbconnect);
  }
}

                  
             ?>
          </tbody>
        </table>
      </section>

      <!-- Add New Property Section -->
      <section id="add-property-section" class="add-property-section">
        <h2>Add New Property</h2>
        <form action="" method="post" enctype="multipart/form-data" class="property-form">
            <label for="property-name">Property Name:</label>
            <input type="text" id="property-name" name="property_name" required>
            <label for="property-number">Property Number:</label>
            <input type="number" id="property-number" name="property_number" required>
            
            <label for="location">Location:</label> 
            <input type="text" id="location" name="location" required>
            
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" required>
            <label for="price">Bedroom:</label>
            <input type="number" id="bedroom" name="bedroom" required>
            <label for="price">Bathroom: </label>
            <input type="number" id="bathroom" name="bathroom" required>
            <label for="price">Square Feet:</label>
            <input type="number" id="sqft" name="sqft" required>
            <!-- Image Upload -->
            <label for="property-image">Upload Image:</label>
            <input type="file" id="property-image" name="property_image" accept="image/*" >
            
            <button type="submit" name="submit">List Property</button>
        </form>
    </section>
</div>

    <script>
      const listPropertiesBtn = document.getElementById("list-properties");
      const propertiesSection = document.getElementById("properties-section");
      const addPropertyBtn = document.getElementById("add-property-btn");
      const addPropertySection = document.getElementById(   "add-property-section" );

      listPropertiesBtn.addEventListener("click", function () {
        addPropertySection.classList.add("hidden");
        propertiesSection.classList.remove("hidden");
      });
      addPropertyBtn.addEventListener("click", function () {
        propertiesSection.classList.add("hidden");
        addPropertySection.classList.remove("hidden");
      });

    </script>
  </body>
</html>
