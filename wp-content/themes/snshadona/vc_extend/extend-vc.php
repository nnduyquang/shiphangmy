<?php
$vc_add_css_animation = array(
	'type' => 'dropdown',
	'heading' => esc_html__( 'CSS Animation', 'snshadona' ),
	'param_name' => 'css_animation',
	'admin_label' => true,
	'value' => array(
		esc_html__( 'No', 'snshadona' ) => '',
		esc_html__( 'Top to bottom', 'snshadona' ) => 'top-to-bottom',
		esc_html__( 'Bottom to top', 'snshadona' ) => 'bottom-to-top',
		esc_html__( 'Left to right', 'snshadona' ) => 'left-to-right',
		esc_html__( 'Right to left', 'snshadona' ) => 'right-to-left',
		esc_html__( 'Appear from center', 'snshadona' ) => 'appear'
	),
	'description' => esc_html__( 'Select type of animation for element to be animated when it "enters" the browsers viewport (Note: works only in modern browsers).', 'snshadona' )
);
$sns_extra_class =array(
			"type" => "textfield",
			"heading" => esc_html__("Extra class name", 'snshadona'),
			"param_name" => "extra_class"
		);

global $wpdb;
// Get category name
$sql = $wpdb->prepare( "
	SELECT a.name,a.slug,a.term_id 
	FROM {$wpdb->terms} a JOIN  {$wpdb->term_taxonomy} b ON (a.term_id= b.term_id ) 
	WHERE b.count> %d and b.taxonomy = %s",
	0,'category' );
$results = $wpdb->get_results($sql);
$cat_value = array();
foreach ($results as $cat) {
	$cat_value[$cat->name] = $cat->slug;
}

