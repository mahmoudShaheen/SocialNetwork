<?php
/**
 * This script is used to view single project if id provided in the url or view all projects if no id provided
 * Get the data of specific project from `Projects` table in the database by its ID (one row) if it is provided in the url
 * Otherwise [if no id provided in the url] get all the projects
 * 
 * php version 7.0.8
 * @version 2.0.0
 * @author Mustafa Kamel   May 5, 2017
 * @method GET
 * 
 * @param integer id    id of the project to be viewed, may be null to view all projects
 */

require_once ("../../includes/courses_projects_model.php");
require_once ("../../includes/session.php");
require_once("../../includes/db_connection.php");
require_once("../../includes/functions.php");

confirm_logged_in();

global $connection;
if (isset($_GET['id']) && (int) $_GET['id'] > 0) {//id of the selected project to be viewed
	$id = (int) $_GET['id'];
	$project = get_project_by_id ($id);
	if (!count($project) > 0) { //project is not found
		$message = "An error has been occurred, Project is not found!";
	}
} else {//no id provided, get all the projects from the database
	$projects = get_projects ();
	if (!count($projects) > 0) { //projects table is empty
		$message = "An error has been occurred, No projects are found!";
	}
}
?>
<?php
	if(admin_check()){ //user is admin
		include("../../includes/header_admin.php");
		include("../../includes/sidebar_admin.php");
	}else{ //normal user
		include("../../includes/header.php");
		include("../../includes/sidebar.php");
	}
?>
		<!-- Page Content -->
		
				
			
		<div class="table">
			<div class="container">
<table id="structure">
<?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
<?php
	echo '<table ><tr><th>Project Supervisor</th><th>Project Idea</th><th>Project Name</th><th>Abstract</th><th>Date Started</th><th>Date Ended</th></tr>';
if (isset($project)){
	echo '<tr><td>'.$project['supervisor'].'</td><td>'.$project['idea'].'</td><td>'.$project['name'].'</td><td>'.$project['abstract'].'</td><td>'.$project['date_started'].'</td><td>'.$project['date_ended'].'</td></tr>';
	if(admin_check()){
		echo "<a href=\"update_project.php?id={$id}\"";
		echo "<a href=\"delete_project.php?id={$id}\"";
	}
} elseif (isset($projects)) {
	while ($project = mysqli_fetch_assoc($projects)) {
		echo '<tr><td>'.$project['supervisor'].'</td><td>'.$project['idea'].'</td><td>'.$project['name'].'</td><td>'.$project['abstract'].'</td><td>'.$project['date_started'].'</td><td>'.$project['date_ended'].'</td></tr>';
		if(admin_check()){ //add link for edit, delete
			//echo "<a href=\"update_project.php?id={$project['project_id']}\" ";
			//echo "<a href=\"delete_project.php?id={$project['project_id']}\" ";
		}
	}
}
?></table></div></div>
<?php
	if(admin_check()){ //user is admin
		include("../../includes/footer_admin.php");
	}else{ //normal user
		include("../../includes/footer.php");
	}
?>