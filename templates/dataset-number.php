<?php if (is_null($data)) die(); ?>

<?php
  $prefix = "";
  $suffix = "";
  if (array_key_exists("prefix",$atts))
    $prefix = $atts["prefix"];
  if (array_key_exists("suffix",$atts))
    $suffix = $atts["suffix"];
?>

<span class="wpckan_dataset_number">
  <?php echo $atts['count'] ?>
</span>
