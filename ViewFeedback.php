<?php
// Database connection
$dbconnect = mysqli_connect("localhost", "root", "", "rentease");

if (!$dbconnect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch booking details
$sql_bookings = "SELECT * FROM feedback";
$result_bookings = mysqli_query($dbconnect, $sql_bookings);

$bookings = [];
if ($result_bookings) {
    while ($row = mysqli_fetch_assoc($result_bookings)) {
        $bookings[] = $row; // Store each booking record
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="ViewFeedback.css" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Bookings</title>
</head>
<body>
<div class="header">
    <h1>LANDLORDS</h1>
  </div>
  <div class="menu">
    <div class="logo">
      <a href="admin.php"> <img src="./image/renteaseadmin-removebg-preview1.png" alt=""></a>
      <!-- <hr> -->
    </div>
    <div class="sidebar">
 
      <div class="options">
        <a href="Manageowner.php">Manage Landlords</a>
      </div>
      <div class="options">

        <a href="Tenant.php">Manage Tenants</a>
      </div>
      <div class="options">
  
  <a href="ManageBooking.php">Manage Bookings</a>
</div>
      <div class="options">
  
  <a href="ViewFeedback.php">View Feedback</a>
</div>
      <div class="options">

        <a href="login.php">Log out</a>
      </div>
      <!-- <hr> -->
    </div>
  </div>
<div class="content">
    <table>
        <thead>
            <tr>
                <th>Feedback Id</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Experience</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($bookings)) : ?>
                <tr>
                    <td colspan="5">No feedback found.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($bookings as $booking) : ?>
                    <tr>
                        <td><?php echo $booking['id']; ?></td>
                        <?php
                        $owner_id = $booking['user_id'];
                        $sql_owners = "SELECT * FROM user WHERE user_id='$owner_id'";
                        $result_owners = mysqli_query($dbconnect, $sql_owners);
                        $owner_name = '';
                        $owner_email = '';

                        if ($result_owners) {
                            $owner = mysqli_fetch_assoc($result_owners);
                            $owner_name = $owner['name'];
                            $owner_email = $owner['email'];
                        }
                        ?>
                        
                        <td><?php echo $owner_name . " (ID: $owner_id)"; ?></td>
                        <td><?php echo $owner_email; ?></td>
                        <td><?php echo $booking['experience']; ?></td>
                        <td><?php echo $booking['description']; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
