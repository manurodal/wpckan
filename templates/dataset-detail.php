<?php if (is_null($data)) {
    die();
} ?>

<?php
  $supported_fields_csv = $GLOBALS['wpckan_options']->get_option('wpckan_setting_supported_fields');
  $supported_fields = explode(',', $supported_fields_csv);
	$supported_fields_additional_csv = $GLOBALS['wpckan_options']->get_option('wpckan_setting_supported_fields_additional');
  $supported_fields_additional = explode(',', $supported_fields_additional_csv);
	$current_language = wpckan_get_current_language();
  $dataset_id = $data['id']; ?>

  <style>

  .wrapper {
      max-width:340px;
      min-height: 50px;
      padding-top:20px;
  }

  .tag {
    float:left;
    margin:0 0 7px 20px;
    position:relative;

    font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;
    font-size:0.75em;
    font-weight:bold;
    text-decoration:none;

    color:#996633;
    text-shadow:0px 1px 0px rgba(255,255,255,.4);

    padding:0.417em 0.417em 0.417em 0.917em;

    border:1px solid #d99d38;

    -webkit-border-radius:0.25em 0.25em 0.25em 0.25em;
    -moz-border-radius:0.25em 0.25em 0.25em 0.25em;
    border-radius:0.25em 0.25em 0.25em 0.25em;

    background-image: -webkit-linear-gradient(top, rgb(254, 218, 113), rgb(254, 186, 71));
    background-image: -moz-linear-gradient(top, rgb(254, 218, 113), rgb(254, 186, 71));
    background-image: -o-linear-gradient(top, rgb(254, 218, 113), rgb(254, 186, 71));
    background-image: -ms-linear-gradient(top, rgb(254, 218, 113), rgb(254, 186, 71));
    background-image: linear-gradient(top, rgb(254, 218, 113), rgb(254, 186, 71));
    filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,StartColorStr='#feda71', EndColorStr='#feba47');

    -webkit-box-shadow:
        inset 0 1px 0 #faeaba,
        0 1px 1px rgba(0,0,0,.1);
    -moz-box-shadow:
        inset 0 1px 0 #faeaba,
        0 1px 1px rgba(0,0,0,.1);
    box-shadow:
        inset 0 1px 0 #faeaba,
        0 1px 1px rgba(0,0,0,.1);

    z-index:100;
}

  </style>

