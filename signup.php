<?php

require 'includes/database-connection.php';		// Include the database connection file

?>

<!DOCTYPE html>

<html>
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <form method="POST">
        <h2>Sign Up</h2>

        <label>First Name</label>
        <input type="text" name="first_name" placeholder="First Name"><br>

        <label>Last Name</label>
        <input type="text" name="last_name" placeholder="Last Name"><br>

        <!-- add date of birth here -->

        <label> Date of Birth</label>
        <input type="date" name="date_of_birth" placeholder="Date of Birth"><br>

        <label>Email</label>
        <input type="text" name="email" placeholder="Email"><br>

        
        <Label> Supscription Plan</label>
        <br>
        <select name="subscription_plan">
            <option value="1">Basic: $5/month (Ads) </option>
            <option value="2">Standard: $10/month(No Ads) </option>
            <option value="3">Premium: $15/month (Special Features)</option>

        </select>
        <br>
        <br>
        <label> Create Password</label>
        <input type="password" name="password" placeholder="Password"><br>


        <label>Confirm Password</label>
        <input type="password" name="confirm_password" placeholder="Confirm Password"><br>

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
                echo "Passwords do not match";
            } else {
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
                header("Location: http://localhost:80/streaming_database/login.php");
            }
        }
    ?>
    
</body>


</html>