<?PHP
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
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Feed', 'Amount'],
                <?php
                    echo "['Deposits', " . $sav_depos. "],";
                    echo "['Withdrawals', " . $sav_withd . "],";
                ?>
            ]);

            var options = {
                title: 'Deposits vs Withdrawals',
                is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('bar'));
            chart.draw(data, options);
        }
    </script>
	 <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Expense', 'Income'],
                <?php
                    echo "['Expense', " . $exp_total. "],";
                    echo "['Income', " . $inc_total . "],";
                ?>
            ]);

            var options = {
                title: 'Expense vs Income',
                is3D: true,
            };

            var chart = new google.visualization.PieChart(document.getElementById('bar__income'));
            chart.draw(data, options);
        }
    </script>
<!-- Income / Expense Ratio -->
<p class="heading_narrow">Income / Expense Ratio</p>
<div id="bar__income">
</div>

<!-- Income / Expense Ratio -->
<p class="heading_narrow">Deposit / Withdraw Ratio</p>

<div id="bar"></div>
<!-- Key -->

</div>
    

