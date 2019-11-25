<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();

$ROOT_REST = "/var/www/web.aanda.ru/public_html/new/";

require_once $ROOT_REST . 'config/session.php';
require_once $ROOT_REST . 'config/vars.php';
require_once $ROOT_REST . 'Autoloader.php';

try {

	$Request        = new Request();
	$CoreController = new CoreController($Request);
	$url = explode("/", $Request->getPathInfo());

	if (!empty($url[1]))
	{

		#	Подключаем класс основной
		require_once $ROOT_REST . $url[1] . '/' . $url[1] . '.php';
		$controller = new report($Request, $ROOT_REST);

		echo $CoreController->mainHead($TITLE, $HTTP, $HTTP_HOST);
		echo $CoreController->mainMenu();
		#   Голова страницы
		echo $CoreController->pageHeader();
		#	Контент
		echo $controller->run();
		#   Подвал
		echo $CoreController->mainFooter($TITLE, $HTTP, $HTTP_HOST);
	}
}
catch (Exception $e)
{
	echo json_encode(Array('error' => $e->getMessage()));
}