<?php
/*
Plugin Name: Role Manger
Text Domain: mvc-base-plugin
Plugin URI: 
Description:  a Role Manager
Version: 1.1.0
Author: James Schüpbach
Author URI: http://cubetech.ch
License: A "Slug" license name e.g. GPL2
*/

include "core/Bootstrap.php";

\RoleManager\Core\Bootstrap::getInstance()->init();
$backend = \RoleManager\Core\MVCFactory::factory('Backend');


