<?php
require_once __DIR__ . '/inc/bootstrap.php';
require_once __DIR__ . '/inc/head.php';
require_once __DIR__ . '/inc/nav.php';
?>
<div class="container">
    <div class="well">
        <h2>Restaurant List</h2>
      <?php echo display_success(); ?>
      <?php echo display_errors(); ?>

      <?php
      foreach(getAllRestaurants() as $restaurant) {
        include __DIR__ . '/inc/restaurant.php';
      }
      ?>

    </div>
</div>
<?php
require_once __DIR__ . '/inc/footer.php';
