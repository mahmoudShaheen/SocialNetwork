<?php
	require_once("../../includes/db_connection.php");
	global $connection;
?>
<?php require_once("../../includes/crud_components.php"); ?>
<?php require_once("../../includes/session.php"); ?>
<?php require_once("../../includes/functions.php"); ?>

<?php
	confirm_logged_in();
?>

		<!DOCTYPE html>
<html>
	<head>
		
		<title>Components - CSE Network</title>
    	<!-- Css -->
    	<link rel="stylesheet" href="../../stylesheets/component.css">
	</head>
</html>

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

<?php

	

    $all_components = read_all_components($read_all_components_stmt);

	echo '<table ><tr><th>Safe name</th><th>Component name</th><th>Component function</th><th>Available</th><th>Datasheet</th></tr>';
	while ($one_component = $all_components->fetch_assoc()) {

        $safe_id = $one_component['safe_id'];
		$read_safe_stmt = $connection->prepare("SELECT name FROM safe WHERE safe_id = ?");
		$read_safe_stmt->bind_param("i", $safe_id);
		$read_safe_stmt->execute();
		$safe = $read_safe_stmt->get_result();
		$safe_data = $safe->fetch_assoc();
	    echo '<tr><td>'.$safe_data['name'].'</td><td>'.$one_component['name'].'</td><td>'.$one_component['functional'].'</td><td>'.$one_component['count'].'</td><td>'.$one_component['Datasheet_url'].'</td></tr>';
	}
	echo '</table>';



/*
    while ($one_component = $all_components->fetch_assoc()) {

        $safe_id = $one_component['safe_id'];
		$read_safe_stmt = $connection->prepare("SELECT name FROM safe WHERE safe_id = ?");
		$read_safe_stmt->bind_param("i", $safe_id);
		$read_safe_stmt->execute();
		$safe = $read_safe_stmt->get_result();
		$safe_data = $safe->fetch_assoc();

		echo htmlentities($safe_data['name']);               // safe name entry
        echo htmlentities($one_component['name']);           // name entry
        echo htmlentities($one_component['functional']);     // functional entry
        echo htmlentities($one_component['count']);          // count entry
        echo htmlentities($one_component['state']);          // state entry
        echo htmlentities($one_component['Datasheet_url']);  // Datasheet entry
    }
*/
 ?>
</div></div>
<?php
	if(admin_check()){ //user is admin
		include("../../includes/footer_admin.php");
	}else{ //normal user
		include("../../includes/footer.php");
	}
?>
