<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);


$dbconnect = mysqli_connect("localhost", "root", "", "rentease");
if (isset($_SESSION['user'])) {
  $user_id = $_SESSION['user']; 
} else {
  header("Location: login.php");
  exit();
}

if (isset($_SESSION['tenant'])) {
  $tenant_id = $_SESSION['tenant']; 
}

// Initialize $bookingResult to null
$bookingResult = null;

// After checking if the user is logged in
if (isset($tenant_id)) {
  echo "<script>console.log('Tenant ID: $tenant_id');</script>";

  $checkbooking = "SELECT * FROM `bookings` WHERE `user_id` = '$tenant_id' AND status = 'pending'";
  $bookingResult = mysqli_query($dbconnect, $checkbooking);

  if (!$bookingResult) {
      echo "<script>alert('Error fetching bookings: " . mysqli_error($dbconnect) . "');</script>";
  }
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


  $check_property_query = "SELECT * FROM `property` WHERE `property_number` = '$property_number'";
  $result = mysqli_query($dbconnect, $check_property_query);



  if (mysqli_num_rows($result) > 0) {
    echo "<script>alert('A property with this number already exists! Please use a unique property number.');</script>";
  } else {
  
    
    $target_file = basename($_FILES["property_image"]["name"]);

      $insert_query = "INSERT INTO `property` (`user_id`, `property_name`, `property_number`, `location`, `price`, `bedroom`, `bathroom`, `sqft`, `image`, `status`) 
                           VALUES ('$user_id', '$property_name', '$property_number', '$location', '$price', '$bedroom', '$bathroom', '$sqft', '$target_file', 'vaccant')";
 if ($target_file){
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
        <img src="./image/renteaseadmin-removebg-preview1.png" alt="" /></a>
      <!-- <hr> -->
    </div>
    <div class="sidebar">
      <div class="options">
        <a href="#properties" id="list-properties">Properties</a>
      </div>
      <div class="options">
        <a href="#add-property" id="add-property-btn">Add Property</a>
      </div>
      <div class="options">
  <a href="#manage-bookings" id="manage-bookings-btn">Manage Bookings</a>
</div>
      <div class="options">
  <a href="#manage-bookings" id="manage-bookings-btn">View Profile</a>
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
     <?php
                           $sql ="SELECT * FROM property WHERE status='vacant' AND user_id='$user_id'";
                           $result = mysqli_query($dbconnect, $sql);
                         
                         
                           if ($result) {
                            $vacant = mysqli_num_rows($result);
     
                         }
                         $sql ="SELECT * FROM property WHERE status='occupied' AND user_id='$user_id'";
                           $result = mysqli_query($dbconnect, $sql);
                         
                         
                           if ($result) {
                            $occupied = mysqli_num_rows($result);
     
                         }
     ?>
    <section id="overview">
      <div class="overview-grid">
        <div class="box vacant">
          <h2>Vacant Properties</h2>
          <p id="vacant-count"><?php echo $vacant; ?></p>
        </div>
        <div class="box occupied">
          <h2>Occupied Properties</h2>
          <p id="occupied-count"><?php echo $occupied; ?></p>
        </div>
      </div>
    </section>

    <!-- My Properties Section -->
    <section id="properties-section" >
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
              $id = $row["property_id"];
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
              echo "<div class='flex-container'>";

              if ($row["status"] == "vacant") {
                echo "<form method='post'><button name='blockuser' value={$id} type='submit' class='btn btn-block'>occupied</button></form>";
              } else {
                echo "<form method='post'><button name='unblockuser' value={$id} type='submit' class='btn btn-unblock'>vacant</button></form>";
              }
              echo '<a href="editproperty.php?property_id=' . $id . '"><img src="./image/rentease.png" alt="Property Icon" style="width: 30px; height: 30px; cursor: pointer;"></a>';
            }
            echo "</div>";
            echo "</td>";
            echo "</tr>";
          } else {
            echo "<tr><td colspan='6'>No owners found</td></tr>";
          }
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['blockuser'])) {
              $property_id = $_POST['blockuser'];
              $sql1 = "UPDATE `property` SET `status` = 'occupied' WHERE `property_id` = $property_id";
          
              if (mysqli_query($dbconnect, $sql1)) {
                
                echo "<script>alert('Property marked as occupied.')</script>";
                header("Location:owner.php");
              } else {
                echo "<script>alert('Error updating status to occupied: " . mysqli_error($dbconnect) . "');</script>";
              }
            }
          
            if (isset($_POST['unblockuser'])) {
              $property_id = $_POST['unblockuser'];
              $sql2 = "UPDATE `property` SET `status` = 'vacant' WHERE `property_id` = $property_id";
          
              if (mysqli_query($dbconnect, $sql2)) {
                echo "<script>alert('Property marked as vacant.')</script>";
                header("Location:owner.php");
              } else {
                echo "<script>alert('Error updating status to vacant: " . mysqli_error($dbconnect) . "');</script>";
              }
            }
          }


          ?>
        </tbody>
      </table>
    </section>

    <!-- Add New Property Section -->
    <section id="add-property-section" class="add-property-section hidden">
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
        <input type="file" id="property-image" name="property_image" accept="image/*">

        <button type="submit" name="submit">List Property</button>
      </form>
    </section>
    <!-- Manage Bookings Section -->
