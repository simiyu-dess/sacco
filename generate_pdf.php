<?PHP
session_start();
require 'TCPDF/tcpdf.php';
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
$obj_pdf->SetFont('helvetica', '', 8);  
$obj_pdf->AddPage();            
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

        
		 $data = array(

			array("name" => "dennis",
			"email" => "sims",
			"amount" => array (
				"May"=> 2000,
				"June"=> 2000,
				"July"=> 6000,
				"August"=> 2000,
				"September"=> 2000,
				"October"=> 7000,
				"November"=> 2000,
				"December"=> 9000,
			
			),
			)
			,
			array("name" => "dennis",
			"email" => "sims",
			"amount" => array (
				"May"=> 3000,
				"June"=> 2000,
				"July"=> 2000,
				"August"=> 2000,
				"September"=> 2000,
				"October"=> 2000,
				"November"=> 2000,
				"December"=> 2000,
			
			),
			),
		array("name" => "dennis",
			"email" => "sims",
			"amount" => array (
				"May"=> 2000,
				"June"=> 2000,
				"July"=> 6000,
				"August"=> 2000,
				"September"=> 2000,
				"October"=> 7000,
				"November"=> 2000,
				"December"=> 9000,
			
			),
		)
		 );

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
		</tr>';
			}
    

		
        
		$obj_pdf->writeHTML($html);  
        ob_end_clean();
		$obj_pdf->Output('revenue_report.pdf', 'I');
		
?>
