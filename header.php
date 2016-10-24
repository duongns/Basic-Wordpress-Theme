<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta content="text/html; charset=utf-8" http-equiv="content-type">
	<meta name="author" content="DuongNS">	
	<meta name="description" content="<?php bloginfo('description'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">

	<meta property="fb:app_id" content="<?php echo get_theme_mod('facebook_appid'); ?>" />
	<meta property="og:title" content="<?php echo get_bloginfo( 'name' );?>" />
	<meta property="og:type" content="website" />
	<meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/images/screenshot.png" />
	<meta property="og:url" content="<?php global $wp; echo home_url(add_query_arg(array(),$wp->request));?>" />
	<meta property="og:description" content="<?php echo get_bloginfo( 'description' );?>" />
	
	<link type="image/x-icon" rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.png" />
	<link rel="image_src" href="<?php echo get_template_directory_uri(); ?>/screenshot.png" />
	
	<title>
	<?php 
		if(is_home()){
			bloginfo('name');
		} elseif ( is_tax() ) {
			 $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); echo $term->name; print ' - '; bloginfo('name');
		}else{
			wp_title('');
		} 
	?>
	</title>
	<?php wp_head();?>
	<?php echo get_theme_mod('header_custom_html'); ?>
</head>

<body <?php body_class(); ?>>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=<?php echo get_theme_mod('facebook_appid'); ?>";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<header>
		<div class="container clearfix">
			<a href="<?php echo home_url();?>" class="fl logo"><img src="<?php echo esc_url(get_theme_mod('site_logo')); ?>"></a>
			<ul class="clearfix">
				<?php wp_nav_menu( array( 
					'theme_location' => 'footer-menu', 
					'container' => 'false', 
					'items_wrap' => '%3$s'
				) );?>
			</ul>
		</div>
	</header>