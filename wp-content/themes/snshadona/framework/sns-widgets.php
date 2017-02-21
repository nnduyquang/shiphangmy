<?php
/**
 * SNSHADONA_Social_Accounts widget class
 */
class SNSHADONA_Social_Accounts extends WP_Widget {

	function __construct(){
		parent::__construct(
			'SNSHADONA_Social_Accounts',
			esc_html__( 'SNS - Social Accounts', 'snshadona' ),
			array( "description" => esc_html__("Display a list of social accounts", 'snshadona') )
		);
	}

	function widget( $args, $instance ) {
		$output = '';

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( '','snshadona' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$output .= $args['before_widget'];
		if ( $title ) {
			$output .= $args['before_title'] . esc_html($title) . $args['after_title'];
		}
		

		$author_socials = array(
			'facebook' => ( ! empty( $instance['facebook'] ) ) ? strip_tags($instance['facebook']) : '',
			'camera-retro' => ( ! empty( $instance['camera-retro'] ) ) ? strip_tags($instance['camera-retro']) : '',
			'twitter' => ( ! empty( $instance['twitter'] ) ) ? strip_tags($instance['twitter']) : '',
			'google-plus' => ( ! empty( $instance['google-plus'] ) ) ? strip_tags($instance['google-plus']) : '',
			'pinterest' => ( ! empty( $instance['pinterest'] ) ) ? strip_tags($instance['pinterest']) : '',
			'youtube' => ( ! empty( $instance['youtube'] ) ) ? strip_tags($instance['youtube']) : '',
			'tumblr' => ( ! empty( $instance['tumblr'] ) ) ? strip_tags($instance['tumblr']) : '',
		);

		// Return HTML
		ob_start();
		?>
		<div class="block-sns-socials">
			<div class="sns-socials-content">
				<p><?php echo esc_html__( 'Follow us on:', 'snshadona' ); ?> </p>
				<div class="sns-socials-account">
					<?php 
                    	foreach ($author_socials as $key => $value){
                    		if( $value )
                    		echo '<a class="icon '.$key.'" href="'.esc_url($value).'" target="blank">'.$key.'</a>';
                    	}
                    ?>
				</div>
				
			</div>
        </div><!-- /.block-sns-socials -->
		<?php 
		$output .= ob_get_contents();
		ob_end_clean();
		
		$output .= $args['after_widget'];

		echo $output;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] 			= strip_tags($new_instance['title']);
		
		$instance['facebook'] 		=  $new_instance['facebook'];
		$instance['camera-retro'] 		=  $new_instance['camera-retro'];
		$instance['twitter'] 		=  $new_instance['twitter'];
		$instance['google-plus'] 	=  $new_instance['google-plus'];
		$instance['pinterest'] 		=  $new_instance['pinterest'];
		$instance['youtube'] 		=  $new_instance['youtube'];
		$instance['tumblr'] 		=  $new_instance['tumblr'];

		return $instance;
	}

	function form( $instance ) {
		$title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : 'Follow us on';
		
		// 
		$author_socials = array(
			'facebook' => isset( $instance['facebook'] ) ? strip_tags($instance['facebook']) : '',
			'camera-retro' => isset( $instance['camera-retro'] ) ? strip_tags($instance['camera-retro']) : '',
			'twitter' => isset( $instance['twitter'] ) ? strip_tags($instance['twitter']) : '',
			'google-plus' => isset( $instance['google-plus'] ) ? strip_tags($instance['google-plus']) : '',
			'pinterest' => isset( $instance['pinterest'] ) ? strip_tags($instance['pinterest']) : '',
			'youtube' => isset( $instance['youtube'] ) ? strip_tags($instance['youtube']) : '',
			'tumblr' => isset( $instance['tumblr'] ) ? strip_tags($instance['tumblr']) : '',
		);
		
?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'snshadona' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_html($title); ?>" /></p>
		
		<?php // Social accounts text fields
		foreach ( $author_socials as $key => $value ): ?>
		
			<p><label for="<?php echo esc_attr($this->get_field_id( $key )); ?>" style="text-transform:capitalize;" ><?php echo esc_attr( $key ). ' URL:'; ?></label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id( $key )); ?>" name="<?php echo esc_attr($this->get_field_name( $key )); ?>" type="text" value="<?php echo esc_html($value); ?>" /></p>
		
		<?php
		endforeach;
		?>
<?php
	}
}

/**
 * SNSHADONA_Widget_About_Me widget class
 */
class SNSHADONA_Widget_About_Me extends WP_Widget {

	function __construct(){
		parent::__construct(
			'SNSHADONA_Widget_About_Me',
			esc_html__( 'SNS - About Me', 'snshadona' ),
			array( "description" => esc_html__("Display author info", 'snshadona') )
		);
	}

	function widget( $args, $instance ) {
		$output = '';

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'About Hadona','snshadona' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$output .= $args['before_widget'];
		if ( $title ) {
			$output .= $args['before_title'] . esc_html($title) . $args['after_title'];
		}
		$about_author 	= ( ! empty( $instance['about_author'] ) ) ? ( $instance['about_author'] ) : '';

		$author_socials = array(
			'facebook' => ( ! empty( $instance['facebook'] ) ) ? strip_tags($instance['facebook']) : '',
			'twitter' => ( ! empty( $instance['twitter'] ) ) ? strip_tags($instance['twitter']) : '',
			'google-plus' => ( ! empty( $instance['google-plus'] ) ) ? strip_tags($instance['google-plus']) : '',
			'pinterest' => ( ! empty( $instance['pinterest'] ) ) ? strip_tags($instance['pinterest']) : '',
			'youtube' => ( ! empty( $instance['youtube'] ) ) ? strip_tags($instance['youtube']) : '',
			'linkedin' => ( ! empty( $instance['linkedin'] ) ) ? strip_tags($instance['linkedin']) : '',
			'tumblr' => ( ! empty( $instance['tumblr'] ) ) ? strip_tags($instance['tumblr']) : '',
			'flickr' => ( ! empty( $instance['flickr'] ) ) ? strip_tags($instance['flickr']) : ''
		);

		// Return HTML
		ob_start();
		?>
		<div class="block-sns-abount-me">
			
			<div class="sns-abount-content">
				<?php if( trim($about_author) != '' ) echo '<p>' . esc_html($about_author). '</p>';?>
				
				<div class="sns-abount-account">
					<?php 
                    	foreach ($author_socials as $key => $value){
                    		if( $value )
                    		echo '<a href="'.esc_url($value).'" target="_blank"><i class="fa fa-'.$key.'"></i> </a>';
                    	}
                    ?>
				</div>
				
			</div>
        </div><!-- /.block-sns-abount-me -->
		<?php 
		$output .= ob_get_contents();
		ob_end_clean();
		
		$output .= $args['after_widget'];

		echo $output;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] 			= strip_tags($new_instance['title']);
		$instance['about_author'] 	=  $new_instance['about_author'];
		
		$instance['facebook'] 		=  $new_instance['facebook'];
		$instance['twitter'] 		=  $new_instance['twitter'];
		$instance['google-plus'] 	=  $new_instance['google-plus'];
		$instance['pinterest'] 		=  $new_instance['pinterest'];
		$instance['youtube'] 		=  $new_instance['youtube'];
		$instance['linkedin'] 		=  $new_instance['linkedin'];
		$instance['tumblr'] 		=  $new_instance['tumblr'];
		$instance['flickr'] 		=  $new_instance['flickr'];

		return $instance;
	}

	function form( $instance ) {
		$title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : 'About Hadona';
		$about_author 	= isset( $instance['about_author'] ) ? esc_textarea( $instance['about_author'] ) : ''; //texteditor - About me content
		
		// 
		$author_socials = array(
			'facebook' => isset( $instance['facebook'] ) ? strip_tags($instance['facebook']) : '',
			'twitter' => isset( $instance['twitter'] ) ? strip_tags($instance['twitter']) : '',
			'google-plus' => isset( $instance['google-plus'] ) ? strip_tags($instance['google-plus']) : '',
			'pinterest' => isset( $instance['pinterest'] ) ? strip_tags($instance['pinterest']) : '',
			'youtube' => isset( $instance['youtube'] ) ? strip_tags($instance['youtube']) : '',
			'linkedin' => isset( $instance['linkedin'] ) ? strip_tags($instance['linkedin']) : '',
			'tumblr' => isset( $instance['tumblr'] ) ? strip_tags($instance['tumblr']) : '',
			'flickr' => isset( $instance['flickr'] ) ? strip_tags($instance['flickr']) : ''
		);
		
?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'snshadona' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_html($title); ?>" /></p>

		<p><label for="<?php echo  esc_attr($this->get_field_id( 'about_author' )); ?>"><?php esc_html_e( 'About me:', 'snshadona' ); ?></label>
			<br/><i><?php echo esc_html__( 'About me content', 'snshadona' ); ?></i><br/>
			<textarea class="widefat" rows="16" cols="20" id="<?php echo esc_attr($this->get_field_id('about_author')); ?>" name="<?php echo esc_attr($this->get_field_name('about_author')); ?>"><?php echo esc_html($about_author); ?></textarea>
		</p>
		
		<?php // Social accounts text fields
		foreach ( $author_socials as $key => $value ): ?>
		
			<p><label for="<?php echo esc_attr($this->get_field_id( $key )); ?>"><?php echo esc_attr( $key ). ' URL:'; ?></label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id( $key )); ?>" name="<?php echo esc_attr($this->get_field_name( $key )); ?>" type="text" value="<?php echo esc_html($value); ?>" /></p>
		
		<?php
		endforeach;
		?>
