<?php

spl_autoload_register(function($cName)
{
	require(__DIR__ . '/../Libraries/' . $cName . '.php');
});

use Zeus\API;

if(API::GetSetting('offline')=='True' && $_SERVER['SCRIPT_NAME'] != '/internal/ismaintenancemodeenabled.php' && $_SERVER['SCRIPT_NAME'] != '/internal/maintenancepassthrough.php')
{
	API::Respond(['Error'=>'Service Undergoing Maintenance'], '503 Service Unavailable');
}

if(strpos($_SERVER['REDIRECT_URL'], '.php'))
{
	API::Respond(['Error'=>'The requested resource was not found.'], '404 Not Found');
}