<?php

spl_autoload_register(function($cName)
{
	require(__DIR__ . '/../Libraries/' . $cName . '.php');
});

use Zeus\IssuePage;
use Zeus\API;

$loader = new Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT'] . '/../../Templating');
$twig = new Twig\Environment($loader, [
    //'cache' => $_SERVER['DOCUMENT_ROOT'] . '/../../TwigCache',
]);

if(API::GetSetting('offline')=='True' && $_SERVER['SCRIPT_NAME'] != '/pages/maintenancerouter.php')
{
	$domain = API::GetSetting('domain');
	header('location: ' . $domain['scheme'] . '://www.' . $domain['host'] . '/login/maintenance?ReturnUrl=' . urlencode($domain['scheme'] . '://www.' . $domain['host'] . $_SERVER['REQUEST_URI']));
	exit;
}

if(strpos($_SERVER['REDIRECT_URL'], '.php'))
{
	http_response_code(404);
	exit($twig->render('error.html', ['pageTitle' => 'Error', 'env' => IssuePage::IssueEnv(), 'responseCode' => 404]));
}