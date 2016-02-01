<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WYSAC Wyoming Tobacco
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container">
			<div class="row">

		<!--Insert the footer widgets from WP backend.  3-col of content-->
		<div id="footer-sidebar-1" class="col-md-4">
		  <?php dynamic_sidebar('footer-sidebar-1'); ?>
		</div>
		<div id="footer-sidebar-2" class="col-md-4">
			<?php dynamic_sidebar('footer-sidebar-2'); ?>
		</div>
		<div id="footer-sidebar-3" class="col-md-4">
			<?php dynamic_sidebar('footer-sidebar-3'); ?>
		</div>
	</div>

		<!--insert the regular old copyright info, if needed-->
		<div class="row">

		<div class="site-info col-md-12">
			&#169;<?php the_time('Y');?> <a href="http://wwww.uwyo.edu/wysac">Wyoming Survey & Analysis Center,</a> <a href="http://www.uwyo.edu">University of Wyoming</a> |
			 <a href="http://www.wordpress.org"><img src="http://www.wytobacco.dev/wp-content/uploads/2016/01/wp-icon-01.png" width="16" style="padding-bottom:3px;"></a>
		</div><!-- .site-info -->
	</div>
</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
