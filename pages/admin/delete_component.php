<?php
	require_once("../../includes/components_includes/crud_components.php");
?>
<?php require_once("../../includes/session.php"); ?>
<?php
	// require_once("../../includes/db_connection.php");
	// global $connection;
?>
<?php require_once("../../includes/functions.php"); ?>

<?php
	confirm_logged_in();
	confirm_admin();
?>

<?php

    if ($_GET['id']) {
        $component_id = $_GET['id'];

        delete_component($delete_component_stmt, $component_id);
    }

 ?>

<?php include("../../includes/header_admin.php"); ?>
<?php include("../../includes/sidebar_admin.php"); ?>
<table id="structure">
	<tr>
		<td id="page">
			<h2>Delete Component</h2>
			<?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>
		</td>
	</tr>
</table>
<?php include("../../includes/footer_admin.php"); ?>
