<?php require_once("researches_includes/statement_functions.php"); ?>
<?php require_once("../../includes/session.php"); ?>
<?php
	require_once("../../includes/db_connection.php");
	global $connection;
?>
<?php require_once("../../includes/functions.php"); ?>

<?php
	confirm_logged_in();
?>

<?php

    $all_researches = read_all_researches($read_all_researches_stmt);

    while ($one_research = $all_researches->fetch_array(MYSQLI_NUM)) {
        echo "$one_research[1] </br>";        // Title entry
        echo "$one_research[2] </br>";        // Idea entry
    }

?>
