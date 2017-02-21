<?php
wp_enqueue_script('owlcarousel');
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$uq = rand().time();

$posts= explode(',', $list_post);
$class = 'sns-post';
$class .= ( trim($extra_class)!='' )?' '.esc_attr($extra_class):'';
$class .= esc_attr($this->getCSSAnimation( $css_animation ));


	$output .= '<div id="sns_post'.$uq.'" class="'.$class.'">';
	$output .= '<div class="wrapper-posts">';
	if ( $title != '' ) $output .= '<h2 class="wpb_heading">'.esc_attr($title).'</h2>';
	$output .= '</div>';
	$output .= '<div class="row">';
	foreach ($posts as $post) {
		$output .= '<div class="col-md-6 item-post">';
		$output .= get_the_post_thumbnail($post, 'snshadona_posts_thumbnail_size');
		$output .= '<div class="info-inner">';
		$output .= '<div class="post-title"><a href="'.esc_url( get_permalink($post) ).'">'.get_the_title($post).'</a>';		
		$output .= '</div>'	;								
		$output .= '<a class="read-more" href="'.esc_url( get_permalink($post) ).'" title="">'.esc_html__('Read more', 'snshadona').'</a>';
				
		$output .= '</div>';
		$output .= '</div>';
	}
	$output .= '</div>';
	$output .= '</div>';
	ob_start();
	?>
	
	<?php
	$output .= ob_get_clean();

/* Restore original Post Data */
wp_reset_postdata();
echo $output;
