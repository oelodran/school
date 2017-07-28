<?php

require_once (LIB_PATH.DS."database.php");

class Marks extends DatabaseObject
{
    protected static $table_name = "marks";
    protected static $db_fields = array('id', 'student_id', 'subject_id', 'mark', 'date');

    public $id;
    public $student_id;
    public $subject_id;
    public $mark;
    public $date;


    public function create() {
        global $database;

        $sql = "INSERT INTO ".self::$table_name." (";
        $sql .= "student_id, subject_id, mark, date";
        $sql .= ") VALUES ('";
        $sql .= $database->escape_value($this->student_id) ."', '";
        $sql .= $database->escape_value($this->subject_id) ."', '";
        $sql .= $database->escape_value($this->mark) ."', '";
        $sql .= $database->escape_value($this->date) ."')";
        if($database->query($sql)) {
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }
    }



}