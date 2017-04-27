<?php
require __DIR__ . '/inc/bootstrap.php';
require_once __DIR__ . '/inc/head.php';
require_once __DIR__ . '/inc/nav.php';
?>
<div class="container">
  <div class="well">
    <h2>Restaurant Voting System</h2>
    <?php echo display_success(); ?>
    <?php echo display_errors(); ?>
    <p>Welcome to the restaurant voting system.  Use this system to submit restaurant you like and see if others like them as well
    by letting them upvote it.</p>
    <form class="form-horizontal" method="get" action="userList.php">
      <h2>Search Users</h2>
      <?php include __DIR__ . '/inc/searchUserForm.php'; ?>
    </form>
  </div>
</div>
<?php
require_once __DIR__ . '/inc/footer.php';
