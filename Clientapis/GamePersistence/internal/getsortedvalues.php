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

Authentication::ValidateRCCAccessKey();

if(isset($_GET['placeId']) && isset($_GET['type']) && isset($_GET['scope']) && isset($_GET['key']) && isset($_GET['pageSize']) && isset($_GET['ascending']))
{
	$db = new Zeus\Database();
	$db = $db->dbConnection;
	API::Respond(['data'=>['Entries'=>[['Target']=>'target_here', 'Value'=>0],[['Target']=>'target_here', 'Value'=>0]], 'ExclusiveStartKey'=>'ThisKeyGoesToPageTwo'], '200 OK');
}
else
{
	API::Respond(['error'=>'Client did not send a required query parameter.'], '403 Forbidden');
}