<?php
include('../config/dbcon.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents('php://input'), true);

  $id = $data['id'];
  $currentPassword = $data['currentPassword'];
  $newPassword = password_hash($data['newPassword'], PASSWORD_DEFAULT); // Hash the new password
  $userType = $data['userType']; // 'user' or 'admin'

  // Choose the correct table based on user type
  $table = ($userType === 'admin') ? 'admins' : 'users';

  // Check if the user exists
  $query = "SELECT * FROM $table WHERE id = '$id'";
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $storedHashedPassword = $row['password']; // Replace 'password' with the actual field name in your database

    // Verify the current password
    if (password_verify($currentPassword, $storedHashedPassword)) {
      // Update the password
      $updateQuery = "UPDATE $table SET password = '$newPassword' WHERE id = '$id'";
      if ($conn->query($updateQuery) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Password updated successfully']);
      } else {
        echo json_encode(['success' => false, 'message' => 'Error updating password']);
      }
    } else {
      echo json_encode(['success' => false, 'message' => 'Invalid current password']);
    }
  } else {
    echo json_encode(['success' => false, 'message' => 'User not found']);
  }
} else {
  http_response_code(405);
  echo json_encode(['error' => 'Method not allowed']);
}

$conn->close();
