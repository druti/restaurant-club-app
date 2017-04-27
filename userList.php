<?php
require_once __DIR__ . '/inc/bootstrap.php';
requireAuth();

require_once __DIR__ . '/inc/head.php';
require_once __DIR__ . '/inc/nav.php';

$searchQuery = request()->get('q');
?>
<div class="container">
  <div class="well">
    <h2>Search</h2>
    <?php echo display_success(); ?>
    <?php echo display_errors(); ?>
    <div class="panel">
      <h4>Users</h4>
      <table class="table table-striped">
      <thead>
      <tr>
        <th>Email</th>
        <th>Name</th>
        <th>Registered</th>
      </tr>
      </thead>
      <tbody>
        <?php foreach (getSearchUsers($searchQuery) as $user): ?>
        <tr>
          <td><?php echo $user['email']; ?></td>
          <td><?php echo $user['name']; ?></td>
          <td><?php echo $user['created_at']; ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
      </table>
    </div>
  </div>
</div>
<?php
require_once __DIR__ . '/inc/footer.php';