// BEGIN: Shortcodes for Woo
if(class_exists('WooCommerce')){
	// Get woo category name
	$sql = $wpdb->prepare( "
		SELECT a.name,a.slug,a.term_id 
		FROM {$wpdb->terms} a JOIN  {$wpdb->term_taxonomy} b ON (a.term_id= b.term_id ) 
		WHERE b.count> %d and b.taxonomy = %s",
		0,'product_cat' );
	$results = $wpdb->get_results($sql);
	$woocat_value = array();
	//$woocat_value[esc_html__('--Select--', 'snshadona')] = '';
	foreach ($results as $cat) {
		$woocat_value[$cat->name] = $cat->slug;
	}

	function sns_woo_get_product_list($product_type = false){
		global $woocommerce;
	    $product_list =  array();
	    $product_list[esc_html__('--Select--', 'snshadona')] = '';

	    $args = array(
	        'posts_per_page'     => -1,
	        'post_status'          => 'publish',
	        'post_type'          => 'product',
	        'order'              => 'DESC',
	    );

	    switch ($product_type) {
	    	case 'on_sale':
	    		$args['meta_query'] = array();
		        $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
		        $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
		        $args['post__in'] = wc_get_product_ids_on_sale();
	    		break;
	    	case 'variable':

	    		break;
	    	default:
	    		break;
	    }

	    $products = get_posts( $args );
	    foreach ($products as $product) {
	    	if($product_type == 'variable'){
	    		$get_product = new WC_Product($product->ID);
	    		if( $get_product->is_type('variable') ){
	    			$product_list[$product->post_title] = $product->ID;
	    		}
	    	}else{
	    		$product_list[$product->post_title] = $product->ID;
	    	}
	    }

	    return $product_list;
	}

	$product_list = sns_woo_get_product_list(false);
	$product_onsale = sns_woo_get_product_list('on_sale');

	/*
	 * Product list
	 */
	$params_script = SNSHADONA_THEME_URI . '/admin/assets/js/params.js';
	vc_add_shortcode_param('sns_woo_products', 'sns_woo_settings_products', $params_script);
	function sns_woo_settings_products( $settings,  $value, $dependency=''){
	    $args = array(
	        'posts_per_page'     => -1,
	        'post_status'          => 'publish',
	        'post_type'          => 'product',
	        'order'              => 'DESC',
	    );
	     $products = get_posts( $args );


		$product_ids = explode(',', $value);

		$output = '<select '.$dependency.' id="'.$settings['param_name'].'" multiple="multiple" class="sns-woo-select chosen_select_nostd">';
		$output .= '<option value="">'. esc_html__('-- Select -- ', 'snshadona') . '</option>';
		if( !empty($products) ){
			foreach ($products as $product){
				//var_dump($products);
				$output .= '<option value="'. esc_attr($product->ID) .'"' . selected( in_array($product->ID, $product_ids), true, false ) . '>' . esc_html( $product->post_title ) . '</option>';
			}
		}
		$output .= '</select>';
		$output .= '<input type="hidden" id="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-textinput" name="'.$settings['param_name'].'" value="'.$value.'"/>';
		
		return $output;
	}

	/*
	 * SNS create new param type
	 */
	$params_script = SNSHADONA_THEME_URI . '/admin/assets/js/params.js';

	vc_add_shortcode_param('sns_woo_categories', 'sns_woo_settings_categories', $params_script);
	function sns_woo_settings_categories( $settings,  $value, $dependency=''){
		$catgory_ids = explode(',', $value);
		$args = array(
			'orderby' => 'name',
			'hide_empty' => 0,
		);
		$categories = get_terms('product_cat', $args);
		$output = '<select '.$dependency.' id="'.$settings['param_name'].'" multiple="multiple" class="sns-woo-select chosen_select_nostd">';
		$output .= '<option value="">'. esc_html__('-- Select -- ', 'snshadona') . '</option>';
		if( !empty($categories) ){
			foreach ($categories as $cat){
				$output .= '<option value="'. esc_attr($cat->slug) .'"' . selected( in_array($cat->slug, $catgory_ids), true, false ) . '>' . esc_html( $cat->name ) . '</option>';
			}
		}
		$output .= '</select>';
		$output .= '<input type="hidden" id="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-textinput" name="'.$settings['param_name'].'" value="'.$value.'"/>';
		
		return $output;
	}

	class WPBakeryShortCode_SNS_Featured_Categories extends WPBakeryShortCode {
		public function snshadona_getListTabTitle(){
			$this->atts = vc_map_get_attributes( $this->getShortcode(), $this->atts );
			$array_tab = array();	
			$array_tab = explode(',', $this->atts['list_cat']);
			foreach ($array_tab as $tab) {
				$list_tab[$tab] = $this->snshadona_tabTitle($tab);
			}
			return $list_tab;
		}
		public function snshadona_tabTitle($tab){
				$cat = get_term_by('slug', $tab, 'product_cat');		
				$image = '';
				$thumbnail_id = get_woocommerce_term_meta($cat->term_id, 'thumbnail_id', true);
				if($thumbnail_id == '')
					$thumbnail_id = get_woocommerce_term_meta($cat->term_id, 'snscustom_product_cat_thumbnail_id', true);
					
				$cat_thumb = wp_get_attachment_image_src($thumbnail_id, 'snshadona_product_tabs_thumbnail');

				$image = isset($cat_thumb[0]) ? $cat_thumb[0] : wc_placeholder_img_src();
				return array('name'=>str_replace(' ', '_', $tab),'title'=>$cat->name,'id'=>$cat->term_id,'short_title'=>$cat->name,'thumbnail' => $image);
		}	
	}
		
	vc_map( array(
		"name" => esc_html__("SNS Featured Categories",'snshadona'),
		"base" => "sns_featured_categories",
		"icon" => "sns_icon_featured_categories",
		"class" => "sns_featured_categories",
		"category" => esc_html__("SNS WooCommerce",'snshadona'),
		"description" => esc_html__( "WooCommerce featured categories", 'snshadona' ),
		"params" => array(	
		    array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("The title",'snshadona'),
				"param_name" => "title",
				"admin_label" => true,
				"value" =>  esc_html__("", 'snshadona'),
			),
			array(
				"type" => "sns_woo_categories",
				"class" => "",
				"heading" => esc_html__("Select Category",'snshadona'),
				"param_name" => "list_cat",
				"description" => "",
			),

		    $vc_add_css_animation,
		    $sns_extra_class,
		)
	) );
	class WPBakeryShortCode_SNS_Products extends WPBakeryShortCode {}

	vc_map( array(
		"name" => esc_html__("SNS Products",'snshadona'),
		"base" => "sns_products",
		"icon" => "sns_icon_products",
		"class" => "sns_products",
		"category" => esc_html__("SNS WooCommerce",'snshadona'),
		"description" => esc_html__( "WooCommerce products",'snshadona' ),
		"params" => array(
			array(
				"type" => "textfield",
				"class" => "",
				"value" => "",		
				"heading" => esc_html__("Prefix", 'snshadona'),
				"param_name" => "prefix" 
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Title",'snshadona'),
				"param_name" => "title",
				"admin_label" => true,
				"value" =>  esc_html__("New Products", 'snshadona'),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Type",'snshadona'),
				"param_name" => "type",
				"value" => array(
					esc_html__('Latest Products', 'snshadona') => "recent",
					esc_html__('BestSeller Products', 'snshadona') => "best_selling",
					esc_html__('Top Rated Products', 'snshadona') => "top_rate",
					esc_html__('Special Products', 'snshadona') => "on_sale",
					esc_html__('Featured Products', 'snshadona') => "featured_product",
					esc_html__('Recent Review', 'snshadona') => "recent_review",
				),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Template",'snshadona'),
				"param_name" => "template",
				"admin_label" => true,
				"value" => array(
					esc_html__("Carousel",'snshadona') => '1',
					esc_html__("List",'snshadona') => '2',
				),
				"description" => esc_html__("Select template.", 'snshadona')
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Show Count Sale",'snshadona'),
				"param_name" => "show_countdown",
				"value" => array(
					esc_html__("Yes",'snshadona') => 'yes',
					esc_html__("No",'snshadona') => 'no',
				),
				'dependency' => array(
					'element' => 'template',
					'value' => '1',
				),
			),
			
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Product number display screen width > 480px","snshadona"),
				"param_name" => "number_display_480",
				"dependency" => array("element" => "template" , "value" => "1" ),
				"value" => "2"
			),

			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Product number display screen > 768px","snshadona"),
				"param_name" => "number_display_768",
				"dependency" => array("element" => "template" , "value" => "1" ),
				"value" => "3"
			),

			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Product number display screen > 992px","snshadona"),
				"param_name" => "number_display_992",
				"dependency" => array("element" => "template" , "value" => "1" ),
				"value" => "3"
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Product number display screen > 1200px","snshadona"),
				"param_name" => "number_display_1200",
				"dependency" => array("element" => "template" , "value" => "1" ),
				"value" => "4"
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Product number display screen > 1600px","snshadona"),
				"param_name" => "number_display_1600",
				"dependency" => array("element" => "template" , "value" => "1" ),
				"value" => "6"
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Product number limit",'snshadona'),
				"param_name" => "number_limit",
				"value" => "10",
			),
			$vc_add_css_animation,
			$sns_extra_class,
			
		)
	) );

	class WPBakeryShortCode_SNS_Product_Tabs extends WPBakeryShortCode {
		public function snshadona_getListTabTitle(){
			$this->atts = vc_map_get_attributes( $this->getShortcode(), $this->atts );
			$array_tab = array();
			if ( $this->atts['tab_types'] == 'category' ) :
				if( empty($this->atts['list_product']) ) :
					$array_tab = $this->snshadona_getCats();
				else :
					$array_tab = explode(',', $this->atts['list_product']);
				endif;
				//var_dump($array_tab);
			else :
				$array_tab = explode(',', $this->atts['list_orderby']);
			endif;
			foreach ($array_tab as $tab) {
				$list_tab[$tab] = $this->snshadona_tabTitle($tab, $this->atts['tab_types'], $this->atts['cat_thumbnail']);
			}
			return $list_tab;
		}

		public function snshadona_tabTitle($tab, $tab_types,$show_cat_thumbnail){
			if( $tab_types == 'category' ){
				$cat = get_term_by('slug', $tab, 'product_cat');
				
				$image = '';
				if( $show_cat_thumbnail == 'show' ){
					$thumbnail_id = get_woocommerce_term_meta($cat->term_id, 'thumbnail_id', true);
					if($thumbnail_id == '')
						$thumbnail_id = get_woocommerce_term_meta($cat->term_id, 'snscustom_product_cat_thumbnail_id', true);
						
					$cat_thumb = wp_get_attachment_image_src($thumbnail_id, 'snshadona_product_tabs_thumbnail');

					$image = isset($cat_thumb[0]) ? $cat_thumb[0] : wc_placeholder_img_src();
				}
				return array('name'=>str_replace(' ', '_', $tab),'title'=>$cat->name,'short_title'=>$cat->name,'thumbnail' => $image);
			}else{
				switch ($tab) {
					case 'recent':
						return array('name'=>$tab,'title'=>esc_html__('Latest Products','snshadona'),'short_title'=>esc_html__('Latest Products','snshadona'));
					case 'featured_product':
						return array('name'=>$tab,'title'=>esc_html__('Featured Products','snshadona'),'short_title'=>esc_html__('Featured Products','snshadona'));
					case 'top_rate':
						return array('name'=>$tab,'title'=> esc_html__('Top Rated Products','snshadona'),'short_title'=>esc_html__('Top Rated', 'snshadona'));
					case 'best_selling':
						return array('name'=>$tab,'title'=>esc_html__('BestSeller Products','snshadona'),'short_title'=>esc_html__('Best Seller','snshadona'));
					case 'on_sale':
						return array('name'=>$tab,'title'=>esc_html__('Special Products','snshadona'),'short_title'=>esc_html__('Special Products','snshadona'));
				}
			}
		}
		public function snshadona_getCats(){
			$cats = get_terms('product_cat');
			$arr = array();
			foreach ($cats as $cat) {
				$arr[] = $cat->slug;
			}
			return $arr;
		}
	}

	vc_map( array(
		"name" => esc_html__("SNS Product Tabs",'snshadona'),
		"base" => "sns_product_tabs",
		"icon" => "sns_icon_product_tabs",
		"class" => "sns_product_tabs",
		"category" => esc_html__("SNS WooCommerce",'snshadona'),
		"description" => esc_html__( "WooCommerce product tabs", 'snshadona' ),
		"params" => array(
			array(
				"type" => "textfield",
				"class" => "",
				"value" => "",		
				"heading" => esc_html__("Prefix", 'snshadona'),
				"param_name" => "prefix" 
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Title",'snshadona'),
				"param_name" => "title",
				"admin_label" => true,
				"value" => esc_html__("New Products",'snshadona'),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Template",'snshadona'),
				"param_name" => "template",
				"value" => array(
					esc_html__("Grid",'snshadona') => "grid",
					esc_html__("Carousel",'snshadona') =>  "carousel"
				),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Align header",'snshadona'),
				"param_name" => "align_header",
				"value" => array(
					esc_html__('Center', 'snshadona') => "center",
					esc_html__('Left', 'snshadona') => "left",
					esc_html__('Right', 'snshadona') => "right",
				),
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Tab types",'snshadona'),
				"param_name" => "tab_types",
				"value" => array(
					esc_html__('Categories', 'snshadona') => "category",
					esc_html__('Order By', 'snshadona') =>  "orderby"
				),
				"description" => ""
			),
			array(
				"type" => "checkbox",
				"class" => "",
				"value" => $woocat_value,
				"heading" => esc_html__("Select Category",'snshadona'),
				"param_name" => "list_cat",
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Order By for all tab",'snshadona'),
				"param_name" => "orderby",
				"value" => array(
					esc_html__('Latest Products', 'snshadona') => "recent",
					esc_html__('BestSeller Products', 'snshadona') => "best_selling",
					esc_html__('Top Rated Products', 'snshadona') => "top_rate",
					esc_html__('Special Products', 'snshadona') => "on_sale",
					esc_html__('Featured Products', 'snshadona') => "featured_product",
					esc_html__('Recent Review', 'snshadona') => "recent_review",
				),
				"dependency" => array("element" => "tab_types" , "value" => "category" ),
				"description" => ""
			),
			array(
				"type" => "checkbox",
				"class" => "",
				"heading" => esc_html__("Select Order By",'snshadona'),
				"param_name" => "list_orderby",
				"value" => array(
					esc_html__('Latest Products', 'snshadona') => "recent",
					esc_html__('BestSeller Products', 'snshadona') => "best_selling",
					esc_html__('Top Rated Products', 'snshadona') => "top_rate",
					esc_html__('Special Products', 'snshadona') => "on_sale",
					esc_html__('Featured Products', 'snshadona') => "featured_product",
					esc_html__('Recent Review', 'snshadona') => "recent_review",
				),
				"dependency" => array("element" => "tab_types" , "value" => "orderby" ),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Category Thumbnail","snshadona"),
				"param_name" => "cat_thumbnail",
				"value" => array(
					 esc_html__("show","snshadona") =>  "show",
					 esc_html__("hide","snshadona") =>  "hide",
				),
				 //"dependency" => array("element" => "tab_types" , "value" => "category" ),
				"description" => esc_html__("Display Category Title with Tab types is Categories.","snshadona")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Number Category Thumbnail display screen > 1200px ",'snshadona'),
				"param_name" => "number_thumbnail",
				"dependency" => array("element" => "cat_thumbnail" , "value" => "show" ),
				"value" => "8"
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Row",'snshadona'),
				"param_name" => "row",
				"dependency" => array("element" => "template" , "value" => "grid" ),
				"value" => "2"
			),


			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Show button load more",'snshadona'),
				"dependency" => array("element" => "template" , "value" => "grid" ),
				"param_name" => "show_button",
				"value" => array(
					"Yes" => '1',
					"No" =>  '2',
				),
			),

			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Column per Row",'snshadona'),
				"param_name" => "col",
				"dependency" => array("element" => "template" , "value" => "grid" ),
				"value" => "4"
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Number product with each click to Load more button",'snshadona'),
				"param_name" => "number_load",
				"dependency" => array("element" => "template" , "value" => "grid" ),
				"value" => "4"
			),
			array(
				"type" => "checkbox",
				"value" => true,
				"class" => "",
				"heading" => esc_html__("Hidden item box",'snshadona'),
				"param_name" => "hidde_item_box"	
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => esc_html__("Effect for product when click to Load more button",'snshadona'),
				"param_name" => "effect_load",
				"value" => array(
					esc_html__('zoomOut', 'snshadona') => "zoomOut",
					esc_html__('zoomIn', 'snshadona') => "zoomIn",
					esc_html__('pageRight', 'snshadona') => "pageRight",
					esc_html__('pageLeft', 'snshadona') => "pageLeft",
					esc_html__('pageTop', 'snshadona') => "pageTop",
					esc_html__('pageBottom', 'snshadona') => "pageBottom",
					esc_html__('starwars', 'snshadona') => "starwars",
					esc_html__('slideBottom', 'snshadona') => "slideBottom",
					esc_html__('slideLeft', 'snshadona') => "slideLeft",
					esc_html__('slideRight', 'snshadona') => "slideRight",
					esc_html__('bounceIn', 'snshadona') => "bounceIn",
				),
				"dependency" => array("element" => "template" , "value" => "grid" ),
				"description" => ""
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Product number limit",'snshadona'),
				"param_name" => "number_limit",
				"dependency" => array("element" => "template" , "value" => "carousel" ),
				"value" => "10"
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Product number display screen width > 480px","snshadona"),
				"param_name" => "number_display_480",
				"dependency" => array("element" => "template" , "value" => "carousel" ),
				"value" => "2"
			),

			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Product number display screen > 768px","snshadona"),
				"param_name" => "number_display_768",
				"dependency" => array("element" => "template" , "value" => "carousel" ),
				"value" => "3"
			),

			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Product number display screen > 992px","snshadona"),
				"param_name" => "number_display_992",
				"dependency" => array("element" => "template" , "value" => "carousel" ),
				"value" => "3"
			),

			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Product number display screen > 1200px","snshadona"),
				"param_name" => "number_display_1200",
				"dependency" => array("element" => "template" , "value" => "carousel" ),
				"value" => "4"
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => esc_html__("Product number display screen > 1600px","snshadona"),
				"param_name" => "number_display_1600",
				"dependency" => array("element" => "template" , "value" => "carousel" ),
				"value" => "6"
			),
			$vc_add_css_animation,
			$sns_extra_class,
			
		)
	) );

	class WPBakeryShortCode_SNS_Onsale_Product extends WPBakeryShortCode {}
	vc_map( array(
			"name" => esc_html__("SNS On sale Products",'snshadona'),
			"base" => "sns_onsale_product",
			"icon" => "sns_icon_onsale_product",
			"class" => "sns_onsale_product",
			"category" => esc_html__("SNS WooCommerce",'snshadona'),
			"description" => esc_html__( "show two onsale products", 'snshadona' ),
			"params" => array(
					array(
						"type" => "textfield",
						"value" => esc_html__("perfect product for you", 'snshadona'),	
						"heading" => esc_html__("Title", 'snshadona'),
						"param_name" => "title" 
					),

					array(
						"type" => "colorpicker",
						"value" => "#ffffff",
						"heading" => esc_html__("Background color", 'snshadona'),
						"param_name" => "background_color"
				    ),
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => esc_html__("The first product",'snshadona'),
						"param_name" => "product",
						"description" => "",
						"value" => $product_onsale,			
					),
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => esc_html__("Second product",'snshadona'),
						"param_name" => "product2",
						"description" => esc_html__("select product discounts here",'snshadona'),
						"value" => $product_onsale,			
					),	
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => esc_html__("Excerpt length",'snshadona'),
						"param_name" => "excerpt_lenght",
						"value" => "20"
					),
				$vc_add_css_animation,
				$sns_extra_class,
			)
	) );

	class WPBakeryShortCode_SNS_Product extends WPBakeryShortCode {}
	vc_map( array(
			"name" => esc_html__("SNS Product",'snshadona'),
			"base" => "sns_product",
			"icon" => "sns_icon_product",
			"class" => "sns_product",
			"category" => esc_html__("SNS WooCommerce",'snshadona'),
			"description" => esc_html__( "Show a single product", 'snshadona' ),
			"params" => array(
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => esc_html__("Select product",'snshadona'),
						"param_name" => "id",
						"value" => $product_list,
					),
				$vc_add_css_animation,
				$sns_extra_class,
			)
	) );

	// SNS select category
	class WPBakeryShortCode_SNS_Category extends WPBakeryShortCode {
		public function category($tab, $tab_types, $cat_thumb_class){
			$cat = get_term_by('slug', $tab, 'product_cat');
			
				return array('name'=>str_replace(' ', '_', $tab),'title'=>$cat->name,'short_title'=>$cat->name, 'thumbnail' => $image, 'icon' => $icon);
		}
	}

	vc_map( array(
		"name" => esc_html__("SNS Category",'snshadona'),
		"base" => "sns_category",
		"class" => "sns_category",
		"category" => esc_html__("SNS WooCommerce",'snshadona'),
		"description" => esc_html__( "WooCommerce category",'snshadona' ),
		"params" => array(
			array(
		      "type" => "attach_image",
		      "heading" => esc_html__("Image", 'snshadona'),
		      "param_name" => "image" 
		    ),
		     array(
				"type" => "textfield",
				"heading" => esc_html__("Image title",'snshadona'),
				"param_name" => "img_title",
				"value" => ""
			),
			array(
				"type" => "dropdown",
				"value" => Array( 	
							"left" => "left" ,
							"right" => "right" 
				),
				"heading" => esc_html__("Image alignment", 'snshadona'),
				"param_name" => "image_alignment" 
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"value" => $woocat_value,
				"heading" => esc_html__("Select Category",'snshadona'),
				"param_name" => "category",
				"description" => ""
			),
			 array(
		      	"type" => "textarea_html",
		      	"heading" => esc_html__("Short description", 'snshadona'),
		     	 "param_name" => "content",
		    ),
			array(
				"type" => "sns_woo_products",
				"class" => "",
				"heading" => esc_html__("Select Products",'snshadona'),
				"param_name" => "list_product",
				"description" => "",
			),
			
			
			$vc_add_css_animation,
			$sns_extra_class,
			
		)
	));

}
// END: Shortcodes for Woo

