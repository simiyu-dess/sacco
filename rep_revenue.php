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
			<a href="revenue.php" id="item_selected"> Revenue report </a>
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
		
		if(isset($_POST['select']))
		{
			
			//Sanitize user input
			$rep_year = sanitize($db_link, $_POST['rep_year']);
			$reps_year = $rep_year;
			$years  = (int)date("Y",$rep_year);

			$_SESSION['rep_export'] = array();
			$_SESSION['rep_exp_title'] = $rep_year.'_annual-report';

			
		

			//$sql_revenues = "SELECT sav_amount, sav_month,sav_year FROM `savings` a 
						   //OUTER JOIN (SELECT cust_name, cust_email,cust_id FROM customer) b ON  a.cust_id = b.cust_id";

			$sql_revenues = "SELECT cust_name, cust_email,c.cust_id as cust_id,sav_amount,MONTHNAME(str_to_date(sav_month,'%m'))as sav_month,m_id,m_name
			                    FROM customer c, savings s, months m WHERE c.cust_id = s.cust_id AND sav_month = m.m_id
								
								GROUP BY c.cust_id,m.m_id
								ORDER BY c.cust_id asc";


			
					
					
			


			$query_revenues = mysqli_query($db_link, $sql_revenues);
			checkSQL($db_link, $query_revenues);

			
			?>
			
			
		
		<form class="export" action="rep_export.php" method="post">
				<input type="submit" name="export_rep" value="Export Report" />
			</form>

			<table id ="tb_table" style="width:95%">
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
			<th class="title" colspan="14">CHENKEN WELFARE ASSOCIATION - <?PHP echo $reps_year; ?></th>
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
			$total_inc = 0;
			$data=array();
			$output = array();
			$outputs=[];
			$customers = array();
			while($row_revenue = mysqli_fetch_assoc($query_revenues))
			{
				
				$customer = array(
					
					"id" => $row_revenue['cust_id'],
					"name"=>$row_revenue['cust_name'],
					"email"=>$row_revenue['cust_email'],
					"amount"=>[$row_revenue['sav_amount']],
					"month"=>[$row_revenue['sav_month']]
					

				);

				array_push($customers,$customer);
			}
			   $data = array();
			   foreach($customers as $value){

			   $key = $value['id'].$value['name'].$value['email'];
			   if(!isset($data[$key]))
			   {
				   $data[$key] = array("id" => $value['id'],"name"=>$value['name'],"email"=>$value['email'],
				   "amount"=>$value['amount'],"month"=>$value['month']);
			   }
			   $data[$key]['amount'][]=$value['amount'];
			   $data[$key]['month'][]=$value['month'];
			} 
			$months = [];
			$amount = [];
			
			
			$sav_amount = array_combine($months,$amount);
				foreach($data as $row)
				{
				$months .= implode(',', $row['month']);
			    $amount .=implode(',', $row['amount']);
				
				echo
				"<tr>
				
				<td>".$row['name']. "</td>
				<td>".$row['email']. "</td>

		<td>"; foreach($sav_amount as $key => $value){
					if($key == 'January')
					 {
					   echo $value;
					 }}echo "</td>
		<td>"; foreach($sav_amount as $key => $value){
					if($key == 'February')
						{
					   echo $value;
					 }}echo "</td>

		<td>"; foreach($sav_amount as $key => $value){
					if($key == 'March')
						{
						 echo $value;
					 }}echo "</td>
		<td>"; foreach($sav_amount as $key => $value){
					if($key == 'April')
					 {
					   echo $value;
					 }}echo "</td>
		<td>"; foreach($sav_amount as $key => $value){
				 if($key == 'May')
				     {
					 echo $value;
				}}echo "</td>
		<td>"; foreach($sav_amount as $key => $value){
			if($key == 'June')
				{
			   echo $value;
				 }}echo "</td>
		 <td>"; foreach($sav_amount as $key => $value){
				if($key == 'July')
				 {
					 echo $value;
				 }}echo "</td>
		<td>"; foreach($sav_amount as $key => $value){
				if($key == 'August')
				 {
				   echo $value;
				 }}echo "</td>
		<td>"; foreach($sav_amount as $key => $value){
				if($key == 'September')
						{
					 echo $value;
				 }}echo "</td>
	    <td>"; foreach($sav_amount as $key => $value){
					if($key == 'October')
						 {
				  echo $value;
					 }}echo "</td>
		<td>"; foreach($sav_amount as $key => $value){
					if($key == 'November')
						{
					 echo $value;
					 }}echo "</td>
		<td>"; foreach($sav_amount as $key => $value){
								if($key == 'December')
									{
								 echo $value;
							 }}echo "</td>
				
				
				
				
				</tr>";

				
				}
				//foreach($cities as $key => $value){
				//	echo $key . " : " . $value . "<br>"

			
				
				
			
			
			
			
		
			
			
			
		
			?>
			
			  
		
				  </tr>
				 
				
				
				
			
		
		
			
			

			
			
			
			</table>
			<?php
		}
	
	?>


	</body>
</html>