<?php include_once 'config/init.php'; ?>

<?php

$user = new User();

$data = array();

$data['friendId'] = $_POST['friendId'];
$data['friendName'] = $_POST['friendName'];

$user->deleteFromUserRequestPending($data);
$user->deleteFromSenderRequestSent($data);
$user->updateFriends($data);
$user->updateSendersFriends($data);
?>
