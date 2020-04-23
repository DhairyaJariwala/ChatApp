<?php include_once 'config/init.php'; ?>

<?php

$msg = new Total_Message();

$data = array();
$data['sender'] = $_POST["sender"];
$data['receiver'] = $_POST["receiver"];
$data['message'] = $_POST["message"];

$count = $msg->insertNewMessage($data);

echo $count['total_messages'];

?>
