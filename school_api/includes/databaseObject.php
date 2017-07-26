<?php
require_once(LIB_PATH . DS . 'database.php');

class DatabaseObject
{

    // Zajedničke metode baze podataka
    public static function find_all()
    {
        return static::find_by_sql("SELECT * FROM " . static::$table_name);
    }

    // Metoda vraća jedan objekat
    public static function find_by_id($id=0)
    {
        $result_array = static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE id={$id} LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    // Metoda vraća polje objekata
    public static function find_by_sql($sql="")
    {
        global $database;
        $result_set = $database->query($sql);
        $object_array = array();
        while ($row = $database->fetch_array($result_set))
        {
            $object_array[] = static::instantiate($row);
        }
        return $object_array;
    }

    // Metoda prima redak baze podataka i instancira jobjekt koji vraća
    public static function instantiate($record)
    {
         $object = new static;

        // Za dinamičnost korištena varijavla varijabli
        foreach ($record as $attribute => $value)
        {
            if ($object->has_attribute($attribute))
            {
                $object->$attribute = $value;
            }
        }
        return $object;
    }

    private function has_attribute($attribute)
    {
        $object_vars = $this->attributes();
        return array_key_exists($attribute, $object_vars);
    }

    // vraća asocijativno polje svih atributa
    protected function attributes()
    {
        return get_object_vars($this);
    }

    protected function sanitized_attributes()
    {
        global $database;
        $clean_attributes = array();
        foreach($this->attributes() as $key => $value)
            {
            $clean_attributes[$key] = $database->escape_value($value);
        }
        return $clean_attributes;
    }

    // Sprečavanje stvaranja isti redaka
    public function save() {
        // Novostvoreni redak još nema id
        return isset($this->id) ? $this->update() : $this->create();
    }

    public function create() {

        // nije proradilo
//        $attributes = $this->sanitized_attributes();
//        $sql = "INSERT INTO ".self::$table_name." (";
//        $sql .= join(", ", array_keys($attributes));
//        $sql .= ") VALUES ('";
//        $sql .= join("', '", array_values($attributes));
//        $sql .= "')";
        
        global $database;

        $sql = "INSERT INTO ".static::$table_name." (";
        $sql .= "username, password, first_name, last_name";
        $sql .= ") VALUES ('";
        $sql .= $database->escape_value($this->username) ."', '";
        $sql .= $database->escape_value($this->password) ."', '";
        $sql .= $database->escape_value($this->first_name) ."', '";
        $sql .= $database->escape_value($this->last_name) ."')";
        if($database->query($sql))
        {
            $this->id = $database->insert_id();
            return true;
        } else
        {
            return false;
        }
    }

    public function update()
    {
        global $database;

        $attributes = $this->sanitized_attributes();
        $attribute_pairs = array();

        foreach ($attributes as $key => $value)
        {
            $attribute_pairs[] = "{$key}='{$value}'";
        }

        $sql = "UPDATE ".static::$table_name." SET ";
        $sql .= join(", ", $attribute_pairs);
        $sql .= " WHERE id=". $database->escape_value($this->id);

        $database->query($sql);

        return ($database->affected_rows() == 1) ? true : false;
    }

    public function delete()
    {
        global $database;

        $sql = "DELETE FROM ".static::$table_name;
        $sql .= " WHERE id=". $database->escape_value($this->id);
        $sql .= " LIMIT 1";

        $database->query($sql);

        return ($database->affected_rows() == 1) ? true : false;
    }
}