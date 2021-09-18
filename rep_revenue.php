<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require 'functions.php';
require 'TCPDF/tcpdf.php';
checkLogin();
checkPermissionReport();
$db_link = connect();

//Variable $year provides the pre-set values for input fields
$year = (date("Y", time())) - 1;
$reps_year = NULL;
$_SESSION['expense_total'] = 0;
$_SESSION['total_inc'] = 0;
$_SESSION['data'] = array();
$_SESSION['outputs'] = [];
$_SESSION['savings'] = array();
$_SESSION['customers'] = array();
$_SESSION['amount_jan'] = 0;
$_SESSION['amount_feb'] = 0;
$_SESSION['amount_march'] = 0;
$_SESSION['amount_april'] = 0;
$_SESSION['amount_may'] = 0;
$_SESSION['amount_june'] = 0;
$_SESSION['amount_july'] = 0;
$_SESSION['amount_august'] = 0;
$_SESSION['amount_september'] = 0;
$_SESSION['amount_october'] = 0;
$_SESSION['amount_november'] = 0;
$_SESSION['amount_december'] = 0;
$_SESSION['total'] = array();
$customers = array();
$expense_total = 0;
?>

<!DOCTYPE HTML>
<html>
<?php include "partials/_head.php"; ?>

<body>
	<?php include "partials/_side_bar_admin.php" ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col min-vh-100 p-4">
			<h1>header</h1>
			<h1>header</h1>
			<h1>header</h1>
			<h1>header</h1>
				<!-- top navbar -->
				<nav>
					<?php include "partials/_top_bar_dashboard.php"; ?>
				</nav>

				<!-- MENU: Selection Bar -->
				<div id="menu_selection">
					<form action="rep_revenue.php" method="post">
						<input type="number" min="2006" max="2206" name="rep_year" style="width:100px;" value="<?PHP echo $year; ?>" placeholder="Give Year" />
						<input type="submit" name="select" value="Select Report" />
					</form>
				</div>

				<?PHP

				if (isset($_POST['select'])) {



					//Sanitize user input
					$rep_year = sanitize($db_link, $_POST['rep_year']);
					//$reps_year = $rep_year;
					$_SESSION['year']  = $rep_year;

					//$_SESSION['rep_export'] = array();
					
					//$_SESSION['rep_exp_title'] = $rep_year.'_annual-report';


					$sql_revenues = "SELECT cust_name,c.cust_id as cust_id,sav_year,sav_amount,
					                  MONTHNAME(str_to_date(sav_month,'%m'))as sav_month,m_id,m_name
			                    FROM customer c, savings s, months m WHERE c.cust_id = s.cust_id
								AND sav_month = m.m_id 
								AND sav_year = $_SESSION[year]
								GROUP BY cust_name, cust_id, sav_year, sav_amount, sav_month, m_id, m_name
								
					             ORDER BY cust_id asc
								";

					$query_revenues = mysqli_query($db_link, $sql_revenues);
					checkSQL($db_link, $query_revenues);

					$sql_totals = "SELECT c.cust_id as cust_id, sum(sav_amount) as total, sav_year FROM customer c, 
			                       savings s WHERE c.cust_id = s.cust_id AND sav_year <= $_SESSION[year]
								GROUP BY cust_id, sav_year";
			                           
					$_SESSION['query_total'] = mysqli_query($db_link, $sql_totals);
					checkSQL($db_link, $_SESSION['query_total']);

					$sql_total_revenue = "SELECT SUM(sav_amount) as revenue_total,sav_year FROM savings
			      WHERE sav_year = $_SESSION[year] GROUP BY sav_year";
					$query_total_revenue = mysqli_query($db_link, $sql_total_revenue);
					checkSQL($db_link, $query_total_revenue);

					$sql_expense = "SELECT exptype_id as types,exp_amount as amount,exp_year from expenses e 
				 WHERE exp_year = $_SESSION[year]";
					$query_expense = mysqli_query($db_link, $sql_expense);
					checkSQL($db_link, $query_expense);

					$sql_expense_bf = "SELECT SUM(exp_amount) AS exp_amount, exp_year FROM expenses e
				  WHERE exp_year < $_SESSION[year] GROUP BY exp_year";
					$query_bf = mysqli_query($db_link, $sql_expense_bf);
					checkSQL($db_link, $query_bf);

					$sql_revenue_bf = "SELECT SUM(sav_amount) AS revenue_bf, sav_year FROM savings 
			      WHERE sav_year < $_SESSION[year] GROUP BY sav_year ";
					$query_revenue_bf = mysqli_query($db_link, $sql_revenue_bf);
					checkSQL($db_link, $query_revenue_bf);




					while ($row_revenue = mysqli_fetch_assoc($query_revenues)) {

						$customer = array(

							"id" => $row_revenue['cust_id'],
							"name" => $row_revenue['cust_name'],
							"amount" => $row_revenue['sav_amount'],
							"month" => $row_revenue['sav_month']



						);

						array_push($customers, $customer);
					}

					while ($total_inc = mysqli_fetch_assoc($_SESSION['query_total'])) {
						$_SESSION['total'] += array(
							$total_inc['cust_id'] => $total_inc['total']
						);
					}



					foreach ($customers as $value) {
						if ($value['month'] == 'January') {

							$_SESSION['amount_jan'] += $value['amount'];
						}
						if ($value['month'] == 'February') {

							$_SESSION['amount_feb'] += $value['amount'];
						}
						if ($value['month'] == 'March') {

							$_SESSION['amount_march'] += $value['amount'];
						}
						if ($value['month'] == 'April') {

							$_SESSION['amount_april'] += $value['amount'];
						}
						if ($value['month'] == 'May') {

							$_SESSION['amount_may'] += $value['amount'];
						}
						if ($value['month'] == 'June') {

							$_SESSION['amount_june'] += $value['amount'];
						}
						if ($value['month'] == 'July') {

							$_SESSION['amount_july'] += $value['amount'];
						}
						if ($value['month'] == 'August') {

							$_SESSION['amount_august'] += $value['amount'];
						}
						if ($value['month'] == 'September') {

							$_SESSION['amount_september'] += $value['amount'];
						}
						if ($value['month'] == 'October') {

							$_SESSION['amount_october'] += $value['amount'];
						}
						if ($value['month'] == 'November') {

							$_SESSION['amount_november'] += $value['amount'];
						}
						if ($value['month'] == 'December') {

							$_SESSION['amount_december'] += $value['amount'];
						}
						$_SESSION['total_inc'] = $_SESSION['amount_jan'] + $_SESSION['amount_feb'] + $_SESSION['amount_march']
							+ $_SESSION['amount_april'] +
							$_SESSION['amount_may'] + $_SESSION['amount_june'] + $_SESSION['amount_july'] +
							$_SESSION['amount_august'] + $_SESSION['amount_september'] +
							$_SESSION['amount_october'] + $_SESSION['amount_november'] + $_SESSION['amount_december'];

						$_SESSION['key'] = $value['id'] . $value['name'] . $value['email'];
						if (!isset($_SESSION['data'][$_SESSION['key']])) {
							$_SESSION['data'][$_SESSION['key']] = array(
								"id" => $value['id'], "name" => $value['name'], "email" => $value['email'],
								"amount" => array($value['month'] => $value['amount'])
							);
						}
						$_SESSION['data'][$_SESSION['key']]['amount'] += [$value['month'] => $value['amount']];
					}


				?>
					<form class="export" action="generate_pdf.php" method="post">
						<input type="submit" name="export_rep" value="Export Report" />
					</form>

					<?php
					if ($_SESSION['year'] == 2014) {
					?>

						<table id="tb_table" style="width:95%">
							<colspan>
								<col width="16%">
								<col width="18%">
								<col width="5.5%">
								<col width="5.5%">
								<col width="5.5%">
								<col width="5.5%">
								<col width="5.5%">
								<col width="5.5%">
								<col width="5.5%">
								<col width="5.5%">
								<col width="5.5%">
								<col width="5.5%">
								<col width="5.5%">
								<col width="5.5%">
							</colspan>
							<tr>
								<th class="title" colspan="12">CHENKEN WELFARE ASSOCIATION - <?PHP echo $years; ?></th>

							</tr>
							<tr>
								<th colspan="2"></th>
								<th colspan="10"> Amount </th>
							</tr>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>May</th>
								<th>June</th>
								<th>July</th>
								<th>August</th>
								<th>September</th>
								<th>October</th>
								<th>November</th>
								<th>December</th>
								<th style='font-weight:bold;'>TOTALS</th>
								<th>Cumulative Totals </th>


							</tr>
							<?php

							foreach ($_SESSION['data'] as $row) {




								echo
								"<tr>
				
				<td>" . $row['name'] . "</td>
				<td>" . $row['email'] . "</td>

		<td>";
								foreach ($row['amount'] as $key => $value) {
									if ($key == 'May') {
										echo number_format($value);
									}
								}
								echo "</td>
		<td>";
								foreach ($row['amount'] as $key => $value) {
									if ($key == 'June') {
										echo number_format($value);
									}
								}
								echo "</td>
		 <td>";
								foreach ($row['amount'] as $key => $value) {
									if ($key == 'July') {
										echo number_format($value);
									}
								}
								echo "</td>
		<td>";
								foreach ($row['amount'] as $key => $value) {
									if ($key == 'August') {
										echo number_format($value);
									}
								}
								echo "</td>
		<td>";
								foreach ($row['amount'] as $key => $value) {
									if ($key == 'September') {
										echo number_format($value);
									}
								}
								echo "</td>
	    <td>";
								foreach ($row['amount'] as $key => $value) {
									if ($key == 'October') {
										echo number_format($value);
									}
								}
								echo "</td>
		<td>";
								foreach ($row['amount'] as $key => $value) {
									if ($key == 'November') {
										echo number_format($value);
									}
								}
								echo "</td>
		<td>";
								foreach ($row['amount'] as $key => $value) {

									if ($key == 'December') {
										echo number_format($value);
									}
								}
								echo "</td>
				
		<td style ='font-weight:bold;'>";

								if (array_sum($row['amount']) > 0) {
									echo number_format(array_sum($row['amount']));
								} else {
									echo 0;
								}
								echo "</td>

		<td style ='font-weight:bold;'>";
								foreach ($_SESSION['query_total'] as $totals) {
									if ($totals['cust_id'] == $row['id']) {
										echo number_format($totals['total']);
									}
								}
								echo "</td>
		
				
				</tr>";
							}

							echo '<tr>
		<td style="font-weight:bold;">TOTALS</td>
		<td></td>
		<td style ="font-weight:bold;">' . number_format($_SESSION['amount_may']) . '</td>
		<td style ="font-weight:bold;">' . number_format($_SESSION['amount_june']) . '</td>
		<td style ="font-weight:bold;">' . number_format($_SESSION['amount_july']) . '</td>
		<td style ="font-weight:bold;">' . number_format($_SESSION['amount_august']) . '</td>
		<td style ="font-weight:bold;">' . number_format($_SESSION['amount_september']) . '</td>
		<td style ="font-weight:bold;">' . number_format($_SESSION['amount_october']) . '</td>
		<td style ="font-weight:bold;">' . number_format($_SESSION['amount_november']) . '</td>
		<td style ="font-weight:bold;">' . number_format($_SESSION['amount_december']) . '</td>
		<td style ="font-weight:bold;">' . number_format($_SESSION['total_inc']) . '</td>
		</tr>';

							echo "</tr>
		<td style = 'font-weight:bold;'>CUMULATIVE Toatals</d>
		<td></td>
		<td style ='font-weight:bold;'>" . number_format($_SESSION['amount_jan'] + $_SESSION['amount_feb'] +
								$_SESSION['amount_march'] + $_SESSION['amount_april'] + $_SESSION['amount_may']) . "</td>
		<td style ='font-weight:bold;'>" . number_format($_SESSION['amount_jan'] + $_SESSION['amount_feb'] +
								$_SESSION['amount_march'] + $_SESSION['amount_april'] + $_SESSION['amount_may'] + $_SESSION['amount_june']) . "</td>
		<td style ='font-weight:bold;'>" . number_format($_SESSION['amount_jan'] + $_SESSION['amount_feb'] +
								$_SESSION['amount_march'] + $_SESSION['amount_april'] + $_SESSION['amount_may'] + $_SESSION['amount_june'] +
								$_SESSION['amount_july']) . "</td>
		<td style ='font-weight:bold;'>" . number_format($_SESSION['amount_jan'] + $_SESSION['amount_feb'] +
								$_SESSION['amount_march'] +
								$_SESSION['amount_april'] + $_SESSION['amount_may'] + $_SESSION['amount_june'] + $_SESSION['amount_july'] +
								$_SESSION['amount_august']) . "</td>
		<td style ='font-weight:bold;'>" . number_format($_SESSION['amount_jan'] + $_SESSION['amount_feb'] +
								$_SESSION['amount_march'] +
								$_SESSION['amount_april'] + $_SESSION['amount_may'] + $_SESSION['amount_june'] + $_SESSION['amount_july'] +
								$_SESSION['amount_august'] + $_SESSION['amount_september']) . "</td>
		<td style ='font-weight:bold;'>" . number_format($_SESSION['amount_jan'] + $_SESSION['amount_feb'] +
								$_SESSION['amount_march'] +
								$_SESSION['amount_april'] + $_SESSION['amount_may'] + $_SESSION['amount_june'] +
								$_SESSION['amount_july'] + $_SESSION['amount_august'] + $_SESSION['amount_september'] + $_SESSION['amount_october']) . "</td>
		 <td style ='font-weight:bold;'>" . number_format($_SESSION['amount_jan'] + $_SESSION['amount_feb'] +
								$_SESSION['amount_march'] +
								$_SESSION['amount_april'] + $_SESSION['amount_may'] + $_SESSION['amount_june'] +
								$_SESSION['amount_july'] + $_SESSION['amount_august'] + $_SESSION['amount_september'] + $_SESSION['amount_october'] +
								$_SESSION['amount_november']) . "</td>
		 <td style ='font-weight:bold;'>" . number_format($_SESSION['amount_jan'] + $_SESSION['amount_feb'] +
								$_SESSION['amount_march'] +
								$_SESSION['amount_april'] + $_SESSION['amount_may'] + $_SESSION['amount_june'] +
								$_SESSION['amount_july'] + $_SESSION['amount_august'] + $_SESSION['amount_september'] + $_SESSION['amount_october'] +
								$_SESSION['amount_november'] + $_SESSION['amount_december']) . "</td>
		  <td style ='font-weight:bold;'></td>

		</tr>";



							?>
							</tr>
						</table>

						<table id="tb_table" style="width:40%">
							<colgroup>




							</colgroup>
							<tr>
								<th class="title" colspan="3">Expenditure <?PHP echo $_SESSION['year']; ?></th>
							</tr>
							<tr>
								<td>
									B/F totals
								</td>
								<td>
								</td>
								<td>
									<?php
									$b_f = mysqli_fetch_assoc($query_bf);
									$expense_before = $b_f['exp_amount'];
									$r_bf = mysqli_fetch_assoc($query_revenue_bf);
									$revenue_before = $r_bf['revenue_bf'];
									$bf = $revenue_before - $expense_before;
									echo number_format($bf);
									?>
								</td>
							</tr>
							<tr>

								<td>
									Revenue total:
								</td>
								<td></td>
								<td>
									<?php
									$revenue = mysqli_fetch_assoc($query_total_revenue);
									$revenue_total = $revenue['revenue_total'];
									$current_sum = $bf + $revenue_total;
									echo $current_sum;

									?>
								</td>
							</tr>
							<?php


							foreach ($query_expense as $expense) {

								$expense_total += $expense['amount'];
								echo "<tr>
					 <td>" . $expense['types'] . "</td>
					 <td>" . $expense['amount'] . "</td>
					 <td></td>
					 </tr>";
							}
							$balance = $current_sum - $expense_total;
							echo "
				 <tr>
				<td style='font-weight:Bold;'>Total expense</td>
				<td></td>
				<td style='font-weight:Bold;'>$expense_total</td>
				</tr>";

							echo "
				<tr>
				<td style='font-weight:Bold;'>Balance:</td>
				<td></td>
				<td style='font-weight:Bold;'>$balance</td>
				</tr>";

							?>



						</table>


					<?php	} else {
					?>

						<table id="tb_table" style="width:95%">
							<colspan>
								<col width="16%">
								<col width="18%">
								<col width="5.5%">
								<col width="5.5%">
								<col width="5.5%">
								<col width="5.5%">
								<col width="5.5%">
								<col width="5.5%">
								<col width="5.5%">
								<col width="5.5%">
								<col width="5.5%">
								<col width="5.5%">
								<col width="5.5%">
								<col width="5.5%">
							</colspan>
							<tr>
								<th class="title" colspan="15">CHENKEN WELFARE ASSOCIATION - <?PHP echo $_SESSION['year']; ?></th>
							</tr>
							<tr>
								<th colspan="2"></th>
								<th colspan="13">Amount</th>
							</tr>


							</tr>
							<tr>
								<th>Name</th>

								<th>January</th>
								<th>February</th>
								<th>March</th>
								<th>April</th>
								<th>May</th>
								<th>June</th>
								<th>July</th>
								<th>August</th>
								<th>September</th>
								<th>October</th>
								<th>November</th>
								<th>December</th>
								<th style='font-weight:bold;'>TOTALS</th>
								<th style='font-weight:bold;'>Cumulative Totals </th>


							</tr>
							<?php

							foreach ($_SESSION['data'] as $row) {
								echo
								"<tr>
				
		<td>" . $row['name'] . "</td>
				

		<td>";
								foreach ($row['amount'] as $key => $value) {
									if ($key == 'January') {
										echo number_format($value);
									}
								}
								echo "</td>
		<td>";
								foreach ($row['amount'] as $key => $value) {
									if ($key == 'February') {
										echo number_format($value);
									}
								}
								echo "</td>

		<td>";
								foreach ($row['amount'] as $key => $value) {
									if ($key == 'March') {
										echo number_format($value);
									}
								}
								echo "</td>
		<td>";
								foreach ($row['amount'] as $key => $value) {
									if ($key == 'April') {
										echo number_format($value);
									}
								}
								echo "</td>
		<td>";
								foreach ($row['amount'] as $key => $value) {
									if ($key == 'May') {
										echo number_format($value);
									}
								}
								echo "</td>
		<td>";
								foreach ($row['amount'] as $key => $value) {
									if ($key == 'June') {
										echo number_format($value);
									}
								}
								echo "</td>
		 <td>";
								foreach ($row['amount'] as $key => $value) {
									if ($key == 'July') {
										echo number_format($value);
									}
								}
								echo "</td>
		<td>";
								foreach ($row['amount'] as $key => $value) {
									if ($key == 'August') {
										echo number_format($value);
									}
								}
								echo "</td>
		<td>";
								foreach ($row['amount'] as $key => $value) {
									if ($key == 'September') {
										echo number_format($value);
									}
								}
								echo "</td>
	    <td>";
								foreach ($row['amount'] as $key => $value) {
									if ($key == 'October') {
										echo number_format($value);
									}
								}
								echo "</td>
		<td>";
								foreach ($row['amount'] as $key => $value) {
									if ($key == 'November') {
										echo number_format($value);
									}
								}
								echo "</td>
		<td>";
								foreach ($row['amount'] as $key => $value) {

									if ($key == 'December') {
										echo number_format($value);
									}
								}
								echo "</td>
				
		<td style ='font-weight:bold;'>";

								if (array_sum($row['amount']) > 0) {
									echo number_format(array_sum($row['amount']));
								} else {
									echo 0;
								}

								echo "</td>

		<td style ='font-weight:bold;'>";
								foreach ($_SESSION['query_total'] as $totals) {
									if ($totals['cust_id'] == $row['id']) {
										echo number_format($totals['total']);
									}
								}
								echo "</td>
		
				
				</tr>";
							}

							echo '<tr>
		<td style="font-weight:bold;">TOTALS</td>
		<td style ="font-weight:bold;">' . number_format($_SESSION['amount_jan']) . '</td>
		<td style ="font-weight:bold;">' . number_format($_SESSION['amount_feb']) . '</td>
		<td style ="font-weight:bold;">' . number_format($_SESSION['amount_march']) . '</td>
		<td style ="font-weight:bold;">' . number_format($_SESSION['amount_april']) . '</td>
		<td style ="font-weight:bold;">' . number_format($_SESSION['amount_may']) . '</td>
		<td style ="font-weight:bold;">' . number_format($_SESSION['amount_june']) . '</td>
		<td style ="font-weight:bold;">' . number_format($_SESSION['amount_july']) . '</td>
		<td style ="font-weight:bold;">' . number_format($_SESSION['amount_august']) . '</td>
		<td style ="font-weight:bold;">' . number_format($_SESSION['amount_september']) . '</td>
		<td style ="font-weight:bold;">' . number_format($_SESSION['amount_october']) . '</td>
		<td style ="font-weight:bold;">' . number_format($_SESSION['amount_november']) . '</td>
		<td style ="font-weight:bold;">' . number_format($_SESSION['amount_december']) . '</td>
		<td style ="font-weight:bold;">' . number_format($_SESSION['total_inc']) . '</td>
		</tr>';

							echo "</tr>
		<td style = 'font-weight:bold;'>CUMULATIVE Toatals</td>
		<td></td>
		<td style ='font-weight:bold;'>" . number_format($_SESSION['amount_jan'] + $_SESSION['amount_feb']) . "</td>
		<td style ='font-weight:bold;'>" . number_format($_SESSION['amount_jan'] + $_SESSION['amount_feb'] + $_SESSION['amount_march']) . "</td>
		<td style ='font-weight:bold;'>" . number_format($_SESSION['amount_jan'] + $_SESSION['amount_feb'] + $_SESSION['amount_march']
								+ $_SESSION['amount_april']) . "</td>
		<td style ='font-weight:bold;'>" . number_format($_SESSION['amount_jan'] + $_SESSION['amount_feb'] + $_SESSION['amount_march']
								+ $_SESSION['amount_april'] + $_SESSION['amount_may']) . "</td>
		<td style ='font-weight:bold;'>" . number_format($_SESSION['amount_jan'] + $_SESSION['amount_feb'] + $_SESSION['amount_march']
								+ $_SESSION['amount_april'] + $_SESSION['amount_may'] + $_SESSION['amount_june']) . "</td>
		<td style ='font-weight:bold;'>" . number_format($_SESSION['amount_jan'] + $_SESSION['amount_feb'] + $_SESSION['amount_march']
								+ $_SESSION['amount_april'] + $_SESSION['amount_may'] + $_SESSION['amount_june'] + $_SESSION['amount_july']) . "</td>
		<td style ='font-weight:bold;'>" . number_format($_SESSION['amount_jan'] + $_SESSION['amount_feb'] + $_SESSION['amount_march']
								+ $_SESSION['amount_april'] + $_SESSION['amount_may'] + $_SESSION['amount_june'] + $_SESSION['amount_july'] +
								$_SESSION['amount_august']) . "</td>
		<td style ='font-weight:bold;'>" . number_format($_SESSION['amount_jan'] + $_SESSION['amount_feb'] + $_SESSION['amount_march']
								+
								$_SESSION['amount_april'] + $_SESSION['amount_may'] + $_SESSION['amount_june'] + $_SESSION['amount_july'] +
								$_SESSION['amount_august'] + $_SESSION['amount_september']) . "</td>
		<td style ='font-weight:bold;'>" . number_format($_SESSION['amount_jan'] + $_SESSION['amount_feb'] + $_SESSION['amount_march']
								+
								$_SESSION['amount_april'] + $_SESSION['amount_may'] + $_SESSION['amount_june'] +
								$_SESSION['amount_july'] + $_SESSION['amount_august'] + $_SESSION['amount_september'] + $_SESSION['amount_october']) . "</td>
		 <td style ='font-weight:bold;'>" . number_format($_SESSION['amount_jan'] + $_SESSION['amount_feb'] + $_SESSION['amount_march']
								+
								$_SESSION['amount_april'] + $_SESSION['amount_may'] + $_SESSION['amount_june'] +
								$_SESSION['amount_july'] + $_SESSION['amount_august'] + $_SESSION['amount_september'] + $_SESSION['amount_october']
								+ $_SESSION['amount_november']) . "</td>
		 <td style ='font-weight:bold;'>" . number_format($_SESSION['amount_jan'] + $_SESSION['amount_feb'] + $_SESSION['amount_march']
								+
								$_SESSION['amount_april'] + $_SESSION['amount_may'] + $_SESSION['amount_june'] +
								$_SESSION['amount_july'] + $_SESSION['amount_august'] + $_SESSION['amount_september'] + $_SESSION['amount_october']
								+ $_SESSION['amount_november'] + $_SESSION['amount_december']) . "</td>
		  <td style ='font-weight:bold;'></td>

		</tr>";

							?>



							</tr>



							<table id="tb_table" style="width:40%">
								<colgroup>




								</colgroup>
								<tr>
									<th class="title" colspan="3">Expenditure <?PHP echo $_SESSION['year']; ?></th>
								</tr>
								<tr>
									<td>
										B/F totals
									</td>
									<td>
									</td>
									<td>
										<?php
										$b_f = mysqli_fetch_assoc($query_bf);
										$expense_before = $b_f['exp_amount'];
										$r_bf = mysqli_fetch_assoc($query_revenue_bf);
										$revenue_before = $r_bf['revenue_bf'];
										$bf = $revenue_before - $expense_before;
										echo number_format($bf);
										?>
									</td>
								</tr>
								<tr>

									<td>
										Revenue total:
									</td>
									<td></td>
									<td>
										<?php
										$revenue = mysqli_fetch_assoc($query_total_revenue);
										$revenue_total = $revenue['revenue_total'];
										$current_sum = $bf + $revenue_total;
										echo $current_sum;

										?>
									</td>
								</tr>
								<?php


								foreach ($query_expense as $expense) {

									$expense_total += $expense['amount'];
									echo "<tr>
					 <td>" . $expense['types'] . "</td>
					 <td>" . $expense['amount'] . "</td>
					 <td></td>
					 </tr>";
								}
								$balance = $current_sum - $expense_total;
								echo "
				 <tr>
				<td style='font-weight:Bold;'>Total expense</td>
				<td></td>
				<td style='font-weight:Bold;'>$expense_total</td>
				</tr>";

								echo "
				<tr>
				<td style='font-weight:Bold;'>Balance:</td>
				<td></td>
				<td style='font-weight:Bold;'>$balance</td>
				</tr>";

								?>



							</table>

						<?php


					}

						?>

					<?php


				}


					?>


			</div>
		</div>
	</div>

</body>

</html>