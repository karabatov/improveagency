<?php
	register_sidebar( array(
		'name' => 'Боковая колонка',
		'id' => 'sidebar-1',
		'before_widget' => '<div class="improve-widget">',
		'after_widget' => "</div>",
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );
	
	register_sidebar( array(
		'name' => 'Подвальная колонка',
		'id' => 'sidebar-2',
		'before_widget' => '<div class="improve-widget-footer">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title-footer">',
		'after_title' => '</h2>',
	) );
	
class Improve_Agency_Afisha_Widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @return void
	 **/
	function Improve_Agency_Afisha_Widget() {
		$widget_ops = array( 'classname' => 'widget_ia_afisha', 'description' => 'Показывает афишу в боковой колонке' );
		$this->WP_Widget( 'widget_ia_afisha', 'Improve Agency: Афиша', $widget_ops );
		$this->alt_option_name = 'widget_ia_afisha';

		add_action( 'save_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache' ) );
	}

	/**
	 * Outputs the HTML for this widget.
	 *
	 * @param array An array of standard parameters for widgets in this theme
	 * @param array An array of settings for this widget instance
	 * @return void Echoes it's output
	 **/
	function widget( $args, $instance ) {
		$cache = wp_cache_get( 'widget_ia_afisha', 'widget' );

		if ( !is_array( $cache ) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = null;

		if ( isset( $cache[$args['widget_id']] ) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract( $args, EXTR_SKIP );

		$title = empty( $instance['title'] ) ? 'АФИША' : $instance['title'];

		if ( ! isset( $instance['number'] ) )
			$instance['number'] = '6';

		if ( ! $number = absint( $instance['number'] ) )
 			$number = 6;
        
		$ephemera_args = array(
			'order' => 'ASC',
			'posts_per_page' => $number,
			'no_found_rows' => true,
			'post_status' => 'publish',
			'cat' => '5,6'
		);
		$ephemera = new WP_Query( $ephemera_args );

		if ( $ephemera->have_posts() ) :

		echo $before_widget;
		echo $before_title;
		echo $title; // Can set this with a widget option, or omit altogether
		echo $after_title;

		?>
		<?php while ( $ephemera->have_posts() ) : $ephemera->the_post(); ?>
            <?php $custom_fields = get_post_custom(); ?>
			<div class="widget-entry-title">
				<h4><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a></h4>
				<?php if ($custom_fields['Жанр']) :
					echo '<p>'.$custom_fields['Жанр'][0].'</p>'; endif; ?>				
				<?php if ($custom_fields['Где']) :
					echo '<p>'.$custom_fields['Где'][0].'</p>'; endif; ?>
				<?php if ($custom_fields['Когда']) :
					echo '<p>'.$custom_fields['Когда'][0];
					if ($custom_fields['Время']) : 
					    echo ' '.($custom_fields['Время'][0]).'</p>'; 
					endif;
				endif; ?>					
			</div>

		<?php endwhile; ?>
		<?php

		echo $after_widget;

		// Reset the post globals as this query will have stomped on it
		wp_reset_postdata();

		// end check for ephemeral posts
		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set( 'widget_ia_afisha', $cache, 'widget' );
	}

	/**
	 * Deals with the settings when they are saved by the admin. Here is
	 * where any validation should be dealt with.
	 **/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['widget_ia_afisha'] ) )
			delete_option( 'widget_ia_afisha' );

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete( 'widget_ia_afisha', 'widget' );
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 **/
	function form( $instance ) {
		$title = isset( $instance['title']) ? esc_attr( $instance['title'] ) : 'АФИША';
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 6;
?>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo('Название:'); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php echo('Количество постов:'); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" size="3" /></p>
		<?php
	}
}

register_widget( 'Improve_Agency_Afisha_Widget' );

