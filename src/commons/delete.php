<?php
require_once __DIR__ . '/../bootstrap.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
        if (validate_table($_POST['table'])) {
            $sql = "DELETE FROM {$_POST['table']} WHERE id=?";
            $query = $conn->prepare($sql);
            $query->bind_param("i", $_POST['id']);
            if ($query->execute()) {
                echo json_encode(['status' => 'success']);
                exit();
            } else {
                echo json_encode(['status' => 'generic_err', 'msg' => 'An unexpected error occurred.']);
                exit();
            }
        } else {
            http_response_code(400);
            echo json_encode(["status" => "err_400"]);
            exit();
        }
    } else {
        echo json_encode(['status' => 'unauthorized', 'msg' => 'Unauthorized operation.']);
        exit();
    }
}
