<?php if (is_null($data)) die(); ?>
<style>

.card {
	/*border: 1px solid black;*/
	background-color: #f7f9fb
}
</style>

<div class="container-fluid">
  <div class="row">
    <div>
      <?php foreach ($data as $dataset): ?>
        <div class="col-12">
        <?php echo "- <a href='/wordpress/group?q=tags:".$dataset["display_name"]."'>".$dataset["display_name"]."(".$dataset["count"].")</a>";?>
	  </div>
      <?php endforeach; ?>
      <?php
      $tam = sizeof($data);
      if($tam < 11){
        echo "<div class='col-12'>+ <a href='/wordpress/all-tags'>Mostrar Más...</a></div>";
      }?>
  </div>
</div>
</div>
