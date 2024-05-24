<?php
include('../../config/dbcon.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  // Get the authentication token from the request
  $authToken = $_GET['authToken']; // Adjust this based on how your frontend sends the token

  // Validate the token (you may want to implement a more secure validation)
  // For simplicity, let's assume the token is the user's ID
  $loggedInUserId = (int)$authToken; // Convert the token to an integer, adjust this based on your authentication mechanism

  // Fetch details for the logged-in user
  $sql = "SELECT givenname, middlename, surname, email, username, contactnumber, birthdate, gender FROM users WHERE id = $loggedInUserId";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $userDetails = $result->fetch_assoc();
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'data' => $userDetails]);
  } else {
    echo json_encode(['success' => false, 'message' => 'User not found']);
  }
}

$conn->close();
