<?php
/**************************************
 *
 * © 2019 Вишневецкий Роман Викторович
 * wwwdojdinawww@yandex.ru
 **************************************/

namespace Traits
{
	class AutoloaderTraits
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
			$path = AutoloaderTraits::ROOT_REST . 'Traits';
			$filepath = AutoloaderTraits::ROOT_REST . 'Traits/' . $file . '.php';

			if (file_exists($filepath))
			{
				if(AutoloaderTraits::debug) AutoloaderTraits::StPutFile(('подключили ' . $filepath));
				require_once($filepath);
			}
			else
			{
				$flag = true;
				if(AutoloaderTraits::debug) AutoloaderTraits::StPutFile(('начинаем рекурсивный поиск'));
				AutoloaderTraits::recursive_autoload($file, $path, $flag);
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
						if(AutoloaderTraits::debug) AutoloaderTraits::StPutFile(('ищем файл <b>' .$file .'</b> in ' .$filepath));
						if (file_exists($filepath))
						{
							if(AutoloaderTraits::debug) AutoloaderTraits::StPutFile(('подключили ' .$filepath ));
							$flag = FALSE;
							require_once($filepath);
							break;
						}
						AutoloaderTraits::recursive_autoload($file, $path2, $flag);
					}
				}
				closedir($handle);
			}
		}

		private static function StPutFile($data)
		{
			$dir = AutoloaderTraits::ROOT_REST .'/log_rest/log.php';
			$file = fopen($dir, 'a');
			flock($file, LOCK_EX);
			fwrite($file, ($data . '=>' . date('d.m.Y H:i:s') . ' namespace ' . __NAMESPACE__ . ' ' . PHP_EOL));
			flock($file, LOCK_UN);
			fclose ($file);
		}

	}
	\spl_autoload_register('Traits\AutoloaderTraits::autoload');
}
