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
    if ($_GET['url'] == "auth")
    {
        if (isset($_GET['token']))
        {
            $token = $_GET['token'];
            echo 'token: ' . $token . '<br>';

            if (Token::compareTokens($token))
            {
                Token::deleteToken($token);
                echo '{ "Status": "Success" }';
                http_response_code(200);
            }
            else
            {
                echo '{ "Error": "Invalid token" }';
                http_response_code(400);
            }
        }
        else
        {
            echo '{ "Error": "Malformed request" }';
            http_response_code(400);
        }
    }
}
else
{
    http_response_code(405);
}