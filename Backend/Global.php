<?php
$loader = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT'] . '/../../Templating');
$twig = new \Twig\Environment($loader, [
    'cache' => $_SERVER['DOCUMENT_ROOT'] . '/../../TwigCache',
]);