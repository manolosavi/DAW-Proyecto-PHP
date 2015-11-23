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
        <h1>Login</h1>
        <form id="form" action="controller.php" onsubmit="return validate();" method="post">
            <p><input type="text" name="user" placeholder="Username"> <span id="response"></span></p>
            <p><input type="password" name="password" placeholder="Password"></p>
            <p id="login-error"><?php echo $_GET["login-error"] ?></p>
            <div id="buttons">
                <input type="submit" name="action" value="Login">
            </div>
        </form>

        <h1>Register</h1>
        <form id="formR" action="controller.php" onsubmit="return validateR() || shouldSubmit;" method="post">
            <p><input type="text" name="user" placeholder="Username"> <span id="response"></span></p>
            <p><input type="password" name="password" placeholder="Password"></p>
            <p id="register-error"><?php echo $_GET["register-error"] ?></p>
            <div id="buttons">
                <input type="submit" name="action" value="Register">
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    function validate() {
        var form = document.getElementById("form");
        if (!(form.user.value.indexOf(' ') === -1) || form.user.value.length == 0) {
            document.getElementById("error").innerHTML = "Invalid username";
            return false;
        }
        if (form.password.value.length < 8) {
            document.getElementById("error").innerHTML = "Password is too short.";
            return false;
        }
        document.getElementById("error").innerHTML = "";

        return true;
    }

    var shouldSubmit = false;

    function validateR() {
        checkAvailability();
        return false;
    }

    function checkAvailability() {
        input = document.getElementById("formR").user;
        value = input.value;

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4) {
                if (xmlhttp.responseText == "valid") {
                    document.getElementById("register-error").innerHTML = "";
                    shouldSubmit = true;
                    document.getElementById("formR").submit();
                } else {
                    document.getElementById("register-error").innerHTML = xmlhttp.responseText;
                    shouldSubmit = false;
                }
            }
        };

        xmlhttp.open("GET", "controller.php?username="  +  value, true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send();
    }
</script>
</body>
</html>
