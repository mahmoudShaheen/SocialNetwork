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
// Check if request was issued using post.
	// START FORM PROCESSING
	if (isset($_POST['submit'])) { // Form has been submitted.
		$errors = array();
		
		$name = trim(mysql_prep($_POST['subject_name'][0]));
		$total_degree = trim(mysql_prep($_POST['total_degree'][0]));
		$year = trim(mysql_prep($_POST['year'][0]));
		$subject_code = trim(mysql_prep($_POST['subject_code'][0]));

		// perform validations on the form data
		$required_fields = array($name, $total_degree, $year);
		$errors = array_merge($errors, check_required_subject_fields($required_fields));
		
		if ( empty($errors) ) {
			$query = "INSERT INTO subject (name, total_degree, year, subject_code) VALUES (?, ?, ?, ?)";
			$add_subject_stmt = mysqli_prepare($connection, $query);
			mysqli_stmt_bind_param($add_subject_stmt, "sisi", $name, $total_degree, $year, $subject_code);
			mysqli_stmt_execute($add_subject_stmt);
			$result = mysqli_stmt_get_result($add_subject_stmt);
			mysqli_stmt_close($add_subject_stmt);
				
			if (mysqli_affected_rows($connection)) {
					
				$message = '<div class="alert alert-success">The subject was successfully created.</div>';

			} else {
				$message = '<div class="alet alert-danger">The subject could not be created.</div>';
				$message .= "<br />";
			}

		} else {
			$message = '<div class="alert alert-warning">There were '.count($errors). ' errors in the form.</div>' ;
		}
	}
?>
<?php include("../../includes/header_admin.php"); ?>
<?php include("../../includes/sidebar_admin.php"); ?>

		<!-- Page Content -->
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default" style="margin-left: 0px; margin-top: 50px">
				<div class="panel-heading">
					<h3 class="panel-title">Add Subjects</h3>
				</div>
				<div class="panel-body">
					<?php if(isset($message)) echo $message; ?>
					<form class="rounded border-0" role="form" method="POST" action="">
						<div class="form-group">
						 	<input type="text" class="form-control" name="subject_name[]" placeholder="Enter Subject Title">
						 	<input type="text" class="form-control" name="total_degree[]" placeholder="Enter Total Degree">
						 	<input type="text" class="form-control" name="subject_code[]" placeholder="Subject Code">
						 	<select name="year[]" class="form-control">
						 		<option value="" selected disabled>Select Subject Level</option>
						 		<option value="year_one_result">1</option>
						 		<option value="year_two_result">2</option>
						 		<option value="year_three_result">3</option>
						 		<option value="year_four_result">4</option>
						 	</select>
						</div>

						<button type="submit" name="submit" value="submit" class="btn form-control btn-block btn-default">Submit</button>
					</form>


				</div>
			</div>
		</div>
	</div>
</div>

<?php include("../../includes/footer_admin.php"); ?>