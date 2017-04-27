<?php
require_once __DIR__ . '/../inc/bootstrap.php';
requireAuth();

$restaurantId = request()->get('restaurantId');
$restaurant = getRestaurant($restaurantId);

if (!isAdmin() && !isOwner($restaurant['owner_id'])) {
  $session->getFlashBag()->add('error', 'Not Authorized');
  redirect('/restaurants.php');
}

try {
  $deletedRestaurant = deleteRestaurant($restaurantId);

  $session->getFlashBag()->add('success', 'Restaurant deleted successfully!');
  redirect('/restaurants.php');
} catch (\Exception $e) {
  $session->getFlashBag()->add('error', 'Oops something went wrong! Please try again.');
  redirect('/edit.php?restaurantId='.$restaurantId);
}
