<?php
/**
 * Created by PhpStorm.
 * User: manolo
 * Date: 11/17/15
 * Time: 3:31 PM
 */

include_once("User.php");

if( $_SERVER['REQUEST_METHOD'] == 'GET'){
    if (isset($_GET['username'])){
        checkUsername();
    }
    else{
        getUserData();
    }
}
else{
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
            break;
    }
}

function register() {
    ini_set('display_errors', 1);
    session_start();
    $conn = new mysqli('localhost', 'root', '', 'login');
    if ($conn->connect_errno > 0) {
        die('Unable to connect to database [' . $conn->connect_error . ']');
    }
    $username = $conn->real_escape_string($_POST["user"]);
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = 'SELECT hash FROM `users` WHERE username = \''.$username.'\'';
    $rs = $conn->query($sql);
    if ($rs->num_rows != 0) {
        header("location: login.php?register-error=Username not available");
        exit;
    }

    //$subject = "Welcome";
    //$text = "You have successfully logged in to our site. \n Username: " .$username;

    //mail($email, $subject, $text); //send email to person logging in

//  A higher "cost" is more secure but consumes more processing power
    $cost = 10;
//  Create a random salt
    $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');

//  Prefix information about the hash so PHP knows how to verify it later.
//  "$2a$" Means we're using the Blowfish algorithm. The following two digits are the cost parameter.
    $salt = sprintf("$2a$%02d$", $cost) . $salt;

//  Hash the password with the salt
    $hash = crypt($password, $salt);
    $sql = 'INSERT INTO users (username, email, hash) values (\''.$username.'\', \''.$email.'\', \''.$hash.'\')';
    if (!$conn->query($sql)) {
        echo "Error: (".$conn->errno.") ".$conn->error;
    }

    header("location: login.php?registered=You just registered. Now login.");

    exit;
}

function login() {
    ini_set('display_errors', 1);
    session_start();
    $conn = new mysqli('localhost', 'root', '', 'login');
    if ($conn->connect_errno > 0) {
        die('Unable to connect to database [' . $conn->connect_error . ']');
    }
    $username = $conn->real_escape_string($_POST["user"]);
    $passwordEntered = $_POST["password"];

    $sql = 'SELECT hash FROM `users` WHERE username = \''.$username.'\' LIMIT 1';
    $rs = $conn->query($sql);
    if ($rs->num_rows == 0) {
        header("location: login.php?login-error=Incorrect username");
        exit;
    }
    if ($row = mysqli_fetch_array($rs)) {
        $DBHash = $row["hash"];
//      Hashing the password with its hash as the salt returns the same hash
        if ( hash_equals(crypt($passwordEntered, $DBHash), $DBHash) ) {
            setcookie("loggedIn", $username, time()+3600);
            header("location: controller.php?action=success");
        } else {
            header("location: login.php?login-error=Incorrect password");
        }
        exit;
    }
}

function logout() {
    setcookie("loggedIn", false, time()-1);
    header("location: login.php");
    exit;
}

function checkUsername(){
    $conn = new mysqli('localhost', 'root', '', 'login');
    if ($conn->connect_errno > 0) {
        die('Unable to connect to database [' . $conn->connect_error . ']');
    }

    $username = $_GET["username"];

    $sql = 'SELECT username FROM `users` WHERE username = \''.$username.'\'';
    $rs = $conn->query($sql);
    if ($rs->num_rows == 0) {
        echo "valid";
        return;
    } else {
        echo "Username already in use.";
        return;
    }
}

function getUserData(){
    $conn = new mysqli('localhost', 'root', '', 'login');
    if ($conn->connect_errno > 0) {
        die('Unable to connect to database [' . $conn->connect_error . ']');
    }

    $username = $_COOKIE["loggedIn"];
    $sql = 'SELECT username, email FROM `users` WHERE username = \''.$username.'\'';
    $rs = $conn->query($sql);
    if ($rs->num_rows == 0) {
        echo "Invalid cookie";
        return;
    }
    if ($row = mysqli_fetch_array($rs)) {
        $DBUsername = $row["username"];
        $DBemail = $row["email"];
    }

    $user = new User($DBUsername, $DBemail);
    //include 'success.php';

    header("location: success.php?username=" .$user->username. "&email=".$user->email);
    return;

}
?>