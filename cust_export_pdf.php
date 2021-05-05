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
$obj_pdf->SetFont('helvetica', '', 16);  
$obj_pdf->AddPage();    

$html = '';

$html .= '
<table id ="tb_table" style="
    width:90%;
	margin:auto;
	margin-bottom:3em;">
<colspan>
<col width="15%">
<col width="25%">
<col width="50%">
</colspan>
<tr>
<th colspan="3">Chenken Welfare Association Members</th>
</tr>
<tr>
<th style="font-weight:bold">Member No.</th>
<th style="font-weight:bold">Member name</th>
<th style="font-weight:bold">Email</th>
</tr>
';

foreach($_SESSION['members'] as $row_cust) {
    
           $number = $row_cust['number'];
           $name = $row_cust['name'];
           $email = $row_cust['email'];

   $html .= '
   <tr>
   <td>'.$number.'</td>
   <td>'.$name.'</td>
   <td>'.$email.'</td>
   </tr>
   <tr>
   <td colspan="3">----------------------------------------------------------------------------</td>
   </tr>
   ';

}


        $obj_pdf->writeHTML($html);  
        ob_end_clean();
		$obj_pdf->Output('Members_report.pdf', 'I');

?>
