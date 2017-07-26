<?php
require_once ("../includes/database.php");
if (isset($database)) {echo 'true';} else {echo 'false';}
echo '<br />';
echo $database->escape_value("it's working");
/**
 * Created by PhpStorm.
 * User: Leonardo
 * Date: 25.7.2017.
 * Time: 14:50
 */