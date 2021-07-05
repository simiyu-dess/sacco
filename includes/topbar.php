<?php
function includesMenu($tab_no){
		echo '
		<!-- MENU HEADER -->
		<div id="menu_header">
			<img src="" alt="CHENKEN WELFARE ASSOCIATION" style="margin: 1em 0 0 .75em;"/>
			<div id="menu_logout">
				<ul>
					<li>'.$_SESSION['log_user'].'
						<ul>
							<li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>';

		echo '
		<!-- MENU TABS -->
		<div id="menu_tabs">
			<ul>
				<li';
				if ($tab_no == 1) echo ' id="tab_selected"';
				echo '><a href="start.php"><i class="fa fa-tachometer fa-fw"></i> Dashboard</a></li>
				<li';
				if ($tab_no == 2) echo ' id="tab_selected"';
				echo '><a href="cust_search.php"><i class="fa fa-group fa-fw"></i> Members</a></li>
				<li';
				if ($tab_no == 3) echo ' id="tab_selected"';
				echo '><a href="loans_search.php"><i class="fa fa-percent fa-fw"></i> Loans</a></li>';
				 if ($_SESSION['log_admin'] == 1){
				echo '<li';
				if ($tab_no == 4) echo ' id="tab_selected"';
				echo '><a href="books_expense.php"><i class="fa fa-calculator fa-fw"></i> Accounting</a></li>';
				 }
				 if ($_SESSION['log_admin'] == 1){
				echo '<li';
				if ($tab_no == 7) echo ' id="tab_selected"';
				echo '><a href="empl_curr.php"><i class="fa fa-male fa-fw"></i> Employees</a></li>';
				 }
				if ($_SESSION['log_report'] == 1){
					echo '<li';
					if ($tab_no == 5) echo ' id="tab_selected"';
					echo '><a href="rep_incomes.php"><i class="fa fa-line-chart fa-fw"></i> Reports</a></li>';
				}

				if ($_SESSION['log_admin'] == 1){
					echo '<li';
					if ($tab_no == 6) echo ' id="tab_selected"';
					echo '><a href="set_basic.php"><i class="fa fa-wrench fa-fw"></i> Settings</a></li>';
				}
			echo '</ul>
		</div>';
    }
    ?>