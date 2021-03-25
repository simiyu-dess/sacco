<?PHP	
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$newPepper = "";
$charUniverse = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789,.:-_!%&=?";
$numberChar = 10;

for($i = 0; $i < $numberChar; $i++){
	$randInt = mt_rand(0,71);
	$randChar = $charUniverse[$randInt];
	$newPepper = $newPepper.$randChar;
}

$mngpepper = "
<?PHP
/**
	*	Password pepper
	*/
	\$pepper = '".$newPepper."';
?>";

// Create new pepper file
file_put_contents("config/pepper.php", $mngpepper);
?>