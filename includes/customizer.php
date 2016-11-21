<?php
// THEME LOGO CUSTOMIZE
	add_action( 'after_setup_theme', 'theme_logo_register' );
	function theme_logo_register() {		
		add_theme_support( 'custom-logo', array(
			'height'      => 100,
			'width'       => 270,
			'flex-width' => true,
		) );	
	}

	add_action( 'customize_register', 'theme_customize_register' );
	function theme_customize_register( $wp_customize ) {
	    // Must have
	    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	    // Section
	    $wp_customize->add_section(
	        'customize_general',
	        array(
	            'title' => 'General',
	            'priority' => 9,
	        )
	    );
	        // Setting
	        $wp_customize->add_setting(
	            'hotline',
	            array(
	                'default' => ''
	            )
	        );
	        	// Control
		        $wp_customize->add_control(
		            'hotline',
		            array(
		                'label'     => 'Hotline',
		                'section'   => 'customize_general',
		                'type'      => 'text',
		            )
		        );
		        
		    // Setting
	        $wp_customize->add_setting(
	            'header_custom_html',
	            array(
	                'default' => ''
	            )
	        );
	        	// Control
		        $wp_customize->add_control(
		            'header_custom_html',
		            array(
		               'label'          => 'Before </head> Custom HTML',
		               'section'        => 'customize_general',
		               'settings'       => 'header_custom_html',
		               'type'           => 'textarea',
		            )
		        );
	    
	    // Section
	    $wp_customize->add_section(
	        'customize_slide',
	        array(
	            'title' => 'Slide',
	            'priority' => 11,
	        )
	    );
	        // Setting
	        $wp_customize->add_setting(
	            'slide_one',
	            array(
	                'default-image' => '',
	                'sanitize_callback' => 'esc_url_raw'
	            )
	        );
		        // Control
		        $wp_customize->add_control(
		            new WP_Customize_Image_Control(
		                $wp_customize,
		                'slide_one',
		                array(
		                   'label'          => 'Upload Image 1',
		                   'type'           => 'image',
		                   'section'        => 'customize_slide',
		                   'settings'       => 'slide_one'
		                )
		            )
		        );
	        
	        // Setting
	        $wp_customize->add_setting(
	            'slide_one_url',
	            array(
	                'default' => ''
	            )
	        );
		        // Control
		        $wp_customize->add_control(
		            'slide_one_url',
		            array(
		                'label'     => 'Image 1 URL',
		                'section'   => 'customize_slide',
		                'type'      => 'text',
		            )
		        );      


	}
