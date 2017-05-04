<?php
	require_once("../../includes/db_connection.php");
	global $connection;

	require_once("crud_labs.php");
?>

<?php

	function execute_stmt($stmt) {
		$stmt->execute();
	}

	function close_stmt($stmt) {
		$stmt->close();
	}

	/*****************************************************************************/

	function read_all_labs($read_all_labs_stmt) {
		$read_all_labs_stmt->execute();

	    $labs_data = $read_all_labs_stmt->get_result();

		return $labs_data;
	}

	function read_lab_by_id($read_lab_stmt) {
		$read_lab_stmt->execute();

		$lab_data = $read_lab_stmt->get_result();

		return $lab_data;
	}

	/***************************************************************************/

?>
