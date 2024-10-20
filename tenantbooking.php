<?php
session_start();
$dbconnect = mysqli_connect("localhost", "root", "", "rentease");

if (!isset($_SESSION['tenant'])) {
    header("Location: login.php");
    exit();
}

$tenantid = $_SESSION['tenant'];

// Fetch the tenant's booking history
$bookingQuery = "SELECT * FROM bookings WHERE user_id = '$tenantid';";
$bookingResult = mysqli_query($dbconnect, $bookingQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - Rentease</title>
    <link rel="stylesheet" href="tenantbooking.css">
</head>
<body>
<div class="header">
        <div class="logo">
           <a href="owner.php"> <img src="image/renteaselogo21.png" alt="Rentease Logo"></a>
        </div>
        <div class="feedback-header">
        <h1>My Bookings</h1>
        </div>
        <div class=""></div>
      </div>

<div class="bookings-section">
   
    <div class="bookings-list">
        <?php if (mysqli_num_rows($bookingResult) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Property Name</th>
                        <th>Bedrooms</th>
                        <th>Bathrooms</th>
                        <th>Sqft</th>
                        <th>Location</th>
                        <th>Price (₹/month)</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($bookingrow = mysqli_fetch_assoc($bookingResult)): ?>
                        <?php
                        $property_id = $bookingrow['property_id'];
                        $propertyQuery = "SELECT * FROM property WHERE property_id = '$property_id'";
                        $propertyResult = mysqli_query($dbconnect, $propertyQuery);

                        if ($propertyResult && mysqli_num_rows($propertyResult) > 0) {
                            $propertyrow = mysqli_fetch_assoc($propertyResult);
                        ?>
                        <tr>
                            <td><?php echo $propertyrow['property_name']; ?></td>
                            <td><?php echo $propertyrow['bedroom']; ?></td>
                            <td><?php echo $propertyrow['bathroom']; ?></td>
                            <td><?php echo $propertyrow['sqft']; ?></td>
                            <td><?php echo $propertyrow['location']; ?></td>
                            <td>₹<?php echo $propertyrow['price']; ?></td>
                            <td><?php echo ucfirst($bookingrow['status']); ?></td>
                            <td>
                                <?php if ($bookingrow['status'] !== 'cancelled'): ?>
                                    <form method="POST" action="cancel_booking.php">
                                        <input type="hidden" name="booking_id" value="<?php echo $bookingrow['booking_id']; ?>">
                                        <button type="submit" class="cancel-button">Cancel Booking</button>
                                    </form>
                                <?php else: ?>
                                    <p class="canceled-msg">Canceled</p>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php
                        } else {
                            echo "<tr><td colspan='8'>Error fetching property details for booking ID: " . $bookingrow['booking_id'] . "</td></tr>";
                        }
                        ?>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You have no bookings.</p>
        <?php endif; ?>
    </div>
</div>

</body>

</html>

<?php
mysqli_close($dbconnect);
?>
