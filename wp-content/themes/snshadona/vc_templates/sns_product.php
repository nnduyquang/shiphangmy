<?php
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
//if( !empty($id) ) continue;
if( class_exists('WooCommerce') ){
	$uq = rand().time();
	$class = 'sns_product woocommerce';
	$class .= ( trim(esc_attr($extra_class))!='' )?' '.esc_attr($extra_class):'';
	$class .= esc_attr($this->getCSSAnimation( $css_animation ));

	$args = array(
        'post_type' => 'product',
        'posts_per_page' => '1',
        'p'		=> $id,
        'post_status' => 'publish',
    );
	$product = new WP_Query($args);
	if( $product->have_posts() ): $product->the_post();
		ob_start();	
			$pr = wc_get_product(get_the_ID());
			?>
			<div id="sns_product-<?php echo $uq; ?>" class="<?php echo esc_attr( $class ); ?>">
				<div class="p-thumbnail-wrap <?php echo ($pr->product_type === 'variable') ? ' sns-product-type-variable' : '';?>">
					<div class="p-thumbnail">
					<?php
					if(has_post_thumbnail()){?>
					<a class="product-image" href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title();?>">
						<?php
							the_post_thumbnail('snshadona_product_sc_image_size');
						?>
					</a>
					<?php
						if( $pr->product_type === 'variable')
								do_action( 'sns_show_product_loop_variable' );
					?>
					<?php
					}
					?>
					</div>
				</div>
				<div class="p-info">
					<h2 class="p-title">
						<a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title();?>">
						<?php the_title();?>
						</a>
					</h2>
					<div class="p-desc" itemprop="description">
						<?php the_excerpt(); ?>
					</div>
					<div class="p-price">
						<span class="p-price-desc"><?php esc_html_e( 'Price just', 'snshadona' );?></span><div class="price-s"><?php woocommerce_template_single_price(); ?></div>
					</div>
					<div class="p-action">
						<a href="<?php the_permalink(); ?>" class="p-button" title="<?php esc_attr_e( 'Buy now', 'snshadona' );?>"><?php esc_html_e( 'Buy now', 'snshadona' );?></a>
					</div>
				</div>
			</div> 	
			<?php
		$output .= ob_get_clean();
	endif;
	wp_reset_postdata();
}
echo $output;
