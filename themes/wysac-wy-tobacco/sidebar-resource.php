<?php
/**
 * Sidebar for resource posts and archive
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WYSAC Wyoming Tobacco
 */


?>
<div id="sidebar-resource" class="widget-area col-md-4 recent-entries">
		<?php dynamic_sidebar( 'resource-sidebar'); ?>
	<div class="widget">
				<h2 class="widget-title">Recent Resources</h2>
					<ul>
					<?php
					$args = array(
						'posts_per_page' => 5,
						'offset'=> 0,
						'category' => 1 );

					$myposts = get_posts( $args );

					foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
						<li>
							<span class="post-date"><?php the_time('m.d.Y');?></span>
							<br/> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</li>
					<?php endforeach;
					wp_reset_postdata();?>
					</ul>
		</div>

		<div class="widget">
			<h2 class="widget-title">Related Topics</h2>
					<?php the_tags('<ul><li>','</li><li>','</li></ul>'); ?>
		</div>
	</div>

<!-- #secondary-->
