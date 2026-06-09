<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/commons/view.php';
require_once __DIR__ . '/inc/flash.php';
require_once __DIR__ . '/commons/validation.php';
require_once __DIR__ . '/commons/queries.php';
?>
