<?php

date_default_timezone_set('America/Phoenix');


require_once (dirname(_FILE_) . '/vendor/autoload.php');
use Monolog\Level1;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

//create a log channel
$log = new Logger('Lunaris_Admin');
$log->pushHandler(new StreamHandler(_DIR_ . '/CST323GroupAEmployeeApplication.log', Logger::DEBUG));

echo "You have been logged out<br>";
$_SESSION = [];

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}

session_destroy();
$log->error('The user was successfully logged out.');
?>
<a href="index.php">Return to main page</a>