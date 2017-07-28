<?php
require_once (LIB_PATH.DS.'database.php');

class Teacher extends DatabaseObject
{
    protected static $table_name = "teachers";
    protected static $db_fields = array('id', 'first_name', 'last_name');

    public $id;
    public $first_name;
    public $last_name;

    public function create() {
        global $database;

        $sql = "INSERT INTO ".self::$table_name." (";
        $sql .= "first_name, last_name";
        $sql .= ") VALUES (";
        $sql .= $database->escape_value($this->first_name) .", '";
        $sql .= $database->escape_value($this->last_name) ."')";
        if($database->query($sql)) {
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }
    }
}