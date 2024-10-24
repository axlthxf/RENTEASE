<?php
session_start();
$dbconnect = mysqli_connect("localhost", "root", "", "rentease");

if (!isset($_SESSION['tenant'])) {
    header("Location: login.php");
    exit();
}
if (!isset($_SESSION['pptyname'] )) {
    $ptyname =$_SESSION['pptyname'] ;
}

if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];
    $tenantid = $_SESSION['tenant'];

    $token_amount = 1000; 

    $statusQuery = "SELECT status FROM bookings WHERE booking_id='$booking_id' AND user_id='$tenantid'";
    $statusResult = mysqli_query($dbconnect, $statusQuery);
    $statusRow = mysqli_fetch_assoc($statusResult);
    
    if ($statusRow && ($statusRow['status'] === 'accepted' || $statusRow['status'] === 'pending')) {
        $cancelQuery = "UPDATE bookings SET status='rejected' WHERE booking_id='$booking_id' AND user_id='$tenantid'";
        if (mysqli_query($dbconnect, $cancelQuery)) {
            $refundAmount = $token_amount * 0.7;

            $notificationMessage = "Your booking (ID: $booking_id) has been canceled. 70% of the token amount (₹" . round($refundAmount) . ") will be refunded.";
            $notificationQuery = "INSERT INTO notifications (user_id, message) VALUES ('$tenantid', '$notificationMessage')";
            mysqli_query($dbconnect, $notificationQuery);

            $_SESSION['cancellation_message'] = "Booking canceled successfully. You will receive 70% of the token amount as a refund.";
            header("Location: tenantbooking.php");
            exit();
        } else {
            $_SESSION['cancellation_message'] = "Error canceling the booking. Please try again.";
            header("Location: tenantbooking.php");
            exit();
        }
    } else {
        $_SESSION['cancellation_message'] = "You cannot cancel this booking.";
        header("Location: tenantbooking.php");
        exit();
    }
} else {
    header("Location: tenantbooking.php");
    exit();
}
?>
