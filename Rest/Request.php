<?php
/**************************************
 *
 * © 2018 Вишневецкий Роман Викторович
 * wwwdojdinawww@yandex.ru
 **************************************/

class Request
{
	public function __construct() {}
    /**
     * Получить путь запроса без строки запроса и имени выполняемого
     * скрипта
     * 
     * @return string
     */
    public function getPathInfo()
	{
        // получаем значения:
        // 
        // - URI без имени хоста
        // - строки запроса после ? 
        // - имя выполняемого скрипта
        $request_uri = $_SERVER['REQUEST_URI'];
        $query_string = $_SERVER['QUERY_STRING'];
        $script_name = $_SERVER['SCRIPT_NAME'];
        //die($request_uri);
        // извлекаем из URI путь запроса,
        $path_info = str_replace(
                '?' . $query_string, 
                '', $request_uri);
        $path_info = str_replace(
                $script_name, 
                '', $path_info);
        $path_info = trim($path_info, '/');

        // возвращаем результат
        return empty($path_info) ? '/' : $path_info;
    }
	public function all()
	{
		if ( !empty($_REQUEST) )
			return $_REQUEST;
		else
			return null;
	}
    /**
     * Поиск и получение значения параметра зпроса
     * по ключу
     * 
     * @param string $key               искомый ключ параметра запроса
     * @return mixed                    значение параметра 
     *                                  или null если параметр не существует
     */
    public function find($key)
	{
        if ( key_exists($key, $_REQUEST) )
            return $_REQUEST[$key];
        else
            return null;
    }
     
    /**
     * Проверяет существование параметра в запросе
     * по его ключу
     * 
     * @param string $key               проверяемый ключ
     * @return boolean
     */
    public function has($key)
    {
        return key_exists($key, $_REQUEST);
    }



	public function __destruct(){}
}