<?php
	}
}
/*
 * Register Wiget
*/
function SNSHADONA_Widget_About_Me_Register(){
	register_widget('SNSHADONA_Widget_About_Me');
}
//add_action('widgets_init', 'SNSHADONA_Widget_About_Me_Register');

/**
 * SNSHADONA_Widget_Vertical_Menu widget class
 */
class SNSHADONA_Widget_Vertical_Menu extends WP_Widget {

	function __construct(){
		parent::__construct(
			'SNSHADONA_Widget_Vertical_Menu',
			esc_html__( 'SNS - Vertical Menu', 'snshadona' ),
			array( "description" => esc_html__("Add a vertical menu to your sidebar.", 'snshadona') )
		);
	}

	function widget( $args, $instance ) {
		// Get menu
		$ver_menu = ! empty( $instance['ver_menu'] ) ? wp_get_nav_menu_object( $instance['ver_menu'] ) : false;

		$bg_color = ! empty( $instance['bg_color'] ) ? $instance['bg_color'] : '';
		$bg_image = ! empty( $instance['bg_image'] ) ? $instance['bg_image'] : '';
		
		if ( !$ver_menu )
			return;

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo $args['before_widget'];

		if ( !empty($instance['title']) )
			echo $args['before_title'] . $instance['title'] . $args['after_title'];
		?>
		<div class="sns_vertical_menu hidden-md hidden-sm hidden-xs <?php if( !empty($bg_color) && $bg_color != '#ffffff') echo 'bg_color';?>">
			<div class="sns-vertical-menu-wrap">
				<?php 
				$nav_menu_args = array(
					'fallback_cb' => '',
					'menu'        => $ver_menu
				);

				/**
				 * Filter the arguments for the Vertical Menu widget.
				 * @param stdClass $ver_menu      Nav menu object for the current menu.
				 * @param array    $args          Display arguments for the current widget.
				 * @param array    $instance      Array of settings for the current widget.
				 */
				//wp_nav_menu( apply_filters( 'widget_ver_menu_args', $nav_menu_args, $ver_menu, $args, $instance ) );
				 wp_nav_menu( array(
       				'theme_location' => 'vertical_navigation',
       				'container' => false, 
       				'menu_id' => 'vertical_navigation',
       				'menu' => $ver_menu,
       				'walker' => new snshadona_Megamenu_Front,
       				'menu_class' => 'vertical-navigation menu'
           		) ); 
				?>
			</div>
		</div>
		<div id="sns_vertical_respmenu" class="menu-offcanvas hidden-lg <?php if( !empty($bg_color) && $bg_color != '#ffffff') echo 'bg_color';?>">
			<div id="vertical_menu_offcanvas" class="offcanvas">
				<?php
				$vertical_menu = '';
				if(is_page() && ($menu_selected = get_post_meta(get_the_ID(), 'snshadona_vertical_menu', true))){
					$vertical_menu = $menu_selected;
				}
		        if(has_nav_menu('vertical_navigation')):
		           wp_nav_menu( array(
		           				'theme_location' => 'vertical_navigation',
		           				'container' => false, 
		           				'menu_id' => 'vertical_navigation_respmenu',
		           				'menu' => $vertical_menu,
		           				'menu_class' => 'resp-nav vertical-navigation-respmenu'
		           	) ); 
				else:
					echo '<p class="vertical_navigation_alert">'.esc_html__('Please sellect menu for Vertical navigation', 'snshadona').'</p>';
				endif;
				?>
			</div>
		</div>
		<script type="text/javascript">
			    jQuery(document).ready(function($) { 
			    	// sns_vertical_respmenu
					$('#vertical_menu_offcanvas').SnsAccordion({
						// btn_open: '<i class="fa fa-plus"></i>',
						// btn_close: '<i class="fa fa-minus"></i>'
						btn_open: '<span class="ac-tongle open"></span>',
						btn_close: '<span class="ac-tongle close"></span>',
					});					
			    });	
		</script>

		<?php if( !empty($bg_color) || !empty($bg_image) ) :?>
			<style scoped>
				#<?php echo $args['widget_id']; ?>:before{background-color: <?php echo esc_attr($bg_color); ?>}
				#<?php echo $args['widget_id']; ?>{background-image: url("<?php echo esc_url($bg_image); ?>");}

				<?php if( !empty($bg_color) && $bg_color != '#ffffff'):?>
					#<?php echo $args['widget_id']; ?> .widget-title{ color: #ffffff;}
				<?php endif; ?>
			</style>
		<?php endif; ?>
		<?php
		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance = array();
		if ( ! empty( $new_instance['title'] ) ) {
			$instance['title'] = sanitize_text_field( $new_instance['title'] );
		}
		if ( ! empty( $new_instance['ver_menu'] ) ) {
			$instance['ver_menu'] = (int) $new_instance['ver_menu'];
		}
		if ( ! empty( $new_instance['bg_color'] ) ) {
			$instance['bg_color'] = sanitize_text_field($new_instance['bg_color']);
		}
		if ( ! empty( $new_instance['bg_image'] ) ) {
			$instance['bg_image'] = $new_instance['bg_image'];
		}
		return $instance;
	}

	function form( $instance ) {
		wp_enqueue_style('thickbox');
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');

		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$ver_menu = isset( $instance['ver_menu'] ) ? $instance['ver_menu'] : '';
		$bg_color = isset( $instance['bg_color'] ) ? $instance['bg_color'] : '';
		$bg_image = isset( $instance['bg_image'] ) ? $instance['bg_image'] : '';
		// Get menus
		$menus = wp_get_nav_menus();
		?>
		<div class="sns-vertical-menu-widget-form-controls" style="width: 100%; vertical-align: top; display: inline-block; margin-bottom: 15px;" <?php if ( empty( $menus ) ) { echo ' style="display:none" '; } ?>>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'snshadona' ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>"/>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'ver_menu' ); ?>"><?php esc_html_e( 'Select Menu:', 'snshadona'); ?></label><br />
				<select id="<?php echo $this->get_field_id( 'ver_menu' ); ?>" name="<?php echo $this->get_field_name( 'ver_menu' ); ?>">
					<option value="0"><?php esc_html_e( '&mdash; Select &mdash;', 'snshadona' ); ?></option>
					<?php foreach ( $menus as $menu ) : ?>
						<option value="<?php echo esc_attr( $menu->term_id ); ?>" <?php selected( $ver_menu, $menu->term_id ); ?>>
							<?php echo esc_html( $menu->name ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</p>
			<p>
			    <label for="<?php echo $this->get_field_id( 'bg_color' ); ?>" style="display:block;"><?php esc_html_e( 'Background overlay:', 'snshadona' ); ?></label> 
			    <input class="widefat <?php echo $this->get_field_id( 'bg_color' ); ?> color-picker" id="<?php echo $this->get_field_id( 'bg_color' ); ?>" name="<?php echo $this->get_field_name( 'bg_color' ); ?>" type="text" value="<?php echo esc_attr( $bg_color ); ?>" />
			</p>

			<p>
		      <label for="<?php echo $this->get_field_id('bg_image'); ?>">Background Image</label><br />
		      <img class="custom_media_image" src="<?php if(!empty($instance['bg_image'])){echo $instance['bg_image'];} ?>" style="margin:0 0 15px;padding:0;max-width:80%;display:block" />
		      <input type="hidden" class="img" name="<?php echo $this->get_field_name('bg_image'); ?>" id="<?php echo $this->get_field_id('bg_image'); ?>" value="<?php echo $instance['bg_image']; ?>" />
		      <input type="button" class="select-img" value="Select Image" />
		    </p>

			<script type="text/javascript">
				var image_field;
			    jQuery(document).ready(function($) { 
		            	jQuery('.sns-vertical-menu-widget-form-controls .<?php echo $this->get_field_id( 'bg_color' ); ?>.color-picker').each(function(){
		                	var parent = jQuery(this).parent();
		                	jQuery(this).wpColorPicker()
		                	parent.find('.sns-vertical-menu-widget-form-controls .wp-color-result').click();
		            	});

		            	jQuery('.sns-vertical-menu-widget-form-controls').each(function(){
		            		var $_this = $(this);
		            		jQuery($_this).find('input.select-img').on('click', function(event){
		            			event.preventDefault();
		            			// If the media frame already exists, reopen it.
								if ( image_field ) {
									image_field.open();
									return;
								}
		            			
		            			// Create the media frame.
								image_field = wp.media.frames.downloadable_file = wp.media({
									title: 'Choose an image',
									button: {
										text: 'Use image'
									},
									multiple: false
								});

								// When an image is selected, run a callback.
								image_field.on( 'select', function() {
									var attachment = image_field.state().get( 'selection' ).first().toJSON();
									jQuery( $_this ).find( '.custom_media_image' ).attr( 'src', attachment.url );
									jQuery( $_this ).find( 'input.img' ).attr( 'value', attachment.url );
								});
			
								// Finally, open the modal.
								image_field.open();
		            		});
		            	});
			    }); 
			</script>
		</div>
		<?php
	}
}
/*
 * Register Wiget
*/
function SNSHADONA_Widget_Vertical_Menu_Register(){
	register_widget('SNSHADONA_Widget_Vertical_Menu');
}
add_action('widgets_init', 'SNSHADONA_Widget_Vertical_Menu_Register');

/**
 * SNSHADONA_Widget_Testimonial widget class
 */
class SNSHADONA_Widget_Testimonial extends WP_Widget {

