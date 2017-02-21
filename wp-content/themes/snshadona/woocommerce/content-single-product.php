<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>
<?php 
$the_sidebar = wp_get_sidebars_widgets();
$show_product_sidebar = get_post_meta( get_the_ID(), 'snshadona_product_sidebar', true );
if($show_product_sidebar == '') $show_product_sidebar = snshadona_themeoption('single_product_sidebar');


?>


<?php 
	$col_tab_products_block = 12;
	$col_prod_sidebar = 0;
	$col_img = 6;
	$class='';
	if (  $show_product_sidebar == '1') :
		$col_tab_products_block = 10;
		$col_prod_sidebar = 2;
		$col_img = 5;
		$class='have-product-sidebar';
	endif;
?>


<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<div class="second_block row <?php echo $class ?> clearfix">		
		<div class="sns_tab_products_block col-lg-<?php echo $col_tab_products_block; ?> col-sm-12">	
			<div class="primary_block sns_main_products row clearfix">
				<div class="entry-img col-md-<?php echo $col_img ?> col-sm-6">
					<div class="inner">
				<?php
					/**
					 * woocommerce_before_single_product_summary hook
					 *
					 * @hooked woocommerce_show_product_sale_flash - 10
					 * @hooked woocommerce_show_product_images - 20
					 */
					
					do_action( 'woocommerce_before_single_product_summary' );
				?>
					</div>
				</div>
				<div class="summary entry-summary col-md-<?php echo 12-$col_img ?> col-sm-6">

					<?php
						/**
						 * woocommerce_single_product_summary hook
						 *
						 * @hooked woocommerce_template_single_title - 5
						 * @hooked woocommerce_template_single_rating - 10
						 * @hooked woocommerce_template_single_price - 10
						 * @hooked woocommerce_template_single_excerpt - 20
						 * @hooked woocommerce_template_single_add_to_cart - 30
						 * @hooked woocommerce_template_single_meta - 40
						 * @hooked snshadona_woo_addthis - 22
						 */
	
						do_action( 'woocommerce_single_product_summary' );
					?>
						
						
						
				</div><!-- .summary -->
			</div> <!-- /.primary_block -->
		
			
			<div class="product_data">
				<?php
					/**
					 * woocommerce_after_single_product_summary hook
					 *
					 * @hooked woocommerce_output_product_data_tabs - 10
					 * @hooked woocommerce_upsell_display - 15
					 * @hooked woocommerce_output_related_products - 20
					 */
					//remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
					//remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
					//remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

					if( $col_prod_sidebar > 0){ // Output product up sells in sidebar.
						remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
					}
					do_action( 'woocommerce_after_single_product_summary' );
				?>
		
				<meta itemprop="url" content="<?php the_permalink(); ?>" />
			</div>
		</div> 
		<?php if( $col_prod_sidebar > 0): ?>
			<div id="sns-product-sidebar" class="sns-right col-lg-<?php echo $col_prod_sidebar; ?> col-sm-12">
				<?php dynamic_sidebar( 'product-sidebar' ); ?>
				<?php 
				// Output product up sells.
				woocommerce_upsell_display(); ?>
			</div>
		<?php endif; ?>
	</div><!--  second_block -->
</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>