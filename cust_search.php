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
	<?PHP includeHead('Customer Search',1); ?>
	
	<body>
		<!-- MENU -->
		<?PHP includeMenu(2); ?>
		<div id="menu_main">
			<a href="cust_search.php" id="item_selected">Search</a>
		    <?php if ($_SESSION['log_ugroup']=="admin"):?>

			<a href="cust_new.php">New Member</a>
			<?php endif ?>
			<a href="cust_act.php">Active Members</a>
			<a href="cust_inact.php">Inactive Members</a>
		</div>
					
		<!-- CONTENT: Customer Search -->
		<div class="content_center">
			
			<?PHP
			if ($_SESSION['set_csi'] == 1)
			echo '
				<form action="customer.php" method="get" style="margin-bottom:4.5em;">
					<p class="heading">Quick Search by ID</p>
					<input type="text" name="cust" placeholder="Customer ID" />
					<input type="submit" value="Search" />
				</form>';
			?>

			<form action="cust_result.php" method="post">
				<p class="heading">Detailed Member Search</p>
				<input type="text" name="cust_search_no" placeholder="Number or number part" tabindex=1 />
				<br/><br/>
				<input type="text" name="cust_search_name" placeholder="Name or name part" tabindex=2 />
				<br/><br/>
				<input type="text" name="cust_search_occup" placeholder="Occupation or part" tabindex=3 />
				<br/><br/>
				<input type="text" name="cust_search_addr" placeholder="Address or address part" tabindex=4 />
				<br/><br/><br/>
				<input type="submit" name="cust_search" value="Search" tabindex=5 />
			</form>
		</div>
	</body>
</html>