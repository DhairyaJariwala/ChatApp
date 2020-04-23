<?php

class Account{

    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function getName(){
        $this->db->query("SELECT account_name FROM accounts");
    }

    public function create($data){
        $this->db->query("INSERT INTO accounts (account_name,account_email,account_passwd) values(:username,:email,:password)");

        $this->db->bind(':username',$data['username']);
        $this->db->bind(':email',$data['email']);
        $this->db->bind(':password',$data['password']);


        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function getUser($data){
        $this->db->query("SELECT * FROM accounts WHERE account_name = :username;");

        $this->db->bind(':username',$data['username']);

        return $this->db->resultset();
    }

    public function getIdByUsername($data){
        $this->db->query("SELECT account_id FROM accounts WHERE account_name = :username AND account_passwd = :password;");

        $this->db->bind(':username',$data['username']);
        $this->db->bind(':password',$data['password']);

        $account_id = $this->db->resultset();
        return $account_id[0]->account_id;
    }

}
