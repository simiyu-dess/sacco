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
<table id ="tb_table" style="width:75%">
<colspan>
<col width="30%">
<col width="30%">
<col width="30%">
</colspan>
<tr>
<th colspan="3" style="font-weight:Bold">'.$_SESSION['name'].'    Savings  report</th>
</tr>
<tr>
<td style="background:Red">total balance '.$_SESSION['sav_bal'].'</td>
</tr>
<tr>
<th style="font-weight:bold">Savings</th>
<th style="font-weight:bold">Amount</th>
<th style="font-weight:bold">Transaction</th>
</tr>
';

foreach($_SESSION['user_account'] as $row_sav) {
    //$date ='';
    //$Amount=0;
   /// $type='';
   // if($key=='date'){
   // $date = $value;
   // }
   // if($key=='amount'){
       // $Amount = $value;
       // }
    //if($key=='type'){
           // $type= $value;
           // }
           $date = $row_sav['date'];
           $type = $row_sav['type'];
           $Amount = $row_sav['amount'];
   $html .= '
   <tr>
   <td>'.$date.'</td>
   <td>'.$type.'</td>
   <td>'.$Amount.'</td>
   </tr>
   ';

}


        $obj_pdf->writeHTML($html);  
        ob_end_clean();
		$obj_pdf->Output('Account_report.pdf', 'I');

?>