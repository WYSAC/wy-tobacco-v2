<?php

/**
 * Plugin Name: Post Slider WD
 * Plugin URI: https://web-dorado.com/products/wordpress-post-slider-plugin.html
 * Description: Post Slider WD is designed to show off your selected posts of your website using in a slider. 
 * Version: 1.0.1
 * Author: WebDorado
 * Author URI: https://web-dorado.com/
 * License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */


define('WD_PS_DIR', WP_PLUGIN_DIR . "/" . plugin_basename(dirname(__FILE__)));
define('WD_PS_URL', plugins_url(plugin_basename(dirname(__FILE__))));
$upload_dir = wp_upload_dir();

$WD_PS_UPLOAD_DIR = str_replace(ABSPATH, '', $upload_dir['basedir']) . '/post-slider-wd';

// Plugin menu.
function wdps_options_panel() {
  add_menu_page('Post Slider WD', 'Post Slider WD', 'manage_options', 'sliders_wdps', 'wdps_sliders', WD_PS_URL . '/images/wd_slider.png');

  $sliders_page = add_submenu_page('sliders_wdps', __('Sliders','wdps_back'), __('Sliders','wdps_back'), 'manage_options', 'sliders_wdps', 'wdps_sliders');
  add_action('admin_print_styles-' . $sliders_page, 'wdps_styles');
  add_action('admin_print_scripts-' . $sliders_page, 'wdps_scripts');
  
  add_submenu_page('sliders_wdps', 'Get Pro', 'Get Pro', 'manage_options', 'licensing_wdps', 'wdps_licensing');
  add_submenu_page('sliders_wdps', __('Featured Plugins','wdps_back'), __('Featured Plugins','wdps_back'), 'manage_options', 'featured_plugins_wdps', 'wdps_featured');
  add_submenu_page('sliders_wdps', __('Featured Themes','wdps_back'), __('Featured Themes','wdps_back'), 'manage_options', 'featured_themes_wdps', 'wdps_featured_themes'); 
  $uninstall_page = add_submenu_page('sliders_wdps', __('Uninstall','wdps_back'), __('Uninstall','wdps_back'), 'manage_options', 'uninstall_wdps', 'wdps_sliders');
  add_action('admin_print_styles-' . $uninstall_page, 'wdps_styles');
  add_action('admin_print_scripts-' . $uninstall_page, 'wdps_scripts');
}
add_action('admin_menu', 'wdps_options_panel');
function wdps_sliders() {
 
  if (function_exists('current_user_can')) {
    if (!current_user_can('manage_options')) {
      die('Access Denied');
    }
  }
  else {
    die('Access Denied');
  }
  require_once(WD_PS_DIR . '/framework/WDW_PS_Library.php');
  $page = WDW_PS_Library::get('page');
  
  if (($page != '') && (($page == 'sliders_wdps') || ($page == 'uninstall_wdps') || ($page == 'WDPSShortcode'))) {
    require_once(WD_PS_DIR . '/admin/controllers/WDPSController' . (($page == 'WDPSShortcode') ? $page : ucfirst(strtolower($page))) . '.php');
    $controller_class = 'WDPSController' . ucfirst(strtolower($page));
    $controller = new $controller_class();
    $controller->execute();
  }
 
}

function wdps_licensing() {
  if (function_exists('current_user_can')) {
    if (!current_user_can('manage_options')) {
      die('Access Denied');
    }
  }
  else {
    die('Access Denied');
  }
  wp_register_style('wdps_licensing', WD_PS_URL . '/licensing/style.css', array(), get_option("wdps_version"));
  wp_print_styles('wdps_licensing');
  require_once(WD_PS_DIR . '/licensing/licensing.php');
}

function wdps_featured() {
  if (function_exists('current_user_can')) {
    if (!current_user_can('manage_options')) {
      die('Access Denied');
    }
  }
  else {
    die('Access Denied');
  }
  require_once(WD_PS_DIR . '/featured/featured.php');
  wp_register_style('wdps_featured', WD_PS_URL . '/featured/style.css', array(), get_option("wdps_version"));
  wp_print_styles('wdps_featured');
  spider_featured('slider_wd');
}

function wdps_featured_themes() {
  if (function_exists('current_user_can')) {
    if (!current_user_can('manage_options')) {
      die('Access Denied');
    }
  }
  else {
    die('Access Denied');
  }
  require_once(WD_PS_DIR . '/featured/featured_themes.php');
  wp_register_style('wdps_featured_themes', WD_PS_URL . '/featured/themes_style.css', array(), get_option("wdps_version"));
  wp_print_styles('wdps_featured_themes');
  spider_featured_themes();
}

function wdps_frontend() {
  require_once(WD_PS_DIR . '/framework/WDW_PS_Library.php');
  $page = WDW_PS_Library::get('action');
  if (($page != '') && ($page == 'WDPSShare')) {
    require_once(WD_PS_DIR . '/frontend/controllers/WDPSController' . ucfirst($page) . '.php');
    $controller_class = 'WDPSController' . ucfirst($page);
    $controller = new $controller_class();
    $controller->execute();
  }
}



function wdps_ajax() {
  if (function_exists('current_user_can')) {
    if (!current_user_can('manage_options')) {
      die('Access Denied');
    }
  }
  else {
    die('Access Denied');
  }
  require_once(WD_PS_DIR . '/framework/WDW_PS_Library.php');
  $page = WDW_PS_Library::get('action');
  if ($page != '' && (($page == 'WDPSShortcode') || ($page == 'WDPSPosts') )) {
    require_once(WD_PS_DIR . '/admin/controllers/WDPSController' . ucfirst($page) . '.php');
    $controller_class = 'WDPSController' . ucfirst($page);
    $controller = new $controller_class();
    $controller->execute();
  }
}

function wdps_shortcode($params) {
  $params = shortcode_atts(array('id' => 0), $params);
  ob_start();
  wdps_front_end($params['id']);
  // return str_replace(array("\r\n", "\n", "\r"), '', ob_get_clean());
  return ob_get_clean();
}
add_shortcode('wdps', 'wdps_shortcode');

function wdp_slider($id) {
  echo wdps_front_end($id);
}

$wdps = 0;
function wdps_front_end($id) {
  require_once(WD_PS_DIR . '/frontend/controllers/WDPSControllerSlider.php');
  $controller = new WDPSControllerSlider();
  global $wdps;
  $controller->execute($id, 1, $wdps);
  $wdps++;
  return;
}

function wdps_media_button($context) {
  global $pagenow;
  if (in_array($pagenow, array('post.php', 'page.php', 'post-new.php', 'post-edit.php'))) {
    $context .= '
      <a onclick="tb_click.call(this); wdps_thickDims(); return false;" href="' . add_query_arg(array('action' => 'WDPSShortcode', 'TB_iframe' => '1'), admin_url('admin-ajax.php')) . '" class="wdps_thickbox button" style="padding-left: 0.4em;" title="Select post slider">
        <span class="wp-media-buttons-icon wdps_media_button_icon" style="vertical-align: text-bottom; background: url(' . WD_PS_URL . '/images/wd_slider.png) no-repeat scroll left top rgba(0, 0, 0, 0);"></span>
        Add Post Slider WD
      </a>';
  }
  return $context;
}
add_filter('media_buttons_context', 'wdps_media_button');
// Add the Slider button to editor.
add_action('wp_ajax_WDPSShortcode', 'wdps_ajax');
add_action('wp_ajax_WDPSPosts', 'wdps_ajax');

