<?php
/**
 * callback for  CoursesController.php > course_insert()
 * This script is used to add a new course to the database if it isn't exist
 * by calling course_insert() function in the CoursesController.php
 * 
 * php version 7.0.8
 * @version 1.0.0
 * @author Mustafa Kamel   May 2, 2017
 * @method POST
 * 
 * @param string name      name of the course to be added
 * @param string about     description of the course to be added
 * @param string department       department of the course to be added
 * @param string grading_schema    grading_schema of the course to be added
 */


require_once ("CoursesController.php");
course_insert();