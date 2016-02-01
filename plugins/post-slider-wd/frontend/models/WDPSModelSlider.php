<?php

class WDPSModelSlider {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function __construct() {
  }
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////

  public function get_post_slide_rows_data($id) {
    global $wpdb;
     $dynamic = $wpdb->get_var($wpdb->prepare('SELECT dynamic FROM ' . $wpdb->prefix . 'wdpsslider WHERE id="%d"', $id));
     $layer_word_count = $wpdb->get_var($wpdb->prepare('SELECT layer_word_count FROM ' . $wpdb->prefix . 'wdpsslider WHERE id="%d"', $id));
      $post_fildes_name = array(
        '0' => 'ID',
        '1' => 'post_author',
        '2' => 'post_date',
        '3' => 'post_content',
        '4' => 'post_title',
        '5' => 'post_excerpt',
        '6' => 'post_status',
        '7' => 'post_name',
        '8' => 'to_ping',
        '9' => 'post_modified',
        '10' => 'post_type',
        '11' => 'comment_count',
        '12' => 'filter',
      );
    if($dynamic == 0 ){
      $slide_rows = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'wdpsslide WHERE  published=1 AND title<>"prototype" AND slider_id="%d" AND image_url<>"" ORDER BY `order` asc', $id));
      $row = array();
       $users = get_users();
     foreach($slide_rows as $key => $slide_row ) {
       $post_fildes_name_current =  $post_fildes_name;
       $custom_fields_name = get_post_custom_keys($slide_row->post_id);
         for($k = 0; $k < count($custom_fields_name);++$k) {
           array_push($post_fildes_name_current,$custom_fields_name[$k]);
         }
         $layers_row = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "wdpslayer WHERE slide_id='%d' ORDER BY `depth` ASC", $slide_row->id));
       $slide_row->layer = array(); 
       foreach($layers_row as $layer) {
         $string = $layer->text;
         foreach($post_fildes_name_current as $post_filde_name_curr) {
            if($post_filde_name_curr == 'post_author') {
              foreach($users as $user) {
                if(get_post_field('post_author',$slide_row->post_id) == $user ->ID ){
                  $user_name = $user->display_name;
                }
              }
              $string = str_replace('{' . $post_filde_name_curr . '}', $user_name,$string);
              
            }
            else {
              if(is_array(get_post_field($post_filde_name_curr,$slide_row->post_id))== true) {
                $string = str_replace('{' . $post_filde_name_curr . '}', implode(',',get_post_field($post_filde_name_curr,$slide_row->post_id)), $string);
              }
              else {
                $string = str_replace('{' . $post_filde_name_curr . '}',$this->add_more_link(strip_tags(get_post_field($post_filde_name_curr,$slide_row->post_id)),$layer_word_count),$string);
              }
            }
        }
       $original_value = $layer->text;
       $layer->text = $string;
       $slide_row->layer[] = clone $layer;
       $layer->text = $original_value;
       }
         array_push($row,$slide_row);
     }
     
    }
    else {
      $slide_rows = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'wdpsslide WHERE  title = "prototype" AND slider_id="%d" AND image_url<>"" ORDER BY `order` asc', $id));
      
      if ($slide_rows && count($slide_rows)) {
        $slide_id = $slide_rows[0]->id; 
      }
      
       $layers_row = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "wdpslayer WHERE slide_id='%d' ORDER BY `depth` ASC", $slide_id));
       $author_name = $wpdb->get_var($wpdb->prepare('SELECT author_name FROM ' . $wpdb->prefix . 'wdpsslider WHERE id="%d"', $id));
       $asc_or_desc = $wpdb->get_var($wpdb->prepare('SELECT order_by_posts FROM ' . $wpdb->prefix . 'wdpsslider WHERE id="%d"', $id));
       $asc_or_desc = ($asc_or_desc == 1)? 'asc' : 'desc';
       $order_by = $wpdb->get_var($wpdb->prepare('SELECT post_sort FROM ' . $wpdb->prefix . 'wdpsslider WHERE id="%d"', $id));
       $post_type = $wpdb->get_var($wpdb->prepare('SELECT choose_post FROM ' . $wpdb->prefix . 'wdpsslider WHERE id="%d"', $id));
       $posts_count = $wpdb->get_var($wpdb->prepare('SELECT posts_count FROM ' . $wpdb->prefix . 'wdpsslider WHERE id="%d"', $id));
       $cache_expiration = $wpdb->get_var($wpdb->prepare('SELECT cache_expiration FROM ' . $wpdb->prefix . 'wdpsslider WHERE id="%d"', $id));    
        $taxonom = $wpdb->get_var($wpdb->prepare('SELECT taxonomies FROM ' . $wpdb->prefix . 'wdpsslider WHERE id="%d"', $id));
       
        $cache_expiration_array = preg_split("/[\s,]+/", $cache_expiration);
        $cache_expiration_count = $cache_expiration_array[0];
        $cache_expiration_name = $cache_expiration_array[1];
        if($order_by =="author") {
          $order_by ='author';
        }
        else if($order_by == 'publishing date') {
          $order_by = 'post_data';
        }
        else if($order_by == 'modification date') {
          $order_by = 'post_modified';
        }
        else if($order_by == 'number of comments') {
          $order_by = 'comment_count';
        }
        else if($order_by == 'post title') {
          $order_by = 'post_title';
        }
        else if($order_by == 'menu order') {
          $order_by = 'menu_order';
        }
        else {
          $order_by ='rand';
        }
        $users = get_users();
        foreach($users as $user){
          if($user->display_name == $author_name) {
            $author_id = $user->ID; 
          }
        }
        if($author_name == ''){
          $author_id = ''; 
        }
       if($cache_expiration_name == 'hour') {
          $newdata_time = time() - ($cache_expiration_count * 60 * 60 );
        }
        else if($cache_expiration_name == 'day'){
          $newdata_day = time() - (1 * 60 * 60 );
          $newdate = new DateTime(date('Y-m-d', $newdata_day));
          $newdate->modify('-'.$cache_expiration_count.' day');
          $newdate->format('Y-m-d');
        }
        else if($cache_expiration_name == 'week') { 
          $newdata_day = time() - (1 * 60 * 60 );
          $newdate = new DateTime(date('Y-m-d', $newdata_day));
          $newdate->modify('-'.$cache_expiration_count.' week');
          $newdate->format('Y-m-d');
        }
        else if ($cache_expiration_name == 'month') {
          $newdata_day = time() - (1 * 60 * 60 );
          $newdate = new DateTime(date('Y-m-d', $newdata_day));
          $newdate->modify('-'.$cache_expiration_count.' month');
          $newdate->format('Y-m-d');
        }
        
        $argss = array(
         'posts_per_page' => 255,
         'orderby' => $order_by,
         'order' => $asc_or_desc,
         'post_type' => $post_type,
         'author' => $author_id,
         'post_status' => 'publish',
          
        );
       
        $args=array(
          'object_type' => array($post_type) 
        );
        $output = 'names'; // or objects
        $operator = 'and'; // 'and' or 'or'
        $taxonomies = get_taxonomies($args,$output,$operator);
        $tax_query = array();
        $term = json_decode($taxonom);
        $post_term =array();   
        foreach($term as $terms) {
          $post_term[] = $terms;
        }     
          $i = 0;
        foreach($taxonomies as $taxonomie) {
          if($post_term[$i] !='') {
            $tax_query[] = array(
              'taxonomy' => $taxonomie,
              'field' => 'slug',
              'terms' =>  $post_term[$i]
            );
          
         }
         $i++;
     }  
         
    $argss['tax_query'] = $tax_query;
    $posts = get_posts($argss);
        
    $row = array();$q = 0;
    foreach($posts as $key => $post){
      if(has_post_thumbnail($post->ID) && !post_password_required($post->ID)) {
        $post_id = $post->ID;
       $posts_data = get_post_field('post_date',$post_id);
       $post->layer = array();
       foreach ($layers_row as $key => $layer) {
         $string = $layer->text;
         foreach($post_fildes_name as $post_filde_name) {
            if($post_filde_name == 'post_author') {
              $string = str_replace('{' . $post_filde_name . '}', get_the_author_meta('display_name', $post->post_author),$string);
            }
            else {
              $string = str_replace('{' . $post_filde_name . '}',$this->add_more_link(strip_tags(get_post_field($post_filde_name,$post_id)),$layer_word_count),$string);
            }
        }
        
       $original_value = $layer->text;
       $layer->text = $string;
       $post->layer[] = clone $layer;
       $layer->text = $original_value; 
       }
        
      if( $cache_expiration_count == 0 || $cache_expiration_name == '' ) {
          array_push($row,$post);
          if($posts_count != 0) {
            $q++;
          }
      }
      else {      
        if($cache_expiration_name != 'hour' && $newdate->format('Y-m-d') <= $posts_data) {
          array_push($row,$post);
          if($posts_count != 0) {
            $q++;
          }
        }
        else if ($cache_expiration_name == 'hour' && date('Y-m-d H:i:s',$newdata_time) <= $posts_data ) {
          array_push($row,$post);
           if($posts_count != 0) {
            $q++;
          }
        }
      } 
          
    }
    
   if($posts_count != 0 && $q >= $posts_count) {
     break;
   }
    }
    }
      return $row;
     
    
  }
  
  public function get_post_slider_row_data($id) {
    global $wpdb;
    $row = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'wdpsslider WHERE id="%d"', $id));
    return $row;
  }
   public function add_more_link($content,$charlength) {
    if (mb_strlen($content) > $charlength) {
      $a = $charlength;
      $charlength = mb_strpos($content, ' ', $charlength);
      if($charlength == false) {
        $charlength = $a;
      }
      $subex = mb_substr($content, 0, $charlength);
      return $subex . '<a target=\'_blank\' class=\'wdps_more\'> ...</a>';
    }
    else {
      return $content;
     
    }
  }
  /*public function get_layers_row_data($slide_id) {
    global $wpdb;
    
    $rows = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "wdpslayer WHERE slide_id='%d' ORDER BY `depth` ASC", $slide_id));
    return $rows;
  }*/
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