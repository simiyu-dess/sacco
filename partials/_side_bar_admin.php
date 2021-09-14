<div class="offcanvas offcanvas-start w-25" tabindex="-1" id="offcanvas" data-bs-keyboard="false" data-bs-backdrop="false">
    <div class="offcanvas-header">
        <h6 class="offcanvas-title d-none d-sm-block" id="offcanvas">CHENKEN SACCO</h6>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body px-0 dashboard">
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-start" id="menu">
            <li class="nav-item">
                <a href="member_dashboard.php" class="nav-link text-truncate">
                    <i class="fs-5 bi-house"></i><span class="d-sm-inline h5">Dashboard</span>
                </a>
            </li>
           
            <li>
            <a class="nav-link text-truncate" data-bs-toggle="collapse" href="#collapseExample"
             role="button" aria-expanded="false" aria-controls="collapseExample">
             <i class="fs-5 bi-people"></i><span class="ms-1  d-sm-inline h5">Members</span></a>
                 </a>
                <ul data-bs-toggle="collapse" id="collapseExample">
                    <li><a class="nav-link text-truncate" href="cust_act.php">Active Members</a></li>
                    <li><a class="nav-link text-truncate" href="cust_inact.php">Inactive Members</a></li>
                    <li><a class="nav-link text-truncate" href="cust_search.php">Search Member</a></li>
                    <li><a class="nav-link text-truncate" href="cust_new.php">New Member</a></li>


                </ul>
           </li>
           <li>
            <a class="nav-link text-truncate" data-bs-toggle="collapse" href="#collapseLoans"
             role="button" aria-expanded="false" aria-controls="collapseLoans">
             <i class="fs-5 bi-percent"></i><span class="ms-1  d-sm-inline h5">Loans</span></a>
                 </a>
                <ul data-bs-toggle="collapse" id="collapseLoans">
                    <li><a class="nav-link text-truncate" href="loans_act.php">Active Loans</a></li>
                    <li><a class="nav-link text-truncate" href="loans_pend.php">Pending Loans</a></li>
                    <li><a class="nav-link text-truncate" href="loans_search.php">Search Loans</a></li>
                    <li><a class="nav-link text-truncate" href="loans_securities.php">Loan Securities</a></li>


                </ul>
           </li>
           <li>
            <a class="nav-link text-truncate" data-bs-toggle="collapse" href="#collapseAccounting"
             role="button" aria-expanded="false" aria-controls="collapseAccounting">
             <i class="fs-5 bi-calculator"></i><span class="ms-1  d-sm-inline h5">Accounting</span></a>
                 </a>
                <ul data-bs-toggle="collapse" id="collapseAccounting">
                    <li><a class="nav-link text-truncate" href="books_expenses.php">Expenses</a></li>
                    <li><a class="nav-link text-truncate" href="books_income.php">Incomes</a></li>
                    <li><a class="nav-link text-truncate" href="books_annual.php">Annual Accounts</a></li>


                </ul>
           </li>
           <li>
            <a class="nav-link text-truncate" data-bs-toggle="collapse" href="#collapseEmployees"
             role="button" aria-expanded="false" aria-controls="collapseEmployees">
             <i class="fs-5 bi-people"></i><span class="ms-1  d-sm-inline h5">Employees</span></a>
                 </a>
                <ul data-bs-toggle="collapse" id="collapseEmployees">
                    <li><a class="nav-link text-truncate" href="empl_curr.php">Current Employees</a></li>
                    <li><a class="nav-link text-truncate" href="empl_past.php">Former Employees</a></li>
                    <li><a class="nav-link text-truncate" href="empl_new.php">New Employee</a></li>


                </ul>
           </li>
           <li>
            <a class="nav-link text-truncate" data-bs-toggle="collapse" href="#collapseReports"
             role="button" aria-expanded="false" aria-controls="collapseReports">
             <i class="fs-5 bi-line-chart"></i><span class="ms-1  d-sm-inline h5">Reports</span></a>
                 </a>
                <ul data-bs-toggle="collapse" id="collapseReports">
                    <li><a class="nav-link text-truncate" href="rep_expense">Expense</a></li>
                    <li><a class="nav-link text-truncate" href="rep_incomes">Incomes</a></li>
                    <li><a class="nav-link text-truncate" href="rep_revenue">Revenue</a></li>
                    <li><a class="nav-link text-truncate" href="rep_loans">Loans</a></li>


                </ul>
           </li>
           <li>
            <a class="nav-link text-truncate" data-bs-toggle="collapse" href="#collapseSettings"
             role="button" aria-expanded="false" aria-controls="collapseAccounting">
             <i class="fs-5 bi-wrench"></i><span class="ms-1  d-sm-inline h5">Settings</span></a>
                 </a>
                <ul data-bs-toggle="collapse" id="collapseSettings">
                    <li><a class="nav-link text-truncate" href="set_basic.php">Basic Settings</a></li>
                    <li><a class="nav-link text-truncate" href="set_loans.php">Loans Settings</a></li>
                    <li><a class="nav-link text-truncate" href="set_fees.php">Fees Settings</a></li>
                    <li><a class="nav-link text-truncate" href="set_user.php">Users Settins</a></li>
                    <li><a class="nav-link text-truncate" href="set_ugroup.php">Usergroup Settings</a></li>
                    <li><a class="nav-link text-truncate" href="set_logrec.php">Log Records</a></li>
                    <li><a class="nav-link text-truncate" href="set_dbbackup.php">Database backup</a></li>


                </ul>
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