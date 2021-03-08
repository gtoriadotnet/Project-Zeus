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

if(API::GetSetting('offline')=='True')
{
	exit($twig->render('offline.html', ['pageTitle' => 'Maintenance', 'env' => IssuePage::IssueEnv()]));
}

if(strpos($_SERVER['REQUEST_URI'], '.php'))
{
	http_response_code(404);
	exit($twig->render('error.html', ['pageTitle' => 'Error', 'env' => IssuePage::IssueEnv(), 'responseCode' => 404]));
}