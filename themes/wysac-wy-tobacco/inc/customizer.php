<?php
/**
 * WYSAC Wyoming Tobacco Theme Customizer.
 *
 * @package WYSAC Wyoming Tobacco
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function wysac_wy_tobacco_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'wysac_wy_tobacco_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function wysac_wy_tobacco_customize_preview_js() {
	wp_enqueue_script( 'wysac_wy_tobacco_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'wysac_wy_tobacco_customize_preview_js' );
