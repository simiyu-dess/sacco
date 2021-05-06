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
	$_SESSION['rep_exp_title'] = $rep_year.'-'.$rep_month.'_empl-former';

	$query_emplpast = getEmplPast($db_link);
?>

<!DOCTYPE HTML>
<html>
	<?PHP includeHead('Former Employees',1) ?>

	<body>
		<!-- MENU -->
		<?PHP includeMenu(7); ?>
		<div id="menu_main">
			<!-- <a href="empl_search.php">Search</a> -->
			<a href="empl_new.php">New Employee</a>
			<a href="empl_curr.php">Current Employees</a>
			<a href="empl_past.php" id="item_selected">Former Employees</a>
		</div>

		<!-- TABLE: Former Employees -->
		<table id="tb_table">
			<colgroup>
				<col width="7%" />
				<col width="13%" />
				<col width="13%" />
				<col width="7%" />
				<col width="7%" />
				<col width="13%" />
				<col width="13%" />
				<col width="13%" />
				<col width="7%" />
				<col width="7%" />
			</colgroup>
			<tr>
				<form class="export" action="rep_emppast_pdf.php" method="post">
					<th class="title" colspan="10">Former Employees
					<!-- Export Button -->
					<input type="submit" name="export_rep" value="Export" />
					</th>
				</form>
			</tr>
			<tr>
				<th>Empl. No.</th>
				<th>Name</th>
				<th>Position</th>
				<th>Gender</th>
				<th>DoB</th>
				<th>Address</th>
				<th>Phone No.</th>
				<th>E-Mail</th>
				<th>In</th>
				<th>Out</th>
			</tr>
			<?PHP
			$count = 0;
			$_SESSION['emp_past'] = array();
			while ($row_emplpast = mysqli_fetch_assoc($query_emplpast)){
				array_push(
					$_SESSION['emp_past'],array(
						"number" => $row_emplpast['empl_no'],
						"name" => $row_emplpast['empl_name'],
						"position" => $row_emplpast['empl_position'],
						"sex" => $row_emplpast['emplsex_name'],
						"address" => $row_emplpast['empl_address'],
						"phone" => $row_emplpast['empl_phone'],
						"email" => $row_emplpast['empl_email'],
						"date_in" => date("d.m.Y",$row_emplpast['empl_in']),
						"date_out" => date("d.m.Y",$row_emplpast['empl_out'])
					)
				);
				echo '<tr>
								<td><a href="employee.php?empl='.$row_emplpast['empl_id'].'">'.$row_emplpast['empl_no'].'</a></td>
								<td>'.$row_emplpast['empl_name'].'</td>
								<td>'.$row_emplpast['empl_position'].'</td>
								<td>'.$row_emplpast['emplsex_name'].'</td>
								<td>'.date("d.m.Y",$row_emplpast['empl_dob']).'</td>
								<td>'.$row_emplpast['empl_address'].'</td>
								<td>'.$row_emplpast['empl_phone'].'</td>
								<td>'.$row_emplpast['empl_email'].'</td>
								<td>'.date("d.m.Y",$row_emplpast['empl_in']).'</td>
								<td>'.date("d.m.Y",$row_emplpast['empl_out']).'</td>
							</tr>';

				array_push($_SESSION['rep_export'], array("Empl. No." => $row_emplpast['empl_no'], "Employee Name" => $row_emplpast['empl_name'], "DoB" => date("d.m.Y",$row_emplpast['empl_dob']), "Gender" => $row_emplpast['emplsex_name'], "Address" => $row_emplpast['empl_address'], "Phone No." => $row_emplpast['empl_phone'], "Email" => $row_emplpast['empl_email'], "Empl. In" => date("d.m.Y",$row_emplpast['empl_in']), "Empl. Out" => date("d.m.Y",$row_emplpast['empl_out'])));

				$count++;
			}
			?>
			<tr class="balance">
				<td colspan="10">
					<?PHP
					echo $count.' former employee';
					if ($count != 1) echo 's';
					?>
				</td>
			</tr>
		</table>
	</body>
</html>
