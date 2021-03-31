<!DOCTYPE HTML>
<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	require 'functions.php';
	checkLogin();
	checkPermissionReport();
	$db_link = connect();
	
	//Variable $year provides the pre-set values for input fields
	$year = (date("Y",time()))-1; 
	$reps_year = NULL;
?>
<html>
	<?PHP includeHead('Annual Report',1) ?>	
	<body>
		
		<!-- MENU -->
		<?PHP 
				includeMenu(5);
		?>
		
		<!-- MENU MAIN -->
		<div id="menu_main">
			<a href="rep_incomes.php">Income Report</a>
			<a href="rep_expenses.php">Expense Report</a>
			<a href="rep_loans.php">Loans Report</a>
			<a href="rep_capital.php">Capital Report</a>
			<a href = "revenue.php" id="item_selected"> Revenue report </a>
			<a href="revenue.php">Revenue Report</a>
			<a href="rep_monthly.php">Monthly Report</a>
			<a href="rep_annual.php">Annual Report</a>
		</div>
		
		<!-- MENU: Selection Bar -->
		<div id="menu_selection">			
			<form action="rep_revenue.php" method="post">
				<input type="number" min="2006" max="2206" name="rep_year" style="width:100px;" value="<?PHP echo $year; ?>" placeholder="Give Year" />
				<input type="submit" name="select" value="Select Report" />
			</form>
		</div>
		
		<?PHP
		if(isset($_POST['select'])){
			
			//Sanitize user input
			$rep_year = sanitize($db_link, $_POST['rep_year']);
			$reps_year = $rep_year;
			$years  = (int)date("Y",$rep_year);

			$_SESSION['rep_export'] = array();
			$_SESSION['rep_exp_title'] = $rep_year.'_annual-report';

			
			$sql_revenues_jan = "SELECT * FROM savings WHERE 
								sav_month = 1 AND sav_year=$years";

			$query_revenues_jan = mysqli_query($db_link, $sql_revenues_jan);
			checkSQL($db_link, $query_revenues_jan);

		    $sql_revenues_feb = "SELECT * FROM savings WHERE 
								sav_month = 2 AND sav_year=$years";
			$query_revenues_feb = mysqli_query($db_link, $sql_revenues_feb);
			checkSQL($db_link, $query_revenues_feb);
								
			$sql_revenues_mach = "SELECT * FROM savings WHERE
								sav_month=3 AND sav_year=$years";
			$query_revenues_march =mysqli_query($db_link, $sql_revenues_mach);
			checkSQL($db_link, $query_revenues_march);

								
			$sql_revenues_april = "SELECT * FROM savings WHERE 
								   sav_month=4 AND sav_year=$years";
			$query_revenues_april = mysqli_query($db_link, $sql_revenues_april);
			checkSQL($db_link, $query_revenues_april);
								   
			$sql_revenues_may = "SELECT * FROM savings WHERE 
								 sav_month=5 AND sav_year=$years";
			$query_revenues_may = mysqli_query($db_link, $sql_revenues_may);
			checkSQL($db_link, $query_revenues_may);
								 
			$sql_revenues_june = "SELECT * FROM savings WHERE
								 sav_month=6 AND sav_year=$years";
			$query_revenues_june = mysqli_query($db_link, $sql_revenues_june);
			checkSQL($db_link, $query_revenues_june);

			$sql_revenues_july = "SELECT * FROM savings WHERE
								   sav_month=7 AND sav_year=$years";
			$query_revenues_july = mysqli_query($db_link, $sql_revenues_july);
			checkSQL($db_link, $query_revenues_july);

								 
			$sql_revenues_august= "SELECT * FROM savings WHERE 
								  sav_month=8 AND sav_year=$years";
			$query_revenues_august = mysqli_query($db_link, $sql_revenues_august);
			checkSQL($db_link, $query_revenues_august);
								  
			$sql_revenues_sep = "SELECT * FROM savings WHERE 
								  sav_month=9 AND sav_year=$years";
			$query_revenues_sep = mysqli_query($db_link,$sql_revenues_sep);
			checkSQL($db_link,$query_revenues_sep);
			$sql_revenues_oct = "SELECT * FROM savings WHERE 
								 sav_month=10 AND sav_year=$years";
			$query_revenues_oct = mysqli_query($db_link, $sql_revenues_oct);
			checkSQL($db_link, $query_revenues_oct);

			$sql_revenues_nov = "SELECT * FROM savings WHERE
								 sav_month=11 AND sav_year=$years";
			$query_revenues_nov = mysqli_query($db_link, $sql_revenues_nov);
			checkSQL($db_link, $query_revenues_nov);
			$sql_revenues_dec = "SELECT * FROM savings WHERE
								 sav_month=12 AND sav_year=$years";
			$query_revenues_dec= mysqli_query($db_link,$sql_revenues_dec);
			checkSQL($db_link,$query_revenues_dec);
		}
		?>
		<form class="export" action="rep_export.php" method="post">
				<input type="submit" name="export_rep" value="Export Report" />
			</form>

			<table id ="tb_table" style="width:50%">
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
			<th class="title" colspan="2">Revenue for <?PHP echo $reps_year; ?></th>
			</tr>
			<tr>
			<th>Name</th>
			<th>Email</th>
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
			</tr>
			<?php

			
			?>
			</table>
	</body>
</html>