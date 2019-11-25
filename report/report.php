<?php
/*
 *
 * 		TODO объявляем для статических методов так ---  CoreController::class;
 * */


class report extends Api
{
	public static $controllername = 'report';
	private static $path_to_templates = 'templates';

	public function __construct($Request, $ROOT_REST)
	{
		$this->Request 					= $Request; 	// Вопрос
		$this->full_path_to_template 	= self::$controllername . "/" . self::$path_to_templates;
		$this->ROOT_REST 				= $ROOT_REST;
	}
	/**
	 * 	Метод GET
	 * 	Просмотр отдельной записи (по id)
	 * 	http://ДОМЕН/users/index.php || index.htm
	 */
	public function index()
	{
		$html_params = ['h2' => 'Отчет по шлюзам'];

		if (file_exists($this->ROOT_REST . $this->full_path_to_template . "/report_gateways.htm"))
		{
			return $this->template($this->ROOT_REST . $this->full_path_to_template . "/report_gateways.htm", $html_params);
		}
		else
		{
			return $this->response('File not found to index()', 404);
		}
	}
	/**
	 * Метод GET
	 * Просмотр отдельной записи (по id)
	 */
	public function view()
	{
		return $this->response('Data not found VIEW', 404);
	}
	/**
	 * Метод POST
	 * Создание новой записи
	 * @return string
	 */
	public function create()
	{
		return $this->response("CREATE empty ", 500);
	}

	/**
	 * Метод PUT
	 * Обновление отдельной записи (по ее id)
	 * @return string
	 */
	public function update()
	{
		return $this->response("Update empty", 400);
	}
	/**
	 * Метод DELETE
	 * Удаление отдельной записи (по ее id)
	 * @return string
	 */
	public function delete()
	{
		return $this->response("Delete empty", 500);
	}
	public function AjaxHandler()
	{
		if (method_exists($this, $this->Request->find('action')))
		{
			$action = $this->Request->find('action');
			$result = $this->{$action}();
			return json_encode($result);
		}
		else
		{
			return $this->response("Not method to ajax", 404);
		}
	}
	public function __destruct(){}
}