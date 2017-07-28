<?php

require_once (LIB_PATH.DS."database.php");

class Token extends  DatabaseObject
{
    protected static $table_name = "login_tokens";
    protected static $db_fields = array('id', 'user_id', 'token');

    public $id;
    public $user_id;
    public $token;

    public function create() {
        global $database;

        $sql = "INSERT INTO ".self::$table_name." (";
        $sql .= "user_id, token";
        $sql .= ") VALUES (";
        $sql .= $database->escape_value($this->user_id) .", '";
        $sql .= $database->escape_value($this->token) ."')";
        if($database->query($sql)) {
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }
    }

    public static function auth()
    {
        $postBody = file_get_contents("php://input");
        //echo $postBody;
        $postBody = json_decode($postBody);
        //echo $postBody;
        print_r($postBody);


        //print_r($_GET);
        $username  = $postBody->username;
        $password  = $postBody->password;

        $foundUser = User::authenticate($username, $password);

        if($foundUser)
        {
            global $database;
            $strong = True;
            $token = bin2hex(openssl_random_pseudo_bytes(64, $strong));
            $user_id = $database->query("SELECT id FROM users WHERE username = '$username' LIMIT 1");
            $id = 0;
            while ($row = $database->fetch_array($user_id))
            {
                $id = $row['id'];
            }
            $token1 = new Token();
            $token1->user_id = $id;
            $token1->token   = $token;

            $token1->create();

            echo "Token: " . $token;
        }
        else
        {
            http_response_code(405);
        }
    }
}