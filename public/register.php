<?php
require_once __DIR__ . '/../src/bootstrap.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../src/register.php';
    exit;
}
?>

<?php view('header', ['title' => 'Register - Pantry']) ?>
<?php ?>
<main>  
    <form id="register" action="/register.php" method="post">
        <h1>Welcome to<span class="brand">Pantry</span>!</h1>
        <?php flash() ?>
        <div>
            <label for="email">E-mail</label><br>
            <input type="email" name="email" required>
        </div>
        <div>
            <label for="name">Name</label><br>
            <input type="text" name="name" required>
        </div>
        <div>
            <label for="password">Password</label><br>
            <input type="password" name="password" required>
        </div>
        <div>
            <label for="passconfirm">Confirm password</label><br>
            <input type="password" name="passconfirm" required>
        </div>
        <div>
            <label for="tos">
                <input type="checkbox" name="tos" value="yes" required> I agree to the Pantry <a href=""
                    title="terms of service"> terms of services</a>
            </label>
        </div>
        <input type="submit" value="Register"><br>
        <span>Already have an account? <a href="/login">Log in</a></span>
    </form>
</main>
<?php view('footer') ?>