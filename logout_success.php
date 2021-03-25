<!DOCTYPE HTML>
<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'functions.php';
header ('refresh:7; url=index.php');
?>

<html>
	<?PHP includeHead('Microfinance Management',1) ?>
		
	<body>
		<div class="content_center" style="margin-top:2em;">
			<img src="ico/mangoo_l.png" />
			<?PHP include 'version.html'; ?>
		</div>
	</body>
</html>