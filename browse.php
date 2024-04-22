<?php
session_start();
require 'includes/database-connection.php';
print_r($_SESSION['cust_id']) 
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chows and Moovies</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="css/style.css"> -->
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
                        <form class="form-inline my-2 my-lg-0">
                            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
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
</body>