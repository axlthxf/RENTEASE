<?php
session_start();
$dbconnect = mysqli_connect("localhost", "root", "", "rentease");

if (!$dbconnect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form was submitted and tenant session is set
$feedbackSubmitted = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])) {
    $user_id = $_SESSION['user']; // Use the tenant's session ID here
    $experience = mysqli_real_escape_string($dbconnect, $_POST['experience']);
    $description = mysqli_real_escape_string($dbconnect, $_POST['description']);

    // Insert feedback into the database
    $sql = "INSERT INTO feedback (user_id, experience, description) VALUES ('$user_id', '$experience', '$description')";
    
    if (mysqli_query($dbconnect, $sql)) {
        $_SESSION['message'] = "Feedback submitted successfully!";
        $feedbackSubmitted = true; // Flag to trigger the alert
    } else {
        echo "Error: " . mysqli_error($dbconnect);
    }
}

mysqli_close($dbconnect);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedback Submitted</title>
</head>
<body>
    <?php if ($feedbackSubmitted): ?>
        <script>
            alert("Thank you for your feedback! We appreciate your input and will use it to improve our services.");
            window.location.href = "owner.php"; // Redirect to user dashboard after feedback submission
        </script>
    <?php endif; ?>
</body>
</html>
