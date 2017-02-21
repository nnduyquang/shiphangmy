<?php
/**
 * SNS Get theme options - post meta.
 * This function to get the options in theme option and the page config.
 * The option in page config will priority than the option in theme option if set.
 * 
 * @param string $option ID of the option to get. Required.
 * @param string|int|null $default Return to default value. Optional.
 * @param string $key. Enter the key if the $option is an array. Default leave blank. Optional.
 * 					   This only support for theme option.
 * 
 * @return the value of theme option or page config. If the page config leave blank or "def" return theme option.
 */

function snshadona_set_themeoption($key, $value){
	global $snshadona_opt;
	if ( $key != '' && $value != '' )
		$snshadona_opt[$key] = $value;
}
function snshadona_themeoption($option, $default = '', $key = ''){
	global $snshadona_obj;
	return ($snshadona_obj->snshadona_getOption($option, $default, $key)) ? $snshadona_obj->snshadona_getOption($option, $default, $key) : $default;
}

function snshadona_getOption($param, $type = null){
    global $snshadona_opt, $post;
    $value = '';
    // Get config via theme option
    if ( isset($snshadona_opt[$param]) && $snshadona_opt[$param] ) $value = $snshadona_opt[$param];
    if ( $type == 'image' && isset( $value['url'] ) ) $value = $value['url'];
    // Get config via cookie
    if ( isset($_COOKIE['snshadona_'.$param]) && $_COOKIE['snshadona_'.$param] != '' ) {
        $value = $_COOKIE['snshadona_'.$param];
    }
    // Dont exist config for post & page
    if ( !isset( $post ) ) return $value;
    // Get config via page config
    if ( function_exists('rwmb_meta') ){
    	// Dont apply config for page/post
    	if( rwmb_meta('snshadona_enablelayoutconfig') == '0' ) return $value;
    	// Apply config for page/post
	    if( $type != null && $type == 'image'){

	    	if( rwmb_meta('snshadona_'.$param) ){
		    	foreach ( rwmb_meta('snshadona_'.$param) as $image ) {
		    		$value = $image['full_url'];
		    	}
		    }
	    }else if( function_exists('is_shop') && is_shop() && rwmb_meta('snshadona_'.$param, array(), get_option('woocommerce_shop_page_id')) ) {
			$value = rwmb_meta('snshadona_'.$param, array(), get_option('woocommerce_shop_page_id'));
		}else if( rwmb_meta('snshadona_'.$param) ){
	    	$value = rwmb_meta('snshadona_'.$param);
	    }
	}
    // if ( function_exists('rwmb_meta') && rwmb_meta('snshadona_'.$param) && !is_search() ) $value = rwmb_meta('snshadona_'.$param);
    return $value;
}
/*
 * get meta box data
 */
function snshadona_metabox($field_id, $args = array()){
	if( !function_exists('rwmb_meta') ){
		return '';
	}
	if( function_exists('is_shop') && is_shop() ) {
		return rwmb_meta($field_id, $args, get_option('woocommerce_shop_page_id'));
	}
	return rwmb_meta($field_id, $args);
}
/**
 * return number of published sticky posts
 */
function snshadona_get_sticky_posts_count(){
	global $wpdb;
	$sticky_posts = array_map('absint', (array)get_option('sticky_posts') );
	return count($sticky_posts) > 0 ? $wpdb->get_var( $wpdb->prepare( "SELECT COUNT( 1 ) FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' AND ID IN (".implode(',', $sticky_posts).")" ) ) : 0;
}

/**
 * Display Ajax loading
 * 
 * @param $content_div (string) ID of the DIV which contains items
 * @param $template (string) Name of the template file hold HTML for a single item.
 */
function snshadona_paging_nav_ajax( $content_div = '#snsmain', $template = '' ){
	// Don't print empty markup if there is only one page.
	if( $GLOBALS['wp_query']->max_num_pages < 2 ){
		return;
	}
	
	?>
	<nav class="navigation-ajax" role="navigation">
		<a href="javascript:void(0)" data-target="<?php echo esc_attr($content_div);?>" data-template="<?php echo esc_attr($template); ?>" id="navigation-ajax" class="load-more">
			<span><?php echo esc_html__('Load More', 'snshadona');?></span>
			<div class="sns-navloading"><div class="sns-navloader"></div></div>
		</a>
	</nav>
	<?php
}

/**
 * Display navigation to next/previous post when applicable.
 */
function snshadona_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<div class="post-standard-navigation navigation post-navigation" role="navigation">
	    	<?php 
        	if( $previous ):
        	?>
	        <div class="nav-previous">
	            <div class="area-content">
	            	<?php
	            	previous_post_link('%link',''); // link overlay
	                ?>
	                <div class="nav-content">
	                	<?php 
	                		previous_post_link( '<div class="nav-post-link">%link</div>', _x( 'Previous post', 'Previous post link', 'snshadona' ) );
						
							previous_post_link( '<div class="nav-post-title">%link</div>');?>	
	                </div>
	            </div>
	        </div>
	        <?php endif; ?>
	        <?php if( $next ): ?>
	        <div class="nav-next">
	            <div class="area-content ">
	            	<?php
	            	next_post_link( '%link',''); // link overlay
	                ?>
	                <div class="nav-content">
	                	<?php 
	                		next_post_link( '<div class="nav-post-link">%link</div>', _x( 'Next post', 'Next post link', 'snshadona' ) );
						
							next_post_link( '<div class="nav-post-title">%link</div>');?>
								
	                </div>
	            </div>
	        </div>
	        <?php endif; ?>
	</div>
	
	
	<?php
}

/*
 * snshadona_featured_image_shop_page hook
 */
add_filter('snshadona_featured_image_shop_page', 'snshadona_featured_image_shop_page');
function snshadona_featured_image_shop_page(){
	global $post;
	$page_id = '';
	if( is_shop() ){
		$page_id = woocommerce_get_page_id('shop');
		// Check has post thumbnai
		if(has_post_thumbnail($page_id)): // return html featured image shop page
		?>
			<div class="sns-shop-page-thumbnail"><?php echo get_the_post_thumbnail($page_id, 'full')?></div>
		<?php
		endif;
	}
}

if( !function_exists('sns_yith_woocompare') ){
	function sns_yith_woocompare(){
		global $product;
		if( class_exists( 'YITH_Woocompare' ) ) {
                $action_add = 'yith-woocompare-add-product';
                $url_args = array(
                    'action' => $action_add,
                    'id' => $product->id
                );
                ?>
                <a data-original-title="<?php echo esc_html( get_option('yith_woocompare_button_text') ); ?>" data-toggle="tooltip" href="<?php echo esc_url( wp_nonce_url( add_query_arg( $url_args ), $action_add ) ); ?>" class="compare btn btn-primary-outline" data-product_id="<?php echo esc_attr( $product->id ); ?>">
                </a>
        <?php }
	}
}

if( !function_exists('sns_yith_wcwl_add_to_wishlist') ){
	function sns_yith_wcwl_add_to_wishlist(){
		if( class_exists( 'YITH_WCWL' ) ) {
			echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
		}
	}
}