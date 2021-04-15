<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	require 'functions.php';
	require 'TCPDF/tcpdf.php';
	checkLogin();
	checkPermissionReport();
	$db_link = connect();
	
	//Variable $year provides the pre-set values for input fields
	$year = (date("Y",time()))-1; 
	$reps_year = NULL;
?>
<?php
			if(isset($_POST['export_rep']))
			{// create new PDF document
				$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
				$obj_pdf->SetCreator(PDF_CREATOR);  
				$obj_pdf->SetTitle("Export HTML Table data to PDF using TCPDF in PHP");  
				$obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
				$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
				$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
				$obj_pdf->SetDefaultMonospacedFont('helvetica');  
				$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
				$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
				$obj_pdf->setPrintHeader(false);  
				$obj_pdf->setPrintFooter(false);  
				$obj_pdf->SetAutoPageBreak(TRUE, 10);  
				$obj_pdf->SetFont('helvetica', '', 12);  
				$obj_pdf->AddPage();


			$html .= '<table class="table table-bordered">
			<tr>
			<th class="title" width="100%">CHENKEN WELFARE ASSOCIATION></th>
			
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
			<th style>TOTALS</th>
			<th>Cumulative Totals </th>
			

			</tr>
			';
			$html .= '</table>';
			ob_end_clean();
			$obj_pdf->writeHTML($html);  
			$obj_pdf->Output('sample.pdf', 'I');
		   } ?>
