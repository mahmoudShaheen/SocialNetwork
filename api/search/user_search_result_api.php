<?php require_once("../../includes/session.php"); ?>
<?php 
	require_once("../../includes/db_connection.php");
	global $connection;
?>

<?php 
	//only works if user is logged in
	if (!logged_in_as()) {
		echo "[[Permission Denied!]]";
		exit;
	}
?>
<?php
	if (isset($_POST['result'])) {
		$year_result = $_POST['result'];
		//get user id, current time
		$user_id = $_SESSION['user_id'];	
			$query = "SELECT * FROM user WHERE user_id = $user_id";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
			$row = mysqli_fetch_array($result);	
			$res = $row[$year_result];
			if($res){
			$form_data = '';
			$unserialized_result = unserialize($res);
			foreach ($unserialized_result as $key => $value) {
				$form_data =	$form_data . '<div class="form-group">
							<label for="'.$key.'">'.$key.'</label>
							<input type="text" name="'.$key.'" class="form-control" value="'.$value.'" readonly>
						</div>';
			}
			} else {
				$form_data = "<label>Sorry you have no result for this year</label>";
			}
			

			$result_array = array('result' => false, 'data' => $form_data);
			echo json_encode($result_array);
		
			
	}else{
		echo "[[query can't be empty!]]";
		exit;
	}	
?>