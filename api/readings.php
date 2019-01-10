<?php
require('./lib/jrmvc.lib.php');

class ReadingsController extends AbstractJrMvcController {
  const DB_PATH = "./readings.db";
  const READINGS_TABLE_DDL = <<<EOD
    CREATE TABLE bgl_reading (
      reading_id INTEGER PRIMARY KEY,
      user_id INTEGER NOT NULL,
      reading_date DATE NOT NULL,
      reading INTEGER NOT NULL
    );
EOD;

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
        $DBH_READINGS = new PDO('sqlite:' . ReadingsController::DB_PATH);
        $DBH_READINGS->exec(ReadingsController::READINGS_TABLE_DDL);
        $DBH_READINGS = null;
      }
    }
  
    function add_reading() {
      $DBH_READINGS = new PDO('sqlite:' . ReadingsController::DB_PATH);
      $STMTH_SELECT_READINGS = $DBH_READINGS->prepare("INSERT INTO bgl_reading(user_id, reading_date, reading) VALUES(1, '2019-01-06', 160)");
      $STMTH_SELECT_READINGS->execute();
      $DBH_READINGS = null;
    }
  
    function json_encoded_readings() {
      if (empty($_GET["user_id"]) && empty($_POST["user_id"])) {
        return array();
      }
      
      $DBH_READINGS = new PDO('sqlite:' . ReadingsController::DB_PATH);
      $STMTH_SELECT_READINGS = $DBH_READINGS->prepare("SELECT * FROM bgl_reading");
      $STMTH_SELECT_READINGS->execute();
      $all_readings = $STMTH_SELECT_READINGS->fetchAll();
      $DBH_READINGS = null;
      return json_encode($all_readings, JSON_HEX_APOS|JSON_HEX_QUOT);
    }

    bootstrap_db();
  
    if (!empty($_POST) && $_POST["mode"] === 'add') {
      add_reading();
    }
  
    $mto->setModelValue('readings', json_decode(json_encoded_readings())); 
    return $mto;
  }
}

ReadingsController::sendResponse(new ReadingsController());