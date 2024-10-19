<?php
session_start();
$dbconnect = mysqli_connect("localhost", "root", "", "rentease");

// Check if the user is logged in and has clicked the Accept button
if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];
    
    // Update the booking status to 'accepted'
    $query = "UPDATE bookings SET status='accepted' WHERE booking_id='$booking_id'";
    
    if (mysqli_query($dbconnect, $query)) {
        echo "<script>alert('Booking accepted successfully!');</script>";
        
        // Optionally, update the property's status to 'occupied'
        $property_id_query = "SELECT property_id FROM bookings WHERE booking_id='$booking_id'";
        $property_id_result = mysqli_query($dbconnect, $property_id_query);
        $property_row = mysqli_fetch_assoc($property_id_result);
        $property_id = $property_row['property_id'];

        $update_property_query = "UPDATE property SET status='occupied' WHERE property_id='$property_id'";
        mysqli_query($dbconnect, $update_property_query);

        header("Location: owner.php"); // Redirect back to the dashboard
        exit();
    } else {
        echo "<script>alert('Error accepting booking. Please try again.');</script>";
    }
}
?>
