<?php
include('../../config/dbcon.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if 'userId' exists in the GET request
    if (isset($_GET['userId'])) {
        $userId = $_GET['userId'];

        $conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

        if ($conn->connect_error) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Connection failed']);
        } else {
            // Fetch only the units acquired by the user
            $stmt = $conn->prepare("SELECT id, unitname, unitno, unitprice FROM units WHERE acquired_by = ?");
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            echo json_encode(['success' => true, 'acquiredUnits' => $result]);

            $stmt->close();
            $conn->close();
        }
    } else {
        // userId not provided in the request
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'userId parameter missing']);
    }
} else {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
