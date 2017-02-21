<?php 
	$footercss = '';
	$footercss .= 'background: url('.$logourl = snshadona_getOption('footertop_bg_img', 'image').') center center;';
?>

<div id="sns_footer" class="sns-footer">
	<?php
	if ( (snshadona_themeoption('use_footer_top') == '1') && ( is_active_sidebar('footer_top_left') || is_active_sidebar('footer_top_right') ) ) : ?>
	<style scoped>
		#sns_footer_top{ <?php echo esc_attr($footercss); ?> }
	</style>
	<div id="sns_footer_top" class="wrap">
		<div class="container">
			<div class="contain">
				<div class="row">
					 <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('footer_top_left') ) :endif; ?>
					 <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('footer_top_right') ) :endif; ?>			
				</div>
			</div>
		</div>
	</div>
	<?php endif ?>
	<?php
	if ( is_active_sidebar('Footer Column #1') ||  is_active_sidebar('Footer Column #2') || is_active_sidebar('Footer Column #3') || is_active_sidebar('Footer Column #4') || is_active_sidebar('Footer Column #5') ): ?>
	<div id="sns_footer_midle" class="wrap">
		<div class="container">
			<div class="contain">
				<div class="row">
					 <div class="col-phone-12 col-xs-12 col-sm-8 col-lg-4 footer-column column1">
					 	 <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Column #1') ) :endif; ?>
					 </div>
					<?php 		
					$i = 1;
					for ($i=2; $i <= 5 ; $i++) { ?>
						<div class="col-phone-12 col-xs-6 col-sm-4 col-lg-2 footer-column <?php echo esc_attr('column'.($i)) ?>">	
							<?php if ( ($i) == 2) :?> <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Column #2') ) :endif; ?> <?php endif; ?>
							<?php if ( ($i) == 3) :?> <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Column #3') ) :endif; ?> <?php endif; ?>
							<?php if ( ($i) == 4) :?> <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Column #4') ) :endif; ?> <?php endif; ?>
							<?php if ( ($i) == 5) :?> <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Column #5') ) :endif; ?> <?php endif; ?>
						</div>
						<?php
			        		if($i==3) {
			        			echo '<div class="clearfix visible-xs"></div>';
			        		}
			        	?>
					<?php } ?>	
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
	<div id="sns_footer_bottom" class="wrap">
		<div class="container">
			<div class="contain">
				<div class="row">
					<?php
					$payment_img = snshadona_themeoption('payment_img','','url');
					$col_class = '';
					?>
					<?php if ( isset( $payment_img ) && $payment_img != '' ) :
					$col_class = 'col-md-6 col-md-pull-6'; ?>
					<div class="payment-logo col-md-6  col-md-push-6">
						<div class="inner">
							<img src="<?php echo esc_attr( $payment_img ); ?>" alt="<?php echo esc_html__('Payment method', 'snshadona'); ?>"/>
						</div>
					</div>
					<?php endif; ?>
					
					<div class="sns-copyright <?php echo esc_attr( $col_class ); ?>">
						<?php $copyright = snshadona_themeoption('copyright'); ?>
						<?php echo ( isset( $copyright ) && $copyright !='' ) ? wp_kses($copyright, array(
							'a' => array(
								'href' => array(),
								'class' => array(),
								'data-original-title' => array(),
								'data-toggle' => array(),
								'title' => array()
							),
							)) : esc_html__('© 2016 SnsTheme. All Rights Reserved. Developed By SnsTheme', 'snshadona'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	<?php 
	$advance_scrolltotop = snshadona_themeoption('advance_scrolltotop', 1);
	$advance_cpanel = snshadona_themeoption('advance_cpanel', 0);
	?>
	<?php if ( $advance_scrolltotop == 1 || $advance_cpanel == 1 ) : ?>
	<div id="sns_tools">
		<?php 
		if ( $advance_scrolltotop == 1 ) : 
			get_template_part( 'tpl-scrolltotop');
		endif;
		if ( $advance_cpanel == 1 ) : 
			get_template_part( 'tpl-cpanel');
		endif;
		?>
	</div>
	<?php endif; ?>
</div>
