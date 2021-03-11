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
		
		static public function GetExceptionTraceAsString($exception) {
			$rtn = "";
			$count = 0;
			foreach ($exception->getTrace() as $frame)
			{
				$args = "";
				if (isset($frame['args']))
				{
					$args = array();
					foreach ($frame['args'] as $arg)
					{
						if (is_string($arg))
						{
							$args[] = "'" . $arg . "'";
						}
						elseif (is_array($arg))
						{
							$args[] = "Array";
						}
						elseif (is_null($arg))
						{
							$args[] = 'NULL';
						}
						elseif (is_bool($arg))
						{
							$args[] = ($arg) ? "true" : "false";
						}
						elseif (is_object($arg))
						{
							$args[] = get_class($arg);
						}
						elseif (is_resource($arg))
						{
							$args[] = get_resource_type($arg);
						}
						else
						{
							$args[] = $arg;
						}   
					}   
					$args = join(", ", $args);
				}
				$rtn .= sprintf( "#%s %s(%s): %s(%s)\n",
				$count,
				isset($frame['file']) ? $frame['file'] : 'unknown file',
				isset($frame['line']) ? $frame['line'] : 'unknown line',
				(isset($frame['class']))  ? $frame['class'].$frame['type'].$frame['function'] : $frame['function'], $args );
				$count++;
			}
			return $rtn;
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
						API::Respond(['Error'=>'An internal server error occurred whilst trying to process the request.', 'Trace'=>PageSandboxer::GetExceptionTraceAsString($e)], '500 Internal Server Error');
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
						exit($twig->render('error.html', ['pageTitle' => 'Error', 'env' => IssuePage::IssueEnv(), 'responseCode' => 500, 'trace' => PageSandboxer::GetExceptionTraceAsString($e)]));
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