<?php require_once("../../includes/components_includes/statement_functions.php"); ?>
<?php require_once("../../includes/session.php"); ?>
<?php
	require_once("../../includes/db_connection.php");
	global $connection;
?>
<?php require_once("../../includes/functions.php"); ?>

<?php
	confirm_logged_in();
?>

<?php include("../../includes/header.php") ?>
<?php include("../../includes/sidebar.php"); ?>
<?php

    $all_components = read_all_labs($read_all_components_stmt);

    while ($one_component = $all_components->fetch_array(MYSQLI_NUM)) {
        echo htmlentities($one_component[1]);        // Name entry
        echo htmlentities($one_component[2]);        // Functional entry
        echo htmlentities($one_component[3]);        // UnitCount entry
        echo htmlentities($one_component[4]);        // State entry
        echo htmlentities($one_component[5]);        // Picture entry
        echo htmlentities($one_component[6]);        // Datasheet entry
    }

 ?>

<?php include("../../includes/footer.php") ?>
