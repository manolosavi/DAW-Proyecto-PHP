<?php
/**
 * Created by PhpStorm.
 * User: manolo
 * Date: 11/17/15
 * Time: 1:03 PM
 */
if (!$_COOKIE["loggedIn"]) {
    header("location: login.php");
    exit;
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="main.css">
    <title>Logged In</title>
</head>
<body>
<div id="main">
    <div class="wrapper">
        <h1>You're currently logged in as: <?php echo $_COOKIE["username"] ?></h1>
        <form id="form" action="controller.php" method="post">
            <div id="buttons">
                <input type="submit" name="action" value="Log Out">
            </div>
        </form>
    </div>
</div>
</body>
</html>

