<?php
/**
 * Template part for displaying page content in home-page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WYSAC Wyoming Tobacco
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
