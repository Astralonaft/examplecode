<?php
/*
 * 		TODO объявляем для статических методов так ---  CoreController::class;
 * */


class user extends Api
{
	use CURL, FILE;

	public static $controllername = 'user';
	private static $path_to_templates = 'templates';

	public function __construct(Request $Request, $ROOT_REST)
	{
		$this->Request 					= $Request; 	// Вопрос
		$this->full_path_to_template 	= self::$controllername . "/" . self::$path_to_templates;
		$this->ROOT_REST 				= $ROOT_REST;
		$this->html						= new Html();
		$this->HTML_PARAMS				= ['error' => "hide"];
		$this->RETURN_AJAX				= [
			'error' => false
			, 'description' => ""
			, 'data' => []
		];
	}
	/**
	 * 	Метод GET
	 * 	Просмотр отдельной записи (по id)
	 * 	http://ДОМЕН/users/index.php || index.htm
	 */
	public function index()
	{
		#	Забираме данные пользователей
		$res = CURL::getUrlContent('http://web.aanda.ru/reports/?', "GET", ['mode' => 'UsersList']);
		#	Нет ошибок
		if ($res['success'])
		{
			#	Аттрибуты таблицы
			$tableParams = $this->html->tableParams([
				'data-show-refresh' 	=> 'false'
				,'data-show-export' 	=> 'true'
				,'data-show-footer' 	=> 'false'
				,'data-pagination'		=> 'true'
				,'data-url' 			=> self::$path_to_templates . '/data_table.json' // Забор данных
				,'data-toolbar'         => '#toolbar'
			], true);

			#	Управление видимостью основных кнопок строки таблицы в колонка "Действия"
			#	TODO Должно быть автоматизировано под роли и привелегии
			$permissions = ['show' => true, 'edit' => true, 'destroy' => true];
			foreach ($res['data'] as $k => $val)
			{
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

			#	Собераем данные для страницы
			$this->HTML_PARAMS['tableParams'] 	= $tableParams;
			$this->HTML_PARAMS['title'] 		= $res['header']['title'];
			$this->HTML_PARAMS['columns'] 		= $this->html->tableBuildTH($res['header']['columns'], true);
			$this->HTML_PARAMS['select_roles'] = [
				0 => "Выбрать"
				,1 => "Роль 1"
				,2 => "Роль 2"
				,3 => "Роль 3"
			];// TODO Загушка ролей

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
	}
	/**
	 * Метод GET
	 * Просмотр отдельной записи (по id)
	 * http://ДОМЕН/users/1
	 */
	public function view()
	{
		$id = $this->Request->find('user_id');
		#	Забираме данные пользователей
		$result = CURL::getUrlContent('http://web.aanda.ru/reports/?', "GET", ['mode' => 'UserDetail', 'id' => $id]);
		if ($result['success'])
		{
			if (!empty($result['data'][0]))
			{
				$data = $result['data'][0];
				$this->RETURN_AJAX['data']['user'] = [
					'user_id' 			=> $data['id']
					,'name' 			=> $data['name']
					,'surname' 			=> $data['lastname']
					,'patronymic' 		=> $data['patronymic']
					,'birthday' 		=> '00-00-0000'
					,'time_work_start' 	=> $data['time_work_start']
					,'time_work_end' 	=> $data['time_work_end']
					,'email' 			=> $data['email']
					,'mailto' 			=> 'mailto:' . $data['email']
					,'phone' 			=> '0(000)000-00-00'
					,'phone_mobile' 	=> '0(000)000-00-00'
					,'phone_dop' 		=> '0000'
					,'skype' 			=> $data['skype']
					,'image'			=> 'https://wpnovin.com/wp-content/uploads/2018/07/profile-default-lrg.png' // TODO Временная аватарка
					,'image_name' 		=> ''
					,'system_access' 	=> 1
					,'office' 			=> $data['office']
					,'post' 			=> $data['post']
					,'status' 			=> $data['status']
				];
			}
		}
		return $this->RETURN_AJAX;
	}

	public function getDataBeforeCreate()
	{

		$this->RETURN_AJAX['description'] = "Получены данные для интерфейса!<ul><li>Офисы</li><li>Должности</li><li>Отделы</li></ul>";

		//--------------------------------------------------------
		$options_office = [
			['id' => 0, 'text' => "Выбрать"]
			,['id' => 47, 'text' => "Москва"]
			,['id' => 65, 'text' => "Санкт-Петербург"]
			,['id' => 71, 'text' => "Нижний Новгород"]
		];
		$this->RETURN_AJAX['data']['select_office'] = [
			'selectID' => 'SelectOffice'
			,'myClass' => 'selectpicker show-tick'
			,'vModel' => 'office_id'
			,'Name' => 'office_id'
			,'selectedValue' => '0'
			,'options' => $options_office
		];
		//--------------------------------------------------------
		$options_positions = [
			['id' => 0, 'text' => "Выбрать"]
			,['id' => 5, 'text' => "Программист"]
			,['id' => 23, 'text' => "Бухгалтер"]
			,['id' => 25, 'text' => "Кассир"]
			,['id' => 27, 'text' => "Контент-менеджер"]
		];
		$this->RETURN_AJAX['data']['select_position'] = [
			'selectID' => 'SelectPost'
			,'myClass' => 'selectpicker show-tick'
			,'vModel' => 'position_id'
			,'Name' => 'position_id'
			,'selectedValue' => '0'
			,'options' => $options_positions
		];
		//--------------------------------------------------------
		$options_departments = [
			['id' => 0, 'text' => "Выбрать"]
			,['id' => 2, 'text' => "Бухгалтерия"]
			,['id' => 3, 'text' => "Электро"]
			,['id' => 4, 'text' => "IT"]
		];
		$this->RETURN_AJAX['data']['select_departments'] = [
			'selectID' => 'SelectDepartment'
			,'myClass' => 'selectpicker show-tick'
			,'vModel' => 'department_id'
			,'Name' => 'department_id'
			,'selectedValue' => '0'
			,'options' => $options_departments
		];

		return $this->RETURN_AJAX;
	}
	/**
	 * Метод POST
	 * Создание новой записи
	 * http://ДОМЕН/users + параметры запроса name, email
	 * @return string
	 */
	public function create()
	{
		$this->RETURN_AJAX['description'] = "Заглушка create()";
		$this->RETURN_AJAX['data'] = $this->Request->all();
		return $this->RETURN_AJAX;
	}

	/**
	 * Метод PUT
	 * Обновление отдельной записи (по ее id)
	 * http://ДОМЕН/users/1 + параметры запроса name, email
	 * @return string
	 */
	public function update()
	{
		$this->RETURN_AJAX['description'] = "Заглушка update()";
		$this->RETURN_AJAX['data'] = $this->Request->all();
		return $this->RETURN_AJAX;

	}
	/**
	 * Метод DELETE
	 * Удаление отдельной записи (по ее id)
	 * http://ДОМЕН/users/1
	 * @return string
	 */
	public function delete()
	{


		return "DELETE";


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