	function __construct(){
		parent::__construct(
			'SNSHADONA_Widget_Testimonial',
			esc_html__( 'SNS - Testimonial', 'snshadona' ),
			array( "description" => esc_html__("Display Testimonial", 'snshadona') )
		);
	}

	function widget( $args, $instance ) {
		wp_enqueue_script('owlcarousel');
		$output = '';

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Testimonial','snshadona' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$autoplay 	= ( ! empty( $instance['autoplay'] ) ) ? $instance['autoplay'] : 'false';

		$output .= $args['before_widget'];
		if ( $title ) {
			$output .= $args['before_title'] . esc_html($title) . $args['after_title'];
		}
		
		$uq = rand().time();
		$args_testi = array(
			'post_type' => 'testimonial',
			'posts_per_page' => -1
		);
		$brand = new WP_Query($args_testi);
		
		if ( $brand->have_posts() ) :
			ob_start();
			?>
				<div id="sns_testimonial_widget<?php echo esc_attr($uq); ?>" class="sns-testimonial-widget">
					<div class="testimonial-widget-content">
						<ul class="clearfix">
							<?php 
							while ( $brand->have_posts() ) : $brand->the_post(); ?>
							<li>
								<div class="quote-content"><i class="fa fa-quote-left"></i><?php the_content(); ?><i class="fa fa-quote-right"></i></div>
								<?php
								$title = get_the_title();
								$sub_title = get_post_meta(get_the_ID(), 'snshadona_testisub', true);
								if( $sub_title != '')
									$title = $title . '<span>'.$sub_title.'</span>';
								?>
								<div class="sns-test-title"><?php echo esc_html($title); ?></div>
							</li>
							<?php 
							endwhile;?>
						</ul>
					</div>
					<div class="navslider">
						<span class="prev"><i class="fa fa-angle-left"></i></span>
						<span class="next"><i class="fa fa-angle-right"></i></span>
					</div>
					<script type="text/javascript">
						jQuery(document).ready(function(){
							jQuery('#sns_testimonial_widget<?php echo $uq;?> ul').owlCarousel({
								items: 1,
								loop: true,
					            dots: false,
					            nava: false,
							    autoplay: <?php echo esc_js($autoplay); ?>,
					            onInitialized: callback,
					            slideSpeed : 800
							});
			
							function callback(event) {
								if(this._items.length > this.options.items){
							        jQuery('#sns_testimonial_widget<?php echo $uq;?> .navslider').show();
							    }else{
							        jQuery('#sns_testimonial_widget<?php echo $uq;?> .navslider').hide();
							    }
							}
							jQuery('#sns_testimonial_widget<?php echo $uq;?> .navslider .prev').on('click', function(e){
								e.preventDefault();
								jQuery('#sns_testimonial_widget<?php echo $uq;?> ul').trigger('prev.owl.carousel');
							});
							jQuery('#sns_testimonial_widget<?php echo $uq;?> .navslider .next').on('click', function(e){
								e.preventDefault();
								jQuery('#sns_testimonial_widget<?php echo $uq;?> ul').trigger('next.owl.carousel');
							});
						});
					</script>
				</div>
			<?php
			$output .= ob_get_clean();
			wp_reset_postdata();
		endif;
		
		$output .= $args['after_widget'];

		echo $output;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] 	= strip_tags($new_instance['title']);
		$instance['autoplay']  = $new_instance['autoplay'];
		
		return $instance;
	}

	function form( $instance ) {
		$title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : 'Testimonial';
		$autoplay  = isset( $instance['autoplay'] ) ? esc_attr( $instance['autoplay'] ) : 'true';
?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'snshadona' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_html($title); ?>" /></p>
		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'autoplay' )); ?>"><?php esc_html_e( 'Autoplay:', 'snshadona' ); ?></label>
			<select  class="widefat" name="<?php echo esc_attr($this->get_field_name( 'autoplay' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'autoplay' )); ?>">
				<option value="true" <?php selected($autoplay, 'true', true)?>><?php esc_html_e('Yes', 'snshadona')?></option>
				<option value="false" <?php selected($autoplay, 'false', true)?>><?php esc_html_e('No', 'snshadona')?></option>
			</select>
		</p>
<?php
	}
}
/*
 * Register Wiget
*/
function SNSHADONA_Widget_Testimonial_Register(){
	register_widget('SNSHADONA_Widget_Testimonial');
}
add_action('widgets_init', 'SNSHADONA_Widget_Testimonial_Register');


/**
 * SNSHADONA_Widget_Products widget class
 */
class SNSHADONA_Widget_Products extends WP_Widget {

	function __construct(){
		parent::__construct(
			'SNSHADONA_Widget_Products',
			esc_html__( 'SNS - Products', 'snshadona' ),
			array( "description" => esc_html__("Display products", 'snshadona') )
		);
	}

	function widget( $args, $instance ) {
		$output = '';
		$uq = rand().time();

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Latest posts','snshadona' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		
		$type 	= ( ! empty( $instance['type'] ) ) ? $instance['type'] : 'recent';
		$number_display 	= ( ! empty( $instance['number_display'] ) ) ? (int)$instance['number_display'] : 4;
		$number_limit 	= ( ! empty( $instance['number_limit'] ) ) ? (int)$instance['number_limit'] : 10;
		$autoplay 	= ( ! empty( $instance['autoplay'] ) ) ? $instance['autoplay'] : 'false';

		$output .= $args['before_widget'];
		
		$output .= $args['before_title'] . esc_html($title) . $args['after_title'];

		if( class_exists('WooCommerce') ){
			global $woocommerce;
			$loop = snshadona_woo_query($type, $number_display);
		
			$uq = rand().time();
			if( $loop->have_posts() ) :
				$output .= '<div id="sns_widget_products'.esc_attr( $uq ).'" class="sns-widget-products woocommerce sns-products sns-products-style-two">';
					ob_start();
					?>
					<div class="navslider"><span class="prev"><i class="fa fa-angle-left"></i></span><span class="next"><i class="fa fa-angle-right"></i></span></div>
					<ul class="widget_products product_list grid zoomOut">
						<?php
						$i = 0;
						while ( $loop->have_posts() ) : $loop->the_post();
							if($i == 0):?>
							<li class="item product">
							<?php
							endif;
						    	wc_get_template( 'vc/item.php' );
					    	if($i == $number_display):?>
		    		    	</li>
		    		    	<?php
		    		    	endif;
		    		    	$i++;
		    		    	if( $i == $number_display) $i = 0;
						endwhile; ?>
					</ul>
					<?php
					$output .= ob_get_clean();
				$output .= '</div>';
			endif;
			wp_reset_postdata();
		}
		
		$output .= $args['after_widget'];

		echo $output;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] 			= strip_tags($new_instance['title']);
		$instance['type'] 			=  $new_instance['type'];
		$instance['number_display'] =  (int)$new_instance['number_display'] == 0 ? 4 : (int)$new_instance['number_display'];
		

