<?PHP
session_start();
require 'functions.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	$fingerprint = fingerprint();
    $db_link = connect();
    $users_id = 0;
    //password pepper to hash the password
    $pepper = 'g7NIiru!!8';
    /*
    //Creating a user account for the members
    //Members must be registere in the system
    */
    
    //checking if the register button has been clicked
    if(isset($_POST['member_register']))
    {

        //checking if the passwords match and are of the right length
        if($_POST['password'] != $_POST['conf_password'])
        {
            $_SESSION['error'] = "Passwords do not match";
            header('Location: registers.php');
            exit();
        }
        //checking if the lenght of the password if greater than six characters
        if(!strlen($_POST['password']>=6))
        {
            $_SESSION['error'] = "Passwords lenght must be atleast six characters";
            header('Location:registers.php');
            exit();

        }
        //getting the user input
    $member_id = sanitize($db_link, $_POST['member_id']);
    $user_name = sanitize($db_link, $_POST['username']);
    $password = password_hash(sanitize($db_link, $_POST['password']).$pepper, PASSWORD_DEFAULT);
    $cust_no = strval($member_id);
    
    

   //getting the customer id and customer number from the customer table
    $sql_select_user = "SELECT cust_no, cust_id FROM customer WHERE customer.cust_id > 0";
    $query_user = mysqli_query($db_link,$sql_select_user);
    checkSQL($db_link, $query_user);
   //checking if the member id exists in the system
   //if the member id exists continue else throw message
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
  
   if(!empty($user))
   {
        $member=[];
        $sql_userid = "SELECT cust_id, cust_no FROM customer WHERE cust_no = '$member_id'
        AND cust_id IN (SELECT member_id FROM user)";
        $query_existing_member = mysqli_query($db_link, $sql_userid);
        checkSQL($db_link, $query_existing_member);

        while($member_user = mysqli_fetch_assoc($query_existing_member))
        {
          $member[] = $member_user['cust_id'];
        }
 
        
        if(empty($member))
        {
            $names = 0;
            $sql_select_username = "SELECT user_name from user WHERE user_id > 0";
            $query_username = mysqli_query($db_link, $sql_select_username);
            checkSQL($db_link, $query_username);
//checking if another username has the same name
// if the username exists throw an error message
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
                 showMessage("Username already exists, choose a unique name");
               
             }

        }
        else
        {
           showMessage("You already have an account!");
         
        }
   }
   else
   {
       showMessage("invalid member number");
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
	<link rel="stylesheet" type="text/css" href="Login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="Login/css/util.css">
	<link rel="stylesheet" type="text/css" href="Login/css/main.css">
    
<!--===============================================================================================-->

</head>
<body>
	
	
	<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
		<div class="wrap-login100 p-l-55 p-r-55 p-t-80 p-b-30">
			<form class="login100-form validate-form" method="POST">
            <div class = "error_div">

                
            <?php if (isset($_SESSION['error'])):?>
                
                    <?php echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                
                <?php endif ?>
                
                </div>

            
				<span class="login100-form-title p-b-37">
					Sign Up
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
					<input class="input100" type="password" name="conf_password"
                     placeholder=" repeat password">
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
	
<!--===============================================================================================-->
	<script src="Login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="Login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="Login/js/main.js"></script>

</body>
</html>