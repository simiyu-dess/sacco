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
<col width="15%">
<col width="20%">
<col width="5%">
<col width="5%">
<col width="20%">
<col width="20%">
<col width="10%">
<col width="10%">

</colspan>
<tr>
<th colspan="9" style="font-weight:Bold; border: 1px solid black;text-align:center;">Curent Employess report</th>
</tr>
<tr>
<td style="back-ground:Red; border: 1px solid black;"></td>
</tr>
<tr>
<th style="font-weight:bold; border: 1px solid black;">number</th>
<th style="font-weight:bold; border: 1px solid black;">Name</th>
<th style="font-weight:bold; border: 1px solid black;">Position</th>
<th style="font-weight:bold; border: 1px solid black;">Gender</th>
<th style="font-weight:bold; border: 1px solid black;">adress</th>
<th style="font-weight:bold; border: 1px solid black;">phone</th>
<th style="font-weight:bold; border: 1px solid black;">Email</th>
<th style="font-weight:bold; border: 1px solid black;"> In</th>
<th style="font-weight:bold; border: 1px solid black;"> Out</th>
</tr>
';

foreach($_SESSION['emp_past'] as $row_emp) {
    $number = $row_emp['number'];
    $name = $row_emp['name'];
    $postion = $row_emp['position'];
    $sex = $row_emp['sex'];
    $Dob = $row_emp['date'];
    $address= $row_emp['address'];
    $date_in = $row_emp['date_in'];
    $phone = $row_emp['phone'];
    $email = $row_emp['email'];
    $date_out = $row_emp['date_out'];


   $html .= '
   <tr>
   <td style="border: 1px solid black;">'.$number.'</td>
   <td style="border: 1px solid black;">'.$name.'</td>
   <td style="border: 1px solid black;">'.$postion.'</td>
   <td style="border: 1px solid black;">'.$sex.'</td>
   <td style="border: 1px solid black;">'.$address.'</td>
   <td style="border: 1px solid black;">'.$phone.'</td>
   <td style="border: 1px solid black;">'.$email.'</td>
   <td style="border: 1px solid black;">'.$date_in.'</td>
   <td style="border: 1px solid black;">'.$date_out.'</td>

   </tr>
   ';

}
$html .='</table>';


        $obj_pdf->writeHTML($html);  
        ob_end_clean();
		$obj_pdf->Output('Employee_report.pdf', 'I');

?>
