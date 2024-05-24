<?php
include '../../config/dbcon.php';

// Get the input data
$data = json_decode(file_get_contents('php://input'), true);
$unitno = isset($data['unitno']) ? $data['unitno'] : null;

// Initialize the response array
$response = array();

if ($unitno !== null) {
  // Check if the unit number exists
  $query = "SELECT * FROM units WHERE unitno = ?";
  $stmt = $conn->prepare($query);

  if ($stmt) {
    $stmt->bind_param('s', $unitno);
    $stmt->execute();
    $stmt->store_result();

    $response['exists'] = $stmt->num_rows > 0;

    $stmt->close();
  } else {
    $response['error'] = 'Failed to prepare the statement.';
  }
} else {
  $response['error'] = 'Unit number not provided.';
}

// Send the JSON response
echo json_encode($response);
