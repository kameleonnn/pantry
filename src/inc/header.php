<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Pantry' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style.css">
</head>

<body>
    <header>
        <h1><a class="brand" href="index.php">Pantry</a></h1>
        <div id="buttons">
            <?php
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if (!isset($_SESSION['user'])) {
                echo '<button onclick="window.location.href=`/../login.php`">Log in</button><button onclick="window.location.href=`/../register.php`">Register</button>';
            } else {
                echo '<!--<button>Setings</button>-->
            <button onclick="window.location.href=`/src/logout.php`">Log out</button>';
            }
            ?>

        </div>
    </header>