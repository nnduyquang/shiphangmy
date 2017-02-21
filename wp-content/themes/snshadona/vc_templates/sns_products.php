<?php
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
if ( isset($animate) && $animate){
    $animate = $animate;
}else{
    $animate = '';
}
if( class_exists('WooCommerce') ){
	$loop = snshadona_woo_query($type, $number_limit);
	$template = !empty($template) ? $template : '1';
	
	$uq = rand().time();
	$row = 1;
	$class = 'sns-products woocommerce';
	$class .= ( trim(esc_attr($extra_class))!='' )?' '.esc_attr($extra_class):'';
	$class .= esc_attr($this->getCSSAnimation( $css_animation ));
	if($template == '1'){ // Template carousel 
		wp_enqueue_script('owlcarousel');
		
		//if($row == '2') $class .= ' sns-products-style-two';
		if( $loop->have_posts() ) :
		$output .= '<div id="sns_products'.$uq.'" class="'.$class.'">';
		
		$output .= '<div class="sns_products_heading">';
		if ( $prefix != '' ) $output .= '<div class="prefix">'.esc_html($prefix) .'</div>';
		if ( $title != '' ) $output .= '<h2 class="wpb_heading"><span>'.esc_html($title).'</span></h2>';
		$output .= '<div class="navslider"><span class="prev"></span><span class="next"></span></div>';
		$output .= '</div>';
		
		if($show_countdown == 'yes'){
			wp_enqueue_script('countdown');
		}
		ob_start();
		wc_get_template( 'vc/carousel.php', array('loop' => $loop, 'number_display' => intval($number_display_1600), 'number_display_1200' => intval($number_display_1200), 'number_display_992' => intval($number_display_992), 'number_display_768' => intval($number_display_768), 'number_display_480' => intval($number_display_480), 'row' => $row, 'id' => 'sns_products'.$uq, 'show_countdown' => $show_countdown) );
		$output .= ob_get_clean();
		$output .= '</div>';
		endif;
	}else{ // Template list of products
		$class .= ' sns-products-list ' . esc_attr($type); 
		if( $loop->have_posts() ) :
			$output .= '<div id="sns_products-list'.$uq.'" class="'.$class.'">';
			$title = !empty($title) ? $title : 'Product list';
			$output .= '<div class="sns_products_heading">';
			
			$output .= '<h2 class="sns_products-list_heading"><span>'.esc_attr($title).'</span></h2></div>';
			$output .= '<div class="products-list">';
			ob_start();
				 woocommerce_product_loop_start();
				while ( $loop->have_posts() ) : $loop->the_post();
				    	wc_get_template( 'vc/item.php');
				endwhile;
				woocommerce_product_loop_end(); 
			$output .= ob_get_clean();
			$output .= '</div>';
			$output .= '</div>';
		endif;
	}
	
	wp_reset_postdata();
}
echo $output;
