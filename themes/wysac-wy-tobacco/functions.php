<?php
/**
 * WYSAC Wyoming Tobacco functions and definitions.
 *
 * @link https://codex.wordpress.org/Functions_File_Explained
 *
 * @package WYSAC Wyoming Tobacco
 */

if ( ! function_exists( 'wysac_wy_tobacco_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function wysac_wy_tobacco_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on WYSAC Wyoming Tobacco, use a find and replace
	 * to change 'wysac-wy-tobacco' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'wysac-wy-tobacco', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'linkarea-feature', 300, 150, array ('center', 'center'));
	add_image_size( 'entry-feature-large', 750, 250, array ('center', 'center'));

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'wysac-wy-tobacco' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		//'aside', --> take out aside. we don't need it.
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'wysac_wy_tobacco_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Set default values for media upload attachment type from link to none
	update_option ('image_default_link_type', 'none');
}
endif; // wysac_wy_tobacco_setup
add_action( 'after_setup_theme', 'wysac_wy_tobacco_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wysac_wy_tobacco_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'wysac_wy_tobacco_content_width', 640 );
}
add_action( 'after_setup_theme', 'wysac_wy_tobacco_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wysac_wy_tobacco_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'wysac-wy-tobacco' ),
		'id'            => 'sidebar-1',
		'description'   => 'Primary, Default Sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'					=> esc_html__('Homepage - Slider', 'wysac-wy-tobacco'),
		'id'            => 'slider',
		'description'   => 'Content for slider on home page ',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));
	register_sidebar( array(
		'name'					=> esc_html__('Homepage - Sidebar Promo Image', 'wysac-wy-tobacco'),
		'id'            => 'home-sidebar',
		'description'   => 'Content for sidebar on home page posts',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));
	register_sidebar( array(
		'name'					=> esc_html__('Resources Description', 'wysac-wy-tobacco'),
		'id'            => 'resource-sidebar',
		'description'   => 'Content for sidebar on resource posts and archive',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));
	register_sidebar( array(
		'name'					=> esc_html__('About - WYSAC Info Box', 'wysac-wy-tobacco'),
		'id'            => 'info-sidebar',
		'description'   => 'Content for the sidebar on informational or "about" pages.',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));
	register_sidebar( array(
		'name'					=> esc_html__('Footer - Left', 'wysac-wy-tobacco'),
		'id'            => 'footer-sidebar-1',
		'description'   => 'Content for footer 1.  Appears on all pages',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));
	register_sidebar( array(
		'name'					=> esc_html__('Footer - Middle', 'wysac-wy-tobacco'),
		'id'            => 'footer-sidebar-2',
		'description'   => 'Content for footer 2.  Appears on all pages',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));
	register_sidebar( array(
		'name'					=> esc_html__('Footer - Right', 'wysac-wy-tobacco'),
		'id'            => 'footer-sidebar-3',
		'description'   => 'Content for footer 3.  Appears on all pages',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));
}


add_action( 'widgets_init', 'wysac_wy_tobacco_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function wysac_wy_tobacco_scripts() {

	wp_enqueue_script( 'wysac-wy-tobacco-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'wysac-wy-tobacco-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

/* get the bootstrap css and js and load it*/
	wp_register_script( 'bootstrap-js', get_template_directory_uri() . '/bootstrap-3.3.5-dist/js/bootstrap.js', array( 'jquery'), '3.0.1', true);
	wp_register_style( 'bootstrap-css', get_template_directory_uri() . '/bootstrap-3.3.5-dist/css/bootstrap.css', array(), '3.3.5', 'all');
	wp_enqueue_script('bootstrap-js');
	wp_enqueue_style('bootstrap-css');

/* move the theme css here to override bootstrap */
	wp_enqueue_style( 'wysac-wy-tobacco-style', get_stylesheet_uri() );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wysac_wy_tobacco_scripts' );
remove_filter('the_content', 'wpautop');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
* Custom Image Sizes
*/
