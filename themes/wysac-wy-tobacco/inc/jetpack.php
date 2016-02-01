<?php
/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.me/
 *
 * @package WYSAC Wyoming Tobacco
 */

/**
 * Add theme support for Infinite Scroll.
 * See: https://jetpack.me/support/infinite-scroll/
 */
function wysac_wy_tobacco_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'wysac_wy_tobacco_infinite_scroll_render',
		'footer'    => 'page',
	) );
} // end function wysac_wy_tobacco_jetpack_setup
add_action( 'after_setup_theme', 'wysac_wy_tobacco_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function wysac_wy_tobacco_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/content', get_post_format() );
	}
} // end function wysac_wy_tobacco_infinite_scroll_render
