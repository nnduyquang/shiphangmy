<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

	get_header( 'shop' ); ?>

	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
		add_action( 'woocommerce_before_main_content', 'wc_print_notices', 10 );
		do_action( 'woocommerce_before_main_content' );
	?>
		
		<?php 
		// add category image http://docs.woothemes.com/document/woocommerce-display-category-image-on-category-archive/
		?>
		<?php do_action( 'woocommerce_archive_description' ); ?>
		<div class="listing-product-main">
			<?php if ( have_posts() ) : ?>
			<div class="listing-product-wrap">
				<div class="toolbar toolbar-top">	
					<?php
						/**
						 * woocommerce_before_shop_loop hook
						 *
						 * @hooked woocommerce_result_count - 20
						 * @hooked woocommerce_catalog_ordering - 30
						 */
						 add_action ( 'woocommerce_before_shop_loop', 'wc_print_notices', 10); 
						//remove_action( 'woocommerce_before_shop_loop', 'wc_print_notices', 10 );
						 add_action( 'woocommerce_before_shop_loop', 'snshadona_woo_modeview', 1 );
						// remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
						add_action( 'woocommerce_before_shop_loop_result_count', 'woocommerce_catalog_ordering', 30 );
						//add_action( 'woocommerce_before_shop_loop_result_count', 'woocommerce_result_count', 41 );
						add_action( 'woocommerce_before_shop_loop_pagination', 'woocommerce_pagination', 40 );
						do_action( 'woocommerce_before_shop_loop' );
					?>
				</div>
				<?php //do_action( 'woocommerce_before_shop_loop_result_count', 'woocommerce_pagination', 41 );?>
				<?php //do_action( 'woocommerce_before_shop_loop_pagination', 'woocommerce_pagination', 40 );?>
				<?php woocommerce_product_loop_start(); ?>

					<?php woocommerce_product_subcategories(); ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php wc_get_template_part( 'content', 'product' ); ?>

					<?php endwhile; // end of the loop. ?>

				<?php woocommerce_product_loop_end(); ?>
				<div class="toolbar toolbar-bottom">
				<?php
					/**
					 * woocommerce_after_shop_loop hook
					 *
					 * @hooked woocommerce_pagination - 10
					 */
					add_action( 'woocommerce_after_shop_loop', 'snshadona_woo_modeview', 1 );
					add_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 3 );
					add_action( 'woocommerce_after_shop_loop_result_count', 'woocommerce_result_count', 11 );
					do_action( 'woocommerce_after_shop_loop' );
					add_action( 'woocommerce_after_shop_loop_cs', 'woocommerce_result_count', 2 );
					//add_action( 'woocommerce_after_shop_loop_cs', 'woocommerce_pagination', 12 );
					do_action( 'woocommerce_after_shop_loop_cs' );
				?>
				</div>
				<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>
					<?php wc_get_template( 'loop/no-products-found.php' ); ?>
				<?php endif; ?>
			</div>
			<div id="sns_respmenu" class="sns_respshop_loop menu-offcanvas hidden-lg hidden-md">
				<span class="btn2 btn-navbar after_shop_loop">
				    <span class="overlay"></span>
				</span>
			</div>
			<div class="sns_after_shop_loop">		
				<?php 
				/*
				* sns_after_shop_loop
				*
				* @hooked woo_onsale_layout - 10
				* @hooked woo_custom_block - 11
				*/
				do_action( 'sns_after_shop_loop');
				?>
			</div>
		</div>
<?php //get_footer( 'shop' ); ?>
<script type="text/javascript">
	jQuery(document).ready(function($){	
		//show hidden sns after shop loop
		if($('#sns_content .sns_after_shop_loop').length) {
			$('#sns_respmenu .btn2.after_shop_loop').css('display', 'inline-block').on('click', function(){
				if($('#sns_content .sns_after_shop_loop').hasClass('active')){
					$(this).find('.overlay').fadeOut(250);
					$('#sns_content .sns_after_shop_loop').removeClass('active');
					$('body').removeClass('show-sidebar', 4000);
				} else {
					$('#sns_content .sns_after_shop_loop').addClass('active');
					$(this).find('.overlay').fadeIn();
					$('body').addClass('show-sidebar');
				}
			});
		}
	});	
</script>