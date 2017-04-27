<?php
require_once __DIR__ . '/../inc/bootstrap.php';

$restaurantName = request()->get('name');
$restaurantDescription = request()->get('description');

try {
  $newRestaurant = addRestaurant($restaurantName, $restaurantDescription);

  $session->getFlashBag()->add('success', 'Restaurant saved successfully!');
  redirect('/restaurants.php');
} catch (\Exception $e) {
  $session->getFlashBag()->add('error', 'Oops something went wrong! Please try again.');
  redirect('/add.php');
}
