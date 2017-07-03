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
		$user_id = $_POST['user_id'];
		$query = "select * FROM user where user_id = $user_id";
		$result  = mysqli_query($connection, $query);
		$row = mysqli_fetch_array($result);
		$user_result = $row[$year_result];
		if(!$user_result || empty($user_result)){
			$query_2 = "select * FROM subject WHERE year = '$year_result'";
			$result_res = mysqli_query($connection, $query_2) or die(mysqli_error($connection));
			$form_data = '';
			while($row = mysqli_fetch_array($result_res)){
				$form_data =	$form_data . '<div class="form-group">
							<label for="'.$row['name'].'">'.$row['name'].'</label>
							<input type="text" name="'.$row['name'].'" class="form-control" placeholder="Enter score for '.$row['name'].'">
						</div>';
			}
			if($form_data){
				$form_data = $form_data . '<button type="submit" name="submit" value="submit" class="btn form-control btn-block btn-default">submit</button>';
			} else {
				$form_data = "<label>Sorry user has no result for this year</label>";
			}
			$result_array = array('result' => false, 'data' => $form_data);
			echo json_encode($result_array);
		}else{
			$query = "SELECT * FROM user WHERE user_id = $user_id";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
			$row = mysqli_fetch_array($result);
			$res = $row[$year_result];
			$form_data = '';
			$unserialized_result = unserialize($res);
			foreach ($unserialized_result as $key => $value) {
				$form_data =	$form_data . '<div class="form-group">
							<label for="'.$key.'">'.$key.'</label>
							<input type="text" name="'.$key.'" class="form-control" value="'.$value.'">
						</div>';
			}
			$form_data = $form_data . '<button type="submit" name="submit" value="submit" class="btn form-control btn-block btn-default">submit</button>';

			$result_array = array('result' => false, 'data' => $form_data);
			echo json_encode($result_array);
		}
			
	}else{
		echo "[[query can't be empty!]]";
		exit;
	}	
?>