class Improve_Agency_Contacts_Widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @return void
	 **/
	function Improve_Agency_Contacts_Widget() {
		$widget_ops = array( 'classname' => 'widget_ia_contacts', 'description' => 'Показывает контакты в боковой колонке' );
		$this->WP_Widget( 'widget_ia_contacts', 'Improve Agency: Контакты', $widget_ops );
		$this->alt_option_name = 'widget_ia_contacts';

		add_action( 'save_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache' ) );
	}

	/**
	 * Outputs the HTML for this widget.
	 *
	 * @param array An array of standard parameters for widgets in this theme
	 * @param array An array of settings for this widget instance
	 * @return void Echoes it's output
	 **/
	function widget( $args, $instance ) {
		$cache = wp_cache_get( 'widget_ia_contacts', 'widget' );

		if ( !is_array( $cache ) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = null;

		if ( isset( $cache[$args['widget_id']] ) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract( $args, EXTR_SKIP );

		$title = empty( $instance['title'] ) ? 'КОНТАКТЫ' : $instance['title'];
		$text = empty( $instance['text'] ) ? '' : $instance['text'];

		echo $before_widget;
		echo $before_title;
		echo $title; // Can set this with a widget option, or omit altogether
		echo $after_title;

        echo $text;
        
		echo $after_widget;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set( 'widget_ia_contacts', $cache, 'widget' );
	}

	/**
	 * Deals with the settings when they are saved by the admin. Here is
	 * where any validation should be dealt with.
	 **/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['text'] =  $new_instance['text'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['widget_ia_contacts'] ) )
			delete_option( 'widget_ia_contacts' );

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete( 'widget_ia_contacts', 'widget' );
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 **/
	function form( $instance ) {
		$title = isset( $instance['title']) ? esc_attr( $instance['title'] ) : 'КОНТАКТЫ';
		$text = esc_textarea($instance['text']);
		
?>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo('Название:'); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

			<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
		<?php
	}
}

register_widget( 'Improve_Agency_Contacts_Widget' );

class Improve_Agency_Social_Widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @return void
	 **/
	function Improve_Agency_Social_Widget() {
		$widget_ops = array( 'classname' => 'widget_ia_social', 'description' => 'Показывает ссылки на событие в социальных сетях в боковой колонке' );
		$this->WP_Widget( 'widget_ia_social', 'Improve Agency: Социальные сети', $widget_ops );
		$this->alt_option_name = 'widget_ia_social';

		add_action( 'save_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache' ) );
	}

	/**
	 * Outputs the HTML for this widget.
	 *
	 * @param array An array of standard parameters for widgets in this theme
	 * @param array An array of settings for this widget instance
	 * @return void Echoes it's output
	 **/
	function widget( $args, $instance ) {
		$cache = wp_cache_get( 'widget_ia_social', 'widget' );

		if ( !is_array( $cache ) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = null;

		if ( isset( $cache[$args['widget_id']] ) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract( $args, EXTR_SKIP );

		if ( is_single() ) :

		$title = empty( $instance['title'] ) ? 'Добавьте этот концерт:' : $instance['title'];

		?>
		<?php global $post; ?>
            <?php $custom_fields = get_post_custom($post->ID); ?>
                <?php if ($custom_fields['Фейсбук'] || $custom_fields['Вконтактик'] || $custom_fields['Лукэтми'] || $custom_fields['Твиттер'] || $custom_fields['Мейлру'] || $custom_fields['Ярушечка'] || $custom_fields['Жежешечка'] || $custom_fields['Одноклассники']) :
                echo '<div class="social">';
		        echo '<p>';
		        echo $title; // Can set this with a widget option, or omit altogether
		        echo '</p>'; ?>
				<?php if ($custom_fields['Фейсбук']) :
					echo '<a id="facebook" rel="nofollow" href= "'.$custom_fields['Фейсбук'][0].'" title="Поделиться в Facebook" target="_blank"></a>'; endif; ?>				
				<?php if ($custom_fields['Вконтактик']) :
					echo '<a id="vkontakte" rel="nofollow" href= "'.$custom_fields['Вконтактик'][0].'" title="Поделиться В Контакте" target="_blank"></a>'; endif; ?>		
				<?php if ($custom_fields['Лукэтми']) :
					echo '<a id="lookatme" rel="nofollow" href= "'.$custom_fields['Лукэтми'][0].'" title="Добавить на LookAtMe" target="_blank"></a>'; endif; ?>		
				<?php if ($custom_fields['Твиттер']) :
					echo '<a id="twitter" rel="nofollow" href= "'.$custom_fields['Твиттер'][0].'" title="Поделиться в Twitter" target="_blank"></a>'; endif; ?>		
				<?php if ($custom_fields['Мейлру']) :
					echo '<a id="mailru" rel="nofollow" href= "'.$custom_fields['Мейлру'][0].'" title="Поделиться на Mail.ru" target="_blank"></a>'; endif; ?>						
				<?php if ($custom_fields['Ярушечка']) :
					echo '<a id="yaru" rel="nofollow" href= "'.$custom_fields['Ярушечка'][0].'" title="Поделиться в Я.ру" target="_blank"></a>'; endif; ?>		
				<?php if ($custom_fields['Жежешечка']) :
					echo '<a id="livejournal" rel="nofollow" href= "'.$custom_fields['Жежешечка'][0].'" title="Поделиться в Живом Журнале" target="_blank"></a>'; endif; ?>	
				<?php if ($custom_fields['Одноклассники']) :
					echo '<a id="odnoklassniki" rel="nofollow" href= "'.$custom_fields['Одноклассники'][0].'" title="Поделиться в Одноклассниках" target="_blank"></a>'; endif; ?>	
				<?php echo '</div>'; ?>
				<?php endif; ?>

		<?php

		// Reset the post globals as this query will have stomped on it
		wp_reset_postdata();

		// end check for ephemeral posts
		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set( 'widget_ia_social', $cache, 'widget' );
	}

	/**
	 * Deals with the settings when they are saved by the admin. Here is
	 * where any validation should be dealt with.
	 **/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['widget_ia_social'] ) )
			delete_option( 'widget_ia_social' );

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete( 'widget_ia_social', 'widget' );
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 **/
	function form( $instance ) {
		$title = isset( $instance['title']) ? esc_attr( $instance['title'] ) : 'Добавьте этот концерт:';
?>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo('Название:'); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
		<?php
	}
}

