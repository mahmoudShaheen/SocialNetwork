<?php
/**
 * callback for  CoursesController.php > course_update()
 * This script is used to update an exist course in the database
 * by calling course_update() function in the CoursesController.php
 * 
 * php version 7.0.8
 * @version 1.0.0
 * @author Mustafa Kamel   May 2, 2017
 * @method POST
 * 
 * @param integer id        id of the course to be updated
 * @param string name       name of the course to be updated
 * @param string about      description of the course to be updated
 * @param string department       department of the course to be updated
 * @param string grading_schema    grading_schema of the course to be updated
 */


require_once ("CoursesController.php");
course_update();