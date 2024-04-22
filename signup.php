<?php

require 'includes/database-connection.php';		// Include the database connection file

?>

<!DOCTYPE html>

<html>
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body id="login_body">
    <form id="login_form" method="POST">
        <h2 id="login_h2">Sign Up</h2>

        <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?> </p>
            <?php } ?>

        <label id="login_label">First Name</label>
        <input id="login_input" type="text" name="first_name" placeholder="First Name"><br>

        <label id="login_label">Last Name</label>
        <input id="login_input" type="text" name="last_name" placeholder="Last Name"><br>

        <!-- add date of birth here -->

        <label id="login_label"> Date of Birth</label>
        <input id="login_input" type="date" name="date_of_birth" placeholder="Date of Birth"><br>

        <label id="login_label">Email</label>
        <input id="login_input" type="text" name="email" placeholder="Email"><br>

        
        <Label id="login_label"> Supscription Plan</label>
        <br>
        <select name="subscription_plan">
            <option value="1">Basic: $5/month (Ads) </option>
            <option value="2">Standard: $10/month(No Ads) </option>
            <option value="3">Premium: $15/month (Special Features)</option>

        </select>
        <br>
        <br>

        <label label id="login_label"> Create Password</label>
        <input id="login_input" type="password" name="password" placeholder="Password"><br>


        <label label id="login_label">Confirm Password</label>
        <input id="login_input" type="password" name="confirm_password" placeholder="Confirm Password"><br>

        <button type="submit">Sign Up</button>
    </form>

    <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
            // Get the first name, last name, date of birth, email, subscription plan, password, and confirm password from the form
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $date_of_birth = $_POST['date_of_birth'];
            $email = $_POST['email'];
            $subscription_plan = $_POST['subscription_plan'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            

            // print_r($date_of_birth);
            // Check if the password and confirm password match
            if ($password != $confirm_password) {
                header("Location: signup.php?error=Passwords do not match");
                exit();
            }
            else if (empty($first_name) || empty($last_name) || empty($date_of_birth) || empty($email) || empty($password) || empty($confirm_password)) {
                header("Location: signup.php?error=All fields are required");
                exit();
            }
            else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header("Location: signup.php?error=Invalid email address");
                exit();
            } else {

                // check if the email already exists in the database
                $sql = "SELECT email FROM Customers WHERE email = :email";
                $stmt = pdo($pdo, $sql, ['email' => $email]);
                $user = $stmt->fetch();

                if ($user) {
                    header("Location: signup.php?error=Email is already in use, please sign in");
                    exit();
                }

                $password = password_hash($password, PASSWORD_DEFAULT);
                // SQL query to insert the customer information into the database
                $sql = "INSERT INTO Customers (first_name, last_name, email, date_of_birth, password) 
                        VALUES (:first_name, :last_name, :email, :date_of_birth, :password)";

                // Execute the SQL query using the pdo function
                pdo($pdo, $sql, ['first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'date_of_birth' => $date_of_birth, 'password' => $password]);

                $sql = "SELECT cust_id FROM Customers WHERE email = :email";
                $customer_id = pdo($pdo, $sql, ['email' => $email])->fetch();

                $sql = "SELECT subscription_id FROM Subscriptions WHERE subscription_id = :subscription_plan";
                $subscription_plan_id = pdo($pdo, $sql, ['subscription_plan' => $subscription_plan])->fetch();

                $sql = "INSERT INTO Customer_subscription (cust_id, subscription_id) 
                        VALUES (:cust_id, :subscription_id)";

                pdo($pdo, $sql, ['cust_id' => $customer_id['cust_id'], 'subscription_id' => $subscription_plan_id['subscription_id']]);



                // Redirect to the login page
                $url = $_SERVER['HTTP_REFERER'];
                // cut the url to get everything before the last /
                $url = substr($url, 0, strrpos($url, '/'));
                // add the browse.php to the url
                $url = $url . '/login.php';

                header("Location: $url");
            }
        }
    ?>
    
</body>


</html>