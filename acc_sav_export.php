 <?PHP
 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);
 session_start();
	 
  // File name for download
  $filename = $_SESSION['sav_exp_title'].'.pdf';

  header("Content-Disposition: attachment; filename=$filename");
  header("Content-Type: application/x-download");
  header("Content-Type: application/vnd.fpdf");

  $firstRow = true;
  $output = '';
	
 foreach($_SESSION['sav_export'] as $row_sav) {
		// Display array keys as first row
		if($firstRow) {
     echo implode("\t", array_keys($row_sav)) . "\n";
      $firstRow = FALSE;
    }    
    echo implode("\t", array_values($row_sav)) . "\n";
  }

	unset($_SESSION['sav_exp_title']);
	unset($_SESSION['sav_export']);
  exit;
?>