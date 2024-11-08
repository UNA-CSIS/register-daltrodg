<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action="authenticate.php" method="POST">
            Username: <input type="text" name="user"><br>
            Password: <input type="password" name="pwd"><br>
            <input type="submit">
        </form>
        <a href="register.php">Register a new login</a>
        <p>
            <?php
            if (isset($_SESSION['error'])) {
                echo "<em>" . $_SESSION['error'] . "</em></br>";
            }
            if (isset($_SESSION['username'])) {
                $username = $_SESSION['username'];
                echo "Welcome $username!</br>";
            }
            ?>
            <a href="games.php">UNA NCAA Championship Season</a>
    </body>
</html>