register_widget( 'Improve_Agency_Social_Widget' );

class Improve_Agency_Sponsor_Widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @return void
	 **/
	function Improve_Agency_Sponsor_Widget() {
		$widget_ops = array( 'classname' => 'widget_ia_sponsor', 'description' => 'Показывает логотип спонсора в подвальной колонке' );
		$this->WP_Widget( 'widget_ia_sponsor', 'Improve Agency: Логотип спонсора', $widget_ops );
		$this->alt_option_name = 'widget_ia_sponsor';

		add_action( 'save_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache' ) );
	}

	/**
	 * Outputs the HTML for this widget.
	 *
	 * @param array An array of standard parameters for widgets in this theme
	 * @param array An array of settings for this widget instance
	 * @return void Echoes it's output
	 **/
	function widget( $args, $instance ) {
		$cache = wp_cache_get( 'widget_ia_sponsor', 'widget' );

		if ( !is_array( $cache ) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = null;

		if ( isset( $cache[$args['widget_id']] ) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract( $args, EXTR_SKIP );

		if ( is_single() ) :

		?>
		<?php global $post; ?>
            <?php $custom_fields = get_post_custom($post->ID); ?>
            <?php if ($custom_fields['Спонсор']) :
                echo '<div id="partners"><img src="'.$custom_fields['Спонсор'][0].'" alt="Спонсоры"></div>'; 
            endif; ?>
        <?php elseif ( is_home() ) :
            $defimg = empty( $instance['defimg'] ) ? '' : $instance['defimg'];
            if (!($defimg == '')) :
                echo '<div id="partners"><img src="'.$defimg.'" alt="Спонсоры"></div>';
            endif;
        //endif;
        ?>
		<?php

		// Reset the post globals as this query will have stomped on it
		wp_reset_postdata();

		// end check for ephemeral posts
		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set( 'widget_ia_sponsor', $cache, 'widget' );
	}

	/**
	 * Deals with the settings when they are saved by the admin. Here is
	 * where any validation should be dealt with.
	 **/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['defimg'] = strip_tags( $new_instance['defimg'] );
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['widget_ia_sponsor'] ) )
			delete_option( 'widget_ia_sponsor' );

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete( 'widget_ia_sponsor', 'widget' );
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 **/
	function form( $instance ) {
		$defimg = isset( $instance['defimg']) ? esc_attr( $instance['defimg'] ) : '';
?>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'defimg' ) ); ?>"><?php echo('Логотип спонсоров на главной странице:'); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'defimg' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'defimg' ) ); ?>" type="text" value="<?php echo esc_attr( $defimg ); ?>" /></p>
		<?php
	}
}

