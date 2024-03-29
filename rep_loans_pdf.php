<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require 'TCPDF/tcpdf.php';
ob_start();
$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
$obj_pdf->SetCreator(PDF_CREATOR);  
$obj_pdf->SetTitle("Export loans report");  
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
<table id ="tb_table" style="width:75%">
<colspan>
<col width="25%">
<col width="25%">
<col width="25%">
<col width="25%">
</colspan>
<tr>
<th colspan="3" style="font-weight:Bold; text-align:center;">Loans report</th>
</tr>
<tr>
<td style="background:Red"></td>
</tr>
<tr>
<th style="font-weight:bold">Loan no</th>
<th style="font-weight:bold">Loan status</th>
<th style="font-weight:bold">Due date</th>
<th style="font-weight:bold">Due amount</th>
</tr>
';

foreach($_SESSION['loan_due'] as $row_loan) {
           $number = $row_loan['loan_no'];
           $status = $row_loan['status'];
           $date = $row_loan['date'];
           $amount = $row_loan['amount'];
   $html .= '
   <tr>
   <td>'.$number.'</td>
   <td>'.$status.'</td>
   <td>'.$date.'</td>
   <td>'.$amount.'</td>
   </tr>
   ';

}


        $obj_pdf->writeHTML($html);  
        ob_end_clean();
		$obj_pdf->Output('loans.pdf', 'I');

?>
