<?php
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
wp_enqueue_script( 'waypoints' );
$products= explode(',', $list_product);
if( class_exists('WooCommerce') ){	
	if(empty($category)){
		return;
	}
	$image_url = absint($image) ? wp_get_attachment_image_url($image, 'full') : '';
	$term = get_term_by( 'slug', $category, 'product_cat', 'ARRAY_A');
	$term_id = $term['term_id'];
	$uq = rand().time();
	$class = 'sns-category woocommerce';
	$class .= ( trim(esc_attr($extra_class))!='' )?' '.esc_attr($extra_class):'';
	$class .= esc_attr($this->getCSSAnimation( $css_animation ));
	$class .= ' '.esc_attr( $image_alignment );
	

	// $limit = ($excerpt_lenght) ? absint($excerpt_lenght) : 20;
	// $excerpt = explode(' ', $term['description'], $limit);
	// if (count($excerpt)>=$limit) {
	// 	array_pop($excerpt);
	// 	$excerpt = implode(" ",$excerpt).'...';
	// } else {
	// 	$excerpt = implode(" ",$excerpt);
	// }
	// $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
	
	$output .= '<div id="sns_category'.$uq.'" class="'.$class.'">';

	$output .= '<div class="cat_image">';
	
	if ( $image != '' ){
		 $output .= '<img class="image" alt="'.esc_attr($img_title).'" src="'.$image_url.'"/>';
	}
	$output .= '</div>';
	$output .= '<div class="category_content">';
	if ( $category != '' ){
		 $output .= '<h2 class="wpb_heading"><a href="' . esc_url(get_term_link( $term['term_id'], 'product_cat' ) ) . '">'.$term['name'].'</a></h2>';
		 $output .= '<div class="content">'.$content.'</div>';
		 //$output .= '<p class="description">'.$excerpt.'</p>';
		
		foreach ($products as $product) {
			if ($product != '' ){
				$output .= '<a class="img"href="'.esc_url(get_permalink($product)).'">';
				$output .=	get_the_post_thumbnail($product,'snshadona_product_thumbnail_size');
				$output .= '</a>';
			}
		}
		 $output .= '<div class="link"><a href="' . esc_url(get_term_link( $term['term_id'], 'product_cat' ) ) . '">'.esc_html__('View all products','snshadona').'</a></div>';
		
	}
	 $output .= '</div>';
		
	ob_start();
	$output .= ob_get_clean();
	$output .= '</div>';
}
echo $output;
