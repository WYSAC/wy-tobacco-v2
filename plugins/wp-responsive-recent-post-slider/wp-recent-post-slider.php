<?php
/**
 * Plugin Name: WP Responsive Recent Post Slider
 * Plugin URI: http://www.wponlinesupport.com/
 * Text Domain: wp-responsive-recent-post-slider
 * Domain Path: /languages/
 * Description: Easy to add and display Recent Post Slider  
 * Author: WP Online Support
 * Version: 1.2.2
 * Author URI: http://www.wponlinesupport.com/
 *
 * @package WordPress
 * @author WP Online Support
 */
register_activation_hook( __FILE__, 'install_postslider_free_version' );
function install_postslider_free_version(){
if( is_plugin_active('wp-responsive-recent-post-slider-pro/wp-recent-post-slider.php') ){
     add_action('update_option_active_plugins', 'deactivate_postslider_free_version');
    }
}
function deactivate_postslider_free_version(){
   deactivate_plugins('wp-responsive-recent-post-slider-pro/wp-recent-post-slider.php',true);
}
add_action( 'admin_notices', 'freepostslider_admin_notice');
function freepostslider_admin_notice() {
    $dir = ABSPATH . 'wp-content/plugins/wp-responsive-recent-post-slider-pro/wp-recent-post-slider.php';
    if( is_plugin_active( 'wp-responsive-recent-post-slider/wp-recent-post-slider.php' ) && file_exists($dir)) {
        global $pagenow;
        if( $pagenow == 'plugins.php' ){
            deactivate_plugins ( 'wp-responsive-recent-post-slider-pro/wp-recent-post-slider.php',true);
            if ( current_user_can( 'install_plugins' ) ) {
                echo '<div id="message" class="updated notice is-dismissible"><p><strong>Thank you for activating WP Responsive Recent Post Slider</strong>.<br /> It looks like you had PRO version <strong>(<em>WP Responsive Recent Post Slider Pro</em>)</strong> of this plugin activated. To avoid conflicts the extra version has been deactivated and we recommend you delete it. </p></div>';
            }
        }
    }
}  
 
add_action('plugins_loaded', 'wprps_load_textdomain');
function wprps_load_textdomain() {
	load_plugin_textdomain( 'wp-responsive-recent-post-slider', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}
 
add_action( 'wp_enqueue_scripts','wprpsstyle_css' );
	function wprpsstyle_css() {
	
		wp_enqueue_script( 'wprps_slick_jquery', plugin_dir_url( __FILE__ ) . 'assets/js/slick.min.js', array( 'jquery' ) );
		wp_enqueue_style( 'wprps_slick_style',  plugin_dir_url( __FILE__ ) . 'assets/css/slick.css');
  		wp_enqueue_style( 'wprps_recent_post_style',  plugin_dir_url( __FILE__ ) . 'assets/css/recent-post-style.css');
  		
}

require_once( 'templates/wprps-template.php' );
require_once( 'post_menu_function.php' );




