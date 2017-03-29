<?php /* Template Name: Graph */
  add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');
  get_header();
?>

<div class="container">
  <div class="row">
    <div class="col-sm-10">
       <ui-view></ui-view>
    </div>
  </div>
</div>

<?php
  get_footer();
?>