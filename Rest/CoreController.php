<?php
/**************************************
* 
* © 2018 Вишневецкий Роман Викторович
* wwwdojdinawww@yandex.ru
*
	TODO Построение и развертывание REST-API
 * установка Bullet и Eloquent
	https://www.ibm.com/developerworks/ru/library/wa-deployrest-app/

	TODO Использование Accept Header для версионирования API
	https://habr.com/post/240817/

	TODO Примеры REST запросов
	GET /api/users — получить список пользователей;
	GET /api/users/123 — получить указанного пользователя;
	POST /api/users — создать нового пользователя;
	PUT /api/users/123 — обновить все данные указанного пользователя;
	PATCH /api/users/123 — частично обновить данные пользователя;
	DELETE /api/users/123 — удалить пользователя.
	https://noteskeeper.ru/1161/
	
**************************************/

class CoreController  extends Api
{
	public static $controllername = 'CoreController';
	
	public function __construct($Request)
	{
		$this->Request 		= $Request;
		$this->ROOT_REST 	= "/var/www/web.aanda.ru/public_html/new/";
	}
	/*
	 * 		<HEAD>
	 * */
	public function mainHead($TITLE, $HTTP, $HTTP_HOST, $JS = "", $CSS = "")
	{
		return $this->template($this->ROOT_REST . "layouts/head.php"
			, [
				'TITLE' => $TITLE
				, 'HTTP' => $HTTP
				, 'HTTP_HOST' => $HTTP_HOST
				, 'JS' => $JS
				, 'CSS' => $CSS
			]);
	}
	public function mainFooter($TITLE, $HTTP, $HTTP_HOST, $JS = "")
	{
		return $this->template($this->ROOT_REST . "layouts/foot.php", ['TITLE' => $TITLE, 'HTTP' => $HTTP, 'HTTP_HOST' => $HTTP_HOST, 'JS' => $JS]);
	}
	public function mainMenu()
	{
		return $this->template($this->ROOT_REST . "layouts/menu.htm", []);
	}


	public function pageHeader()
	{
		return $this->template($this->ROOT_REST . "main/header.html", []);
	}

	public function getRootRest()
	{
		return $this->ROOT_REST;
	}
    /**
	 *
     * @return string
     */
    public function index()
    {
		return $this->template($this->ROOT_REST . "main/main.html", ['info' => 'В разработке!']);
		//return $this->response('Data not found INDEX', 404);
    }
    /**
     * Метод GET
     * Просмотр отдельной записи (по id)
     * @return string
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

	}

	public function __destruct(){}
}