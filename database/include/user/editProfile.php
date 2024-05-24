<?php
include('../../config/dbcon.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents('php://input'), true);

  $givenname = $data['givenname'];
  $middlename = $data['middlename'];
  $surname = $data['surname'];
  $email = $data['email'];
  $username = $data['username'];
  $contactnumber = $data['contactnumber'];
  $birthdate = $data['birthdate'];
  $gender = $data['gender'];
  $id = $data['id'];

  $query = "UPDATE users SET
              givenname = '$givenname',
              middlename = '$middlename',
              surname = '$surname',
              email = '$email',
              username = '$username',
              contactnumber = '$contactnumber',
              birthdate = '$birthdate',
              gender = '$gender'
              WHERE id = '$id'";

  if ($conn->query($query) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
  } else {
    echo json_encode(['success' => false, 'message' => 'Error updating profile']);
  }
} else {
  http_response_code(405);
  echo json_encode(['error' => 'Method not allowed']);
}

$conn->close();