		return $instance;
	}

	function form( $instance ) {
		$title 	 		= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : 'Latest Products';
		$typer 			= isset( $instance['type'] ) ? esc_attr( $instance['type'] ) : 'recent';
		$number_display = isset( $instance['number_display'] ) ? esc_attr( $instance['number_display'] ) : '4';
		
		
?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'snshadona' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_html($title); ?>" /></p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'type' )); ?>"><?php esc_html_e( 'Type:', 'snshadona' ); ?></label>
			<select  class="widefat" name="<?php echo esc_attr($this->get_field_name( 'type' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'type' )); ?>">
				<option value="recent" <?php selected($typer, 'recent', true)?>><?php esc_html_e('Latest Products', 'snshadona') ?></option>
				<option value="best_selling" <?php selected($typer, 'best_selling', true)?>><?php esc_html_e('BestSeller Products', 'snshadona') ?></option>
				<option value="top_rate" <?php selected($typer, 'top_rate', true)?>><?php esc_html_e('Top Rated Products', 'snshadona') ?></option>
				<option value="on_sale" <?php selected($typer, 'on_sale', true)?>><?php esc_html_e('Special Products', 'snshadona') ?></option>
				<option value="featured_product" <?php selected($typer, 'featured_product', true)?>><?php esc_html_e('Featured Products', 'snshadona') ?></option>
				<option value="recent_review" <?php selected($typer, 'recent_review', true)?>><?php esc_html_e('Recent Review', 'snshadona') ?></option>
			</select>
		</p>
		
		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'number_display' )); ?>"><?php esc_html_e( 'Number of products to show:', 'snshadona' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'number_display' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number_display' )); ?>" type="text" value="<?php echo esc_html($number_display); ?>" /></p>
		
<?php
	}
}
/*
 * Register Wiget
*/
function SNSHADONA_Widget_Products_Register(){
	register_widget('SNSHADONA_Widget_Products');
}
add_action('widgets_init', 'SNSHADONA_Widget_Products_Register');

/**
 * SNSHADONA_Widget_Product_Countdown widget class
 */
class SNSHADONA_Widget_Product_Countdown extends WP_Widget {

	function __construct(){
		parent::__construct(
			'SNSHADONA_Widget_Product_Countdown',
			esc_html__( 'SNS - Product Sale Countdown', 'snshadona' ),
			array( "description" => esc_html__("Display the sale will end at the beginning of the set date.", 'snshadona') )
		);
	}

	function widget( $args, $instance ) {
		$output = '';
		$uq = rand().time();

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Deal of day','snshadona' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$product_id = ( ! empty( $instance['product_id'] ) ) ? (int)$instance['product_id'] : '';
		
		// Get the Sale Price Date To of the product
		$sale_price_dates_to 	= ( $date = get_post_meta( $product_id, '_sale_price_dates_to', true ) ) ? date_i18n( 'Y/m/d', $date ) : '';
		
		/** set sale price date to default 10 days for http://demo.snstheme.com/ */
		if($_SERVER['SERVER_NAME'] == 'demo.snstheme.com' || $_SERVER['SERVER_NAME'] == 'dev.snsgroup.me' ){
			if($sale_price_dates_to == 0)
				$sale_price_dates_to = date('Y/m/d', strtotime('+10 days'));
		}
		
		$output .= $args['before_widget'];

		$output .= $args['before_title'] . esc_html($title) . $args['after_title'];

		if( class_exists('WooCommerce') ){
			if($sale_price_dates_to == ''){ // Return if is blank
				echo '<div class="alert-danger">'.esc_html__('May be the Scheduled Sale End Date of this product is not set.', 'snshadona') . '</div>';
				return '';
			}
			
			$uq = rand().time();
			
			$output .= '<div id="sns_widget_product_sale_countdown'.esc_attr( $uq ).'" class="sns_widget_product_sale_countdown">';
			ob_start();
			?>		<div class="sns_sale_countdown_thumb">
						<?php
						if( has_post_thumbnail($product_id) ):?>
							<a href="<?php echo esc_url(get_permalink($product_id)); ?>" title="<?php echo esc_attr( get_the_title($product_id) );?>">
								<?php
								echo get_the_post_thumbnail($product_id);
								?>
							</a>
							<?php
						endif;
						?>
					</div>
					<div class="sns_sale_countdown">
						<div class="sns_sale_clock"></div>
						<div class="sns_sale_more"><a href="<?php echo esc_url(get_permalink($product_id)); ?>" title="<?php esc_attr_e('Click here', 'snshadona');?>"><?php esc_html_e('Click here', 'snshadona');?></a></div>
					</div>
					<div class="sns_sale_countdown_title">
						<div class="sns_sale_title"><a href="<?php echo esc_url(get_permalink($product_id)); ?>" title="<?php echo esc_attr(get_the_title($product_id)); ?>"><?php echo get_the_title($product_id); ?></a></div>
						<div class="sns_sale_price">
							<?php
							$product = new WC_Product( $product_id );
							echo $product->get_price_html();
							?>
						</div>
					</div>
					<script type="text/javascript">
					jQuery(document).ready(function($){
						$('#sns_widget_product_sale_countdown<?php echo $uq;?> .sns_sale_clock').countdown('<?php echo $sale_price_dates_to; ?>', function(event) {
							$(this).html(event.strftime('%-D day%!D : %H : %M : %S'));
						});
					});
					</script>
			<?php
			$output .= ob_get_clean();
			$output .= '</div>';
			wp_reset_postdata();
		}
		
		$output .= $args['after_widget'];

		echo $output;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] 			= strip_tags($new_instance['title']);
		$instance['product_id'] 	= esc_attr($new_instance['product_id']);
		

		return $instance;
	}

	function form( $instance ) {
		$title 	 		= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : 'Deal of day';
		$product_id		= isset( $instance['product_id'] ) ? esc_attr( $instance['product_id'] ) : '';
		
?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'snshadona' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_html($title); ?>" /></p>
		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'product_id' )); ?>"><?php esc_html_e( 'Product ID:', 'snshadona' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'product_id' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'product_id' )); ?>" type="text" value="<?php echo esc_html($product_id); ?>" />
			<span class="description"><?php esc_html_e('The ID of the product to get the form Sale Price Date To.', 'snshadona'); ?></span>
		</p>

<?php
	}
}
/*
 * Register Wiget
*/
function SNSHADONA_Widget_Product_Countdown_Register(){
	register_widget('SNSHADONA_Widget_Product_Countdown');
}
//add_action('widgets_init', 'SNSHADONA_Widget_Product_Countdown_Register');


/**
 * SNSHADONA_Widget_Latest_Posts widget class
 */
class SNSHADONA_Widget_Latest_Posts extends WP_Widget {

	function __construct(){
		parent::__construct(
			'SNSHADONA_Widget_Latest_Posts',
			esc_html__( 'SNS - Latest Posts Slider', 'snshadona' ),
			array( "description" => esc_html__("Display latest posts", 'snshadona') )
		);
	}

