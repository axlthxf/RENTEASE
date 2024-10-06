<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="login.css" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LOGIN</title>
  </head>
  <body>
   <div class="section1">
    <div class="login">
      <a href="home.html">  <img src="./image/renteaselogo21.png" alt="Logo" /></a>
      <h1>Login</h1>
      <form action="" method="post">
        <div class="username">
          <label for="username">YOUR EMAIL</label>
          <input
            type="email"
            name="username"
            placeholder="example@gmail.com"
            required
          />
        </div>
        <div class="username">
          <label for="username">PASSWORD</label>
          <input
            type="password"
            name="password"
            placeholder="Password"
            required
          />
        </div>
        <div class="signin">
          <button name="submit" type="submit">Login</button>
        </div>
      </form>
      <p>Don't have an account? <a href="signup.php">Sign up</a></p>
    </div>
    <img src="./image/image 12.png" alt="">
  </div>
  </body>
</html>
<?php
session_start();
$dbconnect = mysqli_connect("localhost", "root", "", "rentease");

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $query = "SELECT * FROM `login` WHERE `email`='$username'";
    $result = mysqli_query($dbconnect, $query);
    
    $query1 = "SELECT * FROM `user` WHERE `email`='$username'";
    $result1 = mysqli_query($dbconnect, $query1);
    
    if ($result && $result1) {
        if (mysqli_num_rows($result) > 0 && mysqli_num_rows($result1) > 0) {
            $row = mysqli_fetch_assoc($result);
            $row1 = mysqli_fetch_assoc($result1);
            
            echo "<script>console.log('User Status: " . $row1['status'] . "');</script>";
            if ($row1['status'] === 'active') {
                
                if ($row['password'] == $password) {
                    
                    if ($row['user_type'] == 0) {
                      header('Location: user.php');  
                      exit();
                    } else if ($row['user_type'] == 1) {
                      $_SESSION['user'] =$row1['user_id'];
                        header("Location: owner.php");  
                        exit();
                    } else {
                        header('Location: admin.php');  
                        exit();
                    }
                    
                } else {
                    echo "<script>alert('Invalid username or password');</script>";
                }
                
            } else {
                echo "<script>alert('User is blocked');</script>";
            }
            
        } else {
            echo "<script>alert('Invalid username or password');</script>";
        }
    } else {
        echo "<script>alert('Error in query execution');</script>";
    }
}
?>
