<?php
define( 'SNSHADONA_THEME_DIR', get_template_directory() );
define( 'SNSHADONA_THEME_URI', get_template_directory_uri() );

// Require framework
require_once( SNSHADONA_THEME_DIR.'/framework/init.php' );
/** 
 *   Initialize Visual Composer in the theme.
 **/
add_action( 'vc_before_init', 'snshadona_vcSetAsTheme' );
function remove_loop_button(){
   remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
   remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
}
add_action('init','remove_loop_button');
function snshadona_vcSetAsTheme() {
	vc_set_as_theme(true);
}
// Initialising Visual shortcode editor
 if (class_exists('WPBakeryVisualComposerAbstract')) {
 	function snshadona_requireVcExtend(){
 		include_once( SNSHADONA_THEME_DIR . '/vc_extend/extend-vc.php' );
 	}
 	add_action('init', 'snshadona_requireVcExtend', 2);
 }
/** 
 *	Width of content, it's max width of content without sidebar.
 **/
if ( ! isset( $content_width ) ) { $content_width = 660; }

/** 
 *	Set base function for theme.
 **/
if ( ! function_exists( 'snshadona_setup' ) ) {
    function snshadona_setup() {
        global $snshadona_opt, $snshadona_obj;
    	// Load default theme textdomain.
        load_theme_textdomain( 'snshadona' , SNSHADONA_THEME_DIR . '/languages' );
		// Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );
		// Enable support for Post Thumbnails on posts and pages.
        add_theme_support( 'post-thumbnails' );
        // Add title-tag, it auto title of head
        add_theme_support( 'title-tag' );
        // Enable support for Post Formats.
        add_theme_support( 'post-formats',
            array(
                'video', 'audio', 'quote', 'link', 'gallery'
            )
        );
        // Register images size
        add_image_size('snshadona_megamenu_thumb', 250, 150, true);
        add_image_size('snshadona_blog_layout2_thumbnail_size', 720,480, true); // blog layout 2
        add_image_size('snshadona_latest_posts_thumbnail_size', 900,600, true); // blog layout 2
        add_image_size('snshadona_posts_thumbnail_size', 960,640, true); // sns_posts
        add_image_size('snshadona_product_thumbnail_size', 110,119, true); 
        add_image_size('snshadona_latest_posts', 370, 266, true);
        add_image_size('snshadona_latest_posts_widget', 80, 53, true);
        add_image_size('snshadona_testimonial_avatar', 120, 120, true);
        add_image_size('snshadona_products_slider_thumb', 680, 530, false);

        add_image_size('snshadona_product_sc_image_size', 554, 600, false);
        add_image_size('snshadona_attribute_pa_images_size', 64, 64, false);
        
		//Setup the WordPress core custom background & custom header feature.
         $default_background = array(
            'default-color' => '#FFF',
        );
        add_theme_support( 'custom-background', $default_background );
        $default_header = array();
        add_theme_support( 'custom-header', $default_header );
        // Register navigations
	    register_nav_menus( array(
	    	'top_navigation'  => esc_html__( 'Top navigation', 'snshadona' ),
            'vertical_navigation' => esc_html__( 'Vertical navigation', 'snshadona' ),
			'main_navigation' => esc_html__( 'Main navigation', 'snshadona' ),
		) );
    }
    add_action ( 'after_setup_theme', 'snshadona_setup' );
}
add_action( 'after_setup_theme', 'snshadona_woocommerce_support' );
function snshadona_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

/** 
    Add class for body
 **/
