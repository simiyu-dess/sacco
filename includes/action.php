<?PHP
include "{$_SERVER['DOCUMENT_ROOT']}/sacco/functions.php";
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
$sql_sav = "SELECT sav_amount FROM savings WHERE sav_date > $sixtydays";
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
?>