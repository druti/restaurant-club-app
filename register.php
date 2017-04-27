<?php
require_once __DIR__ . '/inc/bootstrap.php';
require_once __DIR__ . '/inc/head.php';
require_once __DIR__ . '/inc/nav.php';
?>

<div class="container">
  <div class="well col-sm-6 col-sm-offset-3">
    <form class="form-signin" method="post" action="/procedures/register.php">
      <h2 class="form-signin-heading">Registration</h2>
      <?php echo display_success(); ?>
      <?php echo display_errors(); ?>
      <label for="inputEmail" class="sr-only">Email address</label>
      <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required autofocus>
      <br>
      <label for="inputName" class="sr-only">Name</label>
      <input type="text" id="inputName" name="name" class="form-control" placeholder="Name" required>
      <br>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
      <br>
      <label for="inputConfirmPassword" class="sr-only">Confirm Password</label>
      <input type="password" id="inputConfirmPassword" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
      <br>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
    </form>
  </div>
</div>

<?php require_once __DIR__ . '/inc/footer.php'; ?>
