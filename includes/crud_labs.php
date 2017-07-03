<?php
    require_once("../../includes/db_connection.php");
 ?>

<?php

    function insert_lab($user_id, $name, $location, $about) {
        global $connection;

        $insert_lab_stmt = $connection->prepare("INSERT INTO `lab` (`user_id`, `name`, `location`, `about`) Values(?, ?, ?, ?)");

        if ($insert_lab_stmt) {
            $insert_lab_stmt->bind_param("isss", $user_id, $name, $location, $about);
            $insert_lab_stmt->execute();
            $insert_lab_stmt->close();
        } else {
            echo "Error..False";
        }
    }

    /**********************************************************************************/

    $read_all_labs_stmt = $connection->prepare("SELECT * FROM `lab`");
    $read_lab_stmt      = $connection->prepare("SELECT * FROM `lab` WHERE `lab_id` = ?");

    function read_all_labs($read_all_labs_stmt) {
        $read_all_labs_stmt->execute();

	    $labs_data = $read_all_labs_stmt->get_result();

        $read_all_labs_stmt->close();

		return $labs_data;
    }

    function read_lab_by_id($read_lab_stmt, $lab_id) {
        if ($read_lab_stmt) {
            $read_lab_stmt->bind_param("i", $lab_id);
        } else {
             echo "Error..False";
        }

        $read_lab_stmt->execute();

        $lab_data = $read_lab_stmt->get_result();

        $read_lab_stmt->close();

		return $lab_data;
    }

    /**********************************************************************************/

    function update_lab($user_id = NULL, $name = NULL, $location = NULL, $about = NULL, $lab_id) {
        global $connection;

        $update_lab_stmt = $connection->prepare("UPDATE `lab` SET `user_id` = ?, `name` = ?, `location` = ?, `about` = ? WHERE `lab_id` = ?");

        if ($update_lab_stmt) {
            $update_lab_stmt->bind_param("isssi", $user_id, $name, $location, $about, $lab_id);
            $update_lab_stmt->execute();
            $update_lab_stmt->close();
        } else {
            echo "Error..False";
        }
    }

    /**********************************************************************************/

    $delete_lab_stmt = $connection->prepare("DELETE FROM `lab` WHERE `lab_id` = ?");

    function delete_lab($delete_lab_stmt, $lab_id) {
        if ($delete_lab_stmt) {
            $delete_lab_stmt->bind_param("i", $lab_id);
            $delete_lab_stmt->execute();
            $delete_lab_stmt->close();
        } else {
            echo "Error..False";
        }
    }

    /**********************************************************************************/

?>
