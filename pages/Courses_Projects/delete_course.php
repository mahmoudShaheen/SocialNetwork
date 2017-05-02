<?php
/**
 * callback for  CoursesController.php > course_delete()
 * This script is used to delete an exist course in the database
 * by calling course_delete() function in the CoursesController.php
 * 
 * php version 7.0.8
 * @version 1.0.0
 * @author Mustafa Kamel   May 2, 2017
 * @method GET
 * 
 * @param integer id        id of the course to be deleted
 */


require_once ("CoursesController.php");
course_delete();