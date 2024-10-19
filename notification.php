<?php
session_start();
$dbconnect = mysqli_connect("localhost", "root", "", "rentease");
if (isset($_SESSION['tenant'])) {
    $tenantid = $_SESSION['tenant'];
}
// Fetch all notifications for the logged-in tenant
$notificationsQuery = "SELECT message, created_at FROM notifications WHERE user_id='$tenantid' ORDER BY created_at DESC";
$notificationsResult = mysqli_query($dbconnect, $notificationsQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="notification.css">
</head>
<body>
<div class="notification-list">
    <h3>Notifications</h3>
    <ul>
        <?php while ($row = mysqli_fetch_assoc($notificationsResult)): ?>
            <li>
                <p><?php echo $row['message']; ?></p>
                <small><?php echo $row['created_at']; ?></small>
            </li>
        <?php endwhile; ?>
    </ul>
</div>
<?php
$updateReadStatusQuery = "UPDATE notifications SET is_read=1 WHERE user_id='$tenantid' AND is_read=0";
mysqli_query($dbconnect, $updateReadStatusQuery);

?>
</body>
</html>


