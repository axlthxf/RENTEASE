<?php
error_reporting(0);
  if($_SERVER["REQUEST_METHOD"] == "GET"){
    $dbconnect = mysqli_connect("localhost", "root", "", "rentease");
    
 
    if (!$dbconnect) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $id=$_GET['id'];
    if(isset($_POST['submit']))
    {
      $propertyname = $_POST['property_name'];
      $location = $_POST['location'];
      $property_number = $_POST['property_number'];
      $price = $_POST['price'];
      $bedroom = $_POST['bedroom'];
      $bathroom = $_POST['bathroom'];
      $sqft= $_POST['sqft'];
      $property_image= $_POST['property_image'];
  }
  $query = "SELECT * FROM properties WHERE property_number = $property_number";
  $result = mysqli_query($dbconnect, $query);

  if (mysqli_num_rows($result) > 0) {
    echo "<script>alert('A property with this number already exists.)</script>";
} 
else{
      $property_number = $_POST['property_number'];
  $query1 = "INSERT INTO properties ( property_name, location,property_number, price, bedroom, bathroom, sqft, property_image)
  VALUES ( '$propertyname', '$location', '$property_number','$price', '$bedroom', '$bathroom', '$sqft', '$property_image')";
              if (mysqli_query($dbconnect, $insert_query)) {
                echo "<script>alert('Property inserted successfully.)</script>";
            } else {
                echo "<script>alert('error inserting property)</script>";
                 mysqli_error($dbconnect);
            }
}
mysqli_close($dbconnect);
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
              <th>Property ID</th>
              <th>Property Name</th>
              <th>Location</th>
              <th>Price</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody id="properties-list">
            <!-- Properties fetched from the database will be displayed here -->
          </tbody>
        </table>
      </section>

      <!-- Add New Property Section -->
      <section id="add-property-section" class="add-property-section">
        <h2>Add New Property</h2>
        <form action="add_property.php" method="POST" enctype="multipart/form-data" class="property-form">
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
            <label for="price">Bathroom:    $location = $_POST['location'];</label>
            <input type="number" id="bathroom" name="bathroom" required>
            <label for="price">Square Feet:</label>
            <input type="number" id="sqft" name="sqft" required>
            <!-- Image Upload -->
            <label for="property-image">Upload Image:</label>
            <input type="file" id="property-image" name="property_image" accept="image/*" required>
            
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
