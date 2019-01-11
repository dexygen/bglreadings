<?php
require('./lib/jrmvc.lib.php');

class ReadingsController extends AbstractJrMvcController {
  const DB_PATH = "./readings.db";
  
  const READINGS_TABLE_DDL = <<<HERE01
    CREATE TABLE bgl_reading (
      reading_id INTEGER PRIMARY KEY,
      user_id INTEGER NOT NULL,
      reading_date DATE NOT NULL,
      reading INTEGER NULL
    );
HERE01;

  const READINGS_TABLE_SQL_INSERT = <<<HERE02
    INSERT INTO bgl_reading
      (user_id, reading_date, reading) 
    VALUES
      (1, :reading_date, :reading)
HERE02;
  
  const READINGS_TABLE_SQL_DELETE = <<<HERE03
    DELETE FROM bgl_reading WHERE user_id=:user_id AND reading_id=:reading_id
HERE03;

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
      $DBH_READINGS->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
      $STMTH_INSERT_READING = $DBH_READINGS->prepare(ReadingsController::READINGS_TABLE_SQL_INSERT);
      
      $reading = filter_input(INPUT_POST, 'reading', FILTER_SANITIZE_NUMBER_INT); 
      $STMTH_INSERT_READING->bindParam(':reading', $reading, PDO::PARAM_INT);
      $reading_date = filter_input(INPUT_POST, 'reading_date', FILTER_SANITIZE_STRING);
      $STMTH_INSERT_READING->bindParam(':reading_date', $reading_date, PDO::PARAM_STR);
      
      $STMTH_INSERT_READING->execute();
      $DBH_READINGS = null;
    }
  
    function delete_reading() {
      $DBH_READINGS = new PDO('sqlite:' . ReadingsController::DB_PATH);
      $DBH_READINGS->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
      
      $STMTH_DELETE_READING = $DBH_READINGS->prepare(ReadingsController::READINGS_TABLE_SQL_DELETE);
      $reading_id = filter_input(INPUT_POST, 'reading_id', FILTER_SANITIZE_NUMBER_INT); 
      $STMTH_DELETE_READING->bindParam(':reading_id', $reading_id, PDO::PARAM_INT);
      $user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT); 
      $STMTH_DELETE_READING->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      
      $STMTH_DELETE_READING->execute();
      $DBH_READINGS = null;
    }
  
    function json_encoded_readings() {
      if (empty($_GET["user_id"]) && empty($_POST["user_id"])) {
        return array();
      }
      
      $DBH_READINGS = new PDO('sqlite:' . ReadingsController::DB_PATH);
      $STMTH_SELECT_READINGS = $DBH_READINGS->prepare("SELECT * FROM bgl_reading ORDER BY reading_date DESC");
      $STMTH_SELECT_READINGS->execute();
      $all_readings = $STMTH_SELECT_READINGS->fetchAll();
      $DBH_READINGS = null;
      return json_encode($all_readings, JSON_HEX_APOS|JSON_HEX_QUOT);
    }

  
    bootstrap_db();
 
    if (!empty($_POST)) {
      if ($_POST["mode"] === 'add') {
        add_reading(); 
      }
      else if ($_POST["mode"] === 'delete') {
        delete_reading();
      }
    }
  
    $mto->setModelValue('readings', json_decode(json_encoded_readings())); 
    return $mto;
  }
}

ReadingsController::sendResponse(new ReadingsController());