<?php 

/**
 * @return \Symfony\Component\HttpFoundation\Request
 */
function request() {
    return \Symfony\Component\HttpFoundation\Request::createFromGlobals();
}

function addRestaurant($name, $description) {
  global $db;
  $ownerId = 0;

  try {
    $query = 'INSERT INTO restaurants (name, description, owner_id) VALUES (:name, :description, :ownerId)';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':ownerId', $ownerId);
    return $stmt->execute();
  } catch (\Exception $e) {
    throw $e;
  }
}

function updateRestaurant($id, $name, $description) {
  global $db;

  try {
    $query = 'UPDATE restaurants SET name=:name, description=:description WHERE id=:restaurantId';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':restaurantId', $id);
    return $stmt->execute();
  } catch (\Exception $e) {
    throw $e;
  }
}

function deleteRestaurant($id) {
  global $db;

  try {
    $query = 'DELETE FROM restaurants WHERE id = ?';
    $stmt = $db->prepare($query);
    $stmt->bindParam(1, $id);
    return $stmt->execute();
  } catch (\Exception $e) {
    throw $e;
  }
}

function getAllRestaurants() {
  global $db;

  $userId = 0;

  if (isAuthenticated()) {
    $userId = decodeJwt('sub');
  }

  try {
    $query = 'SELECT restaurants.*, sum(votes.value) as score, '
      . ' (SELECT value FROM votes '
      . ' WHERE votes.restaurant_id=restaurants.id '
      . ' AND votes.user_id=:userId) as myVote '
      . ' FROM restaurants '
      . ' LEFT JOIN votes ON (restaurants.id = votes.restaurant_id) '
      . ' GROUP BY restaurants.id '
      . ' ORDER BY score DESC';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
    return $stmt->fetchAll();
  } catch (\Exception $e) {
    throw $e;
  }
}

function getRestaurant($id) {
  global $db;

  $query = 'SELECT * FROM restaurants WHERE id = ?';
  $stmt = $db->prepare($query);
  $stmt->bindParam(1, $id);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
  try {
  } catch (\Exception $e) {
    throw $e;
  }
}

function vote($restaurantId, $score) {
  global $db;
  $userId = decodeJwt('sub');

  try {
    $query = 'INSERT INTO votes (restaurant_id, user_id, value) VALUES (:restaurantId, :userId, :score)';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':restaurantId', $restaurantId);
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':score', $score);
    $stmt->execute();
  } catch (\Exception $e) {
    die('Something happened with voting. Please try again.');
  }
}

function clearVote($restaurantId) {
  global $db;

  $userId = decodeJwt('sub');

  try {
    $query = 'DELETE FROM votes WHERE restaurant_id = :restaurantId AND user_id = :userId';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':restaurantId', $restaurantId);
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
    return $stmt->rowCount();
  } catch (\Exception $e) {
    throw $e;
  }
}

function redirect($path, $extra = []) {
  $response = \Symfony\Component\HttpFoundation\Response::create(null, \Symfony\Component\HttpFoundation\Response::HTTP_FOUND, ['Location' => $path]);

  if (key_exists('cookies', $extra)) {
    foreach ($extra['cookies'] as $cookie) {
      $response->headers->setCookie($cookie);
    }
  }

  $response->send();
  exit;
}

