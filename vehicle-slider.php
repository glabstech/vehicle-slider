<?php
 /*
 Plugin Name: Car Vehicle Slider
 Plugin URI: https://github.com/wdonayre/vehicle-slider
 Description: A simple plugin to include a Vehicle Carousel in any post/page
 Version: 1.0.0
 Author: Glabs Tech
 Author URI: http://glabs.tech/
 License: GPL2
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! defined( 'GLTV_PLUGIN_ASSETS_JS_SCRIPT_PHP' ) ) define( 'GLTV_PLUGIN_ASSETS_JS_SCRIPT_PHP', plugin_dir_url( __FILE__ ).'assets/js/' );
if ( ! defined( 'GLTV_PLUGIN_ADMIN_GET_IMAGE_DEF' ) ) define( 'GLTV_PLUGIN_ADMIN_GET_IMAGE_DEF', plugin_dir_url( __FILE__ ).'admin/images/' );

require_once ( plugin_dir_path(__FILE__) . '/admin/includes/glt-vehicle-cmb.php' );
require_once ( plugin_dir_path(__FILE__) . '/admin/includes/glt-vehicle-cmb-image-upload.php' );
require_once ( plugin_dir_path(__FILE__) . '/admin/includes/glt-vehicle-cpt.php' );
require_once ( plugin_dir_path(__FILE__) . '/admin/includes/glt-vehicle-request.php' );
require_once ( plugin_dir_path(__FILE__) . '/admin/includes/glt-vehicle-sc.php' );
require_once ( plugin_dir_path(__FILE__) . '/admin/includes/glt-vehicle-cc.php' );

//===========================================================================
//    ENQUEUE JS SCRIPT AND CSS STYLE
//===========================================================================
add_action( 'admin_enqueue_scripts', 'gltv_enqueue_js_css' );
function gltv_enqueue_js_css() {
	wp_enqueue_script( 'gltv-customscript', plugins_url( '/admin/assets/js/script.js', __FILE__ ) );
	wp_enqueue_script( 'gltv-jscolor', plugins_url( '/admin/assets/js/jscolor.js', __FILE__ ) );
	
	wp_enqueue_style( 'gltv-customstyle', plugins_url( '/admin/assets/css/style.css', __FILE__ ) );
}


//===========================================================================
//    ENQUEUE FRONT END SCRIPTS AND CSS'
//===========================================================================
add_action( 'wp_enqueue_scripts', 'gltv_enqueue_js_css_front_end' );
function gltv_enqueue_js_css_front_end() {
	wp_register_script( 'gltv-f-owlcarousel-js', plugins_url( '/assets/js/owl.carousel.min.js', __FILE__ ), array( 'jquery' ) );
	
	wp_register_style( 'gltv-f-owlcarousel-css', plugins_url( '/assets/css/owl.carousel.min.css', __FILE__ ) );
	wp_register_style( 'gltv-f-themedefault-css', plugins_url( '/assets/css/owl.theme.default.min.css', __FILE__ ) );
	wp_register_style( 'gltv-f-custom-css', plugins_url( '/assets/css/style.css', __FILE__ ) );

	wp_enqueue_script( 'gltv-f-owlcarousel-js' );
	wp_enqueue_script( 'gtlv-f-custom-js' );
	
	wp_enqueue_style( 'gltv-f-owlcarousel-css' );
	wp_enqueue_style( 'gltv-f-themedefault-css' );
	wp_enqueue_style( 'gltv-f-custom-css' );
}

// 	wp_enqueue_script( 'gltv-enqueue-id', plugins_url( '/assets/js/script.php', __FILE__ ), array( 'jquery' ) );