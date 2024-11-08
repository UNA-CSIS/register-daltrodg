<?php

// session start here...
session_start();
include_once 'validate.php';

// get all 3 strings from the form (and scrub w/ validation function)
$user = test_input($_POST['user']);
$pwd = test_input($_POST['pwd']);
$repeat = test_input($_POST['repeat']);

// make sure that the two password values match!
if ($pwd !== $repeat) {
    echo '<a href="register.php">Go back to register page.</a></br>';
    die("Passwords do not match. Try again.");
}

// create the password_hash using the PASSWORD_DEFAULT argument
$hashed_password = password_hash($pwd, PASSWORD_DEFAULT);

// login to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "softball";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// make sure that the new user is not already in the database
$sql = "SELECT * FROM users WHERE username = '$user'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<a href="register.php">Go back to register page.</a></br>';
    die("Username is already taken. Please choose another one.");
}

// insert username and password hash into db (put the username in the session
// or make them login)
$sql = "INSERT INTO users (username, password) VALUES ('$user', '$hashed_password')";

if ($conn->query($sql) === TRUE) {
    echo 'User created successfully.</br>';
    echo '<a href="index.php">Go back to login</a>';
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

