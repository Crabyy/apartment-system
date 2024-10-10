<?php

include('../../config/dbcon.php');

header('Content-Type: application/json');

// Check if room_id is set in the request
if (isset($_POST['room_id'])) {
    $room_id = intval($_POST['room_id']);
    $room_name = $_POST['room_name'];
    $description = $_POST['description'];
    $price = floatval($_POST['price']);
    $imagePath = '';

    // Check if an image was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $uploadFileDir = './uploads/';
        $dest_path = $uploadFileDir . $fileName;

        // Move the uploaded file
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $imagePath = $dest_path;
        } else {
            echo json_encode(['success' => false, 'message' => 'Error uploading image']);
            exit;
        }
    } else {
        // If no new image was uploaded, retain the old image path
        $sql = "SELECT imagePath FROM room WHERE room_id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('i', $room_id);
            $stmt->execute();
            $stmt->bind_result($currentImagePath);
            $stmt->fetch();
            $imagePath = $currentImagePath;
            $stmt->close();
        }
    }

    // Update the room data in the database
    $sql = "UPDATE room SET room_name = ?, description = ?, price = ?, imagePath = ? WHERE room_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('ssdsi', $room_name, $description, $price, $imagePath, $room_id);

        // Execute the query
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Room updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error updating room: ' . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error preparing statement']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid room ID']);
}

$conn->close();
