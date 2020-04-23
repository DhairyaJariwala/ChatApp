<?php

class User{

    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function create($data,$account_id){
        $this->db->query("INSERT INTO user (f_name,l_name,email,account_id) VALUES (:firstname,:lastname,:email,:account_id);");

        $this->db->bind(':firstname',$data['firstname']);
        $this->db->bind(':lastname',$data['lastname']);
        $this->db->bind(':email',$data['email']);
        $this->db->bind(':account_id',$account_id,PDO::PARAM_INT);

        $this->db->execute();

    }

    public function getAllUserFriends($data){
        $this->db->query("SELECT friends FROM user WHERE account_id = :account_id; ");

        $this->db->bind(':account_id',$data->account_id,PDO::PARAM_INT);

        $friends = $this->db->resultset();
        $friends = explode(',', $friends[0]->friends);

        $friendsName = array();
        foreach ($friends as $friend) {
            $this->db->query("SELECT a.account_id,a.account_name,u.status,u.last_login FROM accounts a join user u ON a.account_id = u.account_id WHERE u.account_id = :account_id; ");

            $this->db->bind(':account_id',$friend);

            $frinedsName[] = $this->db->resultset(PDO::FETCH_ASSOC);

        }
        $friendsName = $frinedsName;
        return $friendsName;
    }

    public function updateStatusOnline($data){
      $this->db->query("UPDATE user set status = 1 WHERE account_id = :account_id ;");

      $this->db->bind(":account_id",$data,PDO::PARAM_INT);

      $this->db->execute();
    }

    public function updateStatusOffline($data){
      $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
      $this->db->query("UPDATE user set status = 0, last_login = :currentTime WHERE account_id = :account_id ;");

      $this->db->bind(":currentTime", $date->format('Y-m-d H:i:s'));
      $this->db->bind(":account_id",$data,PDO::PARAM_INT);

      $this->db->execute();
    }

    public function searchFriends($data){
      $this->db->query("SELECT friends FROM user WHERE account_id = :account_id; ");

      $this->db->bind(':account_id',$_SESSION['user']->account_id,PDO::PARAM_INT);

      $friends = $this->db->resultset(PDO::FETCH_ASSOC);
      if($friends[0]['friends'] == '' || $friends[0]['friends'] == NULL){
        $friends = $_SESSION['user']->account_id;
      }else{
        $friends = $friends[0]['friends'];
        $friends = $friends .",".$_SESSION['user']->account_id;
      }
      $this->db->query("SELECT a.account_name,a.account_id FROM user u JOIN accounts a ON a.account_id = u.account_id WHERE a.account_name LIKE :account_name AND a.account_id NOT IN (". $friends . ");");
      $this->db->bind(":account_name",'%'.$data['term'].'%',PDO::PARAM_STR);

      return $this->db->resultset(PDO::FETCH_ASSOC);
    }

    public function updateRequest_pending($data){
      $this->db->query("SELECT requests_pending FROM user WHERE account_id = :account_id;");
      $this->db->bind(":account_id",$data['receiverId']);

      $sent = $this->db->resultset(PDO::FETCH_ASSOC);
      $sent = $sent[0]['requests_pending'];

      if($sent == '' || $sent == NULL){
        $sent = $_SESSION['user']->account_id;
      }else{
        $sent = $sent . ',' . $_SESSION['user']->account_id;
      }



      $this->db->query("UPDATE user SET requests_pending = :user WHERE account_id = :account_id;");

      $this->db->bind(":user",$sent);
      $this->db->bind(":account_id",$data['receiverId']);

      $this->db->execute();
    }

    public function updateRequest_sent($data){
      $this->db->query("SELECT requests_sent FROM user WHERE account_id = :account_id;");
      $this->db->bind(":account_id",$_SESSION['user']->account_id);

      $sent = $this->db->resultset(PDO::FETCH_ASSOC);
      $sent = $sent[0]['requests_sent'];

      if($sent == '' || $sent == NULL){
        $sent = $data['receiverId'];
      }else{
        $sent = $sent . ',' . $data['receiverId'];
      }


      $this->db->query("UPDATE user SET requests_sent = :user WHERE account_id = :account_id;");

      $this->db->bind(":user",$sent);
      $this->db->bind(":account_id",$_SESSION['user']->account_id);

      $this->db->execute();
    }

    public function serachRequests_sent($data){
      $this->db->query("SELECT requests_sent FROM user WHERE account_id = :account_id;");

      $this->db->bind(":account_id",$_SESSION['user']->account_id);
      $requestSent = $this->db->resultset(PDO::FETCH_ASSOC);

      $requestSent = $requestSent[0]['requests_sent'];

      if(strpos($requestSent,$data['receiverId']) !== false){
        return true;
      }else{
        return false;
      }
    }

    public function getAllFriendRequests(){
      $this->db->query("SELECT requests_pending FROM user WHERE account_id = :account_id;");

      $this->db->bind(":account_id",$_SESSION['user']->account_id);
      $requests = $this->db->resultset(PDO::FETCH_ASSOC);

      if($requests[0]['requests_pending'] == '' || $requests[0]['requests_pending'] == NULL){
        return null;
      }else{
        return explode(',',$requests[0]['requests_pending']);
      }

    }

    public function getAllUserById($users){
      $requestedUsers = array();
      for ($i = 0;$i<count($users);$i++){
        $this->db->query("SELECT a.*,u.* FROM user u JOIN accounts a ON u.account_id = a.account_id WHERE a.account_id = :account_id;");
        $this->db->bind(":account_id",$users[$i]);

        $requestedUsers[] = $this->db->resultset(PDO::FETCH_ASSOC);
      }
      return $requestedUsers;
    }

