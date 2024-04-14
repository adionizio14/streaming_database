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
    <form>
        <h2>Login</h2>
        <label>User Name</label>
        <input type="text" name="uname" placeholder="User Name">

        <label>Password</label>
        <input type="password" name="password" placeholder="Password">

        <button type="submit">Login</button>
    </form>
</body>
</html>