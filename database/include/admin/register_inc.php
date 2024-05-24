<?php
include('../../config/dbcon.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $requestData = json_decode(file_get_contents('php://input'), true);

  $username = $requestData['username'];
  $email = $requestData['email'];

  $conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

  if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Connection failed: ' . $conn->connect_error]);
    exit();
  }

  $query = "SELECT COUNT(*) as count FROM admins WHERE LOWER(username) = LOWER(?) OR LOWER(email) = LOWER(?)";
  $stmt = $conn->prepare($query);

  if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Prepare statement failed: ' . $conn->error]);
    exit();
  }

  $stmt->bind_param("ss", $username, $email);
  $stmt->execute();

  if ($stmt->errno) {
    http_response_code(500);
    echo json_encode(['error' => 'Execution failed: ' . $stmt->error]);
    exit();
  }

  $result = $stmt->get_result()->fetch_assoc();

  echo json_encode(['exists' => $result['count'] > 0]);

  $stmt->close();
  $conn->close();
} else {
  http_response_code(400);
  echo json_encode(['error' => 'Invalid request']);
}