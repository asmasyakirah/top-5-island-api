<?php
 
/*
    The important thing to realize is that the config file should be included in every
    page of your project, or at least any page you want access to these settings.
    This allows you to confidently use these settings throughout a project because
    if something changes such as your database credentials, or a path to a specific resource,
    you'll only need to update it here.
*/
 
$config = array
(
    "project" => "Top 5 Island",
    "version" => "1.0",
    "language" => "en",
    "timezone" => "Asia/Kuala_Lumpur",
    "url" => array
    ( 
        // (#1) localhost
        "base" => "localhost/top5island/"
    ),
    "db" => array
    (        
        // (#1) localhost
        "host" => "localhost",
        "port" => "",
        "name" => "top5island",
        "username" => "root",
        "password" => ""
    ),
    "path" => array
    (
        "resources" => "resources/",
    ),
    // List of APIs
    "apis" => array
    (
        "getTop5ByDate" => array("name" => "Get top 5 island by date","function" => "getTop5ByDate",
            "data" => ["visit_date"]),
        "getIsland" => array("name" => "Get island details","function" => "getIsland",
            "data" => ["island_id"])
    )
);

// rgba(237, 159, 0, 1)
// rgba(227, 119, 0, 1)
 
/*
    I will usually place the following in a bootstrap file or some type of environment
    setup file (code that is run at the start of every page request), but they work 
    just as well in your config file if it's in php (some alternatives to php are xml or ini files).
*/
 
/*
    Creating constants for heavily used paths makes things a lot easier.
    ex. require_once(LIBRARY_PATH . "Paginator.php")
*/
defined("LIBRARY_PATH")
    or define("LIBRARY_PATH", realpath(dirname(__FILE__) . '/library'));
     
defined("TEMPLATES_PATH")
    or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/templates'));
 
/*
    Error reporting.
*/
// Turn off error reporting
error_reporting(0); 
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
 
?>
