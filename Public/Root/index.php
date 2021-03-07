<?php

use Zeus\IssuePage;

require($_SERVER['DOCUMENT_ROOT'] . '/../../Backend/Global.php');

echo $twig->render('index.html', ['pageTitle' => 'Home', 'env' => IssuePage::IssueEnv()]);

?>