function wdps_admin_ajax() {
  ?>
  <script>
    var wdps_thickDims, wdps_tbWidth, wdps_tbHeight;
    wdps_tbWidth = 400;
    wdps_tbHeight = 200;
    wdps_thickDims = function() {
      var tbWindow = jQuery('#TB_window'), H = jQuery(window).height(), W = jQuery(window).width(), w, h;
      w = (wdps_tbWidth && wdps_tbWidth < W - 90) ? wdps_tbWidth : W - 40;
      h = (wdps_tbHeight && wdps_tbHeight < H - 60) ? wdps_tbHeight : H - 40;
      if (tbWindow.size()) {
        tbWindow.width(w).height(h);
        jQuery('#TB_iframeContent').width(w).height(h - 27);
        tbWindow.css({'margin-left': '-' + parseInt((w / 2),10) + 'px'});
        if (typeof document.body.style.maxWidth != 'undefined') {
          tbWindow.css({'top':(H-h)/2,'margin-top':'0'});
        }
      }
    };
  </script>
  <?php
}
add_action('admin_head', 'wdps_admin_ajax');

// Add images to Slider.
add_action('wp_ajax_wdps_UploadHandler', 'wdps_UploadHandler');
add_action('wp_ajax_postaddImage', 'wdps_filemanager_ajax');

// Upload.
function wdps_UploadHandler() {
  require_once(WD_PS_DIR . '/filemanager/UploadHandler.php');
}

function wdps_filemanager_ajax() { 
  if (function_exists('current_user_can')) {
    if (!current_user_can('manage_options')) {
      die('Access Denied');
    }
  }
  else {
    die('Access Denied');
  }
  global $wpdb;
  require_once(WD_PS_DIR . '/framework/WDW_PS_Library.php');
  $page = WDW_PS_Library::get('action');
  if (($page != '') && (($page == 'postaddImage') || ($page == 'addMusic'))) {
    require_once(WD_PS_DIR . '/filemanager/controller.php');
    $controller_class = 'FilemanagerController';
    $controller = new $controller_class();
    $controller->execute();
  }
}
// Slider Widget.
if (class_exists('WP_Widget')) {
  require_once(WD_PS_DIR . '/admin/controllers/WDPSControllerWidgetSlideshow.php');
  add_action('widgets_init', create_function('', 'return register_widget("WDPSControllerWidgetSlideshow");'));
}

// Activate plugin.
function wdps_activate() {
   global $wpdb;
  wdps_install();
 /* if (!$wpdb->get_var("SELECT * FROM " . $wpdb->prefix . "wdpsslider")) {
    $wpdb->insert(
      $wpdb->prefix . 'wdpsslider', 
      array(
        'id' => 1,
        'name' => 'Default slider',
        'published' => 1,
        'full_width' => 0,
        'width' => 800,
        'height' => 300,
        'bg_fit' => 'cover',
        'align' => 'center',
        'effect' => 'none',
        'time_intervval' => 5,
        'autoplay' => 1,
        'shuffle' => 0,
        'music' => 0,
        'music_url' => '',
        'preload_images' => 1,
        'background_color' => '000000',
        'background_transparent' => 100,
        'glb_border_width' => 0,
        'glb_border_style' => 'none',
        'glb_border_color' => 'FFFFFF',
        'glb_border_radius' => '',
        'glb_margin' => 0,
        'glb_box_shadow' => '',
        'image_right_click' => 0,
        'layer_out_next' => 1,
        'prev_next_butt' => 1,
        'play_paus_butt' => 0,
        'navigation' => 'hover',
        'rl_butt_style' => 'fa-angle',
        'rl_butt_size' => 40,
        'pp_butt_size' => 40,
        'butts_color' => 'FFFFFF',
        'butts_transparent' => 100,
        'hover_color' => 'CCCCCC',
        'nav_border_width' => 0,
        'nav_border_style' => 'none',
        'nav_border_color' => 'FFFFFF',
        'nav_border_radius' => '20px',
        'nav_bg_color' => 'FFFFFF',
        'bull_position' => 'bottom',
        'bull_style' => 'fa-square-o',
        'bull_size' => 20,
        'bull_color' => 'FFFFFF',
        'bull_act_color' => 'FFFFFF',
        'bull_margin' => 3,
        'film_pos' => 'none',
        'film_thumb_width' => 100,
        'film_thumb_height' => 50,
        'film_bg_color' => '000000',
        'film_tmb_margin' => 0,
        'film_act_border_width' => 0,
        'film_act_border_style' => 'none',
        'film_act_border_color' => 'FFFFFF',
        'film_dac_transparent' => 50,
        'timer_bar_type' => 'none',
        'timer_bar_size' => 5,
        'timer_bar_color' => 'FFFFFF',
        'timer_bar_transparent' => 50,
        'built_in_watermark_type' => 'none',
        'built_in_watermark_position' => 'middle-center',
        'built_in_watermark_size' => 15,
        'built_in_watermark_url' => WD_S_URL . '/images/watermark.png',
        'built_in_watermark_text' => 'web-dorado.com',
        'built_in_watermark_font_size' => 20,
        'built_in_watermark_font' => '',
        'built_in_watermark_color' => 'FFFFFF',
        'built_in_watermark_opacity' => 70,
        'css' => '',
        'stop_animation' => 0,
        'spider_uploader' => 0,
        'right_butt_url' => WD_S_URL . '/images/arrow/arrow11/1/2.png',
        'left_butt_url' => WD_S_URL . '/images/arrow/arrow11/1/1.png',
        'right_butt_hov_url' => WD_S_URL . '/images/arrow/arrow11/1/4.png',
        'left_butt_hov_url' => WD_S_URL . '/images/arrow/arrow11/1/3.png',
        'rl_butt_img_or_not' => 'style',
        'bullets_img_main_url' => WD_S_URL . '/images/bullet/bullet1/1/1.png',
        'bullets_img_hov_url' => WD_S_URL . '/images/bullet/bullet1/1/2.png',
        'bull_butt_img_or_not' => 'style',
        'play_butt_url' => WD_S_URL . '/images/button/button4/1/1.png',
        'paus_butt_url' => WD_S_URL . '/images/button/button4/1/3.png',
        'play_butt_hov_url' => WD_S_URL . '/images/button/button4/1/2.png',
        'paus_butt_hov_url' => WD_S_URL . '/images/button/button4/1/4.png',
        'play_paus_butt_img_or_not' => 'style',
        'start_slide_num' => 1,
        'effect_duration' => 800,
        'carousel' => 0,
        'carousel_image_counts' => 7,
        'carousel_image_parameters' => '0.85',
        'carousel_fit_containerWidth' => 0,
        'carousel_width' => 1000,
        'parallax_effect' => 0,
        
	
      )
    );
  }
  if (!$wpdb->get_var("SELECT * FROM " . $wpdb->prefix . "wdpsslide")) {
    $wpdb->query('INSERT INTO `' . $wpdb->prefix . 'wdpsslide` VALUES(1, 1, "Slide 1", "image", "' . WD_PS_URL . '/demo/1.jpg", "' . WD_PS_URL . '/demo/1-150x150.jpg", 1, "", 1, 0)');
    $wpdb->query('INSERT INTO `' . $wpdb->prefix . 'wdpsslide` VALUES(2, 1, "Slide 2", "image", "' . WD_PS_URL . '/demo/2.jpg", "' . WD_PS_URL . '/demo/2-150x150.jpg", 1, "", 2, 0)');
    $wpdb->query('INSERT INTO `' . $wpdb->prefix . 'wdpsslide` VALUES(3, 1, "Slide 3", "image", "' . WD_PS_URL . '/demo/3.jpg", "' . WD_PS_URL . '/demo/3-150x150.jpg", 1, "", 3, 0)');
  }*/
}
register_activation_hook(__FILE__, 'wdps_activate');

