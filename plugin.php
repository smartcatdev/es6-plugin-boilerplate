<?php
/**
 * Plugin Name: MY_PLUGIN_NAME
 * Plugin URI: MY_PLUGIN_URL
 * Description: MY_PLUGIN_DESCRIPTION
 * Version: 1.0.0
 * Author: Smartcat Solutions Inc.
 * Author URI: https://smartcatdesign.net
 * License: MIT
 *
 */

/**
 * Read and load the plugin manifest into memory
 * 
 * @action plugins_loaded
 * 
 * @since 1.1.0
 * @return void
 */
add_action('plugins_loaded', function () {
  $file = dirname( __FILE__ ) . '/build/manifest.json';

  if ( !file_exists( $file ) ) {
    return;
  }

  $manifest = json_decode( file_get_contents( $file ) );

  if ( !is_null( $manifest ) ) {
    wp_cache_set( 'my_plugin_manifest', $manifest );
  }
});

add_action('wp_enqeue_scripts', function () {
  // Load assets from manifest file
});