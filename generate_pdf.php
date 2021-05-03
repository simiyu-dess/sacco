<?PHP
session_start();
require 'TCPDF/tcpdf.php';
$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
$obj_pdf->SetCreator(PDF_CREATOR);  
$obj_pdf->SetTitle("Revenue");  
$obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
$obj_pdf->SetDefaultMonospacedFont('helvetica');  
$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
$obj_pdf->SetMargins(0, '0',2);  
$obj_pdf->setPrintHeader(FALSE);  
$obj_pdf->setPrintFooter(false);  
$obj_pdf->SetAutoPageBreak(TRUE, 10);  
$obj_pdf->SetFont('helvetica', '', 5);  
$obj_pdf->AddPage();


//$query = mysqli_fetch_assoc($_SESSION['query_total']);

if($_SESSION['year']==2014)
{
	        $amount_may = $_SESSION['amount_may'];
			$amount_june = $_SESSION['amount_june'];
			$amount_july = $_SESSION['amount_july'];
			$amount_aug = $_SESSION['amount_august'];
			$amount_sep = $_SESSION['amount_september'];
			$amount_oct = $_SESSION['amount_october'];
			$amount_nov = $_SESSION['amount_november'];
			$amount_dec = $_SESSION['amount_december'];
			$amount_total = $_SESSION['total_inc'];
			
            
            $html='';
			$html .= '
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
			<th style ="font-weight:bold;">TOTALS</th>
			<th>Cumulative Totals </th>
			

			</tr>';
		

			foreach($_SESSION['data'] as $row)
				{

					$name = $row['name'];
					$email = $row['email'];
					foreach($row['amount'] as $key => $value){
						if($key == "May")
						{
							$May = number_format($value);
						}
						if($key=="June")
						{
							$june =number_format($value);
						}
						if($key=="July")
						{
							$july =number_format($value);
						}
						if($key=="August")
						{
							$August =number_format($value);
						}
						if($key=="September")
						{
							$september =number_format($value);
						}
						if($key=="October")
						{
							$october =number_format($value);
						}
						if($key=="November")
						{
							$november =number_format($value);
						}
						if($key=="December")
						{
							$december =number_format($value);
						}

					}

			if(array_sum($row['amount'])>0)
			{
			$sum = number_format(array_sum($row['amount']));
			}

			else{
				$sum = 0;
			}
			foreach($_SESSION['total'] as $id => $values)
					{
						if($id == $row['id'])
						{
							$c_total = number_format($values);
							
			
							
						}
					}
			
			$html .= '
				<tr>		
		<td>'.$name.'</td>
		<td>'.$email.'</td>
		<td>'.$May.'</td>
		<td>'.$june.'</td>
		<td>'.$july.'</td>
		<td>'.$August.'</td>
		<td>'.$september.'</td>
		<td>'.$october.'</td>
		<td>'.$november.'</td>
		<td>'.$december.'</td>
		<td>'.$sum.'</td>
		<td>'.$c_total.'</td>
		</tr>';
			}
					
			$html .= '
				<tr>		
		<td>Totals</td>
		<td></td>
		<td>'.number_format($amount_may).'</td>
		<td>'.number_format($amount_june).'</td>
		<td>'.number_format($amount_july).'</td>
		<td>'.number_format($amount_aug).'</td>
		<td>'.number_format($amount_sep).'</td>
		<td>'.number_format($amount_oct).'</td>
		<td>'.number_format($amount_nov).'</td>
		<td>'.number_format($amount_dec).'</td>
		</tr>';

		$html .= '
		<tr>		
<td>C.Totals</td>
<td></td>
<td>'.number_format($amount_may).'</td>
<td>'.number_format($amount_june + $amount_may).'</td>
<td>'.number_format($amount_july +$amount_june + $amount_may).'</td>
<td>'.number_format($amount_aug + $amount_july +$amount_june + $amount_may).'</td>
<td>'.number_format($amount_sep + $amount_aug + $amount_july +$amount_june + $amount_may).'</td>
<td>'.number_format($amount_oct + $amount_sep + $amount_aug + $amount_july +$amount_june + $amount_may).'</td>
<td>'.number_format($amount_nov + $amount_oct + $amount_sep + $amount_aug + $amount_july +$amount_june + $amount_may).'</td>
<td>'.number_format($amount_dec + $amount_nov + $amount_oct + $amount_sep + $amount_aug + $amount_july +$amount_june + $amount_may).'</td>
</tr>';
		}
		else
		{   $amount_jan = $_SESSION['amount_jan'];
			$amount_feb = $_SESSION['amount_feb'];
			$amount_march = $_SESSION['amount_march'];
			$amount_april = $_SESSION['amount_april'];
            $amount_may = $_SESSION['amount_may'];
			$amount_june = $_SESSION['amount_june'];
			$amount_july = $_SESSION['amount_july'];
			$amount_aug = $_SESSION['amount_august'];
			$amount_sep = $_SESSION['amount_september'];
			$amount_oct = $_SESSION['amount_october'];
			$amount_nov = $_SESSION['amount_november'];
			$amount_dec = $_SESSION['amount_december'];
			$amount_total = $_SESSION['total_inc'];

			$html='';
			$html .= '
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
			<th class="title" colspan="15">CHENKEN WELFARE ASSOCIATION - echo $_SESSION[year]; ?></th>
			
			</tr>
			<tr>
			<th colspan= "2"></th>
			<th colspan = "13"> Amount </th>
			</tr>
			<tr>
			<th>Name</th>
			<th>Email</th>
			<th>jan</th>
			<th>feb</th>
			<th>march</th>
			<th>April</th>
			<th>May</th>
			<th>June</th>
			<th>July</th>
			<th>Aug</th>
			<th>Sep</th>
			<th>Oct</th>
			<th>Nov</th>
			<th>Dec</th>
			<th style ="font-weight:bold;">TOTALS</th>
			<th style ="font-weight:bold;">C.Totals </th>
			

			</tr>';
			

			foreach($_SESSION['data'] as $row)
				{
					


					$name = $row['name'];
					$email = $row['email'];
					foreach($row['amount'] as $key => $value){
						
						if($key == "January")
						{
							$Jan = number_format($value);	
						}
						if($key == "February")
						{
							$Feb = number_format($value);
							
						}
						if($key == "March")
						{
							$March = number_format($value);
							
						}
						if($key == "April")
						{
							$April = number_format($value);
							
						}
						if($key == "May")
						{
							$May = number_format($value);
							$value=0;
							
							
						}
						if($key=="June")
						{   
							$june =number_format($value);
							
							
						}
						if($key=="July")
						{
							$july =number_format($value);
							
							
						}
						if($key=="August")
						{
							$August =number_format($value);
						
							
						}
						if($key=="September")
						{
							$september =number_format($value);
							
							
						}
						if($key=="October")
						{
							$october =number_format($value);
							
						}
						if($key=="November")
						{
							$november =number_format($value);
							
						}
						if($key=="December")
						{
							$december =number_format($value);
							
						}
						//unset($Jan);
					   
						
						
						

					}
					if(array_sum($row['amount'])>0)
			{
			$sum = number_format(array_sum($row['amount']));
			}

			else{
				$sum = 0;
			}
			foreach($_SESSION['total'] as $id => $values)
					{
						if($id == $row['id'])
						{
							$c_total = number_format($values);
							
			
							
						}
					}
				
			$html .= '
		<tr><td colspan= "17">--------------------------------------------------------------
		--------------------------------------------------------------------------------
		----------------------------------------------------------------------------------
		---------------------------------------------------------------------------------
		--------------------------------------------</td></tr>
				<tr>		
		<td>'.$name.'</td>
		<td>'.$email.'</td>
		<td>'.$Jan.'</td>
		<td>'.$Feb.'</td>
		<td>'.$March.'</td>
		<td>'.$April.'</td>
		<td>'.$May.'</td>
		<td>'.$june.'</td>
		<td>'.$july.'</td>
		<td>'.$August.'</td>
		<td>'.$september.'</td>
		<td>'.$october.'</td>
		<td>'.$november.'</td>
		<td>'.$december.'</td>
		<td style="font-weight:Bold;">'.$sum.'</td>
		<td style ="font-weight:bold;">'.$c_total.'</td>
		<td></td>
		</tr>';
		unset($Jan);
		unset($Feb);
		unset($March);
		unset($April);
		unset($May);
		unset($june);
		unset($july);
		unset($August);
		unset($september);
		unset($october);
		unset($november);
		unset($december);
			}
			$html .= '
			<tr><td colspan= "17">--------------------------------------------------------------
		--------------------------------------------------------------------------------
		----------------------------------------------------------------------------------
		---------------------------------------------------------------------------------
		--------------------------------------------</td></tr>
				<tr>		
		<td style="font-weight:Bold;">Totals</td> 
		<td></td>
		<td style="font-weight:Bold;">'.number_format($amount_jan).'</td>
		<td style="font-weight:Bold;">'.number_format($amount_feb).'</td>
		<td style="font-weight:Bold;">'.number_format($amount_march).'</td>
		<td style="font-weight:Bold;">'.number_format($amount_april).'</td>
		<td style="font-weight:Bold;">'.number_format($amount_may).'</td>
		<td style="font-weight:Bold;">'.number_format($amount_june).'</td>
		<td style="font-weight:Bold;">'.number_format($amount_july).'</td>
		<td style="font-weight:Bold;">'.number_format($amount_aug).'</td>
		<td style="font-weight:Bold;">'.number_format($amount_sep).'</td>
		<td style="font-weight:Bold;">'.number_format($amount_oct).'</td>
		<td style="font-weight:Bold;">'.number_format($amount_nov).'</td>
		<td style="font-weight:Bold;">'.number_format($amount_dec).'</td>
		<td style="font-weight:Bold;">'.number_format($amount_total).'</td>
		</tr>
		<tr><td colspan= "17">--------------------------------------------------------------
		--------------------------------------------------------------------------------
		----------------------------------------------------------------------------------
		---------------------------------------------------------------------------------
		--------------------------------------------</td></tr>';


		$html .= '
		<tr>		
<td style="font-weight:Bold;">C.Totals</td>
<td></td>
<td style="font-weight:Bold;">'.number_format($amount_jan).'</td>
<td style="font-weight:Bold;">'.number_format($amount_jan + $amount_feb).'</td>
<td style="font-weight:Bold;">'.number_format($amount_jan + $amount_feb + $amount_march).'</td>
<td style="font-weight:Bold;">'.number_format($amount_jan + $amount_feb + $amount_march + $amount_april).'</td>
<td style="font-weight:Bold;">'.number_format($amount_jan + $amount_feb + $amount_march + $amount_april + $amount_may).'</td>
<td style="font-weight:Bold;">'.number_format($amount_jan + $amount_feb + $amount_march + $amount_april + $amount_may + $amount_june).'</td>
<td style="font-weight:Bold;">'.number_format($amount_jan + $amount_feb + $amount_march + $amount_april + $amount_may + $amount_june + $amount_july).'</td>
<td style="font-weight:Bold;">'.number_format($amount_jan + $amount_feb + $amount_march + $amount_april + $amount_may +
 $amount_june + $amount_july + $amount_aug).'</td>
 <td style="font-weight:Bold;">'.number_format($amount_jan + $amount_feb + $amount_march + $amount_april + $amount_may +
 $amount_june + $amount_july + $amount_aug + $amount_sep).'</td>
 <td style="font-weight:Bold;">'.number_format($amount_jan + $amount_feb + $amount_march + $amount_april + $amount_may +
 $amount_june + $amount_july + $amount_aug + $amount_sep + $amount_oct).'</td>
 <td style="font-weight:Bold;">'.number_format($amount_jan + $amount_feb + $amount_march + $amount_april + $amount_may +
 $amount_june + $amount_july + $amount_aug + $amount_sep + $amount_oct + $amount_nov).'</td>
 <td style="font-weight:Bold;">'.number_format($amount_jan + $amount_feb + $amount_march + $amount_april + $amount_may +
 $amount_june + $amount_july + $amount_aug + $amount_sep + $amount_oct + $amount_nov + $amount_dec).'</td>
</tr>';

		}
    

		
        
		$obj_pdf->writeHTML($html);  
        ob_end_clean();
		$obj_pdf->Output('revenue_report.pdf', 'I');


	unset($_SESSION['totals']);
	//unset($_SESSION['sav_export']);
		
?>
