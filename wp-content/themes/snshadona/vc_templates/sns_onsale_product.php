<?php
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$class_content = '';

$bg_color = '';
if ($background_color !='') {
	$bg_color .= 'background: '.  $background_color;
}

if( class_exists('WooCommerce') ){
	$uq = rand().time();
	ob_start();	
?>
<?php
	$class='';
	if(($product !='') && ($product2 !='')){
		$class='col-md-6';
	 }
	 else {
	 	$class='col-md-12';
	 }

?>
	<style scoped>
		#sns_onsale_product-<?php echo $uq; ?>{ <?php echo esc_attr($bg_color); ?> }
	</style>
		<div id="sns_onsale_product-<?php echo $uq; ?>" class="sns_onsale_product <?php echo $class_content ?>">
			<?php if( $title != '' ) : ?>
				<h3 class="title">
					<span>
						<?php echo esc_html($title) ?>
					</span>
				</h3>
			<?php endif ?>
			<div class="row">
				<?php if($product !=''): ?>
				<div class = "left <?php echo $class ?>">
					<div class="sns_onsale_product-content">	
						<div class="entry-img">
							<a href="<?php echo esc_url(get_permalink($product)); ?>">
							<?php
								 echo get_the_post_thumbnail($product);
							?>
							</a>
						</div>	
						<div class="entry-summary">
							<div class="item-title">
								<h3 itemprop="name" class="product_title entry-title">
									<a href="<?php echo esc_url(get_permalink($product)); ?>"><?php echo get_the_title($product); ?></a>
								</h3>
							</div>
							<div class="item-short-desc">
								<div itemprop="description">
									<?php
									$limit = ($excerpt_lenght) ? absint($excerpt_lenght) : 20;
									$excerpt = explode(' ', get_the_excerpt($product), $limit);
									if (count($excerpt)>=$limit) {
										array_pop($excerpt);
										$excerpt = implode(" ",$excerpt).'...';
									} else {
										$excerpt = implode(" ",$excerpt);
									}
									$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
									echo $excerpt;
									?>
								</div>				
							</div> 
							
							<?php 
									// Get the Sale Price Date To of the product
									$sale_price_dates_to 	= ( $date = get_post_meta( $product, '_sale_price_dates_to', true ) ) ? date_i18n( 'Y/m/d', $date ) : '';
									/** set sale price date to default 10 days for http://demo.snstheme.com/ */
									if($_SERVER['SERVER_NAME'] == 'demo.snstheme.com' || $_SERVER['SERVER_NAME'] == 'dev.snsgroup.me' ){
										if($sale_price_dates_to == 0)
											$sale_price_dates_to = date('Y/m/d', strtotime('+10 days'));
									} 
									
							if(!empty($sale_price_dates_to)):
							wp_enqueue_script('countdown');
							?>
						
							<div class="item-slider-countdown">
								<div class="sns_sale_clock">
									<div><span class="day"></span><?php esc_html_e('D:', 'snshadona');?></div>
									<div><span class="hours"></span><?php esc_html_e('H:', 'snshadona');?></div>
									<div><span class="minutes"></span><?php esc_html_e('M:', 'snshadona');?></div>
									<div><span class="seconds"></span><?php esc_html_e('S', 'snshadona');?></div>
								</div>
								<script type="text/javascript">
									jQuery(document).ready(function($){
										$('#sns_onsale_product-<?php echo $uq; ?> .sns_sale_clock').countdown('<?php echo $sale_price_dates_to; ?>', function(event){
											$(this).find('.day').html(event.strftime('%D'));
											$(this).find('.hours').html(event.strftime('%H'));
											$(this).find('.minutes').html(event.strftime('%M'));
											$(this).find('.seconds').html(event.strftime('%S'));
										});
									});
				
								</script>
							</div>
							<?php endif; ?>	
							<a class="link" href="<?php echo esc_url(get_permalink($product)); ?>"><?php esc_html_e('View detail', 'snshadona'); ?></a>			
						</div>
					</div>
				</div>
				<?php endif; ?>
				<?php if($product2 !=''): ?>
				<div class = "right <?php echo $class ?>">
					<div class="sns_onsale_product-content">
						<div class="entry-img">
							<a href="<?php echo esc_url(get_permalink($product2)); ?>">
								<?php
									 echo get_the_post_thumbnail($product2);
								?>
							</a>
						</div>
						<div class="entry-summary">
							<div class="item-title">
								<h3 itemprop="name" class="product_title entry-title">
									<a href="<?php echo esc_url(get_permalink($product2)); ?>"><?php echo get_the_title($product2); ?></a>
								</h3>
							</div>
							<div class="item-short-desc">
								<div itemprop="description">
									<?php
									$limit = ($excerpt_lenght) ? absint($excerpt_lenght) : 20;
									$excerpt = explode(' ', get_the_excerpt($product2), $limit);
									if (count($excerpt)>=$limit) {
										array_pop($excerpt);
										$excerpt = implode(" ",$excerpt).'...';
									} else {
										$excerpt = implode(" ",$excerpt);
									}
									$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
									echo $excerpt;
									?>
								</div>				
							</div> 
							
							<?php 
									// Get the Sale Price Date To of the product
									$sale_price_dates_to2 	= ( $date = get_post_meta( $product2, '_sale_price_dates_to2', true ) ) ? date_i18n( 'Y/m/d', $date ) : '';
									//var_dump($sale_price_dates_to);die;
									/** set sale price date to default 10 days for http://demo.snstheme.com/ */
									if($_SERVER['SERVER_NAME'] == 'demo.snstheme.com' || $_SERVER['SERVER_NAME'] == 'dev.snsgroup.me' ){
										if($sale_price_dates_to2 == 0)
											$sale_price_dates_to2 = date('Y/m/d', strtotime('+10 days'));
									} 
									
							if(!empty($sale_price_dates_to2)):
							wp_enqueue_script('countdown');
							?>
							<div class="item-slider-countdown">
								<div class="sns_sale_clock2">
									<div><span class="day"></span><?php esc_html_e('D:', 'snshadona');?></div>
									<div><span class="hours"></span><?php esc_html_e('H:', 'snshadona');?></div>
									<div><span class="minutes"></span><?php esc_html_e('M:', 'snshadona');?></div>
									<div><span class="seconds"></span><?php esc_html_e('S', 'snshadona');?></div>
								</div>
								<script type="text/javascript">
									jQuery(document).ready(function($){
										$('#sns_onsale_product-<?php echo $uq; ?> .sns_sale_clock2').countdown('<?php echo $sale_price_dates_to2; ?>', function(event){
											$(this).find('.day').html(event.strftime('%D'));
											$(this).find('.hours').html(event.strftime('%H'));
											$(this).find('.minutes').html(event.strftime('%M'));
											$(this).find('.seconds').html(event.strftime('%S'));
										});
									});
				
								</script>
							</div>
							<?php endif; ?>	
							<a class="link" href="<?php echo esc_url(get_permalink($product2)); ?>"><?php esc_html_e('View detail', 'snshadona'); ?></a>			
						</div>
					</div>
				</div>
				<?php endif; ?>	
			</div>
		</div> 	
		<?php
	$output .= ob_get_clean();
	wp_reset_postdata();
}
echo $output;
