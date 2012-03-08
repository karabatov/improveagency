<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 */

get_header(); ?>

	<?php if ( have_posts() ) : ?>
		<?php
		global $post;
		$args = array( 'numberposts' => 1, 'category' => 5 );
		$lastposts = get_posts( $args );
		foreach($lastposts as $post) : setup_postdata($post); ?>

			<div id="topliner">
			<div class="alpha">
				<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
				<?php $custom_fields = get_post_custom(); ?>
				<?php if ($custom_fields['Цитата']) :
				    echo '<blockquote>';
				    foreach ($custom_fields['Цитата'] as $value) echo '<p>'.nl2br($value).'</p>';
				    echo '</blockquote>';
				else: 
				    the_excerpt(); 
				endif; 
				echo '<div class="clear2"></div>'; ?>
				<?php
					if ($custom_fields['Купить билет']) :
						echo '<a href="'.$custom_fields['Купить билет'][0].'" class="buy" target="_blank"><span>КУПИТЬ</span></a>';
					endif; 
					if ($custom_fields['Где']) :
					echo '<p class="info">'.$custom_fields['Где'][0];
						if ($custom_fields['Когда']) :
							echo '<br />'.$custom_fields['Когда'][0];
							if ($custom_fields['День недели']) :
								echo ', '.$custom_fields['День недели'][0];
								if ($custom_fields['Время']) :
									echo ' в '.$custom_fields['Время'][0];
								endif;
							endif;
						endif;
						if ($custom_fields['Цена билета']) :
							echo '<br />Билет: '.$custom_fields['Цена билета'][0];
						endif;
					echo '</p>';
					endif;
					?>
				</div>
				<div class="omega">
				<?php 
					if ($custom_fields['imagebig']) : ?>
						<a href="<?php the_permalink(); ?>"><img class="centered" src="<?php echo $custom_fields['imagebig'][0]; ?>"></a>
					<?php endif; ?>
				</div>
			</div>
			<div id="border"></div>

		<?php endforeach; ?>
		
		<?php /* Start the Loop */ ?>
		<?php $announce = 0; ?>
		<?php while ( have_posts() ) : the_post();
			if ( !in_category( 5 ) && in_category( 6 ) ) :
				if ($announce % 3 == 0) :  
					echo '<div class="clear"></div>';
				endif; ?>
			<?php $announce += 1; ?>
			<div class="anonce">
				<?php $custom_fields = get_post_custom(); ?>
				<a href="<?php the_permalink();?>">
				<img src="<?php echo $custom_fields['300image'][0];?>">
				<h2><?php the_title() ?></h2></a>
				<?php
				if ($custom_fields['Где']) :
					echo '<p class="info">'.$custom_fields['Где'][0];
					if ($custom_fields['Когда']) :
						echo ' — '.$custom_fields['Когда'][0];
						if ($custom_fields['День недели']) :
							echo ', '.$custom_fields['День недели'][0];
						endif;
						if ($custom_fields['Время']) :
							echo ' в '.$custom_fields['Время'][0];
						endif;
					endif;
					echo '</p>';
				endif; 
				the_excerpt(); ?>
			</div>	
			<?php endif;
		endwhile; ?>
	<?php else : ?>

		<article id="post-0" class="post no-results not-found">
			<header class="entry-header">
				<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentyeleven' ); ?></h1>
			</header><!-- .entry-header -->

			<div class="entry-content">
				<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyeleven' ); ?></p>
				<?php get_search_form(); ?>
			</div><!-- .entry-content -->
		</article><!-- #post-0 -->
	<?php endif; ?>

<?php //get_sidebar(); ?>
<?php get_footer(); ?>