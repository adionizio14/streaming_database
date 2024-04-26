<?php
session_start();
require 'includes/database-connection.php'; 

if(isset($_GET['movie_id'])) {
    $id = $_GET['movie_id'];
    $idType = 'movie_ID';
    $table = 'Movies';
} elseif(isset($_GET['show_id'])) {
    $id = $_GET['show_id'];
    $idType = 'show_ID';
    $table = 'Shows';
} else {
    // Handle error, both movie_id and show_id are not set
    exit("Error: No ID specified.");
}

$sql = "SELECT trailerSRC FROM $table WHERE $idType = :id";
$trailer = pdo($pdo, $sql, ['id' => $id])->fetch();
$trailerSRC = $trailer['trailerSRC'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Blockbuster++</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body style="background: #282828">
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: #0d3fa9">
            <a class="navbar-brand mr-1" href="browse.php">
                <img src="image/Untitled design (6).PNG" width="150" height="150" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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

                    <li class="nav-item dropdown">
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

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.dropdown-toggle').dropdown();
        });
    </script>

        <iframe class="embed-responsive-item" src="<?php echo $trailerSRC ?>" frameborder="0" style="overflow: hidden; 
            overflow-x: hidden; overflow-y: hidden; height: 75%; width: 75%; position: absolute; top: 100px; 
            left: 0px; right: 0px; bottom: 0px; margin: auto;">
        </iframe>

</body>