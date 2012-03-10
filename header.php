<!DOCTYPE html> 
<html lang="en"> 
<head> 
<meta charset="utf-8" /> 
<title><?php 
if (is_home()) : 
    bloginfo('name'); 
elseif (is_single()) :
    wp_title("", true);
else :
    bloginfo('name') + wp_title("—", true);
endif;
?></title>
<meta name="og:title" content="<?php 
if (is_home()) : 
    bloginfo('name'); 
elseif (is_single()) :
    wp_title("", true);
else :
    bloginfo('name') + wp_title("—", true);
endif;
?>" />
<meta name="og:description" content="<?php 
if (is_home()) : 
    bloginfo('name'); 
elseif (is_single()) :
    wp_title("", true);
else :
    bloginfo('name') + wp_title("—", true);
endif;
?>" />
<!-- <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" /> -->
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/improve.css" type="text/less" media="screen" />
<!--<script src="<?php bloginfo('template_url'); ?>/js/less-1.1.3.min.js" type="text/javascript"></script>-->
<!--[if lt IE 9]><script type="text/javascript" src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/favicon.ico" />
<link href="/favicon.ico" rel="icon" type="image/x-icon" />
<?php wp_enqueue_script('jquery'); ?>
<?php wp_head(); ?>
<script language="javascript" type="text/javascript" src="<?php bloginfo('template_url'); ?>/script/jquery.masonry.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($){
  $('#masonry').masonry({ gutterWidth: 10 });
});
</script>
</head> 
<body>
<div class="center"> 
  <div id="head"> 
    <div id="social-header"> 
<a rel="nofollow" style="display:inline-block;width:24px;height:24px;margin:0 7px 0 0;background:url(http://improve-agency.com/img/icons.png) -0px 0" href="http://www.facebook.com/olga.duka" title="Improve в Facebook"  target="_blank"></a> 
 
<a rel="nofollow" style="display:inline-block;width:24px;height:24px;margin:0 7px 0 0;background:url(http://improve-agency.com/img/icons.png) -24px 0" href="http://vkontakte.ru/club18004494" title="Improve ВКонтакте" target="_blank"></a> 
 
<a rel="nofollow" style="display:inline-block;width:24px;height:24px;margin:0 7px 0 0;background:url(http://improve-agency.com/img/icons.png) -72px 0" href="http://twitter.com/#!/yollo" title="Improve в Твиттере" target="_blank"></a> 
 
<a rel="nofollow" style="display:inline-block;width:24px;height:24px;margin:0 7px 0 0;background:url(http://improve-agency.com/img/icons.png) -144px 0" href="http://improve-music.livejournal.com/profile" title="Improve в LiveJournal"  target="_blank"></a> 
 
<a rel="nofollow" style="display:inline-block;width:24px;height:24px;margin:0 7px 0 0;background:url(http://improve-agency.com/img/icons2.png) -168px 0" href="http://www.lookatme.ru/users/yollo" title="Improve на Look At Me" target="_blank"></a> 
</div> 
<img src="http://improve-agency.com/img/improve-logo.gif"> 
</div> 
<div id="menu">
	<ul id="pages">
		<li class="page_item <?php if ( is_home() ) echo 'selected'; ?>"><a href="<?php echo get_option('home'); ?>">Главная</a></li>
		<?php wp_nav_menu(array('container' => '', 'menu' => 'custom_menu', 'fallback_cb' => false, 'items_wrap' => '%3$s')); ?>
	</ul>
</div>
