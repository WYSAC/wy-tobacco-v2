<?php
/**
 * Sidebar for publication pages with pub blurb and list of topics (tags)
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WYSAC Wyoming Tobacco
 */


?>
<div id="sidebar-pub" class="widget-area col-md-4 recent-entries">
	<div class="widget">
		<h2 class="widget-title">About This Report</h2>
			<p><?php // display description custom 
							global $wp_query;
							$postid = $wp_query->post->ID;
						        echo get_post_meta($postid, 'pub_description', true);
							wp_reset_query();
							?>
						</p>
		</div>
		<div class="widget">
			<?php echo do_shortcode('[toc]');?>
		</div>

		<div class="widget">
			<h2 class="widget-title">Related Topics</h2>
					<?php the_tags('<ul><li>','</li><li>','</li></ul>'); ?>
		</div>
	</div>

<!-- #secondary-->
