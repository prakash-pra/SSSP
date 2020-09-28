<?php
class Application{
   public $router;

   public function __construct() {
      $this->router = new Router();
   }
}
?>