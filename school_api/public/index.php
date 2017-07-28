<?php
require_once('../includes/initialize.php');

if($_SERVER['REQUEST_METHOD'] == "GET")

{
   if ($_GET['url'] == "auth")
   {

   }
   elseif ($_GET['url'] == "users")
   {

   }
}
elseif ($_SERVER['REQUEST_METHOD'] == "POST")
{
    if ($_GET['url'] == "auth")
    {
        Token::auth();
    }
}
elseif ($_SERVER['REQUEST_METHOD'] == "DELETE")
{

}
else
{
    http_response_code(405);
}