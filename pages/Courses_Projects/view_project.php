<?php
/**
 * callback for  ProjectsController.php > project_view()
 * This script is used to view single project if id provided in the url or view all projects if no id provided
 * by calling project_view() function in the ProjectsController.php
 * 
 * php version 7.0.8
 * @version 1.0.0
 * @author Mustafa Kamel   May 2, 2017
 * @method GET
 * 
 * @param integer id    id of the project to be viewed, may be null to view all projects
 */


require_once ("ProjectsController.php");
project_view();