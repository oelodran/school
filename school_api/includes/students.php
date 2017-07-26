<?php

/**
 * Created by PhpStorm.
 * User: Leonardo
 * Date: 25.7.2017.
 * Time: 14:44
 */
class Students extends DatabaseObject
{
    protected static $table_name = "students";
    protected static $db_fields = array('student_id', 'class_id', 'first_name', 'last_name');

    public $student_id;
    public $class_id;
    public $first_name;
    public $last_name;
}