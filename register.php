<?php
/**
 * Created by PhpStorm.
 * User: elaela
 * Date: 24.11.2015
 * Time: 15:22
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
    <title>Register</title>
</head>
<body>
<div id="main">
    <div class="wrapper">
        <h1>Register</h1>
        <form id="formR" action="controller.php" onsubmit="return validateR();" method="post">
            <p><input type="text" name="user" placeholder="Username" onkeyup="checkAvailability()" onblur="checkAvailability()"></p>
            <p><input type="password" name="password" placeholder="Password" onblur="checkPasswordLength();checkAvailability()"></p>
            <p><input type="password" name="password2" placeholder="Re-type password" onblur="checkPasswordMatch();checkAvailability()"</p></p>
            <p id="register-error"><?php echo $_GET["register-error"] ?></p>
            <div id="buttons">
                <input type="submit" name="action" value="Register">
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    function validateR() {
        if (document.getElementById("register-error").innerHTML != "") {
            return false;
        }

        var form = document.getElementById("formR");
        if (!(form.user.value.indexOf(' ') === -1) || form.user.value.length == 0) {
            document.getElementById("register-error").innerHTML = "Invalid username.";
            return false;
        }

        if (!checkEmail()) {
            return false;
        }

        if (!checkPasswordLength()) {
            return false;
        }

        if (!checkPasswordMatch()) {
            return false;
        }

        document.getElementById("register-error").innerHTML = "";

        return true;
    }

    function checkPasswordLength() {
        var form = document.getElementById("formR");
        if (form.password.value.length < 8) {
            document.getElementById("register-error").innerHTML = "Password is too short.";
            return false;
        }
        document.getElementById("register-error").innerHTML = "";
        return true;
    }

    function checkPasswordMatch() {
        var form = document.getElementById("formR");
        if (form.password.value != form.password2.value) {
            document.getElementById("register-error").innerHTML = "Passwords don't match.";
            return false;
        }
        document.getElementById("register-error").innerHTML = "";
        return true;
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
                    //document.getElementById("formR").submit();
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