    public function updateNotifications($notifications){
      $this->db->query("INSERT INTO notifications (message,for_user,seen) VALUES (:message,:for_user,:seen);");

      $this->db->bind(":message",$notifications['message']);
      $this->db->bind(":for_user",$notifications['for_user']);
      $this->db->bind(":seen",$notifications['seen']);

      $this->db->execute();
    }

    public function updateFriends($data){
      $this->db->query("SELECT friends FROM user WHERE account_id = :account_id;");
      $this->db->bind(":account_id",$_SESSION['user']->account_id);
      $friends = $this->db->resultset(PDO::FETCH_ASSOC);

      $friends = $friends[0]['friends'];
      if($friends == NULL || $friends == ''){
        $friends = $data['friendId'];
      }else{
        $friends = $friends . ',' . $data['friendId'];
      }

      $this->db->query("UPDATE user SET friends = :friends WHERE account_id = :account_id");
      $this->db->bind(":friends",$friends);
      $this->db->bind(":account_id",$_SESSION['user']->account_id);
      $this->db->execute();

      $notifications = array();
      $notifications['message'] = $data['friendName']. ' accepted Your Friend Request.';
      $notifications['for_user'] = $_SESSION['user']->account_id;
      $notifications['seen'] = 0;
      $this->updateNotifications($notifications);
    }

    public function updateSendersFriends($data){
      $this->db->query("SELECT friends FROM user WHERE account_id = :account_id;");
      $this->db->bind(":account_id",$data['friendId']);
      $friends = $this->db->resultset(PDO::FETCH_ASSOC);

      $friends = $friends[0]['friends'];
      if($friends == NULL || $friends == ''){
        $friends = $_SESSION['user']->account_id;
      }else{
        $friends = $friends . ',' . $_SESSION['user']->account_id;
      }

      $this->db->query("UPDATE user SET friends = :friends WHERE account_id = :account_id");
      $this->db->bind(":friends",$friends);
      $this->db->bind(":account_id",$data['friendId']);
      $this->db->execute();

      $notifications = array();
      $notifications['message'] = $_SESSION['user']->account_name. ' accepted Your Friend Request.';
      $notifications['for_user'] = $data['friendId'];
      $notifications['seen'] = 0;
      $this->updateNotifications($notifications);
    }

    public function deleteFromSenderRequestSent($data){
      $this->db->query("SELECT requests_sent FROM user WHERE account_id = :account_id;");
      $this->db->bind(":account_id",$data['friendId']);
      $sent = $this->db->resultset(PDO::FETCH_ASSOC);

      if(strpos($sent[0]['requests_sent'],',') === false){
        if($_SESSION['user']->account_id == $sent[0]['requests_sent']){
          $sent = NULL;
        }
      }else{
        $friendsArray = explode(',',$sent[0]['requests_sent']);
        foreach (array_keys($friendsArray, $_SESSION['user']->account_id) as $key) {
            $unsetKey = $key;
            unset($friendsArray[$key]);
        }
        if(count($friendsArray) > 1){
            $sent = implode(',',$friendsArray);
        }else{
          if($unsetKey == 0){
              $sent = $friendsArray[1];
          }else{
            $sent = $friendsArray[0];
          }
        }
      }
      $this->db->query("UPDATE user SET requests_sent = :user WHERE account_id = :account_id;");
      $this->db->bind(":user",$sent);
      $this->db->bind(":account_id",$data['friendId']);
      $this->db->execute();
    }

    public function deleteFromUserRequestPending($data){
      $this->db->query("SELECT requests_pending FROM user WHERE account_id = :account_id;");
      $this->db->bind(":account_id",$_SESSION['user']->account_id);
      $pending = $this->db->resultset(PDO::FETCH_ASSOC);

      if(strpos($pending[0]['requests_pending'],',') === false){
        if($data['friendId'] == $pending[0]['requests_pending']){
          $pending = NULL;
        }
      }else{
        $friendsPendingArray = explode(',',$pending[0]['requests_pending']);
        foreach (array_keys($friendsPendingArray, $data['friendId']) as $key) {
            unset($friendsPendingArray[$key]);
            $unsetKey = $key;
        }
        if(count($friendsPendingArray) > 1){
            $pending = implode(',',$friendsPendingArray);
        }else{
          if($unsetKey == 0){
              $pending = $friendsPendingArray[1];
          }else{
            $pending = $friendsPendingArray[0];
          }

        }
      }

      $this->db->query("UPDATE user SET requests_pending = :user WHERE account_id = :account_id;");
      $this->db->bind(":user",$pending);
      $this->db->bind(":account_id",$_SESSION['user']->account_id);
      $this->db->execute();
    }



    public function getAllUserNotifications(){
      $this->db->query("SELECT * FROM notifications WHERE for_user = :user AND seen = :seen");

      $this->db->bind(":user",$_SESSION['user']->account_id);
      $this->db->bind(":seen",0);

      return $this->db->resultset(PDO::FETCH_ASSOC);
    }

    public function updateNotificationToRead($data){
      $this->db->query("UPDATE notifications SET seen = :seen WHERE id = :id;");

      $this->db->bind(":id",$data['notificationId']);
      $this->db->bind(":seen",1);
      $this->db->execute();
    }
}
