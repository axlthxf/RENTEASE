<?php
 
 $dbconnect = mysqli_connect("localhost", "root", "", "rentease");
 if ($dbconnect->connect_error) {
     die("Connection failed: " . $dbconnect->connect_error);
 }
 
 // Default SQL query to fetch all properties
 $sql = "SELECT * FROM property";
 
 // Check if the filter form is submitted
 if (isset($_POST['filter'])) {
     $conditions = [];
 
     // Get filter values from the form
     $bedrooms = isset($_POST['bedrooms']) ? $_POST['bedrooms'] : '';
     $location = isset($_POST['location']) ? $_POST['location'] : '';
     $sqft = isset($_POST['sqft']) ? $_POST['sqft'] : '';
     $price = isset($_POST['price']) ? $_POST['price'] : '';
 
     // Add conditions based on filters
     if (!empty($bedrooms)) {
         $conditions[] = "bedroom >= '$bedrooms'";
     }
     if (!empty($location)) {
      $conditions[] = "location = '" . mysqli_real_escape_string($dbconnect, $location) . "'";
  }
  
     if (!empty($sqft)) {
         $conditions[] = "sqft >= '$sqft'";
     }
     if (!empty($price)) {
         $conditions[] = "price <= '$price'";
     }
 
     // If there are conditions, append them to the SQL query
     if (count($conditions) > 0) {
         $sql .= " WHERE " . implode(' AND ', $conditions);
     }
 }
 
 $result = mysqli_query($dbconnect, $sql);
 



if ($result) {
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rentease - Tenant Dashboard</title>
    <link rel="stylesheet" href="user.css">
</head>
<body>
    <div class="header">
        <!-- <div class="logo">
            <img src="/image/renteaselogo21.png" alt="Rentease Logo">
        </div>
        <div class="nav">
            <button class="list-property">List Your Property</button>
            <div class="menu-icon">&#9776;</div>
        </div> -->
        <nav>
          <div class="navbar">
          <div class="logo">
            <a href="">  <img src="./image/renteaselogo21.png" alt="Logo" /></a>
          </div>
        <div class="options">
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Properties</a></li>
            <li><a href="#">Contact</a></li>
          </ul>
          <div class="logout">
             <a href="login.php"> <button>Logout</button></a>
            </div>
        </div>
      </div>
      </nav>
    </div>
    
<div class="hero">
    <div class="banner">
        <div class="banner-content">
            <h1>Find Your Perfect Rental property with  <span>Rentease</span></h1>
            <p>Connecting Tenants and Landlords Seamlessly with Ease and Trust</p>
            
            <!-- <div class="search-form">
                <div class="search-options">
                    <button class="option">Full House</button>
                    <button class="option">Flatmates</button>
                    <button class="option">Co-Living/PG</button>
                </div> -->
                <!-- <div class="search-inputs">
                    <select class="location">
                        <option value="Bangalore">Bangalore</option>
                        <option value="Delhi">Delhi</option>
                        <option value="Mumbai">Mumbai</option> -->
                        <!-- Add more locations as needed -->
                    <!-- </select>
                    <input type="text" placeholder="Search Locality" class="locality">
                    <button class="search-btn">Search</button>
                </div> -->
            </div>
          </div>
          <div class="stats">
            <div class="stat-box">
                <h3>1,00,000+</h3>
                <p>Houses Rented</p>
            </div>
            <div class="stat-box">
                <h3>2,00,000+</h3>
                <p>Happy Customers</p>
            </div>
            <div class="stat-box">
                <h3>45,000+</h3>
                <p>Trusted Owners</p>
            </div>
        </div>
      </div>
        </div>

    <!-- Add Filter Form Here -->
 <div class="filter">
 <div class="filter-form">
        <form method="POST" action="">
            <select name="bedrooms">
                <option value="">Select Bedrooms</option>
                <option value="1">1 Bedroom</option>
                <option value="2">2 Bedrooms</option>
                <option value="3">3 Bedrooms</option>
                <option value="4">4 Bedrooms</option>
            </select>

            <input type="text" name="location" placeholder="Enter Location">


            <select name="sqft">
                <option value="">Select Sqft</option>
                <option value="500">500 sqft</option>
                <option value="1000">1000 sqft</option>
                <option value="1500">1500 sqft</option>
            </select>

            <input type="number" name="price" placeholder="Max Price">

            <button type="submit" name="filter">Filter</button>
        </form>
    </div>
 </div>
        <div class="section2">
        <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          
            ?>
            
          <div class="card">
            <img src="image/<?php echo $row['image']; ?>" alt="Property Image">
            <div class="card-content">
              <h3><?php echo $row['property_name']; ?></h3>
              <p><?php echo $row['bedroom']; ?> Bed | <?php echo $row['bathroom']; ?>  Bath |<?php echo $row['sqft']; ?>sqft</p>
              <p>Location: <?php echo $row['location']; ?></p>
              <p class="price">₹<?php echo $row['price']; ?>/month</p>
              
              <?php
                echo "<a href='property_details.php?id=".$row["property_id"]."'><button>View Details</button></a>";
            ?>   
            </div>
          </div>
          <?php
        }
    } else {
        echo "<p>No properties available.</p>";
    }
    ?>
           </div>
           

</body>
</html>
<?php
} else {
    echo "<p>Error executing query: " . mysqli_error($dbconnect) . "</p>"; 
}
mysqli_close($dbconnect); 