<?php include_once 'config/init.php'; ?>

<?php
$user = new User();

$user->updateStatusOffline($_SESSION['user']->account_id);
unset($_SESSION['user']);
session_destroy();
redirect("login.php","Logout Successfull","success");
