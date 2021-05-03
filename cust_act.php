<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	require 'functions.php';
	checkLogin();
	$db_link = connect();

	//Make array for exporting data
	$rep_year = date("Y",time());
	$rep_month = date("m",time());
	$_SESSION['rep_export'] = array();
	$_SESSION['rep_exp_title'] = $rep_year.'-'.$rep_month.'_cust-active';
	$_SESSION['members']=array();

	//Select active customers from CUSTOMER
	$query_custact = getCustAct($db_link);
?>

<!DOCTYPE HTML>	
<html>
	<?PHP includeHead('Active Customers',1) ?>

	<body>
		<!-- MENU -->
		<?PHP includeMenu(2); ?>
		<div id="menu_main">
			<a href="cust_search.php">Search</a>
			<a href="cust_new.php">New Customer</a>
			<a href="cust_act.php" id="item_selected">Active Customers</a>
			<a href="cust_inact.php">Inactive Customers</a>
		</div>

		<!-- TABLE: Active Customers -->
		<table id="tb_table">
			<colgroup>
				
			</colgroup>
			<tr>
				<form class="export" action="cust_export_pdf.php" method="post">
					<th class="title" colspan="8">Active Customers
					<!-- Export Button -->
					<input type="submit" name="export_rep" value="Export" />
					</th>
				</form>
			</tr>
			<tr>
				<th>Cust. No.</th>
				<th>Name</th>
				
				<th>Email</th>
				<th>Memb. since</th>
			</tr>
			<?PHP
			$count = 0;
			while ($row_custact = mysqli_fetch_assoc($query_custact)){
			array_push($_SESSION['members'], array(
					"number" => $row_custact['cust_no'],
					"name"   => $row_custact['cust_name'],
					"email"  => $row_custact['cust_email']
				));
				echo '<tr>
								<td>
									<a href="customer.php?cust='.$row_custact['cust_id'].'">'.$row_custact['cust_no'].'</a>
								</td>
								<td>'.$row_custact['cust_name'].'</td>
								
								<td>'.$row_custact['cust_email'].'</td>
								<td>'.date("d.m.Y",$row_custact['cust_since']).'</td>
							</tr>';

				array_push($_SESSION['rep_export'], array("Cust. No." => $row_custact['cust_no'],
				 "Customer Name" => $row_custact['cust_name'],  "Gender" => $row_custact['custsex_name'], 
				  "customer email." => $row_custact['cust_email'], 
				  "Member since" => date("d.m.Y",$row_custact['cust_since'])));

				$count++;
			}
			?>
			<tr class="balance">
				<td colspan="8">
				<?PHP
				echo $count.' active customer';
				if ($count != 1) echo 's';
				?>
				</td>
			</tr>
		</table>
	</body>
</html>
