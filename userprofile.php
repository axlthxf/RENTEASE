<?php
session_start();
$dbconnect = mysqli_connect("localhost", "root", "", "rentease");

if (isset($_SESSION['tenant'])) {
    $user_id = $_SESSION['tenant']; 
} else {
    header("Location: login.php");
    exit();
}

if ($dbconnect->connect_error) {
    die("Connection failed: " . $dbconnect->connect_error);
}

// If the form was submitted, update the tenant's profile
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($dbconnect, $_POST['name']);
    $email = mysqli_real_escape_string($dbconnect, $_POST['email']);
    $phone = mysqli_real_escape_string($dbconnect, $_POST['phone']);
    
    // Update tenant details in the database
    $updateQuery = "UPDATE user SET name='$name', email='$email', phno='$phone' WHERE user_id='$user_id'";
    
    if (mysqli_query($dbconnect, $updateQuery)) {
        // Redirect to profile page with success message
        $_SESSION['message'] = "Profile updated successfully.";
        header("Location: userprofile.php");
        exit();
    } else {
        echo "Error updating profile: " . mysqli_error($dbconnect);
    }
}

// Fetch tenant details to populate the form
$sql = "SELECT * FROM user WHERE user_id = $user_id";
$result = mysqli_query($dbconnect, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $tenant = mysqli_fetch_assoc($result);
} else {
    echo "Error fetching tenant details.";
    exit();
}

mysqli_close($dbconnect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Profile</title>
    <link rel="stylesheet" href="userprofile.css">
</head>
<body>
<div class="header">
        <div class="logo">
           <a href="user.php"> <img src="image/renteaselogo21.png" alt="Rentease Logo"></a>
        </div>
        <div class="feedback-header">
        <h1>Tenant Profile</h1>
        </div>
        <div class=""></div>
      </div>
    <div class="profile-container">
        

        <!-- Display success message after profile update -->
        <?php if (isset($_SESSION['message'])): ?>
            <p style="color:green;"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
        <?php endif; ?>

        <!-- Profile form -->
        <form method="POST" action="userprofile.php">
            <label for="name">Name:</label>
            <div class="input-group">
                <input type="text" id="name" name="name" value="<?php echo $tenant['name']; ?>" readonly>
                <button type="button" class="edit-btn" onclick="editField('name')">✏️</button>
            </div>

            <label for="email">Email:</label>
            <div class="input-group">
                <input type="email" id="email" name="email" value="<?php echo $tenant['email']; ?>" readonly>
                <button type="button" class="edit-btn" onclick="editField('email')">✏️</button>
            </div>

            <label for="phone">Phone:</label>
            <div class="input-group">
                <input type="text" id="phone" name="phone" value="<?php echo $tenant['phno']; ?>" readonly>
                <button type="button" class="edit-btn" onclick="editField('phone')">✏️</button>
            </div>

            <!-- Save button -->
            <button type="submit">Save Changes</button>
        </form>
    </div>

    <script>
        // Function to enable editing for a field
        function editField(fieldId) {
            document.getElementById(fieldId).removeAttribute('readonly');
        }
    </script>
</body>
</html>
