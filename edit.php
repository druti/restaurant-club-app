<?php
require_once __DIR__ . '/inc/bootstrap.php';
requireAuth();

require_once __DIR__ . '/inc/head.php';
require_once __DIR__ . '/inc/nav.php';

$restaurant = getRestaurant(request()->get('restaurantId'));

if (!isAdmin() && !isOwner($restaurant['owner_id'])) {
  $session->getFlashBag()->add('error', 'Not Authorized');
  redirect('/restaurants.php');
}

$restaurantName = $restaurant['name'];
$restaurantDescription = $restaurant['description'];
$buttonText = 'Update Restaurant';
?>
<div class="container">
  <div class="well">
    <form class="form-horizontal" method="post" action="procedures/editRestaurant.php">
      <h2>Update restaurant</h2>
      <?php echo display_success(); ?>
      <?php echo display_errors(); ?>
      <input type="hidden" name="restaurantId" value="<?php echo $restaurant['id']; ?>" />
      <?php include __DIR__ . '/inc/restaurantForm.php'; ?>
    </form>
  </div>
</div>
<?php
require_once __DIR__ . '/inc/footer.php';
