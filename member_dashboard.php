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
<body>
<div class="offcanvas offcanvas-start w-25" tabindex="-1" id="offcanvas" data-bs-keyboard="false" data-bs-backdrop="false">
    <div class="offcanvas-header">
        <h6 class="offcanvas-title d-none d-sm-block" id="offcanvas">CHENKEN SACCO</h6>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body px-0">
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-start" id="menu">
            <li class="nav-item">
                <a href="#" class="nav-link text-truncate">
                    <i class="fs-5 bi-house"></i><span class="ms-1 d-none d-sm-inline">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#submenu1" data-bs-toggle="collapse" class="nav-link text-truncate">
                    <i class="fa fa-home"></i><span class="ms-1 d-none d-sm-inline">Dashboard</span> </a>
            </li>
            <li>
                <a href="#" class="nav-link text-truncate">
                    <i class="fs-5 bi-table"></i><span class="ms-1 d-none d-sm-inline">Orders</span></a>
            </li>
            <li class="dropdown">
                <a href="#" class="nav-link dropdown-toggle  text-truncate" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fs-5 bi-bootstrap"></i><span class="ms-1 d-none d-sm-inline">Bootstrap</span>
                </a>
                <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdown">
                    <li><a class="dropdown-item" href="#">New project...</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Sign out</a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="nav-link text-truncate">
                    <i class="fs-5 bi-grid"></i><span class="ms-1 d-none d-sm-inline">Products</span></a>
            </li>
            <li>
                <a href="#" class="nav-link text-truncate">
                    <i class="fs-5 bi-people"></i><span class="ms-1 d-none d-sm-inline">Customers</span> </a>
            </li>
        </ul>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col min-vh-100 p-4">
            <!-- 
            <button class="btn float-end" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" role="button">
                <i class="bi bi-arrow-right-square-fill" data-bs-toggle="offcanvas" data-bs-target="#offcanvas"></i>
            </button>
            toggler 
            <button class="btn btn-primary m-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" 
            aria-controls="offcanvas">Toggle bottom offcanvas</button>
            
            <button class="navbar-toggler" type="button" aria-controls="offcanvas"
             data-bs-toggle="offcanvas"  data-bs-target="#offcanvas">
             <i class="fa fa-bars"></i>
        </button>
        -->
     
    <div class="containered">
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

                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <p class="card-header">Total withdrawals(kshs)</p>
                            <!-- <span class="font-bold text-title">578</span> -->
                            <span class="font-bold text-title">
                                <?php
                                    echo number_format($sav_withd);
                                ?>
                            </span>
                        </div>
                    </div>
                    

                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <p class="card-header">No. Of loans Issued</p>
                            <!-- <span class="font-bold text-title">578</span> -->
                            <span class="font-bold text-title text-body">
                                <?php
                                    echo number_format($number_loans);
                                ?>
                            </span>
                        </div>
                    </div>

                    <div class="card text-white bg-danger mb-3">
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

</div>
</div>  
 </div>
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