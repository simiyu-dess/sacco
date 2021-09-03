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
//query all member id from the customers table
$member_ids = [];
$sql_select_members = "SELECT cust_no FROM customer WHERE customer.cust_id > 0";
$query_memebers = mysqli_query($db_link, $sql_select_members);
checkSQL($db_link, $query_memebers);
foreach ($query_memebers as $row) {
    $member_ids[] = $row['cust_no'];
}
//Query all member ids that are already associated with another account
$associated_members = [];
$sql_select_associtedMembers = "SELECT cust_no, member_id FROM customer, user WHERE customer.cust_id = user.member_id";
$query_associateMembers = mysqli_query($db_link, $sql_select_associtedMembers);
checkSQL($db_link, $query_associateMembers);

foreach ($query_associateMembers as $row) {
    $associated_members[] = $row['cust_no'];
}
//Query all usernames from the users tables
$usernames = [];
$sql_selectUsernames = "SELECT user_name FROM user";
$query_Usernames = mysqli_query($db_link, $sql_selectUsernames);
checkSQL($db_link, $query_Usernames);
foreach ($query_Usernames as $row) {
    $usernames[] = $row['user_name'];
}

if (isset($_POST['member_register'])) {
    $time_stamp = time();

    $username = sanitize($db_link, $_POST['username']);
    $member_id = sanitize($db_link, $_POST['member_id']);
    $password = password_hash(sanitize($db_link, $_POST['password']) . $pepper, PASSWORD_DEFAULT);


    $select_custId = "SELECT cust_id FROM customer WHERE cust_no = '$member_id'";
    $query_memberId = mysqli_query($db_link, $select_custId);
    checkSQL($db_link, $query_memberId);
    $row = mysqli_fetch_array($query_memberId);
    $cust_id = $row['cust_id'];




    $sql_insert_new_user = "INSERT INTO user
            (
                user_name,
                user_pw,
                ugroup_id,
                member_id,
                user_created
            )
             VALUES(
                              '$username',
                              '$password',
                              '3',
                               $cust_id,
                              '$time_stamp'
                         )";

    $query_insert_user = mysqli_query($db_link, $sql_insert_new_user);
    checkSQL($db_link, $query_insert_user);
    header('Location:logins.php');
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
            <form class="login100-form" method="POST" onsubmit="return validate()">
                <span class="login100-form-title p-b-37">
                    Sign Up
                </span>

                <div class="my-div-error" id="errorUsername"></div>
                <div class="wrap-input100 validate-input m-b-20" data-validate="Enter username">
                    <input class="input100" type="text" id="username" name="username" placeholder="username">
                    <span class="focus-input100"></span>
                </div>
                <div class="my-div-error" id="errorMemberId"></div>
                <div class="wrap-input100 validate-input m-b-20" data-validate="Enter Member ID">

                    <input class="input100" type="text" id="memberId" name="member_id" placeholder="Member ID">
                    <span class="focus-input100"></span>
                </div>
                <div class="my-div-error" id="errorPassword"></div>
                <div class="wrap-input100 validate-input m-b-25" data-validate="Enter password">

                    <input class="input100" type="password" id="password" name="password" placeholder="password">
                    <span class="focus-input100"></span>
                </div>
                <div class="my-div-error" id="errorConfPassword"></div>
                <div class="wrap-input100 validate-input m-b-25" data-validate="Enter Repeat Password">
                    <input class="input100" type="password" id="conf_password" name="conf_password" placeholder=" repeat password">
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

    <script>
        function validate() {
            //getting the form values  
            var password = document.getElementById("password").value;
            var Id = document.getElementById("memberId").value;
            var username = document.getElementById("username").value;
            var confPassword = document.getElementById("conf_password").value; 
            var usernames = <?php echo json_encode($usernames); ?>;
            var members = <?php echo json_encode($member_ids);?>;
            var associated_members = <?php echo json_encode($associated_members);?>;

            //getting error divs

            var errorConfPassword = document.getElementById("errorConfPassword");
            var errorPassword = document.getElementById("errorPassword");
            var errorMemberId = document.getElementById("errorMemberId");
            var errorUsername = document.getElementById("errorUsername");
            var j_username = username;
            var j_Id = Id;

            truth = true; 
           

            for(i = 0; i < usernames.length; i++)
            {
                if(usernames[i] == j_username)
                {
                    errorUsername.innerHTML = "Username is already taken";
                    truth = false;
                }
            }
            if(username == "")
            {
                errorUsername.innerHTML = "Please enter the username";
                truth = false;
            }
            if(associated_members.includes(Id))
            {
                errorMemberId.innerHTML = "Member Already has an account";
                truth = false;
            }
            if(!members.includes(Id))
            {
                errorMemberId.innerHTML = "Invalid member Id";
                truth = false;
            }
            if(password.length < 6)
            {
                errorPassword.innerHTML = "passwword must be atleast six characters";
                truth = false;
            }

            if(password != confPassword)
            {
                errorConfPassword.innerHTML = "Password do no match";
                truth = false;
            }


            
           
            return truth;

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