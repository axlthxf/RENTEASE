<?php
// Database connection
$dbconnect = mysqli_connect("localhost", "root", "", "rentease");

if (!$dbconnect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch booking details
$sql_bookings = "SELECT * FROM bookings";
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
    <link rel="stylesheet" href="ManageBooking.css" />
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

        <a href="login.php">Log out</a>
      </div>
      <!-- <hr> -->
    </div>
  </div>
    <div class="content">
        <table>
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Property Name</th>
                    <th>Owner Name</th>
                    <th>Tenant Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($bookings)) : ?>
                    <tr>
                        <td colspan="5">No bookings found.</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($bookings as $booking) : ?>
                        <tr>
                            <td><?php echo $booking['booking_id']; ?></td>
                            <?php
                            // Fetch property details
                            $property_id = $booking['property_id'];
                            $sql_properties = "SELECT * FROM property WHERE property_id='$property_id'";
                            $result_properties = mysqli_query($dbconnect, $sql_properties);
                            $property_name = '';

                            if ($result_properties) {
                                $property = mysqli_fetch_assoc($result_properties);
                                $property_name = $property['property_name'];
                                $owner_id = $property['user_id'];
                            }

                            // Fetch owner details
                            $sql_owners = "SELECT * FROM user WHERE user_id='$owner_id'";
                            $result_owners = mysqli_query($dbconnect, $sql_owners);
                            $owner_name = '';

                            if ($result_owners) {
                                $owner = mysqli_fetch_assoc($result_owners);
                                $owner_name = $owner['name'];
                            }

                            // Fetch tenant details
                            $tenant_id = $booking['user_id'];
                            $sql_tenants = "SELECT * FROM user WHERE user_id='$tenant_id'";
                            $result_tenants = mysqli_query($dbconnect, $sql_tenants);
                            $tenant_name = '';

                            if ($result_tenants) {
                                $tenant = mysqli_fetch_assoc($result_tenants);
                                $tenant_name = $tenant['name'];
                            }
                            ?>
                            <td><?php echo $property_name; ?></td>
                            <td><?php echo $owner_name . " (ID: $owner_id)"; ?></td> 
                             <td><?php echo $tenant_name . " (ID: $tenant_id)"; ?></td>
                            <td><?php echo $booking['status']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
