<?php

namespace Zeus
{
	class IssuePage
	{
		static public function IssueEnv()
		{
			$config = json_decode(file_get_contents(__DIR__ . "/../../zeus.config"));
			return ['Name'=>$config->name, 'Domain'=>['Scheme'=>$config->domain->scheme, 'Url'=>$config->domain->host]];
		}
	}
}