<?php

use Zeus\API;
use Zeus\Authentication;

require_once($_SERVER['DOCUMENT_ROOT'] . '/../../Backend/API.php');

// Expected format is:
//	{ "data" : 
//		[
//			{	"Value" : value,
//				"Scope" : scope,							
//				"Key" : key,
//				"Target" : target
//			}
//		]
//	}
// or for non-existing key:
// { "data": [] }

API::Respond(['Error'=>'The requested resource is not implemented yet.'], '501 Not Implemented');

Authentication::ValidateRCCAccessKey(); // add support for session cookies l8r, but also add a check to $_GET['placeId'] for if the user is allowed to access the asset

if(isset($_GET['placeId']) && isset($_GET['type']) && isset($_GET['scope']))
{
	$db = new Zeus\Database();
	$db = $db->dbConnection;
	
	
	$dataToReturn = [
		'data'=>[]
	];
	
	$db->prepare('SELECT `value`, `target`, `scope`, `key` FROM `datastores` WHERE `type`=:type AND `scope`=:scope AND `placeId`=:placeId;');
	$db->bindParam(':type', $_GET['type']);
	$db->bindParam(':scope', $_GET['scope']);
	$db->bindParam(':placeId', (int)$_GET['placeId']);
	$db->execute();
	$result = $db->fetch(PDO::FETCH_ASSOC);

	array_push($dataToReturn['data'], [['Value'=>$result['value'], 'Scope'=>$result['scope'], 'Key'=>$result['ley'], 'Target'=>$result['target']]]);
	
	API::Respond($dataToReturn, '200 OK');
}
else
{
	API::Respond(['error'=>'Client did not send a required query parameter.'], '403 Forbidden');
}