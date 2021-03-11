<?php

use Zeus\IssuePage;

require_once($_SERVER['DOCUMENT_ROOT'] . '/../../Backend/Global.php');

exit($twig->render('index.html', ['pageTitle' => 'Home', 'env' => IssuePage::IssueEnv()]));

?>