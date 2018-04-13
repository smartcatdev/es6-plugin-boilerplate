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

include_once dirname( __FILE__ ) .'/includes/libraries/build-helper.php';


add_action('wp_enqueue_scripts', function () {
  
  // Get the manifest helper instance
  $helper = build_helper_instance1( __FILE__ );

  // Enqueue scripts and styles
  $helper->enqueue_script( 'bundle', 'bundle.js',  null, '1.0.0' ); 
  $helper->enqueue_style(  'bundle', 'bundle.css', null, '1.0.0' );

});
