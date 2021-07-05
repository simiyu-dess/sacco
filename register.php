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

    if(isset($_POST['register']))
    {
    $member_id = sanitize($db_link, $_POST['member_number']);
    $user_name = sanitize($db_link, $_POST['user_name']);
    $key = $user_name.$member_id;
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
                header('Location:login.php');
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
<!DOCTYPE HTML>
<html>
<?PHP includeHead('register') ?>
		<script>
			function validate(form){
                fail = validatePw(form.password.value, form.repeat_password.value)
				if (fail == "") return true
				else {

					alert(fail);
					return false
				}
			}
		</script>
		<script src="functions_validate.js"></script>
	</head>
    <body>
<div class="register">
<form action="register.php" method="post" onSubmit="return validate(this)"> 
<input type = "text" name ="member_number" placeholder="Enter member id"/><br/>
<input type = "text" name ="user_name" placeholder = "Enter the user name" /><br/>
<input type = "password" name = "password" placeholder = "Enter the password"/><br/>
<input type = "password" name = "repeat_password" placeholder ="Re type the password"/><br/>
<input type = "submit" name ="register" value = "Submit" />
</form>
</div>
</body>
</html>