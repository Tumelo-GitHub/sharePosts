<?php
  class User {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    //cheching user by email
    public function findUserByEmail($email){
      // get emails from Db
      $this->db->query('SELECT * FROM users WHERE email = :email');
      //bind
      $this->db->bind(':email', $email);
      // get a single result
      $row = $this->db->single();

      //check if email is returned
      if($this->db->rowCount() > 0){
        return true;
      }else{
        return false;
      }
    }

    // register user
    public function register($data){
      $this->db->query('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
      // bind values
      $this->db->bind(':name', $data['name']);
      $this->db->bind(':email', $data['email']);
      $this->db->bind('password',$data['password']);
      // executes
      if($this->db->execute()){
        return true;
      }else{
        return false;
      }
    }

    // login user model
    public function login($email, $password){
      $this->db->query('SELECT * FROM users WHERE email = :email');
      $this->db->bind(':email', $email);
      $row = $this->db->single();

      // verify password
      if(password_verify($password, $row->password)){
        return $row;
      }else{
        return false;
      }
    }
  }