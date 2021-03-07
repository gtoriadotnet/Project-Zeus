<?php

namespace Zeus
{
	class Authentication
	{
		public static function ValidateRCCAccessKey()
		{
			if(!isset($_SERVER['HTTP_ACCESSKEY']) && $_SERVER['HTTP_ACCESSKEY'] != API::GetSetting('keys')['rccaccess'])
			{
				API::Respond(['Error'=>'The client is not authorized to access the requested resource.'], '403 Forbidden');
			}
		}
		
		public static function ValidateAPIKey($channel)
		{
			$keys = API::GetSetting('keys');
		}
	}
}