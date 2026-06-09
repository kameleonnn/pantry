<?php
require_once __DIR__ . 'bootstrap.php';
$previous = "/../login.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email'], $_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        if ($conn->connect_error) {
            flash('connection_error', 'Connection failed. Try again later.', FLASH_ERROR);
            header("location: $previous");
            exit();
        }
        $user_exists = $conn->prepare("SELECT * FROM users WHERE email=?");
        $user_exists->bind_param("s", $email);
        if ($user_exists->execute()) {
            $result = $user_exists->get_result();
            if ($result->num_rows === 1) {
                $hash = $result->fetch_assoc();
                if (password_verify($password, $hash['password'])) {
                    $_SESSION['user'] = $hash['id'];
                    $_SESSION['name'] = $hash['name'];
                    header("location: /");
                    exit();
                } else {
                    flash('incorrect_pass', 'Incorrect password.', FLASH_ERROR);
                    header("location: /login.php");
                    exit();
                }
            } else {
                flash('invalid_user', 'User does not exist.', FLASH_ERROR);
                header("location: /login.php");
                exit();
            }
        } else {
            flash('generic_err', 'Sorry, an unexpected error occured. Try again', FLASH_ERROR);
            header("location: /login.php");
            exit();
        }
    } else {
        flash('empty_form', 'Please fill out the form.', FLASH_ERROR);
        header("location: /login.php");
        exit();
    }
}