<?php

use Zeus\IssuePage;
use Zeus\PageSandboxer;

require_once($_SERVER['DOCUMENT_ROOT'] . '/../../Backend/Global.php');

$sandbox = new PageSandboxer;
$sandbox->CreateExceptionHandler();

$sandbox->RunSandbox(
	function()
	{
		$egg = $bruh;
	},
	false,
	$twig
);
exit($twig->render('index.html', ['pageTitle' => 'Home', 'env' => IssuePage::IssueEnv()]));

?>