function getAllUsers() {
  global $db;

  try {
    $query = 'SELECT * FROM users';
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (\Exception $e) {
    throw $e;
  }
}

function getSearchUsers($search) {
  global $db;

  try {
    $query = "SELECT * FROM users WHERE email LIKE '%$search%' OR name LIKE '%$search%'";
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (\Exception $e) {
    throw $e;
  }
}

function findUserByEmail($email) {
  global $db;

  try {
    $query = 'SELECT * FROM users WHERE email = :email';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  } catch (\Exception $e) {
    throw $e;
  }
}

function findUserByAccessToken() {
  global $db;

  try {
    $userId = decodeJwt('sub');
  } catch (\Exception $e) {
    throw $e;
  }

  try {
    $query = 'SELECT * FROM users WHERE id = :userId';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  } catch (\Exception $e) {
    throw $e;
  }
}

function createUser($email, $name, $password) {
  global $db;

  try {
    $query = 'INSERT INTO users (email, name, password, role_id) VALUES (:email, :name, :password, 2)';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    return findUserByEmail($email);
  } catch (\Exception $e) {
    throw $e;
  }
}

function updatePassword($password, $userId) {
  global $db;

  try {
    $query = 'UPDATE users SET password = :password WHERE id = :userId';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
  } catch (\Exception $e) {
    return false;
  }

  return true;
}

function promote($userId) {
  global $db;

  try {
    $query = 'UPDATE users SET role_id=1 WHERE id = :userId';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
  } catch (\Exception $e) {
    throw $e;
  }
}

function demote($userId) {
  global $db;

  try {
    $query = 'UPDATE users SET role_id=2 WHERE id = :userId';
    $stmt = $db->prepare($query);
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
  } catch (\Exception $e) {
    throw $e;
  }
}

function decodeJwt($prop = null) {
  \Firebase\JWT\JWT::$leeway = 1;
  $jwt = \Firebase\JWT\JWT::decode(
    request()->cookies->get('access_token'),
    getenv('SECRET_KEY'),
    ['HS256']
  );

  if ($prop === null) {
    return $jwt;
  }

  return $jwt->{$prop};
}

function isAuthenticated() {
  if (!request()->cookies->has('access_token')) {
    return false;
  }

  try {
    decodeJwt();
    return true;
  } catch (\Exception $e) {
    return false;
  }
}

function requireAuth() {
  if (!isAuthenticated()) {
    $cookieDomain = (getenv('HOST') != 'localhost') ? getenv('HOST') : false;
    $accessToken = new \Symfony\Component\HttpFoundation\Cookie("access_token", "Expired", time()-3600, '/', $cookieDomain);
    redirect('/login.php', ['cookies' => [$accessToken]]);
  }
}

function requireAdmin() {
  global $session;

  if (!isAuthenticated()) {
    $cookieDomain = (getenv('HOST') != 'localhost') ? getenv('HOST') : false;
    $accessToken = new \Symfony\Component\HttpFoundation\Cookie("access_token", "Expired", time()-3600, '/', $cookieDomain);
    redirect('/login.php', ['cookies' => [$accessToken]]);
  }

  try {
    if (!decodeJwt('is_admin')) {
      $session->getFlashBag()->add('error', 'Not Authorized');
      redirect('/');
    }
  } catch (\Exception $e) {
    $cookieDomain = (getenv('HOST') != 'localhost') ? getenv('HOST') : false;
    $accessToken = new \Symfony\Component\HttpFoundation\Cookie("access_token", "Expired", time()-3600, '/', $cookieDomain);
    redirect('/login.php', ['cookies' => [$accessToken]]);
  }
}

function isAdmin() {
  if (!isAuthenticated()) {
    return false;
  }

  try {
    $isAdmin = decodeJwt('is_admin');
  } catch (\Exception $e) {
    return false;
  }

  return (boolean)$isAdmin;
}

function isOwner($ownerId) {
  if (!isAuthenticated()) {
    return false;
  }

  try {
    $userId = decodeJwt('sub');
  } catch (\Exception $e) {
    return false;
  }

  return $ownerId == $userId;
}

function display_errors() {
  global $session;
  if (!$session->getFlashBag()->has('error')) {
    return;
  }

  $messages = $session->getFlashBag()->get('error');

  $response = '<div class="alert alert-danger alert-dismissable">';
  foreach ($messages as $message) {
    $response .= "{$message}<br />";
  }
  $response .= '</div';

  return $response;
}

function display_success() {
  global $session;
  if (!$session->getFlashBag()->has('success')) {
    return;
  }

  $messages = $session->getFlashBag()->get('success');

  $response = '<div class="alert alert-success alert-dismissable">';
  foreach ($messages as $message) {
    $response .= "{$message}<br />";
  }
  $response .= '</div';

  return $response;
}
