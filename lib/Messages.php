<?php

class Messages{

  private $db;

  public function __construct(){
    $this->db = new Database();
  }

  public function storeMessage($data){
    $count = trim(strval($data['count']));
    if(strcmp($data['sender'],$data['receiver']) < 0){
      $identifier = $data['sender'].":".$data['receiver'].":".$count;
    }else{
      $identifier = $data['receiver'].":".$data['sender'].":".$count;
    }
    $send_time = new DateTime(now, new DateTimeZone("Asia/Kolkata"));
    $send_time = $send_time->format('Y-m-d H:i:s a');
    $this->db->query("INSERT INTO messages (identifier_message_number, message, from_user, send_time) VALUES (:identifier,:message,:from_user, :send_time);");

    $this->db->bind(":identifier",$identifier);
    $this->db->bind(":message",$data['message']);
    $this->db->bind(":from_user",$data['sender']);
    $this->db->bind(":send_time",$send_time);

    $this->db->execute();
  }

  public function getAllMessagesBetweenUsers($data){
    if(strcmp($data['sender'],$data['receiver']) < 0){
      $identifier = $data['sender'].":".$data['receiver'];
    }else{
      $identifier = $data['receiver'].":".$data['sender'];
    }

    $this->db->query("SELECT * FROM messages WHERE identifier_message_number LIKE :identifier ORDER BY send_time ASC;");

    $this->db->bind(":identifier",$identifier.'%');

    return $this->db->resultset(PDO::FETCH_ASSOC);
  }
}

 ?>
