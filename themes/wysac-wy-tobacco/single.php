<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WYSAC Wyoming Tobacco
 */

get_header(); ?>
<div class="row">
	<div id="primary" class="content-area">
		<main id="main" class="site-main col-md-8" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content', 'single' ); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			?>

		<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
			if ( in_category(array('2','3','4','5')) ) {
				get_sidebar ('pub'); }
			else {
				get_sidebar('resource');
			} ?>
</div><!--.row-->
<?php get_footer(); ?>