	function widget( $args, $instance ) {
		wp_enqueue_script('owlcarousel');
		$output = '';
		$uq = rand().time();
		
		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Latest posts','snshadona' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		
		$show_author 	= ( ! empty( $instance['show_author'] ) ) ? $instance['show_author'] : 'show';
		$show_date 	= ( ! empty( $instance['show_date'] ) ) ? $instance['show_date'] : 'show';
		$number 	= ( ! empty( $instance['number'] ) ) ? $instance['number'] : 3;
		$autoplay 	= ( ! empty( $instance['autoplay'] ) ) ? $instance['autoplay'] : 'false';

		$output .= $args['before_widget'];
		if ( $title ) {
			$output .= $args['before_title'] . esc_html($title) . $args['after_title'];
		}
		
		$my_query = array(
			'post_type'      => 'post',
			'posts_per_page' => $number ,
			'order'          => 'DESC',
			'orderby'        => 'date',
			'ignore_sticky_posts' => true,
			'post_status'    => 'publish'
		);
		$latest_posts = new WP_Query($my_query);
		
		
		if( $latest_posts->have_posts() ) :
			$output .= '<div id="sns_latestpost_wd'.esc_attr( $uq ).'" class="sns-latest-posts-widget">';
				$output .= '<ul>';
					while ( $latest_posts->have_posts() ) : $latest_posts->the_post();
						$output .= '<li class="item-post">';
							$output .= '<div class="post-thumb">';
								if(has_post_thumbnail()):
									$output .= '<a class="post-author" href="'. esc_url(get_permalink()).'">';
										$output .= get_the_post_thumbnail(get_the_ID(), 'snshadona_latest_posts');
									$output .= '</a>';
								endif;
								if ( $show_date == 'show' )
									$output .= '<div class="date-blog"><span class="day">'. esc_html(get_the_date('j')) .'</span><span class="month">'. esc_html(get_the_date('M')) .'</span>'.
									'</div>';
							$output .= '</div>';
							
							$output .= '<div class="post-info">';
							
							$output .= '<div class="info-inner">';
							
							$output .= '<div class="post-title"><a href="'.esc_url(get_permalink()).'">'.get_the_title().'</a>';
							if ( $show_author == 'show' )
								$output .= '<span class="post-author" >By <a href="'.esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) )) .'">'.get_the_author_meta('nickname').'</a></span>';
							$output .=  '</div>';
							$output .= '<div class="post-excerpt">' . get_the_excerpt() . '</div>';	
							$output .= '<a class="read-more" href="'.esc_url( get_permalink() ).'" title="">'.esc_html__('Read more', 'snshadona').'</a>';
							$output .= '</div>';	
							$output .= '</div>';
						$output .= '</li>';
					endwhile;
				
				$output .= '</ul>';
				$output .= '<div class="navslider"><span class="prev"></span><span class="next"></span></div>';
			$output .= '</div>';
			ob_start();
			?>
			<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('#sns_latestpost_wd<?php echo $uq;?> ul').owlCarousel({
					items: 1,
					loop:true,
			        dots: false,
				   	autoplay: <?php echo esc_js($autoplay); ?>,
			        onInitialized: callback,
			        slideSpeed : 600
				});
				function callback(event) {
						if(this._items.length > this.options.items){
				        jQuery('#sns_latestpost_wd<?php echo $uq;?> .navslider').show();
				    }else{
				        jQuery('#sns_latestpost_wd<?php echo $uq;?> .navslider').hide();
				    }
				}
				jQuery('#sns_latestpost_wd<?php echo $uq;?> .navslider .prev').on('click', function(e){
					e.preventDefault();
					jQuery('#sns_latestpost_wd<?php echo $uq;?> ul').trigger('prev.owl.carousel');
				});
				jQuery('#sns_latestpost_wd<?php echo $uq;?> .navslider .next').on('click', function(e){
					e.preventDefault();
					jQuery('#sns_latestpost_wd<?php echo $uq;?> ul').trigger('next.owl.carousel');
				});
			});
			</script>
			<?php
			$output .= ob_get_clean();
		endif;
		/* Restore original Post Data */
		wp_reset_postdata();
		$output .= $args['after_widget'];

		echo $output;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] 			= strip_tags($new_instance['title']);
		$instance['show_author'] 	=  $new_instance['show_author'];
		$instance['show_date'] 		=  $new_instance['show_date'];
		$instance['number'] 		=  (int)$new_instance['number'] == 0 ? 3 : (int)$new_instance['number'];
		$instance['autoplay'] 		=  $new_instance['autoplay'];

		return $instance;
	}

	function form( $instance ) {
		$title 	 		= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : 'Latest posts';
		$show_author 	= isset( $instance['show_author'] ) ? esc_attr( $instance['show_author'] ) : 'show';
		$show_date 		= isset( $instance['show_date'] ) ? esc_attr( $instance['show_date'] ) : 'show';
		$number 		= isset( $instance['number'] ) ? esc_attr( $instance['number'] ) : '3';
		$autoplay  = isset( $instance['autoplay'] ) ? esc_attr( $instance['autoplay'] ) : 'true';
		
?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'snshadona' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_html($title); ?>" /></p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'show_author' )); ?>"><?php esc_html_e( 'Show Author:', 'snshadona' ); ?></label>
			<select  class="widefat" name="<?php echo esc_attr($this->get_field_name( 'show_author' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'show_author' )); ?>">
				<option value="show" <?php selected($show_author, 'show', true)?>><?php esc_html_e('Show', 'snshadona')?></option>
				<option value="hide" <?php selected($show_author, 'hide', true)?>><?php esc_html_e('Hide', 'snshadona')?></option>
			</select>
		</p>
		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'show_date' )); ?>"><?php esc_html_e( 'Show Date:', 'snshadona' ); ?></label>
			<select  class="widefat" name="<?php echo esc_attr($this->get_field_name( 'show_date' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'show_date' )); ?>">
				<option value="show" <?php selected($show_date, 'show', true)?>><?php esc_html_e('Show', 'snshadona')?></option>
				<option value="hide" <?php selected($show_date, 'hide', true)?>><?php esc_html_e('Hide', 'snshadona')?></option>
			</select>
		</p>
		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e( 'Number Posts:', 'snshadona' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="text" value="<?php echo esc_html($number); ?>" /></p>
		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'autoplay' )); ?>"><?php esc_html_e( 'Autoplay:', 'snshadona' ); ?></label>
			<select  class="widefat" name="<?php echo esc_attr($this->get_field_name( 'autoplay' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'autoplay' )); ?>">
				<option value="true" <?php selected($autoplay, 'true', true)?>><?php esc_html_e('Yes', 'snshadona')?></option>
				<option value="false" <?php selected($autoplay, 'false', true)?>><?php esc_html_e('No', 'snshadona')?></option>
			</select>
		</p>
<?php
	}
}
/*
 * Register Wiget
*/
function SNSHADONA_Widget_Latest_Posts_Register(){
	register_widget('SNSHADONA_Widget_Latest_Posts');
}
add_action('widgets_init', 'SNSHADONA_Widget_Latest_Posts_Register');


class SNSHADONA_Widget_Facebook extends WP_Widget {
	public function __construct() {
		$widget_ops = array('description' => esc_html__( 'Display your facebook like box', 'snshadona' ) );
		parent::__construct('sns_facebook', esc_html__('SNS - Facebook', 'snshadona'), $widget_ops);
	}
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		echo wp_kses( $args['before_widget'], array(
				                                'aside' => array(
				                                    'id' => array(),
				                                    'class' => array()
				                                ),
				                            ) );
		if ( $title ) echo wp_kses( $args['before_title'] . esc_html($title) . $args['after_title'], array(
				                                'h3' => array(
				                                    'class' => array()
				                                ),
				                                'h4' => array(
				                                    'class' => array()
				                                ),
				                                'span' => array(
				                                    'class' => array()
				                                ),
				                            ) );

		$fanpageName = empty( $instance['fanpageName'] ) ? 'snstheme' : esc_html($instance['fanpageName']);
		?>
		<div class="content">
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.4";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
			<div class="fb-page" 
			data-href="https://www.facebook.com/<?php echo esc_html($fanpageName); ?>" 
			data-small-header="true" 
			data-adapt-container-width="true" 
			data-hide-cover="false" 
			data-show-facepile="true" 
			data-show-posts="false">
				<div class="fb-xfbml-parse-ignore">
					<blockquote cite="https://www.facebook.com/<?php echo esc_html($fanpageName); ?>">
						<a href="https://www.facebook.com/<?php echo esc_html($fanpageName); ?>"><?php echo esc_html($fanpageName); ?></a>
					</blockquote>
				</div>
			</div>
		</div>
		<?php
		echo wp_kses( $args['after_widget'], array(
				                                'aside' => array()
				                            ) );
	}
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args((array) $new_instance, array( 
			'title' => 'SNS Facebook',
			'fanpageName' => 'snstheme',
			'numberDisplay' => '12',
		));
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['fanpageName'] = strip_tags($new_instance['fanpageName']);
		$instance['numberDisplay'] = strip_tags($new_instance['numberDisplay']);
		return $instance;
	}
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 
			'title' => 'SNS Facebook',
			'fanpageName' => 'snstheme',
			'numberDisplay' => '12',
		) );
		$title = $instance['title'];
		$fanpageName = $instance['fanpageName'];
		$numberDisplay = $instance['numberDisplay'];
?>
	<p>
		<label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
			<?php esc_html_e('Title:', 'snshadona'); ?>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</label>
	</p>
	<p>
		<label for="<?php echo esc_attr($this->get_field_id('fanpageName')); ?>">
			<?php esc_html_e('Fanpage Name:', 'snshadona'); ?>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('fanpageName')); ?>" name="<?php echo esc_attr($this->get_field_name('fanpageName')); ?>" type="text" value="<?php echo esc_attr($fanpageName); ?>" />
		</label>
	</p>
<?php
	}
}

