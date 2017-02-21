<?php
$snshadona_lclass = '';
$snshadona_rclass = '';
$snshadona_mclass = '';
$snshadona_hasL = 0;
$snshadona_hasR = 0;

$snshadona_layouttype = snshadona_metabox('snshadona_layouttype', 'm-r');

if( is_product_category() ){
	$cate = get_queried_object();
	$snshadona_layouttype = get_woocommerce_term_meta($cate->term_id, 'snshadona_product_cat_layout');
}
if ( trim($snshadona_layouttype) == '' ) $snshadona_layouttype = 'l-m'; // Tempolary
if( is_product_tag() ){
	$snshadona_layouttype = '';
}
$snshadona_fullwidth = snshadona_themeoption('use_fullwidth');

if( is_product() ){
	$snshadona_mclass = 'col-md-12';
}elseif($snshadona_fullwidth == '1'){
	if ( $snshadona_layouttype == '' || $snshadona_layouttype == 'l-m'){
	    $snshadona_lclass .= 'col-lg-2';
	    $snshadona_mclass = 'col-lg-10';
	    $snshadona_hasL = 1;
	}elseif( $snshadona_layouttype == 'm-r' ){
	    $snshadona_rclass .= 'col-lg-2';
	    $snshadona_mclass = 'col-lg-10';
	    $snshadona_hasR = 1;
	}elseif( $snshadona_layouttype == 'l-m-r' ){
	    $snshadona_lclass .= 'col-lg-2';
	    $snshadona_rclass .= 'col-lg-2';
	    $snshadona_mclass = 'col-lg-8';
	    $snshadona_hasL = 1;
	    $snshadona_hasR = 1;
	}else{
	    $snshadona_mclass = 'col-md-12';
	}
}
else{
	if ( $snshadona_layouttype == '' || $snshadona_layouttype == 'l-m'){
	    $snshadona_lclass .= 'col-md-3';
	    $snshadona_mclass = 'col-md-9';
	    $snshadona_hasL = 1;
	}elseif( $snshadona_layouttype == 'm-r' ){
	    $snshadona_rclass .= 'col-md-3';
	    $snshadona_mclass = 'col-md-9';
	    $snshadona_hasR = 1;
	}elseif( $snshadona_layouttype == 'l-m-r' ){
	    $snshadona_lclass .= 'col-md-3';
	    $snshadona_rclass .= 'col-md-3';
	    $snshadona_mclass = 'col-md-6';
	    $snshadona_hasL = 1;
	    $snshadona_hasR = 1;
	}else{
	    $snshadona_mclass = 'col-md-12';
	}
}
?>
<?php get_header(); ?>
<!-- Content -->
<div id="sns_content">
	<div class="container">
		<div class="row sns-content sns-woocommerce-page">
			<?php if ( apply_filters( 'woocommerce_show_page_title', true ) && is_product_category()) : ?>
				<div class="woo-page-title-wrap">
					<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>
					<span class="count_products">
					<?php
					if( is_shop() ):
						$count_products = wp_count_posts( 'product' );
						echo '('.number_format($count_products->publish). esc_html__(' products', 'snshadona').')';
					elseif ( is_product_category() || is_product_tag()):
						$term_id = $wp_query->get_queried_object()->term_id;
						$term = get_term( $term_id, 'product_cat');
						echo '('.number_format($term->count). esc_html__(' products', 'snshadona').')'; 
					endif;
					?>
					</span>
				</div>
			<?php endif;?>

			<?php if ($snshadona_hasL == 1) :?>
			<!-- left sidebar -->
			<div class="<?php echo esc_attr($snshadona_lclass); ?> sns-left">
			    <?php 
				if( snshadona_metabox('snshadona_leftsidebar')!= '' && is_active_sidebar( snshadona_metabox('snshadona_leftsidebar') ) ){
			        dynamic_sidebar( snshadona_metabox('snshadona_leftsidebar') );
			    }else{
			        dynamic_sidebar( 'woo-sidebar' );
			    }
			    ?>
			</div>
		<?php endif; ?>
			<!-- Main content -->
			<div class="<?php echo esc_attr($snshadona_mclass); ?> sns-main">
			    <?php

		    	if( is_product() ){
					wc_get_template( 'single-product.php' );
				}else{
					wc_get_template( 'listing-product.php' );
				}
				?>
			</div>
			<?php if ($snshadona_hasR == 1): ?>
			<!-- Right sidebar -->
			<div class="<?php echo esc_attr($snshadona_rclass); ?> sns-right">
			    <?php 
			    if( snshadona_metabox('snshadona_rightsidebar')!= '' && is_active_sidebar( snshadona_metabox('snshadona_rightsidebar') ) ){
			        dynamic_sidebar( snshadona_metabox('snshadona_rightsidebar') );
			    }else{
			        dynamic_sidebar( 'woo-sidebar' );
			    }
			    ?>
			</div>
			<?php endif ?>
		</div>
	</div>
</div>
<!-- End Content -->
<?php get_footer(); ?>