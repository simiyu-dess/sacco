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
$obj_pdf->SetFont('helvetica', '', 8);  
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
			<table style="width:95%; border: 1px solid black;">
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
			<th colspan="13" style="border: 1px solid black;text-align:center;">CHENKEN WELFARE ASSOCIATION SAVINGS- '.$_SESSION['year'].'</th>
			
			</tr>
			<tr>
			<th colspan= "2" style="border: 1px solid black;"></th>
			<th colspan = "10" style="border: 1px solid black;"> Amount </th>
			</tr>
			<tr>
			<th style="border: 1px solid black;">Name</th>
			<th style="border: 1px solid black;">Email</th>
			<th style="border: 1px solid black;">May</th>
			<th style="border: 1px solid black;">June</th>
			<th style="border: 1px solid black;">July</th>
			<th style="border: 1px solid black;">August</th>
			<th style="border: 1px solid black;">September</th>
			<th style="border: 1px solid black;">October</th>
			<th style="border: 1px solid black;">November</th>
			<th style="border: 1px solid black;">December</th>
			<th style ="font-weight:bold;border: 1px solid black;">TOTALS</th>
			<th style="border: 1px solid black;">Cumulative Totals </th>
			

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
		<td style="border: 1px solid black;">'.$name.'</td>
		<td style="border: 1px solid black;">'.$email.'</td>
		<td style="border: 1px solid black;">'.$May.'</td>
		<td style="border: 1px solid black;">'.$june.'</td>
		<td style="border: 1px solid black;">'.$july.'</td>
		<td style="border: 1px solid black;">'.$August.'</td>
		<td style="border: 1px solid black;">'.$september.'</td>
		<td style="border: 1px solid black;">'.$october.'</td>
		<td style="border: 1px solid black;">'.$november.'</td>
		<td style="border: 1px solid black;">'.$december.'</td>
		<td style="border: 1px solid black;">'.$sum.'</td>
		<td style="border: 1px solid black;">'.$c_total.'</td>
		</tr>';
			}
					
			$html .= '
				<tr>		
		<td style="border: 1px solid black;">Totals</td>
		<td style="border: 1px solid black;"></td>
		<td style="border: 1px solid black;">'.number_format($amount_may).'</td>
		<td style="border: 1px solid black;">'.number_format($amount_june).'</td>
		<td style="border: 1px solid black;">'.number_format($amount_july).'</td>
		<td style="border: 1px solid black;">'.number_format($amount_aug).'</td>
		<td style="border: 1px solid black;">'.number_format($amount_sep).'</td>
		<td style="border: 1px solid black;">'.number_format($amount_oct).'</td>
		<td style="border: 1px solid black;">'.number_format($amount_nov).'</td>
		<td style="border: 1px solid black;">'.number_format($amount_dec).'</td>
		</tr>';

		$html .= '
		<tr>		