if( class_exists('WooCommerce') ){
/**
	 * SNS Product Categories Widget
	 *
	 */
	class SnsHadona_Widget_Product_Categories extends WC_Widget {
	
		/**
		 * Category ancestors
		 *
		 * @var array
		 */
		public $cat_ancestors;
	
		/**
		 * Current Category
		 *
		 * @var bool
		 */
		public $current_cat;
	
		/**
		 * Constructor
		 */
		public function __construct() {
			$this->widget_cssclass    = 'woocommerce sns_widget_product_categories';
			$this->widget_description = esc_html__( 'A list of product categories.', 'snshadona' );
			$this->widget_id          = 'sns_product_categories';
			$this->widget_name        = esc_html__( 'SNS - Product Categories', 'snshadona' );
			$this->settings           = array(
				'title'  => array(
					'type'  => 'text',
					'std'   => esc_html__( 'All Categories', 'snshadona' ),
					'label' => esc_html__( 'Title', 'snshadona' )
				),
				'orderby' => array(
					'type'  => 'select',
					'std'   => 'name',
					'label' => esc_html__( 'Order by', 'snshadona' ),
					'options' => array(
						'order' => esc_html__( 'Category Order', 'snshadona' ),
						'name'  => esc_html__( 'Name', 'snshadona' )
					)
				),	
				
				'c' => array(
					'type'  => 'checkbox',
					'std'   => 0,
					'label' => __( 'Show product counts', 'snshadona' )
				),	
			);
	
			parent::__construct();
		}
	
		/**
		 * widget function.
		 *
		 * @see WP_Widget
		 *
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) {
			global $wp_query, $post;
			$c             = isset( $instance['c'] ) ? $instance['c'] : $this->settings['c']['std'];
		//	$c             = 0;
			$h             = 1;
			$s             = 0;
			$o             = isset( $instance['orderby'] ) ? $instance['orderby'] : $this->settings['orderby']['std'];
			$dropdown_args = array( 'hide_empty' => false );
			$list_args     = array( 'show_count' => $c, 'hierarchical' => $h, 'taxonomy' => 'product_cat', 'hide_empty' => false );
			
			//$show_more_button = isset( $instance['show_more_button'] ) ? $instance['show_more_button'] : $this->settings['show_more_button']['std'];
			//$number_display	= isset( $instance['number_display'] ) ? $instance['number_display'] : $this->settings['number_display']['std'];
	
			// Menu Order
			$list_args['menu_order'] = false;
			if ( $o == 'order' ) {
				$list_args['menu_order'] = 'asc';
			} else {
				$list_args['orderby']    = 'title';
			}
	
			// Setup Current Category
			$this->current_cat   = false;
			$this->cat_ancestors = array();
	
			if ( is_tax( 'product_cat' ) ) {
	
				$this->current_cat   = $wp_query->queried_object;
				$this->cat_ancestors = get_ancestors( $this->current_cat->term_id, 'product_cat' );
	
			} elseif ( is_singular( 'product' ) ) {
	
				$product_category = wc_get_product_terms( $post->ID, 'product_cat', array( 'orderby' => 'parent' ) );
	
				if ( $product_category ) {
					$this->current_cat   = end( $product_category );
					$this->cat_ancestors = get_ancestors( $this->current_cat->term_id, 'product_cat' );
				}
	
			}
	
			// Show Siblings and Children Only
			if ( $s && $this->current_cat ) {
	
				// Top level is needed
				$top_level = get_terms(
					'product_cat',
					array(
						'fields'       => 'ids',
						'parent'       => 0,
						'hierarchical' => true,
						'hide_empty'   => false
					)
				);
	
				// Direct children are wanted
				$direct_children = get_terms(
					'product_cat',
					array(
						'fields'       => 'ids',
						'parent'       => $this->current_cat->term_id,
						'hierarchical' => true,
						'hide_empty'   => false
					)
				);
	
				// Gather siblings of ancestors
				$siblings  = array();
				if ( $this->cat_ancestors ) {
					foreach ( $this->cat_ancestors as $ancestor ) {
						$ancestor_siblings = get_terms(
							'product_cat',
							array(
								'fields'       => 'ids',
								'parent'       => $ancestor,
								'hierarchical' => false,
								'hide_empty'   => false
							)
						);
						$siblings = array_merge( $siblings, $ancestor_siblings );
					}
				}
	
				if ( $h ) {
					$include = array_merge( $top_level, $this->cat_ancestors, $siblings, $direct_children, array( $this->current_cat->term_id ) );
				} else {
					$include = array_merge( $direct_children );
				}
	
				$dropdown_args['include'] = implode( ',', $include );
				$list_args['include']     = implode( ',', $include );
	
				if ( empty( $include ) ) {
					return;
				}
	
			} elseif ( $s ) {
				$dropdown_args['depth']        = 1;
				$dropdown_args['child_of']     = 0;
				$dropdown_args['hierarchical'] = 1;
				$list_args['depth']            = 1;
				$list_args['child_of']         = 0;
				$list_args['hierarchical']     = 1;
			}
	
			$this->widget_start( $args, $instance );

			$list_args['walker']                     = new SNSHadona_Product_Cat_List_Walker;
			$list_args['title_li']                   = '';
			$list_args['pad_counts']                 = 1;
			$list_args['show_option_none']           = __('No product categories exist.', 'snshadona' );
			$list_args['current_category']           = ( $this->current_cat ) ? $this->current_cat->term_id : '';
			$list_args['current_category_ancestors'] = $this->cat_ancestors;

			echo '<ul class="product-categories ">';

			wp_list_categories( apply_filters( 'woocommerce_product_categories_widget_args', $list_args ) );

			echo '</ul>';
			
		
			$this->widget_end( $args );
		}
	}
	include_once( WC()->plugin_path() . '/includes/walkers/class-product-cat-list-walker.php' );
	class SNSHadona_Product_Cat_List_Walker extends WC_Product_Cat_List_Walker {
	    public function start_el( &$output, $cat, $depth = 0, $args = array(), $current_object_id = 0 ) {
	        $output .= '<li class="cat-item cat-item-' . $cat->term_id;

	        if ( $args['current_category'] == $cat->term_id ) {
	            $output .= ' current-cat';
	        }

	        if ( $args['has_children'] && $args['hierarchical'] ) {
	            $output .= ' cat-parent';
	        }

	        if ( $args['current_category_ancestors'] && $args['current_category'] && in_array( $cat->term_id, $args['current_category_ancestors'] ) ) {
	            $output .= ' current-cat-parent';
	        }
	        $output .=  '"><a href="' . get_term_link( (int) $cat->term_id, $this->tree_type ) . '">';
	        $icon = get_woocommerce_term_meta($cat->term_id, 'sns_product_cat_icon', true);
	        if( $icon ){
	        	$output .= '<i class="fa '.$icon.'"></i>';
	        }
	        $output .= $cat->name . '</a>';

	        if ( $args['show_count'] ) {
	            $output .= ' <span class="count">(' . $cat->count . ')</span>';
	        }
	    }
	}
}

class SNSHADONA_Widget_Recent_Post extends WP_Widget {
	
	function __construct(){
		$widget_ops = array('description' => esc_html__( 'Display recent posts', 'snshadona' ) );
		parent::__construct('snshadona_recentpost', esc_html__('SNS - Recent Post', 'snshadona'), $widget_ops);
	}
	
	function widget($args, $instance){
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$number = esc_attr($instance['number']);
		
		echo wp_kses( $before_widget, array(
				                                'aside' => array(
				                                	'class' => array()
				                                )
				                            ) );

		if($title) {
			echo wp_kses( $before_title . esc_html($title) . $after_title, array(
				                                'h3' => array(
				                                    'class' => array()
				                                ),
				                                'h4' => array(
				                                    'class' => array()
				                                ),
				                                'span' => array(
				                                    'class' => array()
				                                ),
				                            ) );
		}
		?>
		<?php
		$args = array(
			'post_type'      => 'post',
			'posts_per_page' => $number ,
			'order'          => 'DESC',
		    'orderby'        => 'date',
		    'ignore_sticky_posts' => true,
		    'post_status'    => 'publish'
		);
		$recent_posts = new WP_Query($args);
		if($recent_posts->have_posts()):
		?>
        <ul class="widget-posts">
		<?php while($recent_posts->have_posts()): $recent_posts->the_post(); ?>
	        <li class="post-item">
			<?php if(has_post_thumbnail()): ?>
			<div class="post-img">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
			    <?php the_post_thumbnail('snshadona_latest_posts_widget'); ?>
				</a>
			</div>
			<?php endif; ?>
	        <div class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title() ?></a></div>
	      <span class="post-date"><?php echo get_the_date();?></span>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
        </ul>
		<?php endif; ?>
     
		<?php echo wp_kses( $after_widget, array(
				                                'aside' => array()
				                            ) );
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;

		$instance['title'] = esc_attr($new_instance['title']);
		$instance['number'] = esc_attr($new_instance['number']);
		
		return $instance;
	}

	function form($instance){
		$defaults = array('title' => 'Recent posts', 'number' => 4);
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'snshadona'); ?></label>
			<input class="widefat" type="text"  id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number of items to show:', 'snshadona'); ?></label>
			<input class="widefat" type="text"  id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" value="<?php echo esc_attr($instance['number']); ?>" />
		</p>
	<?php
	}
}

class SNSHADONA_Widget_Icon_Box extends WP_Widget{

	function __construct(){
		parent::__construct(
			'SNSHADONA_Widget_Icon_Box',
			esc_html__('SNS - Icon Box', 'snshadona'),
			array('description' => esc_html__('Display a box with Icon image, Title, Description.','snshadona'))
		);
	}

	function widget($args, $instance){
		$html = '';

		$title = ( !empty( $instance['title'] ) ) ? $instance['title'] : esc_html__('Your Title Here...', 'snshadona');
		$url = ( !empty( $instance['url'] ) ) ? $instance['url'] : '#';
		$icon_img = ! empty( $instance['icon_img'] ) ? $instance['icon_img'] : '';
		$desc = ( !empty( $instance['desc'] ) ) ? $instance['desc'] : '';

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$html .= $args['before_widget'];
		
		ob_start();
		?>
		<div class="sns_icon_box">
			<div class="sns_icon_left">			
				<?php if($icon_img != ''): ?>
					<img src="<?php echo esc_url($icon_img) ?>" alt="" />	
				<?php endif; ?>	
			</div>
			<div class="sns_icon_content_right">
				<div>
					<?php 
					if($title){
						echo $args['before_title'] . '<a href="'.esc_url($url).'" target="_blank">'. esc_html($title) . '</a>' . $args['after_title'];
					}
					echo esc_html($desc);
					?>
				</div>
			</div>
		</div>
		<?php
		$html .= ob_get_contents();
		ob_end_clean();

		$html .= $args['after_widget'];

			
		echo $html;

	}

	function update($new_instance, $old_instance){
		$instance 			= $old_instance;
		$instance['title'] 	= strip_tags($new_instance['title']);
		$instance['icon_img'] 	= esc_attr($new_instance['icon_img']);
		$instance['url'] 	= esc_attr($new_instance['url']);
		$instance['desc'] 	= $new_instance['desc'];

		return $instance;
	}

	function form($instance){
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'url' => '#', 'icon_img' => '', 'desc' => '' ) );
		$title = $instance['title'] ? strip_tags($instance['title']) : 'Your Title Here';
		$url = strip_tags($instance['url']);
		$icon_img = strip_tags($instance['icon_img']);
		$desc = esc_textarea($instance['desc']);
		?>
		<div class="sns-policy"  style="width: 100%; vertical-align: top; display: inline-block; margin-bottom: 15px;" >
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php echo esc_html__( 'Title:', 'snshadona' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_html($title); ?>" /></p>
		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'url' )); ?>"><?php echo esc_html__( 'URL:', 'snshadona' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'url' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'url' )); ?>" type="text" value="<?php echo esc_html($url); ?>" /></p>
		<p class="description"><?php echo esc_html__('External url for Title', 'snshadona');?></p>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'icon_img' )); ?>"><?php echo esc_html__( 'Icon image:', 'snshadona' ); ?></label>
			<img class="custom_media_image" src="<?php if(!empty($instance['icon_img'])){echo $instance['icon_img'];} ?>" style="margin:0 0 15px;padding:0;max-width:80%;display:block" />
	      	<input type="hidden" class="img" name="<?php echo $this->get_field_name('icon_img'); ?>" id="<?php echo $this->get_field_id('icon_img'); ?>" value="<?php echo $instance['icon_img']; ?>" />
	      	<input type="button" class="select-img" value="Select Image" />
		</p>

		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'desc' )); ?>"><?php esc_html__( 'Description:', 'snshadona'); ?></label>
		<textarea class="widefat" rows="16" cols="20" id="<?php echo esc_attr($this->get_field_id('desc')); ?>" name="<?php echo esc_attr($this->get_field_name('desc')); ?>"><?php echo esc_html($desc); ?></textarea></p>
		</div>
		<script type="text/javascript">
			var image_field;
		    jQuery(document).ready(function($) { 
            	jQuery('.sns-policy').each(function(){
            		var $_this = $(this);
            		jQuery($_this).find('input.select-img').on('click', function(event){
            			event.preventDefault();
            			// If the media frame already exists, reopen it.
						if ( image_field ) {
							image_field.open();
							return;
						}
            			
            			// Create the media frame.
						image_field = wp.media.frames.downloadable_file = wp.media({
							title: 'Choose an image',
							button: {
								text: 'Use image'
							},
							multiple: false
						});

						// When an image is selected, run a callback.
						image_field.on( 'select', function() {
							var attachment = image_field.state().get( 'selection' ).first().toJSON();
							jQuery( $_this ).find( '.custom_media_image' ).attr( 'src', attachment.url );
							jQuery( $_this ).find( 'input.img' ).attr( 'value', attachment.url );
						});
	
						// Finally, open the modal.
						image_field.open();
            		});
            	});
		    }); 
		</script>
	<?php
	}
	
}


class SNSHADONA_Widget_Twitter extends WP_Widget {
	public function __construct() {
		$widget_ops = array('description' => esc_html__( 'Display your tweets', 'snshadona' ) );
		parent::__construct('sns_twitter', esc_html__('SNS - Twitter', 'snshadona'), $widget_ops);
	}
	public function widget( $args, $instance ) {
   		wp_enqueue_script('twitter-js', SNSHADONA_THEME_URI . '/assets/js/twitterfetcher.min.js', array('jquery'), '', true );
   		
		$title 			= apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$widgets_id 	= isset($instance['widgets_id']) ? $instance['widgets_id'] : '420187988887212033';
		$limit 			= isset($instance['limit']) ? $instance['limit'] : 3;
		$follow_link 	= isset($instance['follow_link']) ? $instance['follow_link'] : true;
		$account_name 	= isset($instance['account_name']) ? $instance['account_name'] : 'snstheme';
		$avartar 		= isset($instance['avartar']) ? $instance['avartar'] : false;
		$interact_link 	= isset($instance['interact_link']) ? $instance['interact_link'] : true;
		$date 			= isset($instance['date']) ? $instance['date'] : false;
		
		$uq = rand().time();
		$class  = "";
		$class .= ($avartar)?'':' no-avartar';
		$class .= ($follow_link)?'':' no-follow-link';
		$class .= ($interact_link)?'':' no-interact-link';
		$class .= ($date)?'':' no-date';
		
		echo wp_kses( $args['before_widget'], array(
				                                'aside' => array(
				                                	'class' => array(),
				                                	'id' => array()
				                                )
				                            ) );
		if ( $title ) echo wp_kses( $args['before_title'] . esc_html($title) . $args['after_title'], array(
				                                'h3' => array(
				                                    'class' => array()
				                                ),
				                                'h4' => array(
				                                    'class' => array()
				                                ),
				                                'span' => array(
				                                    'class' => array()
				                                ),
				                            ) );
		
		if($follow_link && $account_name != ''){ ?>
		<a class="follow-link" href="http://twitter.com/follow?user=<?php echo esc_attr($account_name); ?>">
			<span><?php echo esc_html__("Follow", 'snshadona'); ?></span>
		</a>
		<?php
		}
		?>
		<div class="content">
			<div id="sns_twitter_<?php echo esc_attr( $uq ); ?>" class="sns-tweets <?php echo esc_attr($class); ?>"></div>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					var config5 = {
					  "id": '<?php echo $widgets_id; ?>',
					  "domId": '',
					  "maxTweets": <?php echo esc_attr($limit); ?>,
					  "enableLinks": true,
					  "showUser": <?php echo esc_attr($avartar); ?>,
					  "showTime": <?php echo esc_attr($date); ?>,
					  "dateFunction": '',
					  "showRetweet": false,
					  "customCallback": handleTweets,
					  "showInteraction": <?php echo esc_attr($interact_link); ?>
					};

					function handleTweets(tweets) {
					    var x = tweets.length;
					    var n = 0;
					    var element = document.getElementById('sns_twitter_<?php echo $uq; ?>');
					    var html = '<ul>';
					    while(n < x) {
					      html += '<li>' + tweets[n] + '</li>';
					      n++;
					    }
					    html += '</ul>';
					    element.innerHTML = html;
					}

					twitterFetcher.fetch(config5);
				});
			</script>
		</div>
		<?php
		
		echo wp_kses( $args['after_widget'], array(
				                                'aside' => array()
				                            ) );
	}
	public function update( $new_instance, $old_instance ) {
		$new_instance = (array) $new_instance;
		$instance = array( 
			'follow_link' => 0,
			'avartar' => 0,
			'interact_link' => 0,
			'date' => 0,
		);
		foreach ( $instance as $field => $val )
			if ( isset($new_instance[$field]) )
				$instance[$field] = 1;

		$instance['title'] = ! empty( $new_instance['title'] ) ? $new_instance['title'] : 'SNS Twitter';
		$instance['widgets_id'] = ! empty( $new_instance['widgets_id'] ) ? $new_instance['widgets_id'] : '420187988887212033';
		$instance['limit'] = ! empty( $new_instance['limit'] ) ? intval( $new_instance['limit'] ) : 3;
		$instance['account_name'] = ! empty( $new_instance['account_name'] ) ? $new_instance['account_name'] : 'snstheme';

		return $instance;
	}
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 
			'title' => 'SNS Twitter',
			'widgets_id' => '420187988887212033',
			'limit' => 2,
			'follow_link' => false,
			'account_name' => 'snstheme',
			'avartar' => true,
			'interact_link' => false,
			'date' => true
		) );
		$title = $instance['title'];
		$widgets_id = $instance['widgets_id'];
		$limit = $instance['limit'];
		$follow_link = $instance['follow_link'];
		$account_name = $instance['account_name'];
		$avartar = $instance['avartar'];
		$interact_link = $instance['interact_link'];
		$date = $instance['date'];
?>
	<p>
		<label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
			<?php esc_html_e('Title:', 'snshadona'); ?>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</label>
	</p>
	<p>
		<label for="<?php echo esc_attr($this->get_field_id('widgets_id')); ?>">
			<?php esc_html_e('Widgets Id:', 'snshadona'); ?>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('widgets_id')); ?>" name="<?php echo esc_attr( $this->get_field_name('widgets_id') ); ?>" type="text" value="<?php echo esc_attr($widgets_id); ?>" />
		</label>
	</p>
	<p>
		<label for="<?php echo esc_attr($this->get_field_id('limit')); ?>">
			<?php esc_html_e('Tweets Count:', 'snshadona'); ?>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('limit')); ?>" name="<?php echo esc_attr($this->get_field_name('limit')); ?>" type="text" value="<?php echo esc_attr($limit); ?>" />
		</label>
	</p>
	<p>
		<input class="checkbox" type="checkbox" <?php checked($instance['follow_link'], true) ?> id="<?php echo esc_attr($this->get_field_id('follow_link')); ?>" name="<?php echo esc_attr( $this->get_field_name('follow_link') ); ?>" />
		<label for="<?php echo esc_attr($this->get_field_id('follow_link')); ?>"><?php esc_html_e('Show follow link', 'snshadona'); ?></label>
	</p>
	<p>
		<label for="<?php echo esc_attr( $this->get_field_id('account_name') ); ?>">
			<?php esc_html_e('Account Name:', 'snshadona'); ?>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('account_name')); ?>" name="<?php echo esc_attr( $this->get_field_name('account_name')); ?>" type="text" value="<?php echo esc_attr($account_name); ?>" />
		</label>
	</p>
	<p>
		<input class="checkbox" type="checkbox" <?php checked($instance['interact_link'], true) ?> id="<?php echo esc_attr( $this->get_field_id('interact_link') ); ?>" name="<?php echo esc_attr( $this->get_field_name('interact_link') ); ?>" />
		<label for="<?php echo esc_attr( $this->get_field_id('interact_link') ); ?>"><?php esc_html_e('Show interact link', 'snshadona'); ?></label>
	</p>
	<p>
		<input class="checkbox" type="checkbox" <?php checked($instance['date'], true) ?> id="<?php echo esc_attr( $this->get_field_id('date') ); ?>" name="<?php echo esc_attr( $this->get_field_name('date') ); ?>" />
		<label for="<?php echo esc_attr( $this->get_field_id('date') ); ?>"><?php esc_html_e('Show date', 'snshadona'); ?></label>
	</p>
	<br />

	<?php
	}
}


if ( class_exists('YITH_Woocompare_Widget') ){
	class SNSHADONA_Woocompare_Widget extends YITH_Woocompare_Widget {
		function widget( $args, $instance ) {
            global $yith_woocompare;

            /**
             * WPML Support
             */
            $lang = defined( 'ICL_LANGUAGE_CODE' ) ? ICL_LANGUAGE_CODE : false;

            extract( $args );

            $localized_widget_title = function_exists( 'icl_translate' ) ? icl_translate( 'Widget', 'widget_yit_compare_title_text', $instance['title'] ) : $instance['title'];

            echo wp_kses( $before_widget . $before_title . $localized_widget_title . $after_title, array(
            									'div' => array(
				                                    'class' => array()
				                                ),
				                                'h3' => array(
				                                    'class' => array()
				                                ),
				                                'h4' => array(
				                                    'class' => array()
				                                ),
				                                'span' => array(
				                                    'class' => array()
				                                ),
				                            ) );
            ?>

            <ul class="products-list" data-lang="<?php echo esc_attr( $lang ); ?>">
                <?php echo $yith_woocompare->obj->list_products_html(); ?>
            </ul>

            <a href="<?php echo esc_url( $yith_woocompare->obj->remove_product_url('all') ) ?>" data-product_id="all" class="clear-all"><?php esc_html_e( 'Clear all', 'snshadona' ) ?></a>
            <a href="<?php echo esc_url( add_query_arg( array( 'iframe' => 'true' ), $yith_woocompare->obj->view_table_url() ) ) ?>" class="compare button"><?php esc_html_e( 'Compare', 'snshadona' ) ?></a>

            <?php echo wp_kses( $after_widget, array(
            									'div' => array()
				                            ) );
        }
	}
}
/**
 * SNSHADONA_Widget_Text class
 */

