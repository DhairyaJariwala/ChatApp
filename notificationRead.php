<?php include_once 'config/init.php'; ?>

<?php

$user = new User();

$data = array();
$data['notificationId'] = $_POST['notificationId'];

$user->updateNotificationToRead($data);

?>
