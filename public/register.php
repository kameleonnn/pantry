<?php
require_once __DIR__ . '/../src/bootstrap.php';
?>

<?php view('header', ['title' => 'Register - Pantry']) ?>
<?php ?>
<main>  
    <form id="register" action="/../src/register.php" method="post">
        <h1>Welcome to<span class="brand">Pantry</span>!</h1>
        <?php flash() ?>
        <div>
            <label for="email">E-mail</label><br>
            <input type="email" name="email" require>
        </div>
        <div>
            <label for="name">Name</label><br>
            <input type="text" name="name" require>
        </div>
        <div>
            <label for="password">Password</label><br>
            <input type="password" name="password" require>
        </div>
        <div>
            <label for="passconfirm">Confirm password</label><br>
            <input type="password" name="passconfirm" require>
        </div>
        <div>
            <label for="tos">
                <input type="checkbox" name="tos" value="yes" require> I agree to the Pantry <a href=""
                    title="terms of service"> terms of services</a>
            </label>
        </div>
        <input type="submit" value="Register"><br>
        <span>Already have an account? <a href="/login">Log in</a></span>
    </form>
</main>
<?php view('footer') ?>