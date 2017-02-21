<?php
add_action( 'tgmpa_register', 'snshadona_plugin_activation' );
function snshadona_plugin_activation() {
    $plugins = array(
            // install Redux Framework, it on wordpress.org/plugins
            array(
                'name'      => esc_html__('Redux Framework', 'snshadona'),
                'slug'      => 'redux-framework', // Slug name of plugin on URL
                'required'  => true,
            ),
            array(
                'name'               => esc_html__('Meta Box', 'snshadona'),
                'slug'               => 'meta-box',
                'required'           => true,
                'force_activation'   => false,
                'force_deactivation' => false,
            ),
            array(
                'name'                  => esc_html__('Slider Revolution', 'snshadona'),
                'slug'                  => 'revslider',
                'source'                => esc_url('http://demo.snstheme.com/wp/resource/revslider.zip'),
                'required'              => true,
                'force_activation'      => false,
                'force_deactivation'    => false,
            ),
            array(
                'name'                  => esc_html__('WPBakery Visual Composer', 'snshadona'),
                'slug'                  => 'js_composer',
                'source'                => esc_url('http://demo.snstheme.com/wp/resource/js_composer.zip'),
                'required'              => true,
                'force_activation'      => false,
                'force_deactivation'    => false,
            ),
            array(
                'name'                  => esc_html__('SNS Posttype', 'snshadona'),
                'slug'                  => 'sns-posttype',
                'source'                => esc_url('http://demo.snstheme.com/wp/resource/hadona/sns-posttype.zip'),
                'required'              => true,
                'force_activation'      => false,
                'force_deactivation'    => false,
            ),
            array(
                'name'               => esc_html__('WooCommerce - excelling eCommerce', 'snshadona'),
                'slug'               => 'woocommerce',
                'required'           => true,
                'force_activation'   => false,
                'force_deactivation' => false,
            ),
            array(
                'name'               => esc_html__('YITH WooCommerce Wishlist', 'snshadona'),
                'slug'               => 'yith-woocommerce-wishlist',
                'required'           => true,
                'force_activation'   => false,
                'force_deactivation' => false,
            ),
            array(
                'name'               => esc_html__('YITH WooCommerce Compare', 'snshadona'),
                'slug'               => 'yith-woocommerce-compare',
                'required'           => true,
                'force_activation'   => false,
                'force_deactivation' => false,
            ),
            array(
                'name'               => esc_html__('YITH WooCommerce Quick View', 'snshadona'),
                'slug'               => 'yith-woocommerce-quick-view',
                'required'           => true,
                'force_activation'   => false,
                'force_deactivation' => false,
            ),
	    	array(
	    		'name'               => esc_html__('YITH WooCommerce Ajax Product Filter', 'snshadona'),
	    		'slug'               => 'yith-woocommerce-ajax-navigation',
	    		'required'           => true,
	    		'force_activation'   => false,
	    		'force_deactivation' => false,
	    	),
            array(
                'name'               => esc_html__('Contact Form 7', 'snshadona'),
                'slug'               => 'contact-form-7',
                'required'           => true,
                'force_activation'   => false,
                'force_deactivation' => false,
            ),
            array(
                'name'               => esc_html__('Image Widget', 'snshadona'),
                'slug'               => 'image-widget',
                'required'           => true,
                'force_activation'   => false,
                'force_deactivation' => false,
            ),

        );
  
    $config = array(
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Is show notices or not?
        'dismissable'  => false,                   // If false then user cannot colose notices above.
        'is_automatic' => true,                    // If false thene plugin cannot auto active after install.
    );
    tgmpa( $plugins, $config );
}