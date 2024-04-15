<?php

// Require the database connection file
require 'includes/database-connection.php';

$error = '';

function get_cust_info(PDO $pdo, string $id) {

    // SQL query to retrieve username and password from the database
    $sql = "SELECT email, password 
            FROM Customers WHERE email = :id";		// Select the email and password from the customer table where the email is equal to the value of :id


    // Execute the SQL query using the pdo function and fetch the result
    $credentials = pdo($pdo, $sql, ['id' => $id])->fetch();		// Associative array where 'id' is the key and $id is the value. Used to bind the value of $id to the placeholder :id in  SQL query.

    // Return the toy information (associative array)
    return $credentials;
}

?>

<!DOCTYPE html>

<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <form method="POST">
        <h2>Login</h2>

        <label>Username</label>
        <input type="text" name="uname" placeholder="Username"><br>

        <label>Password</label>
        <input type="password" name="password" placeholder="Password"><br>

        <button type="submit">Login</button>

        <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
        
    </form>

    <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            // Get the username and password from the form
            $uname = $_POST['uname'];
            $password = $_POST['password'];

            // Get the customer information from the database
            $credentials = get_cust_info($pdo, $uname);

            // Check if the password is correct
            if ($credentials && $credentials['password'] == $password) {

                // Redirect to the browse page
                header("Location: http://localhost:80/streaming_database/browse.php");
            } else {
                // Display an error message
                echo "Invalid username or password";
            }
        }
    ?>
    
</body>


</html>