<?php require_once("../../includes/researches_includes/statement_functions.php"); ?>
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
	if(admin_check()){ //user is admin
		include("../../includes/header_admin.php");
		include("../../includes/sidebar_admin.php");
	}else{ //normal user
		include("../../includes/header.php");
		include("../../includes/sidebar.php");
	}
?>

<?php

    $all_researches = read_all_researches($read_all_researches_stmt);

    while ($one_research = $all_researches->fetch_array(MYSQLI_NUM)) {

		$idResearches    = $one_research[0];
		$user_id         = read_user_research($user_research_stmt);

		$user_data       = read_user_by_id($read_user_stmt);
		$user_data_array = $user_data->fetch_array(MYSQLI_NUM);

		// User data for this research
		echo htmlentities($user_data_array[1]);           // First name entry
		echo htmlentities($user_data_array[3]);           // Last name entry

		// Research data
        echo htmlentities($one_research[1]);        // Title entry
        echo htmlentities($one_research[2]);        // Idea entry
    }
?>
<?php
	if(admin_check()){ //user is admin
		include("../../includes/footer_admin.php");
	}else{ //normal user
		include("../../includes/footer.php");
	}
?>