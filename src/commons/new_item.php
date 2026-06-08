<?php
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
        if (validate_table_column($_POST['table'], $_POST['column'])) {
            $sql = "";
            $quantity = 0;
            $name = "New item";
            if ($_POST['parent_id'] != "null" && $_POST['column'] == "item_id") {
                $sql = "SELECT * FROM pantry_item WHERE id=? limit 1";
                $query = $conn->prepare($sql);
                $query->bind_param("i", $_POST['parent_id']);
                $query->execute();
                $name = $query->get_result()->fetch_assoc()['name'];
                $sql = "INSERT INTO {$_POST['table']} (owner_id, {$_POST['column']}, name, quantity) VALUES (?, ?, ?, 1)";
                $query = $conn->prepare($sql);
                $query->bind_param("iis", $_SESSION['user'], $_POST['parent_id'], $name);
                $quantity = 1;
            } else {
                if ($_POST['column'] == "item_id") {
                    $sql = "INSERT INTO {$_POST['table']} (owner_id, {$_POST['column']}, name, quantity) VALUES (?, NULL, 'New item', 0)";
                    $query = $conn->prepare($sql);
                    $query->bind_param("i", $_SESSION['user']);
                } else {
                    $sql = "INSERT INTO {$_POST['table']} ({$_POST['column']}, name, quantity) VALUES (?, 'New item', 0)";
                    $query = $conn->prepare($sql);
                    $query->bind_param("i", $_POST['parent_id']);
                }
            }
            if ($query->execute()) {
                $result = $query->insert_id;
                echo json_encode(['status' => 'success', 'id' => $result, 'item_name' => $name, 'quantity' => $quantity]);
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