<?php

session_start();
ob_start();
error_reporting(E_ALL);
// Require the database connection file
require 'includes/database-connection.php';

$cust_id = $_SESSION['cust_id'];

function get_cust_info(PDO $pdo, int $id) {
    
    $sql = "SELECT *
        FROM Customers WHERE cust_ID = :id";


    // Execute the SQL query using the pdo function and fetch the result
    $credentials = pdo($pdo, $sql, ['id' => $id])->fetch();	

    // Return the toy information (associative array)
    return $credentials;
}

function get_cust_sub_plan(PDO $pdo, int $id){
    $sql = "SELECT subscription_ID
            FROM Customer_subscription
            WHERE cust_ID = :id";

    $plan = pdo($pdo, $sql, ['id' => $id])->fetch();
    $plan_id = $plan['subscription_ID'];

    $sql = "Select subscription_name, subscription_ID
            FROM Subscriptions
            WHERE subscription_ID = :plan_id";

    $plan_name = pdo($pdo, $sql, ['plan_id' => $plan_id])->fetch();


    return $plan_name;
}

function get_plan_names(PDO $pdo){
    $sql = "SELECT subscription_name, subscription_ID
            FROM Subscriptions";

    $plans = pdo($pdo, $sql)->fetchAll();

    return $plans;
}

function get_movie_names(PDO $pdo){
    $sql = "SELECT title, movie_ID
            FROM Movies";

    $movies = pdo($pdo, $sql)->fetchAll();

    return $movies;
}

function get_show_names(PDO $pdo){
    $sql = "SELECT title, show_ID
            FROM Shows";

    $shows = pdo($pdo, $sql)->fetchAll();

    return $shows;
}

function get_actor_names(PDO $pdo){
    $sql = "SELECT first_name, last_name, actor_ID
            FROM Actors";

    $actors = pdo($pdo, $sql)->fetchAll();

    return $actors;
}

function get_genre_names(PDO $pdo){
    $sql = "SELECT genre_name, genre_ID
            FROM Genres";

    $genres = pdo($pdo, $sql)->fetchAll();

    return $genres;
}
function get_fav_movie(PDO $pdo, int $id){
    $sql = "SELECT movie_ID
            FROM fav_movie
            WHERE cust_id = :id";

    $movie_id = pdo($pdo, $sql, ['id' => $id])->fetch();
    if ($movie_id){
        $movie_id = $movie_id['movie_ID'];
        
        $sql = "SELECT title, movie_ID
        FROM Movies
        WHERE movie_ID = :movie_id";

        $fav_movie = pdo($pdo, $sql, ['movie_id' => $movie_id])->fetch();
    }
    else{
        $fav_movie = null;
    }



    return $fav_movie;
}

function get_fav_show(PDO $pdo, int $id){
    $sql = "SELECT show_ID
            FROM fav_show
            WHERE cust_id = :id";

    $show_id = pdo($pdo, $sql, ['id' => $id])->fetch();
    if ($show_id){
        $show_id = $show_id['show_ID'];
        
        $sql = "SELECT title, show_ID
        FROM Shows
        WHERE show_ID = :show_id";

        $fav_show = pdo($pdo, $sql, ['show_id' => $show_id])->fetch();
    }
    else{
        $fav_show = null;
    }

    $sql = "SELECT title
            FROM Shows
            WHERE show_ID = :show_id";

    $fav_show = pdo($pdo, $sql, ['show_id' => $show_id])->fetch();

    return $fav_show;
}

function get_fav_actor(PDO $pdo, int $id){
    $sql = "SELECT actor_ID
            FROM fav_actor
            WHERE cust_id = :id";

    $actor_id = pdo($pdo, $sql, ['id' => $id])->fetch();
    if ($actor_id){
        $actor_id = $actor_id['actor_ID'];

        $sql = "SELECT first_name, last_name
                FROM Actors
                WHERE actor_ID = :actor_id";
        
        $fav_actor = pdo($pdo, $sql, ['actor_id' => $actor_id])->fetch();
    }
    else{
        $fav_actor = null;
    }

    $sql = "SELECT first_name, last_name
            FROM Actors
            WHERE actor_ID = :actor_id";

    $fav_actor = pdo($pdo, $sql, ['actor_id' => $actor_id])->fetch();

    return $fav_actor;
}

