<?php

// Require the database connection file
require 'includes/database-connection.php'; 

?>

<!DOCTYPE html>

<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <form action="" method="post">              <!-- action goes to next page -->
        <h2>Login</h2>
        <label>Username</label>
        <input type="text" name="uname" placeholder="Username"><br>

        <label>Password</label>
        <input type="password" name="password" placeholder="Password"><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>