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

<iframe width="420" height="315"
src="<?php echo $trailerSRC ?>">
</iframe>