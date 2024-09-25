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


<?php
    $dbconnect=mysqli_connect("localhost","root","","rentease");
    if(isset($_POST['submit']))
    {
      $fullname = $_POST['Fullname'];
      $phonenumber = $_POST['phonenumber'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      $confirm_password = $_POST['confirm_password'];
      $usertype = $_POST['selectuser'];
      if($usertype == 'User'){
        $type=0;
        $status="active";
      }
      else{
        $type=1;
        $status="active";
      }

      
      if($password == $confirm_password)
      {
        $query = "INSERT INTO user (name, phno, email, password,status,usertype) VALUES ('$fullname', '$phonenumber', '$email', '$password','$status', '$usertype')";
        $query1 = "INSERT INTO `login`(`email`, `password`, `user_type`) VALUES ('$email', '$password','$type' )";
        $data= mysqli_query($dbconnect, $query);
         mysqli_query($dbconnect, $query1);
         echo "Registration Successful!";  
         header('Location: login.php');
      }
      else
      {
        echo "Passwords do not match!";
      }

      if($data)
      {
        echo "<script>alert('data inserted successfully')</script>";
      }
     
    }
    ?>
