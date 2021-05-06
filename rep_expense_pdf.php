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
<table style="border: 1px solid black;">
<colspan>
<col width="15%">
<col width="10%">
<col width="45%">
<col width="30%">
</colspan>
<tr>
<th colspan="5" style="font-weight:Bold;border: 1px solid black;text-align:center;">Expense report</th>
</tr>
<tr>
<th style="font-weight:bold; border: 1px solid black;">Date</th>
<th style="font-weight:bold; border: 1px solid black;">Type</th>
<th style="font-weight:bold; border: 1px solid black;">Recipient</th>
<th style="font-weight:bold; border: 1px solid black;">Amount</th>
<th style="font-weight:bold; border: 1px solid black;">Receipt</th>
</tr>
';

foreach($_SESSION['expenses'] as $row_expense) {
           $date = $row_expense['date'];
           $type = $row_expense['type'];
           $recipient = $row_expense['recipient'];
           $amount = $row_expense['amount'];
           $receipt = $row_expense['receipt'];
   $html .= '
   <tr>
   <td style="border: 1px solid black;">'.$date.'</td>
   <td style="border: 1px solid black;">'.$type.'</td>
   <td style="border: 1px solid black;">'.$recipient.'</td>
   <td style="border: 1px solid black;">'.$amount.'</td>
   <td style="border: 1px solid black;">'.$receipt.'</td>
   </tr>
   ';

}
$html .= '<tr>
<td colspan="5">Total expenses: '.number_format($_SESSION['total_exp']).'</td>
</tr>';
$html .='</table>';


        $obj_pdf->writeHTML($html);  
        ob_end_clean();
		$obj_pdf->Output('Account_report.pdf', 'I');

?>
