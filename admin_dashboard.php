<?php
 session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "includes/action.php";



    
?>
<!DOCTYPE html>
<html lang="en">
<!-- head -->
<?php include "partials/_head.php";?>
<body id="body">
    <div class="container">
        <!-- top navbar -->
        <?php include "partials/_top_bar_dashboard.php";?>
        <main>
            <div class="main__container">
                <!-- dashboard title and greetings -->
                <div class="main__title">
                    <!-- <img src="images/hello.svg" alt=""> -->
                    <div class="main__greeting">
                        <h1>Hello<?php echo ', ' . $_SESSION["log_user"] . '.';?></h1>
                        <p>Welcome to your dashboard</p>
                    </div>
                </div>
                <!-- dashboard title ends here -->

                <!-- Cards for displaying CRUD insights -->
                <div class="main__cards">
                    <div class="card">
                        <div class="card_inner">
                            <p class="text-primary-p">Total deposits(Kshs)</p>
                            <!-- <span class="font-bold text-title">578</span> -->
                            <span class="font-bold text-title">
                                <?php
                                    echo number_format($sav_depos);
                                ?>
                            </span>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card_inner">
                            <p class="text-primary-p">Total withdrawals(kshs)</p>
                            <!-- <span class="font-bold text-title">578</span> -->
                            <span class="font-bold text-title">
                                <?php
                                    echo number_format($sav_withd);
                                ?>
                            </span>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card_inner">
                            <p class="text-primary-p">No. Of loans Issued</p>
                            <!-- <span class="font-bold text-title">578</span> -->
                            <span class="font-bold text-title">
                                <?php
                                    echo number_format($number_loans);
                                ?>
                            </span>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card_inner">
                            <p class="text-primary-p">No. Of Members</p>
                            <!-- <span class="font-bold text-title">578</span> -->
                            <span class="font-bold text-title">
                                <?php
                                    echo number_format($number_of_members);
                                ?>
                            </span>
                        </div>
                    </div>
                </div>
                <!-- End of cards for displaying CRUD insights -->
                <!-- Start of charts for displaying CRUD insights -->
                <div class="charts">
                    <div class="charts__left">
                        <div class="charts__left__title">
                            <div>
                                <h1>Finance Visualization</h1>
                                <p>Income received and expenses</p>
                            </div>
                            <i class="fa fa-money" aria-hidden="true"></i>
                        </div>
                        <div id="piechart_3d" style="width: 95%; height: 95%;"></div>
                    </div>
                   
                    <div class="charts__right">
                        <div class="charts__right__title">
                            <div>
                                <h1>Stats</h1>
                                <p>Loan Statics</p>
                            </div>
                            <i class="fa fa-money" aria-hidden="true"></i>
                        </div>

                        <div class="charts__right__cards">
                            <div class="card4">
                            <h1>Pending Loans</h1>
                            <p><?php echo number_format($number_of_pendingLoans); ?></p>
                        </div>
                        <div class="card4">
                            <h1>Amount Pending</h1>
                            <p><?php echo number_format($sum_Pending); ?></p>
                        </div>

                        <div class="card2">
                            <h1>Issued Loans</h1>
                            <p><?php echo number_format($number_of_IssuedLoans); ?></p>
                        </div>

                        <div class="card2">
                            <h1>Amount Issued</h1>
                            <p><?php echo number_format($sum_Issued); ?></p>
                        </div>

                        <div class="card3">
                            <h1>Cleared Loans</h1>
                            <?php
                          echo   number_format($number_of_clearedLoans);
                                ?>
                        </div>

                        <div class="card3">
                            <h1>Acrued Collected</h1>
                            <?php
                               echo number_format($interest);
                                ?>
                        </div>
                    </div>
                </div>
                <!-- End of charts for displaying CRUD insights -->
            </div>
        </main>
        <!-- sidebar nav -->
        <?php include "partials/_side_bar.php";?>
    </div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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

            var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
            chart.draw(data, options);
        }
    </script>
   
</body>
</html>