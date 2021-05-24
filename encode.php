<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$custNo = '28/2021';
$timestamp = time();
//$member_id =intval((base64_encode($custNo) * 2014)/2021);
//print($member_id);
print(intval($custNo)*$timestamp);