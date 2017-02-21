<?php
if ( ! class_exists( 'snshadona_Options' ) ) {
class snshadona_Options {
	public $args = array();
	public $sections = array();
	public $theme;
	public $ReduxFramework;

	public function __construct() {
		if ( ! class_exists( 'ReduxFramework' ) ) {
		 return;
		}
		if ( true == Redux_Helpers::isTheme( SNSHADONA_THEME_DIR . '/framework/sns-options.php' ) ) {
			$this->initSettings();
		} else {
			add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
		}
	}

	public function initSettings() {
	    // Set the default arguments
	    $this->setArguments();
	    // Set a few help tabs so you can see how it's done
	    $this->setHelpTabs();
	    // Create the sections and fields
	    $this->setSections();
	    if ( ! isset( $this->args['opt_name'] ) ) {
	        return;
	    }
	    $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
	}

	public function setArguments() {
	    $theme = wp_get_theme();
	    $this->args = array(
            'opt_name'  			=> 'snshadona_themeoptions',
            'display_name' 			=> $theme->get( 'Name' ),
            'menu_type'          	=> 'menu',
	        'allow_sub_menu'     	=> true,
	        'menu_title'         	=> esc_html__( 'SNS Hadona', 'snshadona' ),
	        'page_title'         	=> esc_html__( 'SNS Hadona', 'snshadona' ),
	        'customizer' 			=> true,
	        'page_priority'      	=> 50,
	        'menu_icon' 			=> '',
	        'hints'              	=> array(
	            'icon'          => 'icon-question-sign',
	            'icon_position' => 'right',
	            'icon_color'    => 'lightgray',
	            'icon_size'     => 'normal',
	            'tip_style'     => array(
	                'color'   	=> 'light',
	                'shadow'  	=> true,
	                'rounded' 	=> false,
	                'style'   	=> '',
	            ),
	            'tip_position'  => array(
	                'my' => 'top left',
	                'at' => 'bottom right',
	            ),
	            'tip_effect'    => array(
	                'show' => array(
	                    'effect'   => 'slide',
	                    'duration' => '500',
	                    'event'    => 'mouseover',
	                ),
	                'hide' => array(
	                    'effect'   => 'slide',
	                    'duration' => '500',
	                    'event'    => 'click mouseleave',
	                ),
	            ),
	        ),
	        'dev_mode' 				=> false,
	        //'forced_dev_mode_off'	=> false,
	        'show_options_object'   => false
	    );
	}

	public function setHelpTabs() {
	    $this->args['help_tabs'][] = array(
	        'id'      => 'redux-help-tab-1',
	        'title'   => esc_html__( 'Theme Information 1', 'snshadona' ),
	        'content' => wp_kses(__( '<p>This is the tab content, HTML is allowed.</p>', 'snshadona' ), array(
							'p' => array()
						 ))
	    );
	    $this->args['help_tabs'][] = array(
	        'id'      => 'redux-help-tab-2',
	        'title'   => esc_html__( 'Theme Information 2', 'snshadona' ),
	        'content' => wp_kses(__( '<p>This is the tab content, HTML is allowed.</p>', 'snshadona' ), array(
							'p' => array()
						 ))
	    );
	    $this->args['help_sidebar'] = wp_kses(__( '<p>This is the sidebar content, HTML is allowed.</p>', 'snshadona' ), array(
										'p' => array()
									  ));
	}
	public function setSections() {
		$this->sections[] = $this->importSampleData();
	    $this->sections[] = $this->getGeneralCfg();
	    $this->sections[] = $this->getHeaderCfg();
	    $this->sections[] = $this->getFooterCfg();
	    $this->sections[] = $this->getBlogCfg();
	    $this->sections[] = $this->getPageNotFoundCfg();
	    $this->sections[] = $this->getWooCfg();
	    $this->sections[] = $this->getAdvanceCfg();
	}
	public function getPatterns(){
		$patterns = array();
		$path = SNSHADONA_THEME_DIR . '/assets/img/patterns';
		$regex = '/(\.gif)|(.jpg)|(.png)|(.bmp)$/i';
		if( !is_dir($path) ) return;
		
		$dk =  opendir ( $path );
		$files = array();
		while ( false !== ($filename = readdir ( $dk )) ) {
			if (preg_match ( $regex, $filename )) {
				$files[] = $filename;
			}
		}
		foreach( $files as $p ) $patterns[] = $p;
		return $patterns;
	}
	public function importSampleData(){
		$desc = ''; $i_message = '';
		if ( ! function_exists( 'is_plugin_active' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        if( !is_plugin_active('wordpress-importer/wordpress-importer.php') ){
        	$i_message .= '<li><i class="fa fa-angle-double-right"></i> Need install and active plugin <a href="https://wordpress.org/plugins/wordpress-importer/" target="_blank">Wordpress Importer</a></li>';
        }
        if( !defined('WP_LOAD_IMPORTERS') ){
        	$i_message .= "<li><i class='fa fa-angle-double-right'></i> Need add <code>define('WP_LOAD_IMPORTERS', true);</code> to file wp-config.php</li>";
        }
        if ( $i_message !='' ){
        	$subtitle = '
				<p><label><i class="fa fa-exclamation-circle"></i>  Please follow the check list bellow to enable import function:</label></p>
				<ul class="i_message">'.$i_message.'</ul>
			';
        }else{
        	$subtitle = '<input type=\'button\' class=\'button\' name=\'btn_sampledata\' id=\'btn_sampledata\' value=\'Import\' />';
        	$subtitle .= '
		    	<div class=\'sns-importprocess\'>
		    		<div  class=\'sns-importprocess-width\'></div>
		    	</div>
		    	<span id=\'sns-importmsg\'><span class=\'status\'></span></span>
	    		<div id="sns-import-tablecontent">
					<label>List contents will import:</label>
					<ul>
					  <li class="theme-cfg"><i class="fa fa-hand-pointer-o"></i>Theme config</li>
					  <li class="revslider-cfg"><i class="fa fa-hand-pointer-o"></i>Revolution Slider config</li>
					  <li class="all-content"><i class="fa fa-hand-pointer-o"></i>All contents</li>
					  <li class="widget-cfg"><i class="fa fa-hand-pointer-o"></i>Widget config</li>
					</ul>
				</div>
	    	';
        }
		
		return  array(
		    'icon' => 'el-icon-briefcase',
		    'title' => esc_html__('Demo content', 'snshadona'),
		    'subsection' => true,
		    'fields' => array(
		        array(
		        	'title' => '',
		            'subtitle' => $subtitle,
		            'desc'	=> $desc,
		            'id' => 'theme_data',
		            'icon' => true,
		            'type' => 'image_select',
		            'default' => 'sns_hadona',
		            'options' => array(
		                'sns_logo' => get_template_directory_uri().'/assets/img/logo.png',
		            ),
		        )
		    )
		);
	}
	public function getGeneralCfg() {
		$patterns = $this->getPatterns();
		$pattern_opt = array();
		foreach($patterns as $pattern)
			$pattern_opt[$pattern] = array('img' => SNSHADONA_THEME_URI . '/assets/img/patterns/' . $pattern, 'alt' => $pattern);
		
	    return array(
	        'title'		=> esc_html__( 'General', 'snshadona' ),
	        'icon'		=> 'el-icon-cog',
	        'fields'	=> array(
	            array(
	                'id'       => 'theme_color',
	                'type'     => 'color',
	                'output'   => array( '.site-title' ),
	                'title'    => esc_html__( 'Theme Color', 'snshadona' ),
	                'default'  => '#e22020',
	        		'transparent'	=> false
	            ),
	             array(
	                'id'       => 'use_fullwidth',
	                'type'     => 'switch',
	                'title'    => esc_html__( 'Use extran screen', 'snshadona' ),
	                'default'  => true,
	                'on'       => 'Yes',
                    'off'      => 'No',
	            ),
	            array(
	                'id'       => 'use_boxedlayout',
	                'type'     => 'switch',
	                'title'    => esc_html__( 'Use Boxed Layout', 'snshadona' ),
	                'default'  => false,
	                'on'       => 'Yes',
                    'off'      => 'No',
	            ),
	            array(
	                'id'       => 'body_bg',
	                'type'     => 'background',
	                'output'   => array( 'body' ),
	                'title'    => esc_html__( 'Body Background', 'snshadona' ),
	                'background-image' => false,
	        		'preview'	=> false,
	        		'default'	=> '#f5f5f5'
	            ),
	            array(
	                'id'       => 'body_bg_type',
	                'type'     => 'select',
	                'title'    => esc_html__( 'Body Background Image', 'snshadona' ),
	                'options'  => array(
	                    'none'   	=> esc_html__( 'No image', 'snshadona' ),
	                    'pantern'   => esc_html__( 'Pantern', 'snshadona' ),
	                    'img'  		=> esc_html__( 'Image', 'snshadona' ),
	                ),
	                'default'  => 'pantern',
	                'select2'  => array( 'allowClear' => false ),
	              //  'required' => array( 'use_boxedlayout', '=', '1' )
	            ),
	            array(
	                'id'       => 'body_bg_type_pantern',
	                'type'     => 'image_select',
	                'options'  => $pattern_opt,
	                'width'		=>  '50px !important',
	                'height'	=> 50,
              	  //	'required' => array( 'body_bg_type', '=', array( 'pantern' ) )
	            ),
			    array(
			        'id'		=> 'body_bg_type_img',
			        'type'		=> 'media',
			        'title'		=> esc_html__( 'Body Background type img', 'snshadona' ),
			         'default'	=> '',
			        'title'    => 'Body Background type img',
              	 	'required' => array( 'body_bg_type', '=', array( 'img' ) ),
			    ),
	            array(
	                'id'          => 'body_font',
	                'type'        => 'typography',
	                'title'       => esc_html__( 'Body font', 'snshadona' ),
	                'line-height'   => false,
	                'text-align'   => false,
	                'color'         => true,
	                'all_styles'  => true,
	                'units'       => 'px',
	                // 'subsets'       => true,
	                'default'     => array(
	                    'font-size'   => '14px',
	                    'font-family' => 'Poppins',
	                    'font-weight' => '400',
	                    'color'		  => '#888888'
	                ),
	            ),
	            array(
	                'id'          => 'secondary_font',
	                'type'        => 'typography',
	                'title'       => esc_html__( 'Secondary font', 'snshadona' ),
	                'line-height'   => false,
	                'text-align'   => false,
	                'color'         => false,
	                'all_styles'  => true,
	                'units'       => 'px',
                	'font-size'     => false,
	                // 'subsets'       => true,
	                'default'     => array(
	                    'font-family' => 'Open Sans',
	                    'font-weight' => '400',
	                ),
	            ),
	            array(
	                'id'       => 'secondary_font_target',
	                'type'     => 'textarea',
	                'title'    => esc_html__( 'Secondary font target', 'snshadona' ),
	                'default'  => ''
	            ),
	             array(
	                'id'       => 'showbreadcrump',
	                'type'     => 'switch',
	                'title'    => 'Show Breadcrumbs',
	                'default'  => true,
	                'on'       => 'Yes',
                    'off'      => 'No',
	            ),
	        )
	    );
	}
	public function getHeaderCfg() {
	    return array(
	        'title'		=> esc_html__( 'Header', 'snshadona' ),
	        'icon'		=> 'el el-brush',
	        'fields'	=> array(
	        	array(
	        		'id'       => 'header_style',
	        		'type' => 'select',
	        		
	        		'title'    => esc_html__( 'Header Style', 'snshadona' ),
	        		'default'  => 'solid',
	        		'options' => array(
						'solid' 		=> esc_html__( 'Solid', 'snshadona'),
						'transparent' 	=> esc_html__( 'Transparent', 'snshadona'),
					),
					//'desc'		=> esc_html__( 'Select Header Style', 'snshadona' ),
	        		
	        	),
	        	 array(
	                'id'       => 'top_policy',
	                'type'     => 'switch',
	                'title'    => esc_html__( 'Show Top Policy', 'snshadona' ),
	                'default'  => true,
	                'on'       => 'Yes',
                    'off'      => 'No',
	            ),	
	        	array(
	                'id'       => 'header_bg_color',
	                'type'     => 'color',      
	                'title'    => esc_html__( 'Header Background Color', 'snshadona' ),
	                'default'  => '#000000',
	        		'transparent'	=> true
	            ),
			    array(
			        'id'		=> 'header_logo',
			        'type'		=> 'media',
			        'default'	=> '',
			        'title'		=> esc_html__( 'Logo', 'snshadona' ),
                	'subtitle' => esc_html__( 'If this is not selected, This theme will be display logo with "theme/snshadona/img/logo.png"', 'snshadona' ),
			        'desc'		=> esc_html__( 'Image that you want to use as logo', 'snshadona' ),
			    ),
			    array(
	                'id'       => 'use_stickmenu',
	                'type'     => 'switch',
	                'title'    => esc_html__( 'Enable Sticky Menu', 'snshadona' ),
	                'subtitle' => esc_html__( 'Keep menu on top when scroll down/up', 'snshadona' ),
	                'default'  => false,
	                'on'       => 'Yes',
                    'off'      => 'No',
	            ),
	        )
	    );
	}
	public function  getFooterCfg(){
		return array(
	        'title'		=> esc_html__( 'Footer', 'snshadona' ),
	        'icon'		=> 'el el-link',
	        'fields'	=> array(
	        
			     array(
			        'id'		=> 'footer_title_color',
			        'type'		=> 'color',
			        'title'		=> esc_html__( "Footer title color", 'snshadona' ),
			    	 'default'  => '#ffffff',
			    	 'transparent'	=> false
			    ),
			      array(
	                'id'       => 'use_footer_top',
	                'type'     => 'switch',
	                'title'    => esc_html__( 'Use Footer Top', 'snshadona' ),
	                'default'  => true,
	                'on'       => 'Yes',
                    'off'      => 'No',
	            ),	
			   
			     array(
			        'id'		=> 'footertop_bg_img',
			        'type'		=> 'media',
			        'title'		=> esc_html__( "Footer Top background", 'snshadona' ),
			        'required' => array( 'use_footer_top', '=', '1' )
			    ),
			    array(
			        'id'		=> 'footer_bg_color',
			        'type'		=> 'color',
			        'title'		=> esc_html__( "Footer background color", 'snshadona' ),
			    	 'default'  => '#222222',
			    	 'transparent'	=> false
			    ),
			    
			    array(
			        'id'		=> 'payment_img',
			        'type'		=> 'media',
			        'title'		=> esc_html__( "Payment method's image", 'snshadona' ),
			    	'default'	=> get_template_directory_uri() . '/assets/img/default/payment.png',
			    ),
			    array(
			        'id'		=> 'copyright',
			        'type'		=> 'textarea',
			        'title'		=> esc_html__( "Copyright", 'snshadona' ),
			        'default' => esc_html__( "Designed by SNSTheme.Com", 'snshadona' ),
			    ),
	        )
	    );
	}
	public function getBlogCfg() {
		$siderbars = array(
		    'widget-area' => esc_html__( 'Main Sidebar', 'snshadona' ),
			'home-sidebar' => esc_html__( 'Home Sidebar', 'snshadona' ),
			'product-sidebar' => esc_html__( 'Product Sidebar', 'snshadona' ),
			'blog-sidebar' => esc_html__( 'Blog Sidebar', 'snshadona' ),
			'woo-sidebar' => esc_html__( 'Woo Sidebar', 'snshadona' ),
		);
		//if( is_admin() ) wp_enqueue_style('sns-admin-css', SNSHADONA_THEME_URI . '/assets/css/admin-theme-option.css');
	    return array(
	        'title'		=> esc_html__( 'Blog', 'snshadona' ),
	        'icon'		=> 'el el-file-edit',
	        'fields'	=> array(
				array(
				    'id'       => 'layouttype',
				    'type'     => 'image_select',
				    'title'    => esc_html__('Default Blog Layout', 'snshadona'), 
				    'options'  => array(
				        'm'      => array(
				            'alt'   => esc_html__( 'Without Sidebar', 'snshadona' ), 
				            'img'   => SNSHADONA_THEME_URI.'/assets/img/admin/m.jpg'
				        ),
				        'l-m'      => array(
				            'alt'   => esc_html__( 'Use Left Sidebar', 'snshadona' ), 
				            'img'   => SNSHADONA_THEME_URI.'/assets/img/admin/l-m.jpg'
				        ),
				        'm-r'      => array(
				            'alt'  => esc_html__( 'Use Right Sidebar', 'snshadona' ), 
				            'img'  => SNSHADONA_THEME_URI.'/assets/img/admin/m-r.jpg'
				        ),
				        // 'l-m-r'      => array(
				        //     'alt'   => esc_html__( 'Use Left & Right Sidebar', 'snshadona' ), 
				        //     'img'   => SNSHADONA_THEME_URI.'/assets/img/admin/l-m-r.jpg'
				        // )
				    ),
				    'default' => 'm-r'
				),
				// Left Sidebar
				array(
					'title'  => esc_html__( 'Left Sidebar', 'snshadona' ),
					'id'    => "leftsidebar",
					//'desc'  => esc_html__( 'Text description', 'snshadona' ),
					'type'  => 'select',
					'options'	=> $siderbars,
					'multiselect'	=> false,
					'required' => array( 'layouttype', '=', array( 'l-m', 'l-m-r' ) )
				),
				// Right Sidebar
				array(
					'title'  => esc_html__( 'Right Sidebar', 'snshadona' ),
					'id'    => "rightsidebar",
					//'desc'  => esc_html__( 'Text description', 'snshadona' ),
					'type'  => 'select',
					'options'	=> $siderbars,
					'multiselect'	=> false,
					'required' => array( 'layouttype', '=', array( 'm-r', 'l-m-r' ) )
				),
				array( 
		        	'title' => esc_html__( 'Blog Style', 'snshadona'),
					'id' => 'blog_type',
					'default' => '',
					'type' => 'select',
					'multiselect' => false ,
					'options' => array(
						'' 				=> esc_html__( 'Blog Layout 1', 'snshadona'),
						'layout2' 		=> esc_html__( 'Blog Layout 2', 'snshadona'),
						'masonry' 		=> esc_html__( 'Masonry', 'snshadona'),
					)
				),
				array(
				    'id'   =>'divider_blog',
				    'type' => 'divide'
				),
	            array(
	                'id'       => 'show_categories',
	                'type'     => 'switch',
	                'title'    => esc_html__( 'Show Categories for Blog Entries Page', 'snshadona' ),
	                'default'  => true,
	                'on'       => 'Yes',
	                'off'      => 'No',
	            ),
	        	array(
	        		'id'       => 'show_date',
	        		'type'     => 'switch',
	        		'title'    => esc_html__( 'Show Date for Blog Entries Page', 'snshadona' ),
	        		'default'  => true,
	        		'on'       => 'Yes',
	        		'off'      => 'No',
	        	),
	        	
	            array(
	                'id'       => 'show_author',
	                'type'     => 'switch',
	                'title'    => esc_html__( 'Show Author for Blog Entries Page', 'snshadona' ),
	                'default'  => true,
	                'on'       => 'Yes',
	                'off'      => 'No',
	            ),
	        	array(
	        		'id'       => 'show_tags',
	        		'type'     => 'switch',
	        		'title'    => esc_html__( 'Show Tags for Blog Entries Page', 'snshadona' ),
	        		'default'  => true,
	        		'on'       => 'Yes',
	        		'off'      => 'No',
	        	),
	        	array(
	        		'id'       => 'show_comment_count',
	        		'type'     => 'switch',
	        		'title'    => esc_html__( 'Show Comment Count', 'snshadona' ),
	        		'default'  => true,
	        		'on'       => 'Yes',
	        		'off'      => 'No',
	        	),
	        	array(
	        		'id'       => 'excerpt_length',
	        		'type'     => 'text',
	        		'title'    => esc_html__( 'Blog Excerpt Length', 'snshadona' ),
	        		'default'  => '55',
	        	),
	        	array(
	        		'id'       => 'show_readmore',
	        		'type'     => 'switch',
	        		'title'    => esc_html__( 'Enable Read More Button', 'snshadona' ),
	        		'default'  => true,
	        		'on'       => 'Yes',
	        		'off'      => 'No',
	        	),
	        	array(
	        		'id'       => 'tag_showmore',
	        		'type'     => 'switch',
	        		'title'    => esc_html__( 'Enable View More Tags', 'snshadona' ),
	        		'subtitle' => esc_html__( 'Apply for widget Tag Cloud to show the number for tags display first.', 'snshadona' ),
	        		'default'  => true,
	        		'on'       => 'Yes',
	        		'off'      => 'No',
	        	),
	        	array(
	                'id'       => 'tag_display_first',
	                'type'     => 'text',
	                'title'    => esc_html__( 'The number for Tags display first.', 'snshadona' ),
	                'default'  => '7',
	                'required' => array( 'tag_showmore', '=', true )
	            ),

	            array(
				    'id'   =>'divider_post',
				    'type' => 'divide'
				),
	            array(
	                'id'       => 'show_postauthor',
	                'type'     => 'switch',
	                'title'    => esc_html__( 'Enable Author Info on Post Detail', 'snshadona' ),
	                'default'  => true,
	                'on'       => 'Yes',
	                'off'      => 'No',
	            ),
	            array(
	                'id'       => 'enalble_related',
	                'type'     => 'switch',
	                'title'    => esc_html__( 'Enable Related Posts on Post Detail', 'snshadona' ),
	                'default'  => false,
	                'on'       => 'Yes',
	                'off'      => 'No',
	            ),
	        	array(
	        		'id' 		=> 'related_posts_by',
	        		'title' 	=> esc_html__( 'Related Post By', 'snshadona'),
	        		'desc'		=> esc_html__('Get related post by Categories or Tags', 'snshadona'),
	        		'default' 	=> 'cat',
	        		'type' 		=> 'select',
	        		'multiselect' => false ,
	        		'options'	=> array(
	        			'cat' 	=> 'Categories',
	        			'tag' 	=>  'Tags',
	        		),
	        		'required' => array( 'enalble_related', '=', true )
	        	),
	            array(
	                'id'       => 'related_num',
	                'type'     => 'text',
	                'title'    => esc_html__( 'Related Posts Number', 'snshadona' ),
	                'default'  => '5',
	                'required' => array( 'enalble_related', '=', true )
	            ),
	            array(
	                'id'       => 'show_postsharebox',
	                'type'     => 'switch',
	                'title'    => esc_html__( 'Enable Share Box on Post Detail', 'snshadona' ),
	                'default'  => false,
	                'on'       => 'Yes',
	                'off'      => 'No',
	            ),
	            array(
				    'id'       => 'show_facebook_sharebox',
				    'type'     => 'checkbox',
				    'title'    => esc_html__('Show Facebook in Sharing Box', 'snshadona'),
				    'required' => array( 'show_postsharebox', '=', true ),
				    'default'  => '1'// 1 = on | 0 = off
				),
	            array(
				    'id'       => 'show_twitter_sharebox',
				    'type'     => 'checkbox',
				    'title'    => esc_html__('Show Twitter in Sharing Box', 'snshadona'), 
				    'required' => array( 'show_postsharebox', '=', true ),
				    'default'  => '1'// 1 = on | 0 = off
				),
				array(
				    'id'       => 'show_gplus_sharebox',
				    'type'     => 'checkbox',
				    'title'    => esc_html__('Show G + in Sharing Box', 'snshadona'),
				    'required' => array( 'show_postsharebox', '=', true ), 
				    'default'  => '1'// 1 = on | 0 = off
				),
				array(
				    'id'       => 'show_linkedin_sharebox',
				    'type'     => 'checkbox',
				    'title'    => esc_html__('Show Linkedin in Sharing Box', 'snshadona'), 
				    'required' => array( 'show_postsharebox', '=', true ),
				    'default'  => '1'// 1 = on | 0 = off
				),
				array(
				    'id'       => 'show_pinterest_sharebox',
				    'type'     => 'checkbox',
				    'title'    => esc_html__('Show Pinterest in Sharing Box', 'snshadona'), 
				    'required' => array( 'show_postsharebox', '=', true ),
				    'default'  => '1'// 1 = on | 0 = off
				),
				array(
				    'id'       => 'show_tumblr_sharebox',
				    'type'     => 'checkbox',
				    'title'    => esc_html__('Show Tumblr in Sharing Box', 'snshadona'), 
				    'required' => array( 'show_postsharebox', '=', true ),
				    'default'  => '1'// 1 = on | 0 = off
				),
				array(
				    'id'       => 'show_email_sharebox',
				    'type'     => 'checkbox',
				    'title'    => esc_html__('Show Send Email in Sharing Box', 'snshadona'), 
				    'required' => array( 'show_postsharebox', '=', true ),
				    'default'  => '1'// 1 = on | 0 = off
				),
	        	array(
	        		'id' 		=> 'pagination',
	        		'title' 	=> esc_html__( 'Page Navigation', 'snshadona'),
	        		'desc'		=> esc_html__('Choose Type of navigation for blog and any listing page.', 'snshadona'),
	        		'default' 	=> 'def',
	        		'type' 		=> 'select',
	        		'multiselect' => false ,
	        		'options'	=> array(
	        			'def' 	=> esc_html__('Default PageNavi', 'snshadona'),
	        			'ajax' 	=>  esc_html__('Ajax', 'snshadona'),
	        		),
	        	),

	            
	        )
	    );
	}
	public function getPageNotFoundCfg(){
		return array(
			'title'		=> esc_html__( 'Page Not Found', 'snshadona' ),
			'icon'		=> 'el el-warning-sign',
			'fields'	=> array(
				array(
	                'id'       => 'notfound_title',
	                'type'     => 'text',
	                'title'    => esc_html__( 'Title', 'snshadona' ),
	                'default'  => esc_html__('PAGE NOT FOUND', 'snshadona'),
	            ),
				array(
					'id'       => 'notfound_content',
					'type'     => 'textarea',
					'title'    => esc_html__( 'Content', 'snshadona' ),
					'default'  => esc_html__('Sory but the page you are looking for does not exit, have been removed or name changed. Go back Homepage or enter the key words to search, please!', 'snshadona'),
				),
			  )
			);
	}

	public function getWooCfg() {
		return array(
	        'title'		=> esc_html__( 'WooCommerce', 'snshadona' ),
	        'icon'		=> 'el el-shopping-cart',
	        'fields'	=> array(
	        	array(
	                'id'       => 'woo_uselazyload',
	                'type'     => 'switch',
	                'title'    => esc_html__( 'Use lazyload for Product Image', 'snshadona' ),
	                'default'  => true,
	                'on'       => 'Yes',
	                'off'      => 'No',
	            ),
	            array(
	                'id'		=> 'woo_list_modeview',
	                'type'		=> 'select',
	                'title'		=> esc_html__( 'Default mode view for listing page', 'snshadona' ),
	                'options'  => array(
	                    'grid' => esc_html__( 'Grid', 'snshadona' ),
	                    'list' => esc_html__( 'List', 'snshadona' ),
	                    'list-table' => esc_html__( 'List Table', 'snshadona' ),
	                ),
	                'default'  => 'grid'
			    ),
	            array(
	                'id'       => 'woo_grid_col',
	                'type'     => 'select',
	                'title'    => esc_html__( 'Grid columns', 'snshadona' ),
	                'subtitle'  => esc_html__( 'We are using grid bootstap - 12 cols layout', 'snshadona' ),
	                'default'  => '5',
	                'options'  => array(
	                    '1' => '1',
	                    '2' => '2',
	                    '3' => '3',
	                    '4' => '4',
	                    '5' => '5',
	                    '6' => '6',
	                ),
	            ),
	            array(
	                'id'       => 'woo_number_perpage',
	                'type'     => 'text',
	                'title'    => esc_html__( 'Number products per listing page', 'snshadona' ),
	                'default'  => '15',
	            ),
	            array(
	                'id'       => 'woo_onsale_layout',
	                'type'     => 'select',
	                'title'    => esc_html__( 'On Sale Products', 'snshadona' ),
	                'subtitle'  => esc_html__( 'Slect layout for On Sale Products shown in archive page.', 'snshadona' ),
	                'default'  => 'carousel',
	                'options'  => array(
	                    'carousel' =>  esc_html__( 'Carousel', 'snshadona' ),
	                    'list' =>  esc_html__( 'List', 'snshadona' ),
	                ),
	            ),
	            array(
	                'id'       => 'woo_onsale_limit',
	                'type'     => 'text',
	                'title'    => esc_html__( 'On Sale Limit', 'snshadona' ),
	                'subtitle'  => esc_html__( 'Number of On Sale Products to query.', 'snshadona' ),
	                'default'  => '5'
	            ),
	            array(
	                'id'       => 'woo_custom_block',
	                'type'     => 'textarea',
	                'title'    => __( 'Custom block', 'snshadona' ),
	                'subtitle' => '',
	                'desc'     => __( 'Some HTML is allowed in here: a,img,p,br,em,strong.', 'snshadona' ),
	                'validate' => 'html_custom',
	                'default'  => '<p>Some HTML is allowed in here.</p>',
	                'allowed_html' => array(
	                    'a'      => array(
	                        'href'  => array(),
	                        'title' => array()
	                    ),
	                    'img'      => array(
	                        'src'  => array(),
	                        'alt' => array()
	                    ),
	                    'p'     => array(),
	                    'br'     => array(),
	                    'em'     => array(),
	                    'strong' => array()
	                ) //see http://codex.wordpress.org/Function_Reference/wp_kses
	            ),

	        	
	            array(
				    'id'   =>'divider_blog',
				    'type' => 'divide'
				),
				array(
	                'id'       => 'single_product_sidebar',
	                'type'     => 'switch',
	                'title'    => esc_html__( 'Show Single Product Sidebar', 'snshadona' ),
	                'default'  => false,
	                'on'       => 'Yes',
	                'off'      => 'No',
	            ),
				array(
	                'id'       => 'woo_usecloudzoom',
	                'type'     => 'switch',
	                'title'    => esc_html__( 'Enable Cloud Zoom for Product Image', 'snshadona' ),
	                'default'  => true,
	                'on'       => 'Yes',
	                'off'      => 'No',
	            ),
	            array(
	                'id'       => 'woo_zoomtype',
	                'type'     => 'select',  
	                'title'    => esc_html__( 'Zoom Type for Cloud Zoom', 'snshadona' ),
	                'options'  => array(
	                    'window'   	=> esc_html__( 'Window', 'snshadona' ),
	                    'lens'   	=> esc_html__( 'Lens', 'snshadona' ),
	                    'inner'   	=> esc_html__( 'Inner', 'snshadona' ),                  		                   
	                ),
	                'default'  => 'window',       
	                'required' => array( 'woo_usecloudzoom', '=', true ) 	
	            ),
	            array(
	                'id'       => 'woo_sharebox',
	                'type'     => 'switch',
	                'title'    => esc_html__( 'Enable Share box', 'snshadona' ),
	                'default'  => true,
	                'on'       => 'Yes',
	                'off'      => 'No',
	            ),
	              array(
	                'id'       => 'woo_upsells',
	                'type'     => 'switch',
	                'title'    => esc_html__( 'Enable Upsells Products', 'snshadona' ),
	                'default'  => true,
	                'on'       => 'Yes',
	                'off'      => 'No',
	            ),
	            array(
	                'id'       => 'woo_related',
	                'type'     => 'switch',
	                'title'    => esc_html__( 'Enable Related Products', 'snshadona' ),
	                'default'  => true,
	                'on'       => 'Yes',
	                'off'      => 'No',
	            ),
	            array(
	            	'id'       => 'woo_related_num',
                 	'type'     => 'text',
                 	'title'    => esc_html__( 'Number Related Products to display', 'snshadona' ),
                 	'required' => array( 'woo_related', '=', '1' ),
                 	'default'  => '6',
                ),
            
	        )
	    );
	}
	public function getAdvanceCfg() {
	    return array(
	        'title'		=> esc_html__( 'Advance', 'snshadona' ),
	        'icon'		=> 'el el-wrench',
	        'fields'	=> array(
	            array(
	                'id'       => 'advance_tooltip',
	                'type'     => 'switch',
	                'title'    => esc_html__( 'Enable Tooltip', 'snshadona' ),
	                'default'  => false,
	                'on'       => 'Yes',
	                'off'      => 'No',
	            ),
	            array(
	                'id'       => 'advance_cpanel',
	                'type'     => 'switch',
	                'title'    => esc_html__( 'Enable Cpanel', 'snshadona' ),
	                'default'  => false,
	                'on'       => 'Yes',
	                'off'      => 'No',
	            ),
	            array(
	                'id'       => 'advance_scrolltotop',
	                'type'     => 'switch',
	                'title'    => esc_html__( 'Enable Button Scroll To Top', 'snshadona' ),
	                'default'  => true,
	                'on'       => 'Yes',
	                'off'      => 'No',
	            ),
	            array(
	                'id'		=> 'advance_scss_compile',
	                'type'		=> 'select',
	                'title'		=> esc_html__( 'SCSS Compile', 'snshadona' ),
	                'options'  => array(
	                    '1' => esc_html__( 'Only compile when don\'t have the css file', 'snshadona' ),
	                    '2' => esc_html__( 'Alway compile', 'snshadona' ),
	                ),
	                'default'  => '1'
			    ),
	            array(
	                'id'		=> 'advance_scss_format',
	                'type'		=> 'select',
	                'title'		=> esc_html__( 'CSS Format', 'snshadona' ),
	                'options'  => array(
	                    'scss_formatter' => esc_html__( 'scss_formatter', 'snshadona' ),
	                    'scss_formatter_nested' => esc_html__( 'scss_formatter_nested', 'snshadona' ),
	                    'scss_formatter_compressed' => esc_html__( 'scss_formatter_compressed', 'snshadona' ),
	                ),
	                'default'  => 'scss_formatter_compressed'
			    ),
	            array(
	                'id'       => 'advance_customcss',
	                'type'     => 'ace_editor',
	                'title'    => esc_html__( 'Custom CSS', 'snshadona' ),
	                'subtitle' => esc_html__( 'Paste your CSS code here. EX: .class{font-size:13px}', 'snshadona' ),
	                'mode'     => 'css',
	                'theme'    => 'monokai',
	                'default'  => ""
	            ),
	            array(
	                'id'       => 'advance_customjs',
	                'type'     => 'ace_editor',
	                'title'    => esc_html__( 'Custom JS', 'snshadona' ),
	                'subtitle' => esc_html__( 'Enter your JS code here.', 'snshadona' ),
	                'theme'    => 'chrome',
	                'default'  => ""
	            ),
	        )
	    );
	}
}
}

?>