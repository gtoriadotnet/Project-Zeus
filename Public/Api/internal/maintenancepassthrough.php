<?php

use Zeus\API;
use Zeus\PageSandboxer;

require_once($_SERVER['DOCUMENT_ROOT'] . '/../../Backend/API.php');

$sandbox = new PageSandboxer;
$sandbox->CreateExceptionHandler();

$sandbox->RunSandbox(
	function()
	{
		$domain = API::GetSetting('domain');
		header('Access-Control-Allow-Credentials: true');
		header('Access-Control-Allow-Origin: ' . $domain['scheme'] . '://www.' . $domain['host']);
		header('Access-Control-Allow-Headers: ' . $domain['scheme'] . '://www.' . $domain['host']);

		API::CheckMethod(['POST']);

		$keys = API::GetSetting('keys');

		if($_POST['password']==$keys['maintenance'] && $_POST['letter']==$keys['maintenanceletter'])
		{
			$cookie = hash('sha512', API::GenerateGUID());
			$ip = API::GetIPAddress();
			
			$db = new Zeus\Database();
			$db = $db->dbConnection;
			
			$query = $db->prepare('INSERT INTO `maintenancepassthroughkeys`(`cookie`, `ip`) VALUES (:cookie, :addy)');
			$query->bindParam(':cookie', $cookie);
			$query->bindParam(':addy', $ip);
			$query->execute();
			
			$domain = API::GetSetting('domain');
			
			header('Set-Cookie: .ZEUSMAINTENANCEPASSTHROUGH=' . API::$MaintenanceHeader . $cookie . '; Domain=' . $domain['host'] . '; SameSite=Strict; Path=/; Expires=' . str_replace('+0000', 'GMT', gmdate('r', time()+(60*60*24))));
			
			API::Respond(['Success'=>'True', 'Error'=>null], '200 OK');
			exit;
		}
		else
		{
			API::Respond(['Success'=>'False', 'Error'=>'Incorrect password.'], '403 Forbidden');
			exit;
		}
	},
	true
);
exit;