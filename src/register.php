<?php
require __DIR__ . '/bootstrap.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $previous = "/../register.php";
    if (isset($_POST['email'], $_POST['name'], $_POST['password'], $_POST['passconfirm'], $_POST['tos'])) {
        $email = $_POST['email'];
        $name = $_POST['name'];
        $password = $_POST['password'];
        $pass_conf = $_POST['passconfirm'];
        $tos_consent = $_POST['tos'];
        // validate form data
        if (validate_form($email, $name, $password, $pass_conf, $tos_consent)) {
            // hash password
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $register = "SELECT id from users where email='".$email."'";
            // Check connection
            if ($conn->connect_error) {
                flash('connection_error', 'Connection failed. Try again later.', FLASH_ERROR);
                header("location: $previous");
                die();
            }
            // Check if user already exists
            if ($conn->query($register)->num_rows == 0) {
                // Create new user
                $register = $conn->prepare(REGISTER);
                $register->bind_param("sssi", $email, $name, $password, $tos_consent);
                if ($register->execute()) {
                    flash('reg_success', 'Your account was created succesfully. Please <a href="login.php">log in</a> to use your Pantry account.', FLASH_SUCCESS);
                    header("location: $previous");
                    exit();
                } else {
                    flash('generic_err', 'Sorry, an unexpected error occured. Try again', FLASH_ERROR);
                    header("location: $previous");
                    exit();
                }
            } else {
                flash('reg_user_exists_err', 'This account already exists.', FLASH_ERROR);
                header("location: $previous");
                exit();
            }

            $conn->close();
        } else {
            header("location: $previous");
            exit();
        }
    } else {
        flash('reg_empty_form', 'Please fill out all the information.', FLASH_ERROR);
        header("location: $previous");
        exit();
    }

}
