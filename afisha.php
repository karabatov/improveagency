<?php
/**
 * Template name: Afisha
 */

get_header(); ?>

    <div id="topliner">
    <div class="alpha">
        <h1><?php wp_title("",true); ?></h1>
    </div></div>
    <div id="border"></div>


	<?php if ( have_posts() ) : ?>		
		<?php /* Start the Loop */ ?>
		<table class="afishatable">
		<thead><tr>
		<th width="180">Мероприятие</th>
		<th width="180">Где</th>
		<th width="120">Жанр</th>
		<th width="150">Цена билета</th>
		<th>Когда</th>
		<th>Время</th>
		</tr></thead><tbody>
		<?php global $post;
		$args = array('category' => '6,5', 'numberposts' => -1);
		$lastposts = get_posts( $args );
		foreach($lastposts as $post) : setup_postdata($post); ?>		
            <?php $custom_fields = get_post_custom(); ?>
            <tr><td><a href="<?php the_permalink();?>"><?php the_title() ?></a></td>
            <td><?php echo $custom_fields['Где'][0] ?></td>
            <td><?php echo $custom_fields['Жанр'][0] ?></td>
            <td><?php echo $custom_fields['Цена билета'][0] ?></td>
            <td><?php echo $custom_fields['Когда'][0] ?></td>
            <td><?php echo $custom_fields['Время'][0] ?></td></tr>
        <?php endforeach; ?>
		</tbody></table>
	<?php endif; ?>
	<div id="clear">&nbsp;<br />&nbsp;<br /></div>
    <div id="topliner">
    <div class="alpha">
        <h1>Прошедшие мероприятия</h1>
    </div></div>
    <div id="border"></div>
	<?php if ( have_posts() ) : ?>		
		<?php /* Start the Loop */ ?>
		<table class="afishatable">
		<thead><tr>
		<th width="180">Мероприятие</th>
		<th width="180">Где</th>
		<th width="120">Жанр</th>
		<th width="150">Цена билета</th>
		<th>Когда</th>
		<th>Время</th>
		</tr></thead><tbody>
		<?php global $post;
		$args = array('orderby' => 'menu_order', 'order' => 'DESC', 'category' => '1', 'numberposts' => -1);
		$lastposts = get_posts( $args );
		foreach($lastposts as $post) : setup_postdata($post); ?>		
            <?php $custom_fields = get_post_custom(); ?>
            <tr><td><a href="<?php the_permalink();?>"><?php the_title() ?></a></td>
            <td><?php echo $custom_fields['Где'][0] ?></td>
            <td><?php echo $custom_fields['Жанр'][0] ?></td>
            <td><?php echo $custom_fields['Цена билета'][0] ?></td>
            <td><?php echo $custom_fields['Когда'][0] ?></td>
            <td><?php echo $custom_fields['Время'][0] ?></td></tr>
        <?php endforeach; ?>
		</tbody></table>
	<?php endif; ?>	

<?php //get_sidebar(); ?>
<?php get_footer(); ?>