<?php
/**************************************
 *
 * © 2019 Вишневецкий Роман Викторович
 * wwwdojdinawww@yandex.ru
 **************************************/

namespace RestFull
{
	class Autoloader
	{
		const debug = 0;// 1 дебаг включен
		const ROOT_REST = "/var/www/web.aanda.ru/public_html/new/";

		public function __construct(){

		}
		/*
		 * 	@file имя класса без разрешения
		 * */
		public static function autoload($file)
		{
			$_SESSION['__NAMESPACE__'] = __NAMESPACE__;
			$file = str_replace('\\', '/', $file);
			$path = Autoloader::ROOT_REST . 'Rest';
			$filepath = Autoloader::ROOT_REST . 'Rest/' . $file . '.php';

			if (file_exists($filepath))
			{
				if(Autoloader::debug) Autoloader::StPutFile(('подключили ' . $filepath));
				require_once($filepath);
			}
			else
			{
				$flag = true;
				if(Autoloader::debug) Autoloader::StPutFile(('начинаем рекурсивный поиск'));
				Autoloader::recursive_autoload($file, $path, $flag);
			}
		}

		public static function recursive_autoload($file, $path, $flag)
		{
			if (FALSE !== ($handle = opendir($path)) && $flag)
			{
				while (FAlSE !== ($dir = readdir($handle)) && $flag)
				{
					if (strpos($dir, '.') === FALSE)
					{
						$path2 = $path .'/' . $dir;
						$filepath = $path2 . '/' . $file . '.php';
						if(Autoloader::debug) Autoloader::StPutFile(('ищем файл <b>' .$file .'</b> in ' .$filepath));
						if (file_exists($filepath))
						{
							if(Autoloader::debug) Autoloader::StPutFile(('подключили ' .$filepath ));
							$flag = FALSE;
							require_once($filepath);
							break;
						}
						Autoloader::recursive_autoload($file, $path2, $flag);
					}
				}
				closedir($handle);
			}
		}

		private static function StPutFile($data)
		{
			$dir = Autoloader::ROOT_REST .'/log_rest/log.php';
			$file = fopen($dir, 'a');
			flock($file, LOCK_EX);
			fwrite($file, ($data . '=>' . date('d.m.Y H:i:s') . ' namespace ' . __NAMESPACE__ . ' ' . PHP_EOL));
			flock($file, LOCK_UN);
			fclose ($file);
		}

	}
	\spl_autoload_register('RestFull\Autoloader::autoload');
}
