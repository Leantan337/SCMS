<?php
include '../includes/connection.php';

// Employee data retrieval
$emp_ID = $_POST['emp_ID'];
$fname = $_POST['firstname'];
$lname = $_POST['lastname'];
$gen = $_POST['gender'];
$email = $_POST['email'];
$phone = $_POST['phonenumber'];
$jobb = $_POST['jobs'];
$hdate = $_POST['hireddate'];
$prov = $_POST['province'];
$cit = $_POST['city'];

// Image upload handling
$target_dir = "../uploads/employees/"; // Replace with your desired directory
$imageUploaded = false;

if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
  $target_file = $target_dir . uniqid('', true) . "." . pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
  $uploadOk = true;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  // Image validation logic (unchanged)

  // If everything is ok, try to upload file
  if ($uploadOk) {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
      echo "The file " . basename($_FILES["image"]["name"]) . " has been uploaded.";
      $imageUploaded = true;
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
}

// Prepare location insert
$location_sql = "INSERT INTO location (LOCATION_ID, PROVINCE, CITY) VALUES (Null,'$prov','$cit')";

// Insert location
$location_result = mysqli_query($db, $location_sql);

// Check for location insert success
if ($location_result) {
  $last_location_id = mysqli_insert_id($db); // Get the newly inserted location ID

  // Prepare employee insert with image handling
  $employee_sql = "INSERT INTO employee (EMPLOYEE_ID,emp_ID, FIRST_NAME, LAST_NAME,GENDER, EMAIL, PHONE_NUMBER, JOB_ID, HIRED_DATE, LOCATION_ID";
  if ($imageUploaded) {
    $employee_sql .= ", IMAGE"; // Add image column if upload successful
  }
  $employee_sql .= ") VALUES (Null,'{$emp_ID}','{$fname}','{$lname}','{$gen}','{$email}','{$phone}','{$jobb}','{$hdate}',$last_location_id";
  if ($imageUploaded) {
    $employee_sql .= ",'$target_file'"; // Add image filename if uploaded
  }
  $employee_sql .= ")";

  $employee_result = mysqli_query($db, $employee_sql);

  // Check for employee insert success
  if ($employee_result) {
    header('location:employee.php'); // Redirect on success
  } else {
    echo "Error adding employee: " . mysqli_error($db);
  }
} else {
  echo "Error adding location: " . mysqli_error($db);
}

// Remove the extra closing quotation mark
?>
