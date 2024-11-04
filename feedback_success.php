<?php
session_start();
$dbconnect = mysqli_connect("localhost", "root", "", "rentease");

if (!$dbconnect) {
    die("Connection failed: " . mysqli_connect_error());
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['tenant']) && isset($_SESSION['user'])) {
    $user_id = $_SESSION['tenant'];
    $user_id = $_SESSION['user'];
    $experience = mysqli_real_escape_string($dbconnect, $_POST['experience']);
    $description = mysqli_real_escape_string($dbconnect, $_POST['description']);

    $sql = "INSERT INTO feedback (user_id, experience, description) VALUES ('$user_id', '$experience', '$description')";
    
    if (mysqli_query($dbconnect, $sql)) {
        $_SESSION['message'] = "Feedback submitted successfully!";
        header("Location: feedback_success.php"); 
        exit();
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
    <script>
        alert("Thank you for your feedback! We appreciate your input and will use it to improve our services.");
        window.location.href = "feedback.php"; 
    </script>
</body>
</html>
