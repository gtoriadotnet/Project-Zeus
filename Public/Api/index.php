<?php

use Zeus\API;
use Zeus\PageSandboxer;

require_once($_SERVER['DOCUMENT_ROOT'] . '/../../Backend/API.php');

$sandbox = new PageSandboxer;
$sandbox->CreateExceptionHandler();

$sandbox->RunSandbox(
	function()
	{
		require_once($_SERVER['DOCUMENT_ROOT'] . '/../../Clientapis/ApiErrorShared.php');
		exit;
	},
	true
);
exit;