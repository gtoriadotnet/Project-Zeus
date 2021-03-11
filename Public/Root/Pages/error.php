<?php

use Zeus\IssuePage;

require_once($_SERVER['DOCUMENT_ROOT'] . '/../../Backend/Global.php');

exit($twig->render('error.html', ['pageTitle' => 'Error', 'env' => IssuePage::IssueEnv(), 'responseCode' => http_response_code()]));

?>