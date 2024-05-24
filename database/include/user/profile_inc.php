<?php
include('../../config/dbcon.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  // Fetch all users
  $sql = "SELECT givenname, middlename, surname, email, username, contactnumber, birthdate, gender FROM users";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $userList = [];
    while ($row = $result->fetch_assoc()) {
      $userList[] = $row;
    }
    echo json_encode(['success' => true, 'data' => $userList]);
  } else {
    echo json_encode(['success' => false, 'message' => 'No users found']);
  }
}

$conn->close();
