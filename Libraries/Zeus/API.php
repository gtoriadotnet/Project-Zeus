<?php

namespace Zeus
{
	class API
	{
		public static $MaintenanceHeader = '_|DO-NOT-SHARE-THIS-COOKIE--THIS-COOKIE-ALLOWS-ACCESS-TO-THE-SITE-WHILE-UNDER-MAINTENANCE-|';
		
		public static function Respond($responseArray, $responseStatus)
		{
			header('HTTP/1.1 ' . $responseStatus);
			header('Content-Type: Application/JSON');
			exit(json_encode($responseArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK));
		}
		
		public static function GenerateGUID()
		{
			return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
		}
		
		public static function IsCloudflareConnection()
		{
			$ipRanges = [
				'173.245.',
				'103.21.',
				'103.22.',
				'103.31.',
				'141.101.',
				'108.162.',
				'190.93.',
				'188.114.',
				'197.234.',
				'198.41.',
				'162.158.',
				'104.16.',
				'172.64.',
				'172.69.',
				'131.0.'
			];
			foreach($ipRanges as $range)
			{
				if(str_starts_with($_SERVER['REMOTE_ADDR'], $range))
				{
					return true;
				}
			}
			return false;
		}
		
		public static function GetIPAddress()
		{
			if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && API::IsCloudflareConnection())
			{
				return $_SERVER['HTTP_X_FORWARDED_FOR'];
			}
			else
			{
				return $_SERVER['REMOTE_ADDR'];
			}
		}
		
		public static function CheckMethod($methods)
		{
			if(!in_array($_SERVER['REQUEST_METHOD'], $methods))
			{
				API::Respond(['Error'=>'This API cannot be accessed using the requested method: ' . $_SERVER['REQUEST_METHOD']], '405 Method Not Allowed');
			}
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