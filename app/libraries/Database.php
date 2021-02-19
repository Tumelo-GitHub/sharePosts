<?php
/*
  PDO Databese class
  Connect database
  Create prepared statements
  Bind Values to statements
  Return rows and results
*/

class Database {
  private $host = DB_HOST;
  private $user = DB_USER;
  private $pass = DB_PASS;
  private $dbname = DB_NAME;

  private $dbh;     // database handler
  private $stmt;    // database statements
  private $error;   // database eerror handler

  public function __construct(){
    //set DSN
    $dsn = 'mysql:host='. $this->host .';dbname='.$this->dbname;

    $options = array(
      PDO::ATTR_PERSISTENT => true,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );

    try{
      //connect database
      $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
    } catch(PDOException $e){
      //if something goes wrong, display the error
      $this->error = $e->getMessage();
      echo $this->error;
    }
  }

  // Prepre statememnts with query
  public function query($sql){
    $this->stmt = $this->dbh->prepare($sql);
  }

  // bind values
  public function bind($param, $value, $type = null){
    if(is_null($type)){
      switch(true){
        case is_int($value):
          $type = PDO::PARAM_INT;
          break;
        case is_bool($value):
          $type = PDO::PARAM_BOOL;
          break;
        case is_null($value):
          $type = PDO::PARAM_NULL;
          break;
        default:
          $type = PDO::PARAM_STR;
      }
    }

    $this->stmt->bindValue($param, $value, $type);
  }

  // execute prepared statement
  public function execute(){
    return $this->stmt->execute();
  }

  // get results sets as array of obj
  public function resultSet(){
    $this->execute();
    return $this->stmt->fetchAll(PDO::FETCH_OBJ);
  }

  // get single row
  public function single(){
    $this->execute();
    return $this->stmt->fetch(PDO::FETCH_OBJ);
  }

  // get row count
  public function rowCount(){
    return $this->stmt-> rowCount();
  }
}