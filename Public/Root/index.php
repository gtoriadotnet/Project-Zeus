<?php

require($_SERVER["DOCUMENT_ROOT"] . "/../../Backend/Global.php");

echo $twig->render('index.html', ['pageTitle' => 'Test', 'env' => ['Name'=>'Project Zeus', 'Domain'=>['Scheme'=>'http', 'Url'=>'zeus.local']]]);

?>