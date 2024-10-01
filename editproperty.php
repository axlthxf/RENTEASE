<?php
session_start();


if (isset($_SESSION['user'])) {
  $user_id = $_SESSION['user'];
} else {
  header("Location: login.php");
  exit();
}

// Initialize $property as an empty array to avoid undefined errors
$property = [];

if (isset($_GET['property_id'])) {
  $dbconnect = mysqli_connect("localhost", "root", "", "rentease");
  $property_id = $_GET['property_id'];

  // Fetch the property details based on the property ID
  $sql = "SELECT * FROM `property` WHERE `property_id` = '$property_id' AND `user_id` = '$user_id'";
  $result = mysqli_query($dbconnect, $sql);

  if (mysqli_num_rows($result) > 0) {
    $property = mysqli_fetch_assoc($result); // Fetch property details
  } else {
    echo "Property not found!";
    exit();
  }
} else {
  echo "No property ID provided!";
  exit();
}

if (isset($_POST['update'])) {
  $property_name = $_POST['property_name'];
  $property_number = $_POST['property_number'];
  $location = $_POST['location'];
  $price = $_POST['price'];
  $bedroom = $_POST['bedroom'];
  $bathroom = $_POST['bathroom'];
  $sqft = $_POST['sqft'];

  // Handle image upload
  if ($_FILES['property_image']['name']) {
    $property_image = $_FILES['property_image']['name'];
    $target_dir = "image/";
    $target_file = $target_dir . basename($property_image);

    // Move the uploaded file to the server
    if (move_uploaded_file($_FILES["property_image"]["tmp_name"], $target_file)) {
      $image_update_query = "`image` = '$property_image',";
    } else {
      echo "<script>alert('Failed to upload new image. Keeping the old one.');</script>";
      $image_update_query = ""; // Don't update image if upload fails
    }
  } else {
    // No new image uploaded, keep the old image
    $image_update_query = "";
  }

  // Update the property details in the database
  $update_query = "UPDATE `property` SET 
                      `property_name`='$property_name',
                      `property_number`='$property_number',
                      `location`='$location',
                      `price`='$price',
                      `bedroom`='$bedroom',
                      `bathroom`='$bathroom',
                      `sqft`='$sqft',
                      $image_update_query
                      `status` = 'vacant'
                    WHERE `property_id`='$property_id' AND `user_id`='$user_id'";

  if (mysqli_query($dbconnect, $update_query)) {
    echo "<script>alert('Property updated successfully!'); window.location.href='owner.php';</script>";
  } else {
    echo "<script>alert('Error updating property.');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="property.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Property</title>
  <link rel="stylesheet" href="path-to-your-css-file.css">
</head>
<body>
<div class="header">
        <div class="logo">
           <a href="owner.php"> <img src="image/renteaselogo21.png" alt="Rentease Logo"></a>
        </div>
        <div class="feedback-header">
            <!-- <h1>Feedback Form</h1> -->
        </div>
        <div class=""></div>
      </div>
  <div class="section2">
    <div class="signup">
      <h1>Edit Property</h1>
      <form action="" method="post" enctype="multipart/form-data">
        
        <div class="form">
          <input
            type="text"
            name="property_name"
            placeholder="Property Name"
            value="<?php echo $property['property_name']; ?>"
            required
          />
        </div>

        <div class="form">
          <input
            type="number"
            name="property_number"
            placeholder="Property Number"
            value="<?php echo $property['property_number']; ?>"
            required
          />
        </div>

        <div class="form">
          <input
            type="text"
            name="location"
            placeholder="Location"
            value="<?php echo $property['location']; ?>"
            required
          />
        </div>

        <div class="form">
          <input
            type="number"
            name="price"
            placeholder="Price"
            value="<?php echo $property['price']; ?>"
            required
          />
        </div>

        <div class="form">
          <input
            type="number"
            name="bedroom"
            placeholder="Bedroom"
            value="<?php echo $property['bedroom']; ?>"
            required
          />
        </div>

        <div class="form">
          <input
            type="number"
            name="bathroom"
            placeholder="Bathroom"
            value="<?php echo $property['bathroom']; ?>"
            required
          />
        </div>

        <div class="form">
          <input
            type="number"
            name="sqft"
            placeholder="Square Feet"
            value="<?php echo $property['sqft']; ?>"
            required
          />
        </div>

        <!-- Show current image -->
        <div class="form">
          <label for="current_image">Current Image:</label><br>
          <img src="image/<?php echo $property['image']; ?>" alt="Property Image" style="width:150px;">
        </div>

        <!-- Image Upload -->
        <div class="form">
          <input
            type="file"
            id="property_image"
            name="property_image"
            accept="image/*"
          />
        </div>

        <div class="button">
          <button name="update" type="submit">Update Property</button>
        </div>

      </form>
    </div>
  </div>
</body>
</html>
