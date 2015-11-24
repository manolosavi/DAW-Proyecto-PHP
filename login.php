<?php
/**
 * Created by PhpStorm.
 * User: manolo
 * Date: 11/17/15
 * Time: 1:03 PM
 */
if ($_COOKIE['loggedIn']) {
    header("location: success.php");
    exit;
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="main.css">
    <title>Login</title>
</head>
<body>
<div id="main">
    <div class="wrapper">
        <h1 id="registered-msg"><?php echo $_GET["registered"] ?></h1>
        <h1>Login</h1>
        <form id="form" action="controller.php" onsubmit="return validate();" method="post">
            <p><input type="text" name="user" placeholder="Username"></p>
            <p><input type="password" name="password" placeholder="Password"></p>
            <p id="login-error"><?php echo $_GET["login-error"] ?></p>
            <div id="buttons">
                <input type="submit" name="action" value="Login">
            </div>
        </form>

        <h1>Not registered?</h1>
        <form action="register.php">
            <div id="buttons">
                <p><input type="submit" value="Register"></p>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    function validate() {
        var form = document.getElementById("form");
        if (!(form.user.value.indexOf(' ') === -1) || form.user.value.length == 0) {
            document.getElementById("login-error").innerHTML = "Invalid username";
            return false;
        }
        document.getElementById("login-error").innerHTML = "";

        return true;
    }
</script>
</body>
</html>
