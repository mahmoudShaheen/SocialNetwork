<?php

/**************************************************************************************/

$insert_user_stmt = $connection->prepare("INSERT INTO
	Users (FirstName, MiddleName, LastName, UserName, PasswordHash, PictureURL, Email, Phone, about)
	Values (?, ?, ?, ?, ?, ?, ?, ?, ?)");

if ($insert_user_stmt) {
	$insert_user_stmt->bind_param("sssssssss", $first_name, $middle_name, $last_name, $user_name, $password, $picture_url, $email, $phone, $about);
} else {
	echo "Error..False";
}

/**************************************************************************************/

$read_all_users_stmt  = $connection->prepare("SELECT * FROM Users");
$read_user_stmt       = $connection->prepare("SELECT * FROM Users WHERE userID = ?");

if ($read_user_stmt) {
	$read_user_stmt->bind_param("i", $user_id);
} else {
	echo "Error..False";
}

/*************************************************************************************/

$update_user_stmt = $connection->prepare("UPDATE Users
	SET FirstName = ?, MiddleName = ?, LastName = ?, UserName = ?, PasswordHash = ?, PictureURL = ?, Email = ?, Phone = ?, about = ?
	WHERE userID = ?");

if ($update_user_stmt) {
	$update_user_stmt->bind_param("sssssssssi",
		$first_name = NULL, $middle_name = NULL, $last_name = NULL, $user_name = NULL, $password = NULL, $picture_url = NULL, $email = NULL, $phone = NULL, $about = NULL,
		$user_id);
} else {
	echo "Error..False";
}

/************************************************************************************/

$delete_user_stmt = $connection->prepare("DELETE FROM Users WHERE userID = ?");

if ($delete_user_stmt) {
	$delete_user_stmt->bind_param("i", $user_id);
} else {
	echo "Error..False";
}

/***********************************************************************************/

?>
