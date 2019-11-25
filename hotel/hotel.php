<?php
/*
 *
 * 		TODO объявляем для статических методов так ---  CoreController::class;
 * */


class hotel extends Api
{
	public static $controllername = 'hotel';
	private static $path_to_templates = 'templates';

	public function __construct($Request, $ROOT_REST)
	{
		$this->Request 					= $Request; 	// Вопрос
		$this->full_path_to_template 	= self::$controllername . "/" . self::$path_to_templates;
		$this->ROOT_REST 				= $ROOT_REST;
		$this->html						= new Html();
        $this->HTML_PARAMS				= ['error' => "hide"];
	}

	/**
	 * 	Метод GET
	 * 	Просмотр отдельной записи (по id)
	 */
	public function index()
	{

        $this->HTML_PARAMS['title'] = 'Отель';
		if (file_exists($this->ROOT_REST . $this->full_path_to_template . "/table.htm"))
		{
			return $this->template($this->ROOT_REST . $this->full_path_to_template . "/table.htm", $this->HTML_PARAMS);
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

	///   if (!function_exists('getallheaders')){}
	function getallheaders()
	{
		$headers = [];
		foreach ($_SERVER as $name => $value)
		{
			if (substr($name, 0, 5) == 'HTTP_')
			{
				$headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
			}
		}
		return $headers;
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