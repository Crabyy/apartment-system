<?php
include('../../config/dbcon.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Get room_id from the URL query parameter
    $room_id = isset($_GET['room_id']) ? intval($_GET['room_id']) : null;

    if ($room_id) {
        // Prepare the SQL DELETE statement
        $sql = "DELETE FROM room WHERE room_id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('i', $room_id);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    // Return success response
                    echo json_encode(['success' => true, 'message' => 'Room removed successfully.']);
                } else {
                    // No rows affected means the room_id was not found
                    echo json_encode(['success' => false, 'message' => 'Room not found.']);
                }
            } else {
                // Return error message with the statement error
                echo json_encode(['success' => false, 'message' => 'Error executing delete: ' . $stmt->error]);
            }
            $stmt->close();
        } else {
            // Return error message with the connection error
            echo json_encode(['success' => false, 'message' => 'Error preparing statement: ' . $conn->error]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Room ID not provided.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

$conn->close();
?>
  