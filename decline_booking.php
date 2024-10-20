<?php
session_start();
$dbconnect = mysqli_connect("localhost", "root", "", "rentease");

if (isset($_SESSION['pptyname'])) {
    $propertyname = $_SESSION['pptyname'];
} else {
    die("Error: Property name is not set in the session.");
}

// Check if the user is logged in and has clicked the Decline button
if (isset($_GET['booking_id'])) {
    $booking_id = mysqli_real_escape_string($dbconnect, $_GET['booking_id']);

    // Get tenant details (email) from the booking record
    $bookingQuery = "SELECT user_id FROM bookings WHERE booking_id='$booking_id'";
    $bookingResult = mysqli_query($dbconnect, $bookingQuery);

    if (!$bookingResult) {
        // Output SQL error and stop script execution
        die("Error in booking query: " . mysqli_error($dbconnect));
    }

    $bookingRow = mysqli_fetch_assoc($bookingResult);
    $user_id = $bookingRow['user_id'];

    // Get tenant email address
    $userQuery = "SELECT email FROM user WHERE user_id='$user_id'";
    $userResult = mysqli_query($dbconnect, $userQuery);

    if (!$userResult) {
        // Output SQL error and stop script execution
        die("Error in user query: " . mysqli_error($dbconnect));
    }

    $userRow = mysqli_fetch_assoc($userResult);
    $tenant_email = $userRow['email'];

    // Update the booking status to 'declined'
    $updateQuery = "UPDATE bookings SET status='rejected' WHERE booking_id='$booking_id'";

    if (mysqli_query($dbconnect, $updateQuery)) {
        // Check if the status was updated successfully
        if (mysqli_affected_rows($dbconnect) > 0) {
            // Display an alert in the browser
            echo "<script>alert('Booking declined successfully. The tenant will be notified.');</script>";

            // Insert a notification into the notifications table
            $notificationMessage = "Your booking request (PROPERTY NAME: $propertyname) has been declined. The token amount of ₹1000 will be refunded within 5-7 working days.";
            $insertNotificationQuery = "INSERT INTO notifications (user_id, message) VALUES ('$user_id', '$notificationMessage')";
            mysqli_query($dbconnect, $insertNotificationQuery);

            // Redirect back to the dashboard
            header("Location: owner.php");
            exit();
        } else {
            echo "<script>alert('Error: No records updated. Please check the booking ID.');</script>";
        }
    } else {
        // Show SQL error if the query fails
        die("Error updating booking status: " . mysqli_error($dbconnect));
    }
} else {
    echo "Error: No booking ID provided.";
}
?>
