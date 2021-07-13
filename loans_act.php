<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	require 'functions.php';
	checkLogin();
	$db_link = connect();
	//chargeOverdueLoans($db_link);

	$rep_year = date("Y",time());
	$rep_month = date("m",time());

	//Make array for exporting data
	$_SESSION['rep_export'] = array();
	$_SESSION['rep_exp_title'] = $rep_year.'-'.$rep_month.'_loans-active';

	//Select Active Loans from LOANS
	$sql_loans = "SELECT * FROM loans LEFT JOIN loanstatus ON loans.loanstatus_id = loanstatus.loanstatus_id
	LEFT JOIN customer ON loans.cust_id = customer.cust_id WHERE loans.loanstatus_id = 2 
	ORDER BY loan_dateout, loans.cust_id";
	$query_loans = mysqli_query($db_link, $sql_loans);
	checkSQL($db_link, $query_loans);
?>
<!DOCTYPE HTML>
<html>
	<?PHP includeHead('Active Loans',1) ?>

	<body>
		<!-- MENU -->
		<?PHP includeMenu(3);	?>
		<div id="menu_main">
			<a href="loans_search.php">Search</a>
			<a href="loans_act.php" id="item_selected">Active Loans</a>
			<a href="loans_pend.php">Pending Loans</a>
			<a href="cleared_loans.php">Cleared Loans</a>
			<a href="loans_securities.php">Loan Securities</a>
		</div>

		<!-- CONTENT -->
		<div class="content-center">

			<table id="tb_table">
				<colgroup>
				<?php if($_SESSION['log_ugroup'] != "members")
				{?>
					<col width="7.5%">
					<?php } ?>
					<col width="30%">
					<col width="10%">
					<col width="15%">
					<col width="15%">
					<col width="15%">
					<col width="7.5%">
				</colgroup>
				<tr>
					<form class="export" action="reploan_active.php" method="post">
						<th class="title" colspan="7">Active Loans
						<!-- Export Button -->
						<input type="submit" name="export_rep" value="Export" />
						</th>
					</form>
				</tr>
				<tr>
				<?php if($_SESSION['log_ugroup'] != "members") {?>
					<th>Loan No.</th>
					<?php } ?>
					<th>Customer</th>
					<th>Loan Period</th>
					<th>Principal</th>
					<th>Interest</th>
					<th>Remaining</th>
					<th>Issued on</th>
				</tr>
				<?PHP
				$count = 0;
				$_SESSION['active_loans']=array();
				while ($row_loans = mysqli_fetch_assoc($query_loans)){

					$loan_balances = getLoanBalance($db_link, $row_loans['loan_id']);
					array_push(
						$_SESSION['active_loans'],
						array(
							"number"=> $row_loans['loan_no'],
							"name" => $row_loans['cust_name'],
							"period" => $row_loans['loan_period'],
							"pdue" => $loan_balances['pdue'],
							"idue" => $loan_balances['idue'],
							"balance" => $loan_balances['balance'],
							"dateout" => date("d.m.Y", $row_loans['loan_dateout'])
						)
					);
                        ?>
					<tr>            <?php if($_SESSION['log_ugroup'] != "members") {?>
									<td><a href="loan.php?lid=<?php echo $row_loans['loan_id']; ?>"><?php echo $row_loans['loan_no']; ?></a></td>
									<?php } ?>
									<td><?php echo $row_loans['cust_name']; ?></td>
									<td><?php echo $row_loans['loan_period']; ?></td>
									<td><?php echo number_format($loan_balances['pdue']).' '.$_SESSION['set_cur']; ?></td>
									<td><?php echo number_format($loan_balances['idue']).' '.$_SESSION['set_cur']; ?></td>
									<td><?php echo number_format($loan_balances['balance']).' '.$_SESSION['set_cur']; ?></td>
									<td><?php echo date("d.m.Y", $row_loans['loan_dateout']); ?></td>
								</tr>';

					<?php
					array_push($_SESSION['rep_export'], array("Loan No." => $row_loans['loan_no'], "Customer" => $row_loans['cust_name'].' ('.$row_loans['cust_no'].')', "Status" => $row_loans['loanstatus_status'],"Loan Period" => $row_loans['loan_period'], "Principal" => $loan_balances['pdue'], "Interest" => $loan_balances['idue'], "Remaining" => $loan_balances['balance'], "Issued on" => date("d.m.Y", $row_loans['loan_dateout'])));

					$count++;
					
				}
				?>
				<tr class="balance">
				<?php if($_SESSION['log_ugroup'] != "members")
				{?>
					<td	colspan="7">
					<?php } 
					else
					{?>
					<td colspan="6">
					<?php }?>
					<?PHP
					echo $count.' active loan';
					if ($count != 1) echo 's';
					?>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>
