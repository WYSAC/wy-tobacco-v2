<?php
/**
 * Widgetize link areas below the page main content, curated by topic.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WYSAC Wyoming Tobacco
 */


?>
	<!--Widget Area 1 -->
	<div class="widget recent-entries linkarea row">
			<h2 class="widget-title"><span class="linkarea-topic">Topic</span> Youth Tobacco Use</h2>
				<ul>
				<?php
				$args = array(
					'posts_per_page' => 4,
					'offset'=> 0,
					'tag_id' => 6 ); // Youth Tobacco tag

				$myposts = get_posts( $args );

				foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
					<li class="col-md-6">
						<?php if ( has_post_thumbnail() ) :  //Get the Thumbnail for each post ?>
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<?php the_post_thumbnail('linkarea-feature'); //Print the Thumbnail ?> </a> <?php endif; ?>
						<br/><span class="post-date"><?php the_time('m.d.Y'); //Print the Date ?></span>
						<br/> <a href="<?php the_permalink(); ?>"><?php the_title(); //Print the Title  ?></a>
					</li>
				<?php endforeach;
				wp_reset_postdata();?>
				</ul>
			</div>

<!--Widget Area 2 -->
	<div class="widget recent-entries linkarea row">
		<h2 class="widget-title"><span class="linkarea-topic">Topic</span> Schools</h2>
			<ul>
			<?php
			$args = array(
				'posts_per_page' => 4,
				'offset'=> 0,
				'tag_id' => 17 ); //Schools Tag

			$myposts = get_posts( $args );

			foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
			<li class="col-md-6">
				<?php if ( has_post_thumbnail() ) :  //Get the Thumbnail for each post ?>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail('linkarea-feature'); //Print the Thumbnail ?> </a> <?php endif; ?>
				<br/><span class="post-date"><?php the_time('m.d.Y'); //Print the Date ?></span>
				<br/> <a href="<?php the_permalink(); ?>"><?php the_title(); //Print the Title  ?></a>
			</li>
			<?php endforeach;
			wp_reset_postdata();?>
			</ul>
	</div>
</div>

<!--#secondary-->
