<?php
session_start();
ob_start();
error_reporting(E_ALL);
require 'includes/database-connection.php';		// Include the database connection file

?>

<!DOCTYPE html>

<html>
<head>
    <title>Blockbuster++</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body id="settings_body" style="justify-content: centered;">
    <form id="settings_form" method="POST">
        <h2 id="login_h2">Add Movie or Show</h2>

        <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?> </p>
            <?php } ?>

            <div>
                <input id="login_input" style="margin: auto" type="text" name="title" placeholder="Title"><br>

                <input id="login_input" style="margin: auto" type="text" name="release_year" placeholder="Release Year"><br>

                <input id="login_input" style="margin: auto" type="text" name="runtime" placeholder="Runtime"><br>

                <input id="login_input" style="margin: auto" type="text" name="rating" placeholder="Rating"><br>
            </div>

    </form>

    <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
            // Get the title, release year, runtime, rating from the form
            $title = $_POST['title'];
            $release_year = $_POST['release_year'];
            $runtime = $_POST['runtime'];
            $rating = $_POST['rating'];

            if (empty($title) || empty($release_year) || empty($runtime) || empty($rating)) {
                header("Location: signup.php?error=All fields are required");
                exit();
            }
            else {
                // check if the movie already exists in the database
                $sql = "SELECT title FROM Movies WHERE title = :title";
                $stmt = pdo($pdo, $sql, ['title' => $title]);
                $content = $stmt->fetch();

                if ($content) {
                    header("Location: signup.php?error=Movie or Show is already added");
                    exit();
                }

                // SQL query to insert the customer information into the database
                $sql = "INSERT INTO Movies (title, release_year, runtime, rating) 
                        VALUES (:title, :release_year, :runtime, :rating)";

                // Execute the SQL query using the pdo function
                pdo($pdo, $sql, ['title' => $title, 'release_year' => $release_year, 'runtime' => $runtime, 'rating' => $rating]);

                header("Location: admin.php");
            }
        }
    ?>
    
</body>

</html>