<!-- Manage Bookings Section -->
<section id="manage-bookings-section" class="hidden">
  <h2>Manage Bookings</h2>
  <table>
    <thead>
      <tr>
        <th>Booking ID</th>
        <th>Property Name</th>
        <th>Tenant</th>
        <th>Booking Date</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
    if (isset($bookingResult) && $bookingResult && mysqli_num_rows($bookingResult) > 0) {
    while ($bookingrow = mysqli_fetch_assoc($bookingResult)) {
        // Fetch tenant details for this booking
        $tenantQuery = "SELECT name FROM user WHERE user_id = '$tenant_id'"; // Use tenant_id from booking
        $tenantResult = mysqli_query($dbconnect, $tenantQuery);
        if ($tenantResult && mysqli_num_rows($tenantResult) > 0) {
            $tenantrow = mysqli_fetch_assoc($tenantResult);
        } else {
            echo "<script>console.log('Error: No tenant found for user_id: " . $bookingrow['user_id'] . "');</script>";
            continue; // Skip this booking if no tenant found
        }

        // Fetch property details for this booking
        $property_id = $bookingrow['property_id'];
        $propertyQuery = "SELECT property_name FROM property WHERE property_id = '$property_id'";
        $propertyResult = mysqli_query($dbconnect, $propertyQuery);
        if ($propertyResult && mysqli_num_rows($propertyResult) > 0) {
            $propertyrow = mysqli_fetch_assoc($propertyResult);
            $_SESSION['pptyname'] =$propertyrow['property_name'];
        } else {
            echo "<script>console.log('Error: No property found for property_id: " . $property_id . "');</script>";
            continue; // Skip this booking if no property found
        }

        echo "<tr>";
        echo "<td>" . $bookingrow["booking_id"] . "</td>";
        echo "<td>" . $propertyrow["property_name"] . "</td>"; // Property name
        echo "<td>" . $tenantrow["name"] . "</td>"; // Tenant name
        echo "<td>" . $bookingrow["booking_date"] . "</td>"; // Booking date
        echo "<td>" . $bookingrow["status"] . "</td>"; // Booking status
        echo "<td><a href='accept_booking.php?booking_id=" . $bookingrow["booking_id"] . "'><button style=' background-color: #28a745; color:white; border-radius:5px; border:none; cursor: pointer';>Accept</button></a> | <a href='decline_booking.php?booking_id=" . $bookingrow["booking_id"] . "'><button style=' background-color: #dc3545; color:white; border-radius:5px; border:none; cursor: pointer'>Decline</button></a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No booking requests found</td></tr>";
}
?>

    </tbody>
  </table>
</section>



  </div>

  <script>
const listPropertiesBtn = document.getElementById("list-properties");
const propertiesSection = document.getElementById("properties-section");
const addPropertyBtn = document.getElementById("add-property-btn");
const addPropertySection = document.getElementById("add-property-section");
const manageBookingsBtn = document.getElementById("manage-bookings-btn");
const manageBookingsSection = document.getElementById("manage-bookings-section");

// Function to hide all sections
function hideAllSections() {
  propertiesSection.classList.add("hidden");
  addPropertySection.classList.add("hidden");
  manageBookingsSection.classList.add("hidden");
}

// Show Properties Section
listPropertiesBtn.addEventListener("click", function () {
  hideAllSections();
  propertiesSection.classList.remove("hidden");
});

// Show Add Property Section
addPropertyBtn.addEventListener("click", function () {
  hideAllSections();
  addPropertySection.classList.remove("hidden");
});

// Show Manage Bookings Section
manageBookingsBtn.addEventListener("click", function () {
  hideAllSections();
  manageBookingsSection.classList.remove("hidden");
});


  </script>
</body>

</html>