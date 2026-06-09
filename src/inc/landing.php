<?php
require_once __DIR__ . '/../bootstrap.php';
?>
<?php view('header', ['title' => 'Welcome to Pantry']) ?>
<main>
    <div id="landing">
        <h1>Shopping made easy.</h1>
        <h3><span class="brand">Pantry</span> lets you save time, money and reduce food
            waste<!-- - now powered by our state-of-the-art AI technology-->.</h3>
        <button id="signup" onclick="window.location.href='register.php'">Sign up now!</button>
        <p>Already a member? <a href="/login">Log in</a></p>
        <!--<button onclick="window.location.href='login.php'">Log in</button>
        <button onclick="window.location.href='register.php'">Register</button>-->
    </div>
</main>
<?php view('footer') ?>