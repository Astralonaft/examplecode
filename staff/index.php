<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();

$ROOT_REST = "/var/www/web.aanda.ru/public_html/new/";

require_once $ROOT_REST . 'config/session.php';
require_once $ROOT_REST . 'config/vars.php';
require_once $ROOT_REST . 'Autoloader.php';
require_once $ROOT_REST . 'AutoloaderTraits.php';

try {

	$Request        = new Request();
	$CoreController = new CoreController($Request);
	$url 			= explode("/", $Request->getPathInfo());
	#	Есть ли название для папки и файла (можно и вручную)
	if (!empty($url[1]))
	{

		#	Подключаем класс основной
		require_once $ROOT_REST . $url[1] . '/' . $url[1] . '.php';
		$controller = new staff($Request, $ROOT_REST);

		#	Подключим только для этой страницы
		$CSS = '<link rel="stylesheet" href="' . $HTTP . $HTTP_HOST . 'assets/css/bootstrap/bootstrap-table.min.css">';
		# 	Подключим только для этой страницы
		$JS = '<script src="' . $HTTP . $HTTP_HOST . 'assets/js/vue.js"></script>';
		#	Подключим для таблиц
		$JSfoot = '<script src="' . $HTTP . $HTTP_HOST . 'assets/js/bootstrap/table/bootstrap-table.js"></script>';
		$JSfoot .= '<script src="' . $HTTP . $HTTP_HOST . 'assets/js/bootstrap/table/bootstrap-table-ru-RU.js"></script>';
		#	Экспорт данных из таблицы js
		//$JSfoot .= '<script src="' . $HTTP . $HTTP_HOST . 'assets/js/bootstrap/table/export/bootstrap-table-export.js"></script>';
		//$JSfoot .= '<script src="' . $HTTP . $HTTP_HOST . 'assets/js/bootstrap/table/export/plugin/tableExport.min.js"></script>';
		//$JSfoot .= '<script src="' . $HTTP . $HTTP_HOST . 'assets/js/bootstrap/table/export/plugin/libs/jspdf.min.js"></script>';
		//$JSfoot .= '<script src="' . $HTTP . $HTTP_HOST . 'assets/js/bootstrap/table/export/plugin/libs/jspdf.plugin.autotable.js"></script>';
		#	Свой js
		$JSfoot .= '<script src="' . $HTTP . $HTTP_HOST . 'assets/js/staff/staff.js?v=' . time() . '"></script>'; // ?v=1

		#   TODO html head
		echo $CoreController->mainHead($TITLE, $HTTP, $HTTP_HOST, $JS, $CSS);
		#   TODO Основное страницы
		echo $CoreController->mainMenu();
		#   TODO Голова страницы
		echo $CoreController->pageHeader();
		#	TODO Контент
		echo $controller->run();
		#   TODO Подвал
		echo $CoreController->mainFooter($TITLE, $HTTP, $HTTP_HOST, $JSfoot);
	}
}
catch (Exception $e)
{
	echo json_encode(Array('error' => $e->getMessage()));
}