<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	require 'functions.php';
	checkLogin();
	$db_link = connect();

	$rep_year = date("Y",time());
	$rep_month = date("m",time());

	//Make array for exporting data
	$_SESSION['rep_export'] = array();
	$_SESSION['rep_exp_title'] = $rep_year.'-'.$rep_month.'_loan-securities';

	//Select loans that have securities
	$sql_loans = "SELECT * FROM loans LEFT JOIN loanstatus ON loans.loanstatus_id = loanstatus.loanstatus_id LEFT JOIN customer ON loans.cust_id = customer.cust_id WHERE loan_id IN (SELECT DISTINCT loan_id FROM securities WHERE sec_returned = 0) ORDER BY loan_dateout, loans.cust_id";
	$query_loans = mysqli_query($db_link, $sql_loans);
	checkSQL($db_link, $query_loans);
?>
<!DOCTYPE HTML>
<html>
	<?PHP includeHead('Loan Securities',1) ?>

	<body>
		<!-- MENU -->
		<?PHP includeMenu(3);	?>
		<div id="menu_main">
			<a href="loans_search.php">Search</a>
			<a href="loans_act.php">Active Loans</a>
			<a href="loans_pend.php">Pending Loans</a>
			<a href="loans_securities.php" id="item_selected">Loan Securities</a>
		</div>

		<!-- CONTENT -->
		<div class="content-center">

			<table id="tb_table">
				<colgroup>
				<?php if($_SESSION['log_ugroup'] != "members")
				{?>
					<col width="20%">
					<?php }?>
					<col width="20%">
					<col width="20%">
					<col width="20%">
					<col width="20%">
				</colgroup>
				<tr>
					<form class="export" action="rep_export.php" method="post">
						<th class="title" colspan="5">Current Loan Securities
						<!-- Export Button -->
						<input type="submit" name="export_rep" value="Export" />
						</th>
					</form>
				</tr>
				<tr>
				<?php if($_SESSION['log_ugroup'] != "members")
				{?>
					<th>Loan No.</th>
					<?php } ?>
					<th>Customer</th>
					<th>Loan Status</th>
					<th>Security 1</th>
					<th>Security 2</th>
				</tr>
				<?PHP
				$count = 0;
				while ($row_loans = mysqli_fetch_assoc($query_loans)){
					$securities = getLoanSecurities($db_link, $row_loans['loan_id']);
					$security1 = NULL;
					$security2 = NULL;
					foreach ($securities as $s){
						if ($s['sec_no'] == 1) $security1 = $s;
						elseif ($s['sec_no'] == 2) $security2 = $s;
					}
					?>
					   <tr>
									<?php if($_SESSION['log_ugroup'] != "members")
									{?>
									<td><a href="loan.php?lid=<?php echo $row_loans['loan_id']; ?>"><?php echo $row_loans['loan_no']; ?></a></td>
									<?php }?>
									<td><?php echo $row_loans['cust_name']; ?></td>
									<td><?php echo $row_loans['loanstatus_status']; ?></td>
									<td><a href="security.php?security='<?php echo $security1['sec_id'];?>'"><?php echo $security1['sec_name']; ?></a></td>
									<td><a href="security.php?security='<?php echo $security2['sec_id']; ?>'"><?php echo $security2['sec_name']; ?></a></td>
									
				  

					
					</tr>

					<?php 
					array_push($_SESSION['rep_export'], array("Loan No." => $row_loans['loan_no'], "Customer" => $row_loans['cust_name'].' ('.$row_loans['cust_no'].')', "Status" => $row_loans['loanstatus_status'],"Security 1" => $security1['sec_name'], "Security 2" => $security2['sec_name']));

					$count++;
				}
				?>

				<tr class="balance">
				<?php if($_SESSION['log_ugroup'] != "members")
				{?>
					<td	colspan="5">
					<?php } 
					else{
						?>
						<td colspan="4">
						<?php }?>
					<?PHP
					echo $count.' loans with securities';
					?>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>
