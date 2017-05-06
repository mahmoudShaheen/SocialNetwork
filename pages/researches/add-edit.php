<?php
	require_once("../../includes/researches_includes/statement_functions.php");
	global $insert_research_stmt;
	global $update_research_stmt;
?>
<?php require_once("../../includes/session.php"); ?>
<?php
	require_once("../../includes/db_connection.php");
	global $connection;
?>
<?php require_once("../../includes/functions.php"); ?>

<?php
	confirm_logged_in();
	confirm_admin();
?>

<?php include("../../includes/header_admin.php") ?>
<?php include("../../includes/sidebar_admin.php"); ?>

<?php
	include_once("../../includes/form_functions.php");

    if ($_GET['id']) {

	    $research_id = $_GET['id'];

		// Old research data to update
		$research_data = read_research_by_id($read_research_stmt);
		$one_research  = $research_data->fetch_array(MYSQLI_NUM);

		echo htmlentities($one_research[1]);               // Title entry
		echo htmlentities($one_research[2]);               // Idea entry
    }

	if ($_POST && $_GET['id']) {
		form_validate($research_id);
	} else if ($_POST) {
		form_validate();
	}
 ?>
<?php include("../../includes/footer.php") ?>

<?php

	function form_validate($research_id = NULL) {
		$errors = array();

		// perform validations on the form data
		$required_fields    = array('title', 'idea');
		$errors             = array_merge($errors, check_required_fields($required_fields));
		$fields_max_lengths = array('title' => 45, 'idea' => 450);
		$errors             = array_merge($errors, check_max_field_lengths($fields_max_lengths));
		$fields_min_lengths = array('title' => 8, 'idea' => 20);
		$errors             = array_merge($errors, check_min_field_lengths($fields_min_lengths));

		// New research data
        $title = trim($_POST['title']);                   // name for html input tag => title
        $idea  = trim($_POST['idea']);                    // name for html input tag => idea

		if (empty($errors)) {
			if ($research_id != NULL) {
		        execute_stmt($update_research_stmt);
		        close_stmt($update_research_stmt);
			} else {
				execute_stmt($insert_research_stmt);
		        close_stmt($insert_research_stmt);
			}
		}
	}

 ?>
