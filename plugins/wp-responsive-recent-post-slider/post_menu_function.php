<?php

add_action('admin_menu', 'register_wprps_postdesign_submenu_page');

function register_wprps_postdesign_submenu_page() {
	add_submenu_page( 'edit.php', 'Pro Post Slider Designs', 'Pro Post Slider Designs', 'manage_options', 'wprps_postdesign-submenu-page', 'wprps_postdesign_page_callback' );
}

function wprps_postdesign_page_callback() {
	
	
	$result ='<div class="wrap"><div id="icon-tools" class="icon32"></div><h2>Free Recent Post Slider Designs</h2></div>				
				<div class="medium-4 columns"><div class="postdesigns"><img  src="'.plugin_dir_url( __FILE__ ).'images/design-1.jpg"><p><code>[recent_post_slider design="design-1"]</code></p></div></div>
				<div class="medium-4 columns"><div class="postdesigns"><img  src="'.plugin_dir_url( __FILE__ ).'images/design-2.jpg"><p><code>[recent_post_slider design="design-2"]</code></p></div></div>
				<div class="medium-4 columns"><div class="postdesigns"><img  src="'.plugin_dir_url( __FILE__ ).'images/design-3.jpg"><p><code>[recent_post_slider design="design-3"]</code></p></div></div>
				<div class="medium-4 columns"><div class="postdesigns"><img  src="'.plugin_dir_url( __FILE__ ).'images/design-4.jpg"><p><code>[recent_post_slider design="design-4"]</code></p></div></div>
				<div class="medium-8 columns"><h2>Complete Shortcode is:</h2><p><code>[recent_post_slider limit="4" design="design-4" show_author="false" show_category_name="true" show_content="true" show_date="true" dots="true" arrows="true" autoplay="true" autoplay_interval="5000" speed="1000" content_words_limit="20"]</code></p>
				</div>
 <div class="medium-12 columns" style="margin:15px 0"><p><a href="http://wponlinesupport.com/sp_plugin/wp-responsive-recent-post-slider/" target="_blank"><img src="'.plugin_dir_url( __FILE__ ).'images/post-slider.png"></a></p>
 For More Details <a href="http://demo.wponlinesupport.com/prodemo/post-slider-pro/" target="_blank" >View DEMO</a></div>
				
				<div class="medium-12 columns"><h1>Pro Recent Post Slider and Carousel Designs</h1></div>				
				<div class="medium-12 columns"><h2>Pro Recent Post Slider Designs</h2></div>
				<div class="medium-4 columns"><div class="postdesigns"><img  src="'.plugin_dir_url( __FILE__ ).'images/design-5.jpg"><p><code>[recent_post_slider design="design-5"]</code></p></div></div>
				<div class="medium-4 columns"><div class="postdesigns"><img  src="'.plugin_dir_url( __FILE__ ).'images/design-6.jpg"><p><code>[recent_post_slider design="design-6"]</code></p></div></div>
				<div class="medium-4 columns"><div class="postdesigns"><img  src="'.plugin_dir_url( __FILE__ ).'images/design-17.jpg"><p><code>[recent_post_slider design="design-17"]</code></p></div></div>
				<div class="medium-4 columns"><div class="postdesigns"><img  src="'.plugin_dir_url( __FILE__ ).'images/design-18.jpg"><p><code>[recent_post_slider design="design-18"]</code></p></div></div>
				<div class="medium-4 columns"><div class="postdesigns"><img  src="'.plugin_dir_url( __FILE__ ).'images/design-19.jpg"><p><code>[recent_post_slider design="design-19"]</code></p></div></div>
				<div class="medium-4 columns"><div class="postdesigns"><img  src="'.plugin_dir_url( __FILE__ ).'images/design-20.jpg"><p><code>[recent_post_slider design="design-20"]</code></p></div></div>
				<div class="medium-4 columns"><div class="postdesigns"><img  src="'.plugin_dir_url( __FILE__ ).'images/design-21.jpg"><p><code>[recent_post_slider design="design-21"]</code></p></div></div>
				<div class="medium-12 columns"><h2>Pro Recent Post Carousel Designs</h2></div>
				<div class="medium-12 columns"><p><code>[recent_post_carousel limit="4" design="design-1" show_author="false" category="8" show_category_name="true" 
show_content="true" show_date="true" slides_to_show="3" slides_to_scroll="1" dots="true" arrows="true" autoplay="true"
 autoplay_interval="5000" speed="1000" content_words_limit ="20"]</code></p></div>
				<div class="medium-4 columns"><div class="postdesigns"><img  src="'.plugin_dir_url( __FILE__ ).'images/design-7.jpg"><p><code>[recent_post_carousel design="design-7"]</code></p></div></div>
				<div class="medium-4 columns"><div class="postdesigns"><img  src="'.plugin_dir_url( __FILE__ ).'images/design-8.jpg"><p><code>[recent_post_carousel design="design-8"]</code></p></div></div>
				<div class="medium-4 columns"><div class="postdesigns"><img  src="'.plugin_dir_url( __FILE__ ).'images/design-9.jpg"><p><code>[recent_post_carousel design="design-9"]</code></p></div></div>
				<div class="medium-4 columns"><div class="postdesigns"><img  src="'.plugin_dir_url( __FILE__ ).'images/design-10.jpg"><p><code>[recent_post_carousel design="design-10"]</code></p></div></div>
				<div class="medium-4 columns"><div class="postdesigns"><img  src="'.plugin_dir_url( __FILE__ ).'images/design-11.jpg"><p><code>[recent_post_carousel design="design-11"]</code></p></div></div>
				<div class="medium-4 columns"><div class="postdesigns"><img  src="'.plugin_dir_url( __FILE__ ).'images/design-12.jpg"><p><code>[recent_post_carousel design="design-12"]</code></p></div></div>
				<div class="medium-4 columns"><div class="postdesigns"><img  src="'.plugin_dir_url( __FILE__ ).'images/design-13.jpg"><p><code>[recent_post_carousel design="design-13"]</code></p></div></div>
				<div class="medium-4 columns"><div class="postdesigns"><img  src="'.plugin_dir_url( __FILE__ ).'images/design-14.jpg"><p><code>[recent_post_carousel design="design-14"]</code></p></div></div>
				<div class="medium-4 columns"><div class="postdesigns"><img  src="'.plugin_dir_url( __FILE__ ).'images/design-15.jpg"><p><code>[recent_post_carousel design="design-15"]</code></p></div></div>
				<div class="medium-4 columns"><div class="postdesigns"><img  src="'.plugin_dir_url( __FILE__ ).'images/design-16.jpg"><p><code>[recent_post_carousel design="design-16"]</code></p></div></div>
				<div class="medium-4 columns"><div class="postdesigns"><img  src="'.plugin_dir_url( __FILE__ ).'images/design-22.jpg"><p><code>[recent_post_carousel design="design-22"]</code></p></div></div>
				<div class="medium-12 columns"><p>For More Details <a href="http://demo.wponlinesupport.com/prodemo/post-slider-pro/" target="_blank" >View DEMO</a></p></div>';
		
	echo $result;
}
function wprps_post_admin_style(){
	?>
	<style type="text/css">
		.postdesigns{-moz-box-shadow: 0 0 5px #ddd;-webkit-box-shadow: 0 0 5px#ddd;box-shadow: 0 0 5px #ddd; background:#fff; padding:10px;  margin-bottom:15px;}
	.column, .columns {-webkit-box-sizing: border-box; -moz-box-sizing: border-box;    box-sizing: border-box;}
.postdesigns img{width:100%; height:auto}
@media only screen and (min-width: 40.0625em) {  
  .column,
  .columns {position: relative;padding-left:10px;padding-right:10px;float: left; }
  .medium-1 {    width: 8.33333%; }
  .medium-2 {    width: 16.66667%; }
  .medium-3 {    width: 25%; }
  .medium-4 {    width: 33.33333%; }
  .medium-5 {    width: 41.66667%; }
  .medium-6 {    width: 50%; }
  .medium-7 {    width: 58.33333%; }
  .medium-8 {    width: 66.66667%; }
  .medium-9 {    width: 75%; }
  .medium-10 {    width: 83.33333%; }
  .medium-11 {    width: 91.66667%; }
  .medium-12 {    width: 100%; } 
   }

   
	</style>
<?php }

add_action('admin_head', 'wprps_post_admin_style');