function wdps_install() {
  $version = get_option("wdps_version");
  $new_version = '1.0.1';
  if ($version && version_compare($version, $new_version, '<')) {
    require_once WD_PS_DIR . "/sliders-update.php";
    wdps_update($version);
    update_option("wdps_version", $new_version);
  }
  elseif (!$version) {
    require_once WD_PS_DIR . "/sliders-insert.php";
    wdps_insert();
    add_option("wdps_theme_version", '1.0.0', '', 'no');
    add_option("wdps_version", $new_version, '', 'no');
    add_option("wdps_version_1.0.0", 1, '', 'no');
  }
}
if (!isset($_GET['action']) || $_GET['action'] != 'deactivate') {
  add_action('admin_init', 'wdps_install');
}

// Plugin styles.
function wdps_styles() {
  $version = get_option("wdps_version");
  wp_admin_css('thickbox');
  wp_enqueue_style('wdps_tables', WD_PS_URL . '/css/wdps_tables.css', array(), $version);
  wp_enqueue_style('wdps_tables_640', WD_PS_URL . '/css/wdps_tables_640.css', array(), $version);
  wp_enqueue_style('wdps_tables_320', WD_PS_URL . '/css/wdps_tables_320.css', array(), $version);
  $google_fonts = array('ABeeZee' => 'ABeeZee', 'Abel' => 'Abel', 'Abril+Fatface' => 'Abril Fatface', 'Aclonica' => 'Aclonica', 'Acme' => 'Acme', 'Actor' => 'Actor', 'Adamina' => 'Adamina', 'Advent+Pro' => 'Advent Pro', 'Aguafina+Script' => 'Aguafina Script', 'Akronim' => 'Akronim', 'Aladin' => 'Aladin', 'Aldrich' => 'Aldrich', 'Alegreya' => 'Alegreya', 'Alegreya+SC' => 'Alegreya SC', 'Alex+Brush' => 'Alex Brush', 'Alfa+Slab+One' => 'Alfa Slab One', 'Alice' => 'Alice', 'Alike' => 'Alike', 'Alike+Angular' => 'Alike Angular', 'Allan' => 'Allan', 'Allerta' => 'Allerta', 'Allura' => 'Allura', 'Almendra' => 'Almendra', 'Almendra+display' => 'Almendra Display', 'Almendra+sc' => 'Almendra SC', 'Amarante' => 'Amarante', 'Amaranth' => 'Amaranth', 'Amatic+sc' => 'Amatic SC', 'Amethysta' => 'Amethysta', 'Anaheim' => 'Anaheim', 'Andada' => 'Andada', 'Andika' => 'Andika', 'Angkor' => 'Angkor', 'Annie+Use+Your+Telescope' => 'Annie Use Your Telescope', 'Anonymous+Pro' => 'Anonymous Pro', 'Antic' => 'Antic', 'Antic+Didone' => 'Antic Didone', 'Antic+Slab' => 'Antic Slab', 'Anton' => 'Anton', 'Arapey' => 'Arapey', 'Arbutus' => 'Arbutus', 'Arbutus+slab' => 'Arbutus Slab', 'Architects+daughter' => 'Architects Daughter', 'Archivo+black' => 'Archivo Black', 'Archivo+narrow' => 'Archivo Narrow', 'Arimo' => 'Arimo', 'Arizonia' => 'Arizonia', 'Armata' => 'Armata', 'Artifika' => 'Artifika', 'Arvo' => 'Arvo', 'Asap' => 'Asap', 'Asset' => 'Asset', 'Astloch' => 'Astloch', 'Asul' => 'Asul', 'Atomic+age' => 'Atomic Age', 'Aubrey' => 'Aubrey', 'Audiowide' => 'Audiowide', 'Autour+one' => 'Autour One', 'Average' => 'Average', 'Average+Sans' => 'Average Sans', 'Averia+Gruesa+Libre' => 'Averia Gruesa Libre', 'Averia+Libre' => 'Averia Libre', 'Averia+Sans+Libre' => 'Averia Sans Libre', 'Averia+Serif+Libre' => 'Averia Serif Libre', 'Bad+Script' => 'Bad Script', 'Balthazar' => 'Balthazar', 'Bangers' => 'Bangers', 'Basic' => 'Basic', 'Battambang' => 'Battambang', 'Baumans' => 'Baumans', 'Bayon' => 'Bayon', 'Belgrano' => 'Belgrano', 'BenchNine' => 'BenchNine', 'Bentham' => 'Bentham', 'Berkshire+Swash' => 'Berkshire Swash', 'Bevan' => 'Bevan', 'Bigelow+Rules' => 'Bigelow Rules', 'Bigshot+One' => 'Bigshot One', 'Bilbo' => 'Bilbo', 'Bilbo+Swash+Caps' => 'Bilbo Swash Caps', 'Bitter' => 'Bitter', 'Black+Ops+One' => 'Black Ops One', 'Bokor' => 'Bokor', 'Bonbon' => 'Bonbon', 'Boogaloo' => 'Boogaloo', 'Bowlby+One' => 'Bowlby One', 'bowlby+One+SC' => 'Bowlby One SC', 'Brawler' => 'Brawler', 'Bree+Serif' => 'Bree Serif', 'Bubblegum+Sans' => 'Bubblegum Sans', 'Bubbler+One' => 'Bubbler One', 'Buda' => 'Buda', 'Buenard' => 'Buenard', 'Butcherman' => 'Butcherman', 'Butterfly+Kids' => 'Butterfly Kids', 'Cabin' => 'Cabin', 'Cabin+Condensed' => 'Cabin Condensed', 'Cabin+Sketch' => 'Cabin Sketch', 'Caesar+Dressing' => 'Caesar Dressing', 'Cagliostro' => 'Cagliostro', 'Calligraffitti' => 'Calligraffitti', 'Cambo' => 'Cambo', 'Candal' => 'Candal', 'Cantarell' => 'Cantarell', 'Cantata+One' => 'Cantata One', 'Cantora+One' => 'Cantora One', 'Capriola' => 'Capriola', 'Cardo' => 'Cardo', 'Carme' => 'Carme', 'Carrois+Gothic' => 'Carrois Gothic', 'Carrois+Gothic+SC' => 'Carrois Gothic SC', 'Carter+One' => 'Carter One', 'Caudex' => 'Caudex', 'Cedarville+cursive' => 'Cedarville Cursive', 'Ceviche+One' => 'Ceviche One', 'Changa+One' => 'Changa One', 'Chango' => 'Chango', 'Chau+philomene+One' => 'Chau Philomene One', 'Chela+One' => 'Chela One', 'Chelsea+Market' => 'Chelsea Market', 'Chenla' => 'Chenla', 'Cherry+Cream+Soda' => 'Cherry Cream Soda', 'Chewy' => 'Chewy', 'Chicle' => 'Chicle', 'Chivo' => 'Chivo', 'Cinzel' => 'Cinzel', 'Cinzel+Decorative' => 'Cinzel Decorative', 'Clicker+Script' => 'Clicker Script', 'Coda' => 'Coda', 'Coda+Caption' => 'Coda Caption', 'Codystar' => 'Codystar', 'Combo' => 'Combo', 'Comfortaa' => 'Comfortaa', 'Coming+soon' => 'Coming Soon', 'Concert+One' => 'Concert One', 'Condiment' => 'Condiment', 'Content' => 'Content', 'Contrail+One' => 'Contrail One', 'Convergence' => 'Convergence', 'Cookie' => 'Cookie', 'Copse' => 'Copse', 'Corben' => 'Corben', 'Courgette' => 'Courgette', 'Cousine' => 'Cousine', 'Coustard' => 'Coustard', 'Covered+By+Your+Grace' => 'Covered By Your Grace', 'Crafty+Girls' => 'Crafty Girls', 'Creepster' => 'Creepster', 'Crete+Round' => 'Crete Round', 'Crimson+Text' => 'Crimson Text', 'Croissant+One' => 'Croissant One', 'Crushed' => 'Crushed', 'Cuprum' => 'Cuprum', 'Cutive' => 'Cutive', 'Cutive+Mono' => 'Cutive Mono', 'Damion' => 'Damion', 'Dancing+Script' => 'Dancing Script', 'Dangrek' => 'Dangrek', 'Dawning+of+a+New+Day' => 'Dawning of a New Day', 'Days+One' => 'Days One', 'Delius' => 'Delius', 'Delius+Swash+Caps' => 'Delius Swash Caps', 'Delius+Unicase' => 'Delius Unicase', 'Della+Respira' => 'Della Respira', 'Denk+One' => 'Denk One', 'Devonshire' => 'Devonshire', 'Didact+Gothic' => 'Didact Gothic', 'Diplomata' => 'Diplomata', 'Diplomata+SC' => 'Diplomata SC', 'Domine' => 'Domine', 'Donegal+One' => 'Donegal One', 'Doppio+One' => 'Doppio One', 'Dorsa' => 'Dorsa', 'Dosis' => 'Dosis', 'Dr+Sugiyama' => 'Dr Sugiyama', 'Droid+Sans' => 'Droid Sans', 'Droid+Sans+Mono' => 'Droid Sans Mono', 'Droid+Serif' => 'Droid Serif', 'Duru+Sans' => 'Duru Sans', 'Dynalight' => 'Dynalight', 'Eb+Garamond' => 'EB Garamond', 'Eagle+Lake' => 'Eagle Lake', 'Eater' => 'Eater', 'Economica' => 'Economica', 'Electrolize' => 'Electrolize', 'Elsie' => 'Elsie', 'Elsie+Swash+Caps' => 'Elsie Swash Caps', 'Emblema+One' => 'Emblema One', 'Emilys+Candy' => 'Emilys Candy', 'Engagement' => 'Engagement', 'Englebert' => 'Englebert', 'Enriqueta' => 'Enriqueta', 'Erica+One' => 'Erica One', 'Esteban' => 'Esteban', 'Euphoria+Script' => 'Euphoria Script', 'Ewert' => 'Ewert', 'Exo' => 'Exo', 'Expletus+Sans' => 'Expletus Sans', 'Fanwood+Text' => 'Fanwood Text', 'Fascinate' => 'Fascinate', 'Fascinate+Inline' => 'Fascinate Inline', 'Faster+One' => 'Faster One', 'Fasthand' => 'Fasthand', 'Federant' => 'Federant', 'Federo' => 'Federo', 'Felipa' => 'Felipa', 'Fenix' => 'Fenix', 'Finger+Paint' => 'Finger Paint', 'Fjalla+One' => 'Fjalla One', 'Fjord+One' => 'Fjord One', 'Flamenco' => 'Flamenco', 'Flavors' => 'Flavors', 'Fondamento' => 'Fondamento', 'Fontdiner+swanky' => 'Fontdiner Swanky', 'Forum' => 'Forum', 'Francois+One' => 'Francois One', 'Freckle+Face' => 'Freckle Face', 'Fredericka+the+Great' => 'Fredericka the Great', 'Fredoka+One' => 'Fredoka One', 'Freehand' => 'Freehand', 'Fresca' => 'Fresca', 'Frijole' => 'Frijole', 'Fruktur' => 'Fruktur', 'Fugaz+One' => 'Fugaz One', 'GFS+Didot' => 'GFS Didot', 'GFS+Neohellenic' => 'GFS Neohellenic', 'Gabriela' => 'Gabriela', 'Gafata' => 'Gafata', 'Galdeano' => 'Galdeano', 'Galindo' => 'Galindo', 'Gentium+Basic' => 'Gentium Basic', 'Gentium+Book+Basic' => 'Gentium Book Basic', 'Geo' => 'Geo', 'Geostar' => 'Geostar', 'Geostar+Fill' => 'Geostar Fill', 'Germania+One' => 'Germania One', 'Gilda+Display' => 'Gilda Display', 'Give+You+Glory' => 'Give You Glory', 'Glass+Antiqua' => 'Glass Antiqua', 'Glegoo' => 'Glegoo', 'Gloria+Hallelujah' => 'Gloria Hallelujah', 'Goblin+One' => 'Goblin One', 'Gochi+Hand' => 'Gochi Hand', 'Gorditas' => 'Gorditas', 'Goudy+Bookletter+1911' => 'Goudy Bookletter 1911', 'Graduate' => 'Graduate', 'Grand+Hotel' => 'Grand Hotel', 'Gravitas+One' => 'Gravitas One', 'Great+Vibes' => 'Great Vibes', 'Griffy' => 'Griffy', 'Gruppo' => 'Gruppo', 'Gudea' => 'Gudea', 'Habibi' => 'Habibi', 'Hammersmith+One' => 'Hammersmith One', 'Hanalei' => 'Hanalei', 'Hanalei+Fill' => 'Hanalei Fill', 'Handlee' => 'Handlee', 'Hanuman' => 'Hanuman', 'Happy+Monkey' => 'Happy Monkey', 'Headland+One' => 'Headland One', 'Henny+Penny' => 'Henny Penny', 'Herr+Von+Muellerhoff' => 'Herr Von Muellerhoff', 'Holtwood+One +SC' => 'Holtwood One SC', 'Homemade+Apple' => 'Homemade Apple', 'Homenaje' => 'Homenaje', 'IM+Fell+DW+Pica' => 'IM Fell DW Pica', 'IM+Fell+DW+Pica+SC' => 'IM Fell DW Pica SC', 'IM+Fell+Double+Pica' => 'IM Fell Double Pica', 'IM+Fell+Double+Pica+S' => 'IM Fell Double Pica S', 'IM+Fell+English' => 'IM Fell English', 'IM+Fell+English+SC' => 'IM Fell English SC', 'IM+Fell+French+Canon' => 'IM Fell French Canon', 'IM+Fell+French+Canon+SC' => 'IM Fell French Canon SC', 'IM+Fell+Great+Primer' => 'IM Fell Great Primer', 'IM+Fell+Great+Primer+SC' => 'IM Fell Great Primer SC', 'Iceberg' => 'Iceberg', 'Iceland' => 'Iceland', 'Imprima' => 'Imprima', 'Inconsolata' => 'Inconsolata', 'Inder' => 'Inder', 'Indie+Flower' => 'Indie Flower', 'Inika' => 'Inika', 'Irish+Grover' => 'Irish Grover', 'Istok+Web' => 'Istok Web', 'Italiana' => 'Italiana', 'Italianno' => 'Italianno', 'Jacques+Francois' => 'Jacques Francois', 'Jacques+Francois+Shadow' => 'Jacques Francois Shadow', 'Jim+Nightshade' => 'Jim Nightshade', 'Jockey+One' => 'Jockey One', 'Jolly+Lodger' => 'Jolly Lodger', 'Josefin+Sans' => 'Josefin Sans', 'Josefin+Slab' => 'Josefin Slab', 'Joti+One' => 'Joti One', 'Judson' => 'Judson', 'Julee' => 'Julee', 'Julius+Sans+One' => 'Julius Sans One', 'Junge' => 'Junge', 'Jura' => 'Jura', 'Just+Another+Hand' => 'Just Another Hand', 'Just+Me+Again+Down+Here' => 'Just Me Again Down Here', 'Kameron' => 'Kameron', 'Karla' => 'Karla', 'Kaushan+Script' => 'Kaushan Script', 'Kavoon' => 'Kavoon', 'Keania+One' => 'Keania One', 'kelly+Slab' => 'Kelly Slab', 'Kenia' => 'Kenia', 'Khmer' => 'Khmer', 'Kite+One' => 'Kite One', 'Knewave' => 'Knewave', 'Kotta+One' => 'Kotta One', 'Koulen' => 'Koulen', 'Kranky' => 'Kranky', 'Kreon' => 'Kreon', 'Kristi' => 'Kristi', 'Krona+One' => 'Krona One', 'La+Belle+Aurore' => 'La Belle Aurore', 'Lancelot' => 'Lancelot', 'Lato' => 'Lato', 'League+Script' => 'League Script', 'Leckerli+One' => 'Leckerli One', 'Ledger' => 'Ledger', 'Lekton' => 'Lekton', 'Lemon' => 'Lemon', 'Libre+Baskerville' => 'Libre Baskerville', 'Life+Savers' => 'Life Savers', 'Lilita+One' => 'Lilita One', 'Limelight' => 'Limelight', 'Linden+Hill' => 'Linden Hill', 'Lobster' => 'Lobster', 'Lobster+Two' => 'Lobster Two', 'Londrina+Outline' => 'Londrina Outline', 'Londrina+Shadow' => 'Londrina Shadow', 'Londrina+Sketch' => 'Londrina Sketch', 'Londrina+Solid' => 'Londrina Solid', 'Lora' => 'Lora', 'Love+Ya+Like+A+Sister' => 'Love Ya Like A Sister', 'Loved+by+the+King' => 'Loved by the King', 'Lovers+Quarrel' => 'Lovers Quarrel', 'Luckiest+Guy' => 'Luckiest Guy', 'Lusitana' => 'Lusitana', 'Lustria' => 'Lustria', 'Macondo' => 'Macondo', 'Macondo+Swash+Caps' => 'Macondo Swash Caps', 'Magra' => 'Magra', 'Maiden+Orange' => 'Maiden Orange', 'Mako' => 'Mako', 'Marcellus' => 'Marcellus', 'Marcellus+SC' => 'Marcellus SC', 'Marck+Script' => 'Marck Script', 'Margarine' => 'Margarine', 'Marko+One' => 'Marko One', 'Marmelad' => 'Marmelad', 'Marvel' => 'Marvel', 'Mate' => 'Mate', 'Mate+SC' => 'Mate SC', 'Maven+Pro' => 'Maven Pro', 'McLaren' => 'McLaren', 'Meddon' => 'Meddon', 'MedievalSharp' => 'MedievalSharp', 'Medula+One' => 'Medula One', 'Megrim' => 'Megrim', 'Meie+Script' => 'Meie Script', 'Merienda' => 'Merienda', 'Merienda+One' => 'Merienda One', 'Merriweather' => 'Merriweather', 'Merriweather+Sans' => 'Merriweather Sans', 'Metal' => 'Metal', 'Metal+mania' => 'Metal Mania', 'Metamorphous' => 'Metamorphous', 'Metrophobic' => 'Metrophobic', 'Michroma' => 'Michroma', 'Milonga' => 'Milonga', 'Miltonian' => 'Miltonian', 'Miltonian+Tattoo' => 'Miltonian Tattoo', 'Miniver' => 'Miniver', 'Miss+Fajardose' => 'Miss Fajardose', 'Modern+Antiqua' => 'Modern Antiqua', 'Molengo' => 'Molengo', 'Molle' => 'Molle', 'Monda' => 'Monda', 'Monofett' => 'Monofett', 'Monoton' => 'Monoton', 'Monsieur+La+Doulaise' => 'Monsieur La Doulaise', 'Montaga' => 'Montaga', 'Montez' => 'Montez', 'Montserrat' => 'Montserrat', 'Montserrat+Alternates' => 'Montserrat Alternates', 'Montserrat+Subrayada' => 'Montserrat Subrayada', 'Moul' => 'Moul', 'Moulpali' => 'Moulpali', 'Mountains+of+Christmas' => 'Mountains of Christmas', 'Mouse+Memoirs' => 'Mouse Memoirs', 'Mr+Bedfort' => 'Mr Bedfort', 'Mr+Dafoe' => 'Mr Dafoe', 'Mr+De+Haviland' => 'Mr De Haviland', 'Mrs+Saint+Delafield' => 'Mrs Saint Delafield', 'Mrs+Sheppards' => 'Mrs Sheppards', 'Muli' => 'Muli', 'Mystery+Quest' => 'Mystery Quest', 'Neucha' => 'Neucha', 'Neuton' => 'Neuton', 'New+Rocker' => 'New Rocker', 'News+Cycle' => 'News Cycle', 'Niconne' => 'Niconne', 'Nixie+One' => 'Nixie One', 'Nobile' => 'Nobile', 'Nokora' => 'Nokora', 'Norican' => 'Norican', 'Nosifer' => 'Nosifer', 'Nothing+You+Could+Do' => 'Nothing You Could Do', 'Noticia+Text' => 'Noticia Text', 'Nova+Cut' => 'Nova Cut', 'Nova+Flat' => 'Nova Flat', 'Nova+Mono' => 'Nova Mono', 'Nova+Oval' => 'Nova Oval', 'Nova+Round' => 'Nova Round', 'Nova+Script' => 'Nova Script', 'Nova+Slim' => 'Nova Slim', 'Nova+Square' => 'Nova Square', 'Numans' => 'Numans', 'Nunito' => 'Nunito', 'Odor+Mean+Chey' => 'Odor Mean Chey', 'Offside' => 'Offside', 'Old+standard+tt' => 'Old Standard TT', 'Oldenburg' => 'Oldenburg', 'Oleo+Script' => 'Oleo Script', 'Oleo+Script+Swash+Caps' => 'Oleo Script Swash Caps', 'Open+Sans' => 'Open Sans', 'Open+Sans+Condensed' => 'Open Sans Condensed', 'Oranienbaum' => 'Oranienbaum', 'Orbitron' => 'Orbitron',  'Oregano' => 'Oregano', 'Orienta' => 'Orienta', 'Original+Surfer' => 'Original Surfer', 'Oswald' => 'Oswald', 'Over+the+Rainbow' => 'Over the Rainbow', 'Overlock' => 'Overlock', 'Overlock+SC' => 'Overlock SC', 'Ovo' => 'Ovo', 'Oxygen' => 'Oxygen', 'Oxygen+Mono' => 'Oxygen Mono', 'PT+Mono' => 'PT Mono', 'PT+Sans' => 'PT Sans', 'PT+Sans+Caption' => 'PT Sans Caption', 'PT+Sans+Narrow' => 'PT Sans Narrow', 'PT+Serif' => 'PT Serif', 'PT+Serif+Caption' => 'PT Serif Caption', 'Pacifico' => 'Pacifico', 'Paprika' => 'Paprika', 'Parisienne' => 'Parisienne', 'Passero+One' => 'Passero One', 'Passion+One' => 'Passion One', 'Patrick+Hand' => 'Patrick Hand', 'Patrick+Hand+SC' => 'Patrick Hand SC', 'Patua+One' => 'Patua One', 'Paytone+One' => 'Paytone One', 'Peralta' => 'Peralta', 'Permanent+Marker' => 'Permanent Marker', 'Petit+Formal+Script' => 'Petit Formal Script', 'Petrona' => 'Petrona', 'Philosopher' => 'Philosopher', 'Piedra' => 'Piedra', 'Pinyon+Script' => 'Pinyon Script', 'Pirata+One' => 'Pirata One', 'Plaster' => 'Plaster', 'Play' => 'Play', 'Playball' => 'Playball', 'Playfair+Display' => 'Playfair Display', 'Playfair+Display+SC' => 'Playfair Display SC', 'Podkova' => 'Podkova', 'Poiret+One' => 'Poiret One', 'Poller+One' => 'Poller One', 'Poly' => 'Poly', 'Pompiere' => 'Pompiere', 'Pontano+Sans' => 'Pontano Sans', 'Port+Lligat+Sans' => 'Port Lligat Sans', 'Port+Lligat+Slab' => 'Port Lligat Slab', 'Prata' => 'Prata', 'Preahvihear' => 'Preahvihear', 'Press+start+2P' => 'Press Start 2P', 'Princess+Sofia' => 'Princess Sofia', 'Prociono' => 'Prociono', 'Prosto+One' => 'Prosto One', 'Puritan' => 'Puritan', 'Purple+Purse' => 'Purple Purse', 'Quando' => 'Quando', 'Quantico' => 'Quantico', 'Quattrocento' => 'Quattrocento', 'Quattrocento+Sans' => 'Quattrocento Sans', 'Questrial' => 'Questrial', 'Quicksand' => 'Quicksand', 'Quintessential' => 'Quintessential', 'Qwigley' => 'Qwigley', 'Racing+sans+One' => 'Racing Sans One', 'Radley' => 'Radley', 'Raleway' => 'Raleway', 'Raleway+Dots' => 'Raleway Dots', 'Rambla' => 'Rambla', 'Rammetto+One' => 'Rammetto One', 'Ranchers' => 'Ranchers', 'Rancho' => 'Rancho', 'Rationale' => 'Rationale', 'Redressed' => 'Redressed', 'Reenie+Beanie' => 'Reenie Beanie', 'Revalia' => 'Revalia', 'Ribeye' => 'Ribeye', 'Ribeye+Marrow' => 'Ribeye Marrow', 'Righteous' => 'Righteous', 'Risque' => 'Risque', 'Roboto' => 'Roboto', 'Roboto+Condensed' => 'Roboto Condensed', 'Rochester' => 'Rochester', 'Rock+Salt' => 'Rock Salt', 'Rokkitt' => 'Rokkitt', 'Romanesco' => 'Romanesco', 'Ropa+Sans' => 'Ropa Sans', 'Rosario' => 'Rosario', 'Rosarivo' => 'Rosarivo', 'Rouge+Script' => 'Rouge Script', 'Ruda' => 'Ruda', 'Rufina' => 'Rufina', 'Ruge+Boogie' => 'Ruge Boogie', 'Ruluko' => 'Ruluko', 'Rum+Raisin' => 'Rum Raisin', 'Ruslan+Display' => 'Ruslan Display', 'Russo+One' => 'Russo One', 'Ruthie' => 'Ruthie', 'Rye' => 'Rye', 'Sacramento' => 'Sacramento', 'Sail' => 'Sail', 'Salsa' => 'Salsa', 'Sanchez' => 'Sanchez', 'Sancreek' => 'Sancreek', 'Sansita+One' => 'Sansita One', 'Sarina' => 'Sarina', 'Satisfy' => 'Satisfy', 'Scada' => 'Scada', 'Schoolbell' => 'Schoolbell', 'Seaweed+Script' => 'Seaweed Script', 'Sevillana' => 'Sevillana', 'Seymour+One' => 'Seymour One', 'Shadows+Into+Light' => 'Shadows Into Light', 'Shadows+Into+Light+Two' => 'Shadows Into Light Two', 'Shanti' => 'Shanti', 'Share' => 'Share', 'Share+Tech' => 'Share Tech', 'Share+Tech+Mono' => 'Share Tech Mono', 'Shojumaru' => 'Shojumaru',  'Short+Stack' => 'Short Stack', 'Siemreap' => 'Siemreap', 'Sigmar+One' => 'Sigmar One', 'Signika' => 'Signika', 'Signika+Negative' => 'Signika Negative', 'Simonetta' => 'Simonetta', 'Sintony' => 'Sintony', 'Sirin+Stencil' => 'Sirin Stencil', 'Six+Caps' => 'Six Caps', 'Skranji' => 'Skranji', 'Slackey' => 'Slackey', 'Smokum' => 'Smokum', 'Smythe' => 'Smythe', 'Sniglet' => 'Sniglet', 'Snippet' => 'Snippet', 'Snowburst+One' => 'Snowburst One', 'Sofadi+One' => 'Sofadi One', 'Sofia' => 'Sofia', 'Sonsie+One' => 'Sonsie One', 'Sorts+Mill+Goudy' => 'Sorts Mill Goudy', 'Source+Code+Pro' => 'Source Code Pro', 'Source+Sans+Pro' => 'Source Sans Pro', 'Special+Elite' => 'Special Elite', 'Spicy+Rice' => 'Spicy Rice', 'Spinnaker' => 'Spinnaker', 'Spirax' => 'Spirax', 'Squada+One' => 'Squada One', 'Stalemate' => 'Stalemate', 'Stalinist+One' => 'Stalinist One', 'Stardos+Stencil' => 'Stardos Stencil', 'Stint+Ultra+Condensed' => 'Stint Ultra Condensed', 'Stint+Ultra+Expanded' => 'Stint Ultra Expanded', 'Stoke' => 'Stoke', 'Strait' => 'Strait', 'Sue+Ellen+Francisco' => 'Sue Ellen Francisco', 'Sunshiney' => 'Sunshiney', 'Supermercado+One' => 'Supermercado One', 'Suwannaphum' => 'Suwannaphum', 'Swanky+and+Moo+Moo' => 'Swanky and Moo Moo',  'Syncopate' => 'Syncopate', 'Tangerine' => 'Tangerine', 'Taprom' => 'Taprom', 'Tauri' => 'Tauri', 'Telex' => 'Telex', 'Tenor+Sans' => 'Tenor Sans', 'Text+Me+One' => 'Text Me One', 'The+Girl+Next+Door' => 'The Girl Next Door', 'Tienne' => 'Tienne', 'Tinos' => 'Tinos', 'Titan+One' => 'Titan One', 'Titillium+Web' => 'Titillium Web', 'Trade+Winds' => 'Trade Winds', 'Trocchi' => 'Trocchi', 'Trochut' => 'Trochut', 'Trykker' => 'Trykker', 'Tulpen+One' => 'Tulpen One', 'Ubuntu' => 'Ubuntu', 'Ubuntu+Condensed' => 'Ubuntu Condensed', 'Ubuntu+Mono' => 'Ubuntu Mono', 'Ultra' => 'Ultra', 'Uncial+Antiqua' => 'Uncial Antiqua', 'Underdog' => 'Underdog', 'Unica+One' => 'Unica One', 'UnifrakturCook' => 'UnifrakturCook', 'UnifrakturMaguntia' => 'UnifrakturMaguntia', 'Unkempt' => 'Unkempt', 'Unna' => 'Unna', 'VT323' => 'VT323', 'Vampiro+One' => 'Vampiro One', 'Varela' => 'Varela', 'Varela+Round' => 'Varela Round', 'Vast+Shadow' => 'Vast Shadow', 'Vibur' => 'Vibur', 'Vidaloka' => 'Vidaloka', 'Viga' => 'Viga', 'Voces' => 'Voces', 'Volkhov' => 'Volkhov', 'Vollkorn' => 'Vollkorn',  'Voltaire' => 'Voltaire', 'Waiting+for+the+sunrise' => 'Waiting for the Sunrise', 'Wallpoet' => 'Wallpoet', 'Walter+Turncoat' => 'Walter Turncoat', 'Warnes' => 'Warnes', 'Wellfleet' => 'Wellfleet', 'Wendy+One' => 'Wendy One', 'Wire+One' => 'Wire One', 'Yanone+Kaffeesatz' => 'Yanone Kaffeesatz', 'Yellowtail' => 'Yellowtail', 'Yeseva+One' => 'Yeseva One', 'Yesteryear' => 'Yesteryear', 'Zeyada' => 'Zeyada');
  $query = implode("|", str_replace(' ', '+', $google_fonts));
  $url = 'https://fonts.googleapis.com/css?family=' . $query;
  wp_enqueue_style('wdps_googlefonts', $url, null, null);
}
// Plugin scripts.
function wdps_scripts() {
  $version = get_option("wdps_version");
  wp_enqueue_media();
  wp_enqueue_script('thickbox');
  wp_enqueue_script('jquery');
  wp_enqueue_script('jquery-ui-tooltip');
  wp_enqueue_script('jquery-ui-sortable');
  wp_enqueue_script('jquery-ui-draggable');
  wp_enqueue_script('wdps_admin', WD_PS_URL . '/js/wdps.js', array(), $version);
  wp_localize_script('wdps_admin', 'wdps_objectL10B', array(
    'saved'  => __('Items Succesfully Saved.', 'wdps_back'),
    'wdps_changes_mode_saved'  => __('Changes made in this table should be saved.', 'wdps_back'),
    'show_order'  => __('Show order column', 'wdps_back'),
    'wdps_select_image'  => __('You must select an image file.', 'wdps_back'),
    'wdps_select_audio'  => __('You must select an audio file.', 'wdps_back'),
    'text_layer'  => __('Add Text Layer', 'wdps_back'),
    'wdps_redirection_link'  => __('You can set a redirection link, so that the user will get to the mentioned location upon hitting the slide.<br />Use http:// and https:// for external links.', 'wdps_back'),
    'link_slide'  => __('Link the slide to:', 'wdps_back'),
    'published'  => __('Published:', 'wdps_back'),
    'add_post'  => __('Add Post', 'wdps_back'),
    'edit_post'  => __('Edit Post', 'wdps_back'),
    'add_hotspot'  => __('Add Hotspot Layer', 'wdps_back'),
    'add_social_buttons'  => __('Add Social Button Layer', 'wdps_back'),
    'none'  => __('None', 'wdps_back'),
    'bounce'  => __('Bounce', 'wdps_back'),
    'flash'  => __('Flash', 'wdps_back'),
    'pulse'  => __('Pulse', 'wdps_back'),
    'rubberBand'  => __('RubberBand', 'wdps_back'),
    'shake'  => __('Shake', 'wdps_back'),
    'swing'  => __('Swing', 'wdps_back'),
    'tada'  => __('Tada', 'wdps_back'),
    'wobble'  => __('Wobble', 'wdps_back'),
    'hinge'  => __('Hinge', 'wdps_back'),
    'lightSpeedIn'  => __('LightSpeedIn', 'wdps_back'),
    'rollIn'  => __('RollIn', 'wdps_back'),
    'bounceIn'  => __('BounceIn', 'wdps_back'),
    'bounceInDown'  => __('BounceInDown', 'wdps_back'),
    'bounceInLeft'  => __('BounceInLeft', 'wdps_back'),
    'bounceInRight'  => __('BounceInRight', 'wdps_back'),
    'bounceInUp'  => __('BounceInUp', 'wdps_back'),
    'fadeIn'  => __('FadeIn', 'wdps_back'),
    'fadeInDown'  => __('FadeInDown', 'wdps_back'),
    'fadeInDownBig'  => __('FadeInDownBig', 'wdps_back'),
    'fadeInLeft'  => __('FadeInLeft', 'wdps_back'),
    'fadeInLeftBig'  => __('FadeInLeftBig', 'wdps_back'),
    'fadeInRight'  => __('FadeInRight', 'wdps_back'),
    'fadeInRightBig'  => __('FadeInRightBig', 'wdps_back'),
    'fadeInUp'  => __('FadeInUp', 'wdps_back'),
    'fadeInUpBig'  => __('FadeInUpBig', 'wdps_back'),
    'flip'  => __('Flip', 'wdps_back'),
    'flipInX'  => __('FlipInX', 'wdps_back'),
    'flipInY'  => __('FlipInY', 'wdps_back'),
    'rotateIn'  => __('RotateIn', 'wdps_back'),
    'rotateInDownLeft'  => __('RotateInDownLeft', 'wdps_back'),
    'rotateInDownRight'  => __('RotateInDownRight', 'wdps_back'),
    'rotateInUpLeft'  => __('RotateInUpLeft', 'wdps_back'),
    'rotateInUpRight'  => __('RotateInUpRight', 'wdps_back'),
    'zoomIn'  => __('ZoomIn', 'wdps_back'),
    'zoomInDown'  => __('ZoomInDown', 'wdps_back'),
    'zoomInLeft'  => __('ZoomInLeft', 'wdps_back'),
    'zoomInRight'  => __('ZoomInRight', 'wdps_back'),
    'zoomInUp'  => __('ZoomInUp', 'wdps_back'),
    'lighter'  => __('Lighter', 'wdps_back'),
    'normal'  => __('Normal', 'wdps_back'),
    'bold'  => __('Bold', 'wdps_back'),
    'solid'  => __('Solid', 'wdps_back'),
    'dotted'  => __('Dotted', 'wdps_back'),
    'dashed'  => __('Dashed', 'wdps_back'),
    'wdps_double'  => __('Double', 'wdps_back'),
    'groove'  => __('Groove', 'wdps_back'),
    'ridge'  => __('Ridge', 'wdps_back'),
    'inset'  => __('Inset', 'wdps_back'),
    'outset'  => __('Outset', 'wdps_back'),
    'facebook'  => __('Facebook', 'wdps_back'),
    'google_plus'  => __('Google+', 'wdps_back'),
    'twitter'  => __('Twitter', 'wdps_back'),
    'pinterest'  => __('Pinterest', 'wdps_back'),
    'tumblr'  => __('Tumblr', 'wdps_back'),
    'top'  => __('Top', 'wdps_back'),
    'bottom'  => __('Bottom', 'wdps_back'),
    'left'  => __('Left', 'wdps_back'),
    'right'  => __('Right', 'wdps_back'),
    'wdps_drag_re_order'  => __('Drag to re-order', 'wdps_back'),
    'wdps_layer_title'  => __('Layer title', 'wdps_back'),
    'wdps_delete_layer'  => __('Are you sure you want to delete this layer ?', 'wdps_back'),
    'wdps_duplicate_layer'  => __('Duplicate layer', 'wdps_back'),
    'z_index'  => __('z-index', 'wdps_back'),
    'text'  => __('Text:', 'wdps_back'),
    'sample_text'  => __('Sample text', 'wdps_back'),
    'dimensions'  => __('Dimensions:', 'wdps_back'),
    'wdps_leave_blank'  => __('Leave blank to keep the initial width and height.', 'wdps_back'),
    'wdps_edit_image'  => __('Edit Image', 'wdps_back'),
    'wdps_alt'  => __('Alt:', 'wdps_back'),
    'wdps_set_HTML_attribute_specified'  => __('Set the HTML attribute specified in the IMG tag.', 'wdps_back'),
    'wdps_link'  => __('Link:', 'wdps_back'),
    'wdps_open_new_window'  => __('Open in a new window', 'wdps_back'),
    'wdps_use_links'  => __('Use http:// and https:// for external links.', 'wdps_back'),
    'position'  => __('Position:', 'wdps_back'),
    'wdps_in_addition'  => __('In addition you can drag and drop the layer to a desired position.', 'wdps_back'),
    'published'  => __('Published:', 'wdps_back'),
    'yes'  => __('Yes', 'wdps_back'),
    'no'  => __('No', 'wdps_back'),
    'color'  => __('Color:', 'wdps_back'),
    'size'  => __('Size:', 'wdps_back'),
    'font_family'  => __('Font family:', 'wdps_back'),
    'font_weight'  => __('Font weight:', 'wdps_back'),
    'padding'  => __('Padding:', 'wdps_back'),
    'use_css_type_value'  => __('Use CSS type values.', 'wdps_back'),
    'background_color'  => __('Background Color:', 'wdps_back'),
    'transparent'  => __('Transparent:', 'wdps_back'),
    'wdps_value_must'  => __('Value must be between 0 to 100.', 'wdps_back'),
    'radius'  => __('Radius:', 'wdps_back'),
    'shadow'  => __('Shadow:', 'wdps_back'),
    'scale'  => __('Scale:', 'wdps_back'),
    'wdps_set_width_height'  => __('Set width and height of the image.', 'wdps_back'),
    'social_button'  => __('Social button:', 'wdps_back'),
    'effect_in'  => __('Effect in:', 'wdps_back'),
    'start'  => __('Start', 'wdps_back'),
    'effect'  => __('Effect', 'wdps_back'),
    'duration'  => __('Duration', 'wdps_back'),
    'effect_out'  => __('Effect out:', 'wdps_back'),
    'hotspot_text_position'  => __('Hotspot text position:', 'wdps_back'),
    'hotspot_width'  => __('Hotspot Width:', 'wdps_back'),
    'hotspot_background_color'  => __('Hotspot Background Color:', 'wdps_back'),
    'hotspot_border'  => __('Hotspot Border:', 'wdps_back'),
    'hotspot_radius'  => __('Hotspot Radius:', 'wdps_back'),
    'add_image_layer'  => __('Add Image Layer', 'wdps_back'),
    'duplicate_slide'  => __('Duplicate slide', 'wdps_back'),
    'delete_slide'  => __('Delete slide', 'wdps_back'),
    'remove'  => __('Delete', 'wdps_back'),
    'border'  => __('Border:', 'wdps_back'),
    'break_word'  => __('Break-word:', 'wdps_back'),
    'hover_color'  => __('Hover color:', 'wdps_back'),
    'wdps_default'  => __('Default', 'wdps_back'),
    'google_fonts'  => __('Google fonts', 'wdps_back'),
  ));
  wp_enqueue_script('jscolor', WD_PS_URL . '/js/jscolor/jscolor.js', array(), '1.3.9');
  wp_enqueue_style('wdps_font-awesome', WD_PS_URL . '/css/font-awesome-4.0.1/font-awesome.css', array(), '4.0.1');
  wp_enqueue_style('wdps_effects', WD_PS_URL . '/css/wdps_effects.css', array(), $version);
  wp_enqueue_style('wdps_tooltip', WD_PS_URL . '/css/jquery-ui-1.10.3.custom.css', array(), $version);
}

