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
	if (isset($_POST['search'])) { // Form has been submitted.
		$errors = array();
		
		$name = trim(mysql_prep($_POST['user']));
		
		if (($name) && !empty($name)) {
			$query = "SELECT * FROM user WHERE first_name LIKE '%$name%'";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
			$num_of_result = mysqli_num_rows($result);
			$search_result = '';
			for($i = 0; $i < $num_of_result; $i++){
				$row = mysqli_fetch_array($result);
				$search_result = $search_result . '<li><a href="get_user.php?id='.$row['user_id'].'">'.$row['first_name'].'</a></li>';
			}
		} else {
			$message = '<div class="alert alert-warning">Your search term is empty</div>' ;
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
					<h3 class="panel-title">Search User</h3>
				</div>
				<div class="panel-body">
					<?php if(isset($message)) echo $message; ?>
					<form class="rounded border-0" role="form" method="POST" action="">
						<input type="text" name="user" class="form-control" placeholder="Enter User's name">
						<button type="submit" name="search" value="search" class="btn form-control btn-block btn-default">Search</button>
					</form>
					<div>
						<?php if(isset($search_result)){
							echo "<h3>Search Result</h3>";
							echo '<ul class="nav">' . $search_result .'</ul>';
						} ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include("../../includes/footer_admin.php"); ?>