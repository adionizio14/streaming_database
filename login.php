<?php

    session_start();
    ob_start();
    error_reporting(E_ALL);
    // Require the database connection file
    require 'includes/database-connection.php';

    function get_cust_info(PDO $pdo, string $id) {

        // SQL query to retrieve username and password from the database
        $sql = "SELECT email, password, cust_id 
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

                $cust_id = $credentials['cust_id'];
                $_SESSION['cust_id'] = $cust_id;

                //print($url);
                
                header("Location: browse.php");
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

    <title>Blockbuster++</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

</head>

<body id="login_body">

<div class="container">
<img src="image/Untitled design (6).PNG" alt="">

    <form id="login_form" method="POST">
        <h2 id="login_h2">Login</h2>

        <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?> </p>
            <?php } ?>

        <label id="login_label">Username</label>
        <input id="login_input" type="text" name="uname" placeholder="Username"><br>

        <label id="login_label">Password</label>
        <input id="login_input" type="password" name="password" placeholder="Password"><br>

        <div id="login_contain">
        <button id="log_button" type="submit">Login</button>

        <hr id="login_divider">
        <!-- <p>Don't have an account? <a href="signup.php">Sign Up</a></p> -->

        <button id="log_button" type="button" onclick="window.location.href='signup.php';">New User</button>
        </div>

    </form>
        </div>
    
</body>


</html>