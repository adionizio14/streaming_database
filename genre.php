<?php
session_start();
require 'includes/database-connection.php'; 
//print_r($_SESSION['cust_id']);
$genre_id = $_GET['genrenum'];

function get_mov_info(PDO $pdo, string $id, string $genre_id) {

    // SQL query to retrieve username and password from the database
    $sql = "SELECT title, release_year, runtime, rating, imgSrc
        FROM Movies JOIN Movie_genres
        where Movies.movie_ID= :id
        AND Movie_genres.genre_ID= :genreid
        AND Movie_genres.movie_ID = Movies.movie_ID;";		// Select the email and password from the customer table where the email is equal to the value of :id

    // Execute the SQL query using the pdo function and fetch the result
    $mov_info = pdo($pdo, $sql, ['id' => $id, 'genreid' => $genre_id])->fetch();		// Associative array where 'id' is the key and $id is the value. Used to bind the value of $id to the placeholder :id in  SQL query.

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
        $movie_info = get_mov_info($pdo, $id, $genre_id);
        if ($movie_info !== false) {
            $movs[$id] = $movie_info;
        }
    }

// Now $toys array will contain information about all the toys

function get_show_info(PDO $pdo, string $id, string $genre_id) {

    // SQL query to retrieve username and password from the database
    $sql = "SELECT title, release_year, rating, imgSrc
        FROM Shows JOIN Show_genres
        where Shows.show_ID= :id
        AND Show_genres.genre_ID= :genreid
        AND Show_genres.show_ID=Shows.show_ID;";		// Select the email and password from the customer table where the email is equal to the value of :id

    // Execute the SQL query using the pdo function and fetch the result
    $show_info = pdo($pdo, $sql, ['id' => $id, 'genreid' => $genre_id])->fetch();		// Associative array where 'id' is the key and $id is the value. Used to bind the value of $id to the placeholder :id in  SQL query.

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
        $show_info = get_show_info($pdo, $id, $genre_id);
        if ($show_info !== false) {
            $shos[$id] = $show_info;
        }
    }

// Now $toys array will contain information about all the toys
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blockbuster++</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: #0d3fa9">
            <a class="navbar-brand mr-1" href="browse.php">
                <img src="image/Untitled design (6).PNG" width="150" height="150" alt="">
            </a>            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-1">
                    <li class="nav-item">
                        <a class="nav-link" href="movies.php">Movies</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="shows.php">Shows</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="popular.php">Popular</a>
                    </li>

                    <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Genre</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="genre.php?genrenum=1">Action</a>
                            <a class="dropdown-item" href="genre.php?genrenum=7">Adventure</a>
                            <a class="dropdown-item" href="genre.php?genrenum=2">Comedy</a>
                            <a class="dropdown-item" href="genre.php?genrenum=11">Crime</a>
                            <a class="dropdown-item" href="genre.php?genrenum=3">Drama</a>
                            <a class="dropdown-item" href="genre.php?genrenum=6">Fantasy</a>
                            <a class="dropdown-item" href="genre.php?genrenum=9">Horror</a>
                            <a class="dropdown-item" href="genre.php?genrenum=8">Romance</a>
                            <a class="dropdown-item" href="genre.php?genrenum=5">Science Fiction</a>
                            <a class="dropdown-item" href="genre.php?genrenum=4">Thriller</a>
                        </div>
                    </li>
                </ul>

                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <form class="form-inline ml-3" action="search.php" method="GET">
                            <input class="form-control mr-sm-2" name = "query" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
                        </form>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="settings.php">Settings</a>
                    </li>
                </ul>

            </div>
        </nav>

        <main>
            <?php foreach ($movs as $movs_inf): ?>
            <div class="card">
                <div class="image">
                <?php if (is_array($movs_inf)): ?>
                    <img src=<?php echo $movs_inf['imgSrc']; ?>>
                <?php else: ?>
                    <p>Movie image not available</p>
                <?php endif; ?>
                </div>
                <div class="caption">
                <?php if (is_array($movs_inf)): ?>
                    <p class="title">Title: <?php echo $movs_inf['title']; ?></p>
                    <p class="release_year">Release Year: <?php echo $movs_inf['release_year']; ?></p>
                    <p class="runtime">Runtime: <?php echo $movs_inf['runtime']; ?></p>
                    <p class="rating">Rating: <?php echo $movs_inf['rating']; ?></p>
                <?php else: ?>
                    <p>Movie information not available</p>
                <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>

            <?php foreach ($shos as $shos_inf): ?>
            <div class="card">
                <div class="image">
                <?php if (is_array($shos_inf)): ?>
                    <img src=<?php echo $shos_inf['imgSrc']; ?>>
                <?php else: ?>
                    <p>Movie image not available</p>
                <?php endif; ?>
                </div>
                <div class="caption">
                <?php if (is_array($shos_inf)): ?>
                    <p class="title">Title: <?php echo $shos_inf['title']; ?></p>
                    <p class="release_year">Release Year: <?php echo $shos_inf['release_year']; ?></p>
                    <p class="rating">Rating: <?php echo $shos_inf['rating']; ?></p>
                <?php else: ?>
                    <p>Movie information not available</p>
                <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </main>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.dropdown-toggle').dropdown();
        });
    </script>
</body>