// SNS Custom Box
class WPBakeryShortCode_SNS_Custom_Box extends WPBakeryShortCode {}
vc_map( array(
	"name"  => esc_html__("SNS Custom Box", 'snshadona'),
	"base" => "sns_custom_box",
	"show_settings_on_create" => true ,
	"is_container" => false ,
	"icon" => "vc_icon_snstheme",
	"class" => "vc_icon_snstheme",
	"content_element" => true ,
	"category" => esc_html__('Content', 'snshadona'),
	'description' => esc_html__( 'Box contain: icon, title, description', 'snshadona' ),
  //  "as_child" => array('only' => 'sns_featured_categories'), // Use only|except attributes to limit parent (separate multiple values with comma)
	"params" => array(		
	    array(
			"type" => "dropdown",
			'value' => array(
				esc_html__( 'Style 1', 'snshadona' ) => 'style1',
				esc_html__( 'Style 2', 'snshadona' ) => 'style2',
				esc_html__( 'Style 3', 'snshadona' ) => 'style3',
			),
			"heading" => esc_html__("Template", 'snshadona'),
			"param_name" => "box_template"

	    ),

		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Icon library', 'snshadona' ),
			'value' => array(
				esc_html__( 'Media', 'snshadona' ) => 'media',
				esc_html__( 'Font Awesome', 'snshadona' ) => 'fontawesome',
				esc_html__( 'Open Iconic', 'snshadona' ) => 'openiconic',
				esc_html__( 'Typicons', 'snshadona' ) => 'typicons',
				esc_html__( 'Entypo', 'snshadona' ) => 'entypo',
				esc_html__( 'Linecons', 'snshadona' ) => 'linecons',
			),
			'param_name' => 'icon_type',
			'description' => esc_html__( 'Select icon library.', 'snshadona' ),
		),
		array(
	      "type" => "attach_image",
	      "heading" => esc_html__("Image", 'snshadona'),
	      "param_name" => "icon_image",
	      'dependency' => array(
				'element' => 'icon_type',
				'value' => 'media',
			),
	    ),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'snshadona' ),
			'param_name' => 'icon_fontawesome',
			'value' => 'fa fa-adjust', // default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false,
				'iconsPerPage' => 4000,
			),
			'dependency' => array(
				'element' => 'icon_type',
				'value' => 'fontawesome',
			),
			'description' => esc_html__( 'Select icon from library.', 'snshadona' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'snshadona' ),
			'param_name' => 'icon_openiconic',
			'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false, // default true, display an "EMPTY" icon?
				'type' => 'openiconic',
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'icon_type',
				'value' => 'openiconic',
			),
			'description' => esc_html__( 'Select icon from library.', 'snshadona' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'snshadona' ),
			'param_name' => 'icon_typicons',
			'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false, // default true, display an "EMPTY" icon?
				'type' => 'typicons',
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'icon_type',
				'value' => 'typicons',
			),
			'description' => esc_html__( 'Select icon from library.', 'snshadona' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'snshadona' ),
			'param_name' => 'icon_entypo',
			'value' => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false, // default true, display an "EMPTY" icon?
				'type' => 'entypo',
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'icon_type',
				'value' => 'entypo',
			),
		),
		array(
			'type' => 'iconpicker',
			'heading' => esc_html__( 'Icon', 'snshadona' ),
			'param_name' => 'icon_linecons',
			'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false, // default true, display an "EMPTY" icon?
				'type' => 'linecons',
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'icon_type',
				'value' => 'linecons',
			),
			'description' => esc_html__( 'Select icon from library.', 'snshadona' ),
		),
		array(
			"type" => "colorpicker",
			"value" => "",
			"heading" => esc_html__("Color for icon", 'snshadona'),
			'dependency' => array(
				'element' => 'icon_type',
				'value' => array('linecons','fontawesome','entypo','typicons','openiconic'),
			),
			"param_name" => "icon_color"

	    ),
		array(
			"type" => "colorpicker",
			"value" => "",
			"heading" => esc_html__("Background Color for icon", 'snshadona'),
			"param_name" => "icon_bgcolor"

	    ),
	   
		array(
			"type" => "textfield",
			"heading" => esc_html__("Font size for icon", 'snshadona'),
			"param_name" => "icon_font_size" ,
			"value" => esc_html__("25px",'snshadona'),
			'dependency' => array(
				'element' => 'icon_type',
				'value' => array('linecons','fontawesome','entypo','typicons','openiconic'),
			),
			"description" => esc_html__("It's font-size for icon you sellected, example: 24px", 'snshadona')
		),

		array(
			"type" => "textfield",
			"heading" => esc_html__("Custom Link", 'snshadona'),
			"param_name" => "link" ,
			"description" => esc_html__("Enter the  link. Do't forget to include http:// ", 'snshadona'),
			"value" => esc_html__("http://", 'snshadona')
		),
		array(
			"type" => "dropdown",
			'value' => array(
				esc_html__( 'Left', 'snshadona' ) => 'left',
				esc_html__( 'Right', 'snshadona' ) => 'right',
				esc_html__( 'Center', 'snshadona' ) => 'center',
			),
			"heading" => esc_html__("Text align", 'snshadona'),
			"param_name" => "text_align"

	    ),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Title", 'snshadona'),
			"param_name" => "title",
			"value" => esc_html__("Your Title Here ...",'snshadona'),
			"admin_label" => true 
		),
		array(
			"type" => "colorpicker",
			"heading" => esc_html__("Title color", 'snshadona'),
			"param_name" => "title_color",
			"value" => "",
		),
		array(
			"type" => "textarea",
			"heading" => esc_html__("Description", 'snshadona'),
			"param_name" => "desc"
		),

		array(
			"type" => "checkbox",
			"class" => "",
			"heading" => esc_html__("Show link",'snshadona'),
			"description" => esc_html__("read more",'snshadona'),
			"param_name" => "show_link"
		),
		$vc_add_css_animation,
		$sns_extra_class,
	)
));

