<?php
/**
 * @author Mustafa kamel   April 18, 2017
 */

require_once("../../includes/db_connection.php");
/*
define ("HOSTNAME", "localhost");
define ("USERNAME", "root");
define ("PASSWORD", "root");
define ("DBNAME","mydb");

$connection = new mysqli(HOSTNAME, USERNAME, PASSWORD, DBNAME);
if ($connection->connect_error){
    die ("Connection Failed".$coneection->connect_error);
}
*/
/**************************************************Courses**************************************************/

 /**
  * Inserts new entry (i.e new course) in the end of the Courses table
  * cid and name can't be null
  * @param integer $cid
  * @param string $name
  * @param string $about
  * @param string $dept
  * @param string $grading_schema
  * @return boolean
  */
function insert_course ($name, $about=NULL, $dept=NULL, $grading_schema=NULL){
    global $connection;
    $course_ins= $connection->prepare("INSERT INTO `Courses` (`Name`, `about`, `department`, `Grading Schema`) VALUES (?, ?, ?, ?)");
    $course_ins->bind_param("ssss", $name, $about, $dept, $grading_schema);
    if($course_ins->execute()){
        $course_ins->close();
        return TRUE;
    }
    return FALSE;
}
/**
 * Updates the data of specific course (ID) (one row) in the Courses table
 * @param integer $cid
 * @param string $name
 * @param string $about
 * @param string $dept
 * @param string $grading_schema
 * @return boolean
 */
function update_course ($cid, $name, $about=NULL, $dept=NULL, $grading_schema=NULL){
    global $connection;
    $course_update=  $connection->prepare("UPDATE `Courses` SET `Name`=?, `about`=?, `department`=?, `Grading Schema`=? WHERE `idCourses`=?");
    $course_update->bind_param("ssssi",$name, $about, $dept, $grading_schema, $cid);
    if($course_update->execute()){
        $course_update->close();
        return TRUE;
    }
    return FALSE;
}
/**
 * Deletes the data of specific course (ID) (one row) from the Courses table
 * @param integer $cid
 * @return boolean
 */
function delete_course ($cid){
    global $connection;
    $course_delete= $connection->prepare("DELETE FROM `Courses` WHERE `idCourses`=?");
    $course_delete->bind_param("i", $cid);
    if($course_delete->execute()){
        $course_delete->close();
        return TRUE;
    }
    return FALSE;
}
/**
 * Get all rows from Courses table
 * @return array
 */
function get_courses (){
    global $connection;
    $rows = array();
    $query = "SELECT * FROM `Courses`";
    $result = mysqli_query($connection, $query);
    if (mysqli_num_rows($result) > 0)
        while ($row = mysqli_fetch_assoc($result)){
            $rows[]= $row;
        }
    else
        return FALSE;
    return $rows;
}
/**
 * Get specific course data from Courses table by its ID (one row)
 * @return array
 */
function  get_course_by_id ($cid){
    $cid= intval($cid);
    global $connection;
    $query = "SELECT * FROM `Courses` WHERE `idCourses` = ?";
	$stmt = mysqli_prepare($connection, $query);
	mysqli_stmt_bind_param($stmt, "s", $cid);
	if (mysqli_stmt_execute($stmt)) {
	    $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
    } else
        return FALSE;
	mysqli_stmt_close($stmt);
    return $row;
}

/**************************************************Projects**************************************************/

 /**
  * Inserts new entry (i.e new project) in the end of the Projects table
  * dateStarted and tag can't be null
  * @param string $idea
  * @param string $name
  * @param string $abstract
  * @param string $pic
  * @param string $st_date
  * @param string $end_date
  * @param integer $tag
  * @return boolean
  */
