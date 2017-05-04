<?php require_once("researches_includes/statement_functions.php"); ?>
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

    if ($_POST) {                                    // use the method attribute set for 'post' in the form html tag
        $errors = array();

        // perform validations on the form data
        $required_fields    = array('title', 'idea');
        $errors             = array_merge($errors, check_required_fields($required_fields));
        $fields_max_lengths = array('title' => 45, 'idea' => 45);
        $errors             = array_merge($errors, check_max_field_lengths($fields_max_lengths));
        $fields_min_lengths = array('title' => 8, 'idea' => 8);
        $errors             = array_merge($errors, check_min_field_lengths($fields_min_lengths));

        $title = trim($_POST['title']);                   // name for html input tag => title
        $idea  = trim($_POST['idea']);                    // name for html input tag => idea

        if (empty($errors)) {
            execute_stmt($insert_research_stmt);
            close_stmt($insert_research_stmt);
        }
    }

 ?>
