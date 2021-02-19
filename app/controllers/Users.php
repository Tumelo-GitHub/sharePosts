<?php

class Users extends Controller{

  public function __construct(){
    // CALL USER MODEL
    $this->userModel = $this->model('User');
  }

  public function register(){
    // Check for POST
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      //  Processs the form

      // sanitize post data
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'name' => trim($_POST['name']),
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),
        'confirm_password' => trim($_POST['confirm_password']),
        'name_err' => '',
        'email_err' => '',
        'password_err' => '',
        'confirm_password_err' => ''
      ];

      // VALIDATIONS
      
      //validate name
      if(empty($data['name'])){
        $data['name_err'] = 'Please Enter Name';
      }

      // validate email
      if(empty($data['email'])){
        $data['email_err'] = 'Please Enter Email';
      }else{
        // check email
        if($this->userModel->findUserByEmail($data['email'])){
          $data['email_err'] = 'Email has already been used';
        }
      }

      // validate passwaord
      if(empty($data['password'])){
        $data['password_err'] = "Please Enter Password"; 
      }elseif(strlen($data['password']) < 6){
        $data['password_err'] = 'Password must have at least 6 charecters';
      }

      //validate confirm password
      if(empty($data['confirm_password'])){
        $data['confirm_password_err'] = 'Please Confirm Password';
      }elseif($data['confirm_password'] != $data['password']){
        $data['confirm_password_err'] = 'Password do not match';
      }

      // confirm error variables are empty
      if(empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
        //process validated inputs
        
        // harsh the password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        // call usermodel to register the user
        if($this->userModel->register($data)){
          // redirect to login page
          // header('location: '. URLROOT . '/users/login');
          flash('register_success', 'You are now registered, Please login.');
          redirect('users/login');
        }else{
          die("something went wrong!");
        }

      }else{
        //load view with errors
        $this->view('users/register', $data);
      }
    }else{
      // Load the form
      // init data
      $data = [
        'name' => '',
        'email' => '',
        'password' => '',
        'confirm_password' => '',
        'name_err' => '',
        'email_err' => '',
        'password_err' => '',
        'confirm_password_err' => ''
      ];

      // load view
      $this->view('users/register', $data);
    }
  }

  public function login(){
    // Check for POST
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      //  Processs the form

      // sanitize post data
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      // init data
      $data = [
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),
        'email_err' => '',
        'password_err' => ''
      ];

      // validate email
      if(empty($data['email'])){
        $data['email_err'] = 'Please Enter Email';
      }elseif($this->userModel->findUserByEmail($data['email'])){
        // email found
      }else{
        // email not found
        $data['email_err'] = 'Email does not exist';
      }

      // validate passwaord
      if(empty($data['password'])){
        $data['password_err'] = "Please Enter Password"; 
      }elseif(strlen($data['password']) < 6){
        $data['password_err'] = 'Password must have at least 6 charecters';
      }

      // confirm error variables are empty
      if(empty($data['email_err']) && empty($data['password_err'])){
        //process validated inputs
        // login using the model
        $loggedInUser = $this->userModel->login($data['email'], $data['password']);
        // check if login was successful
        if($loggedInUser){
          // create session
          $this->createUserSession($loggedInUser);
        }else{
          // An error occured
          $data['password_err'] = 'Password is incorrect';
          // load view
          $this->view('users/login', $data);
        }
      }else{
        //load view with errors
        $this->view('users/login', $data);
      }

    }else{
      // Load the form
      // init data
      $data = [
        'email' => '',
        'password' => '',
        'email_err' => '',
        'password_err' => ''
      ];

      // load view
      $this->view('users/login', $data);
    }
  }

  public function createUserSession($user){
    // creating user sessions
    $_SESSION['user_id'] = $user->id;
    $_SESSION['user_email'] = $user->email;
    $_SESSION['user_name'] = $user->name;
    redirect('pages/index');
  }

  // user log out
  public function logout(){
    // unset sessions
    unset($_SESSION['user_id']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_name']);
    session_destroy();
    // redirect to login page
    redirect('users/login');
  }

  // function to check if user is logged in
  public function isLoggegIn(){
    if(isset($_SESSION['user_id'])){
      return true;
    }else{
      return false;
    }
  }
}