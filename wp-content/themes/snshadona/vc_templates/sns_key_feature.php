<?php
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$uq = rand().time();
$class = 'sns-featured-category item';
$class .= ( trim(esc_attr($extra_class))!='' )?' '.esc_attr($extra_class):'';
$class .= esc_attr($this->getCSSAnimation( $css_animation ));

$cat = get_term_by( 'slug', $category, 'product_cat');

$output = '<div class="'.esc_attr($class).'">';

$output .= '<div class="sns-featured-category-wrap">';
$output .= '<a href="'.esc_url(get_term_link($category, 'product_cat')).'">';
if($cat_featured_image != ''){
	$cat_thumb = wp_get_attachment_image_src( $cat_featured_image, 'fulll');
	if( isset($cat_thumb['0']) )
	$output .= '<div class="cat-thumb-wrap"><img class="cat-thumb" src="'. $cat_thumb['0'] .'" alt=""/></div>';
}
$output .= '<div class="cat-info">';
$output .= '<h3 class="cat-title">'.$cat->name.'</h3>';
$output .= '<div class="cat-desc-html">'.$content.'</div>';
$output .= '<span class="cat-desc">'.esc_html__( 'View all now', 'snshadona' ).'<i class="arrow_carrot-right_alt2"></i></span>';
$output .= '</div>';
$output .= '</a>';
$output .= '</div>';

$output .= '</div>';

echo $output;