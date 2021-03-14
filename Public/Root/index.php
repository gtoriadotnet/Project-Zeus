<?php

use Zeus\IssuePage;
use Zeus\PageSandboxer;

require_once($_SERVER['DOCUMENT_ROOT'] . '/../../Backend/Global.php');

$sandbox = new PageSandboxer;
$sandbox->CreateExceptionHandler();

$sandbox->RunSandbox(
	function()
	{
		$pageIssuer = new IssuePage;
		$twig = $pageIssuer->FetchTwig();
		exit($twig->render('index.html', ['pageTitle' => 'Home', 'env' => IssuePage::IssueEnv()]));
	},
	false
);
exit;