register_widget( 'Improve_Agency_Sponsor_Widget' );

class Improve_Agency_Masonry_Widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @return void
	 **/
	function Improve_Agency_Masonry_Widget() {
		$widget_ops = array( 'classname' => 'widget_ia_masonry', 'description' => 'Показывает логотипы спонсоров в подвальной колонке' );
		$this->WP_Widget( 'widget_ia_masonry', 'Improve Agency: Логотипы спонсоров', $widget_ops );
		$this->alt_option_name = 'widget_ia_masonry';

		add_action( 'save_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache' ) );
	}

	/**
	 * Outputs the HTML for this widget.
	 *
	 * @param array An array of standard parameters for widgets in this theme
	 * @param array An array of settings for this widget instance
	 * @return void Echoes it's output
	 **/
	function widget( $args, $instance ) {
		$cache = wp_cache_get( 'widget_ia_masonry', 'widget' );

		if ( !is_array( $cache ) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = null;

		if ( isset( $cache[$args['widget_id']] ) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract( $args, EXTR_SKIP );

		if ( is_single() ) :

		?>
		<?php global $post; ?>
            <?php $custom_fields = get_post_custom($post->ID); ?>
            <?php if ($custom_fields['Masonry']) :
                echo '<div id="masonry">';
                foreach ($custom_fields['Masonry'] as $brick) {
                    $cimg = wp_get_attachment_image_src($brick, 'full');
                    $pimg = get_post($brick);
                    $imglink = $pimg->post_excerpt;
                    $imgalt = get_post_meta($brick, '_wp_attachment_image_alt', true);
                    if ($imglink == '') :
                        echo  '<img src="'.$cimg[0].'" width="'.$cimg[1].'" height="'.$cimg[2].'" alt="'.$imgalt.'">';
                    else :
                        echo '<a href="'.$imglink.'" target="_blank"><img src="'.$cimg[0].'" width="'.$cimg[1].'" height="'.$cimg[2].'" alt="'.$imgalt.'"></a>';
                    endif;
                }
                echo '</div>';
            endif; ?>
        <?php elseif ( is_home() ) :
            $defimg = empty( $instance['defimg'] ) ? '' : $instance['defimg'];
            if (!($defimg == '')) :
                echo '<div id="partners"><img src="'.$defimg.'" alt="Спонсоры"></div>';
            else :            
                global $post;
                $args = array( 'numberposts' => 1, 'category' => 5 );
		        $lastposts = get_posts( $args );
		        foreach($lastposts as $post) : setup_postdata($post);
                $custom_fields = get_post_custom($post->ID);
                if ($custom_fields['Masonry']) :
                    echo '<div id="masonry">';
                    foreach ($custom_fields['Masonry'] as $brick) {
                        $cimg = wp_get_attachment_image_src($brick, 'full');
                        $pimg = get_post($brick);
                        $imglink = $pimg->post_excerpt;
                        $imgalt = get_post_meta($brick, '_wp_attachment_image_alt', true);
                        if ($imglink == '') :
                            echo  '<img src="'.$cimg[0].'" width="'.$cimg[1].'" height="'.$cimg[2].'" alt="'.$imgalt.'">';
                        else :
                            echo '<a href="'.$imglink.'" target="_blank"><img src="'.$cimg[0].'" width="'.$cimg[1].'" height="'.$cimg[2].'" alt="'.$imgalt.'"></a>';
                        endif;
                    }
                    echo '</div>';
                endif; 
                endforeach; 
            endif; ?>
		<?php

		// Reset the post globals as this query will have stomped on it
		wp_reset_postdata();

		// end check for ephemeral posts
		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set( 'widget_ia_masonry', $cache, 'widget' );
	}

	/**
	 * Deals with the settings when they are saved by the admin. Here is
	 * where any validation should be dealt with.
	 **/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['defimg'] = strip_tags( $new_instance['defimg'] );
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['widget_ia_masonry'] ) )
			delete_option( 'widget_ia_masonry' );

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete( 'widget_ia_masonry', 'widget' );
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 **/
	function form( $instance ) {
		$defimg = isset( $instance['defimg']) ? esc_attr( $instance['defimg'] ) : '';
?>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'defimg' ) ); ?>"><?php echo('Ссылка на статичную картинку для главной страницы. Иначе на главной будут логотипы Featured записи.'); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'defimg' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'defimg' ) ); ?>" type="text" value="<?php echo esc_attr( $defimg ); ?>" /></p>
		<?php
	}
}

