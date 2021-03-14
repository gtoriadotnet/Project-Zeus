<?php

use Zeus\IssuePage;
use Zeus\API;
use Zeus\Maintenance;
use Zeus\PageSandboxer;

require_once($_SERVER['DOCUMENT_ROOT'] . '/../../Backend/Global.php');

$sandbox = new PageSandboxer;
$sandbox->CreateExceptionHandler();

$sandbox->RunSandbox(
	function()
	{
		if(API::GetSetting('offline')=='True' && !Maintenance::CanPassthrough())
		{
			$pageIssuer = new IssuePage;
			$twig = $pageIssuer->FetchTwig();
			exit($twig->render('offline.html', ['pageTitle' => 'Site Offline', 'env' => IssuePage::IssueEnv()]));
		}
		else
		{
			if(isset($_GET['ReturnUrl']))
			{
				header('location: ' . urldecode($_GET['ReturnUrl']));
			}
			else
			{
				header('location: /');
			}
			exit;
		}
	},
	false
);
exit;