class WPBakeryShortCode_SNS_Latest_Posts extends WPBakeryShortCode {}

vc_map( array(
	"name" => esc_html__("SNS Latest Posts",'snshadona'),
	"base" => "sns_latest_posts",
	"icon" => "sns_icon_latestpost",
	"class" => "sns_latestpost",
	"category" => esc_html__("Content",'snshadona'),
	"description" => esc_html__( "Show latest posts", 'snshadona' ),
	"params" => array(
		array(
			"type" => "textfield",
			"class" => "",
			"value" => esc_html__("New our blogs", 'snshadona'),
			"heading" => esc_html__("Prefix", 'snshadona'),
			"param_name" => "prefix" 
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Title",'snshadona'),
			"param_name" => "title",
			"value" =>  esc_html__("Latest News",'snshadona'),
			"admin_label" => true,
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Text Align",'snshadona'),
			"param_name" => "text_align",
			"value" => array(
				esc_html__("Left",'snshadona') =>  'left',
				esc_html__("Right",'snshadona') =>  'right',
				esc_html__("Center",'snshadona') => 'center',
			),
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Show date",'snshadona'),
			"param_name" => "show_date",
			"class" => "",
			"value" => array(
				esc_html__("Yes",'snshadona') => '1',
				esc_html__("No",'snshadona') =>  '2',
			),
		),
		array(
			"type" => "dropdown",
			"class" => "",		
			"value" => array(
				esc_html__("Yes",'snshadona') => '1',
				esc_html__("No",'snshadona') =>  '2',
			),
			"heading" => esc_html__("Show Author",'snshadona'),
			"param_name" => "show_author",
		),
		array(
			"type" => "dropdown",
			"class" => "",		
			"value" => array(
				esc_html__("Yes",'snshadona') => '1',
				esc_html__("No",'snshadona') =>  '2',
			),
			"heading" => esc_html__("Show buton read more",'snshadona'),
			"param_name" => "show_readmore",
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Posts number limit",'snshadona'),
			"param_name" => "number_limit",
			"value" => "12"
		),
		$vc_add_css_animation,
		$sns_extra_class,
	)
) );

