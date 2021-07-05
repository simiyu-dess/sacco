<?PHP
require 'functions.php';
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	$fingerprint = fingerprint();
    $db_link = connect();
    $users_id = 0;
    
    $pepper = 'g7NIiru!!8';
    //get usernames from the database

    if(isset($_POST['member_register']))
    {
    $member_id = sanitize($db_link, $_POST['member_id']);
    $user_name = sanitize($db_link, $_POST['username']);
    $password = password_hash(sanitize($db_link, $_POST['password']).$pepper, PASSWORD_DEFAULT);
    

   
    $sql_select_user = "SELECT cust_no, cust_id FROM customer WHERE customer.cust_id > 0";
    $query_user = mysqli_query($db_link,$sql_select_user);
    checkSQL($db_link, $query_user);
   
   $user = [];
   $cust_id;
    while($user_id = mysqli_fetch_assoc($query_user))
    {
        if($user_id['cust_no'] == strval($member_id)) 
        {
         $user[] = $user_id['cust_no'];
         $cust_id = $user_id['cust_id'];

        }
   
    }

    $time_stamp=time();
   // $member_user = array();
   if(!empty($user))
   {
        $member=[];
        $sql_select_user_names = "SELECT member_id FROM user WHERE user.user_id > 0";
        $query_existing_member = mysqli_query($db_link, $sql_select_user_names);
        checkSQL($db_link, $query_existing_member);

        while($member_user = mysqli_fetch_assoc($query_existing_member))
        {
         if($member_user['member_id'] == strval($member_id)) $member[] = $member_user['member_id'];
        }

        if(empty($member))
        {
            $names = 0;
            $sql_select_username = "SELECT user_name from user WHERE user_id > 0";
            $query_username = mysqli_query($db_link, $sql_select_username);
            checkSQL($db_link, $query_username);
            
            while($get_user = mysqli_fetch_assoc($query_username))
            {
                if($get_user['user_name'] == $user_name) $names+=1;
            }
            if($names == 0)
            {

            $sql_insert_new_user = "INSERT INTO user
            (
                user_name,
                user_pw,
                ugroup_id,
                member_id,
                user_created
            )
             VALUES(
                              '$user_name',
                              '$password',
                              '3',
                               $cust_id,
                              '$time_stamp'
                         )";

                $query_insert_user = mysqli_query($db_link, $sql_insert_new_user);
                checkSQL($db_link, $query_insert_user);
                header('Location:logins.php');
             }
             else{
                 echo "Registration failed, Username already exits";
             }

        }
        else
        {
           echo "Registration failed"; 
        }
   }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Register chenken</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="Login/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login/fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="Login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="Login/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login/css/util.css">
	<link rel="stylesheet" type="text/css" href="Login/css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	
	<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
		<div class="wrap-login100 p-l-55 p-r-55 p-t-80 p-b-30">
			<form class="login100-form validate-form" method="POST">
				<span class="login100-form-title p-b-37">
					Sign In
				</span>

				<div class="wrap-input100 validate-input m-b-20" data-validate="Enter username">
					<input class="input100" type="text" name="username" placeholder="username">
					<span class="focus-input100"></span>
				</div>

        <div class="wrap-input100 validate-input m-b-20" data-validate="Enter username ">
					<input class="input100" type="text" name="member_id" placeholder="Member ID">
					<span class="focus-input100"></span>
                </div>
                <div class="wrap-input100 validate-input m-b-25" data-validate = "Enter password">
					<input class="input100" type="password" name="password" placeholder="password">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input m-b-25" data-validate = "Enter password">
					<input class="input100" type="password" name="password" placeholder="password">
					<span class="focus-input100"></span>
				</div>

				<div class="container-login100-form-btn">
					<button class="login100-form-btn" name="member_register">
						Register
					</button>
				</div>

				<div class="text-center">
					<a href="logins.php" class="txt2 hov1">
						Sign In
					</a>
				</div>
			</form>

			
		</div>
	</div>
	
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="Login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="Login/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="Login/vendor/bootstrap/js/popper.js"></script>
	<script src="Login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="Login/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="Login/vendor/daterangepicker/moment.min.js"></script>
	<script src="Login/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="Login/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="Login/js/main.js"></script>

</body>
</html>