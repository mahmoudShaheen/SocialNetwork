<?php 
	//check if user logged in
	//if not redirect to login page
	require_once("../../includes/session.php"); 
	confirm_logged_in(); 
	confirm_admin();
	$user_id = $_SESSION['user_id'];
?>
<?php
	require_once ("../../includes/courses_projects_model.php");
	if (isset($_GET['id']) && (int) $_GET['id'] > 0) {//id of the selected project to be updated
		$project_id = (int) $_GET['id'];
		$project = get_project_by_id ($project_id);
		$desc = $_POST['desc'];
		if (count($project) < 0) {//project not found
			echo "Project not found";
			exit;
		}
	}else{
		echo "Query string can't be empty'";
		exit;
	}
?>
<?php
	$target_dir = "../../uploads/project_files/".$project_id."/";
	if (!file_exists($target_dir)) {
		mkdir($target_dir, 0777, true);
	}
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$FileType = pathinfo($target_file,PATHINFO_EXTENSION);
	
	if(!isset($_POST["submit"])) {
		exit;
	}
	// Check if file already exists
	if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
	}
	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 500000) {
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
	}
	// Allow certain file formats
	if($FileType != "pdf" ) {
		echo "Sorry, only PDF files are allowed.";
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			$upload_time = date('Y-m-d H:i:s');
			insert_pfile($project_id, $user_id, $upload_time, $target_file, $desc);
			echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}
?>
