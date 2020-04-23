<?php include_once 'config/init.php'; ?>

<?php

$message = new Messages();

$data = array();
$data['sender'] = $_POST['sender'];
$data['receiver'] = $_POST['receiver'];

$allMessages = $message->getAllMessagesBetweenUsers($data);

$dateFunc = function($date){
  return date_format(date_create($date),'g:i a,d/m/y');
};

// $html = '';
if(!empty($allMessages)){
  foreach ($allMessages as $allMessage) {
    if($allMessage['from_user'] == $data['sender']){
      ?>
      <!-- // $html .=  <<<EOD -->
      <li class="clearfix">
        <div class="message-data align-right">
          <span class="message-data-time" ><?php echo $dateFunc($allMessage['send_time']); ?></span>
          <span class="message-data-name" ><?php echo $allMessage['from_user']; ?></span>
        </div>
        <div class="message other-message float-right">
          <?php echo $allMessage['message']; ?>
        </div>
      </li>
      <!-- // EOD; -->
    <?php }else{ ?>
      <!-- $html .=  <<<EOD -->
      <li>
        <div class="message-data">
          <span class="message-data-name"> <?php echo $data['receiver']; ?></span>
          <span class="message-data-time"><?php echo $dateFunc($allMessage['send_time']); ?></span>
        </div>
        <div class="message my-message">
          <?php echo $allMessage['message']; ?>
        </div>
      </li>
      <!-- EOD; -->
    <?php }
  } ?>
  <!-- echo $html; -->
<?php }else{ ?>
   <li class='noMessage'>No Messages Yet</li>
 <?php }
?>
