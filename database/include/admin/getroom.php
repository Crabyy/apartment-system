<?php
include('../../config/dbcon.php');

header('Content-Type: application/json');

// Get the room ID from the query parameter
$room_id = isset($_GET['room_id']) ? intval($_GET['room_id']) : 0;

if ($room_id > 0) {
    $sql = "SELECT * FROM room WHERE room_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $room_id); // Correct the bind_param parameter type
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            echo json_encode(['success' => true, 'room' => $row]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Room not found']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error preparing statement']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid room ID']);
}

$conn->close();
?>
