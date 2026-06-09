<?php
require_once __DIR__ . '/src/bootstrap.php';
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