/**
 * Core class used to implement a SNS Text widget.
 */
class SNSHADONA_Widget_Text extends WP_Widget {
	
	function __construct(){
		parent::__construct(
			'SNSHADONA_Widget_Text',
			esc_html__( 'SNS Text', 'snshadona' ),
			array( "description" => esc_html__("Allow set image replace Title and Arbitrary text or HTML in content.", 'snshadona') )
		);
	}

	
	public function widget( $args, $instance ) {

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		
		$image_url = ! empty( $instance['url'] ) ? $instance['url'] : '';
		
		$widget_text = ! empty( $instance['text'] ) ? $instance['text'] : '';

		/**
		 * Filter the content of the Text widget.
		 *
		 * @since 2.3.0
		 * @since 4.4.0 Added the `$this` parameter.
		 *
		 * @param string         $widget_text The widget content.
		 * @param array          $instance    Array of settings for the current widget.
		 * @param WP_Widget_Text $this        Current Text widget instance.
		 */
		$text = apply_filters( 'widget_text', $widget_text, $instance, $this );

		echo $args['before_widget'];
		if ( ! empty($image_url) ){
			echo $args['before_title'] . '<img src="'. esc_url($image_url) .'" alt="'.esc_attr($title).'"/>' . $args['after_title'];
		}
		elseif ( ! empty( $title ) ) {
			echo $args['before_title'] . esc_html($title) . $args['after_title'];
		} ?>
			<div class="textwidget"><?php echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?></div>
		<?php
		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['url'] = sanitize_text_field( $new_instance['url'] );
		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = wp_kses_post( stripslashes( $new_instance['text'] ) );
		$instance['filter'] = ! empty( $new_instance['filter'] );
		return $instance;
	}

	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'url' => '', 'text' => '' ) );
		$filter = isset( $instance['filter'] ) ? $instance['filter'] : 0;
		$title = sanitize_text_field( $instance['title'] );
		$url = sanitize_text_field( $instance['url'] );
		
		?>
		<p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'snshadona'); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
		
		<p><label for="<?php echo esc_attr($this->get_field_id('url')); ?>"><?php esc_html_e('Image URL:', 'snshadona'); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('url')); ?>" name="<?php echo esc_attr($this->get_field_name('url')); ?>" type="text" value="<?php echo esc_url($url); ?>" /></p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'text' )); ?>"><?php esc_html_e( 'Content:', 'snshadona' ); ?></label>
		<textarea class="widefat" rows="16" cols="20" id="<?php echo esc_attr($this->get_field_id('text')); ?>" name="<?php echo esc_attr($this->get_field_name('text')); ?>"><?php echo esc_textarea( $instance['text'] ); ?></textarea></p>

		<p><input id="<?php echo esc_attr($this->get_field_id('filter')); ?>" name="<?php echo esc_attr($this->get_field_name('filter')); ?>" type="checkbox"<?php checked( $filter ); ?> />&nbsp;<label for="<?php echo esc_attr($this->get_field_id('filter')); ?>"><?php esc_html_e('Automatically add paragraphs', 'snshadona'); ?></label></p>
		<?php
	}
}

function snshadona_load_widgets() {
    register_widget( 'SNSHADONA_Widget_Facebook');
    register_widget( 'SNSHADONA_Widget_Twitter');
    register_widget( 'SNSHADONA_Widget_Recent_Post');
    register_widget( 'SNSHADONA_Widget_Icon_Box');
    register_widget('SNSHADONA_Social_Accounts');
    if( class_exists('SnsHadona_Widget_Product_Categories') ) register_widget( 'SnsHadona_Widget_Product_Categories');
    register_widget( 'SNSHADONA_Widget_Text');
    if ( class_exists('WooCommerce') && class_exists('YITH_Woocompare_Widget') ) register_widget( 'SNSHADONA_Woocompare_Widget');
}
add_action('widgets_init', 'snshadona_load_widgets');

