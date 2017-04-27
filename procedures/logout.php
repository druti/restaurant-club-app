<?php
require __DIR__ . '/../inc/bootstrap.php';

$cookieDomain = (getenv('HOST') != 'localhost') ? getenv('HOST') : false;
$accessToken = new \Symfony\Component\HttpFoundation\Cookie("access_token", "Expired", time()-3600, '/', $cookieDomain);
$session->getFlashBag()->add('success', 'Goodbye!');
redirect('/login.php', ['cookies' => [$accessToken]]);
