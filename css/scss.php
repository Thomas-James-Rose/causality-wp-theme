<?php

// updates the _customize.scss partial
function compileSCSS() {
  require 'scssphp/scss.inc.php';
  $scss = new scssc();

  // TODO: modify the below code to pull defaults from functions.php
  $primary_color_val = get_theme_mod('primary_color');
  if($primary_color_val == NULL) $primary_color_val = '#3f51b4';

  $accent_color_val = get_theme_mod('accent_color');
  if($accent_color_val == NULL) $accent_color_val = '#fe5252';

  $primary_text_val = get_theme_mod('primary_text_color');
  if($primary_text_val == NULL) $primary_text_val = '#ffffff';

  $header_background = get_theme_mod('background_img');

  // generate SCSS
  $sassy_code = '
    $scss-primary-color: '.$primary_color_val.';
    $scss-accent-color: '.$accent_color_val.';
    $scss-primary-text-color: '.$primary_text_val.';
  ';
  if($header_background != NULL) {
    $sassy_code = $sassy_code . '
      $scss-header-background: url("'.$header_background.'");
    ';
  }

  // open _customize.scss
  $customize_file = __DIR__.'/_customize.scss';
  $handle = fopen($customize_file, 'r') or die('Cannot open file:  '.$customize_file);
  $current_scss = fread($handle,filesize($customize_file)); // current scss code

  // Check if CSS needs recompiling
  if($current_scss != $sassy_code || get_theme_mod('scss_recompile') == 1) {

    // write the scss to _customize.scss
    $handle = fopen($customize_file, 'w') or die('Cannot open file:  '.$customize_file);
    fwrite($handle, $sassy_code);

    // open causality.scss and compile it
    $main_file = __DIR__.'/causality.scss';
    $handle = fopen($main_file, 'r');
    $data = fread($handle,filesize($main_file));
    $scss->setImportPaths(__DIR__);
    $scss->setFormatter('scss_formatter');
    $compiled_css = $scss->compile($data);

    // write to causality.css
    $output = __DIR__.'/causality.css';
    $handle = fopen($output, 'w') or die('Cannot open file:  '.$file);
    fwrite($handle, $compiled_css);
  }
}

?>
