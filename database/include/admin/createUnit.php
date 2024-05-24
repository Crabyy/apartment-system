<?php

include('../../config/dbcon.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $requestData = json_decode(file_get_contents('php://input'), true);

  $unitname = $requestData['unitname'];
  $unitno = $requestData['unitno'];
  // $unitstatus = $requestData['unitstatus'];
  $unitposition = $requestData['unitposition'];
  $unitprice = $requestData['unitprice'];
  $unittype = $requestData['unittype'];

  // Check if unitno already exists
  $checkExistingQuery = "SELECT id FROM units WHERE unitno = '$unitno'";
  $result = $conn->query($checkExistingQuery);

  if ($result->num_rows > 0) {
    // Unitno already exists, send an error response
    echo json_encode(['success' => false, 'message' => 'Unit with the same unitno already exists.']);
  } else {
    // Unitno doesn't exist, proceed with insertion
    $status = 1;

    $sql = "INSERT INTO units (unitname, unitno, unitposition, unitprice, unittype, status) VALUES ('$unitname', '$unitno', '$unitposition', '$unitprice', '$unittype', '$status')";

    if ($conn->query($sql) === TRUE) {
      echo json_encode(['success' => true]);
    } else {
      echo json_encode(['success' => false, 'message' => 'Error creating unit: ' . $conn->error]);
    }
  }
}

$conn->close();