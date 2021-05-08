<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	require 'functions.php';
	checkLogin();
	$db_link = connect();
	$timestamp = time();
	
	//NEW EXPENDITURE-Button
	if(isset($_POST['expnew'])){
		
		//Sanitize user input
		$exptype = sanitize($db_link, $_POST['type']);
		$exp_amount = sanitize($db_link, $_POST['exp_amount']);
		$exp_date = strtotime(sanitize($db_link, $_POST['exp_date']));
		$date = strtotime($_POST['exp_date']);
		$exp_text = sanitize($db_link, $_POST['exp_text']);
		$exp_recipient = sanitize($db_link, $_POST['exp_recipient']);
		$exp_receipt = sanitize($db_link, $_POST['exp_receipt']);
		$exp_voucher = sanitize($db_link, $_POST['exp_voucher']);
		$years =  (int)date("Y", $date);
		
		//Insert into expenses
		$sql_expnew = "INSERT INTO expenses (exptype_id, exp_amount, exp_date, exp_text, exp_recipient, exp_receipt,exp_year, exp_created, user_id)
		 VALUES ('$exptype', '$exp_amount', '$exp_date','$exp_text', '$exp_recipient','$exp_receipt','$years','$timestamp', '$_SESSION[log_id]')";
		$query_expnew = mysqli_query($db_link, $sql_expnew);
		checkSQL($db_link, $query_expnew);
	}
			
	//Select recent expenses from EXPENSES
	$sixtydays = time() - convertDays(60);
	$sql_expcur = "SELECT * FROM expenses LEFT JOIN exptype ON expenses.exptype_id = exptype.exptype_id WHERE exp_date > $sixtydays ORDER BY exp_date DESC";
	$query_expcur = mysqli_query($db_link, $sql_expcur);
	checkSQL($db_link, $query_expcur);
	
	//Select types of expenses from EXPTYPE
	$sql_exptype = "SELECT * FROM exptype ORDER BY exptype_type";
	$query_exptype = mysqli_query($db_link, $sql_exptype);
	checkSQL($db_link, $query_exptype);
	?>
<!DOCTYPE HTML>
<html>
	<?PHP includeHead('Expenses',0) ?>	
		<script>
			function validate(form){
				fail = validateDate(form.exp_date.value)
				fail += validateAmount(form.exp_amount.value)
				fail += validateRecipient(form.exp_recipient.value)
				fail += validateVoucher(form.exp_voucher.value)
				if (fail == "") return true
				else { alert(fail); return false }
			}
		</script>
		<script src="functions_validate.js"></script>
		<script src="function_randCheck.js"></script>
	</head>
	
	<body>
	
		<!-- MENU -->
		<?PHP includeMenu(4); ?>
		<div id="menu_main">
			<a href="start.php">Back</a>
			<a href="books_expense.php" id="item_selected">Expenses</a>
			<a href="books_income.php">Incomes</a>
			<a href="books_annual.php">Annual Accounts</a>
		</div>
		
			
		<!-- LEFT SIDE: Form for entering new expense -->
		<div class="content_left">
			
			<p class="heading_narrow">New Expense</p>
			<form action="books_expense.php" method="post" onSubmit="return validate(this)">
				
				<table id="tb_fields">
					<tr>
						<td>Date:</td>
						<td><input type="text" id="datepicker" name="exp_date" value="<?PHP echo date("d.m.Y", $timestamp); ?>"/></td>
						<td>Type:</td>
						<td>
							<input type="text" id="expense_type" name="type" placeholder="type" />
						</td>
					</tr> 
					<tr>
						<td>Amount:</td>
						<td><input type="number" name="exp_amount" placeholder="<?PHP echo $_SESSION['set_cur']; ?>" /></td>
						<td>Payed to:</td>
						<td><input type="text" name="exp_recipient"/></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="hidden" name="exp_voucher"/></td>
						<td></td>
						<td><input type="hidden" name="exp_receipt" placeholder="if any"/></td>
					</tr>
					<tr>
						<td>Details:</td>
						<td><input type="text" name="exp_text"/></td>
					</tr>
					<tr>
						<td>Receipt:</td>
						<td><input type="text" name="exp_receipt"/></td>
					</tr>
				</table>
				<input type="submit" name="expnew" value="New Entry" />
			</form>
		</div>
		
		<!-- RIGHT SIDE: Recent Expenses -->
		<div class="content_right">
			<table id="tb_table">
				<tr>
					<th class="title" colspan="8">Recent Expenses</th>
				</tr>
				<tr>
					<th>Date</th>
					<th>Type</th>
					<th>Amount</th>
					<th>Receipt</th>
					<th>Delete</th>
				</tr>
			<?PHP
			while ($row_expcur = mysqli_fetch_assoc($query_expcur)){
				if ($row_expcur['cust_id'] != 0 AND $row_expcur['cust_id'] != NULL){
					$result_cust = getCustomer($row_expcur['cust_id']);
					$exp_recipient = $result_cust['cust_name'].' (<a href="customer.php?cust='.$row_expcur['cust_id'].'">'.$result_cust['cust_no'].'</a>)';
				}
				else $exp_recipient = $row_expcur['exp_recipient'];
				echo '<tr>	
								<td>'.date("d.m.Y",$row_expcur['exp_date']).'</td>
								<td>'.$row_expcur['exptype_type'].'</td>
								<td>'.number_format($row_expcur['exp_amount']).' '.$_SESSION['set_cur'].'</td>
								<td>'.$row_expcur['exp_receipt'].'</td>
								<td>';
								if ($_SESSION['log_delete'] == 1) echo '<a href="books_expense_del.php?exp_id='.$row_expcur['exp_id'].'" onClick="return randCheck();" ><i class="fa fa-remove fa-lg"></i></a>';
				echo '	</td>
							</tr>';
			}
			?>
			</table>
		</div>
	</body>	
</html>