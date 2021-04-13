<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	require 'functions.php';
	checkLogin();
	$db_link = connect();
?>
<!DOCTYPE HTML>
<html>
	<!-- HTML HEAD -->
	<?PHP includeHead('Loan Search',1); ?>

	<body>
		<!-- MENU -->
		<?PHP
				includeMenu(3);
		?>
		<!-- MENU MAIN -->
		<div id="menu_main">
			<a href="loans_search.php" id="item_selected">Search</a>
			<a href="loans_act.php">Active Loans</a>
			<a href="loans_pend.php">Pending Loans</a>
			<a href="loans_securities.php">Loan Securities</a>
		</div>

		<!-- CONTENT: Loan Search -->
		<div class="content_center">

			<form action="loans_result.php" method="post">
				<p class="heading_narrow">Search Loan by Number</p>
				<input type="text" name="loan_no" placeholder="Loan Number" />
				<input type="submit" value="Search" />
			</form>

			<form action="loans_result.php" method="post" style="margin-top:4.5em;">
				<p class="heading_narrow">Search Loan by Status</p>
				<select name="loan_status">
					<option value="1">Pending</option>
					<option value="2">Approved</option>
					<option value="3">Refused</option>
					<option value="4">Abandoned</option>
					<option value="5">Cleared</option>
				</select>
				<input type="submit" value="Search" />
			</form>

		</div>

	</body>
</html>
