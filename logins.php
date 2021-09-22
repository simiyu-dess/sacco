<?php 
require 'functions.php';
//session start
session_start();
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

   if  ($_SESSION['log_user'] != null || $_SESSION['member_id'] != null)
   {
    showMessage('Multiple logins on the same browser is not allowed, \n please use another browser or logout the other user ');
   
	return "logout_success.php";
   }
else
{
	$fingerprint = fingerprint();
	$db_link = connect();
 
	if(isset($_POST['login'])){

		// Include passwort pepper
		//require 'config/pepper.php';

		// Sanitize user input
		$log_user = sanitize($db_link, $_POST['username']);
		$log_pw = sanitize($db_link, $_POST['password']);

		// Select user details from USER
		$sql_log = "SELECT * FROM user, ugroup WHERE user.ugroup_id = ugroup.ugroup_id AND user_name = '$log_user'";
		$query_log = mysqli_query($db_link, $sql_log);
		checkSQL($db_link, $query_log);
		$result_log = mysqli_fetch_assoc($query_log);
		$pepper = 'g7NIiru!!8';
        //'g7NIiru!!8'
		// Verify Password
		if(password_verify($log_pw.$pepper, $result_log['user_pw'])){
			


			// Define Session Variables for this User
			$_SESSION['log_user'] = $log_user;
			$_SESSION['log_time'] = time();
			$_SESSION['log_id'] = $result_log['user_id'];
			$_SESSION['log_ugroup'] = $result_log['ugroup_name'];
			$_SESSION['log_admin'] = $result_log['ugroup_admin'];
			$_SESSION['log_delete'] = $result_log['ugroup_delete'];
			$_SESSION['log_report'] = $result_log['ugroup_report'];
			$_SESSION['log_fingerprint'] = $fingerprint;

		  
			if($result_log['ugroup_name'] == "members" )
			{
           
				$_SESSION['member_id'] = $result_log['member_id'];
			}
		

			// Check if user logged out properly last time
			$sql_logout = "SELECT logrec_id, logrec_logout FROM logrec WHERE logrec_id IN 
			(SELECT MAX(logrec_id) FROM logrec WHERE user_id = '$_SESSION[log_id]')";
			$query_logout = mysqli_query($db_link, $sql_logout);
			checkSQL($db_link, $query_logout);
			$logout = mysqli_fetch_array($query_logout);
			$_SESSION['logrec_logout'] = $logout[1];

			// Close all open sessions for that user
			$sql_close_logrec = "UPDATE logrec SET logrec_end = '$_SESSION[log_time]' WHERE user_id = '$_SESSION[log_id]' AND logrec_end IS NULL";
			$query_close_logrec = mysqli_query($db_link, $sql_close_logrec);
			checkSQL($db_link, $query_close_logrec);

			// Record Login in LOGREC
			$sql_logrec = "INSERT INTO logrec (user_id, logrec_start, logrec_logout) VALUES ('$_SESSION[log_id]', '$_SESSION[log_time]', '0')";
			$query_logrec = mysqli_query($db_link, $sql_logrec);
			checkSQL($db_link, $query_logrec);

			// Find LOGREC_ID for current user
			$sql_logrecid = "SELECT MAX(logrec_id) FROM logrec WHERE user_id = '$_SESSION[log_id]'";
			$query_logrecid = mysqli_query($db_link, $sql_logrecid);
			checkSQL($db_link, $db_link, $query_logrecid);
			$logrecid = mysqli_fetch_array($query_logrecid);
			$_SESSION['logrec_id'] = $logrecid['MAX(logrec_id)'];

			// Forward to start.php
			
            
			header('Location: start.php');
			
			}
		else 
		{
			$error = "Invalid data";
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login ChenKen</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="Login/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login/css/main.css">
	<link rel="stylesheet" type="text/css" href="Login/css/util.css">
<!--===============================================================================================-->
</head>
<body>
	
	
	<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
		<div class="wrap-login100 p-l-55 p-r-55 p-t-80 p-b-30">
		<div class="my-div-error">
		<?php echo $error; ?>
		</div>
			<form class="login100-form validate-form" method="POST">
				<span class="login100-form-title p-b-37">
					Sign In
				</span>

				<div class="wrap-input100 validate-input m-b-20" data-validate="Enter username or email">
					<input class="input100" type="text" name="username" placeholder="username">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input m-b-25" data-validate = "Enter password">
					<input class="input100" type="password" name="password" placeholder="password">
					<span class="focus-input100"></span>
				</div>
                <div class="my-div-error"></div>
				<div class="container-login100-form-btn">
					<button class="login100-form-btn" name="login">
						Sign In
					</button>
				</div>

				<div class="text-center p-t-57 p-b-20">
					<span class="txt1">
						Dont have account?
					</span>
				</div>

				<div class="text-center">
					<a href="registers.php" class="txt2 hov1">
						Sign Up
					</a>
				</div>
			</form>

			
		</div>
	</div>
	
	<script>
    function validate()
    {
       //getting the form values    
        var username = document.getElementById("username").value;
        var memberId = document.getElementById("memberId").value;
        var password = document.getElementById("password").value;
        var confPassword = document.getElementById("conf_password");
        var usernames = <?php echo json_encode($usernames); ?>;
        var j_username = username;

        //getting the error divs

        var errorUsername = document.getElementById("errorUsername");
        var errorMemberId = document.getElementById("errorMemberId");
        var errorPassword = document.getElementById("errorPassword");
        var errorConfPassword = document.getElementById("errorConfPassword");

        thruth = false;
        
         for(i =0; i < usernames.length; i++)
         {
             if($usernames[i] == j_username)
             {
                 errorUsername.innerHTML = "The username is already taken";
                 thruth = false;
             }
         }

        if(username == "")
        {
            errorUsername.innerHTML = "Please enter a name";
            thruth = false;
        }


        if(password.length < 6)
        {
            errorPassword = "Password must be atleast six characters long";
            thruth = false;
        }

        if(password != confPassword)
        {
            errorConfPassword.innerHTML = "Password does not match";
            truth = false;
        }



        return thruth;

    }
    
    </script>


	
<!--===============================================================================================-->
	<script src="Login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="Login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="Login/js/main.js"></script>

</body>
</html>