function get_fav_genre(PDO $pdo, int $id){
    $sql = "SELECT genre_ID
            FROM fav_genre
            WHERE cust_id = :id";

    $genre_id = pdo($pdo, $sql, ['id' => $id])->fetch();

    if($genre_id){
        $genre_id = $genre_id['genre_ID'];

        $sql = "SELECT genre_name
                FROM Genres
                WHERE genre_ID = :genre_id";
        
        $fav_genre = pdo($pdo, $sql, ['genre_id' => $genre_id])->fetch();
    }
    else{
        $genre_id = null;
    }

    $sql = "SELECT genre_name
            FROM Genres
            WHERE genre_ID = :genre_id";

    $fav_genre = pdo($pdo, $sql, ['genre_id' => $genre_id])->fetch();

    return $fav_genre;
}


    $credentials = get_cust_info($pdo, $cust_id);
    $plan_name = get_cust_sub_plan($pdo, $cust_id);
    $plans = get_plan_names($pdo);
    $movies = get_movie_names($pdo);
    $shows = get_show_names($pdo);
    $actors = get_actor_names($pdo);
    $genres = get_genre_names($pdo);
    $fav_movie = get_fav_movie($pdo, $cust_id);
    $fav_show = get_fav_show($pdo, $cust_id);
    $fav_actor = get_fav_actor($pdo, $cust_id);
    $fav_genre = get_fav_genre($pdo, $cust_id);

?>

