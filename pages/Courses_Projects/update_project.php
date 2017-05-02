<?php
/**
 * callback for  ProjectsController.php > project_update()
 * This script is used to update an exist project in the database
 * by calling project_update() function in the ProjectsController.php
 * 
 * php version 7.0.8
 * @version 1.0.0
 * @author Mustafa Kamel   May 2, 2017
 * @method POST
 * 
 * @param integer id        id of the project to be updated
 * @param integer supervisor supervisor of the project to be updated
 * @param string idea       idea of the project to be updated
 * @param string name       name of the project to be updated
 * @param string abstract   abstract description of the project to be updated
 * @param string pic        picture url of the project to be updated
 * @param string st_date    starting date of the project to be updated
 * @param string end_date   end date of the project to be updated
 * @param integer tag       teg of the project to be updated
 */


require_once ("ProjectsController.php");
project_update();