<?php
session_start();
$dbconnect = mysqli_connect("localhost", "root", "", "rentease");
if (isset($_SESSION['tenant'])) {
  $user_id = $_SESSION['tenant']; 
} 
if ($dbconnect->connect_error) {
    die("Connection failed: " . $dbconnect->connect_error);
}


$property_id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

if ($property_id > 0) {
    $property_sql = "SELECT * FROM property WHERE property_id = $property_id";
    $property_result = mysqli_query($dbconnect, $property_sql);

    if ($property_result && mysqli_num_rows($property_result) > 0) {
        $property = mysqli_fetch_assoc($property_result);
        
        $owner_id = $property['user_id']; 

        $owner_sql = "SELECT * FROM user WHERE user_id = $owner_id ";
        $owner_result = mysqli_query($dbconnect, $owner_sql);

        if ($owner_result && mysqli_num_rows($owner_result) > 0) {
            $owner = mysqli_fetch_assoc($owner_result);
        } else {
            echo "<p>Owner details not found.</p>";
        }
        $booking_sql = "SELECT status FROM bookings WHERE property_id = $property_id ";
        $booking_result = mysqli_query($dbconnect, $booking_sql);

        if ($booking_result && mysqli_num_rows($booking_result) > 0) {
            $booking = mysqli_fetch_assoc($booking_result);
            $booking_status = $booking['status']; 
        } else {
            $booking_status = 'rejected'; 
        }
$active_booking_sql = "SELECT status FROM bookings WHERE user_id = $user_id AND (status = 'accepted' OR status = 'pending')";
$active_booking_result = mysqli_query($dbconnect, $active_booking_sql);

$has_active_booking = (mysqli_num_rows($active_booking_result) > 0);
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
           <a href="user.php"> <img src="image/renteaselogo21.png" alt="Rentease Logo"></a>
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
        <?php if ($has_active_booking): ?>
        <p style="color:red;"><strong>You already have an active booking.</strong></p>
    <?php elseif ($booking_status == 'accepted' || $booking_status == 'pending'): ?>
        <p style="color:red;"><strong>Property is already booked.</strong></p>
    <?php else: ?>
        <button onclick="confirmBooking(<?php echo $property['property_id']; ?>)">Book Property</button>
    <?php endif; ?>
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
