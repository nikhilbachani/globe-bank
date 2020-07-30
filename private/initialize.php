<?php
	// start output buffering
	ob_start(); // needs to come before any content

	// Assign absolute file paths to PHP constants
	// __FILE__ returns the current path to this file
	// dirname() returns the path to the parent directory
	define('PRIVATE_PATH', dirname(__FILE__));
	define('PROJECT_PATH', dirname(PRIVATE_PATH));
	define('PUBLIC_PATH', PROJECT_PATH . '/public');
	define('SHARED_PATH', PRIVATE_PATH . '/shared');
	
	// echo PRIVATE_PATH . '<br />'; // folder paths
	// echo PROJECT_PATH  . '<br />';
	// echo PUBLIC_PATH . '<br />';
	// echo SHARED_PATH . '<br />';

	// NOTE" the constants define above represent file paths
	// on a hard drive (server). But, the constants defined
	// below define web paths.

	// Asssign the web root URL to a PHP constant
	// * Do not include the domain
	// * Use same document root as web server
	// * Way 1: Can set a hard-coded value:
	// define("WWW_ROOT", '~nikhilbachani/globe_bank/public');
	// define("WWW_ROOT", ''); // on a production machine
	// * Way 2: Can dynamically find everything in URL up to "/public"
	$public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
	$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
	// echo $_SERVER['SCRIPT_NAME'] . '<br />';
	// echo $public_end . '<br />';
	// echo $doc_root . '<br />';
	define("WWW_ROOT", $doc_root);

	require_once('functions.php'); // load all code in functions.php. Always use static strings ('') here, to prevent security issues that dynamic data ("") may create.
	require_once('database.php');
	require_once('query_functions.php');
	require_once('validation_functions.php');

	$db = db_connect();
	$errors = [];
?>
