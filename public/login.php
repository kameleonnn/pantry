<?php
require_once __DIR__ . '/../src/bootstrap.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../src/login.php';
    exit;
}
?>

<?php view('header', ['title' => 'Log in - Pantry']) ?>
<main>
    <form id="login" action="/login.php" method="post">
        <h1>Welcome back!</h1>
        <?php flash() ?>
        <div>
            <label for="email">E-mail</label><br>
            <input type="email" name="email">
        </div>
        <div>
            <label for="password">Password</label><br>
            <input type="password" name="password">
        </div>
        <input type="submit" value="Sign in"><br>
        <span>New user? <a href="/register">Create an account</a></span>
    </form>
</main>
<?php view('footer') ?>