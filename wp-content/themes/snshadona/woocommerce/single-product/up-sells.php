<?php
/**
 * Single Product Up-Sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

$upsells = $product->get_upsells();

if ( sizeof( $upsells ) == 0 ) {
	return;
}

$meta_query = WC()->query->get_meta_query();
if( empty($posts_per_page) ) $posts_per_page = -1; 

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => $posts_per_page,
	'orderby'             => $orderby,
	'post__in'            => $upsells,
	'post__not_in'        => array( $product->id ),
	'meta_query'          => $meta_query
);

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = $columns;

if ( $products->have_posts() ) :
	wp_enqueue_script('owlcarousel');
	?>

<?php
$the_sidebar = wp_get_sidebars_widgets();
$show_product_sidebar = get_post_meta( get_the_ID(), 'snshadona_product_sidebar', true );
if($show_product_sidebar == '') $show_product_sidebar = snshadona_themeoption('single_product_sidebar');

?>

	<div class="upsells products">
		<div class="sns_products_heading">
			<h2><span><?php esc_html_e( 'Upsell products', 'snshadona' ) ?></span></h2>
			<?php if (  $show_product_sidebar == '' ) : ?>
				<div class="navslider">
					<span class="prev"></span>
					<span class="next"></span>
				</div>
			<?php endif ?>
		</div>
		<?php if (  $show_product_sidebar == '1' ) : ?>
			<div class="sns-products sns-products-style-two">
			<?php woocommerce_product_loop_start(); ?>
				<?php while ( $products->have_posts() ) : $products->the_post(); ?>					
						<?php wc_get_template( 'vc/item.php' );?>
				<?php endwhile; // end of the loop. ?>
			<?php woocommerce_product_loop_end(); ?>
			</div>
		<?php else: ?>
			<?php woocommerce_product_loop_start(); ?>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php wc_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>

		<?php woocommerce_product_loop_end(); ?>
		<?php endif ?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('.sns_tab_products_block.col-lg-12 .upsells ul').owlCarousel({
					items: 6,
					responsive : {
					    0 : { items: 1 },
					    480 : { items: 2 },
					    768 : { items: 3 },
					    992 : { items: 3 },
					    1200 : { items: 4 },
					    1600 : { items: 6 }
					},
					loop:false,
		            dots: false,
		            // animateOut: 'flipInY',
				    //animateIn: 'pulse',
				    autoplay: false,
		            onInitialized: callback,
		            slideSpeed : 800
				});
				function callback(event) {
		   			if(this._items.length > this.options.items){
				        jQuery('.upsells .navslider').show();
				        jQuery('.upsells').addClass('has-nav');
				    }else{
				        jQuery('.upsells .navslider').hide();
				        jQuery('.upsells').removeClass('has-nav');
				    }
				}
				jQuery('.upsells .navslider .prev').on('click', function(e){
					e.preventDefault();
					jQuery('.upsells ul').trigger('prev.owl.carousel');
				});
				jQuery('.upsells .navslider .next').on('click', function(e){
					e.preventDefault();
					jQuery('.upsells ul').trigger('next.owl.carousel');
				});
			});
		</script>
	</div>

<?php endif;

wp_reset_postdata();
