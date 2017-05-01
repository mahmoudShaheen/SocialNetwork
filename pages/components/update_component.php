<?php require_once("components_includes/statement_functions.php"); ?>
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

<?php
	include_once("../../includes/form_functions.php");

    if ($_GET['id']) {
		$errors = array();

        // perform validations on the form data
        $required_fields    = array('name', 'functional', 'unit_count', 'state');
        $errors             = array_merge($errors, check_required_fields($required_fields));
        $fields_max_lengths = array('name' => 45, 'functional' => 45, 'unit_count' => 45, 'state' => 45);
        $errors             = array_merge($errors, check_max_field_lengths($fields_max_lengths));
        $fields_min_lengths = array('name' => 2, 'functional' => 8, 'unit_count' => 1, 'state' => 2);
        $errors             = array_merge($errors, check_min_field_lengths($fields_min_lengths));


        $component_id = $_GET['id'];
        $name         = trim($_POST['name']);                    // name for html input tag => name
        $functional   = trim($_POST['functional']);              // name for html input tag => functional
        $unit_count   = trim($_POST['unit_count']);              // name for html input tag => unit_count
        $state        = trim($_POST['state']);                   // name for html input tag => state
        $picture      = trim($_POST['picture']);                 // name for html input tag => picture
        $datasheet    = trim($_POST['datasheet']);               // name for html input tag => datasheet

        if (empty($errors)) {
            execute_stmt($update_component_stmt);
            close_stmt($update_component_stmt);
        }
    }

?>
