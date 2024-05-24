<?php

include('../../config/dbcon.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $requestData = json_decode(file_get_contents('php://input'), true);

  $givenname = $requestData['givenname'];
  $middlename = $requestData['middlename'];
  $surname = $requestData['surname'];
  $email = $requestData['email'];
  $username = $requestData['username'];
  $password = password_hash($requestData['password'], PASSWORD_DEFAULT);
  $contactnumber = $requestData['contactnumber'];
  $birthdate = $requestData['birthdate'];
  $gender = $requestData['gender'];

  $role = 'user';
  $status = '1';

  $sql = "INSERT INTO users ( role, status, givenname, middlename, surname, email, username, password, contactnumber, birthdate, gender) VALUES ( '$role', '$status', '$givenname', '$middlename', '$surname', '$email', '$username', '$password', '$contactnumber', '$birthdate', '$gender')";

  if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
  } else {
    echo json_encode(['success' => false, 'message' => 'Error during registration: ' . $conn->error]);
  }
}

$conn->close();
