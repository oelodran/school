<?php
require_once (LIB_PATH.DS.'database.php');

class Students extends DatabaseObject
{
    protected static $table_name = "students";
    protected static $db_fields = array('id', 'class_id', 'first_name', 'last_name');

    public $id;
    public $class_id;
    public $first_name;
    public $last_name;

    public function create() {
        global $database;

        $sql = "INSERT INTO ".self::$table_name." (";
        $sql .= "class_id, first_name, last_name";
        $sql .= ") VALUES (";
        $sql .= $database->escape_value($this->class_id) .", '";
        $sql .= $database->escape_value($this->first_name) ."', '";
        $sql .= $database->escape_value($this->last_name) ."')";
        if($database->query($sql)) {
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }
    }

    public static function studentsFromGrade($grade)
    {
        global $database;
        $sql = "SELECT students.*, classes.name FROM students, classes WHERE students.class_id = classes.id AND classes.name = '{$grade}'";
        $students = self::find_by_sql($sql);
        return $students;
    }
}