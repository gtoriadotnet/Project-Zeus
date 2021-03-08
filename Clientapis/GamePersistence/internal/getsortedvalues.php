<?php

use Zeus\API;
use Zeus\Authentication;

require($_SERVER['DOCUMENT_ROOT'] . '/../../Backend/API.php');

//		Expected format:
// 		{ "data": { "Entries": [{
// 			"Target": "player_1552168488",
// 				"Value": 0
// 		}, {
// 			"Target": "player_1931069815",
// 				"Value": 1
// 		}, {
// 			"Target": "player_221169702",
// 				"Value": 2
// 			}, {
// 				"Target": "player_299777679",
// 					"Value": 3
// 			}, {
// 				"Target": "player_1692004196",
// 					"Value": 4
// 			}],
// 			"ExclusiveStartKey": "player_1692004196$4" }}

API::Respond(['Error'=>'The requested resource is not implemented yet.'], '501 Not Implemented');

Authentication::ValidateRCCAccessKey(); // add support for session cookies l8r, but also add a check to $_GET['placeId'] for if the user is allowed to access the asset

if(isset($_GET['placeId']) && isset($_GET['type']) && isset($_GET['scope']) && isset($_GET['key']) && isset($_GET['pageSize']) && isset($_GET['ascending']))
{
	$db = new Zeus\Database();
	$db = $db->dbConnection;
	
	$offset = '0';
	
	$dataToReturn = [
		'data'=>[
			'Entries'=>[]
		],
		'ExclusiveStartKey'=>null
	];
	
	if(isset($_GET['exclusiveStartKey']))
	{
		$db->prepare('SELECT `id`, `offset` FROM `ordereddskeys` WHERE `key`=:key;');
		$db->bindParam(':key', $_GET['exclusiveStartKey']);
		$db->execute();
		$result = $db->fetch(PDO::FETCH_ASSOC);
		
		if(!empty($result))
		{
			$offset = $result['offset'];
			$db->prepare('DEELTE FROM `ordereddskeys` WHERE `id`=:id');
			$db->bindParam(':id', $result['id']);
			$db->execute();
		}
	}
	
	$db->prepare('SELECT `value`, `target` FROM `datastores` WHERE `type`=:type AND `key`=:key AND `scope`=:scope AND `placeId`=:placeId OFFSET :offset ROWS FETCH NEXT :pageSize ROWS ONLY ORDER BY `value` ' . (strtolower($_GET['ascending']) == 'true' ? 'ASC;' : 'DESC;'));
	$db->bindParam(':type', $_GET['type']);
	$db->bindParam(':key', $_GET['key']);
	$db->bindParam(':scope', $_GET['scope']);
	$db->bindParam(':placeId', (int)$_GET['placeId']);
	$db->bindParam(':offset', (int)$offset);
	$db->bindParam(':pageSize', (int)$_GET['pageSize']);
	$db->execute();
	$result = $db->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($result as $dbresult)
	{
		array_push($dataToReturn['data']['Entries'], ['Target'=>$dbresult['target'], 'Value'=>$dbresult['value']]);
	}
	
	API::Respond($dataToReturn, '200 OK');
}
else
{
	API::Respond(['error'=>'Client did not send a required query parameter.'], '403 Forbidden');
}