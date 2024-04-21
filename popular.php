<?php
session_start();
require 'includes/database-connection.php'; 

function get_mov_info(PDO $pdo, string $id) {

    // SQL query to retrieve username and password from the database
    $sql = "SELECT title, release_year, runtime, rating 
        FROM Movies
        where movie_ID= :id and rating > '8';";		// Select the email and password from the customer table where the email is equal to the value of :id

    // Execute the SQL query using the pdo function and fetch the result
    $mov_info = pdo($pdo, $sql, ['id' => $id])->fetch();		// Associative array where 'id' is the key and $id is the value. Used to bind the value of $id to the placeholder :id in  SQL query.

    // Return the toy mov_information (associative array)
    return $mov_info;

}
    // SQL query to retrieve all toy IDs from the database
    $sql = "SELECT movie_ID FROM Movies";

    // Execute the SQL query using PDO and fetch all the toy IDs
    $statement = $pdo->query($sql);
    $movie_ids = $statement->fetchAll(PDO::FETCH_COLUMN);

    // Create an empty array to store toy information
    $movs = [];

    // Iterate over each toy ID
    foreach ($movie_ids as $id) {
        // Retrieve info about the toy with the current ID from the db using provided PDO connection
        $Movies = get_mov_info($pdo, $id);
        // Add the retrieved toy information to the array
        $movs[$id] = $Movies;
    }

// Now $toys array will contain information about all the toys

function get_show_info(PDO $pdo, string $id) {

    // SQL query to retrieve username and password from the database
    $sql = "SELECT title, release_year, rating 
        FROM Shows
        where show_ID= :id and rating > '8';";		// Select the email and password from the customer table where the email is equal to the value of :id

    // Execute the SQL query using the pdo function and fetch the result
    $show_info = pdo($pdo, $sql, ['id' => $id])->fetch();		// Associative array where 'id' is the key and $id is the value. Used to bind the value of $id to the placeholder :id in  SQL query.

    // Return the toy mov_information (associative array)
    return $show_info;

}
    // SQL query to retrieve all toy IDs from the database
    $sql = "SELECT Show_ID FROM Shows";

    // Execute the SQL query using PDO and fetch all the toy IDs
    $statement = $pdo->query($sql);
    $show_ids = $statement->fetchAll(PDO::FETCH_COLUMN);

    // Create an empty array to store toy information
    $shos = [];

    // Iterate over each toy ID
    foreach ($show_ids as $id) {
        // Retrieve info about the toy with the current ID from the db using provided PDO connection
        $Shows = get_show_info($pdo, $id);
        // Add the retrieved toy information to the array
        $shos[$id] = $Shows;
    }

// Now $toys array will contain information about all the toys
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chows and Moovies</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #344955">
            <a class="navbar-brand" href="browse.php">Chows and Moovies</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="movies.php">Movies</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="shows.php">Shows</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="popular.php">Popular</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="genre.php">Genre</a>
                    </li>
                    <li class="nav-item">
                        <form class="form-inline ml-3">
                            <input class="form-control mr-sm-2" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
                        </form>
                    </li>
                </ul>

                <ul class="navbar-nav mr">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Settings</a>
                    </li>
                </ul>

            </div>
        </nav>

        <main>
            <?php foreach ($movs as $movs_inf): ?>
            <div class="card">
                <!-- <div class="image">
                    <img src="https://m.media-amazon.com/images/M/MV5BM2MyNjYxNmUtYTAwNi00MTYxLWJmNWYtYzZlODY3ZTk3OTFlXkEyXkFqcGdeQXVyNzkwMjQ5NzM@._V1_.jpg">
                </div> -->
                <div class="caption">
                <?php if (is_array($movs_inf)): ?>
                    <p class="title">Title: <?php echo $movs_inf['title']; ?></p>
                    <p class="release_year">Release Year: <?php echo $movs_inf['release_year']; ?></p>
                    <p class="runtime">Runtime: <?php echo $movs_inf['runtime']; ?></p>
                    <p class="rating">Rating: <?php echo $movs_inf['rating']; ?></p>
                <?php else: ?>
                    <p class="error">Movie information not available</p>
                <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>

            <?php foreach ($shos as $shos_inf): ?>
            <div class="card">
                <!-- <div class="image">
                    <img src="https://m.media-amazon.com/images/M/MV5BM2MyNjYxNmUtYTAwNi00MTYxLWJmNWYtYzZlODY3ZTk3OTFlXkEyXkFqcGdeQXVyNzkwMjQ5NzM@._V1_.jpg">
                </div> -->
                <div class="caption">
                <?php if (is_array($shos_inf)): ?>
                    <p class="title">Title: <?php echo $shos_inf['title']; ?></p>
                    <p class="release_year">Release Year: <?php echo $shos_inf['release_year']; ?></p>
                    <p class="rating">Rating: <?php echo $shos_inf['rating']; ?></p>
                <?php else: ?>
                    <p class="error">Movie information not available</p>
                <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </main>
</body>