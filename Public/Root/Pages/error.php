<?php

use Zeus\IssuePage;

require($_SERVER["DOCUMENT_ROOT"] . "/../../Backend/Global.php");

echo $twig->render('error.html', ['pageTitle' => 'Error', 'env' => IssuePage::IssueEnv(), 'responseCode' => http_response_code()]);

?>