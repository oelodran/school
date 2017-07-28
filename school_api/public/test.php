<?php
require_once ("../includes/initialize.php");
//if (isset($database)) {echo 'true';} else {echo 'false';}
//echo '<br />';
//echo $database->escape_value("it's working");


$token = new Token();
$token->user_id = 2;
$token->token = 'trava';

$token->create();