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
  ChromePhp::log($sassy_code);

  // write the scss to file
  $file = __DIR__.'/_customize.scss';
  ChromePhp::log($file);
  $handle = fopen($file, 'w') or die('Cannot open file:  '.$file);
  fwrite($handle, $sassy_code);

  // open origin.scss and compile it
  $main_file = __DIR__.'/origin.scss';
  $handle = fopen($main_file, 'r');
  $data = fread($handle,filesize($main_file));
  $scss->setImportPaths(__DIR__);
  $scss->setFormatter('scss_formatter');
  $compiled_css = $scss->compile($data);
  ChromePhp::log('origin.scss output:'."\n \n".$compiled_css);

  // write to origin.css
  $output = __DIR__.'/origin.css';
  $handle = fopen($output, 'w') or die('Cannot open file:  '.$file);
  fwrite($handle, $compiled_css);
}

?>
