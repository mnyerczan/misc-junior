<main id="login-form">
    <form action="<?=BACKSTEP?>login" method="POST">
        <p>Please Sign In</p>
        <label for="login-name">User name:</label>
        <input id="login-name" type="text" name="loginName">
        <label for="password">Password:</label>
        <input id="password" type="password" name="password">
        <div id="submit-container">
            <input id="login-submit" type="submit" value="Enter" name="login-submit">
        </div>
    </form>
</main>
<h3 class="feedback"><?= $errorMsg ?? "" ?></h3>