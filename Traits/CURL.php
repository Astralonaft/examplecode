<?php


trait CURL
{
	public static function getUrlContent($url, $method = 'GET', $params, $json = true)
	{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //Устанавливаем параметр, чтобы curl возвращал данные, вместо того, чтобы выводить их в браузер.

		if ($method == "POST")
		{
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params, '', '&'));
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		}

		if ($method == "GET")
		{
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_URL, $url . http_build_query($params, '', '&'));
		}

		$data = curl_exec($ch);
		curl_close($ch);

		if ($json)
			return json_decode($data, true);
		else
			return $data;
	}
}