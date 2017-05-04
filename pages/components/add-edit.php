<?php
	require_once("../../includes/components_includes/statement_functions.php");
	global $insert_component_stmt;
	global $update_component_stmt;
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

<?php include("../../includes/header.php") ?>
<?php include("../../includes/sidebar.php"); ?>
<?php
	include_once("../../includes/form_functions.php");

    if ($_GET['id']) {

		$component_id = $_GET['id'];

		// Old component data to update
		$component_data    = read_component_by_id($read_component_stmt);
		$current_component = $component_data->fetch_array();
		close_stmt($read_component_stmt);

		echo htmlentities($current_component[1]);        // Name entry
        echo htmlentities($current_component[2]);        // Functional entry
        echo htmlentities($current_component[3]);        // UnitCount entry
        echo htmlentities($current_component[4]);        // State entry
        echo htmlentities($current_component[5]);        // Picture entry
        echo htmlentities($current_component[6]);        // Datasheet entry
    }

	if ($_POST && $_GET['id']) {
		form_validate($component_id);
	} else if ($_POST) {
		form_validate();
	}
?>
<?php include("../../includes/footer.php") ?>

<?php

	function form_validate($component_id = NULL) {
		$errors = array();

        // perform validations on the new form data
        $required_fields    = array('name', 'functional', 'unit_count', 'state');
        $errors             = array_merge($errors, check_required_fields($required_fields));
        $fields_max_lengths = array('name' => 45, 'functional' => 45, 'unit_count' => 45, 'state' => 45);
        $errors             = array_merge($errors, check_max_field_lengths($fields_max_lengths));
        $fields_min_lengths = array('name' => 2, 'functional' => 8, 'unit_count' => 1, 'state' => 2);
        $errors             = array_merge($errors, check_min_field_lengths($fields_min_lengths));

		// New component data
        $name         = trim($_POST['name']);                    // name for html input tag => name
        $functional   = trim($_POST['functional']);              // name for html input tag => functional
        $unit_count   = trim($_POST['unit_count']);              // name for html input tag => unit_count
        $state        = trim($_POST['state']);                   // name for html input tag => state
        $picture      = trim($_POST['picture']);                 // name for html input tag => picture
        $datasheet    = trim($_POST['datasheet']);               // name for html input tag => datasheet

        if (empty($errors)) {
			if ($component_id != NULL) {
	            execute_stmt($update_component_stmt);
	            close_stmt($update_component_stmt);
			} else {
				execute_stmt($insert_component_stmt);
	            close_stmt($insert_component_stmt);
			}
        }
	}
 ?>
