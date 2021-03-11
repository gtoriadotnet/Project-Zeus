<?php

spl_autoload_register(function($cName)
{
	require_once(__DIR__ . '/../Libraries/' . $cName . '.php');
});

use Zeus\API;
use Zeus\Maintenance;

if((API::GetSetting('offline')=='True' && $_SERVER['SCRIPT_NAME'] != '/internal/ismaintenancemodeenabled.php' && $_SERVER['SCRIPT_NAME'] != '/internal/maintenancepassthrough.php') && !Maintenance::CanPassthrough())
{
	API::Respond(['Error'=>'Service Undergoing Maintenance'], '503 Service Unavailable');
}

$requri = $_SERVER['REQUEST_URI'];
$pos = strpos($requri, '?');
if(strpos(substr($requri, 0, ($pos ? $pos : null)), '.php'))
{
	http_response_code(404);
	require_once(__DIR__ . '/../Clientapis/ApiErrorShared.php');
}