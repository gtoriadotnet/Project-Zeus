<?php

use Zeus\API;
use Zeus\Authentication;

require($_SERVER['DOCUMENT_ROOT'] . '/../../Backend/API.php');

API::Respond(['Error'=>'The requested resource is not implemented yet.'], '501 Not Implemented');

Authentication::ValidateRCCAccessKey();