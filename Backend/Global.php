<?php

spl_autoload_register(function($cName)
{
	require_once(__DIR__ . '/../Libraries/' . $cName . '.php');
});

use Zeus\IssuePage;
use Zeus\API;
use Zeus\Maintenance;

$loader = new Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT'] . '/../../Templating');
$twig = new Twig\Environment($loader, [
    //'cache' => $_SERVER['DOCUMENT_ROOT'] . '/../../TwigCache',
]);

if((API::GetSetting('offline')=='True' && $_SERVER['SCRIPT_NAME'] != '/pages/maintenancerouter.php') && !Maintenance::CanPassthrough())
{
	$domain = API::GetSetting('domain');
	header('location: ' . $domain['scheme'] . '://www.' . $domain['host'] . '/login/maintenance?ReturnUrl=' . urlencode($domain['scheme'] . '://www.' . $domain['host'] . $_SERVER['REQUEST_URI']));
	exit;
}

$requri = $_SERVER['REQUEST_URI'];
$pos = strpos($requri, '?');
if(strpos(substr($requri, 0, ($pos ? $pos : null)), '.php'))
{
	http_response_code(404);
	require_once(__DIR__ . '/../Public/Root/Pages/error.php');
	exit;
}