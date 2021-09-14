<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	require 'functions.php';
	checkLogin();
	$db_link = connect();
	getSettings($db_link);
	getFees($db_link);
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
		<?php if($_SESSION['log_ugroup']  == "admin"): ?>
			<a href="cust_search.php">Search Member</a>
			<a href="cust_new.php">New Member</a>
			<a href="loans_search.php">Search Loan</a>
			<?php endif ?>
			<?php if ($_SESSION['log_ugroup'] == "members"):?>
			
           <a href="member.php">MyAccount</a>
			<?php endif ?>
			
		</div>

		<!-- Left Side of Dashboard -->
		<div class="content_left" style="width:50%; Height:75%">
			<?PHP include $_SESSION['set_dashl']; ?>
		</div>

		<!-- Right Side of Dashboard -->
		<div  class="content_right" style="width:50%; Height:75%">
			<?PHP include $_SESSION['set_dashr']; ?>
		</div>

	</body>
</html>
