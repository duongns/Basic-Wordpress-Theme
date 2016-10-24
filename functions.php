<?php
// ADDING ENQUENE SCRIPTS
add_action( 'wp_enqueue_scripts', 'enqueue_scripts_styles' );
function enqueue_scripts_styles() {
	wp_enqueue_style( 'opensans-font', 'https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&subset=latin,vietnamese,cyrillic' );
	wp_enqueue_style( 'styles', get_stylesheet_uri() );
    wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'addons', get_template_directory_uri() . '/scripts/addons.js', array(), '1.0' );
	wp_enqueue_script( 'scripts', get_template_directory_uri() . '/scripts/scripts.js', array(), '1.0' );	

	$frontend_ajax_arr = array(
		'ajaxurl' => admin_url('admin-ajax.php' ),
		'homeurl' => home_url(),
	);	
	wp_localize_script( 'scripts', 'frontend_ajax_url', $frontend_ajax_arr );
}


// REGISTER MENUS
register_nav_menus(
    array(
        'head-menu' => 'Head Menu',
    )
);


// INCLUDE PARTIALS 
include_once(get_template_directory() . 'includes/customizer.php');
include_once(get_template_directory() . 'includes/custom-posttype.php');


// THUMBNAILS
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );  
    add_image_size('thumbnail', 220, 220, true );
	add_image_size('medium', 768, 0, true );
	add_image_size('large', 1024, 0, true );
}


// ADMIN'S MENU HOOKS
add_action( 'admin_menu', 'custom_admin_menu_hooks' );
function custom_admin_menu_hooks() {
	/* Change Posts menu label */
	global $menu;
	$menu[5][0] = 'News';

	/* Remove 'Comments' menu page */
	remove_menu_page( 'edit-comments.php' );  
}

// CUSTOM EXCERPT
	add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
	function custom_excerpt_length( $length ) {
		return 60;
	}
		
	add_filter('excerpt_more', 'new_excerpt_more');
	function new_excerpt_more( $more ) {
		return ' ...';
	}

// REMOVE WIDTH, HEIGHT ON CONTENT ATTACHMENT IMAGES
	add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
	add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );
	add_filter( 'wp_get_attachment_link', 'remove_thumbnail_dimensions', 10 );
	add_filter( 'the_content', 'remove_thumbnail_dimensions', 10 );

	function remove_thumbnail_dimensions( $html ) {
		$html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
		return $html;
	}
