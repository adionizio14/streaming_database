<?php
session_start();
require 'includes/database-connection.php'; 
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
            <a class="navbar-brand" href="#">Chows and Moovies</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Movies</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Shows</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Popular</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Genre</a>
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
            <div class="card">
                <div class="image">
                    <img src="https://i.kym-cdn.com/photos/images/newsfeed/001/449/979/722.jpeg">
                </div>
                <div class="caption">
                    <p class="title">Title</p>
                    <p class="release_year">Release Year</p>
                    <p class="runtime">Runtime</p>
                    <p class="rating">Rating</p>
                </div>
            </div>

            <!-- only need for one of the div with the card class, just query the data from db inclusing the images once they are added... ones below can be deleted after, added them to test the placement-->

            <div class="card">
                <div class="image">
                    <img src="https://i.pinimg.com/564x/2a/30/3f/2a303f55d2dae25538c1106524cbb46b.jpg">
                    <!--haha kidding heres an actual link https://upload.wikimedia.org/wikipedia/en/1/1c/The_Dark_Knight_%282008_film%29.jpg -->
                </div>
                <div class="caption">
                    <p class="title">Title</p>
                    <p class="release_year">Release Year</p>
                    <p class="runtime">Runtime</p>
                    <p class="rating">Rating</p>
                </div>
            </div>

            <div class="card">
                <div class="image">
                    <img src="https://i.pinimg.com/originals/23/75/ee/2375eedba6fe4f99165d22740d5013b7.png">
                </div>
                <div class="caption">
                    <p class="title">Title: Silence of the Lambs</p>
                    <p class="release_year">Release Year</p>
                    <p class="runtime">Runtime</p>
                    <p class="rating">Rating</p>
                </div>
            </div>
</body>