function insert_project ($idea, $name, $abstract=NULL, $pic=NULL, $st_date, $end_date=NULL, $tag){
    global $connection;
    $project_ins= $connection->prepare("INSERT INTO `Projects` (`Idea`, `name`, `abstract`, `picture`, `dateStarted`, `dateEnded`, `tag`) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $project_ins->bind_param("ssssssi", $idea, $name, $abstract, $pic, $st_date, $end_date, $tag);
    if($project_ins->execute()){
        $project_ins->close();
        return TRUE;
    }
    return FALSE;
}
/**
 * Updates the data of specific project (ID) (one row) in the Projects table
 * pid, dateStarted and tag can't be null
 * @param integer $pid
 * @param string $idea
 * @param string $name
 * @param string $abstract
 * @param string $pic
 * @param string $st_date
 * @param string $end_date
 * @param integer $tag
 * @return boolean
 */
function update_project ($pid, $idea, $name, $abstract=NULL, $pic=NULL, $st_date, $end_date=NULL, $tag){
    global $connection;
    $project_update=  $connection->prepare("UPDATE `Projects` SET `Idea`=?, `name`=?, `abstract`=?, `picture`=?, `dateStarted`, `dateEnded`, `tag` WHERE `idProjects`=?");
    $project_update->bind_param("ssssssii", $idea, $name, $abstract, $pic, $st_date, $end_date, $tag, $pid);
    if($project_update->execute()){
        $project_update->close();
        return TRUE;
    }
    return FALSE;
}
/**
 * Deletes the data of specific project (ID) (one row) from the Projects table
 * @param integer $pid
 * @return boolean
 */
function delete_project ($pid){
    global $connection;
    $project_delete= $connection->prepare("DELETE FROM `Projects` WHERE `idProjects`=?");
    $project_delete->bind_param("i", $pid);
    if($project_delete->execute()){
        $project_delete->close();
        return TRUE;
    }
    return FALSE;
}
/**
 * Get all rows from Projects table
 * @return array
 */
function get_projects (){
    global $connection;
    $rows = array();
    $query = "SELECT * FROM `Projects`";
    $result = mysqli_query($connection, $query);
    if (mysqli_num_rows($result) > 0)
        while ($row = mysqli_fetch_assoc($result)){
            $rows[]= $row;
        }
    else
        return FALSE;
    return $rows;
}
/**
 * Get specific project data from Projects table by its ID (one row)
 * @return array
 */
function  get_project_by_id ($pid){
    $pid= intval($pid);
    global $connection;
    $query = "SELECT * FROM `Projects` WHERE `idProjects` = ?";
	$stmt = mysqli_prepare($connection, $query);
	mysqli_stmt_bind_param($stmt, "s", $pid);
	if (mysqli_stmt_execute($stmt)) {
	    $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
    } else
        return FALSE;
	mysqli_stmt_close($stmt);
    return $row;
}

/**************************************************projectFiles**************************************************/

/**
 * Inserts new entry (i.e new projectFile) in the end of the projectFiles table
 * @param integer $uploader_id
 * @param string $upload_time
 * @param string $url
 * @param string $desc
 * @return boolean
 */
function insert_pfile ($uploader_id, $upload_time, $url, $desc){
    global $connection;
    $pfile_ins= $connection->prepare("INSERT INTO `projectFiles` (`uploaderID`, `uploadTime`, `URL`, `descreption`) VALUES (?, ?, ?, ?)");
    $pfile_ins->bind_param("isss", $uploader_id, $upload_time, $url, $desc);
    if($pfile_ins->execute()){
        $pfile_ins->close();
        return TRUE;
    }
    return FALSE;
}
/**
 * Updates the data of specific projectFile (ID) (one row) in the projectFiles table
 * @param integer $pid
 * @param string $upload_time
 * @param string $url
 * @param string $desc
 * @return boolean
 */
function update_pfile ($pid, $upload_time, $url, $desc){
    global $connection;
    $pfile_update=  $connection->prepare("UPDATE `projectFiles` SET `uploadTime`=?, `URL`=?, `descreption`=? WHERE `projectID`=?");
    $pfile_update->bind_param("sssi", $upload_time, $url, $desc, $pid);
    if($pfile_update->execute()){
        $pfile_update->close();
        return TRUE;
    }
    return FALSE;
}
/**
 * Deletes the data of specific projectFile (ID) (one row) from the projectFiles table
 * @param integer $pid
 * @return boolean
 */
function delete_pfile ($pid){
    global $connection;
    $pfile_delete= $connection->prepare("DELETE FROM `projectFiles` WHERE `projectID`=?");
    $pfile_delete->bind_param("i", $pid);
    if($pfile_delete->execute()){
        $pfile_delete->close();
        return TRUE;
    }
    return FALSE;
}
/**
 * Get all rows from projectFiles table
 * @return array
 */
function get_pfiles (){
    global $connection;
    $rows = array();
    $query = "SELECT * FROM `projectFiles`";
    $result = mysqli_query($connection, $query);
    if (mysqli_num_rows($result) > 0)
        while ($row = mysqli_fetch_assoc($result)){
            $rows[]= $row;
        }
    else
        return FALSE;
    return $rows;
}
/**
 * Get specific projectFile data from projectFiles table by its ID (one row)
 * @return array
 */
function  get_pfile_by_id ($pid){
    $pid= intval($pid);
    global $connection;
    $query = "SELECT * FROM `Projects` WHERE `idProjects` = ?";
	$stmt = mysqli_prepare($connection, $query);
	mysqli_stmt_bind_param($stmt, "s", $pid);
	if (mysqli_stmt_execute($stmt)) {
	    $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
    } else
        return FALSE;
	mysqli_stmt_close($stmt);
    return $row;
}