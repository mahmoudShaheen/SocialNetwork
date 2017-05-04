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

	/* function read_research_by_id($read_research_stmt) {
		$read_research_stmt->execute();

		$research_data = $read_research_stmt->get_result();

		$row = $research_data->fetch_array(MYSQLI_NUM);

		foreach ((array) $row as $value) {
			echo "$value</br>";
		}
	} */

	/***************************************************************************/

?>
