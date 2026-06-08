<?php
require __DIR__ . '/../bootstrap.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['user'])) {
        if ($conn->connect_error) {
            echo json_encode(['status' => 'connection_error', 'msg' => 'Connection failed. Try again later.']);
            exit();
        }
        $query = $conn->prepare(NEW_PANTRY);
        $query->bind_param("i", $_SESSION['user']);
        if ($query->execute()) {
            $result = $query->insert_id;
            echo json_encode(['status' => 'success', 'id' => $result, 'pantry_name' => 'New Pantry']);
            exit();

        } else {
            echo json_encode(['status' => 'generic_err', 'msg' => 'An unexpected error occurred.']);
            exit();
        }
    } else {
        echo json_encode(['status' => 'unauthorized', 'msg' => 'Unauthorized operation.']);
        exit();
    }
}