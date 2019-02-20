<?php if (is_null($data)) die(); ?>
<style>

.card {
	/*border: 1px solid black;*/
	background-color: #f7f9fb
}
</style>

<div class="container-fluid">
  <div class="row">
    <div >
      <?php foreach ($data as $dataset): ?>
        <div class="col-12">
        <?php echo "- <a href='/wordpress/group?group=".$dataset["name"]."'>".$dataset["display_name"]."(".$dataset["package_count"].")</a>";?>
	  </div>
      <?php endforeach; ?>
  </div>
</div>
</div>
