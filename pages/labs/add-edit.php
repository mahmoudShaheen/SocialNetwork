<?php
	require_once("../../includes/labs_includes/statement_functions.php");
	global $insert_lab_stmt;
	global $update_lab_stmt;
?>
<?php require_once("../../includes/session.php"); ?>
<?php
	require_once("../../includes/db_connection.php");
	global $connection;
?>
<?php require_once("../../includes/functions.php"); ?>

<?php
	confirm_logged_in();
?>

<?php require_once("../../includes/header.php") ?>
<?php
	include_once("../../includes/form_functions.php");

    if ($_GET['id']) {

	    $lab_id   = $_GET['id'];

		// Old lab data to update
		$lab_data = read_lab_by_id($read_lab_stmt);

		echo htmlentities($lab_data[1]);        // LabName entry
        echo htmlentities($lab_data[2]);        // Contents entry
        echo htmlentities($lab_data[3]);        // Place entry
        echo htmlentities($lab_data[4]);        // About entry
        echo htmlentities($lab_data[5]);        // Picture entry
    }

	if ($_POST && $_GET['id']) {
		form_validate($lab_id);
	} else if ($_POST) {
		form_validate();
	}

 ?>
 <?php require_once("../../includes/footer.php") ?>

<?php

	function form_validate($lab_id = NULL) {
		$errors = array();

		// perform validations on the form data
		$required_fields    = array('lab_name', 'contents', 'place');
		$errors             = array_merge($errors, check_required_fields($required_fields));
		$fields_max_lengths = array('lab_name' => 45, 'contents' => 45, 'place' => 45);
		$errors             = array_merge($errors, check_max_field_lengths($fields_max_lengths));
		$fields_min_lengths = array('lab_name' => 8, 'contents' => 8, 'place' => 8);
		$errors             = array_merge($errors, check_min_field_lengths($fields_min_lengths));

		// New lab data
		$lab_name = trim($_POST['lab_name']);                    // name for html input tag => title
		$contents = trim($_POST['contents']);                    // name for html input tag => idea
		$place    = trim($_POST['place']);                       // name for html input tag => place
		$about    = trim($_POST['about']);                       // name for html input tag => about
		$picture  = trim($_POST['picture']);                     // name for html input tag => picture

		if (empty($errors)) {
			if ($lab_id != NULL) {
				execute_stmt($update_lab_stmt);
				close_stmt($update_lab_stmt);
			} else {
				execute_stmt($insert_lab_stmt);
				close_stmt($insert_lab_stmt);
			}
		}
	}

 ?>
