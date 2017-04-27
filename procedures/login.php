<?php
require __DIR__ . '/../inc/bootstrap.php';

if (!filter_var(request()->get('email'), FILTER_VALIDATE_EMAIL)) {
  $session->getFlashBag()->add('error', 'Invalid email');
  redirect('/login.php');
}

if (strlen(request()->get('password')) < 6) {
  $session->getFlashBag()->add('error', 'Invalid password');
  redirect('/login.php');
}

$user = findUserByEmail(request()->get('email'));
if (empty($user)) {
  $session->getFlashBag()->add('error', 'That email password combination does not match our records.');
  redirect('/login.php');
}

if (!password_verify(request()->get('password'), $user['password'])) {
  $session->getFlashBag()->add('error', 'That email password combination does not match our records.');
  redirect('/login.php');
}

$expTime = time() + 3600;

$jwt = \Firebase\JWT\JWT::encode([
  'iss' => request()->getBaseUrl(),
  'sub' => "{$user['id']}",
  'exp' => $expTime,
  'iat' => time(),
  'nbf' => time(),
  'is_admin' => $user['role_id'] == 1
], getenv('SECRET_KEY'), 'HS256');

$cookieDomain = (getenv('HOST') != 'localhost') ? getenv('HOST') : false;
$accessToken = new Symfony\Component\HttpFoundation\Cookie('access_token', $jwt, $expTime, '/', $cookieDomain);

$session->getFlashBag()->add('success', 'Welcome '.$user['name'].'!');
redirect('/', ['cookies' => [$accessToken]]);
