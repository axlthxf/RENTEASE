<?php
session_start();  // Start the session to access session variables

// Connect to the database
$dbconnect = mysqli_connect("localhost", "root", "", "rentease");
if ($dbconnect->connect_error) {
    die("Connection failed: " . $dbconnect->connect_error);
}

// Get the tenant's user_id from session
if (isset($_SESSION['tenant'])) {
    $user_id = $_SESSION['tenant'];  // Get the tenant's user ID
} else {
    // If not logged in, redirect to login or show error
    header("Location: login.php");
    exit();
}

// Get the property ID from the URL
$property_id = isset($_GET['property_id']) ? intval($_GET['property_id']) : 0;

if ($property_id > 0) {
    // Dummy payment form handling
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Simulate successful payment process
        $payment_method = $_POST['payment_method'];

        if ($payment_method == 'card') {
            // Validate card details if card is chosen
            $card_number = $_POST['card_number'];
            $expiry_date = $_POST['expiry_date'];
            $cvv = $_POST['cvv'];

            // Simulate card validation and process payment
            if ($card_number && $expiry_date && $cvv) {
                // Proceed with booking and insert into bookings table
                $booking_date = date('Y-m-d H:i:s'); // Current timestamp
                $booking_sql = "INSERT INTO bookings (user_id, property_id, booking_date) VALUES ($user_id, $property_id, '$booking_date')";

                if (mysqli_query($dbconnect, $booking_sql)) {
                    $_SESSION['payment_status'] = 'Payment successful! You have successfully booked the property.';
                    header("Location: user.php");
                    exit();
                } else {
                    echo "Error: Could not complete booking. " . mysqli_error($dbconnect);
                }
            } else {
                echo "Please fill in all card details.";
            }
        } elseif ($payment_method == 'gpay' || $payment_method == 'paytm') {
            // Simulate Google Pay or Paytm payment success
            $booking_date = date('Y-m-d H:i:s'); // Current timestamp
            $booking_sql = "INSERT INTO bookings (user_id, property_id, booking_date) VALUES ($user_id, $property_id, '$booking_date')";

            if (mysqli_query($dbconnect, $booking_sql)) {
                $_SESSION['payment_status'] = 'Payment successful! You have successfully booked the property.';
                header("Location: user.php");
                exit();
            } else {
                echo "Error: Could not complete booking. " . mysqli_error($dbconnect);
            }
        } else {
            echo "Invalid payment method selected.";
        }
    }
} else {
    echo "<p>Invalid property ID.</p>";
}

mysqli_close($dbconnect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link rel="stylesheet" href="booking.css">
</head>
<body>
<div class="payment-container">
        <h1>Make Payment</h1>
        <p>Please pay a token amount of ₹1000 to complete the booking.</p>
        
        <form method="POST" action="">
            <label for="payment_method">Choose Payment Method:</label>
            <select id="payment_method" name="payment_method" required>
                <option value="">Select Payment Method</option>
                <option value="card">Credit/Debit Card</option>
                <option value="gpay">Google Pay</option>
                <option value="paytm">Paytm</option>
            </select><br>

            <div id="card_details" class="payment-details">
                <label for="card_number">Card Number:</label>
                <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9123 4567"><br>

                <label for="expiry_date">Expiry Date:</label>
                <input type="month" id="expiry_date" name="expiry_date"><br>

                <label for="cvv">CVV:</label>
                <input type="text" id="cvv" name="cvv" placeholder="123"><br>
            </div>

            <div id="gpay_details" class="payment-details" style="display:none;">
                <p>Please open Google Pay and scan the QR code below to complete the payment:</p>
                <img src="image/rentease_gpay_qr.png" alt="GPay QR Code" style="width: 200px;"><br>
                <p><strong>After scanning, click the "Confirm Payment" button below.</strong></p>
            </div>

            <div id="paytm_details" class="payment-details" style="display:none;">
                <p>Please open Paytm and scan the QR code below to complete the payment:</p>
                <img src="image/rentease_gpay_qr.png" alt="Paytm QR Code" style="width: 200px;"><br>
                <p><strong>After scanning, click the "Confirm Payment" button below.</strong></p>
            </div>

            <button type="submit" class="pay-button">Confirm Payment</button>
        </form>
    </div>

    <script>
        // Handle payment method selection to show/hide details
        document.getElementById('payment_method').addEventListener('change', function() {
            var method = this.value;
            var cardDetails = document.getElementById('card_details');
            var gpayDetails = document.getElementById('gpay_details');
            var paytmDetails = document.getElementById('paytm_details');
            
            // Hide all sections by default
            cardDetails.style.display = 'none';
            gpayDetails.style.display = 'none';
            paytmDetails.style.display = 'none';

            // Show relevant details based on selected payment method
            if (method === 'card') {
                cardDetails.style.display = 'block';
            } else if (method === 'gpay') {
                gpayDetails.style.display = 'block';
            } else if (method === 'paytm') {
                paytmDetails.style.display = 'block';
            }
        });
    </script>
</body>
</html>