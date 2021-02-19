<?php
/*
* App core class
* Creates URL and Loads core controller
* URL FORMAT - /controller/method/params
*/

class Core{
  protected $currentController = 'Pages';
  protected $currentMethod = 'index';
  protected $params = [];

  public function __construct(){
    //print_r($this->getUrl());
    $url = $this->getUrl();
    // look in controllers for foirst value
    if(file_exists('../app/controllers/' . ucwords($url[0]) . '.php'))
    {
      //set as controller
      $this->currentController = ucwords($url[0]);
      //unset (remove) 0 index on the array
      unset($url[0]);
    }

    //require current controller
    require_once '../app/controllers/'. $this->currentController . '.php';
    //instantiate controller class
    $this->currentController = new $this->currentController;

    //check the second part of url
    if(isset($url[1]))
    {
      //check if the method exist
      if(method_exists($this->currentController, $url[1]))
      {
        $this->currentMethod = $url[1];
        unset($url[1]);
      }
    }

    //get params
    $this->params = $url ? array_values($url) : [];

    //call a callback with array of params
    call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
  }

  public function getUrl()
  {
    // check if URL is set
    if(isset($_GET['url']))
    {
      $url = rtrim($_GET['url'], '/');      // GET RID OF THE LAST SLASH
      $url = filter_var($url, FILTER_SANITIZE_URL);     // FILTER THE URL ARRAY
      $url = explode('/', $url);        // SPLIT URL IN ARRAY FORMART

      return $url;
    }
  }
}