<?php
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if( class_exists('WooCommerce') ){
	$uq = rand().time();
	$class = 'sns_variable_product woocommerce';
	$class .= ( trim(esc_attr($extra_class))!='' )?' '.esc_attr($extra_class):'';
	$class .= esc_attr($this->getCSSAnimation( $css_animation ));

	ob_start();	
		?>
		<div id="sns_variable_product-<?php echo $uq; ?>" class="<?php echo esc_attr( $class ); ?>">
			
		</div> 	
		<?php
	$output .= ob_get_clean();
	wp_reset_postdata();
}
echo $output;
