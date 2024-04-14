<?php

// Require the database connection file
require 'includes/database-connection.php'; 

function get_cust_info(PDO $pdo, string $id) {

    // SQL query to retrieve toy information based on the toy ID
    $sql = "SELECT email
        FROM Customers
        WHERE email= :id;";	// :id is a placeholder for value provided later 
                                   // It's a parameterized query that helps prevent SQL injection attacks and ensures safer interaction with the database.


    // Execute the SQL query using the pdo function and fetch the result
    $credentials = pdo($pdo, $sql, ['id' => $id])->fetch();		// Associative array where 'id' is the key and $id is the value. Used to bind the value of $id to the placeholder :id in  SQL query.

    // Return the toy information (associative array)
    return $credentials;
}

// Check if the request method is POST (i.e, form submitted)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Retrieve the value of the 'email' field from the POST data
    $uname = $_POST['uname'];

    // Retrieve the value of the 'orderNum' field from the POST data
    $password = $_POST['password'];

    $cust_info = get_cust_info($pdo, $uname);
}

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

        <label>Username</label>
        <input type="text" name="uname" placeholder="Username"><br>

        <label>Password</label>
        <input type="password" name="password" placeholder="Password"><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>