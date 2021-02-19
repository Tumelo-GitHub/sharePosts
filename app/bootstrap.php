<?php
//load config
require_once 'config/config.php';
// load helpers
require_once 'helpers/url_help.php';
require_once 'helpers/session_help.php';

// Loading Libraries (manually)
/*
require_once 'libraries/Core.php';
require_once 'libraries/Controller.php';
require_once 'libraries/Database.php';
*/

// auto loads core libraries
//This function auto matically adds files that are required from the library
// RULE: CLASS NAME MUST MATCH THE FILE NAME, EG. CORE.PHP MUST HAVE CLASS NAMEN CORE
spl_autoload_register(function($className){
  require_once 'libraries/' . $className . '.php';
});