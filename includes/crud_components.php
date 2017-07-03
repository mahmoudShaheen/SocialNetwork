<?php
    require_once("../../includes/db_connection.php");
    global $connection;
?>

<?php

    $insert_component_stmt = $connection->prepare("INSERT INTO `component`( `safe_id`, `name`, `functional`, `count`, `state`, `Datasheet_url`) Values(?, ?, ?, ?, ?, ?)");

    function insert_component($insert_component_stmt, $safe_id, $name, $functional, $count, $state, $datasheet) {
        if ($insert_component_stmt) {
            $insert_component_stmt->bind_param("issiis", $safe_id, $name, $functional, $count, $state, $datasheet);
        } else {
            echo "Error..False";
        }

        $insert_component_stmt->execute();
        $insert_component_stmt->close();
    }

    /**********************************************************************************/

    $read_all_components_stmt = $connection->prepare("SELECT * FROM `component`");
    $read_component_stmt      = $connection->prepare("SELECT * FROM `component` WHERE `component_id` = ?");

    function read_all_components($read_all_components_stmt) {
        $read_all_components_stmt->execute();

        $components_data = $read_all_components_stmt->get_result();

        $read_all_components_stmt->close();

		return $components_data;
    }

    function read_component_by_id($read_component_stmt, $component_id) {

        if ($read_component_stmt) {
            $read_component_stmt->bind_param("i", $component_id);
        } else {
             echo "Error..False";
        }

		$read_component_stmt->execute();

		$component_data = $read_component_stmt->get_result();

        $read_component_stmt->close();

		return $component_data;
	}

    /**********************************************************************************/

    $update_component_stmt = $connection->prepare("UPDATE `component`
        SET `safe_id` = ?, `name` = ?, `functional` = ?, `count` = ?, `state` = ?, `Datasheet_url` = ?
        WHERE `component_id` = ?");

    function update_component($update_component_stmt, $safe_id = NULL, $name = NULL, $functional = NULL, $count = NULL, $state = NULL, $datasheet_url = NULL, $component_id) {
        if ($update_component_stmt) {
            $update_component_stmt->bind_param("issiisi", $safe_id, $name, $functional, $count, $state, $datasheet_url, $component_id);
            $update_component_stmt->execute();
            $update_component_stmt->close();
        } else {
            echo "Error..False";
        }
    }

    /**********************************************************************************/

    $delete_component_stmt = $connection->prepare("DELETE FROM `component` WHERE `component_id` = ?");

    function delete_component($delete_component_stmt, $component_id) {
        if ($delete_component_stmt) {
            $delete_component_stmt->bind_param("i", $component_id);
        } else {
            echo "Error..False";
        }

        $delete_component_stmt->execute();
        $delete_component_stmt->close();
    }

    /**********************************************************************************/

?>
