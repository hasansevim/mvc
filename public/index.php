<?php

// Turn on errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Setup vars
$controllerName = null;
$methodName = null;
$notfound = false;

// Check if controller and vars were passed
if (isset($_GET['controller']) && isset($_GET['method'])) {

	// Check if the controller exists:ucfirst:first character uppercase
	$controllerName = ucfirst(strtolower($_GET['controller'])).'Controller';
	if (file_exists('../controllers/'.$controllerName.'.php')) {

		// Instantiate controller object
		require_once('../controllers/'.$controllerName.'.php');
		$controller = new $controllerName;
	
		// Check if method exists
		$methodName = $_GET['method'];
		if (method_exists($controller, $methodName)) {

			// Call controller method
			$controller->$methodName();

		} else {
			$notfound = true; // 404
		}

	} else {
		$notfound = true;  //404
	}

} else {
	$notfound = true; // 404

}

// Show 404 if needed
if ($notfound) {
	header($_SERVER["SERVER_PROTOCOL"].' 404 Not Found');
	exit;
}

?>