add_filter( 'body_class', 'snshadona_bodyclass' );
function snshadona_bodyclass( $classes ) {
    if ( snshadona_themeoption('use_boxedlayout', 0) == 1) {
        $classes[] = 'boxed-layout';
    }
    if( snshadona_themeoption('advance_tooltip', 1) == 1){
        $classes[] = 'use-tooltip';
    }
    if( snshadona_themeoption('use_stickmenu') == 1){
        $classes[] = 'use_stickmenu';
    }
    if ( snshadona_themeoption('woo_uselazyload') == 1 ){
        $classes[] = 'use_lazyload';
    }

    if( snshadona_themeoption('use_fullwidth') ==1 && snshadona_themeoption('use_boxedlayout', 0) == 0){
        $classes[] = 'fullwidth';
    }
    if(class_exists('WooCommerce')){
        $classes[] = 'woocommerce';
        $woo_onsale_layout = snshadona_themeoption('woo_onsale_layout', 'carousel');
        if(is_product_category()){
            $cate = get_queried_object();
            $woo_onsale_layout = get_woocommerce_term_meta($cate->term_id, 'snshadona_woo_onsale_layout');
        }
        if( $woo_onsale_layout != '' ){
            $classes[] = 'sns-archive-product-onsale-'.$woo_onsale_layout;
        }
    }

    return $classes;
}

