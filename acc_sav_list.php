<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Select Savings Transactions from SAVINGS
$sql_sav = "SELECT * FROM savings LEFT JOIN savtype ON savings.savtype_id = savtype.savtype_id 
LEFT JOIN user ON savings.user_id = user.user_id WHERE cust_id = '$_SESSION[member_id]' ORDER BY sav_date DESC, sav_id DESC";
$query_sav = mysqli_query($db_link, $sql_sav);
checkSQL($db_link, $query_sav);

$sql_cust_name = "SELECT cust_name FROM customer WHERE customer.cust_id = '$_SESSION[member_id]'";
 $query_bal = mysqli_query($db_link,$sql_cust_name);
 checkSQL($db_link,$query_bal);

// Make array for exporting data
$sav_exp_date = date("Y-m-d",time());
$_SESSION['sav_export']=array();
$_SESSION['sav_exp_title'] = $_SESSION['member_id'].'_savings_'.$sav_exp_date;
$_SESSION['user_account'] = array();
$name = mysqli_fetch_assoc($query_bal);
$_SESSION['name'] = $name['cust_name'];
?>

<table id="tb_table">
	<colgroup>
		<col width="8%">
		<?PHP
		if ($_SESSION['set_sfx'] == 1) echo '<col width="8%">';
		?>
		
	</colgroup>
	<tr>
		<form class="export" action="acc_sav_pdf.php" method="post">
			<?PHP
			if ($_SESSION['set_sfx'] == 1) echo '<th class="title" colspan="9">Savings Account';
			else echo '<th class="title" colspan="8">Savings Account';
			?>
			<!-- Export Button -->
			<input type="submit" name="export_rep" value="Export" />
			</th>
		</form>
	</tr>
	<?PHP
	$_SESSION['sav_bal'] = number_format($sav_balance);
	echo '<tr class="balance">';
		if ($_SESSION['set_sfx'] == 1) echo '<td colspan="9">';
		else echo '<td colspan="8">';
		echo 'Balance: '.number_format($sav_balance).' '.$_SESSION['set_cur'].'</td>
				</tr>';
	?>
	<tr>
		<th>Date</th>
		<?PHP
		if ($_SESSION['set_sfx'] == 1) echo '<th>Fixed</th>';
		?>
		<th>Transaction</th>
		<th>Amount</th>
		<th>Receipt</th>
		<th>Authorised by</th>
		<th>Delete</th>
	</tr>
 <?PHP
	while($row_sav = mysqli_fetch_assoc($query_sav)){
		array_push($_SESSION['user_account'],array("date" => date('d.m.y',$row_sav['sav_date']),
									   "amount" => number_format($row_sav['sav_amount']),
									   "receipt" => $row_sav['sav_receipt'],
									    "type" => $row_sav['savtype_type']));
		echo '<tr>
						<td>'.date("d.m.Y",$row_sav['sav_date']).'</td>';
			if ($_SESSION['set_sfx'] == 1){
				if($row_sav['sav_fixed'] != 0) echo '<td>'.date("d.m.Y",$row_sav['sav_fixed']).'</td>';
				else echo '<td></td>';
			}
			echo '<td>'.$row_sav['savtype_type'].'</td>
						<td>'.number_format($row_sav['sav_amount']).' '.$_SESSION['set_cur'].'</td>
						<td>'.$row_sav['sav_receipt'].'</td>
						<td>'.$row_sav['user_name'].'</td>';
						if ($_SESSION['log_delete'] == 1 and ($row_sav['savtype_id'] == 1 or $row_sav['savtype_id'] == 2)) echo '<td><a href="acc_sav_del.php?sav_id='.$row_sav['sav_id'].'" onClick="return randCheck();"><i class="fa fa-remove fa-lg"></i></a></td>';
						else echo '<td></td>';
		echo '</tr>';

		//Prepare data for export to Excel file
		array_push($_SESSION['sav_export'], array("Date" => date("d.m.Y",$row_sav['sav_date']), "Transaction_Type" => $row_sav['savtype_type'], "Amount" => $row_sav['sav_amount'], "Receipt" => $row_sav['sav_receipt'], "W/draw Slip" => $row_sav['sav_slip']));
	}
 ?>
</table>
