<?php
/**
 * This template to display Variation select product anywhere.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
$available_variations = $product->get_available_variations();

?>
		<div class="variations-product-wrap">
			<?php foreach ( $attributes as $attribute_name => $options ) : ?>
				<?php 
				$terms = wc_get_product_terms( $product->id, $attribute_name, array( 'fields' => 'all' ) );
				?>
				<div class="variable-item">
					<?php
						foreach ($terms as $term) {
							$type = get_woocommerce_term_meta( $term->term_id, 'snshadona_product_attribute_type' );
							$type = ($type == '') ? 'text' : $type;

							// Get available variation image src
							$image_src = '';
							foreach ($available_variations as $available_variation) {
								if($term->slug === $available_variation['attributes']["attribute_$term->taxonomy"]){
									$image_src = $available_variation['image_src'];
									switch ($type) {
										case 'color':
											$color = get_woocommerce_term_meta( $term->term_id, 'snshadona_product_attribute_color' );
											?>
											<a href="#" class="option color" title="<?php echo esc_attr( $term->name );?>" data-toggle="tooltip" data-original-title="<?php echo esc_attr( $term->name );?>" data-value="<?php echo esc_attr( $term->slug );?>" data-image-src="<?php echo esc_url( $image_src );?>"><span style="background:<?php echo esc_attr( $color );?>"></span></a>
											<?php
											break;

										case 'image':
											$att_image_id = get_woocommerce_term_meta( $term->term_id, 'snshadona_product_attribute_image_id' );
	                                        $att_image = wp_get_attachment_image_src( $att_image_id, 'snshadona_attribute_pa_images_size' );
	                                        $att_image_url = (isset($att_image['0'])) ? $att_image['0'] : '';
											?>
											<a href="#" class="option image" title="<?php echo esc_attr( $term->name );?>" data-toggle="tooltip" data-original-title="<?php echo esc_attr( $term->name );?>" data-value="<?php echo esc_attr( $term->slug );?>" data-image-src="<?php echo esc_url( $image_src );?>"><span style="background-image:url(<?php echo esc_url( $att_image_url );?>);"></span></a>
											<?php
											break;
										
										default: // type text
											?>
											<a href="#" class="option text" title="<?php echo esc_attr( $term->name );?>" data-toggle="tooltip" data-original-title="<?php echo esc_attr( $term->name );?>" data-value="<?php echo esc_attr( $term->slug );?>" data-image-src="<?php echo esc_url( $image_src );?>"><span><?php echo esc_attr( $term->name );?></span></a>
											<?php
											break;
									}
								}
							}
						}
					?>
				</div>
	        <?php endforeach;?>
		</div>