<?php require_once("../../includes/session.php"); ?>
<?php require_once("../../includes/functions.php"); ?>
<?php
	confirm_logged_in();
	confirm_admin();
?>

<?php
	include_once("../../includes/form_functions.php");

    if (isset($_GET['submit'])) {
        $errors = array();

        // perform validations on the new form data
        $required_fields    = array('id');
        $errors             = array_merge($errors, check_required_fields($required_fields));
        $fields_max_lengths = array('id' => 4);
        $errors             = array_merge($errors, check_max_field_lengths($fields_max_lengths));
        $fields_min_lengths = array('id' => 1);
        $errors             = array_merge($errors, check_min_field_lengths($fields_min_lengths));

    }
?>

<?php include("../../includes/header_admin.php") ?>
<?php include("../../includes/sidebar_admin.php"); ?>
        <!-- Page Content -->
        
                
            
        <div class="table">
            <div class="container">
<table id="structure">
    <tr>
        <td id="page">
            <h2>Search Projects</h2>
            <?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
            <?php if (!empty($errors)) { display_errors($errors); } ?>
            <form action="" method="get">
                <table>
    				<tr>
    					<td>Id:</td>
    					<td><input type="text" name="id" maxlength="45" value=""/></td>
    				</tr>
                    <tr>
    					<td colspan="2"><input type="submit" name="name" value="update" onclick="this.form.action='update_project.php'"/></td>
    					<td colspan="2"><input type="submit" name="name" value="delete" onclick="this.form.action='delete_project.php'"/></td>
    				</tr>
                </table>
            </form>
        </td>
    </tr>
</table></div></div>
<?php include("../../includes/footer_admin.php"); ?>
