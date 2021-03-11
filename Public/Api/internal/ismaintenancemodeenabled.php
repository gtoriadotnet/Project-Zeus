<?php

use Zeus\API;
use Zeus\PageSandboxer;

require_once($_SERVER['DOCUMENT_ROOT'] . '/../../Backend/API.php');

$sandbox = new PageSandboxer;
$sandbox->CreateExceptionHandler();

$sandbox->RunSandbox(
	function()
	{
		header('Access-Control-Allow-Origin: http://www.' . API::GetSetting('domain')['host']);
		header('Access-Control-Allow-Credentials: true');

		API::CheckMethod(['GET']);

		API::Respond(['offline'=>API::GetSetting('offline')], '200 OK');
		exit;
	},
	true
);
exit;