<?php
/*
* SNS Testmonial
*/
wp_enqueue_script('owlcarousel');

$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$class = 'sns-testimonial';
$class .= ( trim(esc_attr($extra_class))!='' )?' '.esc_attr($extra_class):'';
$class .= esc_attr($this->getCSSAnimation( $css_animation ));

$class_content = '';
if($use_paging == 'no') {
	$class_content .= ' no_show_paging ';
}

$uq = rand().time();
$args = array(
	'post_type' => 'testimonial',
	'posts_per_page' => -1
);
$brand = new WP_Query($args);
$class .= ' '.$template;

if ( $brand->have_posts() ) :
	ob_start();
?>
	<div id="sns_testimonial<?php echo $uq; ?>" class="<?php echo $class ; ?> <?php echo $class_content; ?>">
		 <div class="navslider">
			<span class="prev"></span>
			<span class="next"></span>
		</div>
		<div class="testimonial-content">
			<?php if ( $prefix !='' ): ?>
				<p class="testimonial-prefix">				
					<?php echo esc_html($prefix); ?>	
				</p>
			<?php endif; ?>
			<?php if ( $title !='' ): ?>
				<div class="testimonial-title">				
					<?php echo esc_html($title); ?>	
				</div>
			<?php endif; ?>
			<ul class="clearfix">
				<?php 
				$i=1;
				while ( $brand->have_posts() && ($i <= $num_display) ) : $brand->the_post();  ?>
				  <?php //if( ($i-1)%3 == 0 || $i-1 == 0):?>
				<li>				
					<?php //endif; ?>
					<div class="item">
						<div class="item-content">
						<?php
						if(has_post_thumbnail()):?>
						<div class="sns-testi-avatar">
							<?php the_post_thumbnail('snshadona_testimonial_avatar');?>
						</div>
						<?php
						endif;
						$title = get_the_title();
						$sub_title = get_post_meta(get_the_ID(), 'snshadona_testisub', true);
						
						if( $sub_title != '')
							$title = $title . '<span>'.esc_html($sub_title).'</span>';
						?>
						<div class="quote-content">
							<?php echo '&#34; '.esc_html(get_the_content()) . ' &#34;'; ?>
						</div>
						<div class="sns-test-title"><?php echo $title; ?></div>
					</div>
					</div>
				<?php //if( $i%3 == 0 || $i == $num_display ): ?>
				</li>
				<?php //endif; ?>
				<?php $i++; ?>
				<?php 
				endwhile;?>
			</ul>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('#sns_testimonial<?php echo $uq;?> ul').owlCarousel({
					items: 1,
					responsive : {
					    0 : { items: 1},
					    480 : { items:1 },
					    768 : { items:1},
					    992 : { items: 2},
					    1200 : { items: 3 }
					},
					loop: false,
		            dots: true,
		            nav: false,
		   //          animateOut: 'flipInY',
					// animateIn: 'pulse',
				    autoplay: false,
		            onInitialized: callback,
		            slideSpeed : 800
				});

				function callback(event) {
					if(this._items.length > this.options.items){
				        jQuery('#sns_testimonial<?php echo $uq;?> .navslider').show();
				    }else{
				        jQuery('#sns_testimonial<?php echo $uq;?> .navslider').hide();
				    }
				}
				jQuery('#sns_testimonial<?php echo $uq;?> .navslider .prev').on('click', function(e){
					e.preventDefault();
					jQuery('#sns_testimonial<?php echo $uq;?> ul').trigger('prev.owl.carousel');
				});
				jQuery('#sns_testimonial<?php echo $uq;?> .navslider .next').on('click', function(e){
					e.preventDefault();
					jQuery('#sns_testimonial<?php echo $uq;?> ul').trigger('next.owl.carousel');
				});
			});
		</script>
	</div>
<?php
$output .= ob_get_clean();
echo $output;
wp_reset_postdata();
endif; 

?>