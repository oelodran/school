<?php
require_once (LIB_PATH.DS.'database.php');

class Grade extends DatabaseObject
{
    protected static $table_name = "classes";
    protected static $db_fields = array('id', 'name');

    public $id;
    public $name;

    public function create() {
        global $database;

        $sql = "INSERT INTO ".self::$table_name." (";
        $sql .= "name";
        $sql .= ") VALUES (";
        $sql .= $database->escape_value($this->name) ."')";
        if($database->query($sql)) {
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }
    }
}