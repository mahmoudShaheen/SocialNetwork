<?php require_once("labs_includes/statement_functions.php"); ?>
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
        $required_fields    = array('lab_name', 'contents', 'place');
        $errors             = array_merge($errors, check_required_fields($required_fields));
        $fields_max_lengths = array('lab_name' => 45, 'contents' => 45, 'place' => 45);
        $errors             = array_merge($errors, check_max_field_lengths($fields_max_lengths));
        $fields_min_lengths = array('lab_name' => 8, 'contents' => 8, 'place' => 8);
        $errors             = array_merge($errors, check_min_field_lengths($fields_min_lengths));

        $lab_name = trim($_POST['lab_name']);                    // name for html input tag => title
        $contents = trim($_POST['contents']);                    // name for html input tag => idea
        $place    = trim($_POST['place']);                       // name for html input tag => place
        $about    = trim($_POST['about']);                       // name for html input tag => about
        $picture  = trim($_POST['picture']);                     // name for html input tag => picture

        if (empty($errors)) {
            execute_stmt($insert_lab_stmt);
            close_stmt($insert_lab_stmt);
        }
    }

 ?>
