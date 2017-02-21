<?php
wp_enqueue_script('owlcarousel');
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

global $post;
$args = array(
	'post_status' => 'publish',
	'post_type' => 'post',
	'orderby' => 'date',
	'order' => 'DESC',
	'posts_per_page' => (int)$number_limit,
	'ignore_sticky_posts' => 1,
);
 
$uq = rand().time();

$lp_query = new WP_Query( $args );

$class = 'sns-latest-posts pre-load ';
$class .= ( trim($extra_class)!='' )?' '.esc_attr($extra_class):'';
$class .= esc_attr($this->getCSSAnimation( $css_animation ));
$class .= esc_attr($text_align);

if( $lp_query->have_posts() ) :
	$output .= '<div id="sns_latestpost'.$uq.'" class="'.$class.'">';
	$output .= '<div class="wrapper-latest-posts">';
	if ( $prefix != '' ) $output .= '<p class="wpb_prefix">'.esc_attr($prefix).'</p>';
	if ( $title != '' ) $output .= '<h2 class="wpb_heading">'.esc_attr($title).'</h2>';
	$output .= '<div class="navslider"><span class="prev"></span><span class="next"></span></div>';
	$output .= '</div>';
	$output .= '<ul>';
	while ( $lp_query->have_posts() ) : $lp_query->the_post();
		$output .= '<li class="item-post">';
			$output .= '<div class="post-content">';
			
				if(has_post_thumbnail()):
				$output .= '<div class="post-thumb">';
					$output .= '<a class="post-author" href="'. esc_url(get_permalink()) .'">';
					$output .= get_the_post_thumbnail(get_the_ID(), 'snshadona_latest_posts_thumbnail_size');
					$output .= '</a>';
					if ( $show_date == '1'){
						$output .= '<div class="date-blog">'.'<span class="day">'.get_the_date('d').'</span>'.'<span class="month">'.get_the_date('M').'</span>'.'</div>';
					}
				$output .= '</div>';
				endif;
				$output .= '<div class="post-info">';
					$output .= '<div class="info-inner">';
						$output .= '<div class="post-title"><a href="'.esc_url( get_permalink() ).'">'.get_the_title().'</a>';	
						if ( $show_author == '1'){
						$output .= '<span class="post-author">'.esc_html__('By', 'snshadona').'<a href="'.esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) )) .'">'.get_the_author_meta('nickname').'</a></span>';
						}	
						$output .= '</div>'	;								
						$output .= '<div class="post-excerpt">' . get_the_excerpt() . '</div>';		
						if ( $show_readmore == '1'){				
						$output .= '<a class="read-more" href="'.esc_url( get_permalink() ).'" title="">'.esc_html__('Read more', 'snshadona').'</a>';
						}	
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</li>';
	endwhile;
	
	$output .= '</ul>';
	$output .= '</div>';
	ob_start();
	?>
	<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('#sns_latestpost<?php echo $uq;?>').removeClass('pre-load');

		jQuery('#sns_latestpost<?php echo $uq;?> ul').owlCarousel({
			items: 3,
			responsive : {
			    0 : { items: 1 },
			    480 : { items: 2 },
			    768 : { items: 2 },
			    992 : { items: 3 },
			    1200 : { items:3 }
			},
			loop:true,
	        dots: false,
		    // autoplay: true,
	        onInitialized: callback,
	        slideSpeed : 800
		});
		function callback(event) {
				if(this._items.length > this.options.items){
		        jQuery('#sns_latestpost<?php echo $uq;?> .navslider').show();
		    }else{
		        jQuery('#sns_latestpost<?php echo $uq;?> .navslider').hide();
		    }
		}
		jQuery('#sns_latestpost<?php echo $uq;?> .navslider .prev').on('click', function(e){
			e.preventDefault();
			jQuery('#sns_latestpost<?php echo $uq;?> ul').trigger('prev.owl.carousel');
		});
		jQuery('#sns_latestpost<?php echo $uq;?> .navslider .next').on('click', function(e){
			e.preventDefault();
			jQuery('#sns_latestpost<?php echo $uq;?> ul').trigger('next.owl.carousel');
		});
	});
	</script>
	<?php
	$output .= ob_get_clean();
endif;
/* Restore original Post Data */
wp_reset_postdata();
echo $output;
