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

//Custom Breadcrumb
function the_breadcrumbs() {
  
    $delimiter = '<div class="divider"> / </div>';
    $name = __('Home'); //text for the 'Home' link
    $currentBefore = '<div class="active section">';
    $currentAfter = '</div>';
  
    if ( !is_home() && !is_front_page() || is_paged() ) {
  
        echo '<div class="ui breadcrumb">';
  
        global $post;
        $home = get_bloginfo('url');
        echo '<a class="section" href="' . $home . '">' . $name . '</a> ' . $delimiter . ' ';
      
        if ( is_category() ) {
            global $wp_query;
            $cat_obj = $wp_query->get_queried_object();
            $thisCat = $cat_obj->term_id;
            $thisCat = get_category($thisCat);
            $parentCat = get_category($thisCat->parent);
            if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
            echo $currentBefore;
            single_cat_title();
            echo $currentAfter;
      
        } elseif ( is_day() ) {
            echo '<a class="section" href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
            echo '<a class="section" href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
            echo $currentBefore . get_the_time('d') . $currentAfter;
      
        } elseif ( is_month() ) {
            echo '<a class="section" href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
            echo $currentBefore . get_the_time('F') . $currentAfter;
      
        } elseif ( is_year() ) {
            echo $currentBefore . get_the_time('Y') . $currentAfter;
      
        } elseif ( is_single() && !is_attachment() ) {
            $cat = get_the_category(); $cat = $cat[0];
            echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
            echo $currentBefore;
            the_title();
            echo $currentAfter;
      
        } elseif ( is_attachment() ) {
            $parent = get_post($post->post_parent);
            $cat = get_the_category($parent->ID); $cat = $cat[0];
            echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
            echo '<a class="section" href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
            echo $currentBefore;
            the_title();
            echo $currentAfter;
      
        } elseif ( is_page() && !$post->post_parent ) {
            echo $currentBefore;
            the_title();
            echo $currentAfter;
      
        } elseif ( is_page() && $post->post_parent ) {
            $parent_id  = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = '<a class="section" href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                $parent_id  = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
            echo $currentBefore;
            the_title();
            echo $currentAfter;
      
        } elseif ( is_search() ) {
            echo $currentBefore . 'Tìm kiếm &#39;' . get_search_query() . '&#39;' . $currentAfter;
      
        } elseif ( is_tag() ) {
            echo $currentBefore;
            single_tag_title();
            echo $currentAfter;
      
        } elseif ( is_author() ) {
            global $author;
            $userdata = get_userdata($author);
            echo $currentBefore . $userdata->display_name . $currentAfter;
      
        } elseif ( is_404() ) {
            echo $currentBefore . 'Error 404' . $currentAfter;
        }
      
        if ( get_query_var('paged') ) {
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
            echo __('Page') . ' ' . get_query_var('paged');
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
        }
        echo '</div>';
  
    }
}
