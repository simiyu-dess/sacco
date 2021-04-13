<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'functions.php';
header ('refresh:4; url=index.php');
?>

<!DOCTYPE HTML>
<html>
	<?PHP includeHead('Microfinance Management',1) ?>
		
	<body>
		<div class="content_center" style="margin-top:2em;">
			<img src=""  alt = "CHENKEN ASSOCIATION"/>
			<?PHP include 'version.html'; ?>
		</div>
	</body>
</html>