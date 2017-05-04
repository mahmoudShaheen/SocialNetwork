<?php
	require_once("../../../includes/db_connection.php");
	global $connection;

	require_once("crud_components.php");
?>

<?php

	function execute_stmt($stmt) {
		$stmt->execute();
	}

	function close_stmt($stmt) {
		$stmt->close();
	}

	/*****************************************************************************/

	function read_all_components($read_all_components_stmt) {
		$read_all_components_stmt->execute();

	    $components_data = $read_all_components_stmt->get_result();

		return $components_data;
	}

	function read_component_by_id($read_component_stmt) {
		$read_component_stmt->execute();

		$component_data = $read_component_stmt->get_result();

		return $component_data;
	}

	/***************************************************************************/

?>
