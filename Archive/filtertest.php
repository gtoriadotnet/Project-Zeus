<?php

use Zeus\ContentFilter;
use Zeus\PageSandboxer;

require_once($_SERVER['DOCUMENT_ROOT'] . '/../../Backend/Global.php');

$sandbox = new PageSandboxer;
$sandbox->CreateExceptionHandler();

$sandbox->RunSandbox(
	function()
	{
		header('content-type: text/plain');
		$list = 'bad word test list: _|3\|/ jev jaw fag faggot feggot faggy fagit faget fA993`/ faget fog foggy jew jewish auschwitz gas chamber heil hitler nigger nigga nig pee ngger ngga niiiiggggggggggeerrrrrrrrr nigge igger n1gger |\|1993.- n|gger 1993 joe mama';
		echo "$list\r\n";
		exit(ContentFilter::FilterMessage($list, false));
	},
	true
);
exit;