<?php include_once 'config/init.php'; ?>

<?php
$user = new User();

$data = array();

if($_POST['term'] != ''){
  $data['term'] = $_POST['term'];

  $allUsers = $user->searchFriends($data);

  $html = '<ul id="friend-list">';
  if(!empty($allUsers)){
    foreach ($allUsers as $allUser) {
      $html .= <<<EOD
      <li class="search-item" data-userid="{$allUser['account_id']}"> {$allUser['account_name']}</li>
      EOD;
    }
  }
  $html .= "</ul>";

  echo $html;
}

?>