/*
 * SNS create new param type
 */
$params_script = SNSHADONA_THEME_URI . '/admin/assets/js/params.js';
vc_add_shortcode_param('sns_woo_posts', 'sns_woo_settings_posts', $params_script);
function sns_woo_settings_posts( $settings,  $value, $dependency='' ){
	$post_ids = explode(',', $value);
	$args = array( 
		'posts_per_page'   => -1,
	 	'order'=> 'DESC',
	  	'orderby' => 'title'	  	
	  	 );
	$postslist = get_posts( $args );

	$output = '<select '.$dependency.' id="'.$settings['param_name'].'" multiple="multiple" class="sns-woo-select chosen_select_nostd">';
	$output .= '<option value="">'. esc_html__('-- Select -- ', 'snshadona') . '</option>';
	if( !empty($postslist) ){
		foreach ($postslist as $post){
			$output .= '<option value="'. esc_attr($post->ID) .'"' . selected( in_array($post->ID, $post_ids), true, false ) . '>' . esc_html($post->post_title ) . '</option>';
		}
	}
	$output .= '</select>';
	$output .= '<input type="hidden" id="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-textinput" name="'.$settings['param_name'].'" value="'.$value.'"/>';
	
	return $output;

}

class WPBakeryShortCode_SNS_Posts extends WPBakeryShortCode {}

vc_map( array(
	"name" => esc_html__("SNS Posts",'snshadona'),
	"base" => "sns_posts",
	"icon" => "sns_icon_post",
	"class" => "sns_post",
	"category" => esc_html__("Content",'snshadona'),
	"description" => esc_html__( "Show posts", 'snshadona' ),
	"params" => array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Title",'snshadona'),
			"param_name" => "title",
			"value" =>  esc_html__("",'snshadona'),
			"admin_label" => true,
		),
		array(
			"type" => "sns_woo_posts",
			"class" => "",
			"heading" => esc_html__("Select posts",'snshadona'),
			"param_name" => "list_post",
			"description" => "",
		),
		array(
			"type" => "dropdown",
			"heading" => esc_html__("Show date",'snshadona'),
			"param_name" => "show_date",
			"class" => "",
			"value" => array(
				esc_html__("Yes",'snshadona') => '1',
				esc_html__("No",'snshadona') =>  '2',
			),
		),
		array(
			"type" => "dropdown",
			"class" => "",		
			"value" => array(
				esc_html__("Yes",'snshadona') => '1',
				esc_html__("No",'snshadona') =>  '2',
			),
			"heading" => esc_html__("Show Author",'snshadona'),
			"param_name" => "show_author",
		),
		array(
			"type" => "dropdown",
			"class" => "",		
			"value" => array(
				esc_html__("Yes",'snshadona') => '1',
				esc_html__("No",'snshadona') =>  '2',
			),
			"heading" => esc_html__("Show buton read more",'snshadona'),
			"param_name" => "show_readmore",
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Posts number limit",'snshadona'),
			"param_name" => "number_limit",
			"value" => "12"
		),
		$vc_add_css_animation,
		$sns_extra_class,
	)
) );

class WPBakeryShortCode_SNS_Blog_Page extends WPBakeryShortCode {}

vc_map( array(
	"name" => esc_html__("SNS Blog Page",'snshadona'),
	"base" => "sns_blog_page",
	"icon" => "sns_icon_blogpage",
	"class" => "sns_blogpage",
	"category" => esc_html__("Content",'snshadona'),
	"description" => esc_html__( "To create blog page with some style", 'snshadona' ),
	"params" => array(
		array(
			"type" => "checkbox",
			"value" => $cat_value,
			"class" => "",
			"heading" => esc_html__("Categories",'snshadona'),
			"description" => esc_html__( "If you dont sellect category, the default is sellected all category", 'snshadona' ),
			"param_name" => "category"
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Blog Style",'snshadona'),
			"param_name" => "blog_type",
			"value" => array(
				esc_html__("Blog Layout 1",'snshadona') 	=> "",
				esc_html__("Blog Layout 2",'snshadona') 	=>  "layout2",
				esc_html__("Masonry",'snshadona')			=>  "masonry",
			),
			"description" => ""
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Post per pages",'snshadona'),
			"param_name" => "posts_per_page",
			"value" => "6"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Excerpt Length",'snshadona'),
			"param_name" => "excerpt_length",
			"value" => "35"
		),

		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Enable Read More Button",'snshadona'),
			"param_name" => "show_readmore",
			"value" => array(
				esc_html__("Yes",'snshadona') => '1',
				esc_html__("No",'snshadona') =>  '2',
			),
			'description' => esc_html__('Choose Type of navigation.','snshadona')
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Page Navigation",'snshadona'),
			"param_name" => "pagination",
			"value" => array(
				esc_html__("Default",'snshadona') => 'def',
				esc_html__("Ajax",'snshadona') =>  'ajax'
			),
			'description' => esc_html__('Choose Type of navigation.','snshadona')
		),
		
		$vc_add_css_animation,
		$sns_extra_class,
	)
) );