<td style="border: 1px solid black;">C.Totals</td>
<td style="border: 1px solid black;"></td>
<td style="border: 1px solid black;">'.number_format($amount_may).'</td>
<td style="border: 1px solid black;">'.number_format($amount_june + $amount_may).'</td>
<td style="border: 1px solid black;">'.number_format($amount_july +$amount_june + $amount_may).'</td>
<td style="border: 1px solid black;">'.number_format($amount_aug + $amount_july +$amount_june + $amount_may).'</td>
<td style="border: 1px solid black;">'.number_format($amount_sep + $amount_aug + $amount_july +$amount_june + $amount_may).'</td>
<td style="border: 1px solid black;">'.number_format($amount_oct + $amount_sep + $amount_aug + $amount_july +$amount_june + $amount_may).'</td>
<td style="border: 1px solid black;">'.number_format($amount_nov + $amount_oct + $amount_sep + $amount_aug + $amount_july +$amount_june + $amount_may).'</td>
<td style="border: 1px solid black;">'.number_format($amount_dec + $amount_nov + $amount_oct + $amount_sep + $amount_aug + $amount_july +$amount_june + $amount_may).'</td>
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
			<table style="width:99%;border: 1px solid black;">
			<colspan>
			<col width="15.5%">
			<col width="17.5%">
			<col width="5%">
			<col width="5%">
			<col width="5%">
			<col width="5%">
			<col width="5%">
			<col width="5%">
			<col width="5%">
			<col width="5%">
			<col width="5%">
			<col width="5%">
			<col width="5%">
			<col width="5%">
			<col width="5%">
			<col width="5.5%">
			</colspan>
			<tr>
			<th class="title" colspan="16" style="border: 1px solid black;text-align:center;">CHENKEN WELFARE ASSOCIATION - '.$_SESSION['year'].'</th>
			
			</tr>
			<tr>
			<th colspan= "2" style="border: 1px solid black;"></th>
			<th colspan = "13" style="border: 1px solid black;text-align:center;"> Amount </th>
			</tr>
			<tr>
			<th style="border: 1px solid black;">Name</th>
			<th style="border: 1px solid black;">Email</th>
			<th style="border: 1px solid black;">jan</th>
			<th style="border: 1px solid black;">feb</th>
			<th style="border: 1px solid black;">march</th>
			<th style="border: 1px solid black;">April</th>
			<th style="border: 1px solid black;">May</th>
			<th style="border: 1px solid black;">June</th>
			<th style="border: 1px solid black;">July</th>
			<th style="border: 1px solid black;">Aug</th>
			<th style="border: 1px solid black;">Sep</th>
			<th style="border: 1px solid black;">Oct</th>
			<th style="border: 1px solid black;">Nov</th>
			<th style="border: 1px solid black;">Dec</th>
			<th style ="font-weight:bold;border: 1px solid black;">TOTALS</th>
			<th style ="font-weight:bold;border: 1px solid black;">C.Totals </th>
			

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
		<td style="border: 1px solid black;">'.$name.'</td>
		<td style="border: 1px solid black;">'.$email.'</td>
		<td style="border: 1px solid black;">'.$Jan.'</td>
		<td style="border: 1px solid black;">'.$Feb.'</td>
		<td style="border: 1px solid black;">'.$March.'</td>
		<td style="border: 1px solid black;">'.$April.'</td>
		<td style="border: 1px solid black;">'.$May.'</td>
		<td style="border: 1px solid black;">'.$june.'</td>
		<td style="border: 1px solid black;">'.$july.'</td>
		<td style="border: 1px solid black;">'.$August.'</td>
		<td style="border: 1px solid black;">'.$september.'</td>
		<td style="border: 1px solid black;">'.$october.'</td>
		<td style="border: 1px solid black;">'.$november.'</td>
		<td style="border: 1px solid black;">'.$december.'</td>
		<td style="font-weight:Bold;border: 1px solid black;">'.$sum.'</td>
		<td style ="font-weight:bold;border: 1px solid black;">'.$c_total.'</td>
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
				<tr>		
		<td style="font-weight:Bold;border: 1px solid black;">Totals</td> 
		<td></td>
		<td style="font-weight:Bold;border: 1px solid black;">'.number_format($amount_jan).'</td>
		<td style="font-weight:Bold;border: 1px solid black;">'.number_format($amount_feb).'</td>
		<td style="font-weight:Bold;border: 1px solid black;">'.number_format($amount_march).'</td>
		<td style="font-weight:Bold;border: 1px solid black;">'.number_format($amount_april).'</td>
		<td style="font-weight:Bold;border: 1px solid black;">'.number_format($amount_may).'</td>
		<td style="font-weight:Bold;border: 1px solid black;">'.number_format($amount_june).'</td>
		<td style="font-weight:Bold;border: 1px solid black;">'.number_format($amount_july).'</td>
		<td style="font-weight:Bold;border: 1px solid black;">'.number_format($amount_aug).'</td>
		<td style="font-weight:Bold;border: 1px solid black;">'.number_format($amount_sep).'</td>
		<td style="font-weight:Bold;border: 1px solid black;">'.number_format($amount_oct).'</td>
		<td style="font-weight:Bold;border: 1px solid black;">'.number_format($amount_nov).'</td>
		<td style="font-weight:Bold;border: 1px solid black;">'.number_format($amount_dec).'</td>
		<td style="font-weight:Bold;border: 1px solid black;">'.number_format($amount_total).'</td>
		</tr>
		';


		$html .= '
		<tr>		
<td style="font-weight:Bold;">C.Totals</td>
<td></td>
<td style="font-weight:Bold;border: 1px solid black;">'.number_format($amount_jan).'</td>
<td style="font-weight:Bold;border: 1px solid black;">'.number_format($amount_jan + $amount_feb).'</td>
<td style="font-weight:Bold;border: 1px solid black;">'.number_format($amount_jan + $amount_feb + $amount_march).'</td>
<td style="font-weight:Bold;border: 1px solid black;">'.number_format($amount_jan + $amount_feb + $amount_march + $amount_april).'</td>
<td style="font-weight:Bold;border: 1px solid black;">'.number_format($amount_jan + $amount_feb + $amount_march + $amount_april + $amount_may).'</td>
<td style="font-weight:Bold;border: 1px solid black;">'.number_format($amount_jan + $amount_feb + $amount_march + $amount_april + $amount_may + $amount_june).'</td>
<td style="font-weight:Bold;border: 1px solid black;">'.number_format($amount_jan + $amount_feb + $amount_march + $amount_april + $amount_may + $amount_june + $amount_july).'</td>
<td style="font-weight:Bold;border: 1px solid black;">'.number_format($amount_jan + $amount_feb + $amount_march + $amount_april + $amount_may +
 $amount_june + $amount_july + $amount_aug).'</td>
 <td style="font-weight:Bold;border: 1px solid black;">'.number_format($amount_jan + $amount_feb + $amount_march + $amount_april + $amount_may +
 $amount_june + $amount_july + $amount_aug + $amount_sep).'</td>
 <td style="font-weight:Bold;border: 1px solid black;">'.number_format($amount_jan + $amount_feb + $amount_march + $amount_april + $amount_may +
 $amount_june + $amount_july + $amount_aug + $amount_sep + $amount_oct).'</td>
 <td style="font-weight:Bold;border: 1px solid black;">'.number_format($amount_jan + $amount_feb + $amount_march + $amount_april + $amount_may +
 $amount_june + $amount_july + $amount_aug + $amount_sep + $amount_oct + $amount_nov).'</td>
 <td style="font-weight:Bold;border: 1px solid black;">'.number_format($amount_jan + $amount_feb + $amount_march + $amount_april + $amount_may +
 $amount_june + $amount_july + $amount_aug + $amount_sep + $amount_oct + $amount_nov + $amount_dec).'</td>
</tr>';



		}
	$html .= '</table>';
    

		
        
		$obj_pdf->writeHTML($html);  
        ob_end_clean();
		$obj_pdf->Output('revenue_report.pdf', 'I');


	unset($_SESSION['totals']);
	//unset($_SESSION['sav_export']);
		
?>
