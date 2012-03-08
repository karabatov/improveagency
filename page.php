<?php
/**
 * Generic page template
 */

get_header(); ?>

    <div id="topliner">
    <div class="alpha">
        <h1><?php wp_title("",true); ?></h1>
    </div></div>
    <div id="border"></div>


    <?php the_post(); ?>

	<div class="contents">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>