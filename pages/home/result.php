
<?php 
	require_once("../../includes/session.php"); 
	require_once("../../includes/db_connection.php"); 
	global $connection;
?>
<?php require_once("../../includes/functions.php"); ?>

<?php 
	//check if user logged in
	//if not redirect to login page
	confirm_logged_in(); 
?>

<?php
	
	include("../../includes/header.php");
	include("../../includes/sidebar.php");
	
?>

<?php
	include_once("../../includes/form_functions.php");

	// Get current user's details.
	$id = $_SESSION['user_id'];
	$query = "SELECT * FROM user WHERE user_id = $id";
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	$row = mysqli_fetch_array($result);
	
	
?>
		<!-- Page Content -->
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default" style="margin-left: 0px; margin-top: 50px">
				<div class="panel-heading">
					<h3 class="panel-title">Your Result Details</h3>
				</div>
				<div class="panel-body">
					<?php if(isset($message)) echo $message; ?>
					<?php if(isset($_SESSION['message'])){ 
							echo $_SESSION['message'];
							$_SESSION['message'] = ''; 
						}
					?>
					<form id="main-form" class="rounded border-0" role="form" method="POST" action="update_user_score.php">
						<div class="form-group">
							<label for="user">Name</label>
							<input type="text" name="user" class="form-control" value="<?php echo $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];?>" readonly>
						</div>

						<div class="form-group">
							<label for="college_role">College Role</label>
							<input type="text" name="college_role" class="form-control" value="<?php echo $row['college_role'];?>" readonly>
						</div>
						<div class="form-group">
						<label for="year">Select Subject year</label>
						<select name="year" class="form-control" id="level-select">
						 	<option value="" selected disabled>Select Subject Year</option>
						 	<option value="year_one_result">1</option>
						 	<option value="year_two_result">2</option>
						 	<option value="year_three_result">3</option>
						 	<option value="year_four_result">4</option>
						</select>
						</div>
						<div id="holder" style="margin-top: 10px"></div>
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
	<script type="text/javascript">
	$('#level-select').on('change', function() {
  		// Send the data using post
		var posting = $.post( "../../api/search/user_search_result_api.php", { result: this.value } );
		posting.done(function(data){
			console.log(data);
			var data = JSON.parse(data);
				$('#holder').html(data.data);
			
		});
	})
</script>

</div>
<?php
	 
	include("../../includes/footer.php");
	
?>
