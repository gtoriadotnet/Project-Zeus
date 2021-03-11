<?php

namespace Zeus
{
	class PageSandboxer
	{
		public function handleException($severity, $message, $filename, $lineno)
		{
			throw new \ErrorException($message, 0, $severity, $filename, $lineno);
		}
		
		public function CreateExceptionHandler()
		{
			set_error_handler(array($this, 'handleException'));
		}
		
		public function RunSandbox($sandboxedFunction, $isApi)
		{
			try
			{
				$sandboxedFunction();
			}
			catch(\ErrorException $e)
			{
				$debugEnabled = API::GetSetting('debug') == 'True';
				
				if($isApi)
				{
					if($debugEnabled)
					{
						API::Respond(['Error'=>'An internal server error occurred whilst trying to process the request.', 'Trace'=>$e->getTraceAsString()], '500 Internal Server Error');
						exit;
					}
					else
					{
						http_response_code(500);
						require_once(__DIR__ . '/../../Clientapis/ApiErrorShared.php');
						exit;
					}
				}
				else
				{
					if($debugEnabled)
					{
						$pageIssuer = new IssuePage;
						$twig = $pageIssuer->FetchTwig();
						exit($twig->render('error.html', ['pageTitle' => 'Error', 'env' => IssuePage::IssueEnv(), 'responseCode' => 500, 'trace' => $e->getTraceAsString()]));
					}
					else
					{
						http_response_code(500);
						require_once(__DIR__ . '/../../Public/Root/Pages/error.php');
						exit;
					}
				}
			}
		}
	}
}