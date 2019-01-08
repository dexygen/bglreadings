<?php
require('jrmvc.lib.php');

class ReadingsController extends AbstractJrMvcController {
const DB_PATH = "./readings.db";

function applyInputToModel() {                      
    $mto = new JrMvcMTO('demo.tpl.php');             

    $mto = new class(JrMvcMTO::NULL_TPL) extends JrMvcMTO {
      function onNullTemplate() {
        echo json_encode($this->model);
      }
    };

    function bootstrap_db() {
      if (!file_exists(ReadingsController::DB_PATH)) {
        $FH_READINGS_DB = fopen(ReadingsController::DB_PATH, "w");
        fclose($FH_READINGS_DB);
      }
    }

    bootstrap_db();
    $mto->setModelValue('DB_PATH', file_exists(ReadingsController::DB_PATH)); 
    return $mto;
  }
}

ReadingsController::sendResponse(new ReadingsController());