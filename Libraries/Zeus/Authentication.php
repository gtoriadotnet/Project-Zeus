<?php

namespace Zeus
{
	class Authentication
	{
		private $RCCAccessKey = API::GetSetting('keys')['rccaccess'];
		
		public static function ValidateRCCAccessKey()
		{
			if(!isset($_SERVER['HTTP_ACCESSKEY']) && $_SERVER['HTTP_ACCESSKEY'] != $RCCAccessKey)
			{
				API::Respond(['Error'=>'The client is not authorized to access the requested resource.'], '403 Forbidden');
			}
		}
	}
}