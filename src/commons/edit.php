<?php
require_once __DIR__ . '/../bootstrap.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['user'])) {
        if ($conn->connect_error) {
            echo json_encode(['status' => 'connection_error', 'msg' => 'Connection failed. Try again later.']);
            exit();
        }
        if (validate_table_column($_POST['table'], $_POST['column'])) {
            $param = "";
            if ($_POST['table'] == "shopping_list") {
                $param = ", item_id=NULL";
            }
            $sql = "UPDATE {$_POST['table']} SET {$_POST['column']} =? {$param} WHERE id=?";
            $query = $conn->prepare($sql);
            $query->bind_param("si", $_POST['val'], $_POST['id']);
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