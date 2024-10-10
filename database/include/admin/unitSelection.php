<?php
include('../../config/dbcon.php');

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Handle GET and POST requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  // Fetch available units
  $conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

  if ($conn->connect_error) {
    http_response_code(500);
    header("Content-Type: application/json");
    echo json_encode(['error' => 'Connection failed: ' . $conn->connect_error]);
  } else {
    $stmt = $conn->prepare("SELECT id, unitname, unitno, unitposition, unitprice, unittype FROM units WHERE status = 1");

    if (!$stmt) {
      echo json_encode(['error' => 'Prepare failed: ' . $conn->error]);
      $conn->close();
      exit;
    }

    if (!$stmt->execute()) {
      echo json_encode(['error' => 'Execute failed: ' . $stmt->error]);
      $stmt->close();
      $conn->close();
      exit;
    }

    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    header("Content-Type: application/json");
    echo json_encode($result);

    $stmt->close();
    $conn->close();
  }

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Handle unit acquisition
  $input = json_decode(file_get_contents('php://input'), true);

  if (isset($input['action']) && $input['action'] === 'acquire' && isset($input['unitId']) && isset($input['userId'])) {
    $conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    if ($conn->connect_error) {
      http_response_code(500);
      header("Content-Type: application/json");
      echo json_encode(['error' => 'Connection failed: ' . $conn->connect_error]);
      exit;
    }

    // Update the unit status to 'acquired' and assign it to the user
    $stmt = $conn->prepare("UPDATE units SET status = 0, acquired_by = ? WHERE id = ?");
    if (!$stmt) {
      echo json_encode(['error' => 'Prepare failed: ' . $conn->error]);
      $conn->close();
      exit;
    }

    $stmt->bind_param('ii', $input['userId'], $input['unitId']);
    if (!$stmt->execute()) {
      echo json_encode(['error' => 'Execute failed: ' . $stmt->error]);
      $stmt->close();
      $conn->close();
      exit;
    }

    echo json_encode(['message' => 'Unit acquired successfully']);

    $stmt->close();
    $conn->close();
  } else {
    http_response_code(400);
    header("Content-Type: application/json");
    echo json_encode(['error' => 'Invalid request']);
  }
} else {
  http_response_code(400);
  header("Content-Type: application/json");
  echo json_encode(['error' => 'Invalid request']);
}
?>
