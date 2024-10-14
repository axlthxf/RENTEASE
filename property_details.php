<?php
// Connect to the database
session_start();
$dbconnect = mysqli_connect("localhost", "root", "", "rentease");
if (isset($_SESSION['tenant'])) {
  $user_id = $_SESSION['tenant']; 
} 
if ($dbconnect->connect_error) {
    die("Connection failed: " . $dbconnect->connect_error);
}


// Get the property ID from the URL
$property_id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

if ($property_id > 0) {
    // Fetch property details from the property table
    $property_sql = "SELECT * FROM property WHERE property_id = $property_id";
    $property_result = mysqli_query($dbconnect, $property_sql);

    if ($property_result && mysqli_num_rows($property_result) > 0) {
        $property = mysqli_fetch_assoc($property_result);
        
        // Now fetch the owner details from the users table using owner_id
        $owner_id = $property['user_id']; // Assuming property table has an 'owner_id' column

        $owner_sql = "SELECT * FROM user WHERE user_id = $owner_id ";
        $owner_result = mysqli_query($dbconnect, $owner_sql);

        if ($owner_result && mysqli_num_rows($owner_result) > 0) {
            $owner = mysqli_fetch_assoc($owner_result);
        } else {
            echo "<p>Owner details not found.</p>";
        }
    } else {
        echo "<p>Property not found.</p>";
    }
} else {
    echo "<p>Invalid property ID.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Details</title>
    <link rel="stylesheet" href="property_details.css">
</head>
<body>
<div class="header">
<div class="logo">
           <a href="owner.php"> <img src="image/renteaselogo21.png" alt="Rentease Logo"></a>
        </div>
    <h1>PROPERTY DETAILS</h1>
    <div class=""></div>
      </div>
  </div>
    <?php if (isset($property) && isset($owner)): ?>

        <div class="property-details">
            <div class="pptyheading">
            <h1><?php echo $property['property_name']; ?></h1>
            </div>
            <img src="image/<?php echo $property['image']; ?>" alt="Property Image">
            <div class="propertycontents">
            <p><strong>Location:</strong> <?php echo $property['location']; ?></p>
            <p><strong>sqft:</strong> <?php echo $property['sqft']; ?> sqft</p>
            <p><strong>Bedrooms:</strong> <?php echo $property['bedroom']; ?></p>
            <p><strong>Bathrooms:</strong> <?php echo $property['bathroom']; ?></p>
            <p><strong>Price:</strong> ₹<?php echo $property['price']; ?>/month</p>
        </div>
        <h2>Owner Details:</h2>
        <div class="ownerdetails">
        <p><strong>Owner Name:</strong> <?php echo $owner['name']; ?></p>
        <p><strong>Owner Contact:</strong> <?php echo $owner['phno']; ?></p>
        </div>
        <div class="bookbutton">
            <!-- Booking Button -->
            <button onclick="confirmBooking(<?php echo $property['property_id']; ?>)">Book Property</button>

                <!-- // echo "<a href='property_details.php?id=".$property['property_id']."'><button>Book Property</button></a>"; -->
            
            </div>  
        </div>
    <?php else: ?>
        <p>Details not available.</p>
    <?php endif; ?>
    <script>
function confirmBooking(propertyId) {
    if (confirm("Pay a token amount of ₹1000 to book this property.")) {
        window.location.href = 'property_booking.php?property_id=' + propertyId;
    } else {
        alert("Booking canceled!");
    }
}
</script>

</body>
</html>

<?php
mysqli_close($dbconnect);
?>
