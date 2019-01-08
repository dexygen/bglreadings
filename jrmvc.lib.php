<?php
  /*
   * jrMvc (JackRabbitMvc -- formerly barebonesmvc-php) 
   * is a one-file MVC micro-framework for PHP5.
   * 
   * Copyright (c) 2007, George M. Jempty
   *
   * "A designer knows he has achieved perfection not when there is nothing left
   * to add, but when there is nothing left to take away."
   * (Antoine de Saint-Exupery)
   *
   * LICENSE: https://opensource.org/licenses/MIT
   *
   * USAGE:
   *
   <?php
     require('jrmvc.lib.php');                                 // 1) require

     class DemoController extends AbstractJrMvcController {    // 2) extend
        function applyInputToModel() {                         // 3) implement
           $mto = new JrMvcMTO('demo.tpl.php');               // 4) instantiate
           // demo.tpl.php content: <pre>$model: <?php print_r($model); ?&gt;</pre>

           $mto->setModelValue('Su', 'Sunday');                // 5) assignments
           $mto->setModelValue('Mo', 'Monday');
           $mto->setModelValue('Tu', 'Tuesday');
           $mto->setModelValue('We', 'Wednesday');
           $mto->setModelValues(['Th'=>'Thursday', 'Fr'=>'Friday', 'Sa'=>'Saturday']);

           return $mto;                                        // 6) return
         }
     }

     DemoController::sendViewAsResponse(new DemoController());       // 7) send
   *
   * OUTPUT:
   *
     $model: Array
      (
      [Su] => Sunday
      [Mo] => Monday
      [Tu] => Tuesday
      [We] => Wednesday
      [Th] => Thursday
      [Fr] => Friday
      [Sa] => Saturday
      )
   */ 

  interface IJrMvcController {
    function setMto(IModelXfer $mto);
    static function sendViewAsResponse(IJrMvcController $controller);
    function applyInputToModel();
  }
  
  abstract class AbstractJrMvcController implements IJrMvcController {
    protected $mto;
    
    function setMto(IModelXfer $mto) {
      $this->mto = $mto;
    }
    
    static function sendViewAsResponse(IJrMvcController $controller) {
      $controller->setMto($controller->applyInputToModel());
      $controller->mto->applyModelToView();
    }
  }
  
  interface IModelXfer {
    function setView($view);
    function setModel($model);
    function setModelValue($key, $value);
    function applyModelToView();
  }

  abstract class AbstractMTO implements IModelXfer {
    protected $view;
    protected $model;
    const NO_VIEW = null;
    
    function setView($view) {
      $this->view = $view;    
    }
    
    function setModel($model) {
      $this->model = $model;
    }
    
    function setModelValue($key, $value) {
      $this->model[$key] = $value;
    }
    
    function setModelValues($arr) {
      foreach ($arr as $key => $value) {
        $this->model[$key] = $value;
      }
    }
    
    protected function unsetNonSessionGlobals() {
      $session = $GLOBALS['_SESSION'];
      unset($GLOBALS);
      $GLOBALS['_SESSION'] = $session;      
    }
    
    protected function whenNoView() {}
  }
  
  class JrMvcMto extends AbstractMTO {    
    function __construct($view) {
      $this->setView($view);
    }
    
    function applyModelToView() {
      # Ensures view does not have access to get/post variables,
      # thus encouraging all access to them to occur within controller
      $this->unsetNonSessionGlobals();
      
      if (is_null($this->view)) {
        $this->whenNoView();
      }
      else {
        $model = $this->model;
        include($this->view); 
      }
    }    
  }
?>