<?php

session_start();

// Require the database connection file
require 'includes/database-connection.php';

$cust_id = $_SESSION['cust_id'];
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Settings</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">

    </head>


    <body>
        <div class="container">
            <h2> Account Settings </h2>
            <p> hello </p>
        </div>
    </body>

</html>