<?php
    if(isset($_POST['action'])){
        
        $action = $_POST['action'];

        if($action == 'u'){

            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $date_of_birth = $_POST['date_of_birth'];
            $fav_movie = $_POST['fav_movie'];
            $fav_show = $_POST['fav_show'];
            $fav_actor = $_POST['fav_actor'];
            $fav_genre = $_POST['fav_genre'];
            $subscription_plan = $_POST['subscription_plan'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
    
            // make sure user has first name, last name, date of birth
            if(empty($first_name) || empty($last_name) || empty($date_of_birth)){
                header("Location: settings.php?error=All fields are required");
                exit();
            }
            // else check if password and confirm password have values
            else if(!empty($password) && !empty($confirm_password)){
                // check if password and confirm password match
                if ($password != $confirm_password) {
                    header("Location: settings.php?error=Passwords do not match");
                    exit();
                }
                else{
                    $password = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "UPDATE Customers
                            SET first_name = :first_name, last_name = :last_name, date_of_birth = :date_of_birth, password = :password
                            WHERE cust_id = :cust_id";
    
                    pdo($pdo, $sql, ['first_name' => $first_name, 'last_name' => $last_name, 'date_of_birth' => $date_of_birth, 'password' => $password, 'cust_id' => $cust_id]);
                }
            }
            else{
                $sql = "UPDATE Customers
                        SET first_name = :first_name, last_name = :last_name, date_of_birth = :date_of_birth
                        WHERE cust_id = :cust_id";
    
                pdo($pdo, $sql, ['first_name' => $first_name, 'last_name' => $last_name, 'date_of_birth' => $date_of_birth, 'cust_id' => $cust_id]);
            }
    
            
            // update the favorite movie
            if($fav_movie){
    
                // check if the user has a favorite movie
                $sql = "SELECT movie_ID
                        FROM fav_movie
                        WHERE cust_ID = :cust_id";
    
                $movie_id = pdo($pdo, $sql, ['cust_id' => $cust_id])->fetch();
    
                // if the user does not have a favorite movie, insert the movie into the table
    
                if(!$movie_id){
                    $sql = "INSERT INTO fav_movie (cust_ID, movie_ID)
                            VALUES (:cust_id, :fav_movie)";
    
                    pdo($pdo, $sql, ['cust_id' => $cust_id, 'fav_movie' => $fav_movie]);
                }
                elseif($fav_movie == 'empty'){
                    $sql = "DELETE FROM fav_movie
                            WHERE cust_ID = :cust_id";
    
                    pdo($pdo, $sql, ['cust_id' => $cust_id]);
                }
    
                // if the user has a favorite movie, update the movie
                else{
                    $sql = "UPDATE fav_movie
                            SET movie_ID = :fav_movie
                            WHERE cust_ID = :cust_id";
    
                    pdo($pdo, $sql, ['fav_movie' => $fav_movie, 'cust_id' => $cust_id]);
                }
    
    
            }
    
            // update the favorite show
            if($fav_show){
                $sql = "SELECT show_ID
                        FROM fav_show
                        WHERE cust_ID = :cust_id";
                
                $show_id = pdo($pdo, $sql, ['cust_id' => $cust_id])->fetch();
    
                if(!$show_id){
                    $sql = "INSERT INTO fav_show (cust_ID, show_ID)
                            VALUES (:cust_id, :fav_show)";
    
                    pdo($pdo, $sql, ['cust_id' => $cust_id, 'fav_show' => $fav_show]);
                }
                elseif($fav_show == 'empty'){
                    $sql = "DELETE FROM fav_show
                            WHERE cust_ID = :cust_id";
    
                    pdo($pdo, $sql, ['cust_id' => $cust_id]);
                }
                else{
                    $sql = "UPDATE fav_show
                            SET show_ID = :fav_show
                            WHERE cust_ID = :cust_id";
    
                    pdo($pdo, $sql, ['fav_show' => $fav_show, 'cust_id' => $cust_id]);
                }
            }
    
            // update the favorite actor
            if($fav_actor){
                $sql = "SELECT actor_ID
                        FROM fav_actor
                        WHERE cust_ID = :cust_id";
    
                $actor_id = pdo($pdo, $sql, ['cust_id' => $cust_id])->fetch();
    
                if(!$actor_id){
                    $sql = "INSERT INTO fav_actor (cust_ID, actor_ID)
                            VALUES (:cust_id, :fav_actor)";
    
                    pdo($pdo, $sql, ['cust_id' => $cust_id, 'fav_actor' => $fav_actor]);
                }
                elseif($fav_actor == 'empty'){
                    $sql = "DELETE FROM fav_actor
                            WHERE cust_ID = :cust_id";
    
                    pdo($pdo, $sql, ['cust_id' => $cust_id]);
                }
                else{
                    $sql = "UPDATE fav_actor
                            SET actor_ID = :fav_actor
                            WHERE cust_ID = :cust_id";
    
                    pdo($pdo, $sql, ['fav_actor' => $fav_actor, 'cust_id' => $cust_id]);
                }
            }
    
            // update the favorite genre
            if($fav_genre){
    
                $sql = "SELECT genre_ID
                        FROM fav_genre
                        WHERE cust_ID = :cust_id";
                
                $genre_id = pdo($pdo, $sql, ['cust_id' => $cust_id])->fetch();
    
                if(!$genre_id){
                    $sql = "INSERT INTO fav_genre (cust_ID, genre_ID)
                            VALUES (:cust_id, :fav_genre)";
    
                    pdo($pdo, $sql, ['cust_id' => $cust_id, 'fav_genre' => $fav_genre]);
                }
                elseif($fav_genre == 'empty'){
                    $sql = "DELETE FROM fav_genre
                            WHERE cust_ID = :cust_id";
    
                    pdo($pdo, $sql, ['cust_id' => $cust_id]);
                }
                else{
                    $sql = "UPDATE fav_genre
                            SET genre_ID = :fav_genre
                            WHERE cust_ID = :cust_id";
    
                    pdo($pdo, $sql, ['fav_genre' => $fav_genre, 'cust_id' => $cust_id]);
                }
            }
    
            // update the subscription plan
            $sql = "UPDATE Customer_subscription
                    SET subscription_ID = :subscription_plan
                    WHERE cust_ID = :cust_id";
    
            
            pdo($pdo, $sql, ['subscription_plan' => $subscription_plan, 'cust_id' => $cust_id]);
            
    
            //reload the page
            header("Location: settings.php");
            exit();
        }

        if($action == 'd'){

            //delete the favorite movie
            $sql = "DELETE FROM fav_movie
                    WHERE cust_ID = :cust_id";
    
            pdo($pdo, $sql, ['cust_id' => $cust_id]);
    
            //delete the favorite show
            $sql = "DELETE FROM fav_show
                    WHERE cust_ID = :cust_id";
    
            pdo($pdo, $sql, ['cust_id' => $cust_id]);
    
            //delete the favorite actor
            $sql = "DELETE FROM fav_actor
                    WHERE cust_ID = :cust_id";
    
            pdo($pdo, $sql, ['cust_id' => $cust_id]);
    
            //delete the favorite genre
            $sql = "DELETE FROM fav_genre
                    WHERE cust_ID = :cust_id";
    
            pdo($pdo, $sql, ['cust_id' => $cust_id]);
    
            //delete the subscription plan
            $sql = "DELETE FROM Customer_subscription
                    WHERE cust_ID = :cust_id";
    
            pdo($pdo, $sql, ['cust_id' => $cust_id]);
    
            //delete the customer
    
            $sql = "DELETE FROM Customers
                    WHERE cust_ID = :cust_id";
            
            pdo($pdo, $sql, ['cust_id' => $cust_id]);
    
            header("Location: login.php");
            exit();
        }

        if($action == 'l'){
            session_unset();
            session_destroy();
            header("Location: login.php");
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

    <body id="settings_body">
    <form id="settings_form" method="POST">
        <h2 id="login_h2">Account Settings</h2>

        <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?> </p>
            <?php } ?>

        <label id="login_label">First Name</label>
        <input id="login_input" type="text" name="first_name" value = <?php echo $credentials['first_name'];?> ><br>

        <label id="login_label">Last Name</label>
        <input id="login_input" type="text" name="last_name" value = <?php echo $credentials['last_name'];?>><br>

        <label id="login_label"> Date of Birth</label>
        <input id="login_input"type="date" name="date_of_birth" value = <?php echo $credentials['date_of_birth'];?> ><br>

        <label id="login_label">Email</label>
        <input id="login_input" readonly style="background-color: grey;" type="text" name="email" value = <?php echo $credentials['email'];?>><br>

        <label id="login_label"> Favorite Movie </label>
        <br>
        <select name="fav_movie">
            <?php

                // if the user has a favorite movie, display the movie
                // then display the other movies
                if($fav_movie){
                    echo "<option value ='{$fav_movie['movie_ID']}'>{$fav_movie['title']}</option>";
                    foreach($movies as $movie){
                        if($movie['movie_ID'] != $fav_movie['movie_ID']){
                            echo "<option value = '{$movie['movie_ID']}'>{$movie['title']}</option>";
                        }
                    }
                    // add option to remove favorite movie
                    echo "<option value = 'empty'>Remove Favorite Movie</option>";
                }
                // if the user does not have a favorite movie, display all the movies
                else{
                    echo "<option value = ''>Select a Movie</option>";
                    foreach($movies as $movie){
                        echo "<option value = '{$movie['movie_ID']}'>{$movie['title']}</option>";
                    }
                }
            ?>
        </select>
        <br>

        <label id="login_label"> Favorite Show </label>
        <br>
        <select name="fav_show">
            <?php

                // if the user has a favorite show, display the show
                // then display the other shows
                if($fav_show){
                    echo "<option value ='{$fav_show['show_ID']}'>{$fav_show['title']}</option>";
                    foreach($shows as $show){
                        if($show['show_ID'] != $fav_show['show_ID']){
                            echo "<option value = '{$show['show_ID']}'>{$show['title']}</option>";
                        }
                    }
                    // add option to remove favorite show
                    echo "<option value = 'empty'>Remove Favorite Show</option>";
                }
                // if the user does not have a favorite show, display all the shows
                else{
                    echo "<option value = ''>Select a Show</option>";
                    foreach($shows as $show){
                        echo "<option value = '{$show['show_ID']}'>{$show['title']}</option>";
                    }
                }
                ?>
        </select>
        <br>

        <label id="login_label"> Favorite Actor/Actress </label>
        <br>
        <select name="fav_actor">
            <?php

                // if the user has a favorite actor, display the actor
                // then display the other actors
                if($fav_actor){
                    echo "<option value ='{$fav_actor['actor_ID']}'>{$fav_actor['first_name']} {$fav_actor['last_name']}</option>";
                    foreach($actors as $actor){
                        if($actor['actor_ID'] != $fav_actor['actor_ID']){
                            echo "<option value = '{$actor['actor_ID']}'>{$actor['first_name']} {$actor['last_name']}</option>";
                        }
                    }
                    // add option to remove favorite actor
                    echo "<option value = 'empty'>Remove Favorite Actor</option>";
                }
                // if the user does not have a favorite actor, display all the actors
                else{
                    echo "<option value = ''>Select an Actor</option>";
                    foreach($actors as $actor){
                        echo "<option value = '{$actor['actor_ID']}'>{$actor['first_name']} {$actor['last_name']}</option>";
                    }
                }
                ?>
        </select>
        <br>

        <label id="login_label"> Favorite Genre </label>
        <br>
        <select name="fav_genre">
            <?php

                // if the user has a favorite genre, display the genre
                // then display the other genres
                if($fav_genre){
                    echo "<option value ='{$fav_genre['genre_ID']}'>{$fav_genre['genre_name']}</option>";
                    foreach($genres as $genre){
                        if($genre['genre_ID'] != $fav_genre['genre_ID']){
                            echo "<option value = '{$genre['genre_ID']}'>{$genre['genre_name']}</option>";
                        }
                    }
                    // add option to remove favorite genre
                    echo "<option value = 'empty'>Remove Favorite Genre</option>";
                }
                // if the user does not have a favorite genre, display all the genres
                else{
                    echo "<option value = ''>Select a Genre</option>";
                    foreach($genres as $genre){
                        echo "<option value = '{$genre['genre_ID']}'>{$genre['genre_name']}</option>";
                    }
                }
                ?>
        </select>
        <br>

        <Label id="login_label"> Supscription Plan</label>
        <br>
        <select name="subscription_plan">
            <?php
                echo "<option value ='{$plan_name['subscription_ID']}'>{$plan_name['subscription_name']}</option>";
                foreach($plans as $plan){
                    if($plan['subscription_name'] != $plan_name['subscription_name']){
                        echo "<option value ='{$plan['subscription_ID']}'>{$plan['subscription_name']}</option>";
                    }
                }
            ?>
        </select>
        <br>
        <br>

        <label id="login_label"> New Password</label>
        <input id="login_input" type="password" name="password" placeholder="Password"><br>


        <label id="login_label">Confirm Password</label>
        <input id="login_input" type="password" name="confirm_password" placeholder="Confirm Password"><br>
        
        <input type="hidden" id="action" name="action" value="">

        <div id="login_contain">
        <div style="margin-bottom: 15px">
        <button id="login_button" type="button" name="update" onclick="confirm_action('u')">Update Profile</button>

        <button id="login_button" type="button" name="logout" onclick="confirm_action('l')">Log Out</button>

        <button id="login_button" type="button" style="margin-right: 100px" onclick="window.location.href='browse.php';">Back</button>

        </div>

        <hr id="login_divider">

        <button id="log_button" type="button" name="delete" onclick="confirm_action('d')" style="background: red">Delete Account</button>

        </div>

        <script>
            function confirm_action(action) {
                var confirmed = false;
                if (action == 'u') {
                    confirmed = confirm("Are you sure you want to update your profile?");
                }
                
                else if (action == 'd') {
                    confirmed = confirm("Are you sure you want to delete your account?");
                }
                
                else if (action == 'l') {
                    confirmed = confirm("Are you sure you want to log out?");
                }
                
                if(confirmed){
                    document.getElementById("action").value = action;
                    document.getElementById("settings_form").submit();
                }
                
            }
        </script>
    </form>


</body>

</html>
