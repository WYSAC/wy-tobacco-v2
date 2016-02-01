<?php
/**
 * Sidebar for archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WYSAC Wyoming Tobacco
 */


?>
<div id="sidebar-archives" class="widget-area col-md-4 recent-entries">
		<div class="widget">
			<h2 class="widget-title">Sort by Topic</h2>
				<?php the_tags('<ul><li>','</li><li>','</li></ul>'); ?>
		</div>
	</div>

<!-- #secondary-->
