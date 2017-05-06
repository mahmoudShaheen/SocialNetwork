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
require_once("../../includes/form_functions.php");

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
<?php include("../../includes/header_admin.php"); ?>
<table id="structure">
	<tr>
		<td id="page">
			<h2>View Projects</h2>
			<?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>
			<form action="view_project.php" method="post">
			<table>
            <?php
            if (isset($project)){
				echo "<tr>
					      <td>Supervisor:</td>
					      <td>{$project['Supervisor']}</td>
					      <td>Idea:</td>
					      <td>{$project['Idea']}</td>
					      <td>Name:</td>
					      <td>{$project['name']}</td>
					      <td>Abstract:</td>
					      <td>{$project['abstract']}</td>
					      <td>Picture URL:</td>
					      <td>{$project['Picture_URL']}</td>
					      <td>Starting Date:</td>
					      <td>{$project['dateStarted']}</td>
					      <td>End Date:</td>
					      <td>{$project['dateEnded']}</td>
					      <td>Tag:</td>
					      <td>{$project['tag']}</td>
					      <td><a href=\"update_project.php?id={$id}\" class=\"button\">Update</a></td>
					      <td><a href=\"delete_project.php?id={$id}\" class=\"button\">Delete</a></td>
				      </tr>";
            } elseif (isset($projects)) {
                while ($project = array_shift($projects)) {
                    echo "<tr>
					          <td>Supervisor:</td>
					          <td>{$project['Supervisor']}</td>
					          <td>Idea:</td>
					          <td>{$project['Idea']}</td>
					          <td>Name:</td>
					          <td>{$project['name']}</td>
					          <td>Abstract:</td>
					          <td>{$project['abstract']}</td>
					          <td>Picture URL:</td>
					          <td>{$project['Picture_URL']}</td>
					          <td>Starting Date:</td>
					          <td>{$project['dateStarted']}</td>
					          <td>End Date:</td>
					          <td>{$project['dateEnded']}</td>
					          <td>Tag:</td>
					          <td>{$project['tag']}</td>
					      	  <td><a href=\"update_project.php?id={$project['idProjects']}\" class=\"button\">Update</a></td>
					      	  <td><a href=\"delete_project.php?id={$project['idProjects']}\" class=\"button\">Delete</a></td>
				          </tr>";
                }
            }
            ?>
			</table>
			</form>
		</td>
	</tr>
</table>
<?php include("../../includes/footer.php"); ?>