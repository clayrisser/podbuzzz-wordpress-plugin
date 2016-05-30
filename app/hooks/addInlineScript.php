<?php
  
  function add_inline_script() {
    $key = get_option('podbuzzz_key');
    $enabled = get_option('podbuzzz_enabled');
    if ($key && $enabled) {
      echo '<script async src="https://www.podbuzzz.com/'.$key.'/podbuzz_review_prompt.js"></script>';
    }
  }
  add_action( 'wp_footer', 'add_inline_script' );
