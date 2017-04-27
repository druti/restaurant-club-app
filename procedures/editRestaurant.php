<?php
require_once __DIR__ . '/../inc/bootstrap.php';

$restaurantId = request()->get('restaurantId');
$restaurantName = request()->get('name');
$restaurantDescription = request()->get('description');

try {
  $newRestaurant = updateRestaurant($restaurantId, $restaurantName, $restaurantDescription);

  $session->getFlashBag()->add('success', 'Restaurant saved successfully!');
  redirect('/restaurants.php');
} catch (\Exception $e) {
  $session->getFlashBag()->add('error', 'Oops something went wrong! Please try again.');
  redirect('/edit.php?restaurantId='.$restaurantId);
}
