<?php
include('../../config/dbcon.php');

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Check if the 'image' file is set
  if (isset($_FILES['image'])) {
    $targetDir = "public/uploads/"; // Create a folder named 'uploads' in your project
    $targetFile = $targetDir . basename($_FILES['image']['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if the image file is a actual image or fake image
    if (isset($_POST['submit'])) {
      $check = getimagesize($_FILES['image']['tmp_name']);
      if ($check !== false) {
        $uploadOk = 1;
      } else {
        $uploadOk = 0;
      }
    }

    // Check if the file already exists
    if (file_exists($targetFile)) {
      $uploadOk = 0;
    }

    // Check file size
    if ($_FILES['image']['size'] > 500000) {
      $uploadOk = 0;
    }

    // Allow certain file formats
    if (
      $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif"
    ) {
      $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo json_encode(array('status' => 'error', 'message' => 'Image upload failed.'));
    } else {
      // If everything is ok, try to upload file
      if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        echo json_encode(array('status' => 'success', 'message' => 'Image uploaded successfully.', 'path' => $targetFile));
      } else {
        echo json_encode(array('status' => 'error', 'message' => 'Image upload failed.'));
      }
    }
  } else {
    echo json_encode(array('status' => 'error', 'message' => 'No image file received.'));
  }
} else {
  echo json_encode(array('status' => 'error', 'message' => 'Invalid request method.'));
}
