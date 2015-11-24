<?php
/**
 * Created by PhpStorm.
 * User: manolo
 * Date: 11/17/15
 * Time: 3:31 PM
 */

switch ($_POST["action"]) {
case "Register":
    register();
    break;
case "Login":
    login();
    break;
case "Log Out":
    logout();
    break;
default:
//    ajax function
    if ($_GET["username"]) {
        checkUsername();
        break;
    }
    break;
}

function register() {
//    database connection
    ini_set('display_errors', 1);
    session_start();
    $conn = new mysqli('localhost', 'root', '', 'login');
    if ($conn->connect_errno > 0) {
        die('Unable to connect to database [' . $conn->connect_error . ']');
    }
    $username = $conn->real_escape_string($_POST["user"]);
    $password = $_POST["password"];

    $sql = 'SELECT hash FROM `users` WHERE username = \''.$username.'\'';
    $rs = $conn->query($sql);
    if ($rs->num_rows != 0) {
        header("location: register.php?register-error=Username not available");
        exit;
    }

//  A higher "cost" is more secure but consumes more processing power
    $cost = 10;
//  Create a random salt
    $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');

//  Prefix information about the hash so PHP knows how to verify it later.
//  "$2a$" Means we're using the Blowfish algorithm. The following two digits are the cost parameter.
    $salt = sprintf("$2a$%02d$", $cost) . $salt;

//  Hash the password with the salt and save to database
    $hash = crypt($password, $salt);
    $sql = 'INSERT INTO users (username, hash) values (\''.$username.'\', \''.$hash.'\')';
    if (!$conn->query($sql)) {
        echo "Error: (".$conn->errno.") ".$conn->error;
    }

//    redirect to login page
    header("location: login.php?registered=Registration successful.");

    exit;
}

function login() {
//    database connection
    ini_set('display_errors', 1);
    session_start();
    $conn = new mysqli('localhost', 'root', '', 'login');
    if ($conn->connect_errno > 0) {
        die('Unable to connect to database [' . $conn->connect_error . ']');
    }

//    remove special characters from username
    $username = $conn->real_escape_string($_POST["user"]);
    $passwordEntered = $_POST["password"];

    $sql = 'SELECT hash FROM `users` WHERE username = \''.$username.'\' LIMIT 1';
    $rs = $conn->query($sql);
    if ($rs->num_rows == 0) {
//        redirect to login, username was incorrect
        header("location: login.php?login-error=Incorrect username");
        exit;
    }
    if ($row = mysqli_fetch_array($rs)) {
        $DBHash = $row["hash"];
//      Hashing the password with its hash as the salt returns the same hash, verifying the password was correct
        if ( hash_equals(crypt($passwordEntered, $DBHash), $DBHash) ) {
//            verified, set cookies for logged in
            setcookie("loggedIn", true, time()+3600);
            setcookie("username", $username, time()+3600);
            header("location: success.php");
        } else {
//            password incorrect, redirect to login page
            header("location: login.php?login-error=Incorrect password");
        }
        exit;
    }
}

function logout() {
//    delete cookies to log out, redirect to login page
    setcookie("loggedIn", false, time()-1);
    setcookie("username", false, time()-1);
    header("location: login.php");
    exit;
}

function checkUsername() {
//    database connection
    $conn = new mysqli('localhost', 'root', '', 'login');
    if ($conn->connect_errno > 0) {
        die('Unable to connect to database [' . $conn->connect_error . ']');
    }

    $username = $_GET["username"];

    $sql = 'SELECT username FROM `users` WHERE username = \''.$username.'\'';
    $rs = $conn->query($sql);
    if ($rs->num_rows == 0) {
//        username is not in database
        echo "valid";
        return;
    } else {
//        username already in database
        echo "Username already in use.";
        return;
    }
}
?>