<?php
/**
 * callback for  ProjcetsController.php > project_delete()
 * This script is used to delete an exist project in the database
 * by calling project_delete() function in the ProjectsController.php
 * 
 * php version 7.0.8
 * @version 1.0.0
 * @author Mustafa Kamel   May 2, 2017
 * @method GET
 * 
 * @param integer id        id of the project to be deleted
 */


require_once ("ProjcetsController.php");
project_delete();