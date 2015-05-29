<?php namespace App\Classes;
class ErrorObject {

  public $code;
  public $message;


  public function __construct($message,$code)
          {
              //inizializzazione della proprietà $name
              $this->code = $code;
              $this->message = $message;
          }
}
