<?php
	require_once("../../includes/db_connection.php");
	global $connection;
?>
<?php require_once("../../includes/components_includes/crud_components.php"); ?>
<?php require_once("../../includes/session.php"); ?>
<?php require_once("../../includes/functions.php"); ?>

<?php
	confirm_logged_in();
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
<?php

    $all_components = read_all_components($read_all_components_stmt);

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

 ?>

<?php
	if(admin_check()){ //user is admin
		include("../../includes/footer_admin.php");
	}else{ //normal user
		include("../../includes/footer.php");
	}
?>
