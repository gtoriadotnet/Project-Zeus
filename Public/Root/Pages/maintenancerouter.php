<?php

use Zeus\IssuePage;
use Zeus\API;
use Zeus\Maintenance;

require($_SERVER['DOCUMENT_ROOT'] . '/../../Backend/Global.php');

if(API::GetSetting('offline')=='True' && !Maintenance::CanPassthrough())
{
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

?>