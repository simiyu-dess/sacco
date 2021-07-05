<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
	* Check for database configuration file.
	* If it exists, proceed to login page.
	* If it doesn't, call the setup page.
	*/
	
	if(file_exists('config/config.php')) header('Location: logins.php');
	
	else header('Location: setup.php');

?>