function snshadona_widgetlocations(){
    // Register widgetized locations
    if(function_exists('register_sidebar')) {
        register_sidebar(array(
           'name' => esc_html__( 'Widget Area','snshadona' ),
           'id'   => 'widget-area',
            'description'   => esc_html__( 'These are widgets for the Widget Area.','snshadona' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title"><span>',
            'after_title' => '</span></h3>',
        ));
         register_sidebar(array(
           'name' => esc_html__( 'Top Policy','snshadona' ),
           'id'   => 'top-policy',
            'description'   => esc_html__( 'These are widgets for the Widget Area.','snshadona' ),
            'before_widget' => '<div class="widget %2$s top_policy col-lg-3 col-md-6 col-sm-6 col-xs-12">',
            'after_widget'  => '</div>', 
        ));
         register_sidebar(array(
           'name' => esc_html__( 'Footer Top Left','snshadona' ),
           'id'   => 'footer_top_left',
            'description'   => esc_html__( 'These are widgets for the Footer','snshadona' ),
            'before_widget' => '<div class="widget %2$s footer_top_left col-lg-6">',
            'after_widget'  => '</div>', 
        ));
        register_sidebar(array(
           'name' => esc_html__( 'Footer Top Right','snshadona' ),
           'id'   => 'footer_top_right',
            'description'   => esc_html__( 'These are widgets for the Footer','snshadona' ),
            'before_widget' => '<div class="widget %2$s footer_top_right col-lg-6">',
            'after_widget'  => '</div>', 
        ));
        register_sidebar(array(
	        'name' => esc_html__( 'Menu Sidebar #1','snshadona' ),
	        'id'   => 'menu_sidebar_1',
	        'description'   => esc_html__( 'These are widgets for Mega Menu Columns style. This sidebar displayed in the right of column.','snshadona' ),
	        'before_widget' => '<div class="widget sidebar-menu-widget %2$s">',
	        'after_widget'  => '</div>',
	        'before_title'  => '<h4 class="hide">',
	        'after_title'   => '</h4>'
        ));
        
        register_sidebar(array(
	        'name' => esc_html__( 'Menu Sidebar #2','snshadona' ),
	        'id'   => 'menu_sidebar_2',
	        'description'   => esc_html__( 'These are widgets for Mega Menu Columns style. This sidebar displayed in the bottom of column.','snshadona' ),
	        'before_widget' => '<div class="widget sidebar-menu-widget %2$s">',
	        'after_widget'  => '</div>',
	        'before_title'  => '<h4 class="hide">',
	        'after_title'   => '</h4>'
        ));
      
        register_sidebar(array(
           'name' => esc_html__( 'Footer Column #1','snshadona' ),
           'id'   => 'footer-column-1',
            'description'   => esc_html__( 'These are widgets for the Footer.','snshadona' ),
            'before_widget' => '<div id="%1$s" class="widget widget-footer %2$s">',       
            'after_widget'  => '</div>',
            'before_title'  => '<h4>',
            'after_title'   => '</h4>'
        ));

        register_sidebar(array(
           'name' => esc_html__( 'Footer Column #2','snshadona' ),
           'id'   => 'footer-column-2',
            'description'   => esc_html__( 'These are widgets for the Footer.','snshadona' ),
            'before_widget' => '<div id="%1$s" class="widget widget-footer %2$s">',       
            'after_widget'  => '</div>',
            'before_title'  => '<h4>',
            'after_title'   => '</h4>'
        ));

         register_sidebar(array(
           'name' => esc_html__( 'Footer Column #3','snshadona' ),
           'id'   => 'footer-column-3',
            'description'   => esc_html__( 'These are widgets for the Footer.','snshadona' ),
            'before_widget' => '<div id="%1$s" class="widget widget-footer %2$s">',       
            'after_widget'  => '</div>',
            'before_title'  => '<h4>',
            'after_title'   => '</h4>'
        ));

        register_sidebar(array(
           'name' => esc_html__( 'Footer Column #4','snshadona' ),
           'id'   => 'footer-column-4',
            'description'   => esc_html__( 'These are widgets for the Footer.','snshadona' ),
            'before_widget' => '<div id="%1$s" class="widget widget-footer %2$s">',       
            'after_widget'  => '</div>',
            'before_title'  => '<h4>',
            'after_title'   => '</h4>'
        ));
        register_sidebar(array(
           'name' => esc_html__( 'Footer Column #5','snshadona' ),
           'id'   => 'footer-column-5',
            'description'   => esc_html__( 'These are widgets for the Footer.','snshadona' ),
            'before_widget' => '<div id="%1$s" class="widget widget-footer %2$s">',       
            'after_widget'  => '</div>',
            'before_title'  => '<h4>',
            'after_title'   => '</h4>'
        ));
         register_sidebar(
            array(
            'name' => esc_html__( 'Home Sidebar','snshadona' ),
            'id' => 'home-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title"><span>',
            'after_title' => '</span></h3>',
        ));
         register_sidebar(
            array(
            'name' => esc_html__( 'Product Sidebar','snshadona' ),
            'id' => 'product-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title"><span>',
            'after_title' => '</span></h3>',
        ));
        register_sidebar(
            array(
            'name' => esc_html__( 'Woo Sidebar','snshadona' ),
            'id' => 'woo-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title"><span>',
            'after_title' => '</span></h3>',
        ));
         register_sidebar(
            array(
            'name' => esc_html__( 'Blog Sidebar','snshadona' ),
            'id' => 'blog-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title"><span>',
            'after_title' => '</span></h3>',
        ));
      
    }
}
add_action( 'widgets_init', 'snshadona_widgetlocations' );
/** 
 *	Add styles & scripts
 **/
function snshadona_scripts() {
	global $snshadona_opt, $snshadona_obj;
    $optimize = '';

	// Enqueue style
	$css_file = $snshadona_obj->snshadona_css_file();
	wp_enqueue_style('bootstrap', SNSHADONA_THEME_URI . '/assets/css/bootstrap.min.css');
    wp_enqueue_style('owlcarousel', SNSHADONA_THEME_URI . '/assets/css/owl.carousel.min.css');
	wp_enqueue_style('fonts-awesome', SNSHADONA_THEME_URI . '/assets/fonts/awesome/css/font-awesome.min.css');
    wp_enqueue_style('fonts-awesome-animation', SNSHADONA_THEME_URI . '/assets/fonts/awesome/css/font-awesome-animation.min.css');
    wp_enqueue_style('snshadona-ie9', SNSHADONA_THEME_URI . '/assets/css/ie9.css');
    wp_enqueue_style('snshadona-woocommerce', SNSHADONA_THEME_URI . '/assets/css/woocommerce'.$optimize.'.css');
	wp_enqueue_style('snshadona-theme-style', SNSHADONA_THEME_URI . '/assets/css/' . $css_file);
	
	wp_register_script('owlcarousel', SNSHADONA_THEME_URI . '/assets/js/owl.carousel.min.js', array('jquery'), '', true);
    wp_enqueue_script('owlcarousel');
	wp_register_script('masonry', SNSHADONA_THEME_URI . '/assets/js/masonry.pkgd.min.js', array('jquery'), '', true);
	wp_register_script('imagesloaded', SNSHADONA_THEME_URI . '/assets/js/imagesloaded.pkgd.min.js', array('jquery'), '', true);
	wp_register_script('countdown', SNSHADONA_THEME_URI . '/assets/countdown/jquery.countdown.min.js', array('jquery'), '2.1.0', true);
    // Enqueue script
    wp_enqueue_script('bootstrap', SNSHADONA_THEME_URI . '/assets/js/bootstrap.min.js', array('jquery'), '', true);
    wp_enqueue_script('bootstrap-tabdrop', SNSHADONA_THEME_URI . '/assets/js/bootstrap-tabdrop.min.js', array('jquery'), '', true);
    if( snshadona_themeoption('woo_uselazyload') == 1 ) wp_enqueue_script('lazyload', SNSHADONA_THEME_URI . '/assets/js/jquery.lazyload'.$optimize.'.js', array(), '', true);
    wp_enqueue_script('snshadona-script', SNSHADONA_THEME_URI . '/assets/js/sns-script'.$optimize.'.js', array('jquery'), '', true);
   
    // IE
    wp_enqueue_script('html5shiv', SNSHADONA_THEME_URI . '/assets/js/html5shiv.min.js', array('jquery'), '');
    wp_script_add_data('html5shiv', 'conditional', 'lt IE 9');
    wp_enqueue_script('respond', SNSHADONA_THEME_URI . '/assets/js/respond.min.js', array('jquery'), '');
    wp_script_add_data('respond', 'conditional', 'lt IE 9');
    // Add style inline with option in admin theme option
    wp_add_inline_style('snshadona-theme-style', snshadona_cssinline());
    // Add inlune scritp
    wp_add_inline_script('snshadona-script', snshadona_jsinline());
    // Code to embed the javascript file that makes the Ajax request
    wp_enqueue_script('ajax-request', SNSHADONA_THEME_URI . '/assets/js/ajax.js', array('jquery'));
    // Code to declare the URL to the file handing the AJAX request
    $js_params = array(
    	'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) )
    );
    global $wp_query, $wp;
    $js_params['query_vars'] = $wp_query->query_vars;
    $js_params['current_url'] = esc_url(home_url($wp->request));
    
    wp_localize_script('ajax-request', 'sns', $js_params);
    
}
add_action( 'wp_enqueue_scripts', 'snshadona_scripts' );

/*
 * Enqueue admin styles and scripts
 */
function snshadona_admin_styles_scripts(){
	wp_enqueue_style('snshadona_admin_style', SNSHADONA_THEME_URI.'/admin/assets/css/admin-style.css');
	wp_enqueue_style( 'wp-color-picker' );
	
	wp_enqueue_media();
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_script('snshadona_admin_template_js', SNSHADONA_THEME_URI.'/admin/assets/js/admin_template.js', array( 'jquery', 'wp-color-picker' ), false, true);
}
add_action('admin_enqueue_scripts', 'snshadona_admin_styles_scripts');

// Editor style
add_editor_style('assets/css/editor-style.css');
/**
 * CSS inline
**/
function snshadona_cssinline(){
    global $snshadona_opt;
    $inline_css = '';
    // Body style
    $bodycss = '';
    if (snshadona_getOption('use_boxedlayout') == 1) {
        if ($snshadona_opt['body_bg_type'] == 'pantern') {
            $bodycss .= 'background-image: url('.SNSHADONA_THEME_URI.'/assets/img/patterns/'.$snshadona_opt['body_bg_type_pantern'].');';
        }elseif( $snshadona_opt['body_bg_type'] == 'img' ){
            $bodycss .= 'background-image: url('.$snshadona_opt['body_bg_type_img']['url'].');';
        }
    }
    if(isset($snshadona_opt['body_font']) && is_array($snshadona_opt['body_font'])) {
        $body_font = '';
        foreach($snshadona_opt['body_font'] as $propety => $value)
            if($value != 'true' && $value != 'false' && $value != '' && $propety != 'subsets')
                $body_font .= $propety . ':' . $value . ';';
        
        if($body_font != '') $bodycss .= $body_font;
    }
    if (snshadona_metabox('body_bg_color') != '') { 
        $body_bg_color = snshadona_metabox('body_bg_color');
        if ($body_bg_color != '') $bodycss .= 'background-color:' .$body_bg_color.' !important;;';
    }
    $inline_css .= 'body {'.$bodycss.'}';
    // Selectors use google font
    if(isset($snshadona_opt['secondary_font_target']) && $snshadona_opt['secondary_font_target']) {
        if(isset($snshadona_opt['secondary_font']) && is_array($snshadona_opt['secondary_font'])) {
            $secondary_font = '';
            foreach($snshadona_opt['secondary_font'] as $propety => $value)
                if($value != 'true' && $value != 'false' && $value != '' && $propety != 'subsets')
                    $secondary_font .= $propety . ':' . $value . ';';
            
            if($secondary_font != '') $inline_css .= $snshadona_opt['secondary_font_target'] . ' {'.$secondary_font.'}';
        }
    }

    if(isset($snshadona_opt['advance_customcss']) && $snshadona_opt['advance_customcss']) {
        $inline_css .= $snshadona_opt['advance_customcss'];
    }
    return $inline_css;
}

/* 
 * Add tpl footer
 */
function snshadona_tplfooter() {
    $output = '';
    ob_start();
    require SNSHADONA_THEME_DIR . '/tpl-footer.php';
    $output = ob_get_clean();
    echo $output;
}
add_action('wp_footer', 'snshadona_tplfooter');
/* 
 * Custom js inline and js in admin panel theme
 */
function snshadona_jsinline() {
    // write out custom code
    $output = '';
    ob_start();
    ?>
    jQuery(document).ready(function(){
        <?php if( snshadona_themeoption('tag_showmore', '1') == '1' ): ?>
        if(jQuery('.widget_tag_cloud').length > 0){
            var $tag_display_first  = <?php echo absint( snshadona_themeoption('tag_display_first', 7) ) - 1?>;
            var $number_tags        = jQuery('.widget_tag_cloud .tagcloud a').length;
            var $_this              = jQuery('.widget_tag_cloud .tagcloud');
            var $view_all_tags      = "<?php echo esc_html__('View all tags', 'snshadona');?>";
            var $hide_all_tags      = "<?php echo esc_html__('Hide all tags', 'snshadona');?>";
            
            if( $number_tags > $tag_display_first ){
                jQuery('.widget_tag_cloud .tagcloud a:gt('+$tag_display_first+')').addClass('is_visible').hide();
                jQuery($_this).append('<div class="view-more-tag"><a href="#" title="">'+$view_all_tags+'</a></div>');

                jQuery('.widget_tag_cloud .tagcloud .view-more-tag a').click(function(){
                    if(jQuery(this).hasClass('active')){
                        if( jQuery($_this).find('a').hasClass('is_hidden') ){
                            $_this.find('.is_hidden').removeClass('is_hidden').addClass('is_visible').stop().slideUp(300);
                        }
                        jQuery(this).removeClass('active');
                        jQuery(this).html($view_all_tags);
                        
                    }else{
                        if(jQuery($_this).find('a').hasClass('is_visible')){
                            $_this.find('.is_visible').removeClass('is_visible').addClass('is_hidden').stop().slideDown(400);
                        }
                        jQuery(this).addClass('active');
                        jQuery(this).html($hide_all_tags);
                    }
                    
                    return false;
                });
            }
        }
        <?php endif; ?>
        <?php echo snshadona_themeoption('advance_customjs','');?>
    });
    <?php
    $output = ob_get_clean();
    return $output;
}

/** 
 *	Tile for page, post
 **/
function snshadona_pagetitle(){
	// Disable title in page
	if( is_page() && function_exists('rwmb_meta') && rwmb_meta('snshadona_showtitle') == '2' ) return;
	// Show title in page, single post
	if( is_single() || is_page() || ( is_home() && get_option( 'show_on_front' ) == 'page' ) ) : ?>
		<h1 class="page-header">
          <?php the_title(); ?>
        </h1>
    <?php 
    // Show title for category page
    elseif ( is_category() ) : ?>
        <h1 class="page-header">
          <?php single_cat_title(); ?>
        </h1>
    <?php
    // Author
    elseif ( is_author() ) : ?>
        <h1 class="page-header">
        <?php
            printf( esc_html__( 'All posts by: %s', 'snshadona' ), get_the_author() );
        ?>
        </h1>
        <?php if ( get_the_author_meta( 'description' ) ) : ?>
        <header class="archive-header">
            <div class="author-description"><p><?php the_author_meta( 'description' ); ?></p></div>
        </header>
        <?php endif; ?>
    <?php 
    // Tag
    elseif ( is_tag() ) : ?>
        <h1 class="page-header">
            <?php printf( esc_html__( 'Tag Archives: %s', 'snshadona' ), single_tag_title( '', false ) ); ?>
        </h1>
        <?php
        $term_description = term_description();
        if ( ! empty( $term_description ) ) : ?>
        <header class="archive-header">
            <?php printf( '<div class="taxonomy-description">%s</div>', $term_description ); ?>
        </header>
        <?php endif; ?>
    <?php 
    // Search
    elseif ( is_search() ) : ?>
    <h1 class="page-header"><?php printf( esc_html__( 'Search Results for: %s', 'snshadona' ), get_search_query() ); ?></h1>
    <?php
    // Archive
    elseif ( is_archive() ) : ?>
        <?php the_archive_title( '<h1 class="page-header">', '</h1>' ); ?>
        <?php
        if( get_the_archive_description() ): ?>
        <header class="archive-header">
            <?php the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>
        </header>
        <?php    
        endif;
        ?>
    <?php
    // Default
    else : ?>
        <h1 class="page-header">
          <?php the_title(); ?>
        </h1>
    <?php
	endif;
}


// Excerpt Function
if(!function_exists('snshadona_excerpt')){
    function snshadona_excerpt($limit, $afterlimit='...') {
        $limit = ($limit) ? $limit : 55 ;
        $excerpt = get_the_excerpt();
        if( $excerpt != '' ){
           $excerpt = explode(' ', strip_tags( $excerpt ), intval($limit));
        }else{
            $excerpt = explode(' ', strip_tags(get_the_content( )), intval($limit));
        }
        if ( count($excerpt) >= $limit ) {
            array_pop($excerpt);
            $excerpt = implode(" ",$excerpt).' '.$afterlimit;
        } else {
            $excerpt = implode(" ",$excerpt);
        }
        $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
        return strip_shortcodes( $excerpt );
    }
}

/*
 * Ajax page navigation
 */
function snshadona_ajax_load_next_page(){
	// Get current layout
	global $snshadona_blog_layout, $snshadona_obj;
	$snshadona_blog_layout = isset($_POST['snshadona_blog_layout']) ? esc_html($_POST['snshadona_blog_layout']) : '';
	if( $snshadona_blog_layout == '' ) $snshadona_blog_layout = $snshadona_obj->snshadona_getOption('blog_type');
	
	// Get current page
	$page = $_POST['page'];
	
	// Number of published sticky posts
	$sticky_posts = snshadona_get_sticky_posts_count();
	
	// Current query vars
	$vars = $_POST['vars'];
	
	// Convert string value into corresponding data types
	foreach ($vars as $key => $value){
		if( is_numeric($value) ) $vars[$key] = intval($value);
		if( $value == 'false' ) $vars[$key] = false;
		if( $value == 'true' ) $vars[$key] = true;
	}
	
	// Item template file 
	$template = $_POST['template'];
	
	// Return next page
	$page = intval($page) + 1;
	
	$posts_per_page = get_option('posts_per_page');
    if( $page == 2 && $vars['posts_per_page'] ){
        $offset = $vars['posts_per_page'];
    }else{
        $offset = $vars['posts_per_page'] + ($page - 2) * $posts_per_page;
    }
	
	// Get more posts per page than necessary to detect if there are more posts
	$args = array('post_status'=>'publish', 'posts_per_page'=>$posts_per_page + 1, 'offset'=>$offset);
	$args = array_merge($vars, $args);
	
	// Remove unnecessary variables
	unset($args['paged']);
	unset($args['p']);
	unset($args['page']);
	unset($args['pagename']); // This is necessary in case Posts Page is set to static page
	
	$query = new WP_Query($args);
	
	$idx = 0;
	if( $query->have_posts() ){
		while ( $query->have_posts() ){
			$query->the_post();
			$idx = $idx + 1;
			if( $idx < $posts_per_page + 1 )
				get_template_part($template, get_post_format());
		}
		
		if( $query->post_count <= $posts_per_page ){
			// There are no more posts
			// Print a flag to detect
			echo '<div id="sns-load-more-no-posts" class="no-posts"><!-- --></div>';
		}
	}else{
		// No posts found
	}
	
	/* Restore original Post Data*/
	wp_reset_postdata();
	
	die('');
}
// When the request action is "load_more", the snshadona_ajax_load_next_page() will be called
add_action('wp_ajax_load_more', 'snshadona_ajax_load_next_page');
add_action('wp_ajax_nopriv_load_more', 'snshadona_ajax_load_next_page');

// Word Limiter
function snshadona_limitwords($string, $word_limit) {
    $words = explode(' ', $string);
    return implode(' ', array_slice($words, 0, $word_limit));
}
//
if(!function_exists('snshadona_sharebox')){
    function snshadona_sharebox( $layout='',$args=array() ){
        global $post, $snshadona_obj;
        $default = array(
            'position' => 'top',
            'animation' => 'true'
            );
        $args = wp_parse_args( (array) $args, $default );
        
        $path = SNSHADONA_THEME_DIR.'/tpl-sharebox';
        if( $layout!='' ){
            $path = $path.'-'.$layout;
        }
        $path .= '.php';

        if( is_file($path) ){
            require($path);
        }
 
    }
}
//
if(!function_exists('snshadona_relatedpost')){
    function snshadona_relatedpost(){
        global $post;
        if($post){
        	$post_id = $post->ID;
        }else{
        	// Return if cannot find any post
        }
        
        $relate_count = snshadona_themeoption('related_num');
        $get_related_post_by = snshadona_themeoption('related_posts_by');

        $args = array(
            'post_status' => 'publish',
            'posts_per_page' => $relate_count,
            'orderby' => 'date',
            'ignore_sticky_posts' => 1,
            'post__not_in' => array ($post_id)
        );
        
        if($get_related_post_by == 'cat'){
        	$categories = wp_get_post_categories($post_id);
        	$args['category__in'] = $categories;
        }else{
        	$posttags = wp_get_post_tags($post_id);
        	
        	$array_tags = array();
        	if($posttags){
        		foreach ($posttags as $tag){
        			$tags = $tag->term_id;
        			array_push($array_tags, $tags);
        		}
        	}
        	$args['tag__in'] = $array_tags;
        }
        
        $relates = new WP_Query( $args );
        
        $template_name = '/framework/tpl/posts/related_post.php';
        if(is_file(SNSHADONA_THEME_DIR.$template_name)) {
            include(SNSHADONA_THEME_DIR.$template_name);
        }
        
        wp_reset_postdata();
    }
}

/*
 * Function to display number of posts.
 */
function snshadona_get_post_views($post_id){
	$count_key = 'post_views_count';
	$count = get_post_meta($post_id, $count_key, true);
	if($count == ''){
		delete_post_meta($post_id, $count_key);
		add_post_meta($post_id, $count_key, '0');
		return esc_html__('0 view', 'snshadona');
	}
	return $count. esc_html__(' View', 'snshadona');
}

/*
 * Function to count views.
 */
function snshadona_set_post_views($post_id){
	$count_key = 'post_views_count';
	$count = get_post_meta($post_id, $count_key, true);
	if($count == ''){
		$count = 0;
		delete_post_meta($post_id, $count_key);
		add_post_meta($post_id, $count_key, '0');
	}else{
		$count++;
		update_post_meta($post_id, $count_key, $count);
	}
}


function snshadona_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment; ?>
    <?php $add_below = ''; ?>
    <li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
        <div class="comment-body">
        	<div class="comment-user-meta">
        		<?php echo get_avatar($comment, 100); ?>
        		<div>
        			<h4 class="comment-user"><?php echo get_comment_author_link(); ?></h4>
	            	<div class="comment-meta"><?php printf(esc_html__('%1$s at %2$s', 'snshadona'), get_comment_date(),  get_comment_time()) ?></div>
    		           <div class="reply">
                      <?php edit_comment_link(esc_html__('Edit', 'snshadona'),'  ','') ?>
                      <?php comment_reply_link(array_merge( $args, array('reply_text' => esc_html__('Reply', 'snshadona'), 'add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth'])))?>
                    </div>
                      <div class="comment-content">
                        <?php if ($comment->comment_approved == '0') : ?>
                        <p>
                            <em><?php echo esc_html__('Your comment is awaiting moderation.', 'snshadona') ?></em><br />
                        </p>
                        <?php endif; ?>
                         <?php comment_text() ?>
                       
                    </div>
                </div>

        	</div>
            
        </div>
  <?php 
}
/** 
 *	Breadcrumbs
 **/
