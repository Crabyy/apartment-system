<?php
include('../../config/dbcon.php');

header('Content-Type: application/json');

// Fetch all rooms
$sql = "SELECT room_id, room_name, description, price, imagePath, bannerTitle FROM room";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $rooms = [];
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
    }
    echo json_encode(['success' => true, 'rooms' => $rooms]);
} else {
    echo json_encode(['success' => false, 'message' => 'No rooms found']);
}

$conn->close();
?>
