<?php

use Zeus\API;
use Zeus\PageSandboxer;

require_once(__DIR__ . '/../Backend/API.php');

$sandbox = new PageSandboxer;
$sandbox->CreateExceptionHandler();

$sandbox->RunSandbox(
	function()
	{
		$errors = [
			400=>'The requester returned a malformed request.',
			401=>'The requester is not authorized to access this resource.',
			403=>'The requester is forbidden from access this resource.',
			404=>'The requested resource was not found on this server.',
			500=>'An internal server error occurred whilst trying to process the request.'
		];

		$errorCodes = [
			400=>'400 Bad Request',
			401=>'401 Unauthorized',
			403=>'403 Forbidden',
			404=>'404 Not Found',
			500=>'500 Internal Server Error'
		];

		if(http_response_code()==200)
		{
			http_response_code(401);
		}

		API::Respond(['Error'=>$errors[http_response_code()]], $errorCodes[http_response_code()]);
	},
	true
);
exit;