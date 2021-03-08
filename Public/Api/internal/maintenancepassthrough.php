<?php

use Zeus\API;

require($_SERVER['DOCUMENT_ROOT'] . '/../../Backend/API.php');

header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Origin: http://www.' . API::GetSetting('domain')['host']);
header('Access-Control-Allow-Headers: http://www.' . API::GetSetting('domain')['host']);

API::CheckMethod(['POST']);

$password = API::GetSetting('keys')['maintenance'];

if($_POST['password']==$password && $_POST['letter']=='U')
{
	$cookie = hash('sha512', API::GenerateGUID());
	
	$db = new Zeus\Database();
	$db = $db->dbConnection;
	
	$query = $db->prepare('INSERT INTO `maintenancepassthroughkeys`(`cookie`, `ip`) VALUES (:cookie, :addy)');
	$query->bindParam(':cookie', $cookie);
	$query->bindParam(':addy', API::GetIPAddress());
	$query->execute();
	
	$domain = API::GetSetting('domain');
	
	header('Set-Cookie: .ZEUSMAINTENANCEPASSTHROUGH=_|DO-NOT-SHARE-THIS-COOKIE--THIS-COOKIE-ALLOWS-ACCESS-TO-THE-SITE-WHILE-UNDER-MAINTENANCE-|' . $cookie . '; Domain=zeus.local; SameSite=Strict; Path=/; Expires=' . str_replace('+0000', 'GMT', gmdate('r', time()+(60*60*24))));
	
	API::Respond(['Success'=>'True', 'Error'=>null], '200 OK');
}
else
{
	API::Respond(['Success'=>'False', 'Error'=>'Incorrect password.'], '403 Forbidden');
}
