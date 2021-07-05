<?php
include('header.php');
function includeuser(){
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
}
?>