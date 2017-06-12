<?php

// updates the _customize.scss partial
function compileSCSS() {
  require 'scssphp/scss.inc.php';
  $scss = new scssc();
  $sassy_code = '
   $scss-primary-color: '.get_theme_mod('primary_color').';
   $scss-secondary-color: '.get_theme_mod('secondary_color').';
   $scss-accent-color: '.get_theme_mod('tertiary_color').';
   $scss-nav-text-color: '.get_theme_mod('nav_text_color').';
   $scss-header-footer-text-color: '.get_theme_mod('header_footer_text_color').';
  ';

  // open _customize.scss
  $customize_file = __DIR__.'/_customize.scss';
  $handle = fopen($customize_file, 'r') or die('Cannot open file:  '.$customize_file);
  $current_scss = fread($handle,filesize($customize_file)); // current scss code

  // Check if CSS needs recompiling
  if($current_scss != $sassy_code) {
    ChromePhp::log('Customizable options have been modified. Compiling SCSS...');

    // write the scss to _customize.scss
    $handle = fopen($customize_file, 'w') or die('Cannot open file:  '.$customize_file);
    fwrite($handle, $sassy_code);

    // open origin.scss and compile it
    $main_file = __DIR__.'/origin.scss';
    $handle = fopen($main_file, 'r');
    $data = fread($handle,filesize($main_file));
    $scss->setImportPaths(__DIR__);
    $scss->setFormatter('scss_formatter');
    $compiled_css = $scss->compile($data);

    // write to origin.css
    $output = __DIR__.'/origin.css';
    $handle = fopen($output, 'w') or die('Cannot open file:  '.$file);
    fwrite($handle, $compiled_css);

    ChromePhp::log('SCSS has been compiled!');
  }
}

?>
