<?php

namespace Zeus
{
	class IssuePage
	{
		static public function IssueEnv()
		{
			$config = json_decode(file_get_contents(__DIR__ . "/../../zeus.config"));
			$alert = $config->alert;
			if($config->offline == 'True')
			{
				$alert = [
					'active'=>'True',
					'message'=>$config->name . ' is currently under maintenance.',
					'type'=>3
				];
			}
			return ['Name'=>$config->name, 'Domain'=>['Scheme'=>$config->domain->scheme, 'Url'=>$config->domain->host], 'Alert'=>$alert];
		}
	}
}