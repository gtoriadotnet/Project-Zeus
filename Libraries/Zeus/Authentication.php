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
		
		public static function CheckIPBanStatus()
		{
			$db = new Database();
			$db = $db->dbConnection;
			
			$query = $db->prepare('SELECT `ip` FROM `ipbans` WHERE `ip`=:ip');
			$query->bindParam(':ip', API::GetIPAddress());
			$query->execute();
			$result = $query->fetch(\PDO::FETCH_ASSOC);
			
			if(!empty($result))
			{
				header('Accept-Ranges: bytes');
				header('Content-Length: 265366');
				header('Content-Range: bytes 0-265365/265366');
				header('Content-Type: video/mp4');
				header('Content-Disposition: inline; filename="Salutations.mp4"');
				header('ETag: "40c96-5bd71ce120fde"');
				header('Last-Modified: Sat, 13 Mar 2021 21:36:09 GMT');
				http_response_code(200);
				exit(file_get_contents(__DIR__ . '/../../Public/Cdn/MP4/Salutations.mp4'));
			}
		}
	}
}