<div class="wpckan_dataset_detail">

	<!-- Title or title_translated in case of multilingual dataset-->
	<?php
    $title = wpckan_get_multilingual_value('title',$data);
    $groups = '';
    if(isset($data['groups'])){
      foreach($data['groups'] as $group):
        $groups.='&nbsp;<img width="32px" height="32px" src="'.$group['image_display_url'].'">&nbsp;';
      endforeach;
    }
  ?>
	<h1 class="wpckan_dataset_title"><?php echo $title.$groups ?></h1>

  <!-- Notes or notes_translated in case of multilingual dataset -->
  <?php
    $notes = wpckan_get_multilingual_value('notes',$data);?>
	  <p class="wpckan_dataset_notes expandible"><?php echo $notes ?></p>
    <?php
    if(!isset($dataset["openess_score"])){
      echo "<div><span>Grado de apertura: </span>";
      for($i=0; $i<5; $i++){
        if($i < 3 /*$dataset["openess_score"]*/)
          echo "<span><image src='/wordpress/wp-content/uploads/2019/02/estrella.png'></span>&nbsp;";
        else {
          echo "<span><image src='/wordpress/wp-content/uploads/2019/02/estrellavacia.png'></span>&nbsp;";
        }
      }
      echo "</div>";
    }?>
	<!-- Organization -->
  <?php if (isset($data['organization']['title'])): ?>
    <div>
      <span class="wpckan_dataset_organization">Autor: <?php _e($data['organization']['title'], 'wpckan') ?></span>
    </div>
  <?php endif; ?>
  <!-- metadata_created -->
  <?php if (isset($data['metadata_created'])): ?>
    <div>
      <span class="wpckan_dataset_notes">Fecha creación: <?php _e($data['metadata_created'], 'wpckan') ?></span>
    </div>
  <?php endif; ?>
  <!-- metadata_modified -->
  <?php if (isset($data['metadata_modified'])): ?>
    <div>
      <span class="wpckan_dataset_notes">Fecha última modificación: <?php _e($data['metadata_modified'], 'wpckan') ?></span>
    </div>
  <?php endif; ?>

  <!-- License -->
  <?php if (isset($data['license_title'])): ?>
    <span>Licencia: <a href="<?php echo $data['license_url'] ?>" class="wpckan_dataset_license"> <?php echo $data['license_title'] ?></a></span>
  <?php endif; ?>

  <!-- separator -->
  <hr style="margin-top: 30px;">

	<!-- Tags -->
  <h3><?php _e('Etiquetas', 'wpckan') ?></h3>
  <div class="wrapper">
    <?php foreach ($data['tags'] as $tag): ?>
      <a href="/wordpress/group?q=tags:<?php echo $tag['name']?>" class="tag"><?php echo apply_filters('translate_term', $tag['display_name'], $current_language); ?></a>
    <?php endforeach; ?>
  </div>

  <!-- separator -->
  <hr style="margin-top: 30px;">

  <!-- Resources -->
	<h3><?php _e('Distribuciones', 'wpckan') ?></h3>
	<table class="wpckan_dataset_resources">
    <?php foreach ($data['resources'] as $resource): ?>
  		<tr class="wpckan_dataset_resource">
        <td class="wpckan_dataset_resource_name">
					<?php
					$resource_title = $resource['name'];
					if (array_key_exists('name_translated', $resource)):
	            if (array_key_exists($current_language, $resource['name_translated'])):
	                $resource_title = !empty($resource['name_translated'][$current_language]) ? $resource['name_translated'][$current_language] : $resource['name_translated']['en'];
	            endif;
	        endif;
          ?>
          <h3><?php echo ($resource_title !="EIA")? $resource_title : $title; ?></h3>
					<?php
					$resource_description = $resource['description'];
					if (array_key_exists('description_translated', $resource)):
	            if (array_key_exists($current_language, $resource['description_translated'])):
	                $resource_description = !empty($resource['description_translated'][$current_language]) ? $resource['description_translated'][$current_language] : $resource['description_translated']['en'];
	            endif;
	        endif; ?>
          <p class="expandible"><?php echo ($resource_description !="asdf")? $resource_description: ''; ?></p>
        </td>
        <td class="wpckan_dataset_resource_format" format="<?php echo $resource['format']; ?>"><?php if (isset($resource['format'])): ?>
          <p format="<?php echo $resource['format']; ?>"><?php echo $resource['format']; ?></p>
        <?php endif; ?></td>
        <td class="wpckan_dataset_resource_url"><?php if (isset($resource['url'])): ?>
          <a style="background-color: rgba(251,51,51);" class="wpckan_dataset_resource_url button download" href="<?php echo $resource['url']; ?>" data-ga-event="Dataset|resource_download|<?php echo $dataset_id.'/'.$resource['id']; ?>"><span><i class="fa fa-download"></i></span></a>
        <?php endif; ?></td>
  		</tr>
    <?php endforeach; ?>
  </table>

	<!-- Metadata -->
  <div class="row">
	<h2 class="col-12"><?php _e('Metadata', 'wpckan') ?></h2>
  <div class="col-12" style="padding-bottom: 10px;">Descargar metadatos:</div>
</div>
  <div class="row" style="padding-bottom: 20px;">
      <div class="col-4">- <a target="_blank" href="<?php echo wpckan_get_ckan_domain(); ?>/dataset/<?php echo $dataset_id;?>.xml" data-ga-event="Dataset|metadata_download|<?php echo $dataset_id; ?>/xml"><?php _e('XML', 'odm')?></a></div>
      <div class="col-4">- <a target="_blank" href="<?php echo wpckan_get_ckan_domain(); ?>/api/3/action/package_show?id=<?php echo $dataset_id;?>" data-ga-event="Dataset|metadata_download|<?php echo $dataset_id; ?>/json"><?php _e('JSON', 'odm')?></a></div>
      <div class="col-4">- <a target="_blank" href="<?php echo wpckan_get_ckan_domain(); ?>/dataset/<?php echo $dataset_id;?>.rdf" data-ga-event="Dataset|metadata_download|<?php echo $dataset_id; ?>/rdf"><?php _e('RDF', 'odm')?></a></div>
  </div>

	<!-- <?php
		if (!empty($supported_fields)): ?>
	    <?php
				echo render_metadata_table($supported_fields,$data); ?>
	<?php
