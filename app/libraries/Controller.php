<?php
/*
  Base contollrt
  Loads The models and views
*/

Class Controller 
{
  //load model
  public function model($model)
  {
    //require model file
    require_once '../app/models/' . $model . '.php';
    //intantiate model
    return new $model();
  }

  //view 
  public function view($view, $data = [])
  {
    //check view file
    if(file_exists('../app/views/'. $view . '.php'))
    {
      // require the view
      require_once '../app/views/'. $view . '.php';
    }
    else
    {
      // view file does not exist
      die('View does not exist');
    }
  }
}