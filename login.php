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
    $dbconnect=mysqli_connect("localhost","root","","rentease");
    if(isset($_POST['submit']))
  {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = "SELECT * FROM `login` WHERE `email`='$username' AND `password`='$password'";
    $result = mysqli_query($dbconnect, $query);
    if($result){
    $row=mysqli_num_rows($result);
    if ($row['user_type']==0)
    {
      header('Location: user.html');  
      exit();
    }
    else if($row['user_type']==1)
    {
      header('Location: owner.html');  
      exit();
    }
    else{
      header('Location: admin.html'); 
    }
  }
  else{
    echo "<script>alert('Invalid username or password')</script>";
  }
  }
?>
