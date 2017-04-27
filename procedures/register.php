<?php
require __DIR__ . '/../inc/bootstrap.php';

$email = request()->get('email');
$name = request()->get('name');
$password = request()->get('password');
$confirmPassword = request()->get('confirm_password');

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $session->getFlashBag()->add('error', 'Invalid email.');
  redirect('/register.php');
}

if (strlen($password) < 6) {
  $session->getFlashBag()->add('error', 'Password must be six or more characters.');
  redirect('/register.php');
}

if ($password != $confirmPassword) {
  $session->getFlashBag()->add('error', 'Passwords don\'t match.');
  redirect('/register.php');
}

$user = findUserByEmail($email);

if (!empty($user)) {
  $session->getFlashBag()->add('error', 'User with that email already exists.');
  redirect('/register.php');
}

$hashed = password_hash($password, PASSWORD_DEFAULT);

$user = createUser($email, $name, $hashed);

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
