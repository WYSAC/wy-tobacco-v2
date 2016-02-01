<?php

class WDPSViewSliders_wdps {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  private $model;


  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function __construct($model) {
    $this->model = $model;
  }
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function display() {
    $rows_data = $this->model->get_rows_data();
    $page_nav = $this->model->page_nav();
    $search_value = ((isset($_POST['search_value'])) ? esc_html(stripslashes($_POST['search_value'])) : '');
    $search_select_value = ((isset($_POST['search_select_value'])) ? (int) $_POST['search_select_value'] : 0);
    $asc_or_desc = ((isset($_POST['asc_or_desc'])) ? esc_html(stripslashes($_POST['asc_or_desc'])) : 'asc');
    $order_by = (isset($_POST['order_by']) ? esc_html(stripslashes($_POST['order_by'])) : 'id');
    $post_t = ((isset($_POST['archive-dropdown'])) ? esc_html(stripslashes($_POST['archive-dropdown'])) : '');
    $order_class = 'manage-column column-title sorted ' . $asc_or_desc;
    $ids_string = '';
    
    ?>
    <style>
    <?php   
      global $wp_version;
      if (version_compare($wp_version, '4','<')) {
    ?>
      #wpwrap {
        background-color:#F1F1F1
      }
      @media  screen and (max-width: 640px) {
        .buttons_div input {
          width:31%;
          font-size:10px;
        }
        
        .tablenav{
          height:auto
        }
        
        #wpcontent{
          margin-left:40px!important
        }
        .alignleft  {
          display:none;
        }
      }

