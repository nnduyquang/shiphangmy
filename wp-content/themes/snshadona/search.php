<?php
/**
 * The template for displaying search results pages.
 *
 * @package WordPress
 * @subpackage snstheme
 */

$snshadona_lclass = '';
$snshadona_rclass = '';
$snshadona_mclass = '';
$snshadona_hasL = 0;
$snshadona_hasR = 0;

$snshadona_layouttype = snshadona_themeoption('layouttype', 'l-m');
$snshadona_fullwidth = snshadona_themeoption('use_fullwidth');
if($snshadona_fullwidth == '1'){
	if ( $snshadona_layouttype == 'l-m'){
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
		if ( $snshadona_layouttype == 'l-m'){
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
		<div class="row sns-content">
		    <?php if( $snshadona_hasL == 1): ?>
			<!-- left sidebar -->
			<div class="<?php echo esc_attr($snshadona_lclass); ?> sns-left">
			    <?php 
			    if( class_exists('WooCommerce') && is_woocommerce() ){
			        dynamic_sidebar( 'woo-sidebar'); 
			    }else{
			        if( snshadona_themeoption('leftsidebar')!= '' && is_active_sidebar( snshadona_themeoption('leftsidebar') ) ) :
			        	dynamic_sidebar( snshadona_themeoption('leftsidebar') ); 
			        else :
			        	dynamic_sidebar('widget-area');
			        endif;
			    }
			    ?>
			</div>
			<?php endif; ?>
			<!-- Main content -->
			<div class="<?php echo esc_attr($snshadona_mclass); ?> sns-main">
				<h1 class="page-header"><?php printf( esc_html__( 'Search Results for: %s', 'snshadona' ), get_search_query() ); ?></h1>
			    <?php
			    if ( have_posts() ) :
			    	$pagination = snshadona_themeoption('pagination', 'def'); // get theme option
			    	?>
			    	<div id="snsmain" class="blog-layout2 posts sns-blog-posts ">
				    	<?php 
						// Theloop
						while ( have_posts() ) : the_post();
						    get_template_part( 'content', 'search' );
						endwhile;
						// Paging
						if( $pagination == 'def' || $pagination == '')
							get_template_part('tpl-paging');
						?>
			    	</div>
			    <?php
				    if( $pagination == 'ajax')
				    	snshadona_paging_nav_ajax('#snsmain', 'content-search' ); // This paging nav should be outside #snsmain div
				    
				    echo '<input type="hidden" name="hidden_snshadona_blog_layout" value="' . snshadona_themeoption('blog_type') .  '">';
			    
			    // If no posts found
			    else:
			    	get_template_part( 'content', 'none' );
			    endif; ?>
			</div>
			<?php if ($snshadona_hasR == 1): ?>
			<!-- Right sidebar -->
			<div class="<?php echo esc_attr($snshadona_rclass); ?> sns-right">
			    <?php 
			    if( class_exists('WooCommerce') && is_woocommerce() ){
			        dynamic_sidebar( 'woo-sidebar'); 
			    }else{
			    	if( snshadona_themeoption('rightsidebar')!= '' && is_active_sidebar( snshadona_themeoption('rightsidebar') ) ) :
			    	dynamic_sidebar( snshadona_themeoption('rightsidebar') );
			    	else :
			    	dynamic_sidebar('widget-area');
			    	endif;
			    }
			    ?>
			</div>
			<?php endif ?>
		</div>
	</div>
</div>
<!-- End Content -->
<?php get_footer(); ?>