<?php
session_start();
$dbconnect = mysqli_connect("localhost", "root", "", "rentease");

if (!$dbconnect) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $fullname = trim($_POST['Fullname']);
    $phonenumber = trim($_POST['phonenumber']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $usertype = $_POST['selectuser'];

    // Set user type and status
    $type = ($usertype === 'User') ? 0 : 1;
    $status = "active";

    // Phone number validation (assume a 10-digit phone number)
    if (!preg_match('/^[0-9]{10}$/', $phonenumber)) {
        echo "<script>alert('Invalid phone number format. Must be 10 digits.')</script>";
    }
    // Email format validation
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.')</script>";
    }
    // Check if email already exists
    elseif (mysqli_num_rows(mysqli_query($dbconnect, "SELECT * FROM user WHERE email='$email'")) > 0) {
        echo "<script>alert('Email is already registered.')</script>";
    }
    // Password strength validation
    elseif (strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[!@#$%^&*]/', $password)) {
        echo "<script>alert('Password must be at least 8 characters long and include at least one letter, one number, and one special character.')</script>";
    }
    // Confirm password validation
    elseif ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!')</script>";
    }
    else {
        // Insert data if all validations pass
        $query = "INSERT INTO user (name, phno, email, password, status, usertype) VALUES ('$fullname', '$phonenumber', '$email', '$password', '$status', '$usertype')";
        $query1 = "INSERT INTO login (email, password, user_type) VALUES ('$email', '$password', '$type')";

        if (mysqli_query($dbconnect, $query) && mysqli_query($dbconnect, $query1)) {
            echo "<script>alert('Registration Successful!'); window.location.href = 'login.php';</script>";
        } else {
            echo "<script>alert('Error in registration. Please try again.')</script>";
        }
    }
}

mysqli_close($dbconnect);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="signup.css" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>signup</title>
  </head>
  <body>
    <div class="section2">
      <div class="signup">
       <a href="home.html"> <img src="./image/renteaselogo21.png" alt=""></a>
        <h1>Sign up</h1>
        <div class="section">
          <form action="" method="post">
            <div class="form">
              <input
                type="text"
                name="Fullname"
                placeholder="Fullname"
                required
              />
            </div>
            <div class="form">
              <input
                type="number"
                name="phonenumber"
                placeholder="phonenumber"
                required
              />
            </div>
            <div class="form">
              <input type="email" name="email" placeholder="Email" required />
            </div>
            <div class="selection">
            <select name="selectuser" id="">
              <option value="" disabled selected required>Select User Type</option>
              <option value="User">User</option>
              <option value="Owner">Owner</option>
            </select>
            </div>
            <div class="form">
              <input
                type="password"
                name="password"
                placeholder="Password"
                required
              />
            </div>
            <div class="form">
              <input
                type="password"
                name="confirm_password"
                placeholder="Confirm Password"
                required
              />
            </div>
            <div class="button">
              <button name="submit" type="submit">Submit</button>
            </div>
          </form>
          <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
      </div>
    </div>
  </body>
</html>
