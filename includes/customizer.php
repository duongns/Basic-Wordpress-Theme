<?php
add_action( 'customize_preview_init', 'customize_scripts' );
function customize_scripts() {
    wp_enqueue_script( 'customizer', get_template_directory_uri() . '/scripts/customizer.js', array(), 0.5 , true );
}

add_action( 'customize_register', 'customize_register' );
function customize_register( $wp_customize ) {
    /**
     * Add postMessage support for site title and description for the Theme Customizer.
     */ 
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

    //___General___//
    $wp_customize->add_section(
        'customize_general',
        array(
            'title' => 'General',
            'priority' => 9,
        )
    );

        //Logo Upload
        $wp_customize->add_setting(
            'site_logo',
            array(
                'default-image' => '',
                'sanitize_callback' => 'esc_url_raw'
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'site_logo',
                array(
                   'label'          => 'Upload your logo',
                   'type'           => 'image',
                   'section'        => 'customize_general',
                   'settings'       => 'site_logo'
                )
            )
        );

        //Facebook AppID
        $wp_customize->add_setting(
            'facebook_appid',
            array(
                'default' => ''
            )
        );
        $wp_customize->add_control(
            'facebook_appid',
            array(
                'label'     => 'Facebook AppID',
                'section'   => 'customize_general',
                'type'      => 'text',
            )
        );
    
        //Header Custom HTML
        $wp_customize->add_setting(
            'header_custom_html',
            array(
                'default' => ''
            )
        );
        $wp_customize->add_control(
            'header_custom_html',
            array(
               'label'          => 'Header Custom HTML',
               'section'        => 'customize_general',
               'settings'       => 'header_custom_html',
               'type'           => 'textarea',
            )
        );
    
    	//Footer Custom HTML
    	$wp_customize->add_setting(
    		'footer_custom_html',
    		array(
    			'default' => ''
    		)
    	);
        $wp_customize->add_control(
            'footer_custom_html',
            array(
               'label'          => 'Footer Custom HTML',
               'section'        => 'customize_general',
               'settings'       => 'footer_custom_html',
               'type'    		=> 'textarea',
            )
        );
}
