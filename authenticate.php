<?php
// start session
session_start();
include_once 'validate.php';
$user = test_input($_POST['user']);
$pwd = test_input($_POST['pwd']);


// TODO: make sure username and password have at least one character
if (strlen($user) < 1 || strlen($pwd) < 1) {
    $_SESSION['error'] = "Username and password connot be empty";
    header("location:index.php");
}
// login to the softball database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "softball";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// select password from users where username = <what the user typed in>
$sql = "SELECT password FROM users WHERE username = '$user'";
$result = $conn->query($sql);
// if no rows, then username is not valid (but don't tell Mallory) just send
// her back to the login
if ($result->num_rows > 0) {
    if ($row = $result->fetch_assoc()) {
        // test the end user's password against the hash in the db
        if (password_verify($pwd, $row['password'])) {
            $verified = 1;
        } else {
            $verified = 0;
        }

        if ($verified) {
            $_SESSION['username'] = $user;
            $_SESSION['error'] = '';
        } else {
            $_SESSION['error'] = 'invalid username or password';
        }
    }
} else {
    $_SESSION['error'] = 'invalid username or password';
}
// otherwise, password_verify(password from form, password from db)

// if good, put username in session, otherwise send back to login
$conn->close();
header("location:index.php");
