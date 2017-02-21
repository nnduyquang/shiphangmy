<?php
global $product, $woocommerce_loop, $yith_woocompare;
?>
<div class="item_product">
	<div class="block-product-inner grid-view">
		<div class="item-inner">
			<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
			<div class="item-info have-iconew have-additional clearfix">
				<div class="item-img-info-left">
					<a class="product-image" href="<?php the_permalink(); ?>">
						<?php
							/**
							 * woocommerce_before_shop_loop_item_title hook
							 *
							 * @hooked woocommerce_show_product_loop_sale_flash - 10
							 * @hooked woocommerce_template_loop_product_thumbnail - 10
							 */
							//remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
							add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
							do_action( 'woocommerce_before_shop_loop_item_title' );
						?>
					</a>
					<?php if ( class_exists('YITH_WCQV_Frontend') ) { ?>
		            	<a data-original-title="<?php echo esc_html( get_option('yith-wcqv-button-label') ); ?>" data-toggle="tooltip" data-product_id="<?php echo esc_attr($product->id) ?>" class="button yith-wcqv-button" href="#"><i class="fa fa-search"></i></a>
		            <?php } ?>
				</div>
				<div class="item-info-right">
					<div class="info-inner">
						<h3 class="item-title">
							<a class="product-name" href="<?php the_permalink(); ?>">
								<?php the_title(); ?>
								 <?php
									/**
									 * woocommerce_after_shop_loop_item_title hook
									 *
									 * @hooked woocommerce_template_loop_rating - 5
									 * @hooked woocommerce_template_loop_price - 10
									 */
									remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
									remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
									// Re-order
									remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 15);
									add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 5);
									do_action( 'woocommerce_after_shop_loop_item_title' );
								?>
								<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
							</a>
						</h3>
						<div class="item-content">
						

							<?php
								/**
								 * woocommerce_after_shop_loop_item_title hook
								 *
								 * @hooked woocommerce_template_loop_rating - 5
								 * @hooked woocommerce_template_loop_price - 10
								 */
								remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
								remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 5);
								remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
								remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
								// Re-order
								//add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);

								add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 15);
								do_action( 'woocommerce_after_shop_loop_item_title' );
							?>
						</div>
					</div>
					<div class="cart-wrap">
						<?php
							/**
							 * woocommerce_after_shop_loop_item hook
							 *
							 * @hooked woocommerce_template_loop_add_to_cart - 10
							 */
							if ( class_exists('YITH_WCQV_Frontend') ) {
								remove_action('woocommerce_after_shop_loop_item',  array( YITH_WCQV_Frontend::get_instance(), 'yith_add_quick_view_button'), 15);
							}
							if ( isset($yith_woocompare) ) {
							    remove_action( 'woocommerce_after_shop_loop_item', array( $yith_woocompare->obj, 'add_compare_link' ), 20 );
							}
							do_action( 'woocommerce_after_shop_loop_item' ); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>