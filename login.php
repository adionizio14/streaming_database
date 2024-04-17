<?php

    // Require the database connection file
    require 'includes/database-connection.php';

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

<?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            // Get the username and password from the form
            $uname = $_POST['uname'];
            $password = $_POST['password'];

            // Get the customer information from the database
            $credentials = get_cust_info($pdo, $uname);

            // Check if the password is correct
            if ($credentials && password_verify($password, $credentials['password'])) {

                // Redirect to the browse page
                // get current url
                $url = $_SERVER['HTTP_REFERER'];
                // cut the url to get everything before the last /
                $url = substr($url, 0, strrpos($url, '/'));
                // add the browse.php to the url
                $url = $url . '/browse.php';
                
                header("Location: $url");
                exit();
            }

            else {
                // Display an error message
                header("Location: login.php?error=Invalid Username or Password");
                exit();
            }
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

        <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?> </p>
            <?php } ?>

        <label>Username</label>
        <input type="text" name="uname" placeholder="Username"><br>

        <label>Password</label>
        <input type="password" name="password" placeholder="Password"><br>

        <button type="submit">Login</button>

        <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
        
    </form>
    
</body>


</html>