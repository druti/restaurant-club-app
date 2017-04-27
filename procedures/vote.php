<?php
require_once __DIR__ . '/../inc/bootstrap.php';

$vote = request()->get('vote');
$restaurantId = request()->get('restaurantId');

if (!clearVote($restaurantId)) {
  switch (strtolower($vote)) {
    case 'up':
      vote($restaurantId, 1);
      break;
    case 'down':
      vote($restaurantId, -1);
      break;
  }
}

redirect('/restaurants.php');
