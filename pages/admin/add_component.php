<?php require_once("../../includes/session.php"); ?>
<?php require_once("../../includes/crud_components.php"); ?>
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

    if (isset($_POST['submit'])) {
        $errors = array();
		
        // perform validations on the form data
        $required_fields    = array('name', 'functional', 'count', 'state', 'datasheet');
        $errors             = array_merge($errors, check_required_fields($required_fields));
        $fields_max_lengths = array('name' => 45, 'functional' => 45, 'count' => 45, 'state' => 45, 'datasheet' => 45);
        $errors             = array_merge($errors, check_max_field_lengths($fields_max_lengths));
        $fields_min_lengths = array('name' => 2, 'functional' => 1, 'count' => 1, 'state' => 1, 'datasheet' => 2);
        $errors             = array_merge($errors, check_min_field_lengths($fields_min_lengths));

        $name       = trim(mysql_prep($_POST['name']));                    // name for html input tag => name
        $functional = trim(mysql_prep($_POST['functional']));              // name for html input tag => functional
        $count      = trim(mysql_prep($_POST['count']));                   // name for html input tag => count
        $state      = trim(mysql_prep($_POST['state']));                   // name for html input tag => state
        $datasheet  = trim(mysql_prep($_POST['datasheet']));               // name for html input tag => datasheet
		$safename   = trim(mysql_prep($_POST['safename']));                // name for html input tag => safename

        if (empty($errors)) {
			$read_safe_stmt = $connection->prepare("SELECT safe_id FROM safe WHERE name = ?");
			$read_safe_stmt->bind_param("s", $safename);
			$read_safe_stmt->execute();
			$safe      = $read_safe_stmt->get_result();
			$safe_data = $safe->fetch_assoc();
			$safe_id   = trim(mysql_prep($safe_data['safe_id']));

            insert_component($insert_component_stmt, $safe_id, $name, $functional, $count, $state, $datasheet);
        }
    } else {
    	$name       = "";
		$functional = "";
		$count      = "";
		$state      = "";
		$datasheet  = "";
		$safename   = "";
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
			<h2>Add New Component</h2>
			<?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>
			<form action="add_component.php" method="post">
			<table>
				<tr>
					<td>Name:</td>
					<td><input type="text" name="name" maxlength="45" value="<?php echo htmlentities($name); ?>"/></td>
				</tr>
				<tr>
					<td>Functional:</td>
					<td><input type="text" name="functional" maxlength="45" value="<?php echo htmlentities($functional); ?>"/></td>
				</tr>
				<tr>
					<td>Count:</td>
					<td><input type="text" name="count" maxlength="45" value="<?php echo htmlentities($count); ?>"/></td>
				</tr>
				<tr>
					<td>State:</td>
					<td><input type="text" name="state" maxlength="45" value="<?php echo htmlentities($state); ?>"/></td>
				</tr>
                <tr>
					<td>Datasheet:</td>
					<td><input type="text" name="datasheet" maxlength="45" value="<?php echo htmlentities($datasheet); ?>"/></td>
				</tr>
				<tr>
					<td>Safe Name:</td>
					 <td><select name="safename">
  <option value="safe11">safe11</option>
  <option value="safe12">safe12</option>
  <option value="safe21">safe21</option>
  <option value="safe22">safe22</option>
  <option value="safe23">safe23</option>
</select> </td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="submit" value="Add Component" /></td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
</table></div></div>
<?php include("../../includes/footer_admin.php"); ?>
