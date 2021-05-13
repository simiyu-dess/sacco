<?PHP
require "fuctions.php";
require 'functions.php';
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	//session_start();
	$fingerprint = fingerprint();
    $db_link = connect();
    

    if(isset($_POST['register']))
    {
    $member_id = sanitize($db_link, $_POST['user_id']);
    $user_name = sanitize($db_link, $_POST['user_name']);
    $password = password_hash(sanitize($db_link, $_POST['password']));


    $sql_select_user = "SELECT member_id";
 


    }





?>
<!DOCTYPE HTML>
<html>

<form method="POST" name ="register" action="">

<input type="" name="user_id" placeholder="Enter member id"/>
<input type="text" name="user_name" palceholder = "Enter the user name" />
<input type = "text" name = "password" placeholder = "Enter the password"/>
<input type ="text" name= "repeat_password" placeholder ="Re type the password"/>
</form>
</html>