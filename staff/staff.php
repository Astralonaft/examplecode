<?php
/*
 *
 * 		TODO объявляем для статических методов так ---  CoreController::class;
 * */


class staff extends Api
{
	use CURL, FILE;

	public static $controllername = 'staff';
	private static $path_to_templates = 'templates';

	public function __construct($Request, $ROOT_REST)
	{
		$this->Request 					= $Request; 	// Вопрос
		$this->full_path_to_template 	= self::$controllername . "/" . self::$path_to_templates;
		$this->ROOT_REST 				= $ROOT_REST;
		$this->html						= new Html();
		$this->HTML_PARAMS				= ['error' => "hide", "note" => ""];
	}
	/**
	 * 	Метод GET
	 * 	Просмотр отдельной записи (по id)
	 * 	http://ДОМЕН/users/index.php || index.htm
	 */
	public function index()
	{

		#	Забираме данные пользователей
		$res = CURL::getUrlContent('http://web.aanda.ru/reports/?', "GET", ['mode' => 'StaffList']);
	//print_r($res);
	//die();
		$tableParams = $this->html->tableParams([
			'data-show-refresh' 	=> 'false'
			,'data-show-export' 	=> 'true'
			,'data-show-footer' 	=> 'true'
			,'data-pagination'		=>'true'
			,'data-url' 			=> self::$path_to_templates . '/data_table.json' // Забор данных
			//,'data-ajax' => "getDataAjaxToTable"
		], true);

		#	Собераем данные для страницы
		$this->HTML_PARAMS['tableParams'] = $tableParams;


		#	Нет ошибок
		if ($res['success'])
		{
			$permissions = ['show' => true, 'edit' => true, 'destroy' => true];
			foreach ($res['data'] as $k => $val) {
				$res['data'][$k]['action'] = $this->html->actionButton(
					'user'
					, $val['id']
					, $permissions
					, 'UsersList'
				);
			}
			#	Запишим данные в файл
			FILE::putFile(
				$this->ROOT_REST . $this->full_path_to_template . '/data_table.json'
				, json_encode($res['data'])
				, 'rewrite'
			);

			$this->HTML_PARAMS['pageTitle'] 	= $res['header']['title'];
			$this->HTML_PARAMS['columns'] 	= !empty($res['header']['columns'])
				? $this->html->tableBuildTH($res['header']['columns'], true)
				: [];

			if (file_exists($this->ROOT_REST . $this->full_path_to_template . "/table.htm"))
			{
				return $this->template($this->ROOT_REST . $this->full_path_to_template . "/table.htm", $this->HTML_PARAMS);
			}
			else
			{
				return $this->response('File not found to index()', 404);
			}
		}
		else
		{
			$this->HTML_PARAMS['error'] = "show";
			$this->HTML_PARAMS['note'] 	= $res['error']['note'];

			return $this->template(
				$this->ROOT_REST . $this->full_path_to_template . "/table.htm"
				, $this->HTML_PARAMS
			);
		}


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
	 * http://ДОМЕН/users/1
	 */
	public function view()
	{


		return $this->response('Data not found VIEW', 404);



	}
	/**
	 * Метод POST
	 * Создание новой записи
	 * http://ДОМЕН/users + параметры запроса name, email
	 * @return string
	 */
	public function create()
	{


		return $this->response("CREATE empty ", 500);


	}

	/**
	 * Метод PUT
	 * Обновление отдельной записи (по ее id)
	 * http://ДОМЕН/users/1 + параметры запроса name, email
	 * @return string
	 */
	public function update()
	{

		return $this->response("Update empty", 400);

	}
	/**
	 * Метод DELETE
	 * Удаление отдельной записи (по ее id)
	 * http://ДОМЕН/users/1
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