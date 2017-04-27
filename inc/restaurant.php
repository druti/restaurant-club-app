<div class="media well">
    <?php if (isAuthenticated()): ?>
    <div class="media-left">
      <div class="btn-group-vertical" role="group">
        <a href="procedures/vote.php?vote=up&restaurantId=<?php echo $restaurant['id']; ?>">
        <span class="glyphicon glyphicon-triangle-top" <?php if ($restaurant['myVote'] == 1) echo 'style="color:orange"'; ?>></span>
        </a>
        <span><?php if (isset($restaurant['score'])) echo $restaurant['score']; else echo '0'; ?></span>
        <a href="procedures/vote.php?vote=down&restaurantId=<?php echo $restaurant['id']; ?>">
          <span class="glyphicon glyphicon-triangle-bottom" <?php if ($restaurant['myVote'] == -1) echo 'style="color:orange"'; ?>></span>
        </a>
      </div>
    </div>
    <?php endif; ?>
    <div class="media-body">
      <h4 class="media-heading"><?php echo $restaurant['name'] ?></h4>
      <p><?php echo $restaurant['description'] ?></p>
      <p>
        <span><a href="/edit.php?restaurantId=<?php echo $restaurant['id']; ?>">Edit</a> | </span>
        <span><a href="/procedures/deleteRestaurant.php?restaurantId=<?php echo $restaurant['id']; ?>">Delete</a></span>
      </p>
    </div>
</div>