endif; ?>

	<?php
    $additional_metadata = render_metadata_table($supported_fields_additional,$data);
		if (!empty($supported_fields_additional) && $additional_metadata): ?>
			<div class="slideable">
				<h5><?php _e('View additional metadata', 'wpckan') ?></h5>
				<div class="slideable-content">
			    <?php
						echo $additional_metadata; ?>
				</div>
			</div>
    <br />
	<?php
endif; ?> -->

</div>

<?php
function render_metadata_table($supported_fields,$data){

	$field_mappings = wpckan_parse_field_mappings('wpckan_setting_field_mappings');
  $field_mappings_values = wpckan_parse_field_mappings('wpckan_setting_field_mappings_values');
	$supported_datatables = wpckan_parse_field_mappings('wpckan_setting_supported_datatables');
	$linked_fields_csv = $GLOBALS['wpckan_options']->get_option('wpckan_setting_linked_fields');
  $linked_fields = explode(',', $linked_fields_csv);
  $current_language = wpckan_get_current_language();

  $show_content = false;
  $html_content = null;

	$html_content = '<table class="wpckan_dataset_metadata_fields">' ?>
  <?php
      $metadata_available = false;
      if (!empty($supported_fields)): ?>
      <?php
        foreach ($supported_fields as $key):
          $html_content .= '<tr class="wpckan_dataset_metadata_field">';?>
          <?php
          $mapped_key = isset($field_mappings[$key]) ? trim($field_mappings[$key]," ") : $key;
          $mapped_value = "";
          if (array_key_exists($key,$data) && isset($data[$key])):
            $value = $data[$key];

            if (array_key_exists($key, $supported_datatables) && !empty($supported_datatables[$key])):
              $resource_id = $supported_datatables[$key];
              $ids = is_array($value) ? $value : explode(',', $value);
              if (count($ids) > 0):
                $metadata_available = true;
                foreach($ids as $id):
                  $results = wpckan_get_datastore_resources_filter(wpckan_get_ckan_domain(),$resource_id,"id",$id);
                  if(isset($results[0])):
                    $result = $results[0];
                    $mapped_value = $mapped_value . $result["name"];
                    if ($id !== end($ids)):
                      $mapped_value = $mapped_value . ", ";
                    endif;
                  endif;
                endforeach;
              endif;
            elseif (is_array($value) && array_key_exists($current_language, $value) && !empty($value)):
              $value = !empty($value[$current_language]) ? $value[$current_language] : $value["en"];
              $mapped_value = isset($field_mappings_values[$value]) ? $field_mappings_values[$value] : $value;
              if (!empty($mapped_value)):
                $metadata_available = true;
              endif;
            else:
              $value = $data[$key];
              if (is_array($value)):
                $value = implode(', ', $value);
              endif;
              if (!empty($value)):
                $mapped_value = isset($field_mappings_values[$value]) ? $field_mappings_values[$value] : $value;
                $metadata_available = true;
              endif;
            endif;
          endif; ?>

          <?php
            if (wpckan_is_date($mapped_value)):
              $parsed_date = date_parse($mapped_value);
              $monthName = date('M', mktime(0, 0, 0, $parsed_date["month"], 10));
              $mapped_value =  $parsed_date["day"] . " " . $monthName . " " . $parsed_date["year"];
            endif;
          ?>

          <?php
          if (!empty($mapped_value)):
            $show_content = true;
            if (in_array($key,$linked_fields)):
              $html_content .= '<td><p>'.__($mapped_key, 'wpckan').'</p></td>';
              $html_content .= '<td><p class="expandible"><a target="_blank" href="' . wpckan_get_link_to_dataset($mapped_value) . '"</a>' . $mapped_value .'</p></td>';
            else:
              $html_content .= '<td><p>'.__($mapped_key, 'wpckan').'</p></td>';
              $html_content .= '<td><p class="expandible">'.__($mapped_value, 'wpckan').'</p></td>';
            endif;
          endif;
          ?>

          </tr>
        <?php
        endforeach; ?>

  <?php endif;
  $html_content .= '</table>';

  if ($show_content):
    return $html_content;
  endif;

  return null;
}

?>
<script>
  //Send GA Event
  jQuery(function(){
    ga('send', 'event', 'Dataset', 'view', '<?php echo $dataset_id; ?>');
  });
</script>
