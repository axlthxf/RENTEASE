<?php
  if($_SERVER["REQUEST_METHOD"] == "GET"){
    $dbconnect = mysqli_connect("localhost", "root", "", "rentease");
    
 
    if (!$dbconnect) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $id=$_GET['id'];
    
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
            
            <label for="location">Location:</label> 
            <input type="text" id="location" name="location" required>
            
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" required>
            <label for="price">Bedroom:</label>
            <input type="number" id="bedroom" name="bedroom" required>
            <label for="price">Bathroom:</label>
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
      const addPropertyBtn = document.getElementById("add-property-btn");
      const listPropertiesBtn = document.getElementById("list-properties");
      const propertiesSection = document.getElementById("properties-section");
      const addPropertySection = document.getElementById(   "add-property-section" );

      addPropertyBtn.addEventListener("click", function () {
        propertiesSection.classList.add("hidden");
        addPropertySection.classList.remove("hidden");
      });

      listPropertiesBtn.addEventListener("click", function () {
        addPropertySection.classList.add("hidden");
        propertiesSection.classList.remove("hidden");
      });
    </script>
  </body>
</html>
