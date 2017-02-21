<?php // Template Name: Side page(demo shortcodes) 
 $snshadona_lclass = '';
 $snshadona_mclass ='';
$snshadona_fullwidth = snshadona_themeoption('use_fullwidth');
if($snshadona_fullwidth == '1'){
	 $snshadona_lclass .= 'col-lg-2';
	 $snshadona_mclass = 'col-lg-10';  
}
else{
	 $snshadona_lclass .= 'col-md-3';
	 $snshadona_mclass = 'col-md-9';
}
?>
<?php get_header(); ?>

<!-- Content -->

<div id="sns_content">
	<div class="container">
		<div class="row sns-content">
			<!-- left sidebar -->
			<div class="<?php echo esc_attr($snshadona_lclass) ?> sns-left">
				<aside class="widget">
					<h3 class='sidebar-shortcodes'><span><?php echo esc_html__('Shortcodes Demo','snshadona'); ?></span></h3>
				    <ul class="side-navigation">
		            <?php 	
						$post_ancestors = get_post_ancestors($post->ID);
						$post_parent = end($post_ancestors);
						if($post_parent) {
							$children = wp_list_pages("title_li=&child_of=".$post_parent."&echo=0");
						} else {
							$children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0");
						}
						if ($children) { echo $children;  } ?>
		            </ul>
				</aside>
			</div>
			<!-- Main content -->
			<div class="<?php echo esc_attr($snshadona_mclass) ?> sns-main">
			    <?php
			    if ( have_posts() ) :
			        get_template_part( 'framework/tpl/page/content' );
			    else:
			        get_template_part( 'content', 'none' );
			    endif; ?>
			</div>
		</div>
	</div>
</div>
<!-- End Content -->
<?php get_footer(); ?>