class WPBakeryShortCode_SNS_Our_Brand extends WPBakeryShortCode {}

vc_map( array(
	"name" => esc_html__("SNS Our Brand",'snshadona'),
	"base" => "sns_our_brand",
	"icon" => "sns_icon_ourbrand",
	"class" => "sns_ourbrand",
	"category" => esc_html__("Content",'snshadona'),
	"description" => esc_html__( "Carousel list brands(image, link)", 'snshadona' ),
	"params" => array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Title",'snshadona'),
			"param_name" => "title",
			"value" => esc_html__("Our brands", 'snshadona'),
		),
		array(
			"type" => "colorpicker",
			"value" => "#ffffff",
			"heading" => esc_html__("Background color", 'snshadona'),
			"param_name" => "background_color"
	    ),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Link Target",'snshadona'),
			"param_name" => "link_target",
			"value" => array(
				esc_html__("New Windown",'snshadona') => "blank",
				esc_html__("Same Windown",'snshadona') =>  "_self"
			),
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Show Nav","snshadona"),
			"param_name" => "show_nav",
			"value" => array(
				"0" => "No",
				"1" =>  "Yes"
			),
			"description" => ""
		),

		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Show Paging","snshadona"),
			"param_name" => "use_paging",
			"value" => array(
				"0" => "No",
				"1" =>  "Yes"
			),
			"description" => ""
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Brands number row","snshadona"),
			"param_name" => "num_row",
			"value" => "1",
			"description" =>  esc_html__("Numbers display with each page carousel","snshadona"),
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Brands number display",'snshadona'),
			"param_name" => "num_display",
			"value" => "5",
			"description" => esc_html__("Numbers display with each page carousel","snshadona"),
		),
		
		$vc_add_css_animation,
		$sns_extra_class,
	)
) );

class WPBakeryShortCode_SNS_Our_Partner extends WPBakeryShortCode {}

vc_map( array(
	"name" => esc_html__("SNS Our Partner",'snshadona'),
	"base" => "sns_our_partner",
	"icon" => "sns_icon_ourpartner",
	"class" => "sns_ourbrand",
	"category" => esc_html__("Content",'snshadona'),
	"description" => esc_html__( "Carousel list brands(image, link)", 'snshadona' ),
	"params" => array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Title",'snshadona'),
			"param_name" => "title",
			"value" => esc_html__("Our partners",'snshadona')
		),
		array(
			"type" => "colorpicker",
			"value" => "",
			"heading" => esc_html__("Background color", 'snshadona'),
			"param_name" => "background_color"
	    ),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Link Target",'snshadona'),
			"param_name" => "link_target",
			"value" => array(
				esc_html__("New Windown", 'snshadona') => "blank",
				esc_html__("Same Windown", 'snshadona') =>  "_self"
			),
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Show Nav","snshadona"),
			"param_name" => "show_nav",
			"value" => array(
				"0" => "No",
				"1" =>  "Yes"
			),
			"description" => ""
		),

		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Show Paging","snshadona"),
			"param_name" => "use_paging",
			"value" => array(
				"0" => "No",
				"1" =>  "Yes"
			),
			"description" => ""
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Partners number row","snshadona"),
			"param_name" => "num_row",
			"value" => "1",
			"description" => esc_html__("Numbers display with each page carousel","snshadona")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Partners number display",'snshadona'),
			"param_name" => "num_display",
			"value" => "5",
			"description" => esc_html__("Numbers display with each page carousel",'snshadona')
		),
		
		$vc_add_css_animation,
		$sns_extra_class,
	)
) );

class WPBakeryShortCode_SNS_Testimonial extends WPBakeryShortCode {}

vc_map( array(
	"name" => esc_html__("SNS Testimonial",'snshadona'),
	"base" => "sns_testimonial",
	"icon" => "sns_icon_testimonial",
	"class" => "sns_testimonial",
	"category" => esc_html__("Content",'snshadona'),
	"description" => esc_html__( "Carousel list testimonial", 'snshadona' ),
	"params" => array(
		array(
			"type" => "textfield",
			"class" => "",
			"value" => esc_html__("What client say ?",'snshadona'),	
			"heading" => esc_html__("Prefix", 'snshadona'),
			"param_name" => "prefix" 
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Title",'snshadona'),
			"param_name" => "title",
			"value" => esc_html__("Testimonials",'snshadona'),
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Template", 'snshadona'),
			"value" => array(
				esc_html__('Style 1', 'snshadona') => "style1",
				esc_html__('Style 2', 'snshadona') => "style2",
			),
			"param_name" => "template" 
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => esc_html__("Show paging",'snshadona'),
			"param_name" => "use_paging",
			"value" => array(
				esc_html__('Yes', 'snshadona') => "yes",
				esc_html__('No', 'snshadona') => "no",
			),
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Number Testimonial",'snshadona'),
			"param_name" => "num_display",
			"value" => "6",
			"description" => esc_html__("Numbers display with each page carousel",'snshadona'),
		),

		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Excerpt Length",'snshadona'),
			"param_name" => "excerpt_length",
			"value" => "35"
		),
			
		$vc_add_css_animation,
		$sns_extra_class,		
	)
) );

class WPBakeryShortCode_SNS_Member extends WPBakeryShortCode {}

vc_map( array(
	"name" => esc_html__("SNS Member",'snshadona'),
	"base" => "sns_member",
	"icon" => "sns_icon_member",
	"class" => "sns_member",
	"category" => esc_html__("Content",'snshadona'),
	"description" => esc_html__( "Display team member", 'snshadona' ),
	"params" => array(
		array(
	      "type" => "attach_image",
	      "heading" => esc_html__("Avartar", 'snshadona'),
	      "param_name" => "avartar" 
	    ),
	    array(
			"type" => "dropdown",
			"heading" => esc_html__("Avartar style",'snshadona'),
			"param_name" => "avartar_style",
			"value" => array(
				esc_html__("Default",'snshadona') => "",
				esc_html__("Rounded",'snshadona') =>  "rounded",
				esc_html__("Circle",'snshadona') =>  "circle"
			),
			"description" => ""
		),
		array(
			'type' => 'vc_link',
			'heading' => esc_html__( 'Link to member', 'snshadona' ),
			'param_name' => 'link',
		),
	    array(
	      "type" => "textfield",
	      "heading" => esc_html__("Member name", 'snshadona'),
	      "param_name" => "name",
		  "admin_label" => true
	    ),
	    array(
	      "type" => "textfield",
	      "heading" => esc_html__("Member role", 'snshadona'),
	      "param_name" => "role",
		  "admin_label" => true
	    ),
	    array(
	      "type" => "textarea_html",
	      "heading" => esc_html__("Short description", 'snshadona'),
	      "param_name" => "content",
	    ),
		array(
	      "type" => "textfield",
	      "heading" => esc_html__("Twitter link", 'snshadona'),
	      "param_name" => "twitter",
		  //"dependency" => Array('element' => "social_links", 'value' => 'twitter')
	    ),
		array(
	      "type" => "textfield",
	      "heading" => esc_html__("Facebook link", 'snshadona'),
	      "param_name" => "facebook",
		  //"dependency" => Array('element' => "social_links", 'value' => 'facebook')
	    ),
		array(
	      "type" => "textfield",
	      "heading" => esc_html__("youtube link", 'snshadona'),
	      "param_name" => "youtube",
		  //"dependency" => Array('element' => "social_links", 'value' => 'youtube')
	    ),
		array(
	      "type" => "textfield",
	      "heading" => esc_html__("google link", 'snshadona'),
	      "param_name" => "google",
		  //"dependency" => Array('element' => "social_links", 'value' => 'google')
	    ),
		array(
	      "type" => "textfield",
	      "heading" => esc_html__("pinterest link", 'snshadona'),
	      "param_name" => "pinterest",
		  //"dependency" => Array('element' => "social_links", 'value' => 'pinterest')
	    ),
	    $vc_add_css_animation,
	    $sns_extra_class,
	)
) );

