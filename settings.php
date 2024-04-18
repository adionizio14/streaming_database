<?php

session_start();

// Require the database connection file
require 'includes/database-connection.php';

$cust_id = $_SESSION['cust_id'];
// print_r($cust_id);
// print_r(gettype($cust_id));

function get_cust_info(PDO $pdo, int $id) {

    // SQL query to retrieve username and password from the database
    $sql = "SELECT *
        FROM Customers WHERE $id = :id";		// Select the email and password from the customer table where the email is equal to the value of :id


    // Execute the SQL query using the pdo function and fetch the result
    $credentials = pdo($pdo, $sql, ['id' => $id])->fetch();		// Associative array where 'id' is the key and $id is the value. Used to bind the value of $id to the placeholder :id in  SQL query.

    // Return the toy information (associative array)
    return $credentials;
}

function get_cust_sub_plan(PDO $pdo, int $id){
    $sql = "SELECT subscription_id
            FROM Customer_subscription
            WHERE cust_id = :id";

    $plan = pdo($pdo, $sql, ['id' => $id])->fetch();
    $plan_id = $plan['subscription_id'];

    $sql = "Select subscription_name
            FROM Subscriptions
            WHERE subscription_id = :plan_id";

    $plan_name = pdo($pdo, $sql, ['plan_id' => $plan_id])->fetch();

    return $plan_name;
}

function get_movie_names(PDO $pdo){
    $sql = "SELECT title
            FROM Movies";

    $movies = pdo($pdo, $sql)->fetchAll();

    return $movies;
}

function get_show_names(PDO $pdo){
    $sql = "SELECT title
            FROM Shows";

    $shows = pdo($pdo, $sql)->fetchAll();

    return $shows;
}

function get_actor_names(PDO $pdo){
    $sql = "SELECT first_name, last_name
            FROM Actors";

    $actors = pdo($pdo, $sql)->fetchAll();

    return $actors;
}

function get_genre_names(PDO $pdo){
    $sql = "SELECT genre_name
            FROM Genres";

    $genres = pdo($pdo, $sql)->fetchAll();

    return $genres;
}

$credentials = get_cust_info($pdo, $cust_id);
$plan_name = get_cust_sub_plan($pdo, $cust_id);
$movies = get_movie_names($pdo);
$shows = get_show_names($pdo);
$actors = get_actor_names($pdo);
$genres = get_genre_names($pdo);

//print_r($credentials);
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Settings</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">

    </head>

    <body>
    <form method="POST">
        <h2>Account Settings</h2>

        <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?> </p>
            <?php } ?>

        <label>First Name</label>
        <input type="text" name="first_name" value = <?php echo $credentials['first_name'];?> ><br>

        <label>Last Name</label>
        <input type="text" name="last_name" value = <?php echo $credentials['last_name'];?>><br>

        <label> Date of Birth</label>
        <input type="date" name="date_of_birth" value = <?php echo $credentials['date_of_birth'];?> ><br>

        <label>Email</label>
        <input readonly style="background-color: grey;" type="text" name="email" value = <?php echo $credentials['email'];?>><br>

        <label> Favorite Movie </label>
        <br>
        <select name="fav_movie">
            <?php foreach($movies as $movie) { 
                echo "<option value = $movie[title]> $movie[title] </option>";
            }
            ?>
        </select>
        <br>

        <label> Favorite Show </label>
        <br>
        <select name="fav_movie">
            <?php foreach($shows as $show) { 
                echo "<option value = $show[title]> $show[title] </option>";
            }
            ?>
        </select>
        <br>

        <label> Favorite Actor/Actress </label>
        <br>
        <select name="fav_movie">
            <?php foreach($actors as $actor) { 
                echo "<option value = $actor[first_name] $actor[last_name]> $actor[first_name] $actor[last_name] </option>";
            }
            ?>
        </select>
        <br>

        <label> Favorite Genre </label>
        <br>
        <select name="fav_movie">
            <?php foreach($genres as $genre) { 
                echo "<option value = $genre[genre_name]> $genre[genre_name] </option>";
            }
            ?>
        </select>
        <br>

        <Label> Supscription Plan</label>
        <br>
        <select name="subscription_plan">
            <option value = "1"> Basic </option>
            <option value = "2"> Standard </option>
            <option value = "3"> Premium </option>
        </select>
        <br>
        <br>

        <label> New Password</label>
        <input type="password" name="password" placeholder="Password"><br>


        <label>Confirm Password</label>
        <input type="password" name="confirm_password" placeholder="Confirm Password"><br>

        <button type="submit">Update Profile</button>
    </form>
</body>

</html>
