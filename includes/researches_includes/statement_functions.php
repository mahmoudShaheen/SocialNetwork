<?php
	require_once("../../includes/db_connection.php");
	global $connection;

	require_once("crud_researches.php");
	require_once("crud_user.php");
?>

<?php

	function execute_stmt($stmt) {
		$stmt->execute();
	}

	function close_stmt($stmt) {
		$stmt->close();
	}

	/*****************************************************************************/

	function read_all_researches($read_all_researches_stmt) {
		$read_all_researches_stmt->execute();

	    $research_data = $read_all_researches_stmt->get_result();

		return $research_data;
	}

	function read_research_by_id($read_research_stmt) {
		$read_research_stmt->execute();

		$research_data = $read_research_stmt->get_result();

		return $research_data;
	}

	/***************************************************************************/

	function read_user_by_id($read_user_stmt) {
		$read_user_stmt->execute();

		$user_data = $read_user_stmt->get_result();

		return $user_data;
 	}

	/****************************************************************************/

	function read_user_research($user_research_stmt) {
		$user_research_stmt->execute();

		$user_research_id = $user_research_stmt->get_result();

		return $user_research_id;
	}

?>
