<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require 'TCPDF/tcpdf.php';
ob_start();
$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
$obj_pdf->SetCreator(PDF_CREATOR);  
$obj_pdf->SetTitle("Export active loans");  
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
<col width="20%">
<col width="20%">
<col width="5%">
<col width="5%">
<col width="15%">
<col width="15%">
<col width="15%">
</colspan>
<tr>
<th colspan="8" style="font-weight:Bold; border: 1px solid black;text-align:center;">loan repayment transactions '.$_SESSION['l_cust'].'</th>
</tr>
<tr>
<td style="back-ground:Red; border: 1px solid black;"></td>
</tr>
<tr>
<th style="font-weight:bold; border: 1px solid black;">Due</th>
<th style="font-weight:bold; border: 1px solid black;">D.paid</th>
<th style="font-weight:bold; border: 1px solid black;">P.due</th>
<th style="font-weight:bold; border: 1px solid black;">P.paid</th>
<th style="font-weight:bold; border: 1px solid black;">I.due</th>
<th style="font-weight:bold; border: 1px solid black;">I.paid</th>
<th style="font-weight:bold; border: 1px solid black;">Receipt</th>
<th style="font-weight:bold; border: 1px solid black;">Fined</th>

</tr>
';
array_push($_SESSION['ltrans_export'],
array(
"Date due" => date("d.m.Y",$row_duedates['ltrans_due']), 
"Date paid" => date("d.m.Y",$row_duedates['ltrans_date']), 
"Principial due" => $row_duedates['ltrans_principaldue'], 
"Principal paid" => $row_duedates['ltrans_principal'], 
"Interest due" => $row_duedates['ltrans_interestdue'], 
"Interest paid" => $row_duedates['ltrans_interest'], 
"Receipt" => $row_duedates['ltrans_receipt'], 
"Fined" => $exp_fined));

foreach($_SESSION['ltrans_export'] as $row_loan) {
    $due_date = $row_loan['Date due'];
    $date = $row_loan['Date paid'];
    $p_due = $row_loan['Principal due'];
    $p_paid = $row_loan['Principal paid'];
    $I_due = $row_loan['Interest due'];
    $I_paid = $row_loan['Interest paid'];
    $Receipt = $row_loan['Receipt'];
    $Fined = $row_loan['Fined'];
    


   $html .= '
   <tr>
   <td style="border: 1px solid black;">'.$due_date.'</td>
   <td style="border: 1px solid black;">'.$date.'</td>
   <td style="border: 1px solid black;">'.$p_due.'</td>
   <td style="border: 1px solid black;">'.$p_paid.'</td>
   <td style="border: 1px solid black;">'.$I_due.'</td>
   <td style="border: 1px solid black;">'.$I_paid.'</td>
   <td style="border: 1px solid black;">'.$Receipt.'</td>
   <td style="border: 1px solid black;">'.$Fined.'</td>
   </tr>
   ';

}
$html .='</table>';


        $obj_pdf->writeHTML($html);  
        ob_end_clean();
		$obj_pdf->Output('loan_repayment.pdf', 'I');

?>
