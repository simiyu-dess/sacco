<?php
/**
	* Generate HTML Header Section
	* @param string title : Page title
	* @param int endFlag : Flag to indicate whether or not to end header section.
	*/
	function includesHead($title, $endFlag = 1) {
		echo '<head>
			<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
			<meta http-equiv="Content-Script-Type" content="text/javascript">
			<meta http-equiv="Content-Style-Type" content="text/css">
			<meta name="robots" content="noindex, nofollow">
			<title>ChenKen | '.$title.'</title>
			<link rel="shortcut icon" href="" type="image/x-icon">
			<link rel="stylesheet" href="css/mangoo.css"  />
			<link rel="stylesheet" href="ico/font-awesome/css/font-awesome.min.css">
			<link rel="stylesheet" href="jquery/jquery-ui-1.11.4/jquery-ui.min.css">
			<script src="jquery/jquery-2.2.1.min.js"></script>
			<script src="jquery/jquery-ui-1.11.4/jquery-ui.min.js"></script>
			<script>
				$(function() {
					$("#datepicker, #datepicker2, #datepicker3").datepicker({
						showOtherMonths: true,
						selectOtherMonths: true,
						dateFormat: \'dd.mm.yy\',
						changeMonth: true,
						changeYear: true
					});
				});
			</script>
			';
		if ($endFlag == 1) echo '</head>';
	}

?>