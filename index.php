<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();

$ROOT_REST = $_SERVER['DOCUMENT_ROOT'] . "/new/";

require_once $ROOT_REST . 'config/session.php';
require_once $ROOT_REST . 'config/vars.php';
require_once $ROOT_REST . 'Autoloader.php';
$HTTP_HOST 	= "./";

try {

    $Request 		= new Request();
	$CoreController = new CoreController($Request);

	echo $CoreController->mainHead($TITLE, $HTTP, $HTTP_HOST, "", "");
	echo $CoreController->mainMenu();
	#   Голова страницы
	echo $CoreController->pageHeader();
    #	Контент
	echo $CoreController->run();
	#   Подвал
	echo $CoreController->mainFooter($TITLE, $HTTP, $HTTP_HOST, "");

}
catch (Exception $e)
{
    echo json_encode(Array('error' => $e->getMessage()));
}