<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require 'TCPDF/tcpdf.php';
ob_start();
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
$obj_pdf->SetFont('helvetica', '', 10);  
$obj_pdf->AddPage();    

$html = '';

$html .= '
<table id ="tb_table" style="
    width:90%;
	border: 1px solid black;">
<colspan>
<col width="15%">
<col width="25%">
<col width="30%">
<col width ="30%">
</colspan>
<tr>
<th colspan="4" style="border: 1px solid black; text-align:center;">Chenken Welfare Association Members</th>
</tr>
<tr>
<th style="font-weight:bold;border: 1px solid black;">Member No.</th>
<th style="font-weight:bold; border: 1px solid black;">Member name</th>
<th style="font-weight:bold;border: 1px solid black;">Email</th>
<th style="font-weight:bold;border: 1px solid black;">Phone</th>

</tr>
';

foreach($_SESSION['members'] as $row_cust) {
    
           $number = $row_cust['number'];
           $name = $row_cust['name'];
           $email = $row_cust['email'];
           $phone = $row_cust['phone'];

   $html .= '
   <tr>
   <td style="border: 1px solid black;">'.$number.'</td>
   <td style="border: 1px solid black;">'.$name.'</td>
   <td style="border: 1px solid black;">'.$email.'</td>
   <td style="border: 1px solid black;">'.$phone.'</td>
   </tr>
   ';

}
$html .= '</table>';


        $obj_pdf->writeHTML($html);  
        ob_end_clean();
		$obj_pdf->Output('Members_report.pdf', 'I');

?>
