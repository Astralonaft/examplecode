<?php
/**************************************
* 
* © 2018 Вишневецкий Роман Викторович
* wwwdojdinawww@yandex.ru
* https://klisl.com/php-api-rest.html
**************************************/


abstract class Api
{
    public $apiName 		= '';
    protected $method 		= ''; //GET|POST|PUT|DELETE
    public $requestUri 		= [];
    public $requestParams 	= [];
    protected $action 		= ''; //Название метод для выполнения

    public function __construct() 
	{
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

    }

	public function template($view, $data)
	{
		extract($data);

		ob_start();

		require $view;

		$output = ob_get_clean();

		return $output;
	}

    public function run() 
	{
		#	URI преобразуем в массив
		$this->requestUri = explode('/', trim($_SERVER['REQUEST_URI'],'/'));
		$this->requestParams = $_REQUEST;
		#	Присваиваем метода запроса
		$this->method = $_SERVER['REQUEST_METHOD'];




		#	Определение метода запроса
		if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER))
		{
			if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE')
			{
				$this->method = 'DELETE';
			}
			else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT')
			{
				$this->method = 'PUT';
			}
			else
			{
				throw new Exception("Unexpected Header");
			}
		}



		if (empty($this->requestUri))
		{
			throw new RuntimeException(' Rest\Api.php $this->requestUri array empty', 404);
		}
        #	Определение действия для обработки
        $this->action = $this->getAction();
        #	Если метод(действие) определен в дочернем классе API
        if (method_exists($this, $this->action))
        {
            return $this->{$this->action}();
        }
        else
        {
            throw new RuntimeException('Invalid Method (нет метода - ' . $this->action . ' в классе)', 405); // http://php.net/manual/ru/class.runtimeexception.php
        }
    }

    protected function response($str, $status = 200)
	{
        //header($status . " " . $this->requestStatus($status));
		$data = [];
		$data['responseStr'] = $str;
		$data['responseStatus'] = $this->requestStatus($status);
        return json_encode($data);
    }

    private function requestStatus($code) 
	{
        $status = array(
            200 => 'OK',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
            555 => 'Undefined Error'
        );
        return !empty($status[$code]) ? $status[$code] : $status[555];
    }

    protected function getAction()
    {
        switch ($this->method) {
            case 'GET':

				#   web.aanda.ru / $this->requestUri[0] / $this->requestUri[1] / $this->requestUri[2]
				if (!empty($this->requestUri[2]))
				{
					return 'view';
				}
				if (!empty($this->requestUri[1]))
				{
					return 'index';
				}
				if (!empty($this->requestUri[0]))
				{
					return 'index';
				}
                break;

            case 'POST':
                return 'create';
                break;

            case 'PUT':
                return 'update';
                break;

            case 'DELETE':
                return 'delete';
                break;

            default:
                return null;
        }
    }

    abstract protected function index();
    abstract protected function view();
    abstract protected function create();
    abstract protected function update();
    abstract protected function delete();
	abstract protected function AjaxHandler();

}
