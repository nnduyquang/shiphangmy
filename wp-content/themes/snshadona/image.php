<?php
$snshadona_lclass = '';
$snshadona_rclass = '';
$snshadona_mclass = '';
$snshadona_hasL = 0;
$snshadona_hasR = 0;

$snshadona_layouttype = snshadona_themeoption('layouttype', 'l-m');

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
			    <?php
			    if ( have_posts() ) :
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					    <h1 class="page-header">
					        <?php the_title(); ?>
					    </h1>
						<div class="entry-attachment">
							<?php
								echo wp_get_attachment_image( get_the_ID(), 'large' );
							?>
							<?php if ( has_excerpt() ) : ?>
								<div class="entry-caption">
									<?php the_excerpt(); ?>
								</div>
							<?php endif; ?>

						</div>
						<nav id="image-navigation" class="navigation image-navigation">
							<div class="nav-links">
								<div class="nav-previous"><?php previous_image_link( false, esc_html__( 'Previous Image', 'snshadona' ) ); ?></div><div class="nav-next"><?php next_image_link( false, esc_html__( 'Next Image', 'snshadona' ) ); ?></div>
							</div>
						</nav>
					    <div class="post-content">
					        <?php 
					        the_content();
					        ?>
					    </div>
					    <div class="wp_postmeta">
					        <span class="separator">|</span><span class="user-post"><i class="fa fa-user"></i> <?php the_author_posts_link(); ?></span>
					        <span class="separator">|</span><span class="date-post"><i class="fa fa-calendar-o"></i> <?php the_time('F jS, Y'); ?></span>
					        <?php edit_post_link(esc_html__('Edit','snshadona'), '<span class="separator">|</span><span class="edit-post"><i class="fa fa-edit"></i> ', '</span>'); ?>
					        <?php
					        // List categories
					        $categories_list = get_the_category_list( esc_html__( ', ', 'snshadona' ) );
					        if ( $categories_list ) {
					            echo '<span class="separator">|</span><span class="categories-links">'.esc_html__( 'In 2', 'snshadona' ) ) . $categories_list . '</span>';
					        }
					        // List tags
					        $tag_list = get_the_tag_list( '', esc_html__( ', ', 'snshadona' ) );
					        if ( $tag_list ) {
					            echo '<span class="separator">|</span><span class="tags-links"><i class="fa fa-tags"></i> ' . $tag_list . '</span>';
					        }
					        // Retrieve attachment metadata.
					        if ( is_attachment() && wp_attachment_is_image() ) {
								$metadata = wp_get_attachment_metadata();

								printf( '<span class="separator">|</span><span class="full-size-link"><span class="screen-reader-text">%1$s </span><a href="%2$s">%3$s &times; %4$s</a></span>',
									_x( 'Full size', 'Used before full size attachment link.', 'snshadona' ),
									esc_url( wp_get_attachment_url() ),
									$metadata['width'],
									$metadata['height']
								);
							}
					        ?>
					    </div>
					    <?php
					    // Post Comment
					    if ( comments_open() || get_comments_number() ) :
					        comments_template();
					    endif;
					    ?>
					</article>
				<?php
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
			        dynamic_sidebar( snshadona_themeoption('rightsidebar') ); 
			    }
			    ?>
			</div>
			<?php endif ?>
		</div>
	</div>
</div>
<!-- End Content -->
<?php get_footer(); ?>