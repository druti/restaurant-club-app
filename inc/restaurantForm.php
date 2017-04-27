<div class="form-group">
  <label for="name" class="col-sm-2 control-label">Name</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="name" name="name" placeholder="Restaurant Name" value="<?php if (isset($restaurantName)) echo $restaurantName; ?>">
  </div>
</div>
<div class="form-group">
  <label for="description" class="col-sm-2 control-label">Description</label>
  <div class="col-sm-10">
    <textarea name="description" class="form-control" rows="5" placeholder="Description of the restaurant"><?php if (isset($restaurantDescription)) echo $restaurantDescription; ?></textarea>
  </div>
</div>
<div class="form-group">
  <div class="col-sm-offset-2 col-sm-10">
    <button type="submit" class="btn btn-default">
      <?php if (isset($buttonText)) echo $buttonText; else echo 'Add Restaurant'; ?>
    </button>
  </div>
</div>
