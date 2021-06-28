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
    $users = array();
    $user_names = array();
    $user_memberid = array();
	$sql_users = "SELECT user.user_id, user.user_name, user.user_created,user.member_id, ugroup.ugroup_id,
	               ugroup.ugroup_name, employee.empl_id, employee.empl_name 
	               FROM user LEFT JOIN ugroup ON ugroup.ugroup_id = user.ugroup_id 
				   LEFT JOIN employee ON user.empl_id = employee.empl_id
				   WHERE user.user_id != 0 
				   ORDER BY user_name";
				   
	$query_users = mysqli_query($db_link, $sql_users);
	checkSQL($db_link, $query_users);
	while($row_users = mysqli_fetch_assoc($query_users)){
		$users[] = $row_users;
        $user_names[] = $row_users['user_name'];
        $user_memberid[] = $row_users['member_id'];

        //get all members from the database who are lready associated with an account
        
    $sql_member_assoc = "SELECT cust_no FROM customer WHERE cust_no != NULL AND cust_no IN (SELECT member_id FROM user)";
	$query_member_assoc = mysqli_query($db_link, $sql_member_assoc);
    checkSQL($db_link, $query_member_assoc);
    }
	$memeber_assoc = array();
	while($row_member_assoc = mysqli_fetch_assoc($query_member_assoc)){
		$member_assoc[] = $row_member_assoc['empl_id'];
    }

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

            $sql_insert_new_user = "INSERT INTO user(
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