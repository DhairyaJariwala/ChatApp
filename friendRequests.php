<?php include_once 'config/init.php'; ?>

<?php

$user = new User();

$data = array();

if(!isset($_POST['receiver'])){

  $data['receiverId'] = $_POST['receiverId'];
  $result = $user->serachRequests_sent($data);
    echo ($result === true) ? json_encode(array('result'=>'true')) : json_encode(array('result'=>'false'));

}else{

  $data['receiver'] = $_POST['receiver'];
  $data['receiverId'] = $_POST['receiverId'];

  $user->updateRequest_pending($data);
  $user->updateRequest_sent($data);

}

?>
