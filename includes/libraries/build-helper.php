<?php 
/**
 * 
 * @since 1.0.0
 * @package global
 */
if ( !function_exists( 'build_helper_instance1' ) ) : 

/**
 * Get the build manifest helper instance
 * 
 * @param string $plugin_file 
 * 
 * @global $build_helpers
 *
 * @since 1.0.0
 * @return mixed
 */
function build_helper_instance1( $plugin_file ) {
  global $build_helpers;

  if ( !is_array( $build_helpers ) ) {
    $build_helpers = array();
  }

  if ( array_key_exists( $plugin_file, $build_helpers ) ) {
    return $build_helpers[ $plugin_file ];
  }

  $css = array();
  $js  = array();

  $manifest = get_manifest1( $plugin_file );

  foreach( $manifest['css'] as $name => $file ) {
   $css[ $name ] = (object) get_asset( $plugin_file, $file );
  }
  
  foreach( $manifest['js'] as $name => $file ) {
    $js[ $name ] = (object) get_asset( $plugin_file, $file );
  } 

  return $build_helpers[ $plugin_file ] = new BuildHelper1( $css, $js );
}

/**
 * Get the manifest contents
 * 
 * @param string $plugin_file
 * 
 * @internal
 * @since 1.0.0
 * @return array()
 */
function get_manifest1( $plugin_file ) {
  $default = array(
    'js'  => array(),
    'css' => array()
  );

  $file = dirname( $plugin_file ) . '/build/Manifest.json';

  if ( !file_exists( $file ) ) {
    return $default;
  }

  $manifest = json_decode( file_get_contents( $file ), true );

  if ( is_null( $manifest ) ) {
    return $default;
  }

  return $manifest;
}

/**
 * Get the asset URL and absolute paths
 * 
 * @internal
 * @since 1.0.0
 * @return array
 */
function get_asset( $plugin_file, $file ) {
  $asset = array(
    'path' => plugin_dir_path( $plugin_file ) . "build/$file",
    'url'  => plugins_url( "build/$file", $plugin_file )
  );

  return $asset;
}

/**
 * Helper class for registering and enqueuing compiled assets 
 * 
 * @since 1.0.0
 * @internal
 */
class BuildHelper1 {
  
  /**
   * Available CSS files
   * 
   * @var array
   * @access public
   */
  public $css = array();

  /**
   * Available JS files
   * 
   * @var array
   * @access public
   */
  public $js = array();

  /**
   * Constuctor
   * 
   * @param array $css
   * @param array $js 
   * 
   * @since 1.0.0
   */
  public function __construct( $css = array(), $js = array() ) {
    $this->css = $css;
    $this->js  = $js;
  }

  /**
   * Register a javascript file
   * 
   * @see wp_register_script
   * 
   * @param string $tag 
   * @param string $file 
   * @param array  $deps 
   * @param mixed  $ver
   * @param bool   $in_footer
   * 
   * @since 1.0.0
   * @return bool
   */
  public function register_script( $tag, $file, $deps = array(), $ver = false, $in_footer = false ) {
    if ( !array_key_exists( $file, $this->js ) ) {
      return false;
    }

    $args = array(
      $tag,
      $this->js[ $file ]->url,
      $deps,
      $ver,
      $in_footer
    );

    return call_user_func_array( 'wp_register_script', $args );
  }

   /**
   * Register a css file
   * 
   * @see wp_register_style
   * 
   * @param string $tag 
   * @param string $file 
   * @param array  $deps 
   * @param mixed  $ver
   * @param string $media
   * 
   * @since 1.0.0
   * @return bool
   */
  public function register_style( $tag, $file, $deps = array(), $ver = false, $media = 'all' ) {
    if ( !array_key_exists( $file, $this->css ) ) {
      return false;
    }
    
    $args = array(
      $tag,
      $this->css[ $file ]->url,
      $deps,
      $ver,
      $media
    );

    return call_user_func_array( 'wp_register_style', $args );
  }

  /**
   * Enqueue a javascript file
   * 
   * @see wp_enqueue_script
   * 
   * @param string $tag 
   * @param string $file 
   * @param array  $deps 
   * @param mixed  $ver
   * @param bool   $in_footer
   * 
   * @since 1.0.0
   * @return void
   */
  public function enqueue_script( $tag, $file, $deps = array(), $ver = false, $in_footer = false ) {
    if ( !call_user_func_array( array( $this, 'register_script' ), func_get_args() ) ) {
      return false;
    }

    wp_enqueue_script( $tag );
  }

  /**
   * Enqueue a css file
   * 
   * @see wp_enqueue_style
   * 
   * @param string $tag 
   * @param string $file 
   * @param array  $deps 
   * @param mixed  $ver
   * @param string $media
   * 
   * @since 1.0.0
   * @return void
   */
  public function enqueue_style( $tag, $file, $deps = array(), $ver = false, $media = 'all' ) {
    if ( !call_user_func_array( array( $this, 'register_style' ), func_get_args() ) ) {
      return false;
    }

    wp_enqueue_style( $tag );
  }
}

endif; 