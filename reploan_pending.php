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
<table id ="tb_table" style="width:95%;border: 1px solid black;">
<colspan>
<col width="5%">
<col width="25%">
<col width="20%">
<col width="5%">
<col width="5%">
<col width="20%">
<col width="20%">
</colspan>
<tr>
<th colspan="7" style="font-weight:Bold; border: 1px solid black;text-align:center;">Pending loans report</th>
</tr>
<tr>
<td style="back-ground:Red; border: 1px solid black;"></td>
</tr>
<tr>
<th style="font-weight:bold; border: 1px solid black;">L.No</th>
<th style="font-weight:bold; border: 1px solid black;">Issued.To</th>
<th style="font-weight:bold; border: 1px solid black;">Status</th>
<th style="font-weight:bold; border: 1px solid black;">L.period</th>
<th style="font-weight:bold; border: 1px solid black;">P.applied</th>
<th style="font-weight:bold; border: 1px solid black;">Interest</th>
<th style="font-weight:bold; border: 1px solid black;">Date.Applied</th>

</tr>
';

foreach($_SESSION['pending_loans'] as $row_loan) {
    $number = $row_loan['number'];
    $name = $row_loan['name'];
    $status= $row_loan['status'];
    $period = $row_loan['period'];
    $principal = $row_loan['principal'];
    $interest = $row_loan['repay'];
    $date= $row_loan['date'];
    


   $html .= '
   <tr>
   <td style="border: 1px solid black;">'.$number.'</td>
   <td style="border: 1px solid black;">'.$name.'</td>
   <td style="border: 1px solid black;">'.$status.'</td>
   <td style="border: 1px solid black;">'.$period.'</td>
   <td style="border: 1px solid black;">'.$principal.'</td>
   <td style="border: 1px solid black;">'.$interest.'</td>
   <td style="border: 1px solid black;">'.$date.'</td>
   </tr>
   ';

}
$html .='</table>';


        $obj_pdf->writeHTML($html);  
        ob_end_clean();
		$obj_pdf->Output('Employee_report.pdf', 'I');

?>