    <?php
      }
    ?>
    </style>
    <div style="clear: both; float: left; width: 99%;">
    <div style="float: left; font-size: 14px; font-weight: bold;">
      <?php echo __('This section allows you to create, edit and delete post sliders.','wdps_back'); ?>
      <a style="color: blue; text-decoration: none;" target="_blank" href="https://web-dorado.com/wordpress-post-slider-wd/creating-post-sliders.html"><?php echo __('Read More in User Manual','wdps_back'); ?> </a>
    </div>
    <div style="float: right; text-align: right;">
        <a style="text-decoration: none;" target="_blank" href="https://web-dorado.com/files/frompostslider.php">
          <img width="215" border="0" alt="web-dorado.com" src="<?php echo WD_PS_URL . '/images/wd_logo.png'; ?>" />
        </a>
      </div>
    </div>
     <form class="wrap wdps_form" id="sliders_form" method="post" action="admin.php?page=sliders_wdps" style="width: 99%;">   
      <?php wp_nonce_field('nonce_wd', 'nonce_wd'); ?>
      <span class="slider-icon"></span>
      <h2>
        <?php echo __('Post Sliders','wdps_back'); ?>
        <a href="" class="add-new-h2" onclick="spider_set_input_value('task', 'add');
                                               spider_form_submit(event, 'sliders_form')"><?php echo __('Add new','wdps_back'); ?></a>
      </h2>
      
      
     
     
      <div class="tablenav top" style="margin-bottom:25px">
        <?php
        
        WDW_PS_Library::search( 'Name' , $search_value, 'sliders_form');
        /*WDW_PS_Library::html_page_nav($page_nav['total'], $page_nav['limit'], 'sliders_form');*/
        
        ?>
        <div class="buttons_div">
        <span class="wdps_button-secondary non_selectable" onclick="spider_check_all_items()">
          <input type="checkbox" id="check_all_items" name="check_all_items" onclick="spider_check_all_items_checkbox()" style="margin: 0; vertical-align: middle;" />
          <span style="vertical-align: middle;"><?php echo __('Select All','wdps_back'); ?></span>
        </span>
        <input class="wdps_button-secondary wdps_publish_all" type="submit" onclick="spider_set_input_value('task', 'publish_all')" value="<?php echo __('Publish','wdps_back'); ?>" />
        <input class="wdps_button-secondary wdps_unpublish_all" type="submit" onclick="spider_set_input_value('task', 'unpublish_all')" value=" <?php echo __('Unpublish','wdps_back'); ?>" />
        <input class="wdps_button-secondary wdps_duplicate_all" type="submit" onclick="spider_set_input_value('task', 'duplicate_all')" value="<?php echo __('Duplicate','wdps_back'); ?>" />
        <input class="wdps_button-secondary wdps_delete_all" type="submit" onclick="if (confirm('<?php echo addslashes(__('Do you want to delete selected items?','wdps_back')); ?>')) {
                                                       spider_set_input_value('task', 'delete_all');
                                                     } else {
                                                       return false;
                                                     }" value="<?php echo __('Delete','wdps_back'); ?>" />
       </div>
     </div>
      <?php
        WDW_PS_Library::html_page_nav($page_nav['total'], $page_nav['limit'], 'sliders_form');
      ?>
      <table class="wp-list-table widefat fixed pages">
        <thead>
          <th class="manage-column column-cb check-column table_small_col"><input id="check_all" type="checkbox" onclick="spider_check_all(this)" style="margin:0;" /></th>
          <th class="table_small_col <?php if ($order_by == 'id') {echo $order_class;} ?>">
            <a onclick="spider_set_input_value('task', '');
                        spider_set_input_value('order_by', 'id');
                        spider_set_input_value('asc_or_desc', '<?php echo ((isset($_POST['asc_or_desc']) && isset($_POST['order_by']) && (esc_html(stripslashes($_POST['order_by'])) == 'id') && esc_html(stripslashes($_POST['asc_or_desc'])) == 'asc') ? 'desc' : 'asc'); ?>');
                        spider_form_submit(event, 'sliders_form')" href="">
              <span> ID</span><span class="sorting-indicator"></span>
            </a>
          </th>
          <th class="mobile_hide table_big_col"><?php echo __('Slider','wdps_back'); ?></th>
          <th class="<?php if ($order_by == 'name') {echo $order_class;} ?>">
            <a onclick="spider_set_input_value('task', '');
                        spider_set_input_value('order_by', 'name');
                        spider_set_input_value('asc_or_desc', '<?php echo ((isset($_POST['asc_or_desc']) && isset($_POST['order_by']) && (esc_html(stripslashes($_POST['order_by'])) == 'name') && esc_html(stripslashes($_POST['asc_or_desc'])) == 'asc') ? 'desc' : 'asc'); ?>');
                        spider_form_submit(event, 'sliders_form')" href="">
              <span><?php echo __('Name','wdps_back');?></span><span class="sorting-indicator"></span>
            </a>
          </th>
          <th class="mobile_hide table_big_col"><?php echo __('Slides','wdps_back'); ?></th>
          <th class="table_big_col"><?php echo __('Shortcode','wdps_back'); ?></th>
          <th class="mobile_hide table_large_col"><?php echo __('PHP function','wdps_back'); ?></th>
          <th class="mobile_hide table_big_col <?php if ($order_by == 'published') {echo $order_class;} ?>">
            <a onclick="spider_set_input_value('task', '');
                        spider_set_input_value('order_by', 'published');
                        spider_set_input_value('asc_or_desc', '<?php echo ((isset($_POST['asc_or_desc']) && isset($_POST['order_by']) && (esc_html(stripslashes($_POST['order_by'])) == 'published') && esc_html(stripslashes($_POST['asc_or_desc'])) == 'asc') ? 'desc' : 'asc'); ?>');
                        spider_form_submit(event, 'sliders_form')" href="">
              <span><?php echo __('Published','wdps_back');?></span><span class="sorting-indicator"></span>
            </a>
          </th>
          <th  class="mobile_hide table_big_col wdps_table_big_col_action" colspan='3'><?php echo __('Action','wdps_back'); ?></th>
        </thead>
        <tbody id="tbody_arr">
          <?php
 
          if ($rows_data) {
             $alternate = '';
            foreach ($rows_data as $row_data) {
              $alternate = (!isset($alternate) || $alternate == 'class="wdps_alternate"') ? '' : 'class="wdps_alternate"';
              $published_image = (($row_data->published) ? 'publish_slide' : 'unpublish_slide');
              $published = (($row_data->published) ? 'unpublish' : 'publish');
              $prev_img_url = $this->model->get_slider_prev_img($row_data->id);
             //$prev_img_url;
              $slides_count = $this->model->get_slides_count($row_data->id);
              ?>
              <tr id="tr_<?php echo $row_data->id; ?>" <?php echo $alternate; ?>>
                <td class="table_small_col check-column"><input id="check_<?php echo $row_data->id; ?>" name="check_<?php echo $row_data->id; ?>" onclick="spider_check_all(this)" type="checkbox" /></td>
                <td class="table_small_col"><?php echo $row_data->id; ?></td>
                <td class="mobile_hide table_big_col">
                  <img title="<?php echo $row_data->name; ?>" style="border: 1px solid #CCCCCC; max-width: 70px; max-height: 50px;" src="<?php echo $prev_img_url . '?date=' . date('Y-m-y H:i:s'); ?>">
                </td>
                <td class="wdps_640">
                  <a onclick="spider_set_input_value('task', 'edit');
                                spider_set_input_value('page_number', '1');
                                spider_set_input_value('search_value', '');
                                spider_set_input_value('search_or_not', '');
                                spider_set_input_value('asc_or_desc', 'asc');
                                spider_set_input_value('order_by', 'order');
                                spider_set_input_value('current_id', '<?php echo $row_data->id; ?>');
                                spider_form_submit(event, 'sliders_form')" href="" title="<?php echo __('Edit','wdps_back'); ?>"><?php echo $row_data->name; ?>
                  </a>
                </td>
                <td class="table_big_col"><?php echo $slides_count; ?></td>
                <td class="table_big_col" style="padding-left: 0; padding-right: 0;">
                  <input type="text" value='[wdps id="<?php echo $row_data->id; ?>"]' onclick="spider_select_value(this)" size="11" readonly="readonly" style="padding-left: 1px; padding-right: 1px;" />
                </td>
                <td class="mobile_hide table_large_col" style="padding-left: 0; padding-right: 0;">
                  <input type="text" value="&#60;?php wdp_slider(<?php echo $row_data->id; ?>); ?&#62;" onclick="spider_select_value(this)" size="23" readonly="readonly" style="padding-left: 1px; padding-right: 1px;" />
                </td>
                <td class="mobile_hide table_big_col"><a onclick="spider_set_input_value('task', '<?php echo $published; ?>');spider_set_input_value('current_id', '<?php echo $row_data->id; ?>');spider_form_submit(event, 'sliders_form')" href=""><img src="<?php echo WD_PS_URL . '/images/sliderwdpng/' . $published_image . '.png'; ?>"></img></a></td>
                <td class="mobile_hide table_big_col" colspan="3">
                  <div class='slider_edit_buttons'>
                    <div class="slider_edit">
                <input type="button" value="<?php echo __('Edit','wdps_back'); ?>" class="action_buttons edit_slider" onclick="spider_set_input_value('task', 'edit');
                                                      spider_set_input_value('page_number', '1');
                                                      spider_set_input_value('search_value', '');
                                                      spider_set_input_value('search_or_not', '');
                                                      spider_set_input_value('asc_or_desc', 'asc');
                                                      spider_set_input_value('order_by', 'order');
                                                      spider_set_input_value('current_id', '<?php echo $row_data->id; ?>');
                                                      spider_form_submit(event, 'sliders_form')" />
                    </div>
               <!-- <div class="slider_duplicate">
                      <input class="action_buttons wdps_duplicate_slider" type="submit" onclick="spider_set_input_value('current_id', '<?php echo $row_data->id; ?>'); 
                        spider_set_input_value('task', 'duplicate_all'); 
                        spider_form_submit(event, 'sliders_form')" value="<?php echo __('Duplicate','wdps_back');?>" />
                    </div>-->
                    <div class="slider_delete">
                      <input type="button" class="action_buttons wdps_delete_slider" value="<?php echo __('Delete','wdps_back'); ?>"  onclick="if (confirm('<?php echo addslashes(__('Do you want to delete selected items?','wdps_back')); ?>')) {spider_set_input_value('task', 'delete');
                                                        spider_set_input_value('current_id', '<?php echo $row_data->id; ?>');
                                                        spider_form_submit(event, 'sliders_form')} else {return false;}" />
                    </div>
                    <div class="clear"></div>
                  </div>
                </td>
              </tr>
              <?php
              $ids_string .= $row_data->id . ',';
            }
          }
          ?>
        </tbody>
      </table>
      <input id="task" name="task" type="hidden" value="" />
      <input id="current_id" name="current_id" type="hidden" value="" />
      <input id="ids_string" name="ids_string" type="hidden" value="<?php echo $ids_string; ?>" />
      <input id="asc_or_desc" name="asc_or_desc" type="hidden" value="asc" />
      <input id="order_by" name="order_by" type="hidden" value="<?php echo $order_by; ?>" />
    </form>
    <?php
  }

  public function edit($id, $reset = FALSE) {
    
    $row = $this->model->get_row_data($id, $reset);
    $users_name = get_users();
    $slides_row = $this->model->get_slides_row_data($id,$row->dynamic);
    $slide_ids_string = '';
    $sub_tab_type = WDW_PS_Library::get('sub_tab', '');
    $page_title = (($id != 0) ? __('Edit post slider ','wdps_back') . $row->name : __('Create new post slider','wdps_back'));
    
    $args = array(
      'public'=>true,
      'publicly_queryable' => true,
       'show_ui'=>true,
      '_builtin' => true
    );
    $output = 'names'; // names or objects, note names is the default
    $operator = 'or'; // 'and' or 'or'
    $post_types = get_post_types( $args, $output, $operator );
    $args=array(
      'object_type' => array( $row->choose_post) 
     ); 

    $output = 'names'; // or objects
    $operator = 'and'; // 'and' or 'or'
    $taxonomies = get_taxonomies($args,$output,$operator); 
    $argss = array(
      'orderby'           => 'id', 
      'order'             => 'ASC',
      'hide_empty'        => false,
    ); 
    
    
    $terms = get_terms($taxonomies, $argss);
    $post_sort = array(
      'publishing date' => __('Publishing Date','wdps_back'),
      'modification date' => __('Modification Date','wdps_back'),
      'number of comments' => __('Number of Comments','wdps_back'),
      'post title' => __('Post Title','wdps_back'),
      'menu order' => __('Menu Order','wdps_back'),
      'author' => __('Author','wdps_back'),
      'random' => __('Random','wdps_back'),
    );
    
      $cache_expiration_array = preg_split("/[\s,]+/", $row->cache_expiration);
      if($cache_expiration_array[0] != ''){
        $cache_expiration_count = $cache_expiration_array[0];
        $cache_expiration_name = $cache_expiration_array[1];
      }
      else {
        $cache_expiration_count = '';
        $cache_expiration_name = '';
      }
   
    
    $cache_expiration = array(
      'hour' => __('Hour','wdps_back'),
      'day' => __('Day','wdps_back'),
      'week' => __('Week','wdps_back'),
      'month' => __('Month','wdps_back'),
    );
    $aligns = array(
      'left' => __('Left','wdps_back'),
      'center' => __('Center','wdps_back'),
      'right' => __('Right','wdps_back'),
    );
    $border_styles = array(
      'none' => __('None','wdps_back'),
      'solid' => __('Solid','wdps_back'),
      'dotted' => __('Dotted','wdps_back'),
      'dashed' => __('Dashed','wdps_back'),
      'double' => __('Double','wdps_back'),
      'groove' => __('Groove','wdps_back'),
      'ridge' => __('Ridge','wdps_back'),
      'inset' => __('Inset','wdps_back'),
      'outset' => __('Outset','wdps_back'),
    );
    $button_styles = array(
      'fa-chevron' => __('Chevron','wdps_back'),
      'fa-angle' => __('Angle','wdps_back'),
      'fa-angle-double' => __('Double','wdps_back'),
    );
    $bull_styles = array(
      'fa-circle-o' => __('Circle O','wdps_back'),
      'fa-circle' => __('Circle','wdps_back'),
      'fa-minus' => __('Minus','wdps_back'),
      'fa-square-o' => __('Square O','wdps_back'),
      'fa-square' => __('Square','wdps_back'),
    );
    if ($row->possib_add_ffamily != '') {
      $possib_add_ffamily = explode("*WD*", $row->possib_add_ffamily);
      foreach($possib_add_ffamily as $possib_add_value) {
        if ($possib_add_value) {
          $font_families[strtolower($possib_add_value)] = $possib_add_value;
        }
      }
    }
    $google_fonts = array('ABeeZee' => 'ABeeZee', 'Abel' => 'Abel', 'Abril+Fatface' => 'Abril Fatface', 'Aclonica' => 'Aclonica', 'Acme' => 'Acme', 'Actor' => 'Actor', 'Adamina' => 'Adamina', 'Advent+Pro' => 'Advent Pro', 'Aguafina+Script' => 'Aguafina Script', 'Akronim' => 'Akronim', 'Aladin' => 'Aladin', 'Aldrich' => 'Aldrich', 'Alegreya' => 'Alegreya', 'Alegreya+SC' => 'Alegreya SC', 'Alex+Brush' => 'Alex Brush', 'Alfa+Slab+One' => 'Alfa Slab One', 'Alice' => 'Alice', 'Alike' => 'Alike', 'Alike+Angular' => 'Alike Angular', 'Allan' => 'Allan', 'Allerta' => 'Allerta', 'Allura' => 'Allura', 'Almendra' => 'Almendra', 'Almendra+display' => 'Almendra Display', 'Almendra+sc' => 'Almendra SC', 'Amarante' => 'Amarante', 'Amaranth' => 'Amaranth', 'Amatic+sc' => 'Amatic SC', 'Amethysta' => 'Amethysta', 'Anaheim' => 'Anaheim', 'Andada' => 'Andada', 'Andika' => 'Andika', 'Angkor' => 'Angkor', 'Annie+Use+Your+Telescope' => 'Annie Use Your Telescope', 'Anonymous+Pro' => 'Anonymous Pro', 'Antic' => 'Antic', 'Antic+Didone' => 'Antic Didone', 'Antic+Slab' => 'Antic Slab', 'Anton' => 'Anton', 'Arapey' => 'Arapey', 'Arbutus' => 'Arbutus', 'Arbutus+slab' => 'Arbutus Slab', 'Architects+daughter' => 'Architects Daughter', 'Archivo+black' => 'Archivo Black', 'Archivo+narrow' => 'Archivo Narrow', 'Arimo' => 'Arimo', 'Arizonia' => 'Arizonia', 'Armata' => 'Armata', 'Artifika' => 'Artifika', 'Arvo' => 'Arvo', 'Asap' => 'Asap', 'Asset' => 'Asset', 'Astloch' => 'Astloch', 'Asul' => 'Asul', 'Atomic+age' => 'Atomic Age', 'Aubrey' => 'Aubrey', 'Audiowide' => 'Audiowide', 'Autour+one' => 'Autour One', 'Average' => 'Average', 'Average+Sans' => 'Average Sans', 'Averia+Gruesa+Libre' => 'Averia Gruesa Libre', 'Averia+Libre' => 'Averia Libre', 'Averia+Sans+Libre' => 'Averia Sans Libre', 'Averia+Serif+Libre' => 'Averia Serif Libre', 'Bad+Script' => 'Bad Script', 'Balthazar' => 'Balthazar', 'Bangers' => 'Bangers', 'Basic' => 'Basic', 'Battambang' => 'Battambang', 'Baumans' => 'Baumans', 'Bayon' => 'Bayon', 'Belgrano' => 'Belgrano', 'BenchNine' => 'BenchNine', 'Bentham' => 'Bentham', 'Berkshire+Swash' => 'Berkshire Swash', 'Bevan' => 'Bevan', 'Bigelow+Rules' => 'Bigelow Rules', 'Bigshot+One' => 'Bigshot One', 'Bilbo' => 'Bilbo', 'Bilbo+Swash+Caps' => 'Bilbo Swash Caps', 'Bitter' => 'Bitter', 'Black+Ops+One' => 'Black Ops One', 'Bokor' => 'Bokor', 'Bonbon' => 'Bonbon', 'Boogaloo' => 'Boogaloo', 'Bowlby+One' => 'Bowlby One', 'bowlby+One+SC' => 'Bowlby One SC', 'Brawler' => 'Brawler', 'Bree+Serif' => 'Bree Serif', 'Bubblegum+Sans' => 'Bubblegum Sans', 'Bubbler+One' => 'Bubbler One', 'Buda' => 'Buda', 'Buenard' => 'Buenard', 'Butcherman' => 'Butcherman', 'Butterfly+Kids' => 'Butterfly Kids', 'Cabin' => 'Cabin', 'Cabin+Condensed' => 'Cabin Condensed', 'Cabin+Sketch' => 'Cabin Sketch', 'Caesar+Dressing' => 'Caesar Dressing', 'Cagliostro' => 'Cagliostro', 'Calligraffitti' => 'Calligraffitti', 'Cambo' => 'Cambo', 'Candal' => 'Candal', 'Cantarell' => 'Cantarell', 'Cantata+One' => 'Cantata One', 'Cantora+One' => 'Cantora One', 'Capriola' => 'Capriola', 'Cardo' => 'Cardo', 'Carme' => 'Carme', 'Carrois+Gothic' => 'Carrois Gothic', 'Carrois+Gothic+SC' => 'Carrois Gothic SC', 'Carter+One' => 'Carter One', 'Caudex' => 'Caudex', 'Cedarville+cursive' => 'Cedarville Cursive', 'Ceviche+One' => 'Ceviche One', 'Changa+One' => 'Changa One', 'Chango' => 'Chango', 'Chau+philomene+One' => 'Chau Philomene One', 'Chela+One' => 'Chela One', 'Chelsea+Market' => 'Chelsea Market', 'Chenla' => 'Chenla', 'Cherry+Cream+Soda' => 'Cherry Cream Soda', 'Chewy' => 'Chewy', 'Chicle' => 'Chicle', 'Chivo' => 'Chivo', 'Cinzel' => 'Cinzel', 'Cinzel+Decorative' => 'Cinzel Decorative', 'Clicker+Script' => 'Clicker Script', 'Coda' => 'Coda', 'Coda+Caption' => 'Coda Caption', 'Codystar' => 'Codystar', 'Combo' => 'Combo', 'Comfortaa' => 'Comfortaa', 'Coming+soon' => 'Coming Soon', 'Concert+One' => 'Concert One', 'Condiment' => 'Condiment', 'Content' => 'Content', 'Contrail+One' => 'Contrail One', 'Convergence' => 'Convergence', 'Cookie' => 'Cookie', 'Copse' => 'Copse', 'Corben' => 'Corben', 'Courgette' => 'Courgette', 'Cousine' => 'Cousine', 'Coustard' => 'Coustard', 'Covered+By+Your+Grace' => 'Covered By Your Grace', 'Crafty+Girls' => 'Crafty Girls', 'Creepster' => 'Creepster', 'Crete+Round' => 'Crete Round', 'Crimson+Text' => 'Crimson Text', 'Croissant+One' => 'Croissant One', 'Crushed' => 'Crushed', 'Cuprum' => 'Cuprum', 'Cutive' => 'Cutive', 'Cutive+Mono' => 'Cutive Mono', 'Damion' => 'Damion', 'Dancing+Script' => 'Dancing Script', 'Dangrek' => 'Dangrek', 'Dawning+of+a+New+Day' => 'Dawning of a New Day', 'Days+One' => 'Days One', 'Delius' => 'Delius', 'Delius+Swash+Caps' => 'Delius Swash Caps', 'Delius+Unicase' => 'Delius Unicase', 'Della+Respira' => 'Della Respira', 'Denk+One' => 'Denk One', 'Devonshire' => 'Devonshire', 'Didact+Gothic' => 'Didact Gothic', 'Diplomata' => 'Diplomata', 'Diplomata+SC' => 'Diplomata SC', 'Domine' => 'Domine', 'Donegal+One' => 'Donegal One', 'Doppio+One' => 'Doppio One', 'Dorsa' => 'Dorsa', 'Dosis' => 'Dosis', 'Dr+Sugiyama' => 'Dr Sugiyama', 'Droid+Sans' => 'Droid Sans', 'Droid+Sans+Mono' => 'Droid Sans Mono', 'Droid+Serif' => 'Droid Serif', 'Duru+Sans' => 'Duru Sans', 'Dynalight' => 'Dynalight', 'Eb+Garamond' => 'EB Garamond', 'Eagle+Lake' => 'Eagle Lake', 'Eater' => 'Eater', 'Economica' => 'Economica', 'Electrolize' => 'Electrolize', 'Elsie' => 'Elsie', 'Elsie+Swash+Caps' => 'Elsie Swash Caps', 'Emblema+One' => 'Emblema One', 'Emilys+Candy' => 'Emilys Candy', 'Engagement' => 'Engagement', 'Englebert' => 'Englebert', 'Enriqueta' => 'Enriqueta', 'Erica+One' => 'Erica One', 'Esteban' => 'Esteban', 'Euphoria+Script' => 'Euphoria Script', 'Ewert' => 'Ewert', 'Exo' => 'Exo', 'Expletus+Sans' => 'Expletus Sans', 'Fanwood+Text' => 'Fanwood Text', 'Fascinate' => 'Fascinate', 'Fascinate+Inline' => 'Fascinate Inline', 'Faster+One' => 'Faster One', 'Fasthand' => 'Fasthand', 'Federant' => 'Federant', 'Federo' => 'Federo', 'Felipa' => 'Felipa', 'Fenix' => 'Fenix', 'Finger+Paint' => 'Finger Paint', 'Fjalla+One' => 'Fjalla One', 'Fjord+One' => 'Fjord One', 'Flamenco' => 'Flamenco', 'Flavors' => 'Flavors', 'Fondamento' => 'Fondamento', 'Fontdiner+swanky' => 'Fontdiner Swanky', 'Forum' => 'Forum', 'Francois+One' => 'Francois One', 'Freckle+Face' => 'Freckle Face', 'Fredericka+the+Great' => 'Fredericka the Great', 'Fredoka+One' => 'Fredoka One', 'Freehand' => 'Freehand', 'Fresca' => 'Fresca', 'Frijole' => 'Frijole', 'Fruktur' => 'Fruktur', 'Fugaz+One' => 'Fugaz One', 'GFS+Didot' => 'GFS Didot', 'GFS+Neohellenic' => 'GFS Neohellenic', 'Gabriela' => 'Gabriela', 'Gafata' => 'Gafata', 'Galdeano' => 'Galdeano', 'Galindo' => 'Galindo', 'Gentium+Basic' => 'Gentium Basic', 'Gentium+Book+Basic' => 'Gentium Book Basic', 'Geo' => 'Geo', 'Geostar' => 'Geostar', 'Geostar+Fill' => 'Geostar Fill', 'Germania+One' => 'Germania One', 'Gilda+Display' => 'Gilda Display', 'Give+You+Glory' => 'Give You Glory', 'Glass+Antiqua' => 'Glass Antiqua', 'Glegoo' => 'Glegoo', 'Gloria+Hallelujah' => 'Gloria Hallelujah', 'Goblin+One' => 'Goblin One', 'Gochi+Hand' => 'Gochi Hand', 'Gorditas' => 'Gorditas', 'Goudy+Bookletter+1911' => 'Goudy Bookletter 1911', 'Graduate' => 'Graduate', 'Grand+Hotel' => 'Grand Hotel', 'Gravitas+One' => 'Gravitas One', 'Great+Vibes' => 'Great Vibes', 'Griffy' => 'Griffy', 'Gruppo' => 'Gruppo', 'Gudea' => 'Gudea', 'Habibi' => 'Habibi', 'Hammersmith+One' => 'Hammersmith One', 'Hanalei' => 'Hanalei', 'Hanalei+Fill' => 'Hanalei Fill', 'Handlee' => 'Handlee', 'Hanuman' => 'Hanuman', 'Happy+Monkey' => 'Happy Monkey', 'Headland+One' => 'Headland One', 'Henny+Penny' => 'Henny Penny', 'Herr+Von+Muellerhoff' => 'Herr Von Muellerhoff', 'Holtwood+One +SC' => 'Holtwood One SC', 'Homemade+Apple' => 'Homemade Apple', 'Homenaje' => 'Homenaje', 'IM+Fell+DW+Pica' => 'IM Fell DW Pica', 'IM+Fell+DW+Pica+SC' => 'IM Fell DW Pica SC', 'IM+Fell+Double+Pica' => 'IM Fell Double Pica', 'IM+Fell+Double+Pica+S' => 'IM Fell Double Pica S', 'IM+Fell+English' => 'IM Fell English', 'IM+Fell+English+SC' => 'IM Fell English SC', 'IM+Fell+French+Canon' => 'IM Fell French Canon', 'IM+Fell+French+Canon+SC' => 'IM Fell French Canon SC', 'IM+Fell+Great+Primer' => 'IM Fell Great Primer', 'IM+Fell+Great+Primer+SC' => 'IM Fell Great Primer SC', 'Iceberg' => 'Iceberg', 'Iceland' => 'Iceland', 'Imprima' => 'Imprima', 'Inconsolata' => 'Inconsolata', 'Inder' => 'Inder', 'Indie+Flower' => 'Indie Flower', 'Inika' => 'Inika', 'Irish+Grover' => 'Irish Grover', 'Istok+Web' => 'Istok Web', 'Italiana' => 'Italiana', 'Italianno' => 'Italianno', 'Jacques+Francois' => 'Jacques Francois', 'Jacques+Francois+Shadow' => 'Jacques Francois Shadow', 'Jim+Nightshade' => 'Jim Nightshade', 'Jockey+One' => 'Jockey One', 'Jolly+Lodger' => 'Jolly Lodger', 'Josefin+Sans' => 'Josefin Sans', 'Josefin+Slab' => 'Josefin Slab', 'Joti+One' => 'Joti One', 'Judson' => 'Judson', 'Julee' => 'Julee', 'Julius+Sans+One' => 'Julius Sans One', 'Junge' => 'Junge', 'Jura' => 'Jura', 'Just+Another+Hand' => 'Just Another Hand', 'Just+Me+Again+Down+Here' => 'Just Me Again Down Here', 'Kameron' => 'Kameron', 'Karla' => 'Karla', 'Kaushan+Script' => 'Kaushan Script', 'Kavoon' => 'Kavoon', 'Keania+One' => 'Keania One', 'kelly+Slab' => 'Kelly Slab', 'Kenia' => 'Kenia', 'Khmer' => 'Khmer', 'Kite+One' => 'Kite One', 'Knewave' => 'Knewave', 'Kotta+One' => 'Kotta One', 'Koulen' => 'Koulen', 'Kranky' => 'Kranky', 'Kreon' => 'Kreon', 'Kristi' => 'Kristi', 'Krona+One' => 'Krona One', 'La+Belle+Aurore' => 'La Belle Aurore', 'Lancelot' => 'Lancelot', 'Lato' => 'Lato', 'League+Script' => 'League Script', 'Leckerli+One' => 'Leckerli One', 'Ledger' => 'Ledger', 'Lekton' => 'Lekton', 'Lemon' => 'Lemon', 'Libre+Baskerville' => 'Libre Baskerville', 'Life+Savers' => 'Life Savers', 'Lilita+One' => 'Lilita One', 'Limelight' => 'Limelight', 'Linden+Hill' => 'Linden Hill', 'Lobster' => 'Lobster', 'Lobster+Two' => 'Lobster Two', 'Londrina+Outline' => 'Londrina Outline', 'Londrina+Shadow' => 'Londrina Shadow', 'Londrina+Sketch' => 'Londrina Sketch', 'Londrina+Solid' => 'Londrina Solid', 'Lora' => 'Lora', 'Love+Ya+Like+A+Sister' => 'Love Ya Like A Sister', 'Loved+by+the+King' => 'Loved by the King', 'Lovers+Quarrel' => 'Lovers Quarrel', 'Luckiest+Guy' => 'Luckiest Guy', 'Lusitana' => 'Lusitana', 'Lustria' => 'Lustria', 'Macondo' => 'Macondo', 'Macondo+Swash+Caps' => 'Macondo Swash Caps', 'Magra' => 'Magra', 'Maiden+Orange' => 'Maiden Orange', 'Mako' => 'Mako', 'Marcellus' => 'Marcellus', 'Marcellus+SC' => 'Marcellus SC', 'Marck+Script' => 'Marck Script', 'Margarine' => 'Margarine', 'Marko+One' => 'Marko One', 'Marmelad' => 'Marmelad', 'Marvel' => 'Marvel', 'Mate' => 'Mate', 'Mate+SC' => 'Mate SC', 'Maven+Pro' => 'Maven Pro', 'McLaren' => 'McLaren', 'Meddon' => 'Meddon', 'MedievalSharp' => 'MedievalSharp', 'Medula+One' => 'Medula One', 'Megrim' => 'Megrim', 'Meie+Script' => 'Meie Script', 'Merienda' => 'Merienda', 'Merienda+One' => 'Merienda One', 'Merriweather' => 'Merriweather', 'Merriweather+Sans' => 'Merriweather Sans', 'Metal' => 'Metal', 'Metal+mania' => 'Metal Mania', 'Metamorphous' => 'Metamorphous', 'Metrophobic' => 'Metrophobic', 'Michroma' => 'Michroma', 'Milonga' => 'Milonga', 'Miltonian' => 'Miltonian', 'Miltonian+Tattoo' => 'Miltonian Tattoo', 'Miniver' => 'Miniver', 'Miss+Fajardose' => 'Miss Fajardose', 'Modern+Antiqua' => 'Modern Antiqua', 'Molengo' => 'Molengo', 'Molle' => 'Molle', 'Monda' => 'Monda', 'Monofett' => 'Monofett', 'Monoton' => 'Monoton', 'Monsieur+La+Doulaise' => 'Monsieur La Doulaise', 'Montaga' => 'Montaga', 'Montez' => 'Montez', 'Montserrat' => 'Montserrat', 'Montserrat+Alternates' => 'Montserrat Alternates', 'Montserrat+Subrayada' => 'Montserrat Subrayada', 'Moul' => 'Moul', 'Moulpali' => 'Moulpali', 'Mountains+of+Christmas' => 'Mountains of Christmas', 'Mouse+Memoirs' => 'Mouse Memoirs', 'Mr+Bedfort' => 'Mr Bedfort', 'Mr+Dafoe' => 'Mr Dafoe', 'Mr+De+Haviland' => 'Mr De Haviland', 'Mrs+Saint+Delafield' => 'Mrs Saint Delafield', 'Mrs+Sheppards' => 'Mrs Sheppards', 'Muli' => 'Muli', 'Mystery+Quest' => 'Mystery Quest', 'Neucha' => 'Neucha', 'Neuton' => 'Neuton', 'New+Rocker' => 'New Rocker', 'News+Cycle' => 'News Cycle', 'Niconne' => 'Niconne', 'Nixie+One' => 'Nixie One', 'Nobile' => 'Nobile', 'Nokora' => 'Nokora', 'Norican' => 'Norican', 'Nosifer' => 'Nosifer', 'Nothing+You+Could+Do' => 'Nothing You Could Do', 'Noticia+Text' => 'Noticia Text', 'Nova+Cut' => 'Nova Cut', 'Nova+Flat' => 'Nova Flat', 'Nova+Mono' => 'Nova Mono', 'Nova+Oval' => 'Nova Oval', 'Nova+Round' => 'Nova Round', 'Nova+Script' => 'Nova Script', 'Nova+Slim' => 'Nova Slim', 'Nova+Square' => 'Nova Square', 'Numans' => 'Numans', 'Nunito' => 'Nunito', 'Odor+Mean+Chey' => 'Odor Mean Chey', 'Offside' => 'Offside', 'Old+standard+tt' => 'Old Standard TT', 'Oldenburg' => 'Oldenburg', 'Oleo+Script' => 'Oleo Script', 'Oleo+Script+Swash+Caps' => 'Oleo Script Swash Caps', 'Open+Sans' => 'Open Sans', 'Open+Sans+Condensed' => 'Open Sans Condensed', 'Oranienbaum' => 'Oranienbaum', 'Orbitron' => 'Orbitron',  'Oregano' => 'Oregano', 'Orienta' => 'Orienta', 'Original+Surfer' => 'Original Surfer', 'Oswald' => 'Oswald', 'Over+the+Rainbow' => 'Over the Rainbow', 'Overlock' => 'Overlock', 'Overlock+SC' => 'Overlock SC', 'Ovo' => 'Ovo', 'Oxygen' => 'Oxygen', 'Oxygen+Mono' => 'Oxygen Mono', 'PT+Mono' => 'PT Mono', 'PT+Sans' => 'PT Sans', 'PT+Sans+Caption' => 'PT Sans Caption', 'PT+Sans+Narrow' => 'PT Sans Narrow', 'PT+Serif' => 'PT Serif', 'PT+Serif+Caption' => 'PT Serif Caption', 'Pacifico' => 'Pacifico', 'Paprika' => 'Paprika', 'Parisienne' => 'Parisienne', 'Passero+One' => 'Passero One', 'Passion+One' => 'Passion One', 'Patrick+Hand' => 'Patrick Hand', 'Patrick+Hand+SC' => 'Patrick Hand SC', 'Patua+One' => 'Patua One', 'Paytone+One' => 'Paytone One', 'Peralta' => 'Peralta', 'Permanent+Marker' => 'Permanent Marker', 'Petit+Formal+Script' => 'Petit Formal Script', 'Petrona' => 'Petrona', 'Philosopher' => 'Philosopher', 'Piedra' => 'Piedra', 'Pinyon+Script' => 'Pinyon Script', 'Pirata+One' => 'Pirata One', 'Plaster' => 'Plaster', 'Play' => 'Play', 'Playball' => 'Playball', 'Playfair+Display' => 'Playfair Display', 'Playfair+Display+SC' => 'Playfair Display SC', 'Podkova' => 'Podkova', 'Poiret+One' => 'Poiret One', 'Poller+One' => 'Poller One', 'Poly' => 'Poly', 'Pompiere' => 'Pompiere', 'Pontano+Sans' => 'Pontano Sans', 'Port+Lligat+Sans' => 'Port Lligat Sans', 'Port+Lligat+Slab' => 'Port Lligat Slab', 'Prata' => 'Prata', 'Preahvihear' => 'Preahvihear', 'Press+start+2P' => 'Press Start 2P', 'Princess+Sofia' => 'Princess Sofia', 'Prociono' => 'Prociono', 'Prosto+One' => 'Prosto One', 'Puritan' => 'Puritan', 'Purple+Purse' => 'Purple Purse', 'Quando' => 'Quando', 'Quantico' => 'Quantico', 'Quattrocento' => 'Quattrocento', 'Quattrocento+Sans' => 'Quattrocento Sans', 'Questrial' => 'Questrial', 'Quicksand' => 'Quicksand', 'Quintessential' => 'Quintessential', 'Qwigley' => 'Qwigley', 'Racing+sans+One' => 'Racing Sans One', 'Radley' => 'Radley', 'Raleway' => 'Raleway', 'Raleway+Dots' => 'Raleway Dots', 'Rambla' => 'Rambla', 'Rammetto+One' => 'Rammetto One', 'Ranchers' => 'Ranchers', 'Rancho' => 'Rancho', 'Rationale' => 'Rationale', 'Redressed' => 'Redressed', 'Reenie+Beanie' => 'Reenie Beanie', 'Revalia' => 'Revalia', 'Ribeye' => 'Ribeye', 'Ribeye+Marrow' => 'Ribeye Marrow', 'Righteous' => 'Righteous', 'Risque' => 'Risque', 'Roboto' => 'Roboto', 'Roboto+Condensed' => 'Roboto Condensed', 'Rochester' => 'Rochester', 'Rock+Salt' => 'Rock Salt', 'Rokkitt' => 'Rokkitt', 'Romanesco' => 'Romanesco', 'Ropa+Sans' => 'Ropa Sans', 'Rosario' => 'Rosario', 'Rosarivo' => 'Rosarivo', 'Rouge+Script' => 'Rouge Script', 'Ruda' => 'Ruda', 'Rufina' => 'Rufina', 'Ruge+Boogie' => 'Ruge Boogie', 'Ruluko' => 'Ruluko', 'Rum+Raisin' => 'Rum Raisin', 'Ruslan+Display' => 'Ruslan Display', 'Russo+One' => 'Russo One', 'Ruthie' => 'Ruthie', 'Rye' => 'Rye', 'Sacramento' => 'Sacramento', 'Sail' => 'Sail', 'Salsa' => 'Salsa', 'Sanchez' => 'Sanchez', 'Sancreek' => 'Sancreek', 'Sansita+One' => 'Sansita One', 'Sarina' => 'Sarina', 'Satisfy' => 'Satisfy', 'Scada' => 'Scada', 'Schoolbell' => 'Schoolbell', 'Seaweed+Script' => 'Seaweed Script', 'Sevillana' => 'Sevillana', 'Seymour+One' => 'Seymour One', 'Shadows+Into+Light' => 'Shadows Into Light', 'Shadows+Into+Light+Two' => 'Shadows Into Light Two', 'Shanti' => 'Shanti', 'Share' => 'Share', 'Share+Tech' => 'Share Tech', 'Share+Tech+Mono' => 'Share Tech Mono', 'Shojumaru' => 'Shojumaru',  'Short+Stack' => 'Short Stack', 'Siemreap' => 'Siemreap', 'Sigmar+One' => 'Sigmar One', 'Signika' => 'Signika', 'Signika+Negative' => 'Signika Negative', 'Simonetta' => 'Simonetta', 'Sintony' => 'Sintony', 'Sirin+Stencil' => 'Sirin Stencil', 'Six+Caps' => 'Six Caps', 'Skranji' => 'Skranji', 'Slackey' => 'Slackey', 'Smokum' => 'Smokum', 'Smythe' => 'Smythe', 'Sniglet' => 'Sniglet', 'Snippet' => 'Snippet', 'Snowburst+One' => 'Snowburst One', 'Sofadi+One' => 'Sofadi One', 'Sofia' => 'Sofia', 'Sonsie+One' => 'Sonsie One', 'Sorts+Mill+Goudy' => 'Sorts Mill Goudy', 'Source+Code+Pro' => 'Source Code Pro', 'Source+Sans+Pro' => 'Source Sans Pro', 'Special+Elite' => 'Special Elite', 'Spicy+Rice' => 'Spicy Rice', 'Spinnaker' => 'Spinnaker', 'Spirax' => 'Spirax', 'Squada+One' => 'Squada One', 'Stalemate' => 'Stalemate', 'Stalinist+One' => 'Stalinist One', 'Stardos+Stencil' => 'Stardos Stencil', 'Stint+Ultra+Condensed' => 'Stint Ultra Condensed', 'Stint+Ultra+Expanded' => 'Stint Ultra Expanded', 'Stoke' => 'Stoke', 'Strait' => 'Strait', 'Sue+Ellen+Francisco' => 'Sue Ellen Francisco', 'Sunshiney' => 'Sunshiney', 'Supermercado+One' => 'Supermercado One', 'Suwannaphum' => 'Suwannaphum', 'Swanky+and+Moo+Moo' => 'Swanky and Moo Moo',  'Syncopate' => 'Syncopate', 'Tangerine' => 'Tangerine', 'Taprom' => 'Taprom', 'Tauri' => 'Tauri', 'Telex' => 'Telex', 'Tenor+Sans' => 'Tenor Sans', 'Text+Me+One' => 'Text Me One', 'The+Girl+Next+Door' => 'The Girl Next Door', 'Tienne' => 'Tienne', 'Tinos' => 'Tinos', 'Titan+One' => 'Titan One', 'Titillium+Web' => 'Titillium Web', 'Trade+Winds' => 'Trade Winds', 'Trocchi' => 'Trocchi', 'Trochut' => 'Trochut', 'Trykker' => 'Trykker', 'Tulpen+One' => 'Tulpen One', 'Ubuntu' => 'Ubuntu', 'Ubuntu+Condensed' => 'Ubuntu Condensed', 'Ubuntu+Mono' => 'Ubuntu Mono', 'Ultra' => 'Ultra', 'Uncial+Antiqua' => 'Uncial Antiqua', 'Underdog' => 'Underdog', 'Unica+One' => 'Unica One', 'UnifrakturCook' => 'UnifrakturCook', 'UnifrakturMaguntia' => 'UnifrakturMaguntia', 'Unkempt' => 'Unkempt', 'Unna' => 'Unna', 'VT323' => 'VT323', 'Vampiro+One' => 'Vampiro One', 'Varela' => 'Varela', 'Varela+Round' => 'Varela Round', 'Vast+Shadow' => 'Vast Shadow', 'Vibur' => 'Vibur', 'Vidaloka' => 'Vidaloka', 'Viga' => 'Viga', 'Voces' => 'Voces', 'Volkhov' => 'Volkhov', 'Vollkorn' => 'Vollkorn',  'Voltaire' => 'Voltaire', 'Waiting+for+the+sunrise' => 'Waiting for the Sunrise', 'Wallpoet' => 'Wallpoet', 'Walter+Turncoat' => 'Walter Turncoat', 'Warnes' => 'Warnes', 'Wellfleet' => 'Wellfleet', 'Wendy+One' => 'Wendy One', 'Wire+One' => 'Wire One', 'Yanone+Kaffeesatz' => 'Yanone Kaffeesatz', 'Yellowtail' => 'Yellowtail', 'Yeseva+One' => 'Yeseva One', 'Yesteryear' => 'Yesteryear', 'Zeyada' => 'Zeyada');
    $font_families = array(
      'arial' => 'Arial',
      'lucida grande' => 'Lucida grande',
      'segoe ui' => 'Segoe ui',
      'tahoma' => 'Tahoma',
      'trebuchet ms' => 'Trebuchet ms',
      'verdana' => 'Verdana',
      'cursive' =>'Cursive',
      'fantasy' => 'Fantasy',
      'monospace' => 'Monospace',
      'serif' => 'Serif',
    );
    $font_weights = array(
      'lighter' => __('Lighter','wdps_back'),
      'normal' => __('Normal','wdps_back'),
      'bold' => __('Bold','wdps_back'),
    );
    $social_buttons = array(
      'facebook' => __('Facebook','wdps_back'),
      'google-plus' => __('Google+','wdps_back'),
      'twitter' => __('Twitter','wdps_back'),
      'pinterest' => __('Pinterest','wdps_back'),
      'tumblr' => __('Tumblr','wdps_back'),
    );
    $free_effects = array('none', 'fade', 'sliceH', 'fan', 'scaleIn');
    $effects = array(
       'none' => 'None',
      'fade' => 'Fade',
      'sliceH' => 'Slice Horizontal',
      'fan' => 'Fan',
      'scaleIn' => 'Scale In',
      'zoomFade' => 'Zoom Fade',
      'parallelSlideH' => 'Parallel Slide Horizontal',
      'parallelSlideV' => 'Parallel Slide Vertical',
      'slic3DH' => 'Slice 3D Horizontal',
      'slic3DV' => 'Slice 3D Vertical',
      'slicR3DH' => 'Slice 3D Horizontal Random',
      'slicR3DV' => 'Slice 3D Vertical Random',
      'blindR' => 'Blind',
      'tilesR' => 'Tiles',
      'blockScaleR' => 'Block Scale Random',
      'cubeH' => 'Cube Horizontal',
      'cubeV' => 'Cube Vertical',
      'cubeR' => 'Cube Random',
      'sliceV' => 'Slice Vertical',
      'slideH' => 'Slide Horizontal',
      'slideV' => 'Slide Vertical',
      'scaleOut' => 'Scale Out',
      'blockScale' => 'Block Scale',
      'kaleidoscope' => 'Kaleidoscope',
      'blindH' => 'Blind Horizontal',
      'blindV' => 'Blind Vertical',
      'random' => 'Random',
      '3Drandom' => '3D Random',
    );
    $free_layer_effects = array('none', 'bounce', 'tada', 'bounceInDown', 'bounceOutUp', 'fadeInLeft', 'fadeOutRight');
    $layer_effects_in = array(
      'none' => 'None',
      'bounce' => 'Bounce',
      'tada' => 'Tada',
      'bounceInDown' => 'BounceInDown',
      'fadeInLeft' => 'FadeInLeft',
      'flash' => 'Flash',
      'pulse' => 'Pulse',
      'rubberBand' => 'RubberBand',
      'shake' => 'Shake',
      'swing' => 'Swing',
      'wobble' => 'Wobble',
      'hinge' => 'Hinge',
      
      'lightSpeedIn' => 'LightSpeedIn',
      'rollIn' => 'RollIn',
      
      'bounceIn' => 'BounceIn',
      'bounceInLeft' => 'BounceInLeft',
      'bounceInRight' => 'BounceInRight',
      'bounceInUp' => 'BounceInUp',
      
      'fadeIn' => 'FadeIn',
      'fadeInDown' => 'FadeInDown',
      'fadeInDownBig' => 'FadeInDownBig',
      'fadeInLeftBig' => 'FadeInLeftBig',
      'fadeInRight' => 'FadeInRight',
      'fadeInRightBig' => 'FadeInRightBig',
      'fadeInUp' => 'FadeInUp',
      'fadeInUpBig' => 'FadeInUpBig',
      
      'flip' => 'Flip',
      'flipInX' => 'FlipInX',
      'flipInY' => 'FlipInY',
      
      'rotateIn' => 'RotateIn',
      'rotateInDownLeft' => 'RotateInDownLeft',
      'rotateInDownRight' => 'RotateInDownRight',
      'rotateInUpLeft' => 'RotateInUpLeft',
      'rotateInUpRight' => 'RotateInUpRight',
        
      'zoomIn' => 'ZoomIn',
      'zoomInDown' => 'ZoomInDown',
      'zoomInLeft' => 'ZoomInLeft',
      'zoomInRight' => 'ZoomInRight',
      'zoomInUp' => 'ZoomInUp',          
    );
    $layer_effects_out = array(
      'none' => 'None',
      'bounce' => 'Bounce',
      'tada' => 'Tada',
      'bounceInDown' => 'BounceInDown',
      'fadeInLeft' => 'FadeInLeft',
      'flash' => 'Flash',
      'pulse' => 'Pulse',
      'rubberBand' => 'RubberBand',
      'shake' => 'Shake',
      'swing' => 'Swing',
      'wobble' => 'Wobble',
      'hinge' => 'Hinge',
      
      'lightSpeedIn' => 'LightSpeedIn',
      'rollIn' => 'RollIn',
      
      'bounceIn' => 'BounceIn',
      'bounceInLeft' => 'BounceInLeft',
      'bounceInRight' => 'BounceInRight',
      'bounceInUp' => 'BounceInUp',
      
      'fadeIn' => 'FadeIn',
      'fadeInDown' => 'FadeInDown',
      'fadeInDownBig' => 'FadeInDownBig',
      'fadeInLeftBig' => 'FadeInLeftBig',
      'fadeInRight' => 'FadeInRight',
      'fadeInRightBig' => 'FadeInRightBig',
      'fadeInUp' => 'FadeInUp',
      'fadeInUpBig' => 'FadeInUpBig',
      
      'flip' => 'Flip',
      'flipInX' => 'FlipInX',
      'flipInY' => 'FlipInY',
      
      'rotateIn' => 'RotateIn',
      'rotateInDownLeft' => 'RotateInDownLeft',
      'rotateInDownRight' => 'RotateInDownRight',
      'rotateInUpLeft' => 'RotateInUpLeft',
      'rotateInUpRight' => 'RotateInUpRight',
        
      'zoomIn' => 'ZoomIn',
      'zoomInDown' => 'ZoomInDown',
      'zoomInLeft' => 'ZoomInLeft',
      'zoomInRight' => 'ZoomInRight',
      'zoomInUp' => 'ZoomInUp',   
    );
    $hotp_text_positions = array(
      'top' => __('Top','wdps_back'),
      'left' => __('Left','wdps_back'),
      'bottom' => __('Bottom','wdps_back'),
      'right' => __('Right','wdps_back'),
    );
   if (get_option("wdps_theme_version")) {
      $fv = TRUE;
      $fv_class = 'spider_free_version_label';
      $fv_disabled = 'disabled="disabled"';
      $fv_message = '<tr><td colspan="2"><div class="wd_error" style="padding: 5px; font-size: 14px; color: #000000 !important;">Some options are disabled in free version.</div></td></tr>';
      $fv_title = ' title="This option is disabled in free version."';
    }
    else {
      $fv = FALSE;
      $fv_class = '';
      $fv_disabled = '';
      $fv_message = '';
      $fv_title = '';
    }
    
    foreach (scandir(path_join(WD_PS_DIR, 'fonts')) as $filename) {
      if (strpos($filename, '.') === 0) {
        continue;
      }
    }
    ?>
    <style>
    <?php  
    
      global $wp_version;
      if (version_compare($wp_version, '4','<')) {
    ?>
      #wpwrap {
        background-color:#F1F1F1
      }
      
      .tab_button_wrap {
        width:46%;
      }
      
      .tab_button_wrap .wdps_button-secondary {
          margin-right: 7px;
      }
      @media  screen and (max-width: 640px) {
        .buttons_div input {
          width:31%;
          font-size:11px
        }
        
        body{
          min-width:inherit !Important;  
        }
        
        .tablenav{
          height:auto
        }
        
        #wpcontent{
          margin-left:40px!important
        }
        .tab_button_wrap, .buttons_conteiner .wdps_buttons .wdps_button_wrap {
          width:48.5%;
        }
        .action_buttons {
            font-size: 10px !important;
        }
        .add_social_layer {
          padding: 0 7px 1px 35px !important;
        }
         #TB_window{
          top:5% !important
        }

        .attachments-browser .attachments{
          right:0 !Important
        }
        .media-modal {
          width: 100% !Important;
          left:0 !Important;
          position:fixed !important
        }
        .media-sidebar{
          bottom:120% !Important;
          padding:0 !Important
        }
        .media-modal-backdrop{
          position:fixed !important
        }
        .uploader-inline{
          right:0!important
        }

      }
    <?php
      }
    ?>
    </style>
    <div class="spider_message_cont"></div>
    <div class="spider_load">
      <div class="spider_load_cont"></div>
      <div class="spider_load_icon"><img class="spider_ajax_loading" src="<?php echo WD_PS_URL . '/images/ajax_loader.gif'; ?>"></div>
    </div>
    <div style="clear: both; float: left; width: 99%;">
      <div style="float: left; font-size: 14px; font-weight: bold;">
        This section allows you to add/edit slider.
        <a style="color: blue; text-decoration: none;" target="_blank" href="https://web-dorado.com/wordpress-post-slider-wd/creating-post-sliders.html">Read More in User Manual</a>
      </div>
      <div style="float: right; text-align: right;">
        <a style="text-decoration: none;" target="_blank" href="https://web-dorado.com/files/frompostslider.php">
          <img width="215" border="0" alt="web-dorado.com" src="<?php echo WD_PS_URL . '/images/wd_logo.png'; ?>" />
        </a>
      </div>
    </div>
    <form class="wrap wdps_forms" method="post" id="sliders_form" action="admin.php?page=sliders_wdps" style="float: left; width: 99%;">
      <?php wp_nonce_field('nonce_wd', 'nonce_wd'); ?>
      <span class="slider-icon"></span>
      <h2><?php echo $page_title; ?></h2>
      <div class="buttons_conteiner">
      <div class="slider_title_conteiner">
        <span class="spider_label"><label for="name"><?php echo __('Slider Title:','wdps_back'); ?> <span style="color:#FF0000;">*</span> </label></span>
        <span><input type="text" id="name" name="name" value="<?php echo $row->name; ?>" size="20" /></span>
      </div>
      <div class="wdps_buttons">
         <div class="wdps_button_wrap">
            <input class="wdps_button-secondary wdps_save_slider" type="button" onclick="if (wdps_check_required('name', 'Name')) {return false;};
                                                                   spider_set_input_value('task', 'save');
                                                                   spider_ajax_save('sliders_form', event);" value="<?php echo __('Save','wdps_back'); ?>" />
         </div>
        <div class="wdps_button_wrap"> 
          <input class="wdps_button-secondary wdps_aplly_slider" type="button" onclick="if (wdps_check_required('name', 'Name')) {return false;};
                                                                   spider_set_input_value('task', 'apply');
                                                                   spider_ajax_save('sliders_form', event);" value="<?php echo __('Apply','wdps_back'); ?>" />
         </div>
       
         
        <div class="wdps_button_wrap">
          <input class="wdps_button-secondary last wdps_cancel" type="submit" onclick="spider_set_input_value('task', 'cancel')" value="<?php echo __('Cancel','wdps_back'); ?>" />
        </div>
      </div>
       <div class="wdps_clear"></div>
      </div>
      <div>
        <div class="wdps_reset_button">
          <input class="reset_settings" type="button" onclick="if (wdps_check_required('name', 'Name')) {return false;};
                                                                   spider_set_input_value('task', 'reset');
                                                                   spider_ajax_save('sliders_form', event);" value="<?php echo __('Reset Settings','wdps_back'); ?>" />
        </div>
        
        <!--------------Settings tab----------->
        <div class="wdps_box wdps_settings_box">
        <table>
						<thead>
							<tr>
								<td colspan="4">
									<div class="tab_conteiner">
										<div class="tab_button_wrap setting_tab_button_wrap" onclick="wdps_change_tab(this, 'wdps_settings_box')">
											<a class="wdps_button-secondary wdps_settings" href="#">
												<span tab_type="settings" class="wdps_tab_label"><?php echo __('Settings','wdps_back'); ?></span>
											</a>
										</div>
										<div class="tab_button_wrap slides_tab_button_wrap" onclick="wdps_change_tab(this, 'wdps_slides_box')">
											<a class="wdps_button-secondary wdps_slides" href="#">
												<span tab_type="slides" class="wdps_tab_label"><?php echo __('Slides','wdps_back'); ?></span>
											</a>
										</div>
										<div class="clear"></div>
									</div>
								</td>
							</tr>
						</thead>
				</table>
      
          <div class="wdps_nav_tabs">
            <ul>
              <li tab_type="global" onclick="wdps_change_nav(this, 'wdps_nav_global_box')">
                <a href="#"><?php echo __('Global','wdps_back'); ?> </a>
              </li>
              <li tab_type="carousel" onclick="wdps_change_nav(this, 'wdps_nav_carousel_box')">
                <a href="#"><?php echo __('Carousel','wdps_back'); ?></a>
              </li>
               <!--<li tab_type="dynamic" onclick="wdps_change_nav(this, 'wdps_nav_dynamic_box')">
                <a href="#"><?php echo __('Dynamic post','wdps_back'); ?></a>
              </li>-->
              <li tab_type="navigation" onclick="wdps_change_nav(this, 'wdps_nav_navigation_box')" >
                <a href="#"><?php echo __('Navigation','wdps_back'); ?></a>
              </li>
              <li tab_type="bullets" onclick="wdps_change_nav(this, 'wdps_nav_bullets_box')" >
                <a href="#"><?php echo __('Bullets','wdps_back'); ?></a>
              </li>
              <li tab_type="filmstrip" onclick="wdps_change_nav(this, 'wdps_nav_filmstrip_box')" >
                <a href="#"><?php echo __('Filmstrip','wdps_back'); ?></a>
              </li>
              <li tab_type="timer_bar" onclick="wdps_change_nav(this, 'wdps_nav_timer_bar_box')" >
                <a href="#"><?php echo __('Timer bar','wdps_back'); ?></a>
              </li>
              
              <li tab_type="css" onclick="wdps_change_nav(this, 'wdps_nav_css_box')" >
                <a href="#"><?php echo __('CSS','wdps_back'); ?> </a>
              </li>
            </ul>
          </div>
          <div>
            <div class="wdps_nav_box wdps_nav_global_box">
              <table>
                <tbody>
                  <tr>
                    <td class="spider_label"><label><?php echo __('Dimensions:','wdps_back'); ?> </label></td>
                    <td>
                      <input type="text" name="width" id="width" value="<?php echo $row->width; ?>" class="spider_int_input" onchange="wdps_whr('width')" onkeypress="return spider_check_isnum(event)" /> x 
                      <input type="text" name="height" id="height" value="<?php echo $row->height; ?>" class="spider_int_input" onchange="wdps_whr('height')" onkeypress="return spider_check_isnum(event)" /> px
                      <div class="spider_description"><?php echo __('Maximum width and height for slider.','wdps_back'); ?></div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label><?php echo __('Full width:','wdps_back'); ?> </label></td>
                    <td>
                      <input type="radio" id="full_width1" name="full_width" <?php echo (($row->full_width) ? 'checked="checked"' : ''); ?> value="1" /><label <?php echo (($row->full_width) ? 'class="selected_color"' : ''); ?> for="full_width1"><?php echo __('Yes','wdps_back');?></label>
                      <input type="radio" id="full_width0" name="full_width" <?php echo (($row->full_width) ? '' : 'checked="checked"'); ?> value="0" /><label <?php echo ($row->full_width) ? '' : 'class="selected_color"'; ?> for="full_width0"><?php echo __('No','wdps_back');?></label>
                      <input type="text" name="ratio" id="ratio" value="" class="spider_int_input" onchange="wdps_whr('ratio')" onkeypress="return spider_check_isnum(event)" /><label for="ratio"><?php echo __('Ratio','wdps_back'); ?></label>
                      <div class="spider_description"><?php echo __('The image will stretch to the page width, taking the height based on dimensions ratio.','wdps_back'); ?></div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label><?php echo __('Background fit:','wdps_back'); ?> </label></td>
                    <td>
                      <input type="radio" name="bg_fit" id="bg_fit_cover" value="cover" <?php if ($row->bg_fit == 'cover') echo 'checked="checked"'; ?> onchange="jQuery('div[id^=\'wdps_preview_image\']').css({backgroundSize: 'cover'})" /><label <?php echo $row->bg_fit == 'cover' ?  'class="selected_color"' : ''; ?> for="bg_fit_cover"><?php echo __('Cover','wdps_back'); ?></label>
                      <input type="radio" name="bg_fit" id="bg_fit_fill" value="100% 100%" <?php if ($row->bg_fit == '100% 100%') echo 'checked="checked"'; ?> onchange="jQuery('div[id^=\'wdps_preview_image\']').css({backgroundSize: '100% 100%'})" /><label <?php echo $row->bg_fit == '100% 100%' ?  'class="selected_color"' : ''; ?> for="bg_fit_fill"><?php echo __('Fill','wdps_back'); ?></label>
                      <input type="radio" name="bg_fit" id="bg_fit_contain" value="contain" <?php if ($row->bg_fit == 'contain') echo 'checked="checked"'; ?> onchange="jQuery('div[id^=\'wdps_preview_image\']').css({backgroundSize: 'contain'})" /><label <?php echo $row->bg_fit == 'contain' ?  'class="selected_color"' : ''; ?> for="bg_fit_contain"><?php echo __('Contain','wdps_back'); ?></label>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="align"><?php echo __('Align:','wdps_back'); ?> </label></td>
                    <td>
                      <select class="select_icon select_icon_320" name="align" id="align">
                        <?php
                       
                        foreach ($aligns as $key => $align) {
                          ?>
                          <option value="<?php echo $key; ?>" <?php echo (($row->align == $key) ? 'selected="selected"' : ''); ?>><?php echo $align; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                      <div class="spider_description"><?php echo __('Set the alignment of the slider.','wdps_back'); ?></div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label_options">
                      <label for="effect"><?php echo __('Effect:','wdps_back'); ?></label>
                    </td>
                    <td>
                      <select class="select_icon select_icon_320" name="effect" id="effect">
                        <?php
                        foreach ($effects as $key => $effect) {
                          ?>
                           <option value="<?php echo $key; ?>" <?php echo (!in_array($key, $free_effects)) ? 'disabled="disabled" title="This effect is disabled in free version."' : ''; ?> <?php if ($row->effect == $key) echo 'selected="selected"'; ?>><?php echo $effect; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                       <div class="wd_error" style="padding: 5px; font-size: 14px; color: #000000 !important;">Some effects are disabled in free version.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="effect_duration"><?php echo __('Effect duration:','wdps_back'); ?> </label></td>
                    <td>
                      <input type="text" id="effect_duration" name="effect_duration" value="<?php echo $row->effect_duration; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" /> ms
                      <div class="spider_description"><?php echo __('Define the time for the effect.','wdps_back'); ?></div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label spider_free_version_label"><label><?php echo __('Parallax Effect:','wdps_back'); ?> </label></td>
                    <td>
                      <input disabled="disabled" type="radio" id="parallax_effect1" name="parallax_effect" <?php echo (($row->parallax_effect) ? 'checked="checked"' : ''); ?> value="1" /><label <?php echo (($row->parallax_effect) ? 'class="selected_color"' : ''); ?> for="parallax_effect1"><?php echo __('Yes','wdps_back'); ?></label>
                      <input disabled="disabled" type="radio" id="parallax_effect0" name="parallax_effect" <?php echo (($row->parallax_effect) ? '' : 'checked="checked"'); ?> value="0" /><label <?php echo (($row->parallax_effect) ? '' : 'class="selected_color"'); ?> for="parallax_effect0"><?php echo __('No','wdps_back'); ?></label>
                      <div class="spider_description"><?php echo __('The direction of the movement, as well as the layer moving pace depend on the z-index value.','wdps_back'); ?></div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label><?php echo __('Autoplay:','wdps_back'); ?> </label></td>
                    <td>
                      <input type="radio" id="autoplay1" name="autoplay" <?php echo (($row->autoplay) ? 'checked="checked"' : ''); ?> value="1" /><label <?php echo (($row->autoplay) ? 'class="selected_color"' : ''); ?> for="autoplay1"><?php echo __('Yes','wdps_back'); ?></label>
                      <input type="radio" id="autoplay0" name="autoplay" <?php echo (($row->autoplay) ? '' : 'checked="checked"'); ?> value="0" /><label <?php echo (($row->autoplay) ? '' : 'class="selected_color"'); ?> for="autoplay0"><?php echo __('No','wdps_back'); ?></label>
                      <div class="spider_description"><?php echo __('Choose whether to autoplay the sliders or not.','wdps_back'); ?></div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="time_intervval"><?php echo __('Time Interval:','wdps_back'); ?> </label></td>
                    <td>
                      <input type="text" id="time_intervval" name="time_intervval" value="<?php echo $row->time_intervval; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" /> <?php echo __('sec.','wdps_back'); ?>
                      <div class="spider_description"><?php echo __('Set the time interval for the change of the sliders when autoplay is on.','wdps_back'); ?> </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label><?php echo __('Stop on hover:','wdps_back'); ?> </label></td>
                    <td>
                      <input type="radio" id="stop_animation1" name="stop_animation" <?php echo (($row->stop_animation) ? 'checked="checked"' : ''); ?> value="1" /><label <?php echo (($row->stop_animation) ? 'class="selected_color"' : ''); ?> for="stop_animation1"><?php echo __('Yes','wdps_back');?></label>
                      <input type="radio" id="stop_animation0" name="stop_animation" <?php echo (($row->stop_animation) ? '' : 'checked="checked"'); ?> value="0" /><label <?php echo (($row->stop_animation) ? '' : 'class="selected_color"'); ?> for="stop_animation0"><?php echo __('No','wdps_back'); ?></label></label>
                      <div class="spider_description"><?php echo __('The option works when autoplay is on.','wdps_back'); ?></div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label><?php echo __('Shuffle:','wdps_back'); ?> </label></td>
                    <td>
                      <input type="radio" id="shuffle1" name="shuffle" <?php echo (($row->shuffle) ? 'checked="checked"' : ''); ?> value="1" /><label <?php echo (($row->shuffle) ? 'class="selected_color"' : ''); ?> for="shuffle1"><?php echo __('Yes','wdps_back'); ?></label>
                      <input type="radio" id="shuffle0" name="shuffle" <?php echo (($row->shuffle) ? '' : 'checked="checked"'); ?> value="0" /><label <?php echo (($row->shuffle) ? '' : 'class="selected_color"'); ?> for="shuffle0"> <?php echo __('No','wdps_back'); ?></label>
                      <div class="spider_description"><?php echo __('Choose whether to have the slides change in a random manner or to keep the original sequence.','wdps_back'); ?></div>
                    </td>
                  </tr> 
                  <tr>
                    <td class="spider_label"><label for="start_slide_num"><?php echo __('Start with slide:','wdps_back'); ?> </label></td>
                    <td>
                      <input type="text" name="start_slide_num" id="start_slide_num" value="<?php echo $row->start_slide_num; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" />
                      <div class="spider_description"><?php echo __('The slider will start with the specified slide. You can use the value 0 for random.','wdps_back'); ?></div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label><?php echo __('Music:','wdps_back'); ?> </label></td>
                    <td>
                     <input type="radio" id="music1" name="music" <?php echo (($row->music) ? 'checked="checked"' : ''); ?> value="1" onClick="bwg_enable_disable('', 'tr_music_url', 'music1')" /><label <?php echo (($row->music) ? 'class="selected_color"' : ''); ?> for="music1"><?php echo __('Yes','wdps_back'); ?></label>
                      <input type="radio" id="music0" name="music" <?php echo (($row->music) ? '' : 'checked="checked"'); ?> value="0" onClick="bwg_enable_disable('none', 'tr_music_url', 'music0')" /><label <?php echo (($row->music) ? '' : 'class="selected_color"'); ?> for="music0"><?php echo __('No','wdps_back'); ?></label>
                      <div class="spider_description"><?php echo __('Choose whether to have music/audio track playback with the slider or not.','wdps_back'); ?></div>
                    </td>
                  </tr>
                  <tr id="tr_music_url">
                    <td class="spider_label_options">
                      <label for="music_url"><?php echo __('Music url:','wdps_back'); ?> </label>
                    </td>
                    <td>
                      <input type="text" id="music_url" name="music_url" size="39" value="<?php echo $row->music_url; ?>" style="display:inline-block;" />
                      <input id="add_music_url" class="button-primary" type="button" onclick="spider_media_uploader('music', event, false); return false;" value="Add music" />
                      <div class="spider_description"><?php echo __('Only .aac,.m4a,.f4a,.mp3,.ogg,.oga formats are supported.','wdps_back'); ?></div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label><?php echo __('Smart Load:','wdps_back'); ?> </label></td>
                    <td>
                      <input type="radio" id="preload_images1" name="preload_images" <?php echo (($row->preload_images) ? 'checked="checked"' : ''); ?> value="1" /><label <?php echo (($row->preload_images) ? 'class="selected_color"' : ''); ?> for="preload_images1"><?php echo __('Yes','wdps_back'); ?></label>
                      <input type="radio" id="preload_images0" name="preload_images" <?php echo (($row->preload_images) ? '' : 'checked="checked"'); ?> value="0" /><label <?php echo (($row->preload_images) ? '' : 'class="selected_color"'); ?> for="preload_images0"><?php echo __('No','wdps_back');?></label>
                      <div class="spider_description"><?php echo __('Choose to have faster load for the first few images and process the rest meanwhile.','wdps_back'); ?></div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="background_color"><?php echo __('Background color:','wdps_back'); ?></label></td>
                    <td>
                      <input type="text" name="background_color" id="background_color" value="<?php echo $row->background_color; ?>" class="color" onchange="jQuery('div[id^=\'wdps_preview_image\']').css({backgroundColor: wdps_hex_rgba(jQuery(this).val(), 100 - jQuery('#background_transparent').val())})" />
                      <input id="background_transparent" name="background_transparent" class="spider_int_input" type="text" onchange="jQuery('div[id^=\'wdps_preview_image\']').css({backgroundColor: wdps_hex_rgba(jQuery('#background_color').val(), 100 - jQuery(this).val())})" onkeypress="return spider_check_isnum(event)" value="<?php echo $row->background_transparent; ?>" /> %
                      <div class="spider_description"><?php echo __('Transparency value must be between 0 to 100.','wdps_back'); ?> </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="glb_border_width"><?php echo __('Border:','wdps_back'); ?> </label></td>
                    <td>
                      <input type="text" name="glb_border_width" id="glb_border_width" value="<?php echo $row->glb_border_width; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" /> px 
                      <select class="select_icon select_icon_320" name="glb_border_style" id="glb_border_style" >
                        <?php
                        foreach ($border_styles as $key => $border_style) {
                          ?>
                          <option value="<?php echo $key; ?>" <?php echo (($row->glb_border_style == $key) ? 'selected="selected"' : ''); ?>><?php echo $border_style; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                      <input type="text" name="glb_border_color" id="glb_border_color" value="<?php echo $row->glb_border_color; ?>" class="color" />
                      <div class="spider_description"><?php echo __('Set the border width, type and the color.','wdps_back');?></div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="glb_border_radius"><?php echo __('Border radius:','wdps_back'); ?> </label></td>
                    <td>
                      <input type="text" name="glb_border_radius" id="glb_border_radius" value="<?php echo $row->glb_border_radius; ?>" class="spider_char_input" />
                      <div class="spider_description"><?php echo __('Use CSS type values.','wdps_back'); ?></div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="glb_margin"><?php echo __('Margin:','wdps_back'); ?></label></td>
                    <td>
                      <input type="text" name="glb_margin" id="glb_margin" value="<?php echo $row->glb_margin; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" /> px
                      <div class="spider_description"><?php echo __('Set a margin for the slider.','wdps_back'); ?></div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="glb_box_shadow"><?php echo __('Shadow:','wdps_back'); ?> </label></td>
                    <td>
                      <input type="text" name="glb_box_shadow" id="glb_box_shadow" value="<?php echo $row->glb_box_shadow; ?>" class="spider_box_input" />
                      <div class="spider_description"><?php echo __('Use CSS type values (e.g. 10px 10px 5px #888888).','wdps_back'); ?></div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label_options">
                      <label><?php echo __('Right click protection:','wdps_back'); ?> </label>
                    </td>
                    <td>
                      <input type="radio" name="image_right_click" id="image_right_click_1" value="1" <?php if ($row->image_right_click) echo 'checked="checked"'; ?> /><label <?php echo $row->image_right_click ? 'class="selected_color"' : ''; ?> for="image_right_click_1"><?php echo __('Yes','wdps_back'); ?></label>
                      <input type="radio" name="image_right_click" id="image_right_click_0" value="0" <?php if (!$row->image_right_click) echo 'checked="checked"'; ?> /><label <?php echo $row->image_right_click ? '' : 'class="selected_color"'; ?> for="image_right_click_0"><?php echo __('No','wdps_back'); ?></label>
                      <div class="spider_description"><?php echo __('Disable image right click possibility.','wdps_back'); ?></div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label_options">
                      <label><?php echo __('Layer out on next:','wdps_back'); ?> </label>
                    </td>
                    <td>
                      <input type="radio" name="layer_out_next" id="layer_out_next_1" value="1" <?php if ($row->layer_out_next) echo 'checked="checked"'; ?> /><label <?php echo $row->layer_out_next ? 'class="selected_color"' : ''; ?>  for="layer_out_next_1"><?php echo __('Yes','wdps_back'); ?></label>
                      <input type="radio" name="layer_out_next" id="layer_out_next_0" value="0" <?php if (!$row->layer_out_next) echo 'checked="checked"'; ?> /><label <?php echo $row->layer_out_next ? '' : 'class="selected_color"'; ?> for="layer_out_next_0"><?php echo __('No','wdps_back'); ?></label>
                      <div class="spider_description"><?php echo __('Choose whether to have the layer effect out regardless of the timing between the hit to the next slider or skip the effect out and get to the next image.','wdps_back'); ?></div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="layer_word_count"><?php echo __('Text layer character limit:','wdps_back'); ?> </label></td>
                    <td>
                      <input type="text" name="layer_word_count" id="layer_word_count" value="<?php echo $row->layer_word_count; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" />
                      <div class="spider_description"><?php echo __('This will limit the number of characters for post content displayed as a text layer.','wdps_back'); ?></div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="possib_add_ffamily_input"><?php echo __('Add font-family:','wdps_back'); ?> </label></td>
                    <td>
                      <input type="text" id="possib_add_ffamily_input" value="" class="spider_box_input" onchange="set_ffamily_value(jQuery(this).val())" />
                      <input type="hidden" id="possib_add_ffamily" name="possib_add_ffamily" value="<?php echo $row->possib_add_ffamily; ?>" /> 
                      <div class="spider_description"><?php echo __('The added font family will appear in the drop-down list of fonts.','wdps_back'); ?></div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label><?php echo __('Published:','wdps_back'); ?> </label></td>
                    <td>
                      <input type="radio" name="published" id="published1" value="1" <?php if ($row->published) echo 'checked="checked"'; ?> /><label <?php echo $row->published ? 'class="selected_color"' : ''; ?> for="published"><?php echo __('Yes','wdps_back'); ?></label>
                      <input type="radio" name="published" id="published0" value="0" <?php if (!$row->published) echo 'checked="checked"'; ?> /><label <?php echo $row->published ? '' : 'class="selected_color"'; ?> for="published0"><?php echo __('No','wdps_back'); ?></label>
                      <div class="spider_description"><?php echo __('Choose whether to publish the mentioned slider or not.','wdps_back'); ?></div>
                    </td>
                  </tr>                
                </tbody>
              </table>
            </div>
            <div class="wdps_nav_box wdps_nav_carousel_box spider_free_version_label" title="This functionality is disabled in free version.">
              <table>
                <tbody>
                  <tr>
                    <td colspan="2">
                      <div class="wd_error" style="padding: 5px; font-size: 14px; color: #000000 !important;">Carousel is disabled in free version.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label>Carousel: </label></td>
                    <td>
                      <input disabled="disabled" type="radio" id="carousel1" name="carousel" <?php echo (($row->carousel) ? 'checked="checked"' : ''); ?> value="1" /><label for="carousel1">Yes</label>
                      <input disabled="disabled" type="radio" id="carousel0" name="carousel" <?php echo (($row->carousel) ? '' : 'checked="checked"'); ?> value="0" /><label for="carousel0">No</label>
                      <div class="spider_description">If you activate this feature the effects you had chosen in Global settings for your slider will not play.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="carousel_image_counts">Number of images for carousel: </label></td>
                    <td>
                      <input disabled="disabled" type="text" id="carousel_image_counts" name="carousel_image_counts" value="<?php echo $row->carousel_image_counts; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" />
                      <div class="spider_description"></div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="carousel_image_parameters">Carousel image ratio: </label></td>
                    <td>
                      <input disabled="disabled" type="text" id="carousel_image_parameters" name="carousel_image_parameters" value="<?php echo $row->carousel_image_parameters; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" />
                      <div class="spider_description">The value must be between 0 and 1.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label>Container fit: </label></td>
                    <td>
                      <input disabled="disabled" type="radio" id="carousel_fit_containerWidth1" name="carousel_fit_containerWidth" <?php echo (($row->carousel_fit_containerWidth) ? 'checked="checked"' : ''); ?> value="1" /><label for="carousel_fit_containerWidth1">Yes</label>
                      <input disabled="disabled" type="radio" id="carousel_fit_containerWidth0" name="carousel_fit_containerWidth" <?php echo (($row->carousel_fit_containerWidth) ? '' : 'checked="checked"'); ?> value="0" /><label for="carousel_fit_containerWidth0">No</label>
                      <div class="spider_description"></div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="carousel_width">Fixed width: </label></td>
                    <td>
                      <input disabled="disabled" type="text" id="carousel_width" name="carousel_width" value="<?php echo $row->carousel_width; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" /> px
                      <div class="spider_description"></div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="wdps_nav_box wdps_nav_navigation_box">
              <table>
                <tbody>
                  <tr>
                    <td class="spider_label_options">
                      <label><?php echo __('Next / Previous buttons:','wdps_back'); ?> </label>
                    </td>
                    <td>
                       <input type="radio" name="prev_next_butt" id="prev_next_butt_1" value="1" <?php if ($row->prev_next_butt) echo 'checked="checked"'; ?> /><label <?php echo $row->prev_next_butt ? 'class="selected_color"' : ''; ?> for="prev_next_butt_1"><?php echo __('Yes','wdps_back'); ?></label>
                      <input type="radio" name="prev_next_butt" id="prev_next_butt_0" value="0" <?php if (!$row->prev_next_butt) echo 'checked="checked"'; ?> /><label <?php echo $row->prev_next_butt ? '' : 'class="selected_color"'; ?> for="prev_next_butt_0"><?php echo __('No','wdps_back'); ?></label>
                      <div class="spider_description"><?php echo __('Choose whether to display Previous and Next buttons or not.','wdps_back'); ?></div>
                    </td>
                  </tr> 
                  <tr>
                    <td class="spider_label_options">
                      <label><?php echo __('Show Navigation buttons:','wdps_back');?> </label>
                    </td>
                    <td>
                      <input type="radio" name="navigation" id="navigation_1" value="hover" <?php if ($row->navigation == 'hover') echo 'checked="checked"'; ?> /><label for="navigation_1"><?php echo __('On hover','wdps_back'); ?></label>
                      <input type="radio" name="navigation" id="navigation_0" value="always" <?php if ($row->navigation == 'always' ) echo 'checked="checked"'; ?> /><label for="navigation_0"><?php echo __('Always','wdps_back'); ?></label>
                      <div class="spider_description"><?php echo __('Select between the option of always displaying the navigation buttons or only when hovered.','wdps_back'); ?></div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label_options">
                      <label><?php echo __('Image for Next / Previous buttons:','wdps_back'); ?> </label>
                    </td>
                    <td>
                      <input type="radio" name="rl_butt_img_or_not" id="rl_butt_img_or_not_our" value="our" <?php if ($row->rl_butt_img_or_not == 'our') echo 'checked="checked"'; ?> onClick="image_for_next_prev_butt('our')" /><label <?php if ($row->rl_butt_img_or_not == 'our') echo 'class="selected_color"'; ?> for="rl_butt_img_or_not_our"><?php echo __('Default','wdps_back'); ?></label>
                      <input type="radio" name="rl_butt_img_or_not" id="rl_butt_img_or_not_cust" value="custom" <?php if ($row->rl_butt_img_or_not == 'custom') echo 'checked="checked"'; ?> onClick="image_for_next_prev_butt('custom')" /><label <?php if ($row->rl_butt_img_or_not == 'custom') echo 'class="selected_color"'; ?> for="rl_butt_img_or_not_cust"><?php echo __('Custom','wdps_back'); ?></label>
                      <input type="radio" name="rl_butt_img_or_not" id="rl_butt_img_or_not_style" value="style" <?php if ($row->rl_butt_img_or_not == 'style') echo 'checked="checked"'; ?> onClick="image_for_next_prev_butt('style')" /><label <?php if ($row->rl_butt_img_or_not == 'style') echo 'class="selected_color"'; ?> for="rl_butt_img_or_not_style"> <?php echo __('Styled','wdps_back'); ?></label>
                      <input type="hidden" id="right_butt_url" name="right_butt_url" value="<?php echo $row->right_butt_url; ?>" />
                      <input type="hidden" id="right_butt_hov_url" name="right_butt_hov_url" value="<?php echo $row->right_butt_hov_url; ?>" />
                      <input type="hidden" id="left_butt_url" name="left_butt_url" value="<?php echo $row->left_butt_url; ?>" />
                      <input type="hidden" id="left_butt_hov_url" name="left_butt_hov_url" value="<?php echo $row->left_butt_hov_url; ?>" />
                      <div class="spider_description"><?php echo __('Choose whether to use default navigation buttons or to upload custom ones.','wdps_back'); ?></div>
                    </td>
                  </tr>
                  </tbody>
                <tbody class="<?php echo $fv_class; ?>"<?php echo $fv_title; ?>>
                  <?php echo $fv_message; ?>
                  <tr id="right_left_butt_style">
                    <td class="spider_label<?php echo $fv_class; ?>"><label for="rl_butt_style"><?php echo __('Next / Previous buttons style:','wdps_back'); ?> </label></td>
                    <td>
                      <div style="display: table;">
                        <div style="display: table-cell; vertical-align: middle;">
                          <select class="select_icon select_icon_320" name="rl_butt_style" id="rl_butt_style" onchange="change_rl_butt_style(jQuery(this).val())">
                          <?php
                          foreach ($button_styles as $key => $button_style) {
                            ?>
                            <option value="<?php echo $key; ?>" <?php echo (($row->rl_butt_style == $key) ? 'selected="selected"' : ''); ?>><?php echo $button_style; ?></option>
                            <?php
                          }
                          ?>
                          </select>
                        </div>
                        <div style="display: table-cell; vertical-align: middle; background-color: rgba(229, 229, 229, 0.62); text-align: center;" >
                          <i id="wdps_left_style" class="fa <?php echo $row->rl_butt_style; ?>-left" style="color: #<?php echo $row->butts_color; ?>; display: inline-block; font-size: 40px; width: 40px; height: 40px;"></i>
                          <i id="wdps_right_style" class="fa <?php echo $row->rl_butt_style; ?>-right" style="color: #<?php echo $row->butts_color; ?>; display: inline-block; font-size: 40px; width: 40px; height: 40px;"></i>
                        </div>
                      </div>
                      <div class="spider_description"><?php echo __('Choose the style of the button you prefer to have as navigation buttons.','wdps_back'); ?></div>
                    </td>
                  </tr>				  
                  <tr id="right_butt_upl">
                    <td class="spider_label_options" style="vertical-align: middle;">
                      <label><?php echo __('Upload buttons images:','wdps_back'); ?> </label>
                    </td>
                    <td>
                      <div style="display: table;">
                        <div style="display: table-cell; vertical-align: middle;" class="display_block">
                         
                          <input class="button-secondary wdps_ctrl_btn_upload wdps_free_button" type="button" value="Previous Button" onclick="alert('This functionality is disabled in free version.')" />
                          <input class="button-secondary wdps_ctrl_btn_upload wdps_free_button" type="button" value="Previous Button Hover" onclick="alert('This functionality is disabled in free version.')" />
                        </div>
                        <div style="display: table-cell; vertical-align: middle;">
                          
                          <input class="button-secondary wdps_ctrl_btn_upload wdps_free_button" type="button" value="Next Button" onclick="alert('This functionality is disabled in free version.')" />
                          <input class="button-secondary wdps_ctrl_btn_upload wdps_free_button" type="button" value="Next Button Hover" onclick="alert('This functionality is disabled in free version.')" />
                        </div>
                        <div style="width:100px; display: table-cell; vertical-align: middle; text-align: center;background-color: rgba(229, 229, 229, 0.62); padding-top: 4px; border-radius: 3px;" class="display_block">
                          <img id="left_butt_img" src="<?php echo $row->left_butt_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                          <img id="right_butt_img" src="<?php echo $row->right_butt_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                          <img id="left_butt_hov_img" src="<?php echo $row->left_butt_hov_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                          <img id="right_butt_hov_img" src="<?php echo $row->right_butt_hov_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                        </div>
                        <div style="display: table-cell; text-align: center; vertical-align: middle;" class="display_block wdps_reverse_cont">
                          <input type="button" class="button button-small wdps_reverse" onclick="wdps_change_custom_src()" value="<?php echo __('Reverse','wdps_back'); ?>" />
                        </div>
                      </div>
                    </td>
                  </tr>
                  <script>
                    
                    if(jQuery("#taxonomies_id").has("select").length == 0) {
                      jQuery("#taxonomies_id1").css({"display":"none"});
                    }
                    else {
                      jQuery("#taxonomies_id1").css({"display":""});
                    }
                    
                    var wdps_rl_butt_type = [];
                    var rl_butt_dir = '<?php echo WD_PS_URL . '/images/arrow/'; ?>';
                    var type_cur_fold = '1';
                    <?php				    
                    $folder_names = scandir(WD_PS_DIR . '/images/arrow');
                    $cur_fold_name = '';
                    $cur_type_key = '';
                    $cur_color_key = '';
                    $cur_sub_fold_names = array();
                    array_splice($folder_names, 0, 2);
                    $flag = FALSE;
                    foreach ($folder_names as $type_key => $folder_name) {
                      if (is_dir(WD_PS_DIR . '/images/arrow/' . $folder_name)) {
                        ?>
                        wdps_rl_butt_type["<?php echo $type_key; ?>"] = [];
                        wdps_rl_butt_type["<?php echo $type_key; ?>"]["type_name"] = "<?php echo $folder_name; ?>";
                        <?php
                        if ($row->left_butt_url != '') {
                          /* Getting current button's type folder and color folder.*/
                          $check_cur_fold = explode('/' , $row->left_butt_url);
                          if (in_array($folder_name, $check_cur_fold)) {
                            $flag = TRUE;
                            $cur_fold_name = $folder_name;
                            $cur_type_key = $type_key;
                            $cur_sub_fold_names = scandir(WD_PS_DIR . '/images/arrow/' . $cur_fold_name);
                            array_splice($cur_sub_fold_names, 0, 2);
                            ?>
                        type_cur_fold = '<?php echo $cur_type_key;?>';
                            <?php
                          }
                        }
                        $sub_folder_names = scandir( WD_PS_DIR . '/images/arrow/' . $folder_name);
                        array_splice($sub_folder_names, 0, 2);
                        foreach ($sub_folder_names as $color_key => $sub_folder_name) {  
                          if (is_dir(WD_PS_DIR . '/images/arrow/' . $folder_name . '/' . $sub_folder_name)) {
                            if ($cur_fold_name == $folder_name) {
                              /* Getting current button's color key.*/
                              if (in_array($sub_folder_name, $check_cur_fold)) {
                                $cur_color_key = $color_key;
                              }
                            }
                            ?>
                            wdps_rl_butt_type["<?php echo $type_key; ?>"]["<?php echo $color_key; ?>"] = "<?php echo $sub_folder_name; ?>";
                            <?php
                          }
                        }
                      }
                      else {
                        ?>
                        console.log('<?php echo $folder_name . addslashes(__(" is not a directory.",wdps_back)); ?>');
                        <?php
                      }
                    }
                    ?>
                   
                  </script>
                  <tr id="right_left_butt_select">
                    <td class="spider_label_options" style="vertical-align: middle;">
                      <label for="right_butt_url"><?php echo __('Choose buttons:','wdps_back'); ?> </label>
                    </td>
                    <td style="display: block;">
                      <div style="display: table; margin-bottom: 14px;" >
                        <div style="display: table-cell; vertical-align: middle;" class="display_block">
                          <div style="display: block; width: 180px;"class="default_buttons">
                            <div class="spider_choose_option" onclick="alert('This functionality is disabled in free version.')">
                              <div  class="spider_option_main_title"><?php echo __('Choose group','wdps_back'); ?></div>
                              <div class="spider_sel_option_ic"><i class="fa fa-angle-down fa-lg" style="color: #1E8CBE"></i></div>
                            </div>
                            <div class="spider_options_cont">
                            <?php
                            foreach ($folder_names as $type_key => $folder_name) {
                              ?> 							  							  
                              <div class="spider_option_cont wdps_rl_butt_groups" value="<?php echo $type_key; ?>" <?php echo (($cur_type_key == $type_key) ? 'selected="selected" style="background-color: #3399FF;"' : ''); ?> onclick="change_rl_butt_type(this)"> 
                                <div  class="spider_option_cont_title">
                                  <?php echo 'Group-' . ++$type_key; ?>
                                </div>
                                <div class="spider_option_cont_img">
                                  <img class="src_top_left" style="display: inline-block; width: 14px; height: 14px;" />
                                  <img class="src_top_right" style="display: inline-block; width: 14px; height: 14px;" />
                                  <img class="src_bottom_left" style="display: inline-block; width: 14px; height: 14px;" />
                                  <img class="src_bottom_right" style="display: inline-block; width: 14px; height: 14px;" /> 
                                </div>
                              </div>
                              <?php
                            }
                            if (!$flag) {
                              /* Folder doesn't exist.*/
                              ?>
                              <div class="spider_option_cont" value="0" selected="selected" disabled="disabled"><?php echo __('Custom','wdps_back'); ?></div>
                              <?php
                            }
                            ?>
                            </div>
                          </div>							
                        </div>
                        <div style="display:table-cell;vertical-align: middle;" class="display_block">
                          <div style="display: block; width: 180px; margin-left: 12px;" class="default_buttons">
                            <div class="spider_choose_option" onclick="alert('This functionality is disabled in free version.')">
                              <div  class="spider_option_main_title"><?php echo __('Choose color','wdps_back'); ?></div>
                              <div class="spider_sel_option_ic"><i class="fa fa-angle-down fa-lg" style="color:#1E8CBE"></i></div>
                              
                            </div>
                          </div>
                        </div>
                        <div style="width:100px; display: table-cell; vertical-align: middle; text-align: center;" class="display_block">
                          <div style=" display: block; margin-left: 12px; vertical-align: middle; text-align: center;background-color: rgba(229, 229, 229, 0.62); padding-top: 4px; border-radius: 3px;" class="play_buttons_cont">
                          <img id="rl_butt_img_l" src="<?php echo $row->left_butt_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                          <img id="rl_butt_img_r" src="<?php echo $row->right_butt_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                          <img id="rl_butt_hov_img_l" src="<?php echo $row->left_butt_hov_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                          <img id="rl_butt_hov_img_r" src="<?php echo $row->right_butt_hov_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                          </div>
                        </div>
                        <div style="display: table-cell; text-align: center; vertical-align: middle;">
                          <input type="button" class="button button-small wdps_reverse" onclick="change_src()" value="<?php echo __('Reverse','wdps_back'); ?>" />
                        </div>
                      </div>
                      <div class="spider_description">Choose the type and color for navigation button images. The option is designed for limited preview (colors not included) purposes and can't be saved.</div>
                    </td>
                  </tr>
                  <tr id="right_left_butt_size">
                    <td class="spider_label <?php echo $fv_class; ?>"><label for="rl_butt_size">Next / Previous buttons size: </label></td>
                    <td>
                       <input type="text" name="rl_butt_size" id="rl_butt_size" value="<?php echo $row->rl_butt_size; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" <?php echo $fv_disabled; ?> /> px
                      <div class="spider_description"><?php echo __('Set the size for the next / previous buttons.','wdps_back'); ?></div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label_options">
                      <label><?php echo __('Play / Pause button:','wdps_back'); ?> </label>
                    </td>
                    <td>
                      <input type="radio" name="play_paus_post_butt" id="play_paus_post_butt_1" value="1" <?php if ($row->play_paus_post_butt) echo 'checked="checked"'; ?> /><label for="play_paus_post_butt_1">Yes</label>
                      <input type="radio" name="play_paus_post_butt" id="play_paus_post_butt_0" value="0" <?php if (!$row->play_paus_post_butt) echo 'checked="checked"'; ?> /><label for="play_paus_post_butt_0">No</label>
                      <div class="spider_description"><?php echo __('Choose whether to display Play and Pause buttons or not.','wdps_back'); ?></div>
                    </td>
                  </tr>
                  <tr>
                  </tbody>
                <tbody>
                    <td class="spider_label_options">
                      <label><?php echo __('Image for Play / Pause buttons:','wdps_back'); ?> </label>
                    </td>
                     <td>
                      <input type="radio" name="play_paus_butt_img_or_not" id="play_pause_butt_img_or_not_our" value="our" <?php if ($row->play_paus_butt_img_or_not == 'our') echo 'checked="checked"'; ?> onClick="image_for_play_pause_butt('our')" /><label <?php if ($row->play_paus_butt_img_or_not == 'our') echo 'class="selected_color"'; ?> for="play_pause_butt_img_or_not_our">Default</label>
                      <input type="radio" name="play_paus_butt_img_or_not" id="play_pause_butt_img_or_not_cust" value="custom" <?php if ($row->play_paus_butt_img_or_not == 'custom') echo 'checked="checked"'; ?> onClick="image_for_play_pause_butt('custom')" /><label <?php if ($row->play_paus_butt_img_or_not == 'custom') echo 'class="selected_color"'; ?> for="play_pause_butt_img_or_not_cust">Custom</label>
                      <input type="radio" name="play_paus_butt_img_or_not" id="play_pause_butt_img_or_not_select" value="style" <?php if ($row->play_paus_butt_img_or_not == 'style') echo 'checked="checked"'; ?> onClick="image_for_play_pause_butt('style')" /><label <?php if ($row->play_paus_butt_img_or_not == 'class="selected_color"') echo 'checked="checked"'; ?> for="play_pause_butt_img_or_not_select">Styled</label>
                      <input type="hidden" id="play_butt_url" name="play_butt_url" value="<?php echo $row->play_butt_url; ?>" />
                      <input type="hidden" id="play_butt_hov_url" name="play_butt_hov_url" value="<?php echo $row->play_butt_hov_url; ?>" />
                      <input type="hidden" id="paus_butt_url" name="paus_butt_url" value="<?php echo $row->paus_butt_url; ?>" />
                      <input type="hidden" id="paus_butt_hov_url" name="paus_butt_hov_url" value="<?php echo $row->paus_butt_hov_url; ?>" />
                      <div class="spider_description">Choose whether to use default play/pause buttons or to upload custom ones.</div>
                    </td>
                  </tr>	
                  </tbody>
                 <tbody class="<?php echo $fv_class; ?>"<?php echo $fv_title; ?>>
                  <tr id="play_pause_butt_style">
                    <td class="spider_label"><label for="pp_butt_style">Play / Pause buttons style: </label></td>
                    <td>
                      <div style="display: table-cell; vertical-align: middle; background-color: rgba(229, 229, 229, 0.62); text-align: center;">
                        <i id="wdps_play_style" class="fa fa-play" style="color: #<?php echo $row->butts_color; ?>; display: inline-block; font-size: 40px; width: 40px; height: 40px;"></i>
                        <i id="wdps_paus_style" class="fa fa-pause" style="color: #<?php echo $row->butts_color; ?>; display: inline-block; font-size: 40px; width: 40px; height: 40px;"></i>
                      </div>
                    </td>
                  </tr>
                  <tr id="play_pause_butt_cust">
                    <td class="spider_label_options" style="vertical-align: middle;">
                      <label>Upload buttons images: </label>
                    </td>
                    <td>
                      <div style="display: table;">
                        <div style="display: table-cell; vertical-align: middle;" class="display_block">
                          <input class="button-secondary wdps_ctrl_btn_upload wdps_free_button" type="button" value="Play Button" onclick="alert('This functionality is disabled in free version.')" />
                          <input class="button-secondary wdps_ctrl_btn_upload wdps_free_button" type="button" value="Play Button Hover" onclick="alert('This functionality is disabled in free version.')" />
                        </div>
                        <div style="display: table-cell; vertical-align: middle;" class="display_block">
                          <input class="button-secondary wdps_ctrl_btn_upload wdps_free_button" type="button" value="Pause Button" onclick="alert('This functionality is disabled in free version.')" />
                          <input class="button-secondary wdps_ctrl_btn_upload wdps_free_button" type="button" value="Pause Button Hover" onclick="alert('This functionality is disabled in free version.')" />
                        </div>
                        <div style="width:100px; display: table-cell; vertical-align: middle; text-align: center;background-color: rgba(229, 229, 229, 0.62); padding-top: 4px; border-radius: 3px;">
                          <img id="play_butt_img" src="<?php echo $row->play_butt_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                          <img id="paus_butt_img" src="<?php echo $row->paus_butt_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                          <img id="play_butt_hov_img" src="<?php echo $row->play_butt_hov_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                          <img id="paus_butt_hov_img" src="<?php echo $row->paus_butt_hov_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                        </div>
                        <div style="display: table-cell; text-align: center; vertical-align: middle;" class="display_block wdps_reverse_cont">
                          <input type="button" class="button button-small wdps_reverse" onclick="wdps_change_play_paus_custom_src()" value="Reverse" />
                        </div>
                      </div>
                    </td>
                  </tr>
                  <script>				  
                    var wdps_pp_butt_type = [];
                    var pp_butt_dir = '<?php echo WD_PS_URL . '/images/button/'; ?>';
                    var pp_type_cur_fold = '1';
                    <?php				    
                    $folder_names = scandir(WD_PS_DIR . '/images/button'); 
                    $butt_cur_fold_name = '';
                    $butt_cur_type_key = '';
                    $butt_cur_color_key = '';
                    $butt_cur_sub_fold_names = array();
                    array_splice($folder_names, 0, 2);
                    $flag = FALSE;
                    foreach ($folder_names as $type_key => $folder_name) {
                      if (is_dir(WD_PS_DIR . '/images/button/' . $folder_name)) {
                        ?>
                        wdps_pp_butt_type["<?php echo $type_key; ?>"] = [];
                        wdps_pp_butt_type["<?php echo $type_key; ?>"]["type_name"] = "<?php echo $folder_name; ?>";
                        <?php
                        if ($row->play_butt_url != '') {
                          /* Getting current button's type folder and color folder.*/
                          $check_butt_cur_fold = explode('/' , $row->play_butt_url);
                          if (in_array($folder_name, $check_butt_cur_fold)) {
                            $flag = TRUE;
                            $butt_cur_fold_name = $folder_name;
                            $butt_cur_type_key = $type_key;
                            $butt_cur_sub_fold_names = scandir(WD_PS_DIR . '/images/button/' . $butt_cur_fold_name);
                            array_splice($butt_cur_sub_fold_names, 0, 2);
                            ?>
                        pp_type_cur_fold = '<?php echo $butt_cur_type_key;?>';
                            <?php
                          }
                        }
                        $sub_folder_names = scandir( WD_PS_DIR . '/images/button/' . $folder_name);
                        array_splice($sub_folder_names, 0, 2);
                        foreach ($sub_folder_names as $color_key => $sub_folder_name) {
                          if (is_dir(WD_PS_DIR . '/images/button/' . $folder_name . '/' . $sub_folder_name)) {
                            if ($butt_cur_fold_name == $folder_name) {
                              /* Getting current button's color key.*/
                              if (in_array($sub_folder_name, $check_butt_cur_fold)) {
                                $butt_cur_color_key = $color_key;
                              }
                            }
                            ?>
                            wdps_pp_butt_type["<?php echo $type_key; ?>"]["<?php echo $color_key; ?>"] = "<?php echo $sub_folder_name; ?>";
                            <?php
                          }
                        }
                      }
                      else {
                        ?>
                        console.log('<?php echo $folder_name . " is not a directory."; ?>');
                        <?php
                      }
                    }
                    ?> 
                  </script>
                  <tr id="play_pause_butt_select">
                    <td class="spider_label_options" style="vertical-align: middle;">
                      <label for="right_butt_url">Choose buttons: </label>
                    </td>
                    <td style="display: block;">
                        <div style="display: table; margin-bottom: 14px;">
                          <div style="display: table-cell; vertical-align: middle;" class="display_block" >
                            <div style="display: block; width: 180px;" class="default_buttons">
                              <div class="spider_choose_option" onclick="wdps_choose_pp_option(this)"> 
                                <div class="spider_option_main_title">Choose group</div>
                                <div class="spider_sel_option_ic"><i class="fa fa-angle-down fa-lg" style="color: #1E8CBE"></i></div>
                              </div>
                              <div class="spider_pp_options_cont">
                              <?php
                              foreach ($folder_names as $type_key => $folder_name) {
                                ?> 							  							  
                                <div class="spider_option_cont wdps_pp_butt_groups" value="<?php echo $type_key; ?>" <?php echo (($butt_cur_type_key == $type_key) ? 'selected="selected" style="background-color: #3399FF;"' : ''); ?> onclick="change_play_paus_butt_type(this)"> 
                                  <div  class="spider_option_cont_title">
                                    <?php echo 'Group-' . ++$type_key; ?>
                                  </div>
                                  <div class="spider_option_cont_img">
                                    <img class="pp_src_top_left" style="display: inline-block; width: 14px; height: 14px;" />
                                    <img class="pp_src_top_right" style="display: inline-block; width: 14px; height: 14px;" />
                                    <img class="pp_src_bottom_left" style="display: inline-block; width: 14px; height: 14px;" />
                                    <img class="pp_src_bottom_right" style="display: inline-block; width: 14px; height: 14px;" /> 
                                  </div>
                                </div>
                                <?php
                              }
                              if (!$flag) {
                                /* Folder doesn't exist.*/
                                ?>
                                <div class="spider_option_cont" value="0" selected="selected" disabled="disabled">Custom</div>
                                <?php
                              }
                              ?>
                              </div>
                            </div>
                          </div>
                          <div style="display:table-cell;vertical-align: middle;" class="display_block">
                            <div style="display: block; width: 180px; margin-left: 12px;" class="default_buttons">
                              <div class="spider_choose_option" onclick="alert('This functionality is disabled in free version.')">
                                <div  class="spider_option_main_title">Choose color</div>
                                <div class="spider_sel_option_ic"><i class="fa fa-angle-down fa-lg" style="color:#1E8CBE"></i></div>
                              </div>
                            </div>
                          </div>
                          <div style="width:100px; display: table-cell; vertical-align: middle; text-align: center;" class="display_block">
                            <div style=" display: block; margin-left: 12px; vertical-align: middle; text-align: center;background-color: rgba(229, 229, 229, 0.62); padding-top: 4px; border-radius: 3px;" class="play_buttons_cont">
                              <img id="pp_butt_img_play" src="<?php echo $row->play_butt_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                              <img id="pp_butt_img_paus" src="<?php echo $row->paus_butt_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                              <img id="pp_butt_hov_img_play" src="<?php echo $row->play_butt_hov_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                              <img id="pp_butt_hov_img_paus" src="<?php echo $row->paus_butt_hov_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                            </div>
                          </div>
                          <div style="display: table-cell; text-align: center; vertical-align: middle;">
                            <input type="button" class="button button-small wdps_reverse" onclick="change_play_paus_src()" value="Reverse" />
                          </div>
                        </div>
                      <div class="spider_description">Choose the type and color for navigation button images. The option is designed for limited preview (colors not included) purposes and can't be saved.</div>
                    </td>
                  </tr>
                  <tr id="play_pause_butt_size">
                    <td class="spider_label <?php echo $fv_class; ?>"><label for="pp_butt_size">Play / Pause button size: </label></td>
                    <td>
                      <input type="text" name="pp_butt_size" id="pp_butt_size" value="<?php echo $row->pp_butt_size; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" <?php echo $fv_disabled; ?> /> px
                      <div class="spider_description">Set the size for the play / pause buttons.</div>
                    </td>
                  </tr>
                  <tr id="tr_butts_color">
                    <td class="spider_label <?php echo $fv_class; ?>"><label for="butts_color">Buttons color: </label></td>
                    <td>
                      <input type="text" name="butts_color" id="butts_color" value="<?php echo $row->butts_color; ?>" class="color" <?php echo $fv_disabled; ?> onchange="jQuery('#wdps_left_style,#wdps_right_style').css({color: '#' + jQuery(this).val()})" />
                      <div class="spider_description">Select a color for the navigation buttons.</div>
                    </td>
                  </tr>
                  <tr id="tr_hover_color">
                    <td class="spider_label <?php echo $fv_class; ?>"><label for="hover_color">Hover color: </label></td>
                    <td>
                      <input type="text" name="hover_color" id="hover_color" value="<?php echo $row->hover_color; ?>" class="color" <?php echo $fv_disabled; ?> />
                      <div class="spider_description">Select a hover color for the navigation buttons.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label <?php echo $fv_class; ?>"><label for="nav_border_width">Border: </label></td>
                    <td>
                      <input type="text" name="nav_border_width" id="nav_border_width" value="<?php echo $row->nav_border_width; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" <?php echo $fv_disabled; ?> /> px
                      <select class="select_icon select_icon_320" name="nav_border_style" id="nav_border_style" <?php echo $fv_disabled; ?>>
                        <?php
                        foreach ($border_styles as $key => $border_style) {
                          ?>
                          <option value="<?php echo $key; ?>" <?php echo (($row->nav_border_style == $key) ? 'selected="selected"' : ''); ?>><?php echo $border_style; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                      <input type="text" name="nav_border_color" id="nav_border_color" value="<?php echo $row->nav_border_color; ?>" class="color" <?php echo $fv_disabled; ?> />
                      <div class="spider_description">Select the type, size and the color of border for the navigation buttons.</div>
                    </td>
                  </tr>
                    <td class="spider_label <?php echo $fv_class; ?>"><label for="nav_border_radius">Border radius: </label></td>
                    <td>
                      <input type="text" name="nav_border_radius" id="nav_border_radius" value="<?php echo $row->nav_border_radius; ?>" class="spider_char_input" <?php echo $fv_disabled; ?> />
                      <div class="spider_description">Use CSS type values.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label <?php echo $fv_class; ?>"><label for="nav_bg_color">Background color: </label></td>
                    <td>
                      <input type="text" name="nav_bg_color" id="nav_bg_color" value="<?php echo $row->nav_bg_color; ?>" class="color" <?php echo $fv_disabled; ?> />
                      <input type="text" name="butts_transparent" id="butts_transparent" value="<?php echo $row->butts_transparent; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" <?php echo $fv_disabled; ?> /> %
                      <div class="spider_description">Transparency value must be between 0 to 100.</div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
             <div class="wdps_nav_box wdps_nav_bullets_box">
              <table>
                <tbody>
                  <tr>
                    <td class="spider_label"><label>Enable bullets: </label></td>
                    <td>
                      <input type="radio" id="enable_bullets1" name="enable_bullets" <?php echo (($row->enable_bullets) ? 'checked="checked"' : ''); ?> value="1" /><label <?php echo (($row->enable_bullets) ? 'class="selected_color"' : ''); ?> for="enable_bullets1">Yes</label>
                      <input type="radio" id="enable_bullets0" name="enable_bullets" <?php echo (($row->enable_bullets) ? '' : 'checked="checked"'); ?> value="0" /><label <?php echo (($row->enable_bullets) ? '' : 'class="selected_color"'); ?> for="enable_bullets0">No</label>
                      <div class="spider_description">Choose whether to have navigation bullets or not.</div>
                    </td>
                  </tr>
                 
                  <tr>
                    <td class="spider_label"><label>Position: </label></td>
                    <td>
                      <select class="select_icon select_icon_320" name="bull_position" id="bull_position">
                        <option value="top" <?php echo (($row->bull_position == "top") ? 'selected="selected"' : ''); ?>>Top</option>
                        <option value="bottom" <?php echo (($row->bull_position == "bottom") ? 'selected="selected"' : ''); ?>>Bottom</option>
                      </select>
                      <div class="spider_description">Select the position for the navigation bullets.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label_options">
                      <label>Image for bullets: </label>
                    </td>
                    <td>
                      <input type="radio" name="bull_butt_img_or_not" id="bull_butt_img_or_not_our" value="our" <?php if ($row->bull_butt_img_or_not == 'our') echo 'checked="checked"'; ?> onClick="image_for_bull_butt('our')" /><label <?php if ($row->bull_butt_img_or_not == 'our') echo 'class="selected_color"'; ?> for="bull_butt_img_or_not_our">Default</label>
                      <input type="radio" name="bull_butt_img_or_not" id="bull_butt_img_or_not_cust" value="custom" <?php if ($row->bull_butt_img_or_not == 'custom') echo 'checked="checked"'; ?> onClick="image_for_bull_butt('custom')" /><label <?php if ($row->bull_butt_img_or_not == 'custom') echo 'class="selected_color"'; ?> for="bull_butt_img_or_not_cust">Custom</label>
                      <input type="radio" name="bull_butt_img_or_not" id="bull_butt_img_or_not_stl" value="style" <?php if ($row->bull_butt_img_or_not == 'style') echo 'checked="checked"'; ?> onClick="image_for_bull_butt('style')" /><label <?php if ($row->bull_butt_img_or_not == 'style') echo 'class="selected_color"'; ?> for="bull_butt_img_or_not_stl">Styled</label>
                      <input type="hidden" id="bullets_img_main_url" name="bullets_img_main_url" value="<?php echo $row->bullets_img_main_url; ?>" />
                      <input type="hidden" id="bullets_img_hov_url" name="bullets_img_hov_url" value="<?php echo $row->bullets_img_hov_url; ?>" />
                      <div class="spider_description">Choose whether to use default or styled bullets.</div>
                    </td>
                  </tr>
                </tbody>
                <tbody class="<?php echo $fv_class; ?>"<?php echo $fv_title; ?>>
                  <?php echo $fv_message; ?>
                  <tr id="bullets_style">
                    <td class="spider_label <?php echo $fv_class; ?>"><label for="bull_style">Bullet style: </label></td>
                    <td>
                      <div style="display: table;">
                        <div style="display: table-cell; vertical-align: middle;">
                          <select class="select_icon select_icon_320" name="bull_style" id="bull_style" <?php echo $fv_disabled; ?> onchange="change_bull_style(jQuery(this).val())">
                            <?php
                            foreach ($bull_styles as $key => $bull_style) {
                              ?>
                              <option value="<?php echo $key; ?>" <?php echo (($row->bull_style == $key) ? 'selected="selected"' : ''); ?>><?php echo $bull_style; ?></option>
                              <?php
                            }
                            ?>
                          </select>
                        </div>
                        <div style="display: table-cell; vertical-align: middle; background-color: rgba(229, 229, 229, 0.62); text-align: center;">
                          <i id="wdps_act_bull_style" class="fa <?php echo str_replace('-o', '', $row->bull_style); ?>" style="color: #<?php echo $row->bull_act_color; ?>; display: inline-block; font-size: 40px; width: 40px; height: 40px;"></i>
                          <i id="wdps_deact_bull_style" class="fa <?php echo $row->bull_style; ?>" style="color: #<?php echo $row->bull_color; ?>; display: inline-block; font-size: 40px; width: 40px; height: 40px;"></i>
                        </div>
                      </div>
                      <div class="spider_description">Choose the style for the bullets.</div>
                    </td>
                  </tr>
                  <script>				  
                    var wdps_blt_img_type = [];
                    var blt_img_dir = '<?php echo WD_PS_URL . '/images/bullet/'; ?>';
                    var bull_type_cur_fold = '1';
                    <?php				    
                    $folder_names = scandir(WD_PS_DIR . '/images/bullet'); 
                    $bull_cur_fold_name = '';
                    $bull_cur_type_key = '';
                    $bull_cur_color_key = '';
                    $bull_cur_sub_fold_names = array();
                    array_splice($folder_names, 0, 2);
                    $flag = FALSE;
                    foreach ($folder_names as $type_key => $folder_name) {
                      if (is_dir(WD_PS_DIR . '/images/bullet/' . $folder_name)) {
                        ?>
                        wdps_blt_img_type["<?php echo $type_key; ?>"] = [];
                        wdps_blt_img_type["<?php echo $type_key; ?>"]["type_name"] = "<?php echo $folder_name; ?>";
                        <?php
                        if ($row->bullets_img_main_url != '') {
                          /* Getting current button's type folder and color folder.*/
                          $check_bull_cur_fold = explode('/' , $row->bullets_img_main_url);
                          if (in_array($folder_name, $check_bull_cur_fold)) {
                            $flag = TRUE;
                            $bull_cur_fold_name = $folder_name;
                            $bull_cur_type_key = $type_key;
                            $bull_cur_sub_fold_names = scandir(WD_PS_DIR . '/images/bullet/' . $bull_cur_fold_name);
                            array_splice($bull_cur_sub_fold_names, 0, 2);
                            ?>
                        bull_type_cur_fold = '<?php echo $bull_cur_type_key;?>';
                            <?php						
                          }
                        }
                        $sub_folder_names = scandir(WD_PS_DIR . '/images/bullet/' . $folder_name);						  
                        array_splice($sub_folder_names, 0, 2); 
                        foreach ($sub_folder_names as $color_key => $sub_folder_name) {
                          if (is_dir(WD_PS_DIR . '/images/bullet/' . $folder_name . '/' . $sub_folder_name)) {
                            if ($bull_cur_fold_name == $folder_name) {
                              /* Getting current button's color key.*/
                              if (in_array($sub_folder_name, $check_bull_cur_fold)) {
                                $bull_cur_color_key = $color_key;
                              }
                            }
                            ?>
                            wdps_blt_img_type["<?php echo $type_key; ?>"]["<?php echo $color_key; ?>"] = "<?php echo $sub_folder_name; ?>";
                            <?php 
                          }
                        }
                      }
                      else {
                        ?>
                        console.log('<?php echo $folder_name . " is not a directory."; ?>');
                        <?php
                      }
                    }
                    ?> 
                  </script>
                  <tr id="bullets_images_cust">
                    <td class="spider_label_options" style="vertical-align: middle;">
                      <label>Upload buttons images: </label>
                    </td>
                    <td>
                      <div style="display: table;">
                        <div style="display: table-cell; vertical-align: middle;">
                          <input class="button-secondary wdps_ctrl_btn_upload wdps_free_button" type="button" value="Active Button" onclick="alert('This functionality is disabled in free version.')" />
                        </div>
                        <div style="display: table-cell; vertical-align: middle;">
                          <input class="button-secondary wdps_free_button" type="button" value="Deactive Button" onclick="alert('This functionality is disabled in free version.')" />
                        </div>  
                        <div style="width:100px; display: table-cell; vertical-align: middle; text-align: center;background-color: rgba(229, 229, 229, 0.62); padding-top: 4px; border-radius: 3px;">
                          <img id="bull_img_main" src="<?php echo $row->bullets_img_main_url; ?>" style="display:inline-block; width: 40px; height: 40px;" />
                          <img id="bull_img_hov" src="<?php echo $row->bullets_img_hov_url; ?>" style="display:inline-block; width: 40px; height: 40px;" /> 
                        </div>
                        <div style="display: table-cell; text-align: center; vertical-align: middle;">
                          <input type="button" class="button button-small wdps_reverse" onclick="wdps_change_bullets_custom_src()" value="Reverse" />
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr id="bullets_images_select">
                    <td class="spider_label_options" style="vertical-align: middle;">
                      <label for="bullets_images_url">Chooes buttons: </label>
                    </td>
                    <td style="display: block;">
                      <div style="display: table; margin-bottom: 14px;">
                        <div style="display: table-cell; vertical-align: middle;" class="display_block">
                          <div style="display: block; width: 180px;" class="default_buttons">
                            <div class="spider_choose_option" onclick="wdps_choose_bull_option(this)">
                              <div class="spider_option_main_title">Choose group</div>
                              <div class="spider_sel_option_ic"><i class="fa fa-angle-down fa-lg" style="color: #1E8CBE;"></i></div>
                            </div>
                            <div class="spider_bull_options_cont">
                            <?php
                            foreach ($folder_names as $type_key => $folder_name) {
                              ?>
                              <div class="spider_option_cont wdps_bull_butt_groups" value="<?php echo $type_key; ?>" <?php echo (($bull_cur_type_key == $type_key) ? 'selected="selected" style="background-color: #3399FF;"' : ''); ?> onclick="change_bullets_images_type(this)">
                                <div class="spider_option_cont_title" style="width: 64%;">
                                  <?php echo 'Group-' . ++$type_key; ?>
                                </div>
                                <div class="spider_option_cont_img">
                                  <img class="bull_src_left" style="display: inline-block; width: 14px; height: 14px;" />
                                  <img class="bull_src_right" style="display: inline-block; width: 14px; height: 14px;" />
                                </div>
                              </div>
                              <?php
                            }
                            if (!$flag) {
                              /* Folder doesn't exist.*/
                              ?>
                              <div class="spider_option_cont" value="0" selected="selected" disabled="disabled">Custom</div>
                              <?php
                            }
                            ?>
                            </div>
                          </div>							
                        </div>
                        <div style="display: table-cell; vertical-align: middle;" class="display_block">
                          <div style="display: block; width: 180px; margin-left: 12px;">
                            <div class="spider_choose_option" onclick="alert('This functionality is disabled in free version.')" >
                              <div class="spider_option_main_title" >Choose color</div>
                              <div class="spider_sel_option_ic"><i class="fa fa-angle-down fa-lg" style="color: #1E8CBE;"></i></div>
                            </div>
                          </div>
                        </div>						
                        <div style="width: 100px; display: table-cell; vertical-align: middle; text-align: center;">
                          <div style="display: block; vertical-align: middle; margin-left: 12px; text-align: center; background-color: rgba(229, 229, 229, 0.62); padding-top: 4px; border-radius: 3px;">
                            <img id="bullets_img_main" src="<?php echo $row->bullets_img_main_url; ?>" style="display: inline-block; width: 40px; height: 40px;" />
                            <img id="bullets_img_hov" src="<?php echo $row->bullets_img_hov_url; ?>" style="display: inline-block; width: 40px; height: 40px;" />
                          </div>
                        </div>						
                        <div style="display: table-cell; text-align: center; vertical-align: middle;">
                          <input type="button" class="button button-small wdps_reverse" onclick="change_bullets_src()" value="Reverse" />
                        </div>
                      </div>
                      <div class="spider_description">Choose the type and color for the bullets. The option is designed for limited preview (colors not included) purposes and can't be saved.</div>
                    </td>
                  </tr>
                  <tr id="bullet_size">
                    <td class="spider_label <?php echo $fv_class; ?>"><label for="bull_size">Size: </label></td>
                    <td>
                      <input type="text" name="bull_size" id="bull_size" value="<?php echo $row->bull_size; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" <?php echo $fv_disabled; ?> /> px
                      <div class="spider_description">Define the size of the navigation bullets.</div>
                    </td>
                  </tr>
                  <tr id="bullets_color">
                    <td class="spider_label <?php echo $fv_class; ?>"><label for="bull_color">Color: </label></td>
                    <td>
                      <input type="text" name="bull_color" id="bull_color" value="<?php echo $row->bull_color; ?>" class="color" <?php echo $fv_disabled; ?> onchange="jQuery('#wdps_deact_bull_style').css({color: '#' + jQuery(this).val()})" />
                      <div class="spider_description">Select the color for the navigation bullets.</div>
                    </td>
                  </tr> 
                  <tr id="bullets_act_color">
                    <td class="spider_label <?php echo $fv_class; ?>"><label for="bull_act_color">Active color: </label></td>
                    <td>
                      <input type="text" name="bull_act_color" id="bull_act_color" value="<?php echo $row->bull_act_color; ?>" class="color" <?php echo $fv_disabled; ?> onchange="jQuery('#wdps_act_bull_style').css({color: '#' + jQuery(this).val()})" />
                      <div class="spider_description">Select the color for the bullet, which is currently displaying a corresponding image.</div>
                    </td>
                  </tr>
                  <tr id="bullet_margin">
                    <td class="spider_label <?php echo $fv_class; ?>"><label for="bull_margin">Margin: </label></td>
                    <td>
                      <input type="text" name="bull_margin" id="bull_margin" value="<?php echo $row->bull_margin; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" <?php echo $fv_disabled; ?> /> px
                      <div class="spider_description">Set the margin for the navigation bullets in pixels.</div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
              <div class="wdps_nav_box wdps_nav_filmstrip_box spider_free_version_label" title="This functionality is disabled in free version.">
              <table>
                <tbody>
                  <tr>
                    <td colspan="2">
                      <div class="wd_error" style="padding: 5px; font-size: 14px; color: #000000 !important;">Filmstrip is disabled in free version.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label spider_free_version_label"><label>Enable filmstrip: </label></td>
                    <td>
                      <input disabled="disabled" type="radio" id="enable_filmstrip1" name="enable_filmstrip" <?php echo (($row->enable_filmstrip) ? 'checked="checked"' : ''); ?> value="1" /><label for="filmstrip1">Yes</label>
                      <input disabled="disabled" type="radio" id="enable_filmstrip0" name="enable_filmstrip" <?php echo (($row->enable_filmstrip) ? '' : 'checked="checked"'); ?> value="0" /><label for="filmstrip0">No</label>
                      <div class="spider_description">Choose whether to have thumbnails of the slides displayed as a filmstrip or not.</div>
                    </td>
                  </tr>
                  <tr id="filmstrip_position">
                    <td class="spider_label"><label>Position: </label></td>
                    <td>
                      <select class="select_icon select_icon_320" disabled="disabled" name="film_pos" id="film_pos">
                        <option value="top" <?php echo (($row->film_pos == "top") ? 'selected="selected"' : ''); ?>>Top</option>
                        <option value="right" <?php echo (($row->film_pos == "right") ? 'selected="selected"' : ''); ?>>Right</option>
                        <option value="bottom" <?php echo (($row->film_pos == "bottom") ? 'selected="selected"' : ''); ?>>Bottom</option>
                        <option value="left" <?php echo (($row->film_pos == "left") ? 'selected="selected"' : ''); ?>>Left</option>
                      </select>
                      <div class="spider_description">Set the position of the filmstrip.</div>
                    </td>
                  </tr>
                  <tr id="filmstrip_size">
                    <td class="spider_label"><label for="film_thumb_width">Thumbnail dimensions: </label></td>
                    <td>
                      <input disabled="disabled" type="text" name="film_thumb_width" id="film_thumb_width" value="<?php echo $row->film_thumb_width; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" /> x 
                      <input disabled="disabled" type="text" name="film_thumb_height" id="film_thumb_height" value="<?php echo $row->film_thumb_height; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" /> px
                      <div class="spider_description">Define the maximum width and heigth of the filmstrip thumbnails.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="film_bg_color">Background color: </label></td>
                    <td>
                      <input disabled="disabled" type="text" name="film_bg_color" id="film_bg_color" value="<?php echo $row->film_bg_color; ?>" class="color" />
                      <div class="spider_description">Select the background color for the filmstrip.</div>
                    </td>
                  </tr>
                  <tr id="filmstrip_thumb_margin">
                    <td class="spider_label"><label for="film_tmb_margin">Thumbnail separator: </label></td>
                    <td>
                      <input disabled="disabled" type="text" name="film_tmb_margin" id="film_tmb_margin" value="<?php echo $row->film_tmb_margin; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)"/> px
                      <div class="spider_description">Set the separator for the thumbnails.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="film_act_border_width">Active border: </label></td>
                    <td>
                      <input disabled="disabled" type="text" name="film_act_border_width" id="film_act_border_width" value="<?php echo $row->film_act_border_width; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)"/> px
                      <select class="select_icon select_icon_320" disabled="disabled" name="film_act_border_style" id="film_act_border_style">
                        <?php
                        foreach ($border_styles as $key => $border_style) {
                          ?>
                          <option value="<?php echo $key; ?>" <?php echo (($row->film_act_border_style == $key) ? 'selected="selected"' : ''); ?>><?php echo $border_style; ?></option>
                          <?php
                        }
                        ?>
                      </select>
                      <input disabled="disabled" type="text" name="film_act_border_color" id="film_act_border_color" value="<?php echo $row->film_act_border_color; ?>" class="color"/>
                      <div class="spider_description">The thumbnail for the currently displayed image will have a border. You can set its size, type and color.</div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="film_dac_transparent">Deactive transparency: </label></td>
                    <td>
                      <input disabled="disabled" type="text" name="film_dac_transparent" id="film_dac_transparent" value="<?php echo $row->film_dac_transparent; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)"/> %
                      <div class="spider_description">You can set a transparency level for the inactive filmstrip items which must be between 0 to 100..</div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="wdps_nav_box wdps_nav_timer_bar_box">
              <table>
                <tbody>
                  <tr>
                    <td class="spider_label"><label><?php echo __('Enable timer bar:','wdps_back'); ?> </label></td>
                    <td>
                      <input type="radio" id="enable_time_bar1" name="enable_time_bar" <?php echo (($row->enable_time_bar) ? 'checked="checked"' : ''); ?> value="1" /><label <?php echo (($row->enable_time_bar) ? 'class="selected_color"' : ''); ?> for="time_bar1"><?php echo __('Yes','wdps_back'); ?></label>
                      <input type="radio" id="enable_time_bar0" name="enable_time_bar" <?php echo (($row->enable_time_bar) ? '' : 'checked="checked"'); ?> value="0" /><label <?php echo (($row->enable_time_bar) ? '' : 'class="selected_color"'); ?> for="time_bar0"><?php echo __('No','wdps_back'); ?></label>
                      <div class="spider_description"><?php echo __('You can add a bar displaying the timing left to switching to the next slide on autoplay.','wdps_back'); ?></div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="timer_bar_type"><?php echo __('Type:','wdps_back'); ?> </label></td>
                    <td>
                      <select class="select_icon select_icon_320" name="timer_bar_type" id="timer_bar_type">
                        <option value="top" <?php echo (($row->timer_bar_type == "top") ? 'selected="selected"' : ''); ?>><?php echo __('Line top','wdps_back'); ?></option>
                        <option value="bottom" <?php echo (($row->timer_bar_type == "bottom") ? 'selected="selected"' : ''); ?>><?php echo __('Line Bottom','wdps_back'); ?></option>
                        <option value="circle_top_left" <?php echo (($row->timer_bar_type == "circle_top_left") ? 'selected="selected"' : ''); ?>><?php echo __('Circle top left','wdps_back'); ?></option>
                        <option value="circle_top_right" <?php echo (($row->timer_bar_type == "circle_top_right") ? 'selected="selected"' : ''); ?>><?php echo __('Circle top right','wdps_back'); ?></option>
                        <option value="circle_bot_left" <?php echo (($row->timer_bar_type == "circle_bot_left") ? 'selected="selected"' : ''); ?>><?php echo __('Circle bottom left','wdps_back'); ?></option>
                        <option value="circle_bot_right" <?php echo (($row->timer_bar_type == "circle_bot_right") ? 'selected="selected"' : ''); ?>><?php echo __('Circle bottom right','wdps_back'); ?></option>
                      </select>
                      <div class="spider_description"><?php echo __('Choose the type of the timer bar to be used within the slider.','wdps_back'); ?></div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="timer_bar_size"><?php echo __('Size:','wdps_back'); ?> </label></td>
                    <td>
                      <input type="text" name="timer_bar_size" id="timer_bar_size" value="<?php echo $row->timer_bar_size; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" /> px
                      <div class="spider_description"><?php echo __('Define the height of the timer bar.','wdps_back'); ?></div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="timer_bar_color"><?php echo __('Color:','wdps_back'); ?> </label></td>
                    <td>
                      <input type="text" name="timer_bar_color" id="timer_bar_color" value="<?php echo $row->timer_bar_color; ?>" class="color" />
                      <input type="text" name="timer_bar_transparent" id="timer_bar_transparent" value="<?php echo $row->timer_bar_transparent; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)"/> %
                      <div class="spider_description"><?php echo __('Transparency value must be between 0 to 100.','wdps_back'); ?></div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="wdps_nav_box wdps_nav_css_box">
              <table style="width:50%">
                <tbody>
                  <tr>
                    <td class="spider_label"><label for="css"><?php echo __('Css:','wdps_back'); ?> </label></td> 
                  </tr> 
                  <tr>
                    <td style="width: 90%;">
                      <div class="spider_description"><?php echo __('Add custom CSS to apply custom changes to the slider.','wdps_back'); ?></div>
                      <textarea id="css" name="css" rows="30" style="width: 100%;"><?php echo htmlspecialchars($row->css); ?></textarea>
                    </td>
                  </tr>   
                </tbody>
              </table>
            </div>
          </div>
        </div>
       
        <!--------------Static Slides tab----------->
        <div class="wdps_box wdps_slides_box">
          <div class="tab_conteiner">
            <div class="tab_button_wrap setting_tab_button_wrap" onclick="wdps_change_tab(this, 'wdps_settings_box')">
              <a class="wdps_button-secondary wdps_settings" href="#">
                <span tab_type="settings" class="wdps_tab_label"><?php echo __('Settings','wdps_back'); ?></span>
              </a>
            </div>
            <div class="tab_button_wrap slides_tab_button_wrap" onclick="wdps_change_tab(this, 'wdps_slides_box')" >
              <a class="wdps_button-secondary wdps_slides" href="#">
                <span tab_type="slides" class="wdps_tab_label"><?php echo __('Slides','wdps_back'); ?></span>
              </a>
            </div>
            <div class="clear"></div>
             
          </div>
          <table>
              <tr>
              <td>
              </td>
              </tr>
          </table>
        <div class="dynamic_tabs">
          <div class="bgcolor wdps_tabs aui-sortable">
            <table>
              <tr>
              <td>
             <label style="padding-right:10px;"><?php echo __('Post slider type:','wdps_back'); ?> </label>
                <input type="radio" id="dynamic0" name="dynamic" <?php echo (($row->dynamic) ? '' : 'checked="checked"'); ?> value="0" onClick="wdps_change_post_nav()" /><label <?php echo (($row->dynamic) ? '' : 'class="selected_color"'); ?> for="dynamic0"><?php echo __('Static posts slides','wdps_back');?></label>
                <input type="radio" id="dynamic1" name="dynamic" <?php echo (($row->dynamic) ? 'checked="checked"' : ''); ?> value="1" onClick="wdps_change_post_nav();" /><label <?php echo (($row->dynamic) ? 'class="selected_color"' : ''); ?> for="dynamic1" style="padding-right:17px;"><?php echo __('Dynamic posts slides','wdps_back'); ?></label>
                
              <div class="wdps_clear"></div>
              </td>
              </tr>
              </table>
            </div>
          </div>
          <div class="wdps_box static_slides">
          <table>
            <tbody style="display: block;">
              <tr style="display: block;">
             
                <td colspan="4" style="display: block;">
                
                  <div class="bgcolor wdps_tabs wbs_subtab aui-sortable">
                      <h2 class="titles"><?php echo __('Slides','wdps_back'); ?><h2>
                   <?php
                    foreach ($slides_row as $key => $slide_row) { 
                      if($slide_row->title != 'prototype' && $slide_row->post_id != 0) {
                      ?>
                      <script>
												jQuery(function(){
														jQuery(document).on("click","#wdps_tab_image<?php echo $slide_row->id; ?>",function(){
																wdps_change_sub_tab(this, 'wdps_slide<?php echo $slide_row->id; ?>');
														});
														jQuery(document).on("click","#wdps_tab_image<?php echo $slide_row->id; ?> input",function(e){
																e.stopPropagation();
														});
														jQuery(document).on("click","#title<?php echo $slide_row->id; ?>",function(){
																wdps_change_sub_tab(jQuery("#wdps_tab_image<?php echo $slide_row->id; ?>"), 'wdps_slide<?php echo $slide_row->id; ?>');
																wdps_change_sub_tab_title(this, 'wdps_slide<?php echo $slide_row->id; ?>');
														});
												});
                      
											</script>
                    <div id="wdps_subtab_wrap<?php echo $slide_row->id; ?>" class="wdps_subtab_wrap connectedSortable"> 
                      <div id="wbs_subtab<?php echo $slide_row->id; ?>" class="tab_link  <?php echo (((($id == 0 || !$sub_tab_type) || (strpos($sub_tab_type, 'pr') !== FALSE)) && $key == 0) || ('slide' . $slide_row->id == $sub_tab_type)) ? 'wdps_sub_active' : ''; ?>" href="#" >
                        <div style="background-image:url('<?php echo $slide_row->type != 'image' ? ($slide_row->type == 'video' && ctype_digit($slide_row->thumb_url) ? (wp_get_attachment_url(get_post_thumbnail_id($slide_row->thumb_url)) ? wp_get_attachment_url(get_post_thumbnail_id($slide_row->thumb_url)) : WD_PS_URL . '/images/no-video.png') : $slide_row->thumb_url) : $slide_row->thumb_url; ?>');background-position: center" class="tab_image" id="wdps_tab_image<?php echo $slide_row->id; ?>" >
                          <div class="tab_buttons">
														<div class="handle_wrap">
															<div class="handle" title="<?php echo __('Drag to re-order','wdps_back'); ?>"></div>
														</div>
														<div class="wdps_tab_title_wrap">
															<input type="text" id="title<?php echo $slide_row->id; ?>" name="title<?php echo $slide_row->id; ?>" value="<?php echo $slide_row->title; ?>" class="wdps_tab_title" tab_type="slide<?php echo $slide_row->id; ?>" />
														</div>
                            <input type="hidden" name="order<?php echo $slide_row->id; ?>" id="order<?php echo $slide_row->id; ?>" value="<?php echo $slide_row->order; ?>" />
                          </div>
                          <div class="overlay" >
                          <div id="hover_buttons">
                          
                              <!--<span class="wdps_change_thumbnail" onclick="spider_media_uploader('<?php echo $slide_row->id; ?>', event, false); return false;" title="<?php echo __('Edit Slide','wdps_back'); ?>" value="<?php echo __('Edit Image','wdps_back'); ?>"></span>-->
                              <span >
                                  <a class="wdps_change_thumbnail" href="<?php echo add_query_arg(array('action' => 'WDPSPosts','slider_id'=>$row->id, 'slide_id' => $slide_row->id, 'count' => 1, 'width' => '700', 'height' => '550', 'TB_iframe' => '1'), admin_url('admin-ajax.php')); ?>"  title="<?php echo __('Edit Post','wdps_back'); ?>" value="<?php echo __('Edit Post','wdps_back'); ?>"  onclick="if (wdps_check_required('name', 'Name')) {jQuery(this).removeClass('thickbox').removeClass('thickbox-preview');return false;};                                        jQuery(this).addClass('thickbox').addClass('thickbox-preview'); return false;"> 
                              
                                  </a> 
                              </span> 
                              <span class="wdps_slide_dublicate" title="<?php echo __('Duplicate slide','wdps_back'); ?>" onclick="wdps_duplicate_slide('<?php echo $slide_row->id; ?>','<?php echo $slide_row->post_id; ?>');" ></span>
                              <span class="wdps_tab_remove" title="<?php echo __('Remove Slide','wdps_back');?>" title="<?php echo __('Delete slide','wdps_back'); ?>" onclick="wdps_remove_slide('<?php echo $slide_row->id; ?>')"></span>
                              <input type="hidden" name="order<?php echo $slide_row->id; ?>" id="order<?php echo $slide_row->id; ?>" value="<?php echo $slide_row->order; ?>" />
                              <span class="wdps_clear"></span>
                           </div>
                          </div>
                        </div>
                      </div>
                    </div>
                      <?php
                    }
                      }
                    ?>
                    <div class="wdps_subtab_wrap new_tab_image">
                    <div class="new_tab_link" >
                      <a id="wdps_posts_btn" href="<?php echo add_query_arg(array('action' => 'WDPSPosts', 'slider_id' => $id, 'width' => '700', 'height' => '550', 'TB_iframe' => '1'), admin_url('admin-ajax.php')); ?>" class="new_tab_link" title="<?php echo __('Add Posts','wdps_back');?>" onclick="if (wdps_check_required('name', 'Name')) {jQuery(this).removeClass('thickbox').removeClass('thickbox-preview');return false;};                                         jQuery(this).addClass('thickbox').addClass('thickbox-preview'); return false;" >
                <?php echo __('Add Posts','wdps_back'); ?>
                        </a>
                     </div>
                    </div>
                    <div class="wdps_clear"></div>
                  </div>
                 
                  <?php
                  foreach ($slides_row as $key => $slide_row) {
                    if($slide_row->title != 'prototype'  && $slide_row->post_id != 0) {
                        if(isset($slide_row->post_id) && $slide_row->post_id != 0) {                          
                          $post_feild_name = $this->model->get_post_data();
                          $custom_fields_names = get_post_custom_keys($slide_row->post_id);
                          for($k = 0; $k < count($custom_fields_names);++$k) {
                            array_push($post_feild_name,$custom_fields_names[$k]);
                          }
                        }
                        else {
                          $post_feild_name = $this->model->get_post_data();
                        }
                        
                          $post_feild_name = implode(",",$post_feild_name);
                      
                    ?>
                  <div class="wdps_box <?php echo (((($id == 0 || !$sub_tab_type) || (strpos($sub_tab_type, 'pr') !== FALSE)) && $key == 0) || ('slide' . $slide_row->id == $sub_tab_type)) ? 'wdps_sub_active' : ''; ?> wdps_slide<?php echo $slide_row->id; ?>">
                    <table class="ui-sortable<?php echo $slide_row->id; ?>">
                      <thead><tr><td colspan="4">&nbsp;</td></tr></thead>
                      <tbody>
                        <input type="hidden" name="type<?php echo $slide_row->id; ?>" id="type<?php echo $slide_row->id; ?>" value="<?php echo $slide_row->type; ?>" />
                        <input type="hidden" name="wdps_video_type<?php echo $slide_row->id; ?>" id="wdps_video_type<?php echo $slide_row->id; ?>" />
                        <tr class="bgcolor">
                          <td colspan="4">
                          <h2 class="titles"><?php echo __('Edit Slides','wdps_back'); ?></h2>
                            <div id="slide_add_buttons">
                            <?php
                            $query_url = wp_nonce_url(admin_url('admin-ajax.php'), '', 'wdps_nonce');
                            ?>
                            <script>
                              var ajax_url = "<?php echo $query_url; ?>";
                            </script>
                            <div class="slide_add_buttons_wrap">
                            <a href="<?php echo add_query_arg(array('action' => 'WDPSPosts','slider_id'=>$row->id, 'slide_id' => $slide_row->id, 'count' => 1, 'width' => '700', 'height' => '550', 'TB_iframe' => '1'), admin_url('admin-ajax.php')); ?>" class="action_buttons add_post thickbox thickbox-preview" title="<?php echo __('Add/Edit Post','wdps_back'); ?>" onclick="if (wdps_check_required('name', 'Name')) {jQuery(this).removeClass('thickbox').removeClass('thickbox-preview');return false;};
                                                                                                                                                                                                                                                                                            jQuery(this).addClass('thickbox').addClass('thickbox-preview'); return false;">
                              <?php echo __('Add Post','wdps_back'); ?>
                            </a>
                           </div> 
                            <div class="slide_add_buttons_wrap">	
                               <input type="button" class="action_buttons delete"  id="delete_image_url<?php echo $slide_row->id; ?>" onclick="wdps_remove_slide('<?php echo $slide_row->id; ?>')" value="<?php echo __('Delete','wdps_back');?>" />
                             </div>
                            <input type="hidden" id="image_url<?php echo $slide_row->id; ?>" name="image_url<?php echo $slide_row->id; ?>" value="<?php echo $slide_row->image_url; ?>" />
                            <input type="hidden" id="thumb_url<?php echo $slide_row->id; ?>" name="thumb_url<?php echo $slide_row->id; ?>" value="<?php echo $slide_row->thumb_url; ?>" />
                            <div class="clear"></div>
                            </div>
                          </td>
                        </tr>
                        <tr class="bgcolor">
                          <td colspan="4">
                            <div id="wdps_preview_wrapper_<?php echo $slide_row->id; ?>" class="wdps_preview_wrapper" style="width: <?php echo $row->width; ?>px; height: <?php echo $row->height; ?>px;">
                              <div class="wdps_preview" style="overflow: hidden; position: absolute; width: inherit; height: inherit; background-color: transparent; background-image: none; display: block;">
                              
                                <div id="wdps_preview_image<?php echo $slide_row->id; ?>" class="wdps_preview_image<?php echo $slide_row->id; ?>"
                                     style='background-color: <?php echo WDW_PS_Library::spider_hex2rgba($row->background_color, (100 - $row->background_transparent) / 100); ?>;
                                            background-image: url("<?php echo $slide_row->type != 'image'  ? $slide_row->thumb_url : $slide_row->image_url . '?date=' . date('Y-m-d H:i:s'); ?>");
                                            background-position: center center;
                                            background-repeat: no-repeat;
                                            background-size: <?php echo $row->bg_fit; ?>;
                                            width: inherit;
                                            height: inherit;
                                            /*position: relative;*/'>
                                <?php
                                $layers_row = $this->model->get_layers_row_data($slide_row->id,$slide_row->post_id);
                                if ($layers_row) {
                                  foreach ($layers_row as $key => $layer) {
                                    //$post_feild_name = implode(",",$post_feild_name[$key]);
                                    $prefix = 'slide' . $slide_row->id . '_layer' . $layer->id;
                                    switch ($layer->type) {
                                      
                                      case 'text': {
                                        ?>
                                        <span id="<?php echo $prefix; ?>" class="wdps_draggable_<?php echo $slide_row->id; ?> wdps_draggable ui-draggable" onclick="wdps_showhide_layer('<?php echo $prefix; ?>_tbody', 1)"
                                              style="<?php echo $layer->image_width ? 'width: ' . $layer->image_width . '%; ' : ''; ?><?php echo $layer->image_height ? 'height: ' . $layer->image_height . '%; ' : ''; ?>word-break: <?php echo ($layer->image_scale ? 'normal' : 'break-all'); ?>; display: inline-block; position: absolute; left: <?php echo $layer->left; ?>px; top: <?php echo $layer->top; ?>px; z-index: <?php echo $layer->depth; ?>; color: #<?php echo $layer->color; ?>; font-size: <?php echo $layer->size; ?>px; line-height: 1.25em; font-family: <?php echo $layer->ffamily; ?>; font-weight: <?php echo $layer->fweight; ?>; padding: <?php echo $layer->padding; ?>; background-color: <?php echo WDW_PS_Library::spider_hex2rgba($layer->fbgcolor, (100 - $layer->transparent) / 100); ?>; border: <?php echo $layer->border_width; ?>px <?php echo $layer->border_style; ?> #<?php echo $layer->border_color; ?>; border-radius: <?php echo $layer->border_radius; ?>; box-shadow: <?php echo $layer->shadow; ?>"><?php echo str_replace(array("\r\n", "\r", "\n"), "<br>", $layer->text); ?></span>
                                        <?php
                                        break;
                                      }
                                      case 'image': {
                                        ?>
                                        <img id="<?php echo $prefix; ?>" class="wdps_draggable_<?php echo $slide_row->id; ?> wdps_draggable ui-draggable" onclick="wdps_showhide_layer('<?php echo $prefix; ?>_tbody', 1)" src="<?php echo $layer->image_url; ?>"
                                             style="opacity: <?php echo (100 - $layer->imgtransparent) / 100; ?>; filter: Alpha(opacity=<?php echo 100 - $layer->imgtransparent; ?>); position: absolute; left: <?php echo $layer->left; ?>px; top: <?php echo $layer->top; ?>px; z-index: <?php echo $layer->depth; ?>; border: <?php echo $layer->border_width; ?>px <?php echo $layer->border_style; ?> #<?php echo $layer->border_color; ?>; border-radius: <?php echo $layer->border_radius; ?>; box-shadow: <?php echo $layer->shadow; ?>; " />
                                        <?php
                                        break;
                                      }
                                      case 'video': {
                                        ?>
                                        <img id="<?php echo $prefix; ?>" class="wdps_draggable_<?php echo $slide_row->id; ?> wdps_draggable ui-draggable" onclick="wdps_showhide_layer('<?php echo $prefix; ?>_tbody', 1)" src="<?php echo $layer->image_url; ?>"
                                             style="max-width: <?php echo $layer->image_width; ?>px; width: <?php echo $layer->image_width; ?>px; max-height: <?php echo $layer->image_height; ?>px; height: <?php echo $layer->image_height; ?>px; position: absolute; left: <?php echo $layer->left; ?>px; top: <?php echo $layer->top; ?>px; z-index: <?php echo $layer->depth; ?>; border: <?php echo $layer->border_width; ?>px <?php echo $layer->border_style; ?> #<?php echo $layer->border_color; ?>; border-radius: <?php echo $layer->border_radius; ?>; box-shadow: <?php echo $layer->shadow; ?>;" />
                                        <?php
                                        break;
                                      }
                                      case 'social': {
                                        ?>
                                        <style>#<?php echo $prefix; ?>:hover {color: #<?php echo $layer->hover_color; ?> !important;}</style>
                                        <i id="<?php echo $prefix; ?>" class="wdps_draggable_<?php echo $slide_row->id; ?> wdps_draggable fa fa-<?php echo $layer->social_button; ?> ui-draggable" onclick="wdps_showhide_layer('<?php echo $prefix; ?>_tbody', 1)"
                                           style="opacity: <?php echo (100 - $layer->transparent) / 100; ?>; filter: Alpha(opacity=<?php echo 100 - $layer->transparent; ?>); position: absolute; left: <?php echo $layer->left; ?>px; top: <?php echo $layer->top; ?>px; z-index: <?php echo $layer->depth; ?>; color: #<?php echo $layer->color; ?>; font-size: <?php echo $layer->size; ?>px; line-height: <?php echo $layer->size; ?>px; padding: <?php echo $layer->padding; ?>; "></i>
                                        <?php
                                        break;
                                      }
                                      default:
                                        break;
                                    }
                                  }
                                }
                                ?>
                                </div>
                              </div>
                            </div>
                          </td>
                        </tr>
                       <tr>
                          <td>
                            <table class="wdps_slide_radio_left">
                              <tr>
                                <td class="spider_label"><label><?php echo __('Published:','wdps_back'); ?> </label></td>
                                <td>
                                  <input type="radio" id="published<?php echo $slide_row->id; ?>1" name="published<?php echo $slide_row->id; ?>" <?php echo (($slide_row->published) ? 'checked="checked"' : ''); ?> value="1" /><label <?php echo (($slide_row->published) ? 'class="selected_color"' : ''); ?> for="published<?php echo $slide_row->id; ?>1"><?php echo __('Yes','wdps_back');?></label>
                                  <input type="radio" id="published<?php echo $slide_row->id; ?>0" name="published<?php echo $slide_row->id; ?>" <?php echo (($slide_row->published) ? '' : 'checked="checked"'); ?> value="0" /><label <?php echo (($slide_row->published) ? '' : 'class="selected_color"'); ?> for="published<?php echo $slide_row->id; ?>0"><?php echo __('No','wdps_back'); ?></label>
                                </td>
                              </tr>
                            </table>
                            <table class="wdps_slide_radio_right">
                             
                              <tr id="trlink<?php echo $slide_row->id; ?>" <?php echo $slide_row->type == 'image' ? '' : 'style="display: none;"'; ?>>
                                <td title="<?php echo __('You can set a redirection link, so that the user will get to the mentioned location upon hitting the slide.Use http:// and https:// for external links.','wdps_back'); ?>" class="wdps_tooltip spider_label">
                                  <label for="link<?php echo $slide_row->id; ?>"><?php echo __('Link the slide to:','wdps_back'); ?> </label>
                                </td>
                                <td>
                                  <input class="wdps_external_link" id="link<?php echo $slide_row->id; ?>" type="text" value="<?php echo $slide_row->link; ?>" name="link<?php echo $slide_row->id; ?>" />
                                  <input id="target_attr_slide<?php echo $slide_row->id; ?>" type="checkbox"  name="target_attr_slide<?php echo $slide_row->id; ?>" <?php echo (($slide_row->target_attr_slide) ? 'checked="checked"' : ''); ?> value="1" /><label for="target_attr_slide<?php echo $slide_row->id; ?>"> <?php echo __('Open in a new window','wdps_back'); ?></label>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td>
                          <?php
                          if(isset($slide_row->post_id)) {
                            
                          ?>
                            <input type="hidden" id="wdps_post_id<?php echo $slide_row->id; ?>" name="wdps_post_id<?php echo $slide_row->id; ?>" value="<?php echo $slide_row->post_id; ?>"/>
                            <?php
                          }
                          ?>
                          </td>
                        </tr>
                        
                        <tr class="bgcolor">
                          <td colspan="4"> 
                          <h2 class="titles"><?php echo __('Layers','wdps_back'); ?></h2>
                         <div id="layer_add_buttons">
                          <div class="layer_add_buttons_wrap">
                            <input type="button"  class="action_buttons add_text_layer button-small" onclick="wdps_add_layer('text', '<?php echo $slide_row->id; ?>','','',1,0,'post','<?php echo $post_feild_name; ?>'); return false;" value="<?php echo __('Add Text Layer','wdps_back'); ?>" />
                          </div>
                          <div class="layer_add_buttons_wrap">
                            <button  class="action_buttons add_image_layer <?php echo !$fv ? "" : " wdps_free_button"; ?>  button-small" onclick="<?php echo !$fv ? "wdps_add_layer('image', '" . $slide_row->id . "', '', event)" : "alert('This functionality is disabled in free version.')"; ?>; return false;"  >Add Image Layer</button>
                          </div>
                          <div class="layer_add_buttons_wrap">
                             <button class="action_buttons add_social_layer button-small wdps_free_button" onclick="alert('This functionality is disabled in free version.'); return false;" > Social Button Layer</button>
                          </div>
                          <div class="layer_add_buttons_wrap">
                            <button class="action_buttons add_hotspot_layer button-small wdps_free_button" onclick="alert('This functionality is disabled in free version.'); return false;" >Add Hotspot Layer</button>
                          </div>
                          <div class="clear"></div>
                         </div>
                         </td>
                        </tr>
                      </tbody>
                      <?php
                      $layer_ids_string = '';
                     
                      if ($layers_row) {
                        foreach ($layers_row as $key => $layer) {
                          $prefix = 'slide' . $slide_row->id . '_layer' . $layer->id;
                       
                          ?>
                          <tbody class="layer_table_count" id="<?php echo $prefix; ?>_tbody">
                            <tr class="wdps_layer_head_tr">
                              <td class="wdps_layer_head" colspan="4">
                              <div class="wdps_layer_left">
                                <div class="layer_handle handle connectedSortable" title="<?php echo __('Drag to re-order','wdps_back'); ?>"></div>
                                <span class="wdps_layer_label" onclick="wdps_showhide_layer('<?php echo $prefix; ?>_tbody', 0)"><input id="<?php echo $prefix; ?>_title" name="<?php echo $prefix; ?>_title" type="text" class="wdps_layer_title" style="width: 80px; color:#00A2D0;padding:5px;" value="<?php echo $layer->title; ?>" title="<?php echo __('Layer title','wdps_back'); ?>" /></span>
                              </div>
                              <div class="wdps_layer_right">
                                <span class="wdps_layer_remove" onclick="wdps_delete_layer('<?php echo $slide_row->id; ?>', '<?php echo $layer->id; ?>')" title="<?php __('Delete layer','wdps_back'); ?>"></span>
                                <span class="wdps_layer_dublicate" onclick="wdps_add_layer('<?php echo $layer->type; ?>', '<?php echo $slide_row->id; ?>', '', '', 1,0,'post','<?php echo $post_feild_name; ?>'); wdps_duplicate_layer('<?php echo $layer->type; ?>', '<?php echo $slide_row->id; ?>', '<?php echo $layer->id; ?>');" title="<?php echo __('Duplicate layer','wdps_back'); ?>"></span>
                                 <input id="<?php echo $prefix; ?>_depth" class="wdps_layer_depth spider_int_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({zIndex: jQuery(this).val()})" onkeypress="return spider_check_isnum(event)" value="<?php echo $layer->depth; ?>" prefix="<?php echo $prefix; ?>" name="<?php echo $prefix; ?>_depth" title="z-index" />
                              </div>  
                                <div class="wdps_clear"></div>
                              </td>
                            </tr>
                            <?php
                          
                           
                            switch ($layer->type) {
                              /*--------text layer----------*/
                              case 'text': {
                                ?>
                            <tr class="wdps_layer_tr" style="display:none;">
                                <td colspan=2>
                                  <table class="layer_table_left">
                              <tr>
                              <td  class="spider_label">
                                <label for="<?php echo $prefix; ?>_text"><?php echo __('Text:','wdps_back'); ?> </label>
                              </td>
                              <td>
                                <textarea id="<?php echo $prefix; ?>_text" class='wdps_textarea' name="<?php echo $prefix; ?>_text" style="width: 555px; height: 100px; resize: vertical;" onkeyup="wdps_new_line('<?php echo $prefix; ?>');"><?php echo $layer->text; ?></textarea>
                                <div class="spider_description" ></div>
                                <?php
                                $post_id = $slide_row->post_id;
                                if(isset($slide_row->post_id) && $slide_row->post_id !=0 ) {
                                $custom_fields_name = get_post_custom_keys($post_id);
                                $post_feild_name = $this->model->get_post_data();
                                  for($k = 0; $k < count($custom_fields_name);++$k) {
                                    array_push($post_feild_name,$custom_fields_name[$k]);
                                  }
                                }
                                else {
                                   $post_feild_name = $this->model->get_post_data();
                                }
                                  for($i = 0; $i < count($post_feild_name); ++$i) {
                                      ?>
                                      <input type='button' class="button-primary" id ="wdps_post<?php echo $slide_row->id; ?>" style="line-height:4px;display:table;float:left;margin:3px;" value="<?php echo $post_feild_name[$i]; ?>" onclick="wdps_add_post_feilds('<?php echo $prefix; ?>','<?php echo  $post_feild_name[$i]; ?>');"/>
                                      <?php
                                  }
                                  $post_feild_name = implode(",",$post_feild_name);
                                ?>
                              </td>	
                              </tr>
                            <tr>
                              <td title="<?php echo __('Leave blank to keep the initial width and height.');?>" class="wdps_tooltip spider_label">
                                <label for="<?php echo $prefix; ?>_image_width"><?php echo __('Dimensions:','wdps_back'); ?> </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_image_width" class="spider_int_input" type="text" onchange="wdps_text_width(this, '<?php echo $prefix; ?>')" value="<?php echo $layer->image_width; ?>" name="<?php echo $prefix; ?>_image_width" /> x 
                                <input id="<?php echo $prefix; ?>_image_height" class="spider_int_input" type="text" onchange="wdps_text_height(this, '<?php echo $prefix; ?>')" value="<?php echo $layer->image_height; ?>" name="<?php echo $prefix; ?>_image_height" /> % 
                                <input id="<?php echo $prefix; ?>_image_scale" type="checkbox" onchange="wdps_break_word(this, '<?php echo $prefix; ?>')" name="<?php echo $prefix; ?>_image_scale" <?php echo (($layer->image_scale) ? 'checked="checked"' : ''); ?> /><label for="<?php echo $prefix; ?>_image_scale"><?php echo __('Break-word','wdps_back'); ?></label>
                              </td>
                            </tr>
                          <tr>
                              <td title="<?php echo __('In addition you can drag and drop the layer to a desired position.','wdps_back'); ?>" class="wdps_tooltip spider_label">
                                <label><?php echo __('Position:','wdps_back'); ?> </label>
                              </td>
                              <td>
                                X <input id="<?php echo $prefix; ?>_left" class="spider_int_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({left: jQuery(this).val() + 'px'})" onkeypress="return spider_check_isnum(event)" value="<?php echo $layer->left; ?>" name="<?php echo $prefix; ?>_left" />
                                Y <input id="<?php echo $prefix; ?>_top" class="spider_int_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({top: jQuery(this).val() + 'px'})" onkeypress="return spider_check_isnum(event)" value="<?php echo $layer->top; ?>" name="<?php echo $prefix; ?>_top" />
                              </td> 
                            </tr>		
                                    <tr>
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_size"><?php echo __('Size:','wdps_back'); ?> </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_size" class="spider_int_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({fontSize: jQuery(this).val() + 'px', lineHeight: jQuery(this).val() + 'px'})" onkeypress="return spider_check_isnum(event)" value="<?php echo $layer->size; ?>" name="<?php echo $prefix; ?>_size" /> px
                                <div class="spider_description"></div>
                              </td>
                            </tr>
                          <tr>
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_color"><?php echo __('Color:','wdps_back'); ?> </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_color" class="color" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({color: '#' + jQuery(this).val()})" value="<?php echo $layer->color; ?>" name="<?php echo $prefix; ?>_color" />
                                <div class="spider_description"></div>
                              </td>
                            </tr>
                           <tr>
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_ffamily"><?php echo __('Font family:','wdps_back'); ?> </label>
                              </td>
                              <td>
                                <select class="select_icon select_icon_320" style="width: 200px;" id="<?php echo $prefix; ?>_ffamily" onchange="wdps_change_fonts('<?php echo $prefix; ?>', 1)" name="<?php echo $prefix; ?>_ffamily">
                                  <?php
                                  $fonts = (isset($layer->google_fonts) && $layer->google_fonts) ? $google_fonts : $font_families;
                                  foreach ($fonts as $key => $font_family) {
                                    ?>
                                    <option value="<?php echo $key; ?>" <?php echo (($layer->ffamily == $key) ? 'selected="selected"' : ''); ?>><?php echo $font_family; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                                <input id="<?php echo $prefix; ?>_google_fonts1" type="radio" name="<?php echo $prefix;  ?>_google_fonts" value="1" <?php echo (($layer->google_fonts) ? 'checked="checked"' : ''); ?> onchange="wdps_change_fonts('<?php echo $prefix; ?>')" />
                                <label for="<?php echo $prefix; ?>_google_fonts1"><?php echo __('Google fonts','wdps_back'); ?></label>
                                <input id="<?php echo $prefix; ?>_google_fonts0" type="radio" name="<?php echo $prefix;?>_google_fonts" value="0" <?php echo (($layer->google_fonts) ? '' : 'checked="checked"'); ?> onchange="wdps_change_fonts('<?php echo $prefix; ?>')" />
                                <label for="<?php echo $prefix; ?>_google_fonts0"><?php echo __('Default','wdps_back'); ?></label>
                                <div class="spider_description"></div>
                              </td>
                            </tr>
                            <tr>
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_fweight"><?php echo __('Font weight:','wdps_back'); ?> </label>
                              </td>
                              <td>
                                  <select class="select_icon select_icon_320" style="width:70px" id="<?php echo $prefix; ?>_fweight" onchange="jQuery('#<?php echo $prefix; ?>').css({fontWeight: jQuery(this).val()})" name="<?php echo $prefix; ?>_fweight">
                                  <?php
                                  foreach ($font_weights as $key => $fweight) {
                                    ?>
                                    <option value="<?php echo $key; ?>" <?php echo (($layer->fweight == $key) ? 'selected="selected"' : ''); ?>><?php echo $fweight; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                                <div class="spider_description"></div>
                              </td>
                            </tr>
                           <tr>
                              <td title="<?php echo __('Use http:// and https:// for external links.','wdps_back'); ?>" class="wdps_tooltip spider_label">
                                <label for="<?php echo $prefix; ?>_link"><?php echo __('Link:','wdps_back'); ?> </label>
                              </td>
                                <td colspan="2">
                                <input class="wdps_link" id="<?php echo $prefix; ?>_link" type="text" style="width: 200px;" value="<?php echo $layer->link; ?>" name="<?php echo $prefix; ?>_link" />
                                <input id="<?php echo $prefix; ?>_target_attr_layer" type="checkbox"  name="<?php echo $prefix; ?>_target_attr_layer" <?php echo (($layer->target_attr_layer) ? 'checked="checked"' : ''); ?> value="1" /><label for="<?php echo $prefix; ?>_target_attr_layer"> <?php echo __('Open in a new window','wdps_back'); ?></label>
                              </td>
                            </tr>
                            <tr>
                              <td class="spider_label">
                                <label><?php echo __('Published:','wdps_back'); ?> </label>
                              </td>
                               <td colspan=3>
                                <input id="<?php echo $prefix; ?>_published1" type="radio" name="<?php echo $prefix; ?>_published" value="1" <?php echo (($layer->published) ? 'checked="checked"' : ''); ?> />
                                <label <?php echo (($layer->published) ? 'class="selected_color"' : ''); ?> for="<?php echo $prefix; ?>_published1"><?php echo __('Yes','wdps_back'); ?></label>
                                <input id="<?php echo $prefix; ?>_published0" type="radio" name="<?php echo $prefix; ?>_published" value="0" <?php echo (($layer->published) ? '' : 'checked="checked"'); ?> />
                                <label <?php echo (($layer->published) ?  '' : 'class="selected_color"'); ?> for="<?php echo $prefix; ?>_published0"><?php echo __('No','wdps_back'); ?></label>
                                <div class="spider_description"></div>
                              </td>
                            </tr>
                            </table>
                            <table class="layer_table_right" >
                            <tr>
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_layer_effect_in"><?php echo __('Effect In:','wdps_back'); ?></label>
                              </td>
                              <td>
                                <span style="display: table-cell;">
                                  <input id="<?php echo $prefix; ?>_start" class="spider_int_input" type="text" value="<?php echo $layer->start; ?>" name="<?php echo $prefix; ?>_start" /> ms 
                                  <div class="spider_description"><?php echo __('Start','wdps_back'); ?></div>
                                </span>
                                <span style="display: table-cell;">
                                  <select class="select_icon select_icon_320" name="<?php echo $prefix; ?>_layer_effect_in" id="<?php echo $prefix; ?>_layer_effect_in" style="width:150px;" onchange="wdps_trans_effect_in('<?php echo $slide_row->id; ?>', '<?php echo $prefix; ?>', 0); wdps_trans_end('<?php echo $prefix; ?>', jQuery(this).val());">
                                  <?php
                                  foreach ($layer_effects_in as $key => $layer_effect_in) {
                                    ?>
                                     <option value="<?php echo $key; ?>" <?php echo (!in_array($key, $free_layer_effects)) ? 'disabled="disabled" title="This effect is disabled in free version."' : ''; ?> <?php if ($layer->layer_effect_in == $key) echo 'selected="selected"'; ?>><?php echo $layer_effect_in; ?></option>
                                    <?php
                                  }
                                  ?>
                                  </select>
                                  <div class="spider_description"><?php echo __('Effect','wdps_back'); ?></div>
                                </span>
                                <span style="display: table-cell;">
                                  <input id="<?php echo $prefix; ?>_duration_eff_in" class="spider_int_input" type="text" onkeypress="return spider_check_isnum(event)" onchange="wdps_trans_effect_in('<?php echo $slide_row->id; ?>', '<?php echo $prefix; ?>', 0); wdps_trans_end('<?php echo $prefix; ?>', jQuery('#<?php echo $prefix; ?>_layer_effect_in').val());" value="<?php echo $layer->duration_eff_in; ?>" name="<?php echo $prefix; ?>_duration_eff_in" /> ms
                                  <div class="spider_description"><?php echo __('Duration','wdps_back'); ?></div>
                                </span>
                                <div class="wd_error" style="padding: 5px; font-size: 14px; color: #000000 !important;">Some effects are disabled in free version.</div>
                              </td>
                            </tr>
                             <tr>
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_layer_effect_out"><?php echo __('Effect Out:','wdps_back'); ?></label>
                              </td>
                              <td>
                                <span style="display: table-cell;">
                                  <input id="<?php echo $prefix; ?>_end" class="spider_int_input" type="text" value="<?php echo $layer->end; ?>" name="<?php echo $prefix; ?>_end"> ms
                                  <div class="spider_description"><?php echo __('Start','wdps_back');?></div>
                                </span> 
                                <span style="display: table-cell;">
                                  <select class="select_icon select_icon_320" name="<?php echo $prefix; ?>_layer_effect_out" id="<?php echo $prefix; ?>_layer_effect_out" style="width:150px;" onchange="wdps_trans_effect_out('<?php echo $slide_row->id; ?>', '<?php echo $prefix; ?>', 0); wdps_trans_end('<?php echo $prefix; ?>', jQuery(this).val());">
                                  <?php
                                  foreach ($layer_effects_out as $key => $layer_effect_out) {
                                    ?>
                                    <option value="<?php echo $key; ?>" <?php echo (!in_array($key, $free_layer_effects)) ? 'disabled="disabled" title="This effect is disabled in free version."' : ''; ?> <?php if ($layer->layer_effect_out == $key) echo 'selected="selected"'; ?>><?php echo $layer_effect_out; ?></option>
                                    <?php
                                  }
                                  ?>
                                  </select>
                                  <div class="spider_description"><?php echo __('Effect','wdps_back'); ?></div>
                                </span> 
                                
                                <span style="display: table-cell;">
                                  <input id="<?php echo $prefix; ?>_duration_eff_out" class="spider_int_input" type="text" onkeypress="return spider_check_isnum(event)" onchange="wdps_trans_effect_out('<?php echo $slide_row->id; ?>', '<?php echo $prefix; ?>', 0); wdps_trans_end('<?php echo $prefix; ?>', jQuery('#<?php echo $prefix; ?>_layer_effect_out').val());" value="<?php echo $layer->duration_eff_out; ?>" name="<?php echo $prefix; ?>_duration_eff_out"> ms
                                  <div class="spider_description"><?php echo __('Duration','wdps_back'); ?></div>
                                </span>
                                <div class="wd_error" style="padding: 5px; font-size: 14px; color: #000000 !important;">Some effects are disabled in free version.</div>
                              </td>
                            </tr>
                            <tr>
                              <td title="<?php echo __('Use CSS type values.','wdps_back'); ?>" class="wdps_tooltip spider_label">
                                <label for="<?php echo $prefix; ?>_padding"><?php echo __('Padding:','wdps_back'); ?> </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_padding" class="spider_char_input" type="text" onchange="document.getElementById('<?php echo $prefix; ?>').style.padding=jQuery(this).val();" value="<?php echo $layer->padding; ?>" name="<?php echo $prefix; ?>_padding">
                                <div class="spider_description"><?php echo __('Use CSS type values.','wdps_back'); ?></div>
                              </td>                              
                            </tr>		
                            <tr> 
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_fbgcolor"><?php echo __('Background Color:','wdps_back'); ?> </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_fbgcolor" class="color" type="text" onchange="wde_change_text_bg_color('<?php echo $prefix; ?>')" value="<?php echo $layer->fbgcolor; ?>" name="<?php echo $prefix; ?>_fbgcolor" />
                                <div class="spider_description"></div>
                              </td>
                            </tr>
                            <tr>
                              <td title="<?php echo __('Value must be between 0 to 100.','wdps_back'); ?>" class="wdps_tooltip spider_label">
                                <label for="<?php echo $prefix; ?>_transparent"><?php echo __('Transparent:','wdps_back'); ?> </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_transparent" class="spider_int_input" type="text" onchange="wde_change_text_bg_color('<?php echo $prefix; ?>')" onkeypress="return spider_check_isnum(event)" value="<?php echo $layer->transparent; ?>" name="<?php echo $prefix; ?>_transparent"> %
                                <div class="spider_description"><?php echo __('Value must be between 0 to 100.','wdps_back'); ?></div>
                              </td>
                            </tr>
                            <tr>
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_border_width"><?php echo __('Border:','wdps_back'); ?> </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_border_width" class="spider_int_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({borderWidth: jQuery(this).val()})" onkeypress="return spider_check_isnum(event)" value="<?php echo $layer->border_width; ?>" name="<?php echo $prefix; ?>_border_width"> px
                                <select class="select_icon select_icon_320" id="<?php echo $prefix; ?>_border_style" onchange="jQuery('#<?php echo $prefix; ?>').css({borderStyle: jQuery(this).val()})" style="width: 80px;" name="<?php echo $prefix; ?>_border_style">
                                  <?php
                                  foreach ($border_styles as $key => $border_style) {
                                    ?>
                                    <option value="<?php echo $key; ?>" <?php echo (($layer->border_style == $key) ? 'selected="selected"' : ''); ?>><?php echo $border_style; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                                <input id="<?php echo $prefix; ?>_border_color" class="color" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({borderColor: '#' + jQuery(this).val()})" value="<?php echo $layer->border_color; ?>" name="<?php echo $prefix; ?>_border_color" />
                                <div class="spider_description"></div>
                              </td>
                            </tr>
                           <tr>
                              <td title="<?php echo __('Use CSS type values.','wdps_back'); ?>" class="wdps_tooltip spider_label">
                                <label for="<?php echo $prefix; ?>_border_radius"><?php echo __('Radius:','wdps_back'); ?> </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_border_radius" class="spider_char_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({borderRadius: jQuery(this).val()})" value="<?php echo $layer->border_radius; ?>" name="<?php echo $prefix; ?>_border_radius">
                                <div class="spider_description"><?php echo __('Use CSS type values.','wdps_back'); ?></div>
                              </td>
                            </tr>
                            <tr>
                              <td title="<?php echo __('Use CSS type values (e.g. 10px 10px 5px #888888).','wdps_back'); ?>" >
                                <label for="<?php echo $prefix; ?>_shadow"><?php echo __('Shadow:','wdps_back'); ?> </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_shadow" class="spider_char_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({boxShadow: jQuery(this).val()})" value="<?php echo $layer->shadow; ?>" name="<?php echo $prefix; ?>_shadow" />
                                <div class="spider_description"><?php echo __('Use CSS type values (e.g. 10px 10px 5px #888888).','wdps_back'); ?></div>
                              </td>
                            </tr>
                            
                              </table>
                               </td>
                            </tr>
                                <?php
                           // }
                                break;
                              }
                              default:
                                break;
                            }
                            ?>
                            <input type="hidden" name="<?php echo $prefix; ?>_type" id="<?php echo $prefix; ?>_type" value="<?php echo $layer->type; ?>" />
                          </tbody>
                          <?php
                          $layer_ids_string .= $layer->id . ',';
                        }
                      }
                      ?>
                    </table>
                    <input id="slide<?php echo $slide_row->id; ?>_layer_ids_string" name="slide<?php echo $slide_row->id; ?>_layer_ids_string" type="hidden" value="<?php echo $layer_ids_string; ?>" />
                    <input id="slide<?php echo $slide_row->id; ?>_del_layer_ids_string" name="slide<?php echo $slide_row->id; ?>_del_layer_ids_string" type="hidden" value="" />
                  </div>
                    <script>
                      jQuery(document).ready(function() {
                        image_for_next_prev_butt('<?php echo $row->rl_butt_img_or_not; ?>');
                        image_for_bull_butt('<?php echo $row->bull_butt_img_or_not; ?>');						
                        image_for_play_pause_butt('<?php echo $row->play_paus_butt_img_or_not; ?>');
                        showhide_for_carousel_fildes('<?php echo $row->carousel; ?>');
                        wdps_whr('width');
                        wdps_drag_layer('<?php echo $slide_row->id; ?>');
                        wdps_layer_weights('<?php echo $slide_row->id; ?>');
                        <?php
                        
                        if ($layers_row) {
                          foreach ($layers_row as $key => $layer) {
                            if ($layer->type == 'image') {
                              $prefix = 'slide' . $slide_row->id . '_layer' . $layer->id;
                              ?>
                          wdps_scale('#<?php echo $prefix; ?>_image_scale', '<?php echo $prefix; ?>');
                              <?php
                            }
                          }
                        }
                        ?>
                      });
                    </script>
                    <?php
                    $slide_ids_string .= $slide_row->id . ',' ;
                    }
                  }
                  ?>
                </td>
              </tr>
            </tbody>
          </table>
          </div>
          <div class="wdps_box dynamic_slides">
          <table>
            <tbody style="display: block;">
              <tr style="display: block;">
                <td colspan="4" style="display: block;">
          <div class="bgcolor wdps_tabs">
          <table>
           <tbody>
            <tr> 
              <td>            
                <table class="wdps_slide_dynamic_left">
                  <tr>
                    <td class="spider_label"><label for="cache_expiration_count"><?php echo __('Period of posts to display:','wdps_back'); ?> </label></td>
                    <td>
                      <input type="text" id="cache_expiration_count" name="cache_expiration_count" value="<?php echo $cache_expiration_count; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" />
                       <select class="select_icon select_icon_320" name="cache_expiration_name" id="cache_expiration_name">
                         <option >
                           <?php echo  '<p>'. '' . '</p>'; ?>
                         </option>
                      <?php
                      foreach($cache_expiration as $key => $cache_expirations ) {
                       ?>
                       <option value="<?php echo $key; ?>" <?php echo (($key == $cache_expiration_name) ? 'selected="selected"' : ''); ?>>
                          <?php echo  '<p>'. $cache_expirations. '</p>'; ?>
                        </option > 
                      <?php  
                      }
                      ?>
                      </select>
                      <div class="spider_description"><?php echo __('Set the time for the posts, e.g. if set it to 24 hours it will display the posts added within the last 24 hours.','wdps_back'); ?></div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label for="posts_count"><?php echo __('Number of posts:','wdps_back'); ?> </label></td>
                    <td>
                      <input type="text" id="posts_count" name="posts_count" value="<?php echo $row->posts_count; ?>" class="spider_int_input" onkeypress="return spider_check_isnum(event)" />
                      <div class="spider_description"><?php echo __('Set the number of posts which will be displayed as slides. If set to 0 or left empty it will display all posts.','wdps_back'); ?></div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label_options">
                      <label for="choose_post"><?php echo __('Choose post type:','wdps_back'); ?></label>
                    </td>
                    <td>
                    
                      <select class="select_icon select_icon_320" name="choose_post" id="choose_post">
                        <?php
                        foreach ($post_types as $post_type) {
                          if($post_type != 'page' && $post_type != 'attachment'&& $post_type != 'nav_menu_item' && $post_type != 'revision') {
                          ?>
                        <option  <?php echo (($post_type == $row->choose_post) ? 'selected="selected"' : ''); ?>>
                          <?php echo  '<p>'. $post_type. '</p>'; ?>
                        </option > 
                          <?php
                        }
                        }
                        ?>
                      </select>
                      <div class="spider_description"><?php echo __('Select the type for the dynamic posts, e.g. standard or custom post types.','wdps_back'); ?></div>
                    </td>
                  </tr>
               
                </table>  
              </td>
              <td>
                <table class="wdps_slide_dynamic_right" style="margin-top:17px;" >
                   <tr>
                    <td class="spider_label_options">
                      <label for="author_name"><?php echo __('Author:','wdps_back'); ?></label>
                    </td>
                    <td>
                    
                      <select class="select_icon select_icon_320" name="author_name" id="author_name">
                       <option  >
                          <?php echo  '<p>'.''. '</p>'; ?>
                        </option >
                        <?php
                         
                         foreach($users_name as $key => $user_name) {
                           
                          ?>
                        <option  <?php echo (($user_name->display_name == $row->author_name ) ? 'selected="selected"' : ''); ?>>
                          <?php echo  '<p>'. $user_name->display_name  . '</p>'; ?>
                        </option > 
                          <?php
                        }
                        
                        ?>
                      </select>
                      <div class="spider_description"><?php echo __('Select the author whose posts will be displayed within the slider.','wdps_back'); ?></div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label_options">
                      <label for="post_sort"><?php echo __('Sort posts by:','wdps_back'); ?></label>
                    </td>
                    <td>
                    
                      <select class="select_icon select_icon_320" name="post_sort" id="post_sort">
                      <option  >
                          <?php echo  '<p>'.''. '</p>'; ?>
                        </option >
                        <?php
                        foreach ($post_sort as $key => $post_sort) {
                          ?>
                        <option value="<?php echo $key; ?>" <?php echo (($key == $row->post_sort) ? 'selected="selected"' : ''); ?>>
                          <?php echo  '<p>'. $post_sort. '</p>'; ?>
                        </option > 
                          <?php
                        }
                        ?>
                      </select>
                      <div class="spider_description"> <?php echo __('Select the option which will be used as a sorting basis while displaying posts.','wdps_back'); ?></div>
                    </td>
                  </tr>
                  <tr>
                    <td class="spider_label"><label><?php echo __('Order posts by:','wdps_back'); ?></label></td>
                    <td>
                      <input type="radio" id="order_by_posts1" name="order_by_posts" <?php echo (($row->order_by_posts) ? 'checked="checked"' : ''); ?> value="1" /><label <?php echo (($row->order_by_posts) ? 'class="selected_color"' : ''); ?> for="order_by_posts1"><?php echo __('Ascending','wdps_back'); ?></label>
                      <input type="radio" id="order_by_posts0" name="order_by_posts" <?php echo (($row->order_by_posts) ? '' : 'checked="checked"'); ?> value="0" /><label <?php echo (($row->order_by_posts) ? '' : 'class="selected_color"'); ?> for="order_by_posts0"><?php echo __('Descending','wdps_back'); ?></label>
                      <div class="spider_description"><?php echo __('Set the ordering sequence for the posts- ascending or descending.','wdps_back'); ?></div>
                    </td>
                  </tr>
             </table>
            </td>
          </tr>
          </tbody>
          </table>
          <table>
            <tbody>
             <tr>
                    <td class="spider_label_options" id="taxonomies_id1">
                      <label for="taxonomies"><?php echo __('Post taxonomies:','wdps_back'); ?></label>
                    </td>
                    <td id="taxonomies_id">
                    <?php
                    $termssss = array();
                    $termsss = json_decode($row->taxonomies);
                    if($termsss != "") {
                      foreach($termsss as $termss) {
                        array_push($termssss,$termss);
                      }
                    }
                    $i = 0;
                    foreach($taxonomies as $taxonomie) { 
                       if(get_terms($taxonomie, $argss)) {
                      ?>
                      <label><?php echo $taxonomie . ':'; ?> </label>
                      <select class="dynamic_select_icon select_icon_320 " name="taxonomies_<?php echo $taxonomie; ?>" id="taxonomies_<?php echo $taxonomie; ?>">
                      <option value="">
                        <?php echo  '<p>'. __('-all-','wdps_back') . '</p>'; ?>
                      </option>
                        <?php
                        
                        foreach ($terms as $term) {
                          if($taxonomie == $term->taxonomy  ) {
                             
                          ?>
                        <option  <?php echo (($termsss != "" && $termssss[$i] == $term->slug) ? 'selected="selected"' : ''); ?> value="<?php echo  $term->slug; ?>">
                          <?php echo  '<p>'. $term->name . '</p>'; ?>
                          <?php
                            
                          }
                          ?>
                        </option > 
                          <?php
                        }
                        ?>
                      </select>
                    <?php
                       }
                       $i++;
                    }
                     
                    ?>
                    </td>
                  </tr>
            </tbody>
          </table>
          <div class="wdps_clear"></div>
        </div>
        </td>
                  
                  <td colspan="4" style="display: block;">
                  <div class="bgcolor wdps_tabs  aui-sortable dynamic_slide">
                    <h2 class="titles"><?php echo __('Slide','wdps_back'); ?><h2>
                   <?php
                    foreach ($slides_row as $key => $slide_row) { 
                      if($slide_row->title == 'prototype' && $slide_row->post_id == 0) {
                      ?>
                      <script>
												/*jQuery(function(){
														jQuery(document).on("click","#wdps_tab_image<?php echo $slide_row->id; ?>",function(){
															wdps_change_sub_tab(this, 'wdps_slide<?php echo $slide_row->id; ?>');
														});
														jQuery(document).on("click","#wdps_tab_image<?php echo $slide_row->id; ?> input",function(e){
																e.stopPropagation();
														});
														jQuery(document).on("click","#title<?php echo $slide_row->id; ?>",function(){
																wdps_change_sub_tab(jQuery("#wdps_tab_image<?php echo $slide_row->id; ?>"), 'wdps_slide<?php echo $slide_row->id; ?>');
																wdps_change_sub_tab_title(this, 'wdps_slide<?php echo $slide_row->id; ?>');
														});
												});*/
                      
											</script>
                    <div id="wdps_subtab_wrap<?php echo $slide_row->id; ?>" class="wdps_subtab_wrap connectedSortable"> 
                      <div id="wbs_subtab<?php echo $slide_row->id; ?>" class="tab_link  <?php echo (((($id == 0 || !$sub_tab_type) || (strpos($sub_tab_type, 'pr') !== FALSE)) && $key == 0) || ('slide' . $slide_row->id == $sub_tab_type)) ? 'wdps_sub_active' : ''; ?>" href="#" >
                        <div style="background-image:url('<?php echo $slide_row->type != 'image' ? ($slide_row->type == 'video' && ctype_digit($slide_row->thumb_url) ? (wp_get_attachment_url(get_post_thumbnail_id($slide_row->thumb_url)) ? wp_get_attachment_url(get_post_thumbnail_id($slide_row->thumb_url)) : WD_PS_URL . '/images/no-video.png') : $slide_row->thumb_url) : $slide_row->thumb_url ?>');background-position: center" class="tab_image" id="wdps_tab_image<?php echo $slide_row->id; ?>" >
                          <div class="tab_buttons">
														<div class="handle_wrap">
															<div class="handle" title="<?php echo __('Drag to re-order','wdps_back'); ?>"></div>
														</div>
														<div class="wdps_tab_title_wrap">
															<input type="text" id="title<?php echo $slide_row->id; ?>" name="title<?php echo $slide_row->id; ?>" value="<?php echo $slide_row->title; ?>" class="wdps_tab_title" tab_type="slide<?php echo $slide_row->id; ?>" />
														</div>
                            <input type="hidden" name="order<?php echo $slide_row->id; ?>" id="order<?php echo $slide_row->id; ?>" value="<?php echo $slide_row->order; ?>" />
                          </div>
                        </div>
                      </div>
                    </div>
                      <?php
                    }  
                      }                    
                    ?>
                    <div class="wdps_clear"></div>
                  </div>
                  <?php
                  foreach ($slides_row as $key => $slide_row) {
                      if($slide_row->title == 'prototype' && $slide_row->post_id == 0) {
                        if(isset($slide_row->post_id) && $slide_row->post_id != 0) {                          
                          $post_feild_name = $this->model->get_post_data();
                          $custom_fields_names = get_post_custom_keys($slide_row->post_id);
                          for($k = 0; $k < count($custom_fields_names);++$k) {
                            array_push($post_feild_name,$custom_fields_names[$k]);
                          }
                        }
                        else {
                          $post_feild_name = $this->model->get_post_data();
                        }
                        
                          $post_feild_name = implode(",",$post_feild_name);
                      
                    ?>
                    <script>
												jQuery(function(){
															wdps_change_sub_tab(this, 'wdps_slide<?php echo $slide_row->id; ?>');
														jQuery(document).on("click","#wdps_tab_image<?php echo $slide_row->id; ?> input",function(e){
																e.stopPropagation();
														});
																wdps_change_sub_tab(jQuery("#wdps_tab_image<?php echo $slide_row->id; ?>"), 'wdps_slide<?php echo $slide_row->id; ?>');
																wdps_change_sub_tab_title(this, 'wdps_slide<?php echo $slide_row->id; ?>');
												});
                      
											</script>
                  <div class=" <?php echo (((($id == 0 || !$sub_tab_type) || (strpos($sub_tab_type, 'pr') !== FALSE)) && $key == 0) || ('slide' . $slide_row->id == $sub_tab_type)) ? 'wdps_sub_active' : ''; ?> wdps_slide<?php echo $slide_row->id; ?>">
                    <table class="ui-sortable<?php echo $slide_row->id; ?>">
                    <?php 
                     if($row->dynamic == 0) {
                       ?>
                      <thead><tr><td colspan="4">&nbsp;</td></tr></thead>
                      <?php
                     }
                      ?>
                      <tbody>
                        <input type="hidden" name="type<?php echo $slide_row->id; ?>" id="type<?php echo $slide_row->id; ?>" value="<?php echo $slide_row->type; ?>" />
                        <input type="hidden" name="wdps_video_type<?php echo $slide_row->id; ?>" id="wdps_video_type<?php echo $slide_row->id; ?>" />
                        <tr class="bgcolor">
                            <div id="slide_add_buttons">
                            <?php
                         
                            $query_url = wp_nonce_url(admin_url('admin-ajax.php'), '', 'wdps_nonce');
                            ?>
                            <script>
                              var ajax_url = "<?php echo $query_url; ?>";
                            </script>
                            <input type="hidden" id="image_url<?php echo $slide_row->id; ?>" name="image_url<?php echo $slide_row->id; ?>" value="<?php echo $slide_row->image_url; ?>" />
                            <input type="hidden" id="thumb_url<?php echo $slide_row->id; ?>" name="thumb_url<?php echo $slide_row->id; ?>" value="<?php echo $slide_row->thumb_url; ?>" />
                            <div class="clear"></div>
                            </div>
                          
                        </tr>
                        <tr class="bgcolor">
                           <td colspan="4">
                          <div class="wd_updated" style = "margin:7px;font-size:14px; padding:5px;line-height:1.5em;"><?php echo __('The post content will not be displayed on back end. You will see a sample background, where you can add standard and dynamic-post layers, which will be displayed over the posts on front end.','wdps_back'); ?></div>
                            <div id="wdps_preview_wrapper_<?php echo $slide_row->id; ?>" class="wdps_preview_wrapper" style="width: <?php echo $row->width; ?>px; height: <?php echo $row->height; ?>px;">
                              <div class="wdps_preview" style="overflow: hidden; position: absolute; width: inherit; height: inherit; background-color: transparent; background-image: none; display: block;">
                              
                                <div id="wdps_preview_image<?php echo $slide_row->id; ?>" class="wdps_preview_image<?php echo $slide_row->id; ?>"
                                     style='background-color: <?php echo WDW_PS_Library::spider_hex2rgba($row->background_color, (100 - $row->background_transparent) / 100); ?>;
                                           background-image: url("<?php echo $slide_row->type != 'image'  ? $slide_row->thumb_url : $slide_row->image_url . '?date=' . date('Y-m-d H:i:s'); ?>");
                                            background-position: center center;
                                            background-repeat: no-repeat;
                                            background-size: <?php echo $row->bg_fit; ?>;
                                            width: inherit;
                                            height: inherit;
                                            /*position: relative;*/'>
                                <?php
                                $layers_row = $this->model->get_layers_row_data($slide_row->id,$slide_row->post_id);
                                if ($layers_row) {
                                  foreach ($layers_row as $key => $layer) {
                                    //$post_feild_name = implode(",",$post_feild_name[$key]);
                                    $prefix = 'slide' . $slide_row->id . '_layer' . $layer->id;
                                    switch ($layer->type) {
                                      
                                      case 'text': {
                                        ?>
                                        <span id="<?php echo $prefix; ?>" class="wdps_draggable_<?php echo $slide_row->id; ?> wdps_draggable ui-draggable" onclick="wdps_showhide_layer('<?php echo $prefix; ?>_tbody', 1)"
                                              style="<?php echo $layer->image_width ? 'width: ' . $layer->image_width . '%; ' : ''; ?><?php echo $layer->image_height ? 'height: ' . $layer->image_height . '%; ' : ''; ?>word-break: <?php echo ($layer->image_scale ? 'normal' : 'break-all'); ?>; display: inline-block; position: absolute; left: <?php echo $layer->left; ?>px; top: <?php echo $layer->top; ?>px; z-index: <?php echo $layer->depth; ?>; color: #<?php echo $layer->color; ?>; font-size: <?php echo $layer->size; ?>px; line-height: 1.25em; font-family: <?php echo $layer->ffamily; ?>; font-weight: <?php echo $layer->fweight; ?>; padding: <?php echo $layer->padding; ?>; background-color: <?php echo WDW_PS_Library::spider_hex2rgba($layer->fbgcolor, (100 - $layer->transparent) / 100); ?>; border: <?php echo $layer->border_width; ?>px <?php echo $layer->border_style; ?> #<?php echo $layer->border_color; ?>; border-radius: <?php echo $layer->border_radius; ?>; box-shadow: <?php echo $layer->shadow; ?>"><?php echo str_replace(array("\r\n", "\r", "\n"), "<br>", $layer->text); ?></span>
                                        <?php
                                        break;
                                      }
                                      case 'image': {
                                        ?>
                                        <img id="<?php echo $prefix; ?>" class="wdps_draggable_<?php echo $slide_row->id; ?> wdps_draggable ui-draggable" onclick="wdps_showhide_layer('<?php echo $prefix; ?>_tbody', 1)" src="<?php echo $layer->image_url; ?>"
                                             style="opacity: <?php echo (100 - $layer->imgtransparent) / 100; ?>; filter: Alpha(opacity=<?php echo 100 - $layer->imgtransparent; ?>); position: absolute; left: <?php echo $layer->left; ?>px; top: <?php echo $layer->top; ?>px; z-index: <?php echo $layer->depth; ?>; border: <?php echo $layer->border_width; ?>px <?php echo $layer->border_style; ?> #<?php echo $layer->border_color; ?>; border-radius: <?php echo $layer->border_radius; ?>; box-shadow: <?php echo $layer->shadow; ?>; " />
                                        <?php
                                        break;
                                      }
                                      case 'video': {
                                        ?>
                                        <img id="<?php echo $prefix; ?>" class="wdps_draggable_<?php echo $slide_row->id; ?> wdps_draggable ui-draggable" onclick="wdps_showhide_layer('<?php echo $prefix; ?>_tbody', 1)" src="<?php echo $layer->image_url; ?>"
                                             style="max-width: <?php echo $layer->image_width; ?>px; width: <?php echo $layer->image_width; ?>px; max-height: <?php echo $layer->image_height; ?>px; height: <?php echo $layer->image_height; ?>px; position: absolute; left: <?php echo $layer->left; ?>px; top: <?php echo $layer->top; ?>px; z-index: <?php echo $layer->depth; ?>; border: <?php echo $layer->border_width; ?>px <?php echo $layer->border_style; ?> #<?php echo $layer->border_color; ?>; border-radius: <?php echo $layer->border_radius; ?>; box-shadow: <?php echo $layer->shadow; ?>;" />
                                        <?php
                                        break;
                                      }
                                      case 'social': {
                                        ?>
                                        <style>#<?php echo $prefix; ?>:hover {color: #<?php echo $layer->hover_color; ?> !important;}</style>
                                        <i id="<?php echo $prefix; ?>" class="wdps_draggable_<?php echo $slide_row->id; ?> wdps_draggable fa fa-<?php echo $layer->social_button; ?> ui-draggable" onclick="wdps_showhide_layer('<?php echo $prefix; ?>_tbody', 1)"
                                           style="opacity: <?php echo (100 - $layer->transparent) / 100; ?>; filter: Alpha(opacity=<?php echo 100 - $layer->transparent; ?>); position: absolute; left: <?php echo $layer->left; ?>px; top: <?php echo $layer->top; ?>px; z-index: <?php echo $layer->depth; ?>; color: #<?php echo $layer->color; ?>; font-size: <?php echo $layer->size; ?>px; line-height: <?php echo $layer->size; ?>px; padding: <?php echo $layer->padding; ?>; "></i>
                                        <?php
                                        break;
                                      }
                                      default:
                                        break;
                                    }
                                  }
                                }
                                ?>
                                </div>
                              </div>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>
                          <?php
                          if($slide_row->post_id) {
                            
                          ?>
                            <input type="hidden" id="wdps_post_id<?php echo $slide_row->id; ?>" name="wdps_post_id<?php echo $slide_row->id; ?>" value="<?php echo $slide_row->post_id; ?>"/>
                            <?php
                          }
                          ?>
                          </td>
                        </tr>
                        
                        <tr class="bgcolor">
                          <td colspan="4"> 
                          <h2 class="titles"><?php echo __('Layers','wdps_back'); ?></h2>
                         <div id="layer_add_buttons">
                          <div class="layer_add_buttons_wrap">
                            <input type="button"  class="action_buttons add_text_layer button-small" onclick="wdps_add_layer('text', '<?php echo $slide_row->id; ?>','','',1,0,'post','<?php echo $post_feild_name; ?>'); return false;" value="<?php echo __('Add Text Layer','wdps_back'); ?>" />
                          </div>
                          <div class="layer_add_buttons_wrap">
                             <button  class="action_buttons add_image_layer <?php echo !$fv ? "" : " wdps_free_button"; ?>  button-small" onclick="<?php echo !$fv ? "wdps_add_layer('image', '" . $slide_row->id . "', '', event)" : "alert('This functionality is disabled in free version.')"; ?>; return false;"  >Add Image Layer</button>
                          </div>
                          <div class="layer_add_buttons_wrap">
                            <button class="action_buttons add_social_layer button-small wdps_free_button" onclick="alert('This functionality is disabled in free version.'); return false;" > Social Button Layer</button>
                          </div>
                          <div class="layer_add_buttons_wrap">
                            <button class="action_buttons add_hotspot_layer button-small wdps_free_button" onclick="alert('This functionality is disabled in free version.'); return false;" >Add Hotspot Layer</button>
                          </div>
                          <div class="clear"></div>
                         </div>
                         </td>
                        </tr>
                      </tbody>
                      <?php
                      $layer_ids_string = '';
                     
                      if ($layers_row) {
                        foreach ($layers_row as $key => $layer) {
                          $prefix = 'slide' . $slide_row->id . '_layer' . $layer->id;
                       
                          ?>
                          <tbody class="layer_table_count" id="<?php echo $prefix; ?>_tbody">
                            <tr class="wdps_layer_head_tr">
                              <td class="wdps_layer_head" colspan="4">
                              <div class="wdps_layer_left">
                                <div class="layer_handle handle connectedSortable" title="<?php echo __('Drag to re-order','wdps_back'); ?>"></div>
                                <span class="wdps_layer_label" onclick="wdps_showhide_layer('<?php echo $prefix; ?>_tbody', 0)"><input id="<?php echo $prefix; ?>_title" name="<?php echo $prefix; ?>_title" type="text" class="wdps_layer_title" style="width: 80px; color:#00A2D0;padding:5px;" value="<?php echo $layer->title; ?>" title="<?php echo __('Layer title','wdps_back'); ?>" /></span>
                              </div>
                              <div class="wdps_layer_right">
                                <span class="wdps_layer_remove" onclick="wdps_delete_layer('<?php echo $slide_row->id; ?>', '<?php echo $layer->id; ?>')" title="<?php __('Delete layer','wdps_back'); ?>"></span>
                                <span class="wdps_layer_dublicate" onclick="wdps_add_layer('<?php echo $layer->type; ?>', '<?php echo $slide_row->id; ?>', '', '', 1,0,'post','<?php echo $post_feild_name; ?>'); wdps_duplicate_layer('<?php echo $layer->type; ?>', '<?php echo $slide_row->id; ?>', '<?php echo $layer->id; ?>');" title="<?php echo __('Duplicate layer','wdps_back'); ?>"></span>
                                <input id="<?php echo $prefix; ?>_depth" class="wdps_layer_depth spider_int_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({zIndex: jQuery(this).val()})" onkeypress="return spider_check_isnum(event)" value="<?php echo $layer->depth; ?>" prefix="<?php echo $prefix; ?>" name="<?php echo $prefix; ?>_depth" title="z-index" />
                              </div>  
                                <div class="wdps_clear"></div>
                              </td>
                            </tr>
                            <?php
                          
                           
                            switch ($layer->type) {
                              /*--------text layer----------*/
                              case 'text': {
                                ?>
                            <tr class="wdps_layer_tr" style="display:none;">
                              <td colspan=2>
                                  <table class="layer_table_left">
                              <tr>
                              <td  class="spider_label">
                                <label for="<?php echo $prefix; ?>_text"><?php echo __('Text:','wdps_back'); ?> </label>
                              </td>
                              <td>
                                <textarea id="<?php echo $prefix; ?>_text" class='wdps_textarea' name="<?php echo $prefix; ?>_text" style="width: 555px; height: 100px; resize: vertical;" onkeyup="wdps_new_line('<?php echo $prefix; ?>');"><?php echo $layer->text; ?></textarea>
                                <div class="spider_description" ></div>
                                <?php
                                $post_id = $slide_row->post_id;
                                if(isset($slide_row->post_id) && $slide_row->post_id !=0 ) {
                                $custom_fields_name = get_post_custom_keys($post_id);
                                $post_feild_name = $this->model->get_post_data();
                                  for($k = 0; $k < count($custom_fields_name);++$k) {
                                    array_push($post_feild_name,$custom_fields_name[$k]);
                                  }
                                }
                                else {
                                   $post_feild_name = $this->model->get_post_data();
                                }
                                  for($i = 0; $i < count($post_feild_name); ++$i) {
                                      ?>
                                      <input type='button' class="button-primary" id ="wdps_post<?php echo $slide_row->id; ?>" style="line-height:4px;display:table;float:left;margin:3px;" value="<?php echo $post_feild_name[$i]; ?>" onclick="wdps_add_post_feilds('<?php echo $prefix; ?>','<?php echo  $post_feild_name[$i]; ?>');"/>
                                      <?php
                                  }
                                  $post_feild_name = implode(",",$post_feild_name);
                                ?>
                              </td>	
                              </tr>
                            <tr>
                              <td title="<?php echo __('Leave blank to keep the initial width and height.');?>" class="wdps_tooltip spider_label">
                                <label for="<?php echo $prefix; ?>_image_width"><?php echo __('Dimensions:','wdps_back'); ?> </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_image_width" class="spider_int_input" type="text" onchange="wdps_text_width(this, '<?php echo $prefix; ?>')" value="<?php echo $layer->image_width; ?>" name="<?php echo $prefix; ?>_image_width" /> x 
                                <input id="<?php echo $prefix; ?>_image_height" class="spider_int_input" type="text" onchange="wdps_text_height(this, '<?php echo $prefix; ?>')" value="<?php echo $layer->image_height; ?>" name="<?php echo $prefix; ?>_image_height" /> % 
                                <input id="<?php echo $prefix; ?>_image_scale" type="checkbox" onchange="wdps_break_word(this, '<?php echo $prefix; ?>')" name="<?php echo $prefix; ?>_image_scale" <?php echo (($layer->image_scale) ? 'checked="checked"' : ''); ?> /><label for="<?php echo $prefix; ?>_image_scale"><?php echo __('Break-word','wdps_back'); ?></label>
                              </td>
                            </tr>
                          <tr>
                              <td title="<?php echo __('In addition you can drag and drop the layer to a desired position.','wdps_back'); ?>" class="wdps_tooltip spider_label">
                                <label><?php echo __('Position:','wdps_back'); ?> </label>
                              </td>
                              <td>
                                X <input id="<?php echo $prefix; ?>_left" class="spider_int_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({left: jQuery(this).val() + 'px'})" onkeypress="return spider_check_isnum(event)" value="<?php echo $layer->left; ?>" name="<?php echo $prefix; ?>_left" />
                                Y <input id="<?php echo $prefix; ?>_top" class="spider_int_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({top: jQuery(this).val() + 'px'})" onkeypress="return spider_check_isnum(event)" value="<?php echo $layer->top; ?>" name="<?php echo $prefix; ?>_top" />
                              </td> 
                            </tr>		
                                    <tr>
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_size"><?php echo __('Size:','wdps_back'); ?> </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_size" class="spider_int_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({fontSize: jQuery(this).val() + 'px', lineHeight: jQuery(this).val() + 'px'})" onkeypress="return spider_check_isnum(event)" value="<?php echo $layer->size; ?>" name="<?php echo $prefix; ?>_size" /> px
                                <div class="spider_description"></div>
                              </td>
                            </tr>
                          <tr>
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_color"><?php echo __('Color:','wdps_back'); ?> </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_color" class="color" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({color: '#' + jQuery(this).val()})" value="<?php echo $layer->color; ?>" name="<?php echo $prefix; ?>_color" />
                                <div class="spider_description"></div>
                              </td>
                            </tr>
                           <tr>
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_ffamily"><?php echo __('Font family:','wdps_back'); ?> </label>
                              </td>
                              <td>
                                <select class="select_icon select_icon_320" style="width: 200px;" id="<?php echo $prefix; ?>_ffamily" onchange="wdps_change_fonts('<?php echo $prefix; ?>', 1)" name="<?php echo $prefix; ?>_ffamily">
                                  <?php
                                  $fonts = (isset($layer->google_fonts) && $layer->google_fonts) ? $google_fonts : $font_families;
                                  foreach ($fonts as $key => $font_family) {
                                    ?>
                                    <option value="<?php echo $key; ?>" <?php echo (($layer->ffamily == $key) ? 'selected="selected"' : ''); ?>><?php echo $font_family; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                                <input id="<?php echo $prefix; ?>_google_fonts1" type="radio" name="<?php echo $prefix;  ?>_google_fonts" value="1" <?php echo (($layer->google_fonts) ? 'checked="checked"' : ''); ?> onchange="wdps_change_fonts('<?php echo $prefix; ?>')" />
                                <label for="<?php echo $prefix; ?>_google_fonts1"><?php echo __('Google fonts','wdps_back'); ?></label>
                                <input id="<?php echo $prefix; ?>_google_fonts0" type="radio" name="<?php echo $prefix;?>_google_fonts" value="0" <?php echo (($layer->google_fonts) ? '' : 'checked="checked"'); ?> onchange="wdps_change_fonts('<?php echo $prefix; ?>')" />
                                <label for="<?php echo $prefix; ?>_google_fonts0"><?php echo __('Default','wdps_back'); ?></label>
                                <div class="spider_description"></div>
                              </td>
                            </tr>
                            <tr>
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_fweight"><?php echo __('Font weight:','wdps_back'); ?> </label>
                              </td>
                              <td>
                                  <select class="select_icon select_icon_320" style="width:70px" id="<?php echo $prefix; ?>_fweight" onchange="jQuery('#<?php echo $prefix; ?>').css({fontWeight: jQuery(this).val()})" name="<?php echo $prefix; ?>_fweight">
                                  <?php
                                  foreach ($font_weights as $key => $fweight) {
                                    ?>
                                    <option value="<?php echo $key; ?>" <?php echo (($layer->fweight == $key) ? 'selected="selected"' : ''); ?>><?php echo $fweight; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                                <div class="spider_description"></div>
                              </td>
                            </tr>
                            <tr>
                           
                              <td class="spider_label">
                                <label><?php echo __('Published:','wdps_back'); ?> </label>
                              </td>
                               <td colspan=3>
                                <input id="<?php echo $prefix; ?>_published1" type="radio" name="<?php echo $prefix; ?>_published" value="1" <?php echo (($layer->published) ? 'checked="checked"' : ''); ?> />
                                <label <?php echo (($layer->published) ? 'class="selected_color"' : ''); ?> for="<?php echo $prefix; ?>_published1"><?php echo __('Yes','wdps_back'); ?></label>
                                <input id="<?php echo $prefix; ?>_published0" type="radio" name="<?php echo $prefix; ?>_published" value="0" <?php echo (($layer->published) ? '' : 'checked="checked"'); ?> />
                                <label <?php echo (($layer->published) ?  '' : 'class="selected_color"'); ?> for="<?php echo $prefix; ?>_published0"><?php echo __('No','wdps_back'); ?></label>
                                <div class="spider_description"></div>
                              </td>
                            </tr>
                            </table>
                            <table class="layer_table_right" >
                            <tr>
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_layer_effect_in"><?php echo __('Effect In:','wdps_back'); ?></label>
                              </td>
                              <td>
                                <span style="display: table-cell;">
                                  <input id="<?php echo $prefix; ?>_start" class="spider_int_input" type="text" value="<?php echo $layer->start; ?>" name="<?php echo $prefix; ?>_start" /> ms 
                                  <div class="spider_description"><?php echo __('Start','wdps_back'); ?></div>
                                </span>
                                <span style="display: table-cell;">
                                  <select class="select_icon select_icon_320" name="<?php echo $prefix; ?>_layer_effect_in" id="<?php echo $prefix; ?>_layer_effect_in" style="width:150px;" onchange="wdps_trans_effect_in('<?php echo $slide_row->id; ?>', '<?php echo $prefix; ?>', 0); wdps_trans_end('<?php echo $prefix; ?>', jQuery(this).val());">
                                  <?php
                                  foreach ($layer_effects_in as $key => $layer_effect_in) {
                                    ?>
                                     <option value="<?php echo $key; ?>" <?php echo (!in_array($key, $free_layer_effects)) ? 'disabled="disabled" title="This effect is disabled in free version."' : ''; ?> <?php if ($layer->layer_effect_in == $key) echo 'selected="selected"'; ?>><?php echo $layer_effect_in; ?></option>
                                    <?php
                                  }
                                  ?>
                                  </select>
                                  <div class="spider_description"><?php echo __('Effect','wdps_back'); ?></div>
                                </span>
                                <span style="display: table-cell;">
                                  <input id="<?php echo $prefix; ?>_duration_eff_in" class="spider_int_input" type="text" onkeypress="return spider_check_isnum(event)" onchange="wdps_trans_effect_in('<?php echo $slide_row->id; ?>', '<?php echo $prefix; ?>', 0); wdps_trans_end('<?php echo $prefix; ?>', jQuery('#<?php echo $prefix; ?>_layer_effect_in').val());" value="<?php echo $layer->duration_eff_in; ?>" name="<?php echo $prefix; ?>_duration_eff_in" /> ms
                                  <div class="spider_description"><?php echo __('Duration','wdps_back'); ?></div>
                                </span>
                                <div class="wd_error" style="padding: 5px; font-size: 14px; color: #000000 !important;">Some effects are disabled in free version.</div>
                              </td>
                            </tr>
                             <tr>
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_layer_effect_out"><?php echo __('Effect Out:','wdps_back'); ?></label>
                              </td>
                              <td>
                                <span style="display: table-cell;">
                                  <input id="<?php echo $prefix; ?>_end" class="spider_int_input" type="text" value="<?php echo $layer->end; ?>" name="<?php echo $prefix; ?>_end"> ms
                                  <div class="spider_description"><?php echo __('Start','wdps_back');?></div>
                                </span> 
                                <span style="display: table-cell;">
                                  <select class="select_icon select_icon_320" name="<?php echo $prefix; ?>_layer_effect_out" id="<?php echo $prefix; ?>_layer_effect_out" style="width:150px;" onchange="wdps_trans_effect_out('<?php echo $slide_row->id; ?>', '<?php echo $prefix; ?>', 0); wdps_trans_end('<?php echo $prefix; ?>', jQuery(this).val());">
                                  <div class="wd_error" style="padding: 5px; font-size: 14px; color: #000000 !important;">Some effects are disabled in free version.</div>
                                  <?php
                                  foreach ($layer_effects_out as $key => $layer_effect_out) {
                                    ?>
                                   <option value="<?php echo $key; ?>" <?php echo (!in_array($key, $free_layer_effects)) ? 'disabled="disabled" title="This effect is disabled in free version."' : ''; ?> <?php if ($layer->layer_effect_out == $key) echo 'selected="selected"'; ?>><?php echo $layer_effect_out; ?></option>
                                    <?php
                                  }
                                  ?>
                                  </select>
                                  <div class="spider_description"><?php echo __('Effect','wdps_back'); ?></div>
                                </span> 
                                
                                <span style="display: table-cell;">
                                  <input id="<?php echo $prefix; ?>_duration_eff_out" class="spider_int_input" type="text" onkeypress="return spider_check_isnum(event)" onchange="wdps_trans_effect_out('<?php echo $slide_row->id; ?>', '<?php echo $prefix; ?>', 0); wdps_trans_end('<?php echo $prefix; ?>', jQuery('#<?php echo $prefix; ?>_layer_effect_out').val());" value="<?php echo $layer->duration_eff_out; ?>" name="<?php echo $prefix; ?>_duration_eff_out"> ms
                                  <div class="spider_description"><?php echo __('Duration','wdps_back'); ?></div>
                                </span>
                                <div class="wd_error" style="padding: 5px; font-size: 14px; color: #000000 !important;">Some effects are disabled in free version.</div>
                              </td>
                            </tr>
                            <tr>
                              <td title="<?php echo __('Use CSS type values.','wdps_back'); ?>" class="wdps_tooltip spider_label">
                                <label for="<?php echo $prefix; ?>_padding"><?php echo __('Padding:','wdps_back'); ?> </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_padding" class="spider_char_input" type="text" onchange="document.getElementById('<?php echo $prefix; ?>').style.padding=jQuery(this).val();" value="<?php echo $layer->padding; ?>" name="<?php echo $prefix; ?>_padding">
                                <div class="spider_description"><?php echo __('Use CSS type values.','wdps_back'); ?></div>
                              </td>                              
                            </tr>		
                            <tr> 
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_fbgcolor"><?php echo __('Background Color:','wdps_back'); ?> </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_fbgcolor" class="color" type="text" onchange="wde_change_text_bg_color('<?php echo $prefix; ?>')" value="<?php echo $layer->fbgcolor; ?>" name="<?php echo $prefix; ?>_fbgcolor" />
                                <div class="spider_description"></div>
                              </td>
                            </tr>
                            <tr>
                              <td title="<?php echo __('Value must be between 0 to 100.','wdps_back'); ?>" class="wdps_tooltip spider_label">
                                <label for="<?php echo $prefix; ?>_transparent"><?php echo __('Transparent:','wdps_back'); ?> </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_transparent" class="spider_int_input" type="text" onchange="wde_change_text_bg_color('<?php echo $prefix; ?>')" onkeypress="return spider_check_isnum(event)" value="<?php echo $layer->transparent; ?>" name="<?php echo $prefix; ?>_transparent"> %
                                <div class="spider_description"><?php echo __('Value must be between 0 to 100.','wdps_back'); ?></div>
                              </td>
                            </tr>
                            <tr>
                              <td class="spider_label">
                                <label for="<?php echo $prefix; ?>_border_width"><?php echo __('Border:','wdps_back'); ?> </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_border_width" class="spider_int_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({borderWidth: jQuery(this).val()})" onkeypress="return spider_check_isnum(event)" value="<?php echo $layer->border_width; ?>" name="<?php echo $prefix; ?>_border_width"> px
                                <select class="select_icon select_icon_320" id="<?php echo $prefix; ?>_border_style" onchange="jQuery('#<?php echo $prefix; ?>').css({borderStyle: jQuery(this).val()})" style="width: 80px;" name="<?php echo $prefix; ?>_border_style">
                                  <?php
                                  foreach ($border_styles as $key => $border_style) {
                                    ?>
                                    <option value="<?php echo $key; ?>" <?php echo (($layer->border_style == $key) ? 'selected="selected"' : ''); ?>><?php echo $border_style; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                                <input id="<?php echo $prefix; ?>_border_color" class="color" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({borderColor: '#' + jQuery(this).val()})" value="<?php echo $layer->border_color; ?>" name="<?php echo $prefix; ?>_border_color" />
                                <div class="spider_description"></div>
                              </td>
                            </tr>
                           <tr>
                              <td title="<?php echo __('Use CSS type values.','wdps_back'); ?>" class="wdps_tooltip spider_label">
                                <label for="<?php echo $prefix; ?>_border_radius"><?php echo __('Radius:','wdps_back'); ?> </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_border_radius" class="spider_char_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({borderRadius: jQuery(this).val()})" value="<?php echo $layer->border_radius; ?>" name="<?php echo $prefix; ?>_border_radius">
                                <div class="spider_description"><?php echo __('Use CSS type values.','wdps_back'); ?></div>
                              </td>
                            </tr>
                            <tr>
                              <td title="<?php echo __('Use CSS type values (e.g. 10px 10px 5px #888888).','wdps_back'); ?>" >
                                <label for="<?php echo $prefix; ?>_shadow"><?php echo __('Shadow:','wdps_back'); ?> </label>
                              </td>
                              <td>
                                <input id="<?php echo $prefix; ?>_shadow" class="spider_char_input" type="text" onchange="jQuery('#<?php echo $prefix; ?>').css({boxShadow: jQuery(this).val()})" value="<?php echo $layer->shadow; ?>" name="<?php echo $prefix; ?>_shadow" />
                                <div class="spider_description"><?php echo __('Use CSS type values (e.g. 10px 10px 5px #888888).','wdps_back'); ?></div>
                              </td>
                            </tr>
                            
                              </table>
                               </td>
                            </tr>
                                <?php
                           // }
                                break;
                              }
                              default:
                                break;
                            }
                            ?>
                            <input type="hidden" name="<?php echo $prefix; ?>_type" id="<?php echo $prefix; ?>_type" value="<?php echo $layer->type; ?>" />
                          </tbody>
                          <?php
                          $layer_ids_string .= $layer->id . ',';
                        }
                      }
                      ?>
                    </table>
                    <input id="slide<?php echo $slide_row->id; ?>_layer_ids_string" name="slide<?php echo $slide_row->id; ?>_layer_ids_string" type="hidden" value="<?php echo $layer_ids_string; ?>" />
                    <input id="slide<?php echo $slide_row->id; ?>_del_layer_ids_string" name="slide<?php echo $slide_row->id; ?>_del_layer_ids_string" type="hidden" value="" />
                  </div>
                    <script>
                      jQuery(document).ready(function() {
                        image_for_next_prev_butt('<?php echo $row->rl_butt_img_or_not; ?>');
                        image_for_bull_butt('<?php echo $row->bull_butt_img_or_not; ?>');						
                        image_for_play_pause_butt('<?php echo $row->play_paus_butt_img_or_not; ?>');
                       /* showhide_for_dynamic_fildes('<?php echo $row->dynamic; ?>');*/
                        showhide_for_carousel_fildes('<?php echo $row->carousel; ?>');
                        wdps_whr('width');
                        wdps_drag_layer('<?php echo $slide_row->id; ?>');
                        wdps_layer_weights('<?php echo $slide_row->id; ?>');
                        <?php
                        
                        if ($layers_row) {
                          foreach ($layers_row as $key => $layer) {
                            if ($layer->type == 'image') {
                              $prefix = 'slide' . $slide_row->id . '_layer' . $layer->id;
                              ?>
                          wdps_scale('#<?php echo $prefix; ?>_image_scale', '<?php echo $prefix; ?>');
                              <?php
                            }
                          }
                        }
                        ?>
                      });
                    </script>
                    <?php
                    $slide_ids_string .= $slide_row->id . ',' ;
                    }
                  }
                  ?>
                </td>
              </tr>
            </tbody>
          </table>
          </div>
        </div>
      </div>
      <div class="wdps_task_cont">
        <input id="current_id" name="current_id" type="hidden" value="<?php echo $row->id; ?>" />
        <input id="slide_ids_string" name="slide_ids_string" type="hidden" value="<?php echo $slide_ids_string; ?>" />
        <input id="del_slide_ids_string" name="del_slide_ids_string" type="hidden" value="" />
        <input id="nav_tab" name="nav_tab" type="hidden" value="<?php echo WDW_PS_Library::get('nav_tab', 'global'); ?>" />
        <input id="tab" name="tab" type="hidden" value="<?php echo WDW_PS_Library::get('tab', 'slides'); ?>" />
        
        <input id="sub_tab" name="sub_tab" type="hidden" value="<?php echo $sub_tab_type; ?>" />
        
      </div>
      <input id="task" name="task" type="hidden" value="" />
      <script>
      
        var uploader_href = '<?php echo add_query_arg(array('action' => 'postaddImage', 'width' => '700', 'height' => '550', 'extensions' => 'jpg,jpeg,png,gif', 'callback' => 'wdps_add_image', 'image_for' => 'add_update_slide', 'slide_id' => 'slideID', 'layer_id' => 'layerID', 'TB_iframe' => '1'), admin_url('admin-ajax.php')); ?>';		
        var wdps_add_post_href = '<?php echo add_query_arg(array('action' => 'WDPSPosts', 'count' => 1, 'width' => '700', 'height' => '550', 'TB_iframe' => '1'), admin_url('admin-ajax.php')); ?>';
        /* var wdps_change_post =  '<?php echo $row->dynamic ? 'dynamic_slides' : 'static_slides'; ?>'; */       
        jQuery(document).ready(function() {
          wdps_onload();
        });
        jQuery("#sliders_form").on("click", "a", function(e) {
          e.preventDefault();
        });
       jQuery(".wdps_tab_title").keyup(function (e) {
          var code = e.which;
          if (code == 13) {
            jQuery(".wdps_sub_active .wdps_tab_title").blur();
            jQuery(".wdps_tab_title_wrap").removeClass("wdps_sub_active");
          }
        });
         var plugin_dir = '<?php echo WD_PS_URL . "/images/sliderwdpng/"; ?>';
      </script>
      
      <div class="opacity_add_image_url opacity_add_video wdps_opacity_video wdps_opacity_export"
           onclick="jQuery('.opacity_add_video').hide();
                    jQuery('.opacity_add_image_url').hide();
                    jQuery('.wdps_exports').hide();">
      </div>
      <div class="opacity_add_image_url wdps_resize_image">
        <input type="text" id="image_url_input" name="image_url_input" value="" />
        <input type="button" id="add_image_url_button" class="button-primary" value="Add" />
        <input type="button" class="button-secondary" onclick="jQuery('.opacity_add_image_url').hide(); return false;" value="Cancel" />
        <div class="spider_description"><?php echo __('Enter absolute url of the image.','wdps_back'); ?></div>
      </div>
      
    </form>
    <?php
  }

  ////////////////////////////////////////////////////////////////////////////////////////
  // Getters & Setters                                                                  //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Private Methods                                                                    //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}