class WPBakeryShortCode_SNS_Show_Video extends WPBakeryShortCode {}

vc_map( array(
	"name" => esc_html__("SNS Show Video",'snshadona'),
	"base" => "sns_show_video",
	"icon" => "sns_icon_show_video",
	"class" => "sns_show_video",
	"category" => esc_html__("Content",'snshadona'),
	"description" => esc_html__( "Display video", 'snshadona' ),
	"params" => array(	
	    array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("The first part of the title",'snshadona'),
			"param_name" => "title",
			"admin_label" => true,
			"value" =>  esc_html__("", 'snshadona'),
		),
		array(
	      	"heading" => esc_html__("Title Color", 'snshadona'),
	      	"param_name" => "title_color",    
	       	"type" => "colorpicker",
			"value" => "",
	      	
	    ),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("The last part of the title",'snshadona'),
			"param_name" => "last_title",
			"admin_label" => true,
			"value" =>  esc_html__("", 'snshadona'),
			"description" => esc_html__("Enter here if you want to this component of title has other color", 'snshadona')
		),
		array(
	      	"heading" => esc_html__("Color of the last part", 'snshadona'),
	      	"param_name" => "last_title_color",    
	       	"type" => "colorpicker",
			"value" => "",
	      
	    ),
		 array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Font size of title",'snshadona'),
			"param_name" => "font_size",
			"admin_label" => true,
			"value" =>  esc_html__("80px", 'snshadona'),
		),
		 array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Margin bottom",'snshadona'),
			"param_name" => "margin_bottom",
			"admin_label" => true,
			"value" =>  esc_html__("50px", 'snshadona'),
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Button",'snshadona'),
			"param_name" => "button",
			"admin_label" => true,
			"value" =>  esc_html__("Watch video", 'snshadona'),
		),
		 array(
	      	"type" => "textarea_html",
	      	"heading" => esc_html__("Add video", 'snshadona'),
	     	 "param_name" => "content",
	    ),
		
	    $vc_add_css_animation,
	    $sns_extra_class,
	)
) );



//Register "container" content element. It will hold all your inner (child) content elements

vc_map( array(
	"name" => esc_html__("SNS Key Features",'snshadona'),
	"base" => "sns_key_features",
	"class" => "sns_key_features",
	"category" => esc_html__("Content",'snshadona'),
	//"description" => esc_html__( "Key Featrues",'snshadona' ),
    "as_parent" => array('only' => 'sns_custom_box'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "show_settings_on_create" => true,
    "is_container" => true,
    "params" => array(
        // add params same as with any other content element
        array(
			"type" => "textfield",
			"class" => "",
			"heading" => esc_html__("Title",'snshadona'),
			"param_name" => "title",
			"admin_label" => true,
			"value" => esc_html__("Key Features",'snshadona'),
		),
        array(
			"type" => "attach_image",
			"class" => "",
			"heading" => esc_html__("Image",'snshadona'),
			"param_name" => "key_featrues_image",
			"value" => "",
		),
		$vc_add_css_animation,
		$sns_extra_class,

    ),
    "js_view" => 'VcColumnView'
) );

//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_SNS_Key_Features extends WPBakeryShortCodesContainer {
    }
}


class WPBakeryShortCode_SNS_Advance_Banner extends WPBakeryShortCode {}