register_widget( 'Improve_Agency_Masonry_Widget' );


class Improve_Agency_Side_Sponsor_Widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @return void
	 **/
	function Improve_Agency_Side_Sponsor_Widget() {
		$widget_ops = array( 'classname' => 'widget_ia_side_sponsor', 'description' => 'Показывает логотип спонсора в боковой колонке' );
		$this->WP_Widget( 'widget_ia_side_sponsor', 'Improve Agency: Боковой логотип спонсора', $widget_ops );
		$this->alt_option_name = 'widget_ia_side_sponsor';

		add_action( 'save_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache' ) );
	}

	/**
	 * Outputs the HTML for this widget.
	 *
	 * @param array An array of standard parameters for widgets in this theme
	 * @param array An array of settings for this widget instance
	 * @return void Echoes it's output
	 **/
	function widget( $args, $instance ) {
		$cache = wp_cache_get( 'widget_ia_side_sponsor', 'widget' );

		if ( !is_array( $cache ) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = null;

		if ( isset( $cache[$args['widget_id']] ) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract( $args, EXTR_SKIP );

		if ( is_single() ) :

		?>
		<?php global $post; ?>
            <?php $custom_fields = get_post_custom($post->ID); ?>
            <?php if ($custom_fields['Спонсор2']) :
                if ($custom_fields['Спонсор2Ссылка']) :
                    echo '<div class="sidesponsor"><a href="'.$custom_fields['Спонсор2Ссылка'][0].'"><img src="'.$custom_fields['Спонсор2'][0].'" alt="Спонсор"></a></div>';
                else :
                    echo '<div class="sidesponsor"><img src="'.$custom_fields['Спонсор2'][0].'" alt="Спонсор"></div>';
                endif;
            endif;

		// Reset the post globals as this query will have stomped on it
		wp_reset_postdata();

		// end check for ephemeral posts
		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set( 'widget_ia_side_sponsor', $cache, 'widget' );
	}

	/**
	 * Deals with the settings when they are saved by the admin. Here is
	 * where any validation should be dealt with.
	 **/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['widget_ia_side_sponsor'] ) )
			delete_option( 'widget_ia_side_sponsor' );

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete( 'widget_ia_side_sponsor', 'widget' );
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 **/
	function form( $instance ) {
?>		<?php
	}
}

register_widget( 'Improve_Agency_Side_Sponsor_Widget' );

