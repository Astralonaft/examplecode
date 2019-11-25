<?php


trait FILE
{
	public static function putFile($path, $data, $fopenmode = 'rewrite')
	{
		//chmod($path, 0777);
		$file = fopen($path, self::fMode($fopenmode));
		flock($file, LOCK_EX);
		fwrite($file, $data);
		flock($file, LOCK_UN);
		fclose ($file);
	}

	private static function fMode($fopenmode)
	{
		$mode = [
			'rewrite' => 'w+'
			,'append' => 'a+'
		];

		return !empty($mode[$fopenmode]) ? $mode[$fopenmode] : false;
	}

}