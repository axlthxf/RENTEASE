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

// Fetch tenant details from the database
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
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <div class="profile-container">
        <h1>Tenant Profile</h1>

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

            <!-- <label for="address">Address:</label>
            <div class="input-group">
                <input type="text" id="address" name="address" value="<?php echo $tenant['address']; ?>" readonly>
                <button type="button" class="edit-btn" onclick="editField('address')">✏️</button>
            </div> -->

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

    <style>
        .profile-container {
            width: 50%;
            margin: auto;
            background: #f4f4f4;
            padding: 20px;
            border-radius: 10px;
        }

        .input-group {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .input-group input {
            flex: 1;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .input-group .edit-btn {
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 18px;
            margin-left: 10px;
        }

        .profile-container button[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</body>
</html>