vc_map( array(
	"name" => esc_html__("SNS Advance Banner",'snshadona'),
	"base" => "sns_advance_banner",
	"class" => "sns_advance",
	"category" => esc_html__("Content",'snshadona'),
	"description" => esc_html__( "Display advance", 'snshadona' ),
	"params" => array(
		array(
	      	"type" => "attach_image",
	      	"heading" => esc_html__("Image", 'snshadona'),
	      	"param_name" => "image"
	    ),
	    array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Image alignment', 'snshadona' ),
			'param_name' => 'image_alignment',
			 "value" => array(
	      		esc_html__('Left', 'snshadona') => "left",
	      		esc_html__('Center', 'snshadona') => "center",
				esc_html__('Right', 'snshadona') => "right",
			),
		),
	   
		array(
			'type' => 'vc_link',
			'heading' => esc_html__( 'Link', 'snshadona' ),
			'param_name' => 'link',
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Banner content position', 'snshadona' ),
			'param_name' => 'content_position',
			 "value" => array(
	      		esc_html__('Left middle', 'snshadona') => "left_middle",
	      		esc_html__('Center middle', 'snshadona') => "center_middle",
				esc_html__('Center top', 'snshadona') => "center_top",
				esc_html__('Center bottom', 'snshadona') => "center_bottom",
			),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Left', 'snshadona' ),
			'param_name' => 'left',
			 "dependency" => array("element" => "content_position" , "value" => array("left_middle","center_middle" )),
			 'value' => __( '50px', 'snshadona' ),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Top', 'snshadona' ),
			'param_name' => 'top1',
			 "dependency" => array("element" => "content_position" , "value" => array("left_middle","center_middle" )),
			'value' => __( '50%', 'snshadona' ), 
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Top', 'snshadona' ),
			'param_name' => 'top',
			 "dependency" => array("element" => "content_position" , "value" => "center_top" ),
		),
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Bottom', 'snshadona' ),
			'param_name' => 'bottom',
			 "dependency" => array("element" => "content_position" , "value" => "center_bottom" ),
		),
		 array(		
		 	"type" => "checkbox",
			"heading" => esc_html__("Use Sub heading?", 'snshadona' ),
			"param_name" => "sub_heading",
			
		),
	     array(
	      	"type" => "textfield",
	      	"heading" => esc_html__("Sub heading text", 'snshadona'),
	      	"param_name" => "sub_heading_text",     
	      	"dependency" => array("element" => "sub_heading" , "value" => "true" ),
	    ),
	    array(
	      	"type" => "textfield",
	      	"heading" => esc_html__("Sub heading font size", 'snshadona'),
	      	"param_name" => "sub_heading_font_size",     
	      	"dependency" => array("element" => "sub_heading" , "value" => "true" ),
	       	'value' => __( '25px', 'snshadona' ),
	    ),
	    array(
	      	"type" => "dropdown",
	      	"heading" => esc_html__("Sub heading font weight", 'snshadona'),
	      	"param_name" => "sub_heading_font_weight",    
	       	"value" => array(
	      		esc_html__('Normal', 'snshadona') => "normal",
				esc_html__('Bold', 'snshadona') => "bold",	
			), 
	      	"dependency" => array("element" => "sub_heading" , "value" => "true" ),
	    ),
	    array(
	      	"type" => "dropdown",
	      	"heading" => esc_html__("Sub heading text transform", 'snshadona'),
	      	"param_name" => "sub_heading_text_transform",    
	       	"value" => array(
	      		esc_html__('None', 'snshadona') => "none",
				esc_html__('Capitalize', 'snshadona') => "capitalize",	
				esc_html__('Uppercase', 'snshadona') => "uppercase",	
				esc_html__('Lowercase', 'snshadona') => "lowercase",	
				esc_html__('Inherit', 'snshadona') => "inherit",	
			), 
	      	"dependency" => array("element" => "sub_heading" , "value" => "true" ),
	    ),
	   
	     array(
	      	"heading" => esc_html__("Sub heading Color", 'snshadona'),
	      	"param_name" => "sub_heading_color",    
	       	"type" => "colorpicker",
			"value" => "",
	      	"dependency" => array("element" => "sub_heading" , "value" => "true" ),
	    ),
	    array(		
		 	"type" => "checkbox",
			"heading" => esc_html__("Use Heading?", 'snshadona' ),
			"param_name" => "heading",
			
		),
	     array(
	      	"type" => "textarea",
	      	"heading" => esc_html__("Heading text", 'snshadona'),
	      	"param_name" => "heading_text",     
	      	"dependency" => array("element" => "heading" , "value" => "true" ),
	    ),
	    array(
	      	"type" => "textfield",
	      	"heading" => esc_html__("Heading font size", 'snshadona'),
	     	"param_name" => "heading_font_size",     
	     	"dependency" => array("element" => "heading" , "value" => "true" ),
	      	'value' => __( '50px', 'snshadona' ),
	    ),
	    array(
	      	"type" => "dropdown",
	      	"heading" => esc_html__("Heading font weight", 'snshadona'),
	      	"param_name" => "heading_font_weight",    
	       	"value" => array(
	      		esc_html__('Normal', 'snshadona') => "normal",
				esc_html__('Bold', 'snshadona') => "bold",	
			), 
	      	"dependency" => array("element" => "heading" , "value" => "true" ),
	    ),
	    array(
	      	"type" => "dropdown",
	      	"heading" => esc_html__("Heading text transform", 'snshadona'),
	      	"param_name" => "heading_text_transform",    
	       	"value" => array(
	      		esc_html__('None', 'snshadona') => "none",
				esc_html__('Capitalize', 'snshadona') => "capitalize",	
				esc_html__('Uppercase', 'snshadona') => "uppercase",	
				esc_html__('Lowercase', 'snshadona') => "lowercase",	
				esc_html__('Inherit', 'snshadona') => "inherit",	
			), 
	      	"dependency" => array("element" => "heading" , "value" => "true" ),
	    ),
	     array(
	      	"heading" => esc_html__("Heading Color", 'snshadona'),
	     	"param_name" => "heading_color",    
	      	"type" => "colorpicker",
			"value" => "",
	      	"dependency" => array("element" => "heading" , "value" => "true" ),
	    ),
	    array(
	    	"type" => "textfield",
	     	"heading" => esc_html__("Margin bottom", 'snshadona'),
	      	"param_name" => "margin_bottom",    
	       'value' => __( '5px', 'snshadona' ), 
	      	"dependency" => array("element" => "heading" , "value" => "true" ),
	    ),
		 array(		
		 	"type" => "checkbox",
			"heading" => esc_html__("Use difference color for first letter?", 'snshadona' ),
			"param_name" => "first_letter",
			"dependency" => array("element" => "heading" , "value" => "true" ),
		),
		 array(
	      	"heading" => esc_html__("Color for first letter", 'snshadona'),
	      	"param_name" => "first_letter_color",    
	      	'type' => 'colorpicker',
			"value" => "",
	     	 "dependency" => array("element" => "first_letter" , "value" => "true" ),
	    ),
	    array(
	      	"type" => "textarea_html",
	      	"heading" => esc_html__("Decription", 'snshadona'),
	     	 "param_name" => "content",
	    ),
	     array(
	      	"type" => "textfield",
	      	"heading" => esc_html__("Decription font size", 'snshadona'),
	      	"param_name" => "decription_font_size",
	      	'value' => __( '13px', 'snshadona' ),
	    ),
	    array(		
		 	"type" => "checkbox",
			"heading" => esc_html__("Use button 1?", 'snshadona' ),
			"param_name" => "show_button1",
			
		),
	    
	    array(
			'type' => 'textfield',
			'heading' => __( 'Text', 'snshadona' ),
			'param_name' => 'btn_title',
			'value' => __( 'Text on the button', 'snshadona' ),
			 "dependency" => array("element" => "show_button1" , "value" => "true" ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Text Color', 'snshadona' ),
			'param_name' => 'btn_title_color',
			'value' => "",
			 "dependency" => array("element" => "show_button1" , "value" => "true" ),
		),
		array(
			'type' => 'vc_link',
			'heading' => __( 'URL (Link)', 'snshadona' ),
			'param_name' => 'btn_link',
			'description' => __( 'Add link to button.', 'snshadona' ),
			 "dependency" => array("element" => "show_button1" , "value" => "true" ),
			// compatible with btn2 and converted from href{btn1}
		),
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Color', 'snshadona' ),
			'param_name' => 'btn_color',
			'value' => "",
			'description' => __( 'Select button color.', 'snshadona' ),
			 "dependency" => array("element" => "show_button1" , "value" => "true" ),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Size', 'snshadona' ),
			'param_name' => 'btn_size',
			'description' => __( 'Select button display size.', 'snshadona' ),
			// compatible with btn2, default md, but need to be converted from btn1 to btn2
			'std' => 'md',
			'value' => getVcShared( 'sizes' ),
			 "dependency" => array("element" => "show_button1" , "value" => "true" ),
		),
		 array(		
		 	"type" => "checkbox",
			"heading" => esc_html__("Use button 2?", 'snshadona' ),
			"param_name" => "show_button2",
			
		),
		  array(
			'type' => 'textfield',
			'heading' => __( 'Text', 'snshadona' ),
			'param_name' => 'btn_title_2',
			'value' => __( 'Text on the button', 'snshadona' ),
			 "dependency" => array("element" => "show_button2" , "value" => "true" ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Text Color', 'snshadona' ),
			'param_name' => 'btn_title_color_2',
			'value' => "",
			 "dependency" => array("element" => "show_button2" , "value" => "true" ),
		),
		array(
			'type' => 'vc_link',
			'heading' => __( 'URL (Link)', 'snshadona' ),
			'param_name' => 'btn_link_2',
			'description' => __( 'Add link to button.', 'snshadona' ),
			 "dependency" => array("element" => "show_button2" , "value" => "true" ),
			// compatible with btn2 and converted from href{btn1}
		),
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Color', 'snshadona' ),
			'param_name' => 'btn_color_2',
			'value' => "",
			'description' => __( 'Select button color.', 'snshadona' ),
			 "dependency" => array("element" => "show_button2" , "value" => "true" ),
		),		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Size', 'snshadona' ),
			'param_name' => 'btn_size_2',
			'description' => __( 'Select button display size.', 'snshadona' ),
			// compatible with btn2, default md, but need to be converted from btn1 to btn2
			'std' => 'md',
			'value' => getVcShared( 'sizes' ),
			 "dependency" => array("element" => "show_button2" , "value" => "true" ),
		),
	    $vc_add_css_animation,
	    $sns_extra_class,
	)
) );

?>