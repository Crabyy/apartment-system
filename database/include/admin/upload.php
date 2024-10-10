<?php
include('../../config/dbcon.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_name = $_POST['room_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $bannerTitle = $_POST['bannerTitle']; // Add this line

    // Handle file upload
    if (isset($_FILES['image'])) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $uploadFileDir = 'uploads/';
        $dest_path = $uploadFileDir . $fileName;

        if(move_uploaded_file($fileTmpPath, $dest_path)) {
            $imagePath = $dest_path; // Store the path in the database
        } else {
            echo json_encode(['success' => false, 'message' => 'Error uploading image']);
            exit;
        }
    }

    // Insert into the database
    $sql = "INSERT INTO room (room_name, description, price, imagePath, bannerTitle) VALUES (?, ?, ?, ?, ?)"; // Updated query
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('sssss', $room_name, $description, $price, $imagePath, $bannerTitle); // Bind bannerTitle
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error inserting room: ' . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error preparing statement: ' . $conn->error]);
    }
}

$conn->close();
?>
