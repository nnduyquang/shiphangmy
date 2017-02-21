<?php
/**
 * Registering meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 * Please read them CAREFULLY.
 *
 * You also should read the changelog to know what has been changed before updating.
 *
 * For more information, please visit:
 * @link http://metabox.io/docs/registering-meta-boxes/
 */
add_filter( 'rwmb_meta_boxes', 'snshadona_register_meta_boxes' );
/**
 * Register meta boxes
 *
 * Remember to change "your_prefix" to actual prefix in your project
 *
 * @param array $meta_boxes List of meta boxes
 *
 * @return array
 */
function snshadona_register_meta_boxes( $meta_boxes ){
	/**
	 * prefix of meta keys (optional)
	 * Use underscore (_) at the beginning to make keys hidden
	 * Alt.: You also can make prefix empty to disable it
	 */
	// Better has an underscore as last sign
	wp_enqueue_script('sns-imgselect', SNSHADONA_THEME_URI . '/framework/meta-box/sns-metabox.js', array('jquery'), '', true);
	$prefix = 'snshadona_';
	global $wpdb, $snshadona_opt;
	$revsliders =array();
	$revsliders[0] = 'Select a slider';
	if ( ! function_exists( 'is_plugin_active' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
	if (is_plugin_active('revslider/revslider.php')) {
		$query = $wpdb->prepare("
			SELECT * 
			FROM {$wpdb->prefix}revslider_sliders 
			ORDER BY %s"
			, "ASC");
	    $get_sliders = $wpdb->get_results($query);
	    if($get_sliders) {
		    foreach($get_sliders as $slider) {
			   $revsliders[$slider->alias] = $slider->title;
		   }
	    }
	}
	//
	$default_layout = 'm-r';
	if ( isset($snshadona_opt['blog_layout']) ) $default_layout = $snshadona_opt['blog_layout'];
	//
	$siderbars = array();
	foreach ($GLOBALS['wp_registered_sidebars'] as $sidebars) {
		$siderbars[ $sidebars['id']] = $sidebars['name'];
	}
	// Layout config
	$meta_boxes[] = array(
		// Meta box id, UNIQUE per meta box. Optional since 4.1.5
		'id'         => 'sns_productcfg',
		// Meta box title - Will appear at the drag and drop handle bar. Required.
		'title'      => esc_html__( 'Product Config', 'snshadona' ),
		// Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
		'post_types' => array( 'product' ),
		// Where the meta box appear: normal (default), advanced, side. Optional.
		'context'    => 'normal',
		// Order of meta box: high (default), low. Optional.
		'priority'   => 'high',
		// Auto save: true, false (default). Optional.
		// 'autosave'   => true,
		// List of meta fields

		'fields'     => array(
			 array(
					'name'    => esc_html__( 'Product Sidebar', 'snshadona' ),
					'id'       => "{$prefix}product_sidebar",
					'type'     => 'select',
					'std'  => '',
					'options'  => array(
						''  => esc_html__( 'Default', 'snshadona' ),
						'0'  => esc_html__( 'No', 'snshadona' ),
						'1'  => esc_html__( 'Yes', 'snshadona' ),
					),
					'desc'		=> esc_html__('Product page with Sidebar. Select "Default" to use in Theme Options.', 'snshadona'),
				),
			  array(
					'name'    => esc_html__( 'Cloud Zoom', 'snshadona' ),
					'id'       => "{$prefix}woo_zoomtype",
					'type'     => 'select',
					'std'  => '',
					'options'  => array(
						''  => esc_html__( 'Default', 'snshadona' ),
						'window'  => esc_html__( 'window', 'snshadona' ),
						'lens'  => esc_html__( 'lens', 'snshadona' ),
						'inner'  => esc_html__( 'Inner', 'snshadona' ),
					),
					'desc'		=> '',
				),
			array(
				'id'    => "{$prefix}product_video",
				'name'  => esc_html__( 'Product Video', 'snshadona' ),
				'type'  => 'oembed',
				// Allow to clone? Default is false
				'clone' => false,
				'desc'		  => esc_html__( 'Enter your video url(youtube, video)', 'snshadona' ),
				// Input size
				'size'  => 50,
			)
		)
	);

	// Layout config
	$meta_boxes[] = array(
		// Meta box id, UNIQUE per meta box. Optional since 4.1.5
		'id'         => 'sns_layout',
		// Meta box title - Will appear at the drag and drop handle bar. Required.
		'title'      => esc_html__( 'Layout Config', 'snshadona' ),
		// Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
		'post_types' => array( 'page' ),
		// Where the meta box appear: normal (default), advanced, side. Optional.
		'context'    => 'normal',
		// Order of meta box: high (default), low. Optional.
		'priority'   => 'high',
		// Auto save: true, false (default). Optional.
		// 'autosave'   => true,
		// List of meta fields

		'fields'     => array(
			
			array(
				'name'        => esc_html__( 'Config layout for this page', 'snshadona' ),
				'id'          => "{$prefix}enablelayoutconfig",
				'type'    => 'radio',
				'options' => array(
					'1' => esc_html__( 'Yes', 'snshadona' ),
					'2' => esc_html__( 'No', 'snshadona' ),
				),
				'std'         => '2',
				'desc'		  => esc_html__( 'Sellect Yes if you want config layout for this page', 'snshadona' ),
			),
			// Layout Type
			array(
				'name'        => esc_html__( 'Layout Type', 'snshadona' ),
				'id'          => "{$prefix}layouttype",
				'type'        => 'layouttype',
				// Array of 'value' => 'Label' pairs for select box
				'options'     => array(
					'm' => esc_html__( 'Without Sidebar', 'snshadona' ),
					'l-m' => esc_html__( 'Use Left Sidebar', 'snshadona' ),
					'm-r' => esc_html__( 'Use Right Sidebar', 'snshadona' ),
					//'l-m-r' => esc_html__( 'Use Left & Right Sidebar', 'snshadona' ),
				),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => $default_layout,
				'placeholder' => esc_html__( '--- Select a layout type ---', 'snshadona' ),
			),
			// Left Sidebar
			array(
				'name'  => esc_html__( 'Left Sidebar', 'snshadona' ),
				'id'    => "{$prefix}leftsidebar",
				//'desc'  => esc_html__( 'Text description', 'snshadona' ),
				'type'  => 'select',
				'options'	=> $siderbars,
				'multiple'	=> false,
				'std'		=> 'left-sidebar',
				'placeholder' => esc_html__( '--- Select a sidebar ---', 'snshadona' ),
			),
			// Right Sidebar
			array(
				'name'  => esc_html__( 'Right Sidebar', 'snshadona' ),
				'id'    => "{$prefix}rightsidebar",
				//'desc'  => esc_html__( 'Text description', 'snshadona' ),
				'type'  => 'select',
				'options'	=> $siderbars,
				'multiple'	=> false,
				'std'		=> 'right-sidebar',
				'placeholder' => esc_html__( '--- Select a sidebar ---', 'snshadona' ),
			),
			
		)
	);
	
	$menus = get_terms('nav_menu', array( 'hide_empty' => false ));
	$menu_options[''] = __('Default Menu...', 'snshadona');
	foreach ( $menus as $menu ){
		$menu_options[$menu->term_id] = $menu->name;
	}
	
	// Page config
	$meta_boxes[] = array(
		// Meta box id, UNIQUE per meta box. Optional since 4.1.5
		'id'         => 'sns_pageconfig',
		// Meta box title - Will appear at the drag and drop handle bar. Required.
		'title'      => esc_html__( 'Page Config', 'snshadona' ),
		// Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
		'post_types' => array( 'page' ),
		// Where the meta box appear: normal (default), advanced, side. Optional.
		'context'    => 'normal',
		// Order of meta box: high (default), low. Optional.
		'priority'   => 'high',
		// Auto save: true, false (default). Optional.
		// 'autosave'   => true,
		// List of meta fields

		'fields'     => array(
			array(
				'name'    => esc_html__( 'Header Style', 'snshadona' ),
				'id'       => "{$prefix}header_style",
				'type'     => 'select',
				'std'  => '',
				'options'  => array(
					'solid'  => esc_html__( 'Solid', 'snshadona' ),
					'transparent'  => esc_html__( 'Transparent', 'snshadona' ),
				),
				//'desc'		=> esc_html__('Select Header style. ', 'snshadona'),
			),
			array(
				'name'    => esc_html__( 'Show Top Policy', 'snshadona' ),
				'id'       => "{$prefix}top_policy",
				'type'     => 'radio',
				'options' => array(
					'1' => esc_html__( 'Yes', 'snshadona' ),
					'2' => esc_html__( 'No', 'snshadona' ),
				),
				'std'         => '1',
			),
			array(
				'name'    => esc_html__( 'Use extran screen', 'snshadona' ),
				'id'       => "{$prefix}use_fullwidth",
				'type'     => 'radio',
				'options' => array(
					'1' => esc_html__( 'Yes', 'snshadona' ),
					'2' => esc_html__( 'No', 'snshadona' ),
				),
				'std'         => '1',
				'desc'		=> esc_html__('Select yes if you want to content full-screen', 'snshadona'),
			),
			 array(
			 	'name'    => esc_html__( 'Logo', 'snshadona' ),
			 	'id'       => "{$prefix}header_logo",
		       'type'    => 'image_advanced',
		        'default'	=> '',
		        'desc' => esc_html__( 'It priority more in theme option', 'snshadona' ),	
		    ),
			 array(
				'name' => esc_html__( 'Show Menu', 'snshadona' ),
				'id'   => "{$prefix}enable_menu",
				'type'    => 'radio',
				'options' => array(
					'1' => esc_html__( 'Yes', 'snshadona' ),
					'0' => esc_html__( 'No', 'snshadona' ),
				),
				'std'         => '1',
			),

			array(
				'name'    => esc_html__( 'Show Title', 'snshadona' ),
				'id'      => "{$prefix}showtitle",
				'type'    => 'radio',
				'options' => array(
					'1' => esc_html__( 'Yes', 'snshadona' ),
					'2' => esc_html__( 'No', 'snshadona' ),
				),
				'std'         => '1',
			),
			array(
				'name'    => esc_html__( 'Use Slideshow', 'snshadona' ),
				'id'      => "{$prefix}useslideshow",
				'type'    => 'radio',
				'options' => array(
					'1' => esc_html__( 'Yes', 'snshadona' ),
					'2' => esc_html__( 'No', 'snshadona' ),
				),
				'std'         => '2',
			),
			array(
				'name'    => esc_html__( 'Select Slideshow', 'snshadona' ),
				'id'      => "{$prefix}revolutionslider",
				'type'    => 'select',
				'options' =>  $revsliders ,
				'std'         => '',
			),
			array(
				'name'    => esc_html__( 'Show Breadcrumbs', 'snshadona' ),
				'id'      => "{$prefix}showbreadcrump",
				'type'    => 'radio',
				'options' => array(
					'1' => esc_html__( 'Yes', 'snshadona' ),
					'2' => esc_html__( 'No', 'snshadona' ),
				),
				'std'         => '1',
				'desc' => esc_html__( 'Dont apply for Front page. Because breadcrumbs dont sense in Front page.', 'snshadona' ),
			),
			array(
				'name'    => esc_html__( 'Use Footer Top', 'snshadona' ),
				'id'       => "{$prefix}use_footer_top",
				'type'     => 'radio',
				'options' => array(
					'1' => esc_html__( 'Yes', 'snshadona' ),
					'2' => esc_html__( 'No', 'snshadona' ),
				),
				'std'         => '1',
			),
			array(
				'name' => esc_html__( 'Body Background', 'snshadona' ),
				'id'   => "{$prefix}body_bg_color",
				'type' => 'color',
				'desc' => esc_html__( 'It will priority than Theme Color in Theme Option panel', 'snshadona' ),
			),
			array(
				'name'    => esc_html__( 'Config Theme Color for this page?', 'snshadona' ),
				'id'      => "{$prefix}page_themecolor",
				'type'    => 'radio',
				'options' => array(
					'1' => esc_html__( 'Yes', 'snshadona' ),
					'2' => esc_html__( 'No', 'snshadona' ),
				),
				'std'         => '2',
			),
			array(
				'name' => esc_html__( 'Sellect Theme Color', 'snshadona' ),
				'id'   => "{$prefix}theme_color",
				'type' => 'color',
				'desc' => esc_html__( 'It will priority than Theme Color in Theme Option panel', 'snshadona' ),
			),
		)
	);
	// Post format - Gallery
	$meta_boxes[] = array(
	    	'id' => 'sns-post-gallery',
		    'title' =>  esc_html__('Gallery Settings','snshadona'),
	    	'description' => '',
    		'pages'      => array( 'post' ), // Post type
	    	'context'    => 'normal',
		    'priority'   => 'high',
	    	'fields' => array(
			     array(
			        'name'		=> 'Gallery Images',
			        'desc'	    => 'Upload Images for post Gallery ( Limit is 15 Images ).',
			        'type'      => 'image_advanced',
			        'id'	    => "{$prefix}post_gallery",
	         		'max_file_uploads' => 15 
	        	)
			)
	);
	// Post format - Video
    $meta_boxes[] = array(
		'id' => 'sns-post-video',
		'title' => esc_html__('Featured Video','snshadona'),
		'description' => '',
		'pages'      => array( 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'fields' => array( 
		    array(
				'id'    => "{$prefix}post_video",
				'name'  => esc_html__( 'Video', 'snshadona' ),
				'type'  => 'oembed',
				// Allow to clone? Default is false
				'clone' => false,
				// Input size
				'size'  => 50,
			)
		)
	);
	// Post format - Audio
    $meta_boxes[] = array(
		'id' => 'sns-post-audio',
		'title' => esc_html__('Featured Audio','snshadona'),
		'description' => '',
		'pages'      => array( 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'fields' => array( 
		    array(
				'id'    => "{$prefix}post_audio",
				'name'  => esc_html__( 'Audio', 'snshadona' ),
				'type'  => 'oembed',
				// Allow to clone? Default is false
				'clone' => false,
				// Input size
				'size'  => 50,
			)
		)
	);
	// Post format - quote
    $meta_boxes[] = array(
		'id' => 'sns-post-quote',
		'title' => esc_html__('Featured Quote','snshadona'),
		'description' => '',
		'pages'      => array( 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'fields' => array( 
		    array(
				'id'    => "{$prefix}post_quotecontent",
				'name'  => esc_html__( 'Quote Content', 'snshadona' ),
				'type'  => 'textarea',
				// Allow to clone? Default is false
				'clone' => false,
			),
			array(
				'id'      => "{$prefix}post_quoteauthor",
				'name'    => esc_html__( 'Quote author', 'snshadona' ),
				'type'    => 'text',
				'clone' => false,
			),
			array(
				'id'      => "{$prefix}post_quote_bg",
				'name'    => esc_html__( 'Quote Background Color', 'snshadona' ),
				'type'    => 'color',
				'std'         => '#ffffff',
			),
			array(
				'id'      => "{$prefix}post_quote_color",
				'name'    => esc_html__( 'Quote Text Color', 'snshadona' ),
				'type'    => 'color',
				'std'         => '#888888',
			),
			array(
				'id'      => "{$prefix}post_quote_size",
				'name'    => esc_html__( 'Quote Text Size', 'snshadona' ),
				'type'    => 'text',
				'std'         => '16px',
			),
			array(
				'id'      => "{$prefix}post_quote_font_weight",
				'name'    => esc_html__( 'Quote Text Weight', 'snshadona' ),
				'type'     => 'select',
				'std'  => '400',
				'options'  => array(
					'100'  => esc_html__( '100', 'snshadona' ),
					'200'  => esc_html__( '200', 'snshadona' ),
					'300'  => esc_html__( '300', 'snshadona' ),
					'400'  => esc_html__( '400', 'snshadona' ),
					'500'  => esc_html__( '500', 'snshadona' ),
					'600'  => esc_html__( '600', 'snshadona' ),
					'700'  => esc_html__( '700', 'snshadona' ),
					'900'  => esc_html__( '900', 'snshadona' ),
				),
			),
		)
	);
	// Post format - Link
    $meta_boxes[] = array(
		'id' => 'sns-post-link',
		'title' => esc_html__('Link Settings','snshadona'),
		'description' => '',
		'pages'      => array( 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'fields' => array( 
		    array(
				'id'    => "{$prefix}post_linkurl",
				'name'  => esc_html__( 'Link URL', 'snshadona' ),
				'type'  => 'text',
				// Allow to clone? Default is false
				'clone' => false,
			),
			array(
				'id'      => "{$prefix}post_linktitle",
				'name'    => esc_html__( 'Link Title', 'snshadona' ),
				'type'    => 'text',
				'clone' => false,
			),
		)
	);
	// Brand config
	$meta_boxes[] = array(
		'id'         => 'sns_brandconfig',
		'title'      => esc_html__( 'Brand Config', 'snshadona' ),
		'post_types' => array( 'brand' ),
		'context'    => 'normal',
		'priority'   => 'high',
		'fields'     => array(
			array(
				'name'    => esc_html__( 'Link for brand', 'snshadona' ),
				'id'      => "{$prefix}brandlink",
				'type'    => 'text'
			),
		)
	);
	// Partner config
	$meta_boxes[] = array(
		'id'         => 'sns_partnerconfig',
		'title'      => esc_html__( 'Partner Config', 'snshadona' ),
		'post_types' => array( 'partner' ),
		'context'    => 'normal',
		'priority'   => 'high',
		'fields'     => array(
			array(
				'name'    => esc_html__( 'Link for partner', 'snshadona' ),
				'id'      => "{$prefix}partnerlink",
				'type'    => 'text'
			),
		)
	);

	return $meta_boxes;
}


if ( class_exists( 'RWMB_Field' ) ) {
	class RWMB_Layouttype_Field extends RWMB_Select_Field {
		static function admin_enqueue_scripts(){
			wp_enqueue_style( 'sns-imgselect', SNSHADONA_THEME_URI . '/framework/meta-box/img-select.css' );
		}
	}
}
