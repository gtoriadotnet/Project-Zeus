<?php

use Zeus\API;

require($_SERVER['DOCUMENT_ROOT'] . '/../../Backend/API.php');

API::CheckMethod(['GET']);

API::Respond(['offline'=>API::GetSetting('offline')], '200 OK');