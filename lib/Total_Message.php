<?php

/**
 *
 */
class Total_Message
{
  private $db;
  public function __construct()
  {
    $this->db = new Database();
  }

  public function insertNewMessage($data){
    if(strcmp($data['sender'],$data['receiver']) < 0){
      $identifier = $data['sender'].":".$data['receiver'];
    }else{
      $identifier = $data['receiver'].":".$data['sender'];
    }
    $this->db->query("INSERT INTO total_message (identifier, total_messages) VALUES (:identifier, :total) ON DUPLICATE KEY UPDATE total_messages = total_messages + 1;");

    $this->db->bind(":identifier",$identifier,PDO::PARAM_STR);
    $this->db->bind(":total",'1',PDO::PARAM_INT);

    $this->db->execute();

    $this->db->query("SELECT total_messages FROM total_message WHERE identifier = :identifier");

    $this->db->bind(":identifier",$identifier,PDO::PARAM_STR);

    return $this->db->single(PDO::FETCH_ASSOC);
  }
}


 ?>
