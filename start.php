<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	require 'functions.php';
	//require_once 'cronjobs/fakecron.php';
	checkLogin();
	$db_link = connect();
	getSettings($db_link);
	getFees($db_link);
	checkMember($db_link);
	chargeOverdueLoans($db_link)
?>

<!DOCTYPE HTML>
<html>
	<!-- HTML HEAD -->
	<?PHP includeHead('Chenken Welfare Association',0); ?>
		<link rel="stylesheet" href="css/stats.css" />
		<link rel = "stylesheet" href="css/mangoo.css">
	</head>
	<!-- HTML BODY -->
	<body>
		<!-- MENU -->
		<?PHP
				includeMenu(1)
		?>
		<!-- MENU MAIN -->
		<div id="menu_main">
			<a href="cust_search.php">Search Customer</a>
			<a href="cust_new.php">New Customer</a>
			<a href="loans_search.php">Search Loan</a>
			<a href="member.php">MyAccount</a>
		</div>

		<!-- Left Side of Dashboard -->
		<div class="content_left" style="width:50%;">
			<?PHP include $_SESSION['set_dashl']; ?>
		</div>

		<!-- Right Side of Dashboard -->
		<div  class="content_right" style="width:50%;">
			<?PHP include $_SESSION['set_dashr']; ?>
		</div>

		<!-- Logout Reminder Message -->
		<?PHP	checkLogout();	?>

	</body>
</html>
