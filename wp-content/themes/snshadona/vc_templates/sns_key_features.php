<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
wp_enqueue_script( 'waypoints' );
$uq = rand().time();
$class = '';
$class .= ( trim(esc_attr($extra_class))!='' )?' '.esc_attr($extra_class):'';
$class .= esc_attr($this->getCSSAnimation( $css_animation ));

$data_number_display = '';
if($key_featrues_image != ''){
	$key_featrues_image = preg_replace('/[^\d]/', '', $key_featrues_image);
	$img =   wp_get_attachment_image_src( $key_featrues_image , '');
}
$output = '
<div id="sns_key_feature'.esc_attr($uq).'" class="'.esc_attr($class).'" '.$data_number_display.'>';
	$output .='<div class="sns-key-feature-wrap">';
	if ( $title != '' ) $output .= '<h2 class="wpb_heading"><span>'.esc_html($title).'</span></h2>';
	if($key_featrues_image != ''):
	$output .='<div class="image"><img src="'.$img[0].'" alt="" /></div>';
	endif;
	$output .= wpb_js_remove_wpautop( $content );
	$output .='</div>';
$output .='</div>';

echo $output;
?>