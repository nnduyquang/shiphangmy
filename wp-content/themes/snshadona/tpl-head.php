<?php
// Theme option

$showbreadcrumbs = 1;
$bg_url = snshadona_getOption('bg_breadcrump', 'image');

if ( get_post_type( get_the_ID() ) == 'page' ) :
	if ( is_front_page() || ( snshadona_metabox('snshadona_showbreadcrump') == '2' ) ) :
		$showbreadcrumbs = 0;
	endif;
elseif ( get_post_type( get_the_ID() ) == 'post') :
		$showbreadcrumbs = 1;
endif;
//
if( snshadona_themeoption('use_stickmenu') == 1): ?>
    <div id="sticky-navigation-holder" class="header">
    </div>
<?php
endif;
?>
<?php 
	$clsads_class = '';
	if(snshadona_themeoption('header_style') != '' ):
		$clsads_class = snshadona_themeoption('header_style');
	endif;
?>

<!-- Header -->
<div id="sns_header" class="wrap <?php echo esc_attr($clsads_class) ?>">
	<div id="sns_menu">
		<div class="sns_menu_wrapper">
			<div class="container">
				<div class="row">
					<div class="header-left col-lg-2 col-md-3 col-sm-3 col-xs-12">
						<div id="logo">
							<?php 
							$logourl = SNSHADONA_THEME_URI.'/assets/img/logo.png';
							if (snshadona_getOption('header_logo', 'image') !='' ){
								$logourl = snshadona_getOption('header_logo', 'image');
							}
							?>
							<a href="<?php echo esc_url( home_url('/') ) ?>" title="<?php bloginfo( 'sitename' ); ?>">
								<img src="<?php echo esc_attr($logourl); ?>" alt="<?php bloginfo( 'sitename' ); ?>"/>
							</a>
						</div>		
					</div>
					<div class="header-center col-lg-7 col-md-4 col-sm-3 col-xs-12">
						<div class="header-center-inner">
							<!-- Menu  -->
							<?php
							$show_menu = 1;
							if ( function_exists('rwmb_meta') ) {
								if ( rwmb_meta('snshadona_enable_menu') == '' || rwmb_meta('snshadona_enable_menu') == 1 ){
									//
								}elseif( rwmb_meta('snshadona_enable_menu') == 0 ) {
									$show_menu = 0;
								}
							}
							if ( is_page() && function_exists('rwmb_meta') && $show_menu == 0 ) : ?>
						    <!-- Hide Menu  -->
							<?php else: ?>
							<div class="sns-mainnav-wrapper">
									<div id="sns_mainnav">
										<div class="visible-lg" id="sns_mainmenu">
											<?php
							                if(has_nav_menu('main_navigation')):
									           wp_nav_menu( array(
									           				'theme_location' => 'main_navigation',
									           				'container' => false, 
									           				'menu_id' => 'main_navigation',
									           				'walker' => new snshadona_Megamenu_Front,
									           				'menu_class' => 'nav navbar-nav'
									           	) ); 
											else:
												echo '<p class="main_navigation_alert">'.esc_html__('Please sellect menu for Main navigation', 'snshadona').'</p>';
											endif;
											?>
										</div>
										<?php get_template_part('tpl-respmenu'); ?>
									</div>
							</div>
							<?php endif; ?>
							<div class="header-search">
								<?php if( shortcode_exists( 'yith_woocommerce_ajax_search' ) ):
									echo do_shortcode('[yith_woocommerce_ajax_search]');
								else:
									if(class_exists('WooCommerce')):
								?>
									<div class="tongle">
									</div>
									<div id="SearchForm">
										<form method="get" action="<?php echo get_permalink( woocommerce_get_page_id( 'shop' ) ); ?>">
			                                <input type="text" name="s" id="s" class="input-search"
			                                       placeholder="<?php echo esc_html__('Enter your keywords...', 'snshadona'); ?>" />
			                                <input type="hidden" name="post_type" value="product" />
			                                <button type="submit"><?php echo esc_html__('Search', 'snshadona'); ?></button>
			                            </form>
									</div>
									<?php endif; ?>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<div class="header-right col-lg-3 col-md-5 col-sm-6 col-xs-6">
						<div class="header-tools">
							<div class="mysetting">
								<div class="tongle" title="<?php echo esc_html__( 'My setting', 'snshadona' ); ?>">
									<?php echo esc_html__('Setting', 'snshadona'); ?>
								</div>
								<div class="content">

									<div class="left">
										<?php
											if ( is_user_logged_in() ) {
												$current_user = wp_get_current_user();
												printf( '<p>Welcome, <a class="name" href="%s">%s</a>!</p>', get_edit_user_link($current_user->user_id), esc_html( $current_user->user_login ) );
												?>
												<a class="btn button" href="<?php echo wp_logout_url(); ?>"><?php echo esc_html__("Logout", "snshadona"); ?></a>
												<?php
											}else{
												wp_login_form();
												?>
												<p class="forgot_password">
													<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Forgot Password', 'snshadona' ); ?></a>
												</p>
												<?php
											}
										?>

										<?php //if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Login account') ) :
										//endif; ?>
									</div>
									<div class="right">
										<div class="sns-switch">
											<div class="switch-inner">
												<div class="language-switcher">
													<div class="lan-current"><span><?php esc_html_e('Language:', 'snshadona');?></span> 
													</div>
													<ul class="list-lang">
														<li><span class="current"><img src="<?php echo SNSHADONA_THEME_URI.'/assets/img/en.jpg'?>" alt="en"></span></li>
														<li><a title="<?php esc_html_e('Germany', 'snshadona');?>" href="#"><img src="<?php echo SNSHADONA_THEME_URI.'/assets/img/ru.jpg'?>" alt="ru"></a></li>
														<li><a title="<?php esc_html_e('Brazil', 'snshadona');?>" href="#"><img src="<?php echo SNSHADONA_THEME_URI.'/assets/img/bra.jpg'?>" alt="fr"></a></li>
														<li><a title="<?php esc_html_e('France', 'snshadona');?>" href="#"><img src="<?php echo SNSHADONA_THEME_URI.'/assets/img/fr.jpg'?>" alt="fr"></a></li>
													</ul>
												</div>
												<div class="currency-switcher">
													<div class="currency">
														<span><?php esc_html_e('Currency :', 'snshadona');?></span>
													</div>
													<ul class="select-currency">
														<li><span title="<?php esc_html_e('USD', 'snshadona');?>"><?php esc_html_e('$', 'snshadona');?></span></li>
														<li><a title="<?php esc_html_e('EURO', 'snshadona');?>" href="#"><?php esc_html_e('€', 'snshadona');?></a></li>
														<li><a title="<?php esc_html_e('GBP', 'snshadona');?>" href="#"><?php esc_html_e('£', 'snshadona');?></a></li>
													</ul>
												</div>
												
											</div>
										</div>
										<?php
								            if(has_nav_menu('top_navigation')): ?>
								            <div class="sns-quickaccess">
												<div class="quickaccess-inner">
											<?php
									           wp_nav_menu( array(
									           				'theme_location' => 'top_navigation',
									           				'container' => false, 
									           				'menu_id' => 'top_navigation',
									           				'menu_class' => 'links',
									           				'walker' => new snshadona_Megamenu_Front,
									           			));
									        ?>
									        	</div>
									        </div>
									     <?php endif; ?>
									 </div>
								</div>
							</div>
							
							<?php if ( class_exists('WooCommerce') ) : ?>
								<div class="mini-cart sns-ajaxcart">
									<div class="mycart mini-cart">
										<a title="View my shopping cart" class="tongle" href="<?php echo snshadona_cart_url();?>">
											<div class="sns-shopping-cart-icon">
											</div>
											<div class="sns-shopping-cart-info">
												<span class="number"><?php echo sizeof( WC()->cart->get_cart() );?></span>
												<span class="cart-label"><?php echo ( sizeof( WC()->cart->get_cart() ) > 1 ) ? esc_html__('item(s)', 'snshadona') : esc_html__('item', 'snshadona'); ?></span>
												<span class="cart-label separator"><?php echo esc_html__(' - ', 'snshadona'); ?></span>
												<span class="cart_quantity"><?php echo snshadona_cart_total(); ?></span>
											</div>
										</a>
										<?php if ( !is_cart() && !is_checkout() ) : ?>
											<div class="content">
												<div class="block-inner">
													<?php the_widget( 'WC_Widget_Cart', 'title= ', array('before_title' => '', 'after_title' => '') ); ?>
												</div>
											</div>
										<?php endif; ?>
									</div>
								</div>
							<?php endif; ?>
						</div>
						
					</div>
				</div>
			</div>
		</div>	
	</div>
</div>
<?php
 if (is_active_sidebar('Top Policy') && snshadona_themeoption('top_policy') == '1') : ?>	
	<div class="policy">
		<div class="container">
			<div class="row">
			<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Top Policy') ) :
				endif; ?>
			</div>
		</div>
	</div>
<?php endif; ?>
<?php if ( is_page() && snshadona_metabox('snshadona_useslideshow') == 1 ): ?>
	<div id="sns_slideshow" class="wrap">
			<?php
				echo do_shortcode('[rev_slider '.esc_attr(snshadona_metabox('snshadona_revolutionslider')).' ]');
			?>
	</div>
<?php endif; ?>
<?php if (!is_search() && $showbreadcrumbs == 1 && !is_front_page()  && !is_404()) : ?>		
<div id="sns_breadcrumbs" class="wrap">
	<div class="container">
		<div id="sns_pathway" class="clearfix">
			<?php snshadona_breadcrumbs(); ?>
		</div>
	</div>
</div>
<?php endif; ?>


