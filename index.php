<?php include_once 'config/init.php'; ?>

<?php

if(!isset($_SESSION['user'])){
    header("Location: login.php");
}

$user = new User();

$template = new Template("templates/frontpage.php");

$template->title = "Chat App";

$template->friends = $user->getAllUserFriends($_SESSION['user']);
$template->friendRequests = $user->getAllFriendRequests();
if($template->friendRequests != NULL){
  $template->allRequestedUsers = $user->getAllUserById($template->friendRequests);
}

$template->notifications = $user->getAllUserNotifications();

echo $template;
