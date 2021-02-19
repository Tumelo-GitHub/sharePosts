<?php
// start sessions
session_start();

// flash messages helper function
function flash($name = '', $message = '', $class = 'alert alert-success'){
  // check if name variable is not empty
  if(!empty($name)){
    // check if message is not empty and name session
    if(!empty($message) && empty($_SESSION[$name])){
      // if name session not empty then unset
      if(!empty($_SESSION[$name])){
        unset($_SESSION[$name]);
      }

      // if class name session not empty then unset
      if(!empty($_SESSION[$name . '_class'])){
        unset($_SESSION[$name. '_class']);
      }

      // set sessions
      $_SESSION[$name] = $message;
      $_SESSION[$name .'_class'] = $class;
    }elseif(empty($message) && !empty($_SESSION[$name])){
      $class = !empty($_SESSION[$name. '_class']) ? $_SESSION[$name. '_class'] : '';
      // display
      echo '<div class="'. $class .'" id="msg-flash">' . $_SESSION[$name] . '</div>';
      // unset
      unset($_SESSION[$name]);
      unset($_SESSION[$name. '_class']);
    }
  }
}