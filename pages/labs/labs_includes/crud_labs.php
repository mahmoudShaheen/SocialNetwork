<?php

/**********************************************************************************/

$insert_lab_stmt = $connection->prepare("INSERT INTO Labs(LabName, Contents, Place, About, Picture) Values(?, ?, ?, ?, ?)");

if ($insert_lab_stmt) {
    $insert_lab_stmt->bind_param("sssss", $lab_name, $contents, $place, $about, $picture);
} else {
    echo "Error..False";
}

/**********************************************************************************/

$read_all_labs_stmt = $connection->prepare("SELECT * FROM Labs");
$read_lab_stmt      = $connection->prepare("SELECT * FROM Labs WHERE labID = ?");

if ($read_lab_stmt) {
    $read_lab_stmt->bind_param("i", $lab_id);
} else {
     echo "Error..False";
}

/**********************************************************************************/

$update_lab_stmt = $connection->prepare("UPDATE Labs SET LabName = ?, Contents = ?, Place = ?, About = ?, Picture = ? WHERE labID = ?");

if ($update_lab_stmt) {
    $update_lab_stmt->bind_param("sssssi", $lab_name = NULL, $contents = NULL, $place = NULL, $about = NULL, $picture = NULL, $lab_id);
} else {
    echo "Error..False";
}

/**********************************************************************************/

$delete_lab_stmt = $connection->prepare("DELETE FROM Labs WHERE labID = ?");

if ($delete_lab_stmt) {
    $delete_lab_stmt->bind_param("i", $lab_id);
} else {
    echo "Error..False";
}

/**********************************************************************************/

?>
