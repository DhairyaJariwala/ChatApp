<?php include_once 'config/init.php'; ?>

<?php
$account = new Account();
$user = new User();

if(isset($_POST['submit'])){

    $data = array();
    $data['username'] = $_POST['username'];
    $data['firstname'] = $_POST['firstname'];
    $data['lastname'] = $_POST['lastname'];
    $data['email'] = $_POST['email'];

    if($_POST['password'] == $_POST['confirm_password']){

        $hashPassword = password_hash($_POST['confirm_password'],PASSWORD_BCRYPT);
        $data['password'] = $hashPassword;
        if($account->create($data)){
            $account_id = $account->getIdByUsername($data);

            $user->create($data,$account_id);
            redirect('login.php','SuccessFully Created New Account','success');
        }
        else{
            redirect('signup.php','Something Went wrong'. 'error');
        }
    }
    else{
        redirect('signup.php','Confirm Password Not Match','error');
    }
}

$signupTemplate = new Template('templates/signuppage.php');

$signupTemplate->title = "ChatApp - SignUp";

echo $signupTemplate;