function wdps_front_end_scripts() {
  $version = get_option("wdps_version");
  wp_enqueue_script('jquery');
  wp_enqueue_script('wdps_jquery_mobile', WD_PS_URL . '/js/jquery.mobile.js', array(), $version);
  wp_enqueue_style('wdps_frontend', WD_PS_URL . '/css/wdps_frontend.css', array(), $version);
  wp_enqueue_script('wdps_frontend', WD_PS_URL . '/js/wdps_frontend.js', array(), $version);
  wp_enqueue_style('wdps_effects', WD_PS_URL . '/css/wdps_effects.css', array(), $version);

  wp_enqueue_style('wdps_font-awesome', WD_PS_URL . '/css/font-awesome-4.0.1/font-awesome.css', array(), '4.0.1');
}
add_action('wp_enqueue_scripts', 'wdps_front_end_scripts');

// Languages localization.
function wdps_language_load() {
  load_plugin_textdomain('wdps', FALSE, basename(dirname(__FILE__)) . '/languages');
  load_plugin_textdomain('wdps_back', FALSE, basename(dirname(__FILE__)) . '/languages/backend');
}
add_action('init', 'wdps_language_load');

if (is_admin() && (!defined('DOING_AJAX') || !DOING_AJAX)) {
	include_once(WD_PS_DIR . '/sliders-notices.php');
  new WDPS_Notices();
}
?>