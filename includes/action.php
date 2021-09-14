<?PHP
include __DIR__ . "/../functions.php";
checkLogin();
$db_link = connect();
$sixtydays = time() - convertDays(2555);

// Getting expenses
$sql_exp = "SELECT exp_amount FROM expenses";
$query_exp = mysqli_query($db_link, $sql_exp);
checkSQL($db_link, $query_exp);
$exp_total = 0;
while($row_exp = mysqli_fetch_assoc($query_exp)){
	$exp_total = $exp_total + $row_exp['exp_amount'];
}

// Getting income
$sql_inc = "SELECT inc_amount FROM incomes";
$query_inc = mysqli_query($db_link, $sql_inc);
checkSQL($db_link, $query_inc);
$inc_total = 0;
while($row_inc = mysqli_fetch_assoc($query_inc)){
	$inc_total = $inc_total + $row_inc['inc_amount'];
}

// Convert to percent
$inc_percent = $inc_total === 0 ? 0 : $inc_total/($inc_total+$exp_total)*100;
$exp_percent = $exp_total === 0 ? 0 : $exp_total/($inc_total+$exp_total)*100;

// Getting savings
$sql_sav = "SELECT sav_amount FROM savings";
$query_sav = mysqli_query($db_link, $sql_sav);
checkSQL($db_link, $query_sav);
$sav_depos = 0;
$sav_withd = 0;
while($row_sav = mysqli_fetch_assoc($query_sav)){
	if($row_sav['sav_amount'] > 0) $sav_depos = $sav_depos + $row_sav['sav_amount'];
	elseif($row_sav['sav_amount'] < 0) $sav_withd = $sav_withd + ($row_sav['sav_amount'] * -1);
}

// Convert to percent
$sav_depos_percent = $sav_depos === 0 ? 0 : $sav_depos/($sav_depos+$sav_withd)*100;
$sav_withd_percent = $sav_withd=== 0 ? 0 : $sav_withd/($sav_depos+$sav_withd)*100;


//getting the total number of loans Issued 
$sql_Loans = "SELECT COUNT(*) AS loan_rows FROM loans";
$query_loans = mysqli_query($db_link, $sql_Loans);
checkSQL($db_link, $query_loans);

while($row = mysqli_fetch_assoc($query_loans))
{
 $number_loans = $row['loan_rows'];
}

//getting the total number of the active employees

$sql_members = "SELECT COUNT(*) AS members FROM customer";
$query_members = mysqli_query($db_link, $sql_members);
checkSQL($db_link, $sql_members);

while($row = mysqli_fetch_assoc($query_members))
{
	$number_of_members = $row['members'];
}

//getting the total number of the issued loans
$sql_issuedLoans = "SELECT COUNT(*) AS issued_loans FROM loans WHERE loanstatus_id = 2";
$query_issuedLoans = mysqli_query($db_link, $sql_issuedLoans);
checkSQL($db_link, $query_issuedLoans);

while($row = mysqli_fetch_assoc($query_issuedLoans))
{
	$number_of_IssuedLoans = $row['issued_loans'];
}

//getting the sum of amount in terms of the issued Loans
$sql_sumIssued = "SELECT SUM(loan_principalapproved) AS sum_Issued FROM loans WHERE loanstatus_id = 2";
$query_sumIssued = mysqli_query($db_link, $sql_sumIssued);
checkSQL($db_link, $query_sumIssued);

while($row = mysqli_fetch_assoc($query_sumIssued))
{
	$sum_Issued = $row['sum_Issued'];
}

//getting the total number of the pending of loans
$sql_pendingLoans = "SELECT COUNT(*) AS pending_Loans FROM loans WHERE loanstatus_id = 1";
$query_pendingLoans = mysqli_query($db_link, $sql_pendingLoans);
checkSQL($db_link, $query_pendingLoans);

while($row = mysqli_fetch_assoc($query_pendingLoans))
{
	$number_of_pendingLoans = $row['pending_Loans'];
}

//getting the sum of amount in the pending loans
$sql_sumPending = "SELECT SUM(loan_principal) AS sum_Pending FROM loans WHERE loanstatus_id = 1";
$query_sumPending = mysqli_query($db_link, $sql_sumPending);
checkSQL($db_link, $query_sumPending);

while($row = mysqli_fetch_assoc($query_sumPending))
{
	$sum_Pending =  $row['sum_Pending'];
}

//getting the total number of the cleared loans

$sql_clearedLoans = "SELECT COUNT(*) AS cleared_Loans FROM loans WHERE loanstatus_id = 5";
$query_clearedLoans = mysqli_query($db_link, $sql_clearedLoans);
checkSQL($db_link, $query_clearedLoans);

while($row = mysqli_fetch_assoc($query_clearedLoans))
{
	$number_of_clearedLoans = $row['cleared_Loans'];
}

//getting the accrued interest from the cleared loans
$sql_acruedInterest = "SELECT loan_amount_paid,loan_principalapproved
                          FROM loans WHERE loanstatus_id = 5";

$query_acruedInterest = mysqli_query($db_link, $sql_acruedInterest);
checkSQL($db_link, $query_acruedInterest);
$interest  = 0;
while($row = mysqli_fetch_assoc($query_acruedInterest))
{
	$interest += ($row['loan_amount_paid'] - $row['loan_pricipalapproved']);
}



?>