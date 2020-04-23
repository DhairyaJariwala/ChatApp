<?php include_once 'config/init.php'; ?>

<?php

$account = new Account();

$userObj = new User();

if(isset($_POST['submit'])){
    $data = array();
    $data['username'] = $_POST['username'];

    $user = $account->getUser($data);

    if($user){
      if(password_verify($_POST['password'],$user[0]->account_passwd)){
          $_SESSION['user'] = $user[0];
          $userObj->updateStatusOnline($_SESSION['user']->account_id);
          redirect("index.php");
      }
      else{
          redirect("login.php","Username or Password is Incorrect!","error");
      }
    }else{
      redirect("login.php","Username does not Exists","error");
    }

}

$loginTemplate = new Template('templates/loginpage.php');

$loginTemplate->title = "ChatApp - Login";

echo $loginTemplate;
