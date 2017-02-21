<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop, $yith_woocompare;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

//Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';
if ($woocommerce_loop['columns'] == '5')
	$classes[] .= 'column2lg4';
if ($woocommerce_loop['columns'] == '6')
	$classes[] .= 'column2m4';
if ( !is_product() && !is_cart() ) :
	$col = 12/$woocommerce_loop['columns'];
	$col2 = 12/($woocommerce_loop['columns']-1);
	$col3 = 12/($woocommerce_loop['columns']-2);
	$classes[] = 'col-lg-'.$col.' col-md-'.$col2.' col-sm-'.$col3.' col-xs-12';
endif;

 	$product_cats = wp_get_post_terms( get_the_ID(), 'product_cat' );
    $single_cat = array_shift( $product_cats );
    $cat_title = $single_cat->name;
    $cat_link = $single_cat->term_id;

	// check is variable product - add class
	$classes[] .= ($product->product_type === 'variable') ? ' sns-product-type-variable' : '';
?>
<li <?php post_class( $classes); ?>>
	<div class="block-product-inner grid-view">
		<div class="item-inner">
			<div class="item-img have-iconew have-additional clearfix">
				<div class="item-img-info">
					  <?php if ( class_exists('YITH_WCQV_Frontend') ) { ?>
			            	<a data-original-title="<?php echo esc_html( get_option('yith-wcqv-button-label') ); ?>" data-toggle="tooltip" data-product_id="<?php echo esc_attr($product->id) ?>" class="button yith-wcqv-button" href="#"></a>
			            <?php } ?>
					<a class="product-image" href="<?php the_permalink(); ?>">
						<?php
							/**
							 * woocommerce_before_shop_loop_item_title hook
							 *
							 * @hooked woocommerce_show_product_loop_sale_flash - 10
							 * @hooked woocommerce_template_loop_product_thumbnail - 10
							 */
							//add_action ( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10); 
							//remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
							add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
							do_action( 'woocommerce_before_shop_loop_item_title' );
						?>
							
					</a>
					
				</div>
			</div>
			<div class="item-info">
				<div class="info-inner">
					<div class="item-content">
						<?php
							/**
							 * woocommerce_after_shop_loop_item_title hook
							 *
							 * @hooked woocommerce_template_loop_rating - 5
							 * @hooked woocommerce_template_loop_price - 10
							 */
							remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 5);
							remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
							remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
							// Re-order

							add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 15);
							do_action( 'woocommerce_after_shop_loop_item_title' );
							do_action( 'sns_show_product_loop_variable' );
						?>
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
									remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 15);
									// Re-order

									add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 5);

									do_action( 'woocommerce_after_shop_loop_item_title' );

								?>
								<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
						 	</a>
						 </h3>
						 <div class="item-box-hover">
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
							<?php
				            if( class_exists( 'YITH_WCWL' ) ) {
				                echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
				            }
				            ?>

				            <?php if( class_exists( 'YITH_Woocompare' ) ) { ?>
				                <?php
				                $action_add = 'yith-woocompare-add-product';
				                $url_args = array(
				                    'action' => $action_add,
				                    'id' => $product->id
				                );
				                ?>
				                <a data-original-title="<?php echo esc_html__('Add to compare', 'snshadona'); ?>" data-placement="top" data-toggle="tooltip" href="<?php echo esc_url( wp_nonce_url( add_query_arg( $url_args ), $action_add ) ); ?>" class="compare btn btn-primary-outline" data-product_id="<?php echo esc_attr( $product->id ); ?>">
				                </a>
				            <?php } ?>
							
						</div>
						
					</div>
					
				</div>
			</div>
		</div>
	</div>
	<?php if ( !is_product() && !is_cart() ) : ?>
	<div class="list-view">
		<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
		<div class="item-img">
			<a class="product-image" href="<?php the_permalink(); ?>">
				<?php
					/**
					 * woocommerce_before_shop_loop_item_title hook
					 *
					 * @hooked woocommerce_show_product_loop_sale_flash - 10
					 * @hooked woocommerce_template_loop_product_thumbnail - 10
					 */
					add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
					//add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
					do_action( 'woocommerce_before_shop_loop_item_title' );
				?>
			</a>
		</div>
		<div class="column1">
			<h3 class="product-name item-title"><a class="product-name" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			<?php
				/**
				 * woocommerce_after_shop_loop_item_title hook
				 *
				 * @hooked woocommerce_template_loop_rating - 5
				 * @hooked woocommerce_template_loop_price - 10
				 */
				remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
				remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 5);
				remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
				add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 15);
				do_action( 'woocommerce_after_shop_loop_item_title' );			
			?>
			</h3>
			<?php woocommerce_template_single_excerpt(); ?>
			<?php do_action( 'sns_show_product_loop_variable' ); ?>
		</div>
		<div class="column2">
		<?php
			/**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			//remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
			remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 15);
			add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
			do_action( 'woocommerce_after_shop_loop_item_title' );			
		?>
			 <?php global $product; ?>
			  <p class="custom_stock">
			    <?php
			    echo esc_html__( 'Availability: ', 'snshadona' );?>
			    <span class="<?php  echo esc_attr($product->stock_status); ?>">
			        <?php
			        echo esc_html($product->stock_status);
			        ?>
			    </span>
			 </p>
			<div class="actions-addtocart">
				<?php
				do_action( 'woocommerce_after_shop_loop_item' );
				?>
				<?php
	            if( class_exists( 'YITH_WCWL' ) ) {
	                echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
	            }
	            ?>

	            <?php if( class_exists( 'YITH_Woocompare' ) ) { ?>
	                <?php
	                $action_add = 'yith-woocompare-add-product';
	                $url_args = array(
	                    'action' => $action_add,
	                    'id' => $product->id
	                );
	                ?>
	                <a data-original-title="<?php echo esc_html__('Add to compare', 'snshadona'); ?>" data-toggle="tooltip" href="<?php echo esc_url( wp_nonce_url( add_query_arg( $url_args ), $action_add ) ); ?>" class="compare btn btn-primary-outline" data-product_id="<?php echo esc_attr( $product->id ); ?>">
	               <?php echo esc_html__( 'Add to compare', 'snshadona' ); ?>
	                </a>
	            <?php } ?>
	             <?php if ( class_exists('YITH_WCQV_Frontend') ) { ?>
	            	<a data-original-title="<?php echo esc_html__('Quick view', 'snshadona'); ?>" data-toggle="tooltip" data-product_id="<?php echo $product->id ?>" class="button yith-wcqv-button" href="#">
					 <?php echo esc_html__( 'Quick view', 'snshadona' ); ?>
	            	</a>
	            <?php } ?>
			</div>
		</div>
	</div>
	<div class="list-view-table">
		<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
		<div class="item-img">
			<a class="product-image" href="<?php the_permalink(); ?>">
				<?php
					/**
					 * woocommerce_before_shop_loop_item_title hook
					 *
					 * @hooked woocommerce_show_product_loop_sale_flash - 10
					 * @hooked woocommerce_template_loop_product_thumbnail - 10
					 */
					add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
					//add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
					do_action( 'woocommerce_before_shop_loop_item_title' );
				?>
			</a>
		</div>

		<div class="column1">
			<h3 class="product-name item-title"><a class="product-name" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			<?php
				/**
				 * woocommerce_after_shop_loop_item_title hook
				 *
				 * @hooked woocommerce_template_loop_rating - 5
				 * @hooked woocommerce_template_loop_price - 10
				 */
				remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
				remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 5);
				remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
				add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 15);
				do_action( 'woocommerce_after_shop_loop_item_title' );			
			?>
			</h3>
			<?php // woocommerce_template_single_excerpt(); ?>
			<?php do_action( 'sns_show_product_loop_variable' ); ?>
		</div>
		<div class="column2">	
			<?php
				/**
				 * woocommerce_after_shop_loop_item_title hook
				 *
				 * @hooked woocommerce_template_loop_rating - 5
				 * @hooked woocommerce_template_loop_price - 10
				 */
				//remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
				remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 15);
				add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
				do_action( 'woocommerce_after_shop_loop_item_title' );			
			?>	
			 <?php global $product; ?>
			  <p class="custom_stock">
			    <?php
			    echo esc_html__( 'Availability: ', 'snshadona' );?>
			    <span class="<?php  echo esc_attr($product->stock_status); ?>">
			        <?php
			        echo esc_html($product->stock_status);
			        ?>
			    </span>
			 </p>
		</div>
		<div class="column3">
			<div class="actions-addtocart">
				<?php
				do_action( 'woocommerce_after_shop_loop_item' );
				?>
				<?php
	            if( class_exists( 'YITH_WCWL' ) ) {
	                echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
	            }
	            ?>

	            <?php if( class_exists( 'YITH_Woocompare' ) ) { ?>
	                <?php
	                $action_add = 'yith-woocompare-add-product';
	                $url_args = array(
	                    'action' => $action_add,
	                    'id' => $product->id
	                );
	                ?>
	                <a data-original-title="<?php echo esc_html__('Add to compare', 'snshadona'); ?>" data-toggle="tooltip" href="<?php echo esc_url( wp_nonce_url( add_query_arg( $url_args ), $action_add ) ); ?>" class="compare btn btn-primary-outline" data-product_id="<?php echo esc_attr( $product->id ); ?>">
	               <?php echo esc_html__( 'Add to compare', 'snshadona' ); ?>
	                </a>
	            <?php } ?>
	             <?php if ( class_exists('YITH_WCQV_Frontend') ) { ?>
	            	<a data-original-title="<?php echo esc_html__('Quick view', 'snshadona'); ?>" data-toggle="tooltip" data-product_id="<?php echo $product->id ?>" class="button yith-wcqv-button" href="#">
					 <?php echo esc_html__( 'Quick view', 'snshadona' ); ?>
	            	</a>
	            <?php } ?>
			</div>
		</div>
	</div>
	<?php endif; ?>
</li>
