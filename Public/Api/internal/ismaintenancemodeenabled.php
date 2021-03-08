<?php

use Zeus\API;

require($_SERVER['DOCUMENT_ROOT'] . '/../../Backend/API.php');

header('Access-Control-Allow-Origin: http://www.' . API::GetSetting('domain')['host']);

API::CheckMethod(['GET']);

API::Respond(['offline'=>API::GetSetting('offline')], '200 OK');