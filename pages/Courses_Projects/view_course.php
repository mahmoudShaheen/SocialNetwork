<?php
/**
 * callback for  CoursesController.php > course_view()
 * This script is used to view single course if id provided in the url or view all courses if no id provided
 * by calling course_view() function in the CoursesController.php
 * 
 * php version 7.0.8
 * @version 1.0.0
 * @author Mustafa Kamel   May 2, 2017
 * @method GET
 * 
 * @param integer id    id of the course to be viewed, may be null to view all courses
 */


require_once ("CoursesController.php");
course_view();