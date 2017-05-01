<?php require_once("labs_includes/statement_functions.php"); ?>
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

    $all_labs = read_all_labs($read_all_labs_stmt);

    while ($one_lab = $all_labs->fetch_array(MYSQLI_NUM)) {
        echo "$one_lab[1] </br>";        // LabName entry
        echo "$one_lab[2] </br>";        // Contents entry
        echo "$one_lab[3] </br>";        // Place entry
        echo "$one_lab[4] </br>";        // About entry
        echo "$one_lab[5] </br>";        // Picture entry
    }

 ?>
