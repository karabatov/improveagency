<?php
/**
 * Single post
 */

get_header(); ?>

	<?php while ( have_posts() ) : the_post();
        setup_postdata($post); ?>
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
					    if ( mb_strtolower($custom_fields['Купить билет'][0]) == 'бесплатно' ) :
					        echo '<a class="buy"><span>БЕСПЛАТНО</span></a>';
					    else :
					        echo '<a href="'.$custom_fields['Купить билет'][0].'" class="buy" target="_blank"><span>КУПИТЬ</span></a>';
					    endif;
					endif; 
					if ($custom_fields['Где']) :
					echo '<p class="info" style="margin-left:20px">'.$custom_fields['Где'][0];
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
			
		<div class="contents" id="selectable-content">
		<?php the_content();
		if ($custom_fields['Подпост']) :
		    echo '<p class="official">';
		    foreach ($custom_fields['Подпост'] as $line) :
		        echo $line;
		    endforeach;
		    echo '</p>';
		endif; ?>
	    </div><!-- .entry-content -->

		<?php endwhile; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>