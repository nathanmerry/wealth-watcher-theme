<?php

/**
 * Include JavaScript files.
 */
function enqueue_js() {
  wp_enqueue_script('main-js', get_manifest_file('scripts/main.js'), [], 1.23, true);
}

/**
 * Enqueue CSS files.
 */
function enqueue_css() {
  wp_enqueue_style('main-css', get_manifest_file('styles/main.css'), [], 1.23);
}


/**
 * Add the enqueue functions to their respective actions.
 */
add_action('wp_enqueue_scripts', 'enqueue_js');
add_action('wp_enqueue_scripts', 'enqueue_css');
//add_action('wp_head', 'wp_head_local');