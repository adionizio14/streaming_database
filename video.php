<?php
session_start();
require 'includes/database-connection.php'; 

$movie_id = $_GET['movie_id'];
$sql = "SELECT trailerSRC FROM Movies WHERE movie_ID = :movie_id";

$trailer= pdo($pdo, $sql, ['movie_id' => $movie_id])->fetch();
$trailerSRC = $trailer['trailerSRC'];
print($trailerSRC);

?>

<iframe width="420" height="315"
src="<?php echo $trailerSRC ?>">
</iframe>