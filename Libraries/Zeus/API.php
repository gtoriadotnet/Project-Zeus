<?php

namespace Zeus
{
	class API
	{
		public static function Respond(responseArray, responseStatus)
		{
			header('HTTP/1.1 ' . responseStatus);
			header('Content-Type: Application/JSON');
			exit(json_encode(responseArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK))
		}
		
		public static function GetSetting($setting)
		{
			$file = @file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/../../zeus.config');
			if(!$file)
			{
				API::Respond(['Error'=>'Failure whilst fetching web setting configuration.'], '500 Internal Server Error');
			}
			
			$settings = @json_decode($file, true);
			if($settings == false)
			{
				API::Respond(['Error'=>'Web settings returned invalid JSON.'], '500 Internal Server Error');
			}
			
			if(isset($settings[$setting]))
			{
				return $settings[$setting];
			}
			else
			{
				API::Respond(['Error'=>'Failure whilst fetching web setting.'], '500 Internal Server Error');
			}
		}
	}
}