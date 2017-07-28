<?php
require_once (LIB_PATH.DS.'database.php');

class Subject extends DatabaseObject
{
    protected static $table_name = "subjects";
    protected static $db_fields = array('id', 'title');

    public $id;
    public $title;

    public function create() {
        global $database;

        $sql = "INSERT INTO ".self::$table_name." (";
        $sql .= "title";
        $sql .= ") VALUES (";
        $sql .= $database->escape_value($this->title) ."')";
        if($database->query($sql)) {
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }
    }
}