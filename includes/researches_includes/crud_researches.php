<?php

	/**************************************************************************************/

	$insert_research_stmt = $connection->prepare("INSERT INTO
		Researches (Title, Idea)
		Values     (?, ?)");

	if ($insert_research_stmt) {
		$insert_research_stmt->bind_param("ss", $title, $idea);
	} else {
		echo "Error..False";
	}

	/**************************************************************************************/

	$read_all_researches_stmt  = $connection->prepare("SELECT * FROM Researches");
	$read_research_stmt        = $connection->prepare("SELECT * FROM Researches WHERE idResearches = ?");

	if ($read_research_stmt) {
		$read_research_stmt->bind_param("i", $research_id);
	} else {
		echo "Error..False";
	}

	/*************************************************************************************/

	$update_research_stmt = $connection->prepare("UPDATE Researches
		SET Title = ?, Idea = ?
		WHERE idResearches = ?");

	if ($update_research_stmt) {
		$update_research_stmt->bind_param("ssi",
			$title = NULL, $idea = NULL,
			$idResearches);
	} else {
		echo "Error..False";
	}

	/************************************************************************************/

	$delete_research_stmt = $connection->prepare("DELETE FROM Researches WHERE idResearches = ?");

	if ($delete_research_stmt) {
		$delete_research_stmt->bind_param("i", $research_id);
	} else {
		echo "Error..False";
	}

	/***********************************************************************************/

	$user_research_stmt = $connection->prepare("SELECT Professor/Teacher_id FROM Professor_Working_On_Researches WHERE Researches_idResearches = ?");

	if ($user_research_stmt) {
		$user_research_stmt->bind_param("i", $idResearches);
	} else {
		echo "Error..False";
	}

	/***********************************************************************************/

?>
