<?php if (is_null($data)) die(); ?>

<?php
if (array_key_exists("related_dataset",$atts)):
  $count = count($atts["related_dataset"]);
endif;
if (array_key_exists("count",$atts)):
  $count = $atts["count"];
endif;

$target_blank_enabled = $GLOBALS['wpckan_options']->get_option('wpckan_setting_target_blank_enabled');
$current_language = wpckan_get_current_language();

?>
<style>

.card {
  /*border: 1px solid black;*/
  background-color: #f7f9fb;
}

.resource-JSON {
  color: green;
}

.resource-GeoJSON {
  color: orange;
}

[data-toggle="collapse"] .fa:before {
  content: "\f139";
}

[data-toggle="collapse"].collapsed .fa:before {
  content: "\f13a";
}

.btn-link{
  color: white;
  text-align: left;
  width: 100%;
}

.card-header{
  background-color: rgba(221,51,51);
}

.btn-primary{
  background-color: rgba(221,51,51);
  margin-bottom: 20px;
}

</style>
<div class="container-fluid">
  <div class="row">
    <div class="col-12 d-lg-none d-inline text-center">
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalFilter">
        Filtros
      </button>

      <!-- Modal -->
      <div class="modal fade text-left" id="modalFilter" tabindex="-1" role="dialog" aria-labelledby="modalFilter"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modaltitle">Filtros</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row content">
              <div id="accordion" style="width:100%;">
                <div class="card">
                  <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                      <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">               <i class="fa" aria-hidden="true"></i>
                        Etiquetas
                      </button>
                    </h5>
                  </div>
                  <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                      <?php echo do_shortcode( ' [wpckan_10_tags_user limit="10"] ' );?>
                    </div>
                  </div>
                </div>
              <div class="card">
                <div class="card-header" id="headingTwo">
                  <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      <i class="fa" aria-hidden="true"></i>
                      Formatos
                    </button>
                  </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                  <div class="card-body">
                    <?php echo do_shortcode( ' [wpckan_10_tags_user limit="10"] ' );?>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header" id="headingThree">
                  <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                      <i class="fa" aria-hidden="true"></i>
                      Grupos
                    </button>
                  </h5>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                  <div class="card-body">
                    <?php echo do_shortcode( ' [wpckan_groups_filter] ' );?>
                  </div>
                </div>
              </div>
            </div>

          </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-12 col-lg-9">
    <div class="row content">
      <?php foreach ($data as $dataset): ?>
        <?php echo "<script>console.log('Debug Objects: " . json_encode($dataset) . "' );</script>";?>
        <div class="card col-12 col-md-6 col-lg-4">
          <div class="row">
            <div class="col-9" style="padding: 10px;">
              <div class="grid-content-wrapper">
                <div class="meta">
                  <img src="http://10.7.0.136:8083/wordpress/wp-content/uploads/2019/02/rec.png">
                  <?php
                  $localized_title = wpckan_get_multilingual_value("title",$dataset);
                  $date = $dataset["metadata_created"];
                  $link = wpckan_get_link_to_dataset($dataset["id"]); ?>
                  <a class="item-title" href="wordpress/<?php echo $link; ?>" title="<?php echo $localized_title; ?>" data-ga-event="Dataset|link_click|<?php echo $dataset["id"]; ?>">
                    <?php echo "<span style='padding: 10px 0px;'>".$localized_title."</span>"; ?>

                  </a><br>
                  <?php
                  $localized_description = wpckan_get_multilingual_value("notes",$dataset);
                  $organization = $dataset["organization"]["title"];
                  echo $localized_description;
                  echo "<br><span>".$organization."</span>";
                  if(!isset($dataset["openess_score"])){
                    echo "<div>";
                    for($i=0; $i<5; $i++){
                      if($i < 3 /*$dataset["openess_score"]*/)
                      echo "<span><image src='/wordpress/wp-content/uploads/2019/02/estrella.png'></span>&nbsp;";
                      else {
                        echo "<span><image src='/wordpress/wp-content/uploads/2019/02/estrellavacia.png'></span>&nbsp;";
                      }
                    }
                    echo "</div>";
                  }
                  if(isset($dataset["num_resources"])){
                    if($dataset["num_resources"] > 0){
                      echo "<hr style='margin: 10px 0px;'>";
                      $resources = $dataset["resources"];
                      $formats = "<div style='display:flex;'><p style='hyphens: auto; '>";
                      foreach($resources as $resource):
                        $formats = $formats . "<span style='padding: 5px; margin: 0px 5px;' class='resource-".$resource["format"]."'>".$resource["format"]."</span> ";
                      endforeach;
                      $formats = $formats . "</p></div>";
                      echo $formats;
                    }
                  }
                  ?>
                </div>
              </div>
            </div>
            <div class="col-3" style="padding: 10px 10px 10px 0px;">
              <?php
              $groups = $dataset["groups"];
              foreach($groups as $group): ?>
              <img width="32px" height="32px" src="<?php echo $group["image_display_url"]; ?>">
              <?php
            endforeach;
            ?>
          </div>
        </div>
      </div>
      <?php
    endforeach; ?>
  </div>

</div>
<div class="col-lg-3 d-lg-inline d-md-none d-xs-none d-sm-none">
  <div class="row content" style="margin-left: 5px;">
    <div id="accordion" style="width:100%;">
      <div class="card">
        <div class="card-header" id="headingOne">
          <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">               <i class="fa" aria-hidden="true"></i>
              Etiquetas
            </button>
          </h5>
        </div>
        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
          <div class="card-body">
            <?php echo do_shortcode( ' [wpckan_10_tags_user limit="10"] ' );?>
          </div>
        </div>
      </div>
    <div class="card">
      <div class="card-header" id="headingTwo">
        <h5 class="mb-0">
          <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            <i class="fa" aria-hidden="true"></i>
            Formatos
          </button>
        </h5>
      </div>
      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
        <div class="card-body">
          <?php echo do_shortcode( ' [wpckan_10_tags_user limit="10"] ' );?>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header" id="headingThree">
        <h5 class="mb-0">
          <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
            <i class="fa" aria-hidden="true"></i>
            Grupos
          </button>
        </h5>
      </div>
      <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
        <div class="card-body">
          <?php echo do_shortcode( ' [wpckan_groups_filter] ' );?>
        </div>
      </div>
    </div>
  </div>

</div> <!-- end container -->
</div>
</div>
</div>
