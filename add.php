<?php
require_once __DIR__ . '/inc/bootstrap.php';
requireAuth();

require_once __DIR__ . '/inc/head.php';
require_once __DIR__ . '/inc/nav.php';
?>
<div class="container">
  <div class="well">
    <form class="form-horizontal" method="post" action="procedures/addRestaurant.php">
      <h2>Add a restaurant</h2>
      <?php echo display_success(); ?>
      <?php echo display_errors(); ?>
      <?php include __DIR__ . '/inc/restaurantForm.php'; ?>
    </form>
  </div>
</div>
<?php
require_once __DIR__ . '/inc/footer.php';
