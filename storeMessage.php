<?php include_once 'config/init.php'; ?>

<?php
$message = new Messages();

$data = array();

$data['message'] = $_POST['message'];
$data['sender'] = $_POST['sender'];
$data['receiver'] = $_POST['receiver'];
$data['count'] = $_POST['msgCount'];

$message->storeMessage($data);
?>