function snshadona_breadcrumbs(){
    $template_name = '/tpl-breadcrumb.php';
	if(is_file(SNSHADONA_THEME_DIR.$template_name)) {
        include(SNSHADONA_THEME_DIR.$template_name);
    }
}

/*
 * Woocommerce advanced search functionlity
 */
add_action('pre_get_posts', 'snshadona_advanced_search_query', 1000);
function snshadona_advanced_search_query($query){
	if($query->is_search()) {
		// Category terms search
		if( isset($_GET['snshadona_woo_category']) && !empty($_GET['snshadona_woo_category']) ){
			$query->set('tax_query', array(array(
				'taxonomy' 	=> 'product_cat',
				'field'		=> 'slug',
				'term'		=> array($_GET['snshadona_woo_category']) )
			));
		}
	}
	return $query;
}

/* Sample data */
add_action( 'admin_enqueue_scripts', 'snshadona_importlib' );
function snshadona_importlib(){
    wp_enqueue_script('sampledata', SNSHADONA_THEME_URI . '/framework/sample-data/assets/script.js', array('jquery'), '', true);
    wp_enqueue_style('sampledata-css', SNSHADONA_THEME_URI . '/framework/sample-data/assets/style.css');
}
add_action( 'wp_ajax_sampledata', 'snshadona_importsampledata' );
function snshadona_importsampledata(){
    include_once(SNSHADONA_THEME_DIR . '/framework/sample-data/sns-importdata.php');
    snshadona_importdata();
}

function snshadona_brightness($colourstr, $steps) {
    $colourstr = str_replace('#','',$colourstr);

    $rhex = substr($colourstr,0,2);
    $ghex = substr($colourstr,2,2);
    $bhex = substr($colourstr,4,2);

    $r = hexdec($rhex);
    $g = hexdec($ghex);
    $b = hexdec($bhex);

    $r = dechex(max(0,min(255,$r + $steps)));
    $g = dechex(max(0,min(255,$g + $steps)));  
    $b = dechex(max(0,min(255,$b + $steps)));

    $r = str_pad($r,2,"0",STR_PAD_LEFT);
    $g = str_pad($g,2,"0",STR_PAD_LEFT);
    $b = str_pad($b,2,"0",STR_PAD_LEFT);

    $cor = '#'.$r.$g.$b;

    return $cor;
}

?>