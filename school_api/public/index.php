<?php
require_once('../includes/database.php');

if($_SERVER['REQUEST_METHOD'] == "GET")
{
    $result = $database->query("SELECT * FROM students");
    $test = array();
    print_r($_GET);
    while($row = mysqli_fetch_assoc($result))
        $test[] = $row;
    print json_encode($test);
}
elseif ($_SERVER['REQUEST_METHOD'] == "POST")
{
    echo "POST";
}
else
{
    http_response_code(405);
}