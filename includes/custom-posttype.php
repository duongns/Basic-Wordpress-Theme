<?php
	/*	MENU POSITIONS
		  5 - below Posts
		 10 - below Media
		 15 - below Links
		 20 - below Pages
		 25 - below comments
		 60 - below first separator
		 65 - below Plugins
		 70 - below Users
		 75 - below Tools
		 80 - below Settings
		100 - below second separator
	*/
?>
<?php add_action('init', 'posttype_custom');

function posttype_custom() {
	$labels = array(
		'name' => 'Custom Posttype',
		'singular_name' => 'Custom Posttype',
		'all_items' => 'All Posts',
		'add_new' => 'Add Post',
		'add_new_item' => 'Add New Post',
		'edit_item' => 'Edit Post',
		'new_item' => 'New Post',
		'view_item' => 'View Details',
		'search_items' => 'Search Post',
		'not_found' =>  'No post was found with that criteria',
		'not_found_in_trash' => 'No post found in the Trash with that criteria',
		'view' =>  'View post'
	);

	$args = array(
		'labels' => $labels,
		'description' => 'This is the holding location for all ecas',
		'public' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => true,
		'show_ui' => true,
		'rewrite' => true,
		'menu_position' => 60,
		'menu_icon' => '',
		'supports' => array('title', 'thumbnail', 'editor')
	);
	register_post_type('pre-custom-posttype', $args);
}

/* Register custom taxonomy */
add_action('init', 'register_custom_taxonomy');
function register_custom_taxonomy() {
	register_taxonomy('custom-taxonomy', 'posttype_custom', array(
		"labels" => array(
			'name' => 'Custom Taxonomy',
			'add_new_item' => 'Add New Custom Taxonomy',
			'menu_name' => 'Custom Taxonomy'
		),
		"hierarchical" => true, 
		"singular_label" => "Edit Custom Taxonomy", 
		"rewrite" => array('slug' => 'custom-posttype'),
		"show_admin_column" => true,			
		'show_in_nav_menus' => true,
	));
}