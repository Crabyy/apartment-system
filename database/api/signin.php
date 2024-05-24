<?php

include('../config/dbcon.php');

$username = $_POST['username'];
$password = $_POST['password'];

$sqlUser = "SELECT * FROM users WHERE username = ?";
$stmtUser = $conn->prepare($sqlUser);
$stmtUser->bind_param("s", $username);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();

$sqlAdmin = "SELECT * FROM admins WHERE username = ?";
$stmtAdmin = $conn->prepare($sqlAdmin);
$stmtAdmin->bind_param("s", $username);
$stmtAdmin->execute();
$resultAdmin = $stmtAdmin->get_result();

$response = array("success" => false, "message" => "Invalid ID or Password");

if ($resultUser->num_rows > 0) {
  $row = $resultUser->fetch_assoc();

  if (password_verify($password, $row['password'])) {
    $response = array("success" => true, "message" => "User login successful", "userData" => $row, "userType" => "user");
  } else {
    $response = array("success" => false, "message" => "Invalid ID or Password");
  }
}

if (!$response['success'] && $resultAdmin->num_rows > 0) {
  $rowAdmin = $resultAdmin->fetch_assoc();

  if (password_verify($password, $rowAdmin['password'])) {
    $response = array("success" => true, "message" => "Admin login successful", "userData" => $rowAdmin, "userType" => "admin");
  } else {
    $response = array("success" => false, "message" => "Invalid ID or Password for Admin");
  }
}

echo json_encode($response);

$stmtUser->close();
$stmtAdmin->close();
$conn->close();