class Improve_Agency_Map_Widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @return void
	 **/
	function Improve_Agency_Map_Widget() {
		$widget_ops = array( 'classname' => 'widget_ia_map', 'description' => 'Вставляет в боковую колонку карту Google Maps' );
		$this->WP_Widget( 'widget_ia_map', 'Improve Agency: Карта', $widget_ops );
		$this->alt_option_name = 'widget_ia_map';

		add_action( 'save_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache' ) );
	}

	/**
	 * Outputs the HTML for this widget.
	 *
	 * @param array An array of standard parameters for widgets in this theme
	 * @param array An array of settings for this widget instance
	 * @return void Echoes it's output
	 **/
	function widget( $args, $instance ) {
		$cache = wp_cache_get( 'widget_ia_map', 'widget' );

		if ( !is_array( $cache ) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = null;

		if ( isset( $cache[$args['widget_id']] ) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract( $args, EXTR_SKIP );

		$width = empty( $instance['width'] ) ? '300' : $instance['width'];
		$height = empty( $instance['height'] ) ? '250' : $instance['height'];

		if ( is_single() ) :

		//echo '<div class="social">';
		//echo '<p>';
		//echo $title; // Can set this with a widget option, or omit altogether
		//echo '</p>';

		?>
		<?php global $post; ?>
            <?php $custom_fields = get_post_custom($post->ID); ?>
				<?php if ($custom_fields['Карта']) :
					echo '<iframe width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$custom_fields['Карта'][0].'&amp;output=embed"></iframe>'; 
					echo '<a class="maptext" target="_blank" href="'.$custom_fields['Карта'][0].'">';
					if ($custom_fields['Где']) :
					    echo $custom_fields['Где'][0].'<br />';
					endif;
					$m = parse_url($custom_fields['Карта'][0]);
					parse_str($m['query'], $arr);
					echo 'Адрес: '.urldecode($arr['q']);
					if ($custom_fields['Телефон']) :
					    echo '<br />Телефон: '.$custom_fields['Телефон'][0].'</a>';
					else:
					    echo '</a>';
					endif;
				
				endif; ?>				
		<?php

		//echo '</div>';

		// Reset the post globals as this query will have stomped on it
		wp_reset_postdata();

		// end check for ephemeral posts
		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set( 'widget_ia_map', $cache, 'widget' );
	}

	/**
	 * Deals with the settings when they are saved by the admin. Here is
	 * where any validation should be dealt with.
	 **/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['width'] = absint( $new_instance['width'] );
		$instance['height'] = absint( $new_instance['height'] );		
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['widget_ia_map'] ) )
			delete_option( 'widget_ia_map' );

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete( 'widget_ia_map', 'widget' );
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 **/
	function form( $instance ) {
		$width = isset( $instance['width']) ? esc_attr( $instance['width'] ) : 300;
		$height = isset( $instance['height']) ? esc_attr( $instance['height'] ) : 250;		
?>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>"><?php echo('Ширина:'); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'width' ) ); ?>" type="text" value="<?php echo esc_attr( $width ); ?>" /></p>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>"><?php echo('Высота:'); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'height' ) ); ?>" type="text" value="<?php echo esc_attr( $height ); ?>" /></p>
		<?php
	}
}

register_widget( 'Improve_Agency_Map_Widget' );

// [buy link="http://buylink.com"]
function buytag_func( $atts ) {
	extract( shortcode_atts( array(
		'link' => '',
	), $atts ) );

    if ($atts['link'] != '') :
	    return '<p><a href="'.$atts['link'].'" class="register" target="_blank"><span>КУПИТЬ БИЛЕТ</span></a></p>';
	else :
	    return '';
	endif;
}
add_shortcode( 'buy', 'buytag_func' );

// [register link="http://buylink.com"]
function registertag_func( $atts ) {
	extract( shortcode_atts( array(
		'link' => '',
	), $atts ) );

    if ($atts['link'] != '') :
	    return '<p><a href="'.$atts['link'].'" class="register" target="_blank"><span>ЗАРЕГИСТРИРОВАТЬСЯ</span></a></p>';
	else :
	    return '';
	endif;
}
add_shortcode( 'register', 'registertag_func' );

add_action('init', 'addmcebutton');

function addmcebutton() {
    if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
        return;
    }

    if ( get_user_option('rich_editing') == 'true' ) {
        add_filter( 'mce_external_plugins', 'add_plugin' );
        add_filter( 'mce_buttons', 'register_button' );
    }
}

function register_button( $buttons ) {
    array_push( $buttons, "|", "buytag" );
    array_push( $buttons, "|", "regtag" );
    return $buttons;
}

function add_plugin( $plugin_array ) {
    $plugin_array['buytag'] = get_bloginfo( 'template_url' ) . '/script/buytag.js';
    $plugin_array['regtag'] = get_bloginfo( 'template_url' ) . '/script/regtag.js';
    return $plugin_array;
}


// add a favicon for your admin
function admin_favicon() {
	echo '<link rel="Shortcut Icon" type="image/x-icon" href="/favicon.ico" />';
}
add_action('admin_head', 'admin_favicon');
	
?>
