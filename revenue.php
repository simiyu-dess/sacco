<!DOCTYPE HTML>
<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	require 'functions.php';
	checkLogin();
	checkPermissionReport();
	$db_link = connect();

	//Variables $year and $month provide the pre-set values for input fields
	$year = date("Y",time());
	$month = date("m",time());
?>
<html>
	<?PHP includeHead('Revenue Report',1); ?>

	<body>
		<!-- MENU -->
		<?PHP includeMenu(5); ?>
		<div id="menu_main">
			<a href="rep_incomes.php">Income Report</a>
			<a href="rep_expenses.php">Expense Report</a>
			<a href="rep_loans.php">Loans Report</a>
			<a href="rep_capital.php">Capital Report</a>
            <a href="revenue.php" id="item_selected">Revenue Report</a>
			<a href="rep_monthly.php">Monthly Report</a>
			<a href="rep_annual.php">Annual Report</a>
		</div>
		<!-- MENU: Selection Bar -->
		<div id="menu_selection">
			<form action="rep_incomes.php" method="post">
				<input type="number" min="2006" max="2206" name="rep_year" style="width:100px;" value="<?PHP if ($month == 01) echo $year-1; else echo $year; ?>" placeholder="Year" />
				<select name="rep_month">
					<option value="01" <?PHP if ($month == 2) echo 'selected="selected"' ?> >January</option>
					<option value="02" <?PHP if ($month == 3) echo 'selected="selected"' ?> >February</option>
					<option value="03" <?PHP if ($month == 4) echo 'selected="selected"' ?> >March</option>
					<option value="04" <?PHP if ($month == 5) echo 'selected="selected"' ?> >April</option>
					<option value="05" <?PHP if ($month == 6) echo 'selected="selected"' ?> >May</option>
					<option value="06" <?PHP if ($month == 7) echo 'selected="selected"' ?> >June</option>
					<option value="07" <?PHP if ($month == 8) echo 'selected="selected"' ?> >July</option>
					<option value="08" <?PHP if ($month == 9) echo 'selected="selected"' ?> >August</option>
					<option value="09" <?PHP if ($month == 10) echo 'selected="selected"' ?> >September</option>
					<option value="10" <?PHP if ($month == 11) echo 'selected="selected"' ?> >October</option>
					<option value="11" <?PHP if ($month == 12) echo 'selected="selected"' ?> >November</option>
					<option value="12" <?PHP if ($month == 1) echo 'selected="selected"' ?> >December</option>
				</select>
				<select name="rep_form" style="height:24px;">
					<option value="d" selected="selected">Detailed Rep.</option>
					<option value="a">Summarised Rep.</option>
				</select>
				<input type="submit" name="select" value="Select Report" />
			</form>
		</div>

		<?PHP
		if(isset($_POST['select'])){

			//Sanitize user input
			$rep_month = sanitize($db_link, $_POST['rep_month']);
			$rep_year = sanitize($db_link, $_POST['rep_year']);

			//Calculate UNIX TIMESTAMP for first and last day of selected month
			$firstDay = mktime(0, 0, 0, $rep_month, 1, $rep_year);
			$lastDay = mktime(0, 0, 0, ($rep_month+1), 0, $rep_year);

			//Make array for exporting data
			$_SESSION['rep_export'] = array();
			$_SESSION['rep_exp_title'] = $rep_year.'-'.$rep_month.'_incomes_'.$_POST['rep_form'];

			/*** CASE 1: Summarised Report ***/
			if ($_POST['rep_form'] == 'a'){

				//Selection from INCOMES and INCTYPE
                //$sql_incomes = "SELECT * FROM incomes WHERE inc_date BETWEEN $firstDay AND $lastDay";
                $sql_revenues = "SELECT * FROM savings WHERE save_created $firstDay AND $lastDay";
                
                //$query_incomes = mysqli_query($db_link, $sql_incomes);
                $query_revenues = mysqli_query($db_link, $sql_revenues);
				checkSQL($db_link, $query_revenues);

                //$sql_inctype = "SELECT cust_name FROM customer where cust_id = savings.cust_id";
                $sql_cutomer_name = "SELECT cust_name FROM customer where cust_id = savings.cust_id";
				$query_customer_name = mysqli_query($db_link, $sql_cutomer_name);
				checkSQL($db_link, $query_customer_name);
				?>

				<!-- TABLE: Results -->
				<table id="tb_table" style="width:50%">
					<colspan>
						<col width="50%">
						<col width="50%">
					</colspan>
					<tr>
						<form class="export" action="rep_export.php" method="post">
							<th class="title" colspan="2">Summarised Revenue Report for <?PHP echo $rep_month.'/'.$rep_year; ?>
								<!-- Export Button -->
								<input type="submit" name="export_rep" value="Export" />
							</th>
						</form>
					</tr>
					<tr>
						<th>Name</th>
						<th>Amount</th>
					</tr>
					<?PHP
					//Make array for income types
					$customer = array();
					while($row_customer = mysqli_fetch_assoc($query_customer_name)){
						$customer[] = $row_customer;
					}

					//Make array for all incomes for selected month
					$revenues = array();
					while($row_revenues = mysqli_fetch_assoc($query_revenues)){
						$incomes[] = $row_revenues;
					}

					//Iterate over income types and add matching incomes to $total
					$total_inc = 0;
					foreach ($customer as $it){
						$total_row = 0;
						foreach ($incomes as $ic) if ($ic['cust_id'] == $it['cust_id']) $total_row = $total_row + $ic['inc_amount'];
						echo '<tr>
										<td>'.$it['cust_name'].'</td>
										<td>'.number_format($total_row).' '.$_SESSION['set_cur'].'</td>
									</tr>';
						$total_inc = $total_inc + $total_row;

						//Prepare data for export to Excel file
						array_push($_SESSION['rep_export'], array("Type" => $it['inctype_type'], "Amount" => $total_row));
					}
					echo '	<tr class="balance">
										<td>Total Incomes:</td>
										<td>'.number_format($total_inc).' '.$_SESSION['set_cur'].'</td>
									</tr>';
			}

			/* CASE 2: Detailed Report */
			else{
                /*
                $sql_incomes = "SELECT * FROM incomes, inctype, 
                customer WHERE incomes.cust_id = customer.cust_id AND 
                incomes.inctype_id = inctype.inctype_id AND 
                inc_date BETWEEN $firstDay AND $lastDay ORDER BY inc_date, inc_receipt";
                */


                $sql_revenues = "SELECT * FROM savings, customer WHERE savings.cust_id = customer.cust_id AND sav_created BETWEEN $firstDay AND $lastDay
                ORDER BY cust_id, cust_name";
				$query_revenues = mysqli_query($db_link, $sql_revenues);
				checkSQL($db_link, $query_revenues);
				?>

				<!-- TABLE: Results -->
				<table id="tb_table">
					<colspan>
						<col width="16%">
						<col width="7%">
						<col width="7%">
						<col width="7%">
						<col width="7%">
                        <col width="7%">
                        <col width="7%">
                        <col width="7%">
                        <col width="7%">
                        <col width="7%">
                        <col width="7%">
                        <col width="7%">
                        <col width="7%">
					</colspan>
					<tr>
						<form class="export" action="rep_export.php" method="post">
							<th class="title" colspan="5">Detailed Incomes Report for <?PHP echo $rep_month.'/'.$rep_year; ?>
							<!-- Export Button -->
							<input type="submit" name="export_rep" value="Export" />
							</th>
						</form>
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
                        <th>Septmember</th>
                        <th>October</th>
                        <th>November</th>
                        <th>December</th>
					</tr><
					<?PHP
					$total_inc = 0;
					while($row_revenues = mysqli_fetch_assoc($query_revenues)){
						echo '<tr>
									    
										<td>'.$row_revenues['cust_name'].'</td>
										<td>'.$row_revenues['sav_amount'].'</td>
                                        <td>'.$row_revenues['sav_amount'].'</td>
                                        <td>'.$row_revenues['sav_amount'].'</td>
                                        <td>'.$row_revenues['sav_amount'].'</td>
                                        <td>'.$row_revenues['sav_amount'].'</td>
                                        <td>'.$row_revenues['sav_amount'].'</td>
                                        <td>'.$row_revenues['sav_amount'].'</td>
                                        <td>'.$row_revenues['sav_amount'].'</td>
                                        <td>'.$row_revenues['sav_amount'].'</td>
                                        <td>'.$row_revenues['sav_amount'].'</td>
                                        <td>'.$row_revenues['sav_amount'].'</td>
                                        <td>'.$row_revenues['sav_amount'].'</td>
									</tr>';
                        $total_inc = $total_inc + $row_revenues['sav_amount'];
                        /*
                        <td>'.date("d.m.Y",$row_incomes['inc_date']).'</td>
										<td>'.number_format($row_incomes['inc_amount']).' '.$_SESSION['set_cur'].'</td> */

						//Prepare data for export to Excel file
						array_push($_SESSION['rep_export'], array("Date" => date("d.m.Y",$row_revenues['sav_created']), "Amount" => $row_revenues['sav_amount'], "Type" => $row_revenues['cust_name'], "From" => $row_incomes['cust_name'])); //"Receipt No" => $row_incomes['inc_receipt']));
					}
					echo '<tr class="balance">
									<td colspan="5">Total Incomes: '.number_format($total_inc).' '.$_SESSION['set_cur'].'</td>
								</tr>';
			}
		}
		?>
		</table>
	</body>
</html>
