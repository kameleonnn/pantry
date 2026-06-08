<?php
require_once __DIR__ . '/../src/bootstrap.php';
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
switch ($request) {
    case '/':
    case '':
        require __DIR__ . '/../src/inc/home.php'; 
        break;
    case '/register':
        require __DIR__ . '/../src/register.php';
        break;
    case '/login':
        require __DIR__ . '/../src/login.php';
        break;
    default:
        http_response_code(404);
        echo "404 - Page Not Found";
        break;
}
?>
<?php view('header') ?>
<?php
if (isset($_SESSION['user'])) {
    view('dashboard', ['title' => 'Dashboard - Pantry']);
} else {
    view('landing', ['title' => 'Welcome to Pantry']);
}
?>

<?php view('footer') ?>