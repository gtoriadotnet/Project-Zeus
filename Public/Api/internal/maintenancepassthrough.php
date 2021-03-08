<?php

use Zeus\API;

require($_SERVER['DOCUMENT_ROOT'] . '/../../Backend/API.php');

API::CheckMethod(['POST']);

$password = API::GetSetting('keys')['maintenance'];

if($_POST['password']==$password)
{
	$cookie = API::GenerateGUID();
	
	$db = new Zeus\Database();
	$db = $db->dbConnection;
	
	$db->prepare('INSERT INTO `maintenancepassthroughkeys`(`cookie`, `ip`) VALUES (:cookie, :addy)');
	$db->bindParam(':cookie', hash('sha512', $cookie));
	$db->bindParam(':addy', API::GetIPAddress());
	$db->execute();
	
	$domain = API::GetSetting('domain');
	
	header('Set-Cookie: .ZEUSMAINTENANCEPASSTHROUGH="_|DO-NOT-SHARE-THIS-COOKIE--THIS-COOKIE-ALLOWS-ACCESS-TO-THE-SITE-WHILE-UNDER-MAINTENANCE-|' . $cookie . '"; SameSite=None; Domain=*.' . $domain['host'] . '; HttpOnly' . ($domain['scheme'] == 'https' ? '; Secure' : ''));
	
	API::Respond(['Success'=>'True', 'Error'=>null], '200 OK');
}
else
{
	API::Respond(['Success'=>'False', 'Error'=>'Incorrect password.'], '403 Forbidden');
}
