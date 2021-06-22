<?php
// Name of crontab file
$crontab = "crontab.php";
// List files to run
//$jobs = array("myfile.php");
require_once("functions.php");
//$db_link = connect();
// Double check that file exists
if (file_exists($crontab)):
	include_once "$crontab";
	if (isset($lastrun)):
		if ($lastrun == "never") $error="true";
		if ($lastrun == date("Y-m-d"))  $error="true";
		if ($lastrun != date("Y-m-d") && $lastrun != "never" && !isset($error)):
		 chargeOverdueLoans();
			//$ran = 0;
			//foreach ($jobs as $job):
				//if (file_exists($job)):
					//include "$job";
					//$ran++;
				//endif;
			//endforeach;
			
			// update crontab file
            
                $CTcontent = "<?php\\\r\\\r";
                                //$CTcontent .= '// Set $lastrun = "never" to stop fakecon from running completely'."\\\r\\\r";
                                $CTcontent .='$lastrun = "'.date("Y-m-d")."\\";"\\\r\\\r?>";
                                if (is_writable($crontab)):
                                    $handle = fopen($crontab, "w");
                                    if (fwrite($handle, $CTcontent) === FALSE):
                                        // echo only while testing
                                        //echo  'Fake Cron error! Could not write to '.$crontab.".\";
                                        //exit;
                                    endif;
                                    fclose($handle);
                                				
                            endif;			
                        endif;
                    endif; 
                endif;
                ?>