<!DOCTYPE HTML>
<html>
	<?PHP includeHead('Revenue Report',1) ?>	
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
			//$reps_year = $rep_year;
			$years  = $rep_year;

			//$_SESSION['rep_export'] = array();
			//$_SESSION['rep_exp_title'] = $rep_year.'_annual-report';

			
		

			//$sql_revenues = "SELECT sav_amount, sav_month,sav_year FROM `savings` a 
						   //OUTER JOIN (SELECT cust_name, cust_email,cust_id FROM customer) b ON  a.cust_id = b.cust_id";

			$sql_revenues = "SELECT cust_name, cust_email,c.cust_id as cust_id,sav_year,sav_amount,MONTHNAME(str_to_date(sav_month,'%m'))as sav_month,m_id,m_name
			                    FROM customer c, savings s, months m WHERE c.cust_id = s.cust_id AND sav_month = m.m_id 
								AND sav_year = $years
								
								GROUP BY c.cust_id,m.m_id
								ORDER BY c.cust_id asc";


			
					
					
			


			$query_revenues = mysqli_query($db_link, $sql_revenues);
			checkSQL($db_link, $query_revenues);

			$sql_totals = "SELECT c.cust_id as cust_id, sum(sav_amount) as total, sav_year FROM customer c, 
			savings s WHERE c.cust_id = s.cust_id AND sav_year <= $years GROUP BY c.cust_id";
			$query_total =mysqli_query($db_link,$sql_totals);
			checkSQL($db_link,$query_total);

			$sql_total_revenue ="SELECT SUM(sav_amount) as revenue_total,sav_year FROM savings
			      WHERE sav_year <= $years";
			$query_total_revenue = mysqli_query($db_link,$sql_total_revenue);
			checkSQL($db_link,$query_total_revenue);

			
			?>
			
			
		
		<form class="export" action="" method="post">
				<input type="submit" name="export_rep" value="Export Report" />
			</form>

			<?php
			if($years == 2014)
			{
			?>

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
			<th class="title" colspan="12">CHENKEN WELFARE ASSOCIATION - <?PHP echo $years; ?></th>
			
			</tr>
			<tr>
			<th colspan= "2"></th>
			<th colspan = "10"> Amount </th>
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
			<th style ='font-weight:bold;'>TOTALS</th>
			<th>Cumulative Totals </th>
			

			</tr>
			<?php
			$total_inc = 0;
			$data=array();
			$output = array();
			$outputs=[];
			$savings = array();
			$customers = array();
			$amount_jan= 0;
			$amount_feb=0;
			$amount_march=0;
			$amount_april=0;
			$amount_may=0;
			$amount_june=0;
			$amount_july=0;
			$amount_august=0;
			$amount_september=0;
			$amount_october=0;
			$amount_november=0;
			$amount_december=0;
			

			while($row_revenue = mysqli_fetch_assoc($query_revenues))
			{
				
				$customer = array(
					
					"id" => $row_revenue['cust_id'],
					"name"=>$row_revenue['cust_name'],
					"email"=>$row_revenue['cust_email'],
					"amount"=>$row_revenue['sav_amount'],
					"month"=>$row_revenue['sav_month']
				
					

				);

				array_push($customers,$customer);
			}
			   $data = array();
			  
			   
			   foreach($customers as $value){
				   if($value['month']=='January')
				   {
					   global $amount_jan;
					   $amount_jan += $value['amount'];
				   }
				   if($value['month']=='February')
				   { 
					   global $amount_feb;
					   $amount_feb += $value['amount'];
				   }
				   if($value['month']=='March')
				   { 
					   global $amount_march;
					   $amount_march += $value['amount'];
				   }
				   if($value['month']=='April')
				   { 
					   global $amount_april;
					   $amount_april += $value['amount'];
				   }
				   if($value['month']=='May')
				   { 
					   global $amount_may;
					   $amount_may += $value['amount'];
				   }
				   if($value['month']=='June')
				   { 
					   global $amount_june;
					   $amount_june += $value['amount'];
				   }
				   if($value['month']=='July')
				   { 
					   global $amount_july;
					   $amount_july += $value['amount'];
				   }
				   if($value['month']=='August')
				   { 
					   global $amount_august;
					   $amount_august += $value['amount'];
				   }
				   if($value['month']=='September')
				   { 
					   global $amount_september;
					   $amount_september += $value['amount'];
				   }
				   if($value['month']=='October')
				   { 
					   global $amount_october;
					   $amount_october += $value['amount'];
				   }
				   if($value['month']=='November')
				   { 
					   global $amount_november;
					   $amount_november += $value['amount'];
				   }
				   if($value['month']=='December')
				   { 
					   global $amount_december;
					   $amount_december += $value['amount'];
				   }
				   $total_inc = $amount_jan + $amount_feb + $amount_march + $amount_april +
				   $amount_may + $amount_june + $amount_july + $amount_august + $amount_september +
				   $amount_october + $amount_november + $amount_december;
			   $key =$value['id'].$value['name'].$value['email'];
			   if(!isset($data[$key]))
			   {
				   $data[$key] = array("id"=>$value['id'],"name"=>$value['name'],"email"=>$value['email'],
				   "amount"=>array($value['month'] => $value['amount']));
			   }
			   $data[$key]['amount'] += [$value['month'] => $value['amount']];
			   

			   
			   
			}

			
			
		
			
			
			
			
			
				foreach($data as $row)
				{
				
					
				
				
				echo
				"<tr>
				
				<td>".$row['name']. "</td>
				<td>".$row['email']. "</td>

		<td>"; foreach($row['amount'] as $key => $value){
				 if($key == 'May')
				 {
					 echo number_format($value);
		        }
				}echo "</td>
		<td>"; foreach($row['amount'] as $key => $value){
			if($key == 'June')
				{
			   echo number_format($value);
		}}echo "</td>
		 <td>"; foreach($row['amount'] as $key => $value){
				if($key == 'July')
				 {
					 echo number_format($value);
				 }}echo "</td>
		<td>"; foreach($row['amount'] as $key => $value){
				if($key == 'August')
				 {
				   echo number_format($value);
				 }
				 }echo "</td>
		<td>"; foreach($row['amount'] as $key => $value){
				if($key == 'September')
						{
					 echo number_format($value);
				 }}echo "</td>
	    <td>"; foreach($row['amount'] as $key => $value){
					if($key == 'October')
						 {
				  echo number_format($value);
					 }}echo "</td>
		<td>"; foreach($row['amount'] as $key => $value){
					if($key == 'November')
						{
					 echo number_format($value);
					 }}echo "</td>
		<td>"; foreach($row['amount'] as $key => $value){
								
								 if($key == 'December')
								 {
									 echo number_format($value);
								 }
							 }echo "</td>
				
		<td style ='font-weight:bold;'>"; //foreach($row['amount'] as $key=>$value)
		//{
			echo number_format(array_sum($row['amount']));
		//}
		//echo $arr;
		echo"</td>

		<td style ='font-weight:bold;'>"; foreach($query_total as $totals)
		{
			if($totals['cust_id'] == $row['id'])
			{
				echo number_format($totals['total']);

				
			}
			//echo $sum;
		}
			
		
		  
		echo "</td>
		
				
				</tr>";
				
				

				
				}
    
				echo '<tr>
		<td style="font-weight:bold;">TOTALS</td>
		<td></td>
		<td style ="font-weight:bold;">'.number_format($amount_may).'</td>
		<td style ="font-weight:bold;">'.number_format($amount_june).'</td>
		<td style ="font-weight:bold;">'.number_format($amount_july).'</td>
		<td style ="font-weight:bold;">'.number_format($amount_august).'</td>
		<td style ="font-weight:bold;">'.number_format($amount_september).'</td>
		<td style ="font-weight:bold;">'.number_format($amount_october).'</td>
		<td style ="font-weight:bold;">'.number_format($amount_november).'</td>
		<td style ="font-weight:bold;">'.number_format($amount_december).'</td>
		<td style ="font-weight:bold;">'.number_format($total_inc).'</td>
		</tr>';

		echo "</tr>
		<td style = 'font-weight:bold;'>CUMULATIVE Toatals</d>
		<td></td>
		<td style ='font-weight:bold;'>".number_format($amount_jan + $amount_feb + $amount_march + $amount_april + $amount_may)."</td>
		<td style ='font-weight:bold;'>".number_format($amount_jan + $amount_feb + $amount_march + $amount_april + $amount_may + $amount_june)."</td>
		<td style ='font-weight:bold;'>".number_format($amount_jan + $amount_feb + $amount_march + $amount_april + $amount_may + $amount_june + $amount_july)."</td>
		<td style ='font-weight:bold;'>".number_format($amount_jan + $amount_feb + $amount_march + 
		$amount_april + $amount_may + $amount_june + $amount_july + $amount_august)."</td>
		<td style ='font-weight:bold;'>".number_format($amount_jan + $amount_feb + $amount_march + 
		$amount_april + $amount_may + $amount_june + $amount_july + $amount_august+ $amount_september)."</td>
		<td style ='font-weight:bold;'>".number_format($amount_jan + $amount_feb + $amount_march + 
		$amount_april + $amount_may + $amount_june +
		 $amount_july +$amount_august + $amount_september + $amount_october)."</td>
		 <td style ='font-weight:bold;'>".number_format($amount_jan + $amount_feb + $amount_march + 
		$amount_april + $amount_may + $amount_june +
		 $amount_july + $amount_august + $amount_september + $amount_october + $amount_november)."</td>
		 <td style ='font-weight:bold;'>".number_format($amount_jan + $amount_feb + $amount_march + 
		 $amount_april + $amount_may + $amount_june +
		  $amount_july +$amount_august+ $amount_september + $amount_october + $amount_november + $amount_december)."</td>
		  <td style ='font-weight:bold;'></td>









		
		
		</tr>";

				
			
				?>
				</tr>
				  </table>
			

		<?php	} 

			else
			{
          ?>

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
			<th class="title" colspan="15">CHENKEN WELFARE ASSOCIATION - <?PHP echo $years; ?></th>
			</tr>
			<tr>
			<th colspan ="2"></th>
			<th colspan ="13">Amount</th>
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
			<th style ='font-weight:bold;'>TOTALS</th>
			<th>Cumulative Totals </th>
			

			</tr>
			<?php
			$total_inc = 0;
			$data=array();
			$output = array();
			$outputs=[];
			$savings = array();
			$customers = array();
			$amount_jan= 0;
			$amount_feb=0;
			$amount_march=0;
			$amount_april=0;
			$amount_may=0;
			$amount_june=0;
			$amount_july=0;
			$amount_august=0;
			$amount_september=0;
			$amount_october=0;
			$amount_november=0;
			$amount_december=0;
			

			while($row_revenue = mysqli_fetch_assoc($query_revenues))
			{
				
				$customer = array(
					
					"id" => $row_revenue['cust_id'],
					"name"=>$row_revenue['cust_name'],
					"email"=>$row_revenue['cust_email'],
					"amount"=>$row_revenue['sav_amount'],
					"month"=>$row_revenue['sav_month']
				
					

				);

				array_push($customers,$customer);
			}
			   $data = array();
			  
			   
			   foreach($customers as $value){
				   if($value['month']=='January')
				   {
					   global $amount_jan;
					   $amount_jan += $value['amount'];
				   }
				   if($value['month']=='February')
				   { 
					   global $amount_feb;
					   $amount_feb += $value['amount'];
				   }
				   if($value['month']=='March')
				   { 
					   global $amount_march;
					   $amount_march += $value['amount'];
				   }
				   if($value['month']=='April')
				   { 
					   global $amount_april;
					   $amount_april += $value['amount'];
				   }
				   if($value['month']=='May')
				   { 
					   global $amount_may;
					   $amount_may += $value['amount'];
				   }
				   if($value['month']=='June')
				   { 
					   global $amount_june;
					   $amount_june += $value['amount'];
				   }
				   if($value['month']=='July')
				   { 
					   global $amount_july;
					   $amount_july += $value['amount'];
				   }
				   if($value['month']=='August')
				   { 
					   global $amount_august;
					   $amount_august += $value['amount'];
				   }
				   if($value['month']=='September')
				   { 
					   global $amount_september;
					   $amount_september += $value['amount'];
				   }
				   if($value['month']=='October')
				   { 
					   global $amount_october;
					   $amount_october += $value['amount'];
				   }
				   if($value['month']=='November')
				   { 
					   global $amount_november;
					   $amount_november += $value['amount'];
				   }
				   if($value['month']=='December')
				   { 
					   global $amount_december;
					   $amount_december += $value['amount'];
				   }
				   $total_inc = $amount_jan + $amount_feb + $amount_march + $amount_april +
				   $amount_may + $amount_june + $amount_july + $amount_august + $amount_september +
				   $amount_october + $amount_november + $amount_december;
			   $key =$value['id'].$value['name'].$value['email'];
			   if(!isset($data[$key]))
			   {
				   $data[$key] = array("id"=>$value['id'],"name"=>$value['name'],"email"=>$value['email'],
				   "amount"=>array($value['month'] => $value['amount']));
			   }
			   $data[$key]['amount'] += [$value['month'] => $value['amount']];
			   

			   
			   
			}

			
			
		
			
			
			
			
			
				foreach($data as $row)
				{
				
					
				
				
				echo
				"<tr>
				
				<td>".$row['name']. "</td>
				

		<td>"; 
					foreach($row['amount'] as $key => $value)
					 {
						 if($key =='January')
						 {
					   echo number_format($value);
						 }
					 }echo "</td>
		<td>"; foreach($row['amount'] as $key => $value){
					if($key == 'February')
						{
					   echo number_format ($value);
					 }}echo "</td>

		<td>"; foreach($row['amount'] as $key => $value){
					if($key == 'March')
						{
						 echo number_format($value);
					 }}echo "</td>
		<td>"; foreach($row['amount'] as $key => $value){
					if($key == 'April')
					 {
					   echo number_format($value);
					 }}echo "</td>
		<td>"; foreach($row['amount'] as $key => $value){
				 if($key == 'May')
				 {
					 echo number_format($value);
		        }
				}echo "</td>
		<td>"; foreach($row['amount'] as $key => $value){
			if($key == 'June')
				{
			   echo number_format($value);
		}}echo "</td>
		 <td>"; foreach($row['amount'] as $key => $value){
				if($key == 'July')
				 {
					 echo number_format($value);
				 }}echo "</td>
		<td>"; foreach($row['amount'] as $key => $value){
				if($key == 'August')
				 {
				   echo number_format($value);
				 }
				 }echo "</td>
		<td>"; foreach($row['amount'] as $key => $value){
				if($key == 'September')
						{
					 echo number_format($value);
				 }}echo "</td>
	    <td>"; foreach($row['amount'] as $key => $value){
					if($key == 'October')
						 {
				  echo number_format($value);
					 }}echo "</td>
		<td>"; foreach($row['amount'] as $key => $value){
					if($key == 'November')
						{
					 echo number_format($value);
					 }}echo "</td>
		<td>"; foreach($row['amount'] as $key => $value){
								
								 if($key == 'December')
								 {
									 echo number_format($value);
								 }
							 }echo "</td>
				
		<td style ='font-weight:bold;'>"; //foreach($row['amount'] as $key=>$value)
		//{
			echo number_format(array_sum($row['amount']));
		//}
		//echo $arr;
		echo"</td>

		<td style ='font-weight:bold;'>"; foreach($query_total as $totals)
		{
			if($totals['cust_id'] == $row['id'])
			{
				echo number_format($totals['total']);

				
			}
			//echo $sum;
		}
			
		
		  
		echo "</td>
		
				
				</tr>";
				
				

				
				}
    
				echo '<tr>
		<td style="font-weight:bold;">TOTALS</td>
		<td style ="font-weight:bold;">'.number_format($amount_jan).'</td>
		<td style ="font-weight:bold;">'.number_format($amount_feb).'</td>
		<td style ="font-weight:bold;">'.number_format($amount_march).'</td>
		<td style ="font-weight:bold;">'.number_format($amount_april).'</td>
		<td style ="font-weight:bold;">'.number_format($amount_may).'</td>
		<td style ="font-weight:bold;">'.number_format($amount_june).'</td>
		<td style ="font-weight:bold;">'.number_format($amount_july).'</td>
		<td style ="font-weight:bold;">'.number_format($amount_august).'</td>
		<td style ="font-weight:bold;">'.number_format($amount_september).'</td>
		<td style ="font-weight:bold;">'.number_format($amount_october).'</td>
		<td style ="font-weight:bold;">'.number_format($amount_november).'</td>
		<td style ="font-weight:bold;">'.number_format($amount_december).'</td>
		<td style ="font-weight:bold;">'.number_format($total_inc).'</td>
		</tr>';

		echo "</tr>
		<td style = 'font-weight:bold;'>CUMULATIVE Toatals</td>
		<td></td>
		<td style ='font-weight:bold;'>".number_format($amount_jan + $amount_feb)."</td>
		<td style ='font-weight:bold;'>".number_format($amount_jan + $amount_feb + $amount_march)."</td>
		<td style ='font-weight:bold;'>".number_format($amount_jan + $amount_feb + $amount_march + $amount_april)."</td>
		<td style ='font-weight:bold;'>".number_format($amount_jan + $amount_feb + $amount_march + $amount_april + $amount_may)."</td>
		<td style ='font-weight:bold;'>".number_format($amount_jan + $amount_feb + $amount_march + $amount_april + $amount_may + $amount_june)."</td>
		<td style ='font-weight:bold;'>".number_format($amount_jan + $amount_feb + $amount_march + $amount_april + $amount_may + $amount_june + $amount_july)."</td>
		<td style ='font-weight:bold;'>".number_format($amount_jan + $amount_feb + $amount_march + 
		$amount_april + $amount_may + $amount_june + $amount_july + $amount_august)."</td>
		<td style ='font-weight:bold;'>".number_format($amount_jan + $amount_feb + $amount_march + 
		$amount_april + $amount_may + $amount_june + $amount_july + $amount_august+ $amount_september)."</td>
		<td style ='font-weight:bold;'>".number_format($amount_jan + $amount_feb + $amount_march + 
		$amount_april + $amount_may + $amount_june +
		 $amount_july +$amount_august + $amount_september + $amount_october)."</td>
		 <td style ='font-weight:bold;'>".number_format($amount_jan + $amount_feb + $amount_march + 
		$amount_april + $amount_may + $amount_june +
		 $amount_july + $amount_august + $amount_september + $amount_october + $amount_november)."</td>
		 <td style ='font-weight:bold;'>".number_format($amount_jan + $amount_feb + $amount_march + 
		 $amount_april + $amount_may + $amount_june +
		  $amount_july +$amount_august+ $amount_september + $amount_october + $amount_november + $amount_december)."</td>
		  <td style ='font-weight:bold;'></td>









		
		
		</tr>";

				
			
				
				//foreach($cities as $key => $value){
				//	echo $key . " : " . $value . "<br>"

			
				?>
			
			  
		
				  </tr>
				 
				






			<?php
			}
			?>
            

			<table id="tb_table" style="width:40%">
			<colgroup>

					
					
				
				</colgroup>
				<tr>
					<th class="title" colspan="3">Expenditure <?PHP echo $years; ?></th>
				</tr>
				<tr>

				<td>
				Revenue total:
				</td>
				<td></td>
				<td>
				<?php 
				 $revenue =mysqli_fetch_assoc($query_total_revenue);
				 $revenue_total = $revenue['revenue_total'];
				 echo $revenue['revenue_total'];
				
				 ?>
				</td>
				</tr>
				<?php

				$sql_expense = "SELECT exptype_id as types,exp_amount as amount,exp_year from expenses e 
				 WHERE exp_year = $years";
				$query_expense=mysqli_query($db_link,$sql_expense);
				checkSQL($db_link, $query_expense);
				$expense_total =0;
				foreach($query_expense as $expense )
                 {
					 
					 $expense_total += $expense['amount'];
					 echo "<tr>
					 <td>".$expense['types']."</td>
					 <td>".$expense['amount']."</td>
					 <td></td>
					 </tr>";
					
				 }
				 $balance =$revenue_total - $expense_total;
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
	
	?>


	</body>
</html>