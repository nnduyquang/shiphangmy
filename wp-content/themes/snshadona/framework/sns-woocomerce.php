<?php
if(class_exists('WooCommerce')){
	class snshadona_Woocommerce{

        public $revsliders = array();

		public static function getInstance(){
			static $_instance;
			if( !$_instance ){
				$_instance = new snshadona_Woocommerce();
			}
			return $_instance;
		}
		public function __construct(){
            global $wpdb;
            $this->revsliders[0] = 'Select a slider';
            if ( ! function_exists( 'is_plugin_active' ) ) {
                require_once ABSPATH . 'wp-admin/includes/plugin.php';
            }
            if (is_plugin_active('revslider/revslider.php')) {
                $query = $wpdb->prepare("
                    SELECT * 
                    FROM {$wpdb->prefix}revslider_sliders 
                    ORDER BY %s"
                    , "ASC");
                $get_sliders = $wpdb->get_results($query);
                if($get_sliders) {
                    foreach($get_sliders as $slider) {
                       $this->revsliders[$slider->alias] = $slider->title;
                   }
                }
            }

			// Add Scripts
			add_action('wp_head', array($this, 'snshadona_renderurlajax'), 15);
			add_action( 'wp_enqueue_scripts', array($this,'snshadona_getscripts') );
			// Number product per page
			add_filter( 'loop_shop_columns', array($this, 'snshadona_woo_shop_columns') );
			// Grid cols per row
			add_filter( 'loop_shop_per_page', array($this, 'snshadona_woo_shop_perpage') );
			// Remove each style one by one
			add_filter( 'woocommerce_enqueue_styles', array($this, 'snshadona_dequeue_woostyles') );
			// Set modeview
			add_action( 'wp_ajax_sns_setmodeview', array($this,'snshadona_set_modeview') );
			add_action( 'wp_ajax_nopriv_sns_setmodeview', array($this,'snshadona_set_modeview') );
			// Ajax load more
			add_action('wp_ajax_sns_wooloadmore', array($this, 'snshadona_woo_loadmore'));
			add_action('wp_ajax_nopriv_sns_wooloadmore', array($this, 'snshadona_woo_loadmore'));
			
			// Ajax load more
			add_action('wp_ajax_sns_wootabloadproducts', array($this, 'snshadona_woo_tab_load_products'));
			add_action('wp_ajax_nopriv_sns_wootabloadproducts', array($this, 'snshadona_woo_tab_load_products'));

			remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
            add_action( 'woocommerce_before_shop_loop_item_title', 'snshadona_product_thumbnail', 11 );

                // Add Taxonomy product_cat custom meta fields
            add_action('product_cat_add_form_fields', array(&$this, 'snshadona_product_cat_add_new_meta_field'), 20, 3);
            add_action('product_cat_edit_form_fields', array(&$this, 'snshadona_product_cat_edit_meta_field'), 20, 3);
            // Save extra taxonomy fields callback function
            add_action( 'edit_term', array(&$this,'snshadona_save_product_cat_custom_meta'), 10, 3 );
            add_action( 'created_term', array(&$this,'snshadona_save_product_cat_custom_meta'), 10, 3 );

            // Add Taxonomy product_attributes custom meta fields
            $attribute_taxonomies = wc_get_attribute_taxonomies();
            if ( $attribute_taxonomies ) {
                foreach ( $attribute_taxonomies as $attribute) {
                    add_action( 'pa_' . $attribute->attribute_name . '_add_form_fields', array(&$this, 'snshadona_product_attribute_add_new_meta_field'), 20, 3 );
                    add_action( 'pa_' . $attribute->attribute_name . '_edit_form_fields', array(&$this, 'snshadona_product_attribute_edit_meta_field'), 20, 3);

                    add_action( 'edit_term', array(&$this,'snshadona_product_attribute_save_custom_meta'), 10, 3 );
                    add_action( 'created_term', array(&$this,'snshadona_product_attribute_save_custom_meta'), 10, 3 );
                }
            }
            /*
            * Variable Product
            */
            add_action('wp_head', array(&$this, 'snshadona_variable_product'), 1000);

            // Add product variation select anwhere.
            add_action( 'sns_show_product_loop_variable', array(&$this, 'snshadona_show_product_loop_variable'), 30 );

			remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
		}
		
		public function snshadona_getscripts(){
            global $snshadona_opt;
            $optimize = '';
            wp_enqueue_script('snshadona-woocommerce', SNSHADONA_THEME_URI.'/assets/js/sns-woocommerce'.$optimize.'.js', array('jquery'), '', true);
            if ( class_exists( 'YITH_WCAN_Frontend' ) ) {
                wp_dequeue_script('yith-wcan-script');
                if ( is_product_category() || is_shop() ) {
                    wp_enqueue_script('snshadona-wcan-script', SNSHADONA_THEME_URI.'/assets/js/yith-wcan-frontend.js', array('jquery'), '', true);
                    $args = apply_filters( 'yith_wcan_ajax_frontend_classes', array(
                                'container'             => yith_wcan_get_option( 'yith_wcan_ajax_shop_container', '.products' ),
                                'pagination'            => yith_wcan_get_option( 'yith_wcan_ajax_shop_pagination', 'nav.woocommerce-pagination' ),
                                'result_count'          => yith_wcan_get_option( 'yith_wcan_ajax_shop_result_container', '.woocommerce-result-count' ),
                                'wc_price_slider'       => array(
                                   
                                    'min_price' => '.price_slider_amount #min_price',
                                    'max_price' => '.price_slider_amount #max_price',
                                     'wrapper'   => '.price_slider',
                                )
                            )
                    );
                    wp_localize_script( 'snshadona-wcan-script', 'yith_wcan', apply_filters( 'yith-wcan-frontend-args', $args ) );
                }
            }
            wp_dequeue_script('prettyPhoto-init');
            if ( $snshadona_opt['woo_usecloudzoom'] && is_product() )
                wp_enqueue_script('elevatezoom-custom', SNSHADONA_THEME_URI.'/assets/js/elevatezoom-custom'.$optimize.'.js', array('jquery'), '', true);
        }
		
		public function snshadona_renderurlajax() {
		?>
			<script type="text/javascript">
				var ajaxurl = '<?php echo esc_url( admin_url('admin-ajax.php') ); ?>';
			</script>
			<?php
		}

        public function snshadona_variable_product(){
           $theID = get_the_id();
           $product = wc_get_product( $theID );
           if( !is_product() ){
            return;
           }
            if( $product->product_type === 'variable' ){
                $attributes = $product->get_attributes();
                 ob_start();?>
                    <script type="text/javascript">
                        var sns_arr_attr = {};
                        <?php foreach ( $attributes as $attribute ) :
                            if ( empty( $attribute['is_visible'] ) || ( $attribute['is_taxonomy'] && ! taxonomy_exists( $attribute['name'] ) ) ) {
                                continue;
                            } else {}
                            
                           $terms = wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'all' ) );
                            
                            $type = '';
                            $key_val = array();
                            $i = 0;
                            foreach ($terms as $term) { $i++;
                                $type = get_woocommerce_term_meta( $term->term_id, 'snshadona_product_attribute_type' );
                                $type = ($type == '') ? 'text' : $type;
                                switch ($type) {
                                    case 'color':
                                        $key_val[$term->slug] = get_woocommerce_term_meta( $term->term_id, 'snshadona_product_attribute_color' );
                                        break;

                                    case 'image':
                                        $att_image_id = get_woocommerce_term_meta( $term->term_id, 'snshadona_product_attribute_image_id' );
                                        $att_image = wp_get_attachment_image_src( $att_image_id, 'snshadona_attribute_pa_images_size' );
                                        $att_image_url = (isset($att_image['0'])) ? $att_image['0'] : '';

                                        $key_val[$term->slug] = $att_image_url;
                                        break;
                                    
                                    default: // type is text
                                        $key_val[$term->slug] = $term->name;
                                        break;
                                }
                            }
                            ?>
                            var attributeName = '<?php echo $attribute['name'] ?>';
                            var data_type = '<?php echo $type; ?>';
                            var key_val = {};
                            <?php foreach ($key_val as $key => $value):?>
                                key_val['<?php echo $key ?>'] = '<?php echo $value ?>';
                            <?php endforeach;?>
                            sns_arr_attr['attribute_' + attributeName] = {'type': data_type, key_val};
                        <?php endforeach; ?>
                    </script>
                <?php
                echo ob_get_clean();
            }
        }

        public function snshadona_show_product_loop_variable(){
            global $product;
            if( $product->product_type === 'variable' ):
                // Load the template
                wc_get_template( 'variable.php', array(
                    'attributes'           => $product->get_variation_attributes()
                ) );
            endif;
        }
		
		public function snshadona_woo_loadmore(){
			$orderby        = $_POST['order'];
			$number_query   = $_POST['numberquery'];
			$start          = $_POST['start'];
			$list_cat       = $_POST['cat'];
			$col            = $_POST['col'];
			$eclass         = $_POST['eclass'];
			$loop = snshadona_woo_query($orderby, $number_query, $list_cat, $start);
			while ( $loop->have_posts() ) : $loop->the_post();
			wc_get_template( 'vc/item-grid.php', array('col' => $col, 'animate' => 1, 'eclass' => $eclass) );
			endwhile;
			wp_die();
		}
		
		public function snshadona_woo_tab_load_products(){
			
			$tab_args = array(
					'data_type'		=> $_POST['data_type'],
					'wrap_id'		=> $_POST['wrap_id'],
					'tab_id'		=> $_POST['tab_id'],
					'cat'			=> $_POST['cat'],
					'template'		=> $_POST['template'],
					'orderby'		=> $_POST['orderby'],
					'number_query'	=> $_POST['number_query'],
					'number_display'=> $_POST['number_display'],
                    'number_display_1200'=> $_POST['number_display_1200'],
                    'number_display_992'=> $_POST['number_display_992'],
                    'number_display_768'=> $_POST['number_display_768'],
                    'number_display_480'=> $_POST['number_display_480'],
					'number_limit'	=> $_POST['number_limit'],
					'effect_load'	=> $_POST['effect_load'],
					'col'			=> $_POST['col'],
					'uq'			=> $_POST['uq'],
					'number_load'	=> $_POST['number_load'],
					'eclass'		=> $_POST['eclass'],
					'animate'		=> 'yes',
				);
			
			wc_get_template( 'vc/template-tab.php', array('tab_args' => $tab_args) );
			wp_die();
		}

		public function snshadona_set_modeview(){
			setcookie('sns_woo_list_modeview', $_POST['mode'] , time()+3600*24*100, '/');
		}
		public function snshadona_woo_shop_columns( $columns ) {
			global $snshadona_opt;
            if(is_product_category()){
                $cat = get_queried_object();
                $snshadona_product_cat_grid_col = get_woocommerce_term_meta( $cat->term_id, 'snshadona_product_cat_grid_col' );
                if( $snshadona_product_cat_grid_col != '' )
                    return $snshadona_product_cat_grid_col;
            }
		    return $snshadona_opt['woo_grid_col'];
		}
		public function snshadona_woo_shop_perpage( $columns ) {
			global $snshadona_opt;
             if(is_product_category()){
                $cat = get_queried_object();
                $snshadona_number_perpage = get_woocommerce_term_meta( $cat->term_id, 'snshadona_number_perpage' );
                if( $snshadona_number_perpage != '' )
                    return $snshadona_number_perpage;
            }
            
		    return $snshadona_opt['woo_number_perpage'];
		}
		
		public function snshadona_dequeue_woostyles( $enqueue_styles ) {
			unset( $enqueue_styles['woocommerce-general'] );	// Remove the gloss
			unset( $enqueue_styles['woocommerce-layout'] );		// Remove the layout
			unset( $enqueue_styles['woocommerce-smallscreen'] );	// Remove the smallscreen optimisation
			return $enqueue_styles;
		}
         // Add term page
    public function snshadona_product_cat_add_new_meta_field(){
        // This will add the custom meta field  to the add new term page
        $revsliders = $this->revsliders;
        ?>
        <div class="form-field term-snshadona_product_cat_slideshow">
            <label for="snshadona_product_cat_slideshow"><?php esc_html_e( 'Slideshow', 'snshadona' ); ?></label>
            <select name="snshadona_product_cat_slideshow" id="snshadona_product_cat_slideshow">
                <?php
                foreach ($revsliders as $key => $value):?>
                   <option value="<?php  echo $key; ?>"><?php  echo $value; ?></option>
                <?php
                endforeach;
                ?>
            </select>
            <p class="description"><?php esc_html_e( 'Select Slideshow.','snshadona' ); ?></p>
        </div>

        <div class="form-field term-snshadona_product_cat_layout">
            <label for="snshadona_product_cat_layout"><?php esc_html_e( 'Layout', 'snshadona' ); ?></label>
            <select name="snshadona_product_cat_layout" id="snshadona_product_cat_layout">
                <option value=""><?php esc_html_e('Default (Layout of Shop page)', 'snshadona');?></option>
                <option value="m"><?php esc_html_e('Fullwidth', 'snshadona');?></option>
                <option value="l-m"><?php esc_html_e('Left Sidebar', 'snshadona');?></option>
                <option value="m-r"><?php esc_html_e('Right Sidebar', 'snshadona');?></option>
            </select>
            <p class="description"><?php esc_html_e( 'Set the layout fullwidth or has sidebar (Woo Sidebar).','snshadona' ); ?></p>
        </div>

        <div class="form-field term-snshadona_product_cat_grid_col">
            <label for="snshadona_product_cat_grid_col"><?php esc_html_e( 'Grid columns', 'snshadona' ); ?></label>
            <select name="snshadona_product_cat_grid_col" id="snshadona_product_cat_grid_col">
                <option value=""><?php esc_html_e('Default', 'snshadona');?></option>
                <option value="1">1</option>
                <option value="1">2</option>
                <option value="1">3</option>
                <option value="1">4</option>
                <option value="1">6</option>
            </select>
            <p class="description"><?php esc_html_e( 'We are using grid bootstap - 12 cols layout. Default use in Theme Options.','snshadona' ); ?></p>
        </div>
         <div class="form-field term-snshadona_number_perpage">
            <label for="snshadona_number_perpage"><?php esc_html_e( 'Number products per listing page', 'snshadona' ); ?></label>
            <input name="snshadona_number_perpage" id="snshadona_number_perpage" type="text" value="5" size="40">
        </div>

        <div class="form-field term-snshadona_woo_onsale_layout">
            <label for="snshadona_woo_onsale_layout"><?php esc_html_e( 'On Sale Products', 'snshadona' ); ?></label>
            <select name="snshadona_woo_onsale_layout" id="snshadona_woo_onsale_layout">
                <option value="carousel"><?php esc_html_e('Carousel', 'snshadona');?></option>
                <option value="list"><?php esc_html_e('List', 'snshadona');?></option>
            </select>
            <p class="description"><?php esc_html_e( 'Slect layout for On Sale Products shown in this category.','snshadona' ); ?></p>
        </div>

         <div class="form-field term-snshadona_woo_onsale_limit">
            <label for="snshadona_woo_onsale_limit"><?php esc_html_e( 'On Sale Limit', 'snshadona' ); ?></label>
            <input name="snshadona_woo_onsale_limit" id="snshadona_woo_onsale_limit" type="text" value="5" size="40">
            <p class="description"><?php esc_html_e( 'Number of On Sale Products to query.','snshadona' ); ?></p>
        </div>
        
        <?php
    }
    // Edit term page
        public function snshadona_product_cat_edit_meta_field($term, $taxonomy){
            $revsliders = $this->revsliders;
            $snshadona_product_cat_slideshow = get_woocommerce_term_meta( $term->term_id, 'snshadona_product_cat_slideshow' );

            $snshadona_product_cat_layout = get_woocommerce_term_meta( $term->term_id, 'snshadona_product_cat_layout' );
            $snshadona_product_cat_grid_col = get_woocommerce_term_meta( $term->term_id, 'snshadona_product_cat_grid_col' );
            $snshadona_number_perpage = get_woocommerce_term_meta( $term->term_id, 'snshadona_number_perpage' );

            $snshadona_woo_onsale_layout = get_woocommerce_term_meta( $term->term_id, 'snshadona_woo_onsale_layout' );
            $snshadona_woo_onsale_limit = get_woocommerce_term_meta( $term->term_id, 'snshadona_woo_onsale_limit' );
            ?>
            <tr class="form-field snshadona_product_cat_slideshow">
                <th scope="row"><label for="snshadona_product_cat_slideshow"><?php esc_html_e( 'Slideshow', 'snshadona' ); ?></label></th>
                <td>
                    <select name="snshadona_product_cat_slideshow" id="snshadona_product_cat_slideshow">
                        <?php
                        foreach ($revsliders as $key => $value):?>
                           <option value="<?php  echo $key; ?>" <?php selected($snshadona_product_cat_slideshow, $key, true)?>><?php  echo $value; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                    
                    <p class="description"><?php esc_html_e( 'Select Slideshow.','snshadona' ); ?></p>
                </td>
            </tr>
            
            <tr class="form-field snshadona_product_cat_layout">
                <th scope="row"><label for="snshadona_product_cat_layout"><?php esc_html_e( 'Layout', 'snshadona' ); ?></label></th>
                <td>
                    <select name="snshadona_product_cat_layout" id="snshadona_product_cat_layout">
                        <option value="" <?php selected($snshadona_product_cat_layout, '', true)?>><?php esc_html_e('Default (Layout of Shop page)', 'snshadona');?></option>
                        <option value="m" <?php selected($snshadona_product_cat_layout, 'm', true)?>><?php esc_html_e('Fullwidth', 'snshadona');?></option>
                        <option value="l-m" <?php selected($snshadona_product_cat_layout, 'l-m', true)?>><?php esc_html_e('Left Sidebar', 'snshadona');?></option>
                        <option value="m-r" <?php selected($snshadona_product_cat_layout, 'm-r', true)?>><?php esc_html_e('Right Sidebar', 'snshadona');?></option>
                    </select>
                    
                    <p class="description"><?php esc_html_e( 'Set the layout fullwidth or has sidebar (Woo Sidebar).','snshadona' ); ?></p>
                </td>
            </tr>

            <tr class="form-field snshadona_product_cat_grid_col">
                <th scope="row"><label for="snshadona_product_cat_grid_col"><?php esc_html_e( 'Grid columns', 'snshadona' ); ?></label></th>
                <td>
                    <select name="snshadona_product_cat_grid_col" id="snshadona_product_cat_grid_col">
                        <option value="" <?php selected($snshadona_product_cat_grid_col, '', true)?>><?php esc_html_e('Default', 'snshadona');?></option>
                        <option value="1" <?php selected($snshadona_product_cat_grid_col, '1', true)?>>1</option>
                        <option value="2" <?php selected($snshadona_product_cat_grid_col, '2', true)?>>2</option>
                        <option value="3" <?php selected($snshadona_product_cat_grid_col, '3', true)?>>3</option>
                        <option value="4" <?php selected($snshadona_product_cat_grid_col, '4', true)?>>4</option>
                        <option value="5" <?php selected($snshadona_product_cat_grid_col, '5', true)?>>5</option>
                        <option value="6" <?php selected($snshadona_product_cat_grid_col, '6', true)?>>6</option>
                    </select>
                    
                    <p class="description"><?php esc_html_e( 'We are using grid bootstap - 12 cols layout. Default use in Theme Options.','snshadona' ); ?></p>
                </td>
            </tr>
             <tr class="form-field snshadona_number_perpage">
                <th scope="row"><label for="snshadona_number_perpage"><?php esc_html_e( 'Number products per listing page', 'snshadona' ); ?></label></th>
                <td>
                    <input name="snshadona_number_perpage" id="snshadona_number_perpage" type="text" value="<?php echo $snshadona_number_perpage;?>" size="40">
                </td>
            </tr>
             <tr class="form-field snshadona_woo_onsale_layout">
                <th scope="row"><label for="snshadona_woo_onsale_layout"><?php esc_html_e( 'On Sale Products', 'snshadona' ); ?></label></th>
                <td>
                    <select name="snshadona_woo_onsale_layout" id="snshadona_product_cat_layout">
                        <option value="carousel" <?php selected($snshadona_woo_onsale_layout, 'carousel', true)?>><?php esc_html_e('Carousel', 'snshadona');?></option>
                        <option value="list" <?php selected($snshadona_woo_onsale_layout, 'list', true)?>><?php esc_html_e('List', 'snshadona');?></option>
                    </select>
                    
                    <p class="description"><?php esc_html_e( 'Slect layout for On Sale Products shown in this category.','snshadona' ); ?></p>
                </td>
            </tr>

            <tr class="form-field snshadona_woo_onsale_limit">
                <th scope="row"><label for="snshadona_woo_onsale_limit"><?php esc_html_e( 'On Sale Limit', 'snshadona' ); ?></label></th>
                <td>
                    <input name="snshadona_woo_onsale_limit" id="snshadona_woo_onsale_limit" type="text" value="<?php echo $snshadona_woo_onsale_limit;?>" size="40">
                    <p class="description"><?php esc_html_e( 'Number of On Sale Products to query.','snshadona' ); ?></p>
                </td>
            </tr>
            <?php
        }
        // Save term page
        public function snshadona_save_product_cat_custom_meta($term_id, $tt_id, $taxonomy){
            $fields = array(
                'snshadona_product_cat_slideshow',
                'snshadona_product_cat_layout',
                'snshadona_product_cat_grid_col',
                'snshadona_number_perpage',
                'snshadona_woo_onsale_layout',
                'snshadona_woo_onsale_limit'
            );
            
            foreach ($fields as $field){
                if( isset($_POST[$field]) ){
                    $value = !empty($_POST[$field]) ? $_POST[$field] : '';
                    
                    update_woocommerce_term_meta($term_id, $field, $value);
                }
            }
        }

        /*
        *   Add term page for product_attribute
        */
        public function snshadona_product_attribute_add_new_meta_field(){
            // This will add the custom meta field  to the add new term page
            ?>
            <div class="form-field term-snshadona_product_attribute_type">
                <label for="snshadona_product_attribute_type"><?php esc_html_e( 'Type', 'snshadona' ); ?></label>
                <select name="snshadona_product_attribute_type" id="snshadona_product_attribute_type">
                    <option value="text"><?php esc_html_e('Text', 'snshadona');?></option>
                    <option value="color"><?php esc_html_e('Color Picker', 'snshadona');?></option>
                    <option value="image"><?php esc_html_e('Color Image', 'snshadona');?></option>
                </select>
                <p class="description"></p>
            </div>

            <div class="form-field term-snshadona_product_attribute_color">
                <label for="snshadona_product_attribute_color"><?php esc_html_e( 'Color Picker', 'snshadona' ); ?></label>
                <input type="text" class="colorpicker sns-colorpicker" value="" name="snshadona_product_attribute_color"/>
                <p class="description"></p>
            </div>
            
            <div class="form-field term-snshadona_product_attribute_image">
                <label for="snshadona_product_attribute_image"><?php esc_html_e('Color Image', 'snshadona'); ?></label>
                <div id="snshadona_product_attribute_image" style="float: left; margin-right: 10px;">
                    <img src="<?php echo wc_placeholder_img_src(); ?>" width="60px" height="60px">
                </div>
                <div style="line-height: 60px;">
                    <input type="hidden" id="snshadona_product_attribute_image_id" name="snshadona_product_attribute_image_id">
                    <button type="button" class="snscustom_upload_image_button button"><?php esc_html_e('Upload/Add image', 'snshadona'); ?></button>
                    <button type="button" class="snscustom_remove_image_button button" style="display: none;"><?php esc_html_e('Remove image', 'snshadona'); ?></button>
                </div>
                <script type="text/javascript">
    
                    // Only show the "remove image" button when needed
                    if ( ! jQuery( '#snshadona_product_attribute_image' ).val() ) {
                        jQuery( '.snscustom_remove_image_button' ).hide();
                    }
    
                    // Uploading files
                    var snscustom_file_frame;
    
                    jQuery( document ).on( 'click', '.snscustom_upload_image_button', function( event ) {
    
                        event.preventDefault();
    
                        // If the media frame already exists, reopen it.
                        if ( snscustom_file_frame ) {
                            snscustom_file_frame.open();
                            return;
                        }
    
                        // Create the media frame.
                        snscustom_file_frame = wp.media.frames.downloadable_file = wp.media({
                            title: 'Choose an image',
                            button: {
                                text: 'Use image'
                            },
                            multiple: false
                        });
    
                        // When an image is selected, run a callback.
                        snscustom_file_frame.on( 'select', function() {
                            var attachment = snscustom_file_frame.state().get( 'selection' ).first().toJSON();
    
                            jQuery( '#snshadona_product_attribute_image_id' ).val( attachment.id );
                            jQuery( '#snshadona_product_attribute_image' ).find( 'img' ).attr( 'src', attachment.sizes.thumbnail.url );
                            jQuery( '.snscustom_remove_image_button' ).show();
                        });
    
                        // Finally, open the modal.
                        snscustom_file_frame.open();
                    });
    
                    jQuery( document ).on( 'click', '.snscustom_remove_image_button', function() {
                        var $wc_placeholder_img_src = '<?php echo wc_placeholder_img_src(); ?>';
                        jQuery( '#snshadona_product_attribute_image' ).find( 'img' ).attr( 'src', $wc_placeholder_img_src );
                        jQuery( '#snshadona_product_attribute_image_id' ).val( '' );
                        jQuery( '.snscustom_remove_image_button' ).hide();
                        return false;
                    });
    
                </script>
                <div class="clear"></div>
                <p class="description"></p>
            </div>
            <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery('select[id="snshadona_product_attribute_type"]').each(function(){
                    var $thisSelected = jQuery(this).val();
                    if( $thisSelected == 'color' ){
                        jQuery('.term-snshadona_product_attribute_color').stop(true, true).fadeIn(100);
                        jQuery('.term-snshadona_product_attribute_image').stop(true, true).fadeOut(0);
                    }else if( $thisSelected == 'image' ){
                        jQuery('.term-snshadona_product_attribute_image').stop(true, true).fadeIn(100);
                        jQuery('.term-snshadona_product_attribute_color').stop(true, true).fadeOut(0);
                    }else{
                        jQuery('.term-snshadona_product_attribute_color').stop(true, true).fadeOut(0);
                        jQuery('.term-snshadona_product_attribute_image').stop(true, true).fadeOut(0);
                    }

                    jQuery(this).on('change', function(){
                        if( this.value == 'color' ){
                            jQuery('.term-snshadona_product_attribute_color').stop(true, true).fadeIn(100);
                            jQuery('.term-snshadona_product_attribute_image').stop(true, true).fadeOut(0);
                        }else if( this.value == 'image' ){
                            jQuery('.term-snshadona_product_attribute_image').stop(true, true).fadeIn(100);
                            jQuery('.term-snshadona_product_attribute_color').stop(true, true).fadeOut(0);
                        }else{
                            jQuery('.term-snshadona_product_attribute_color').stop(true, true).fadeOut(0);
                            jQuery('.term-snshadona_product_attribute_image').stop(true, true).fadeOut(0);
                        }
                    });
                });
            });
            </script>
            <?php
        }
        // Edit term page
        public function snshadona_product_attribute_edit_meta_field($term, $taxonomy){
            $snshadona_product_attribute_type = get_woocommerce_term_meta( $term->term_id, 'snshadona_product_attribute_type' );
            $snshadona_product_attribute_color = get_woocommerce_term_meta( $term->term_id, 'snshadona_product_attribute_color' );
            $snshadona_product_attribute_image_id = get_woocommerce_term_meta( $term->term_id, 'snshadona_product_attribute_image_id' );
            $image_src = wc_placeholder_img_src(); // WC Thumbnail default
            if($snshadona_product_attribute_image_id !==''){
                $image_src = wp_get_attachment_image_src($snshadona_product_attribute_image_id);
                $image_src = $image_src[0];
            }
            ?>
            
            <tr class="form-field snshadona_product_attribute_type">
                <th scope="row"><label for="snshadona_product_attribute_type"><?php esc_html_e( 'Type', 'snshadona' ); ?></label></th>
                <td>
                    <select name="snshadona_product_attribute_type" id="snshadona_product_attribute_type">
                        <option value="text" <?php selected($snshadona_product_attribute_type, 'text', true)?>><?php esc_html_e('Text', 'snshadona');?></option>
                        <option value="color" <?php selected($snshadona_product_attribute_type, 'color', true)?>><?php esc_html_e('Color Picker', 'snshadona');?></option>
                        <option value="image" <?php selected($snshadona_product_attribute_type, 'image', true)?>><?php esc_html_e('Color Image', 'snshadona');?></option>
                    </select>
                    
                    <p class="description"></p>
                </td>
            </tr>

            <tr class="form-field term-snshadona_product_attribute_color">
                <th scope="row"><label for="snshadona_product_attribute_color"><?php esc_html_e( 'Color Picker', 'snshadona' ); ?></label></th>
                <td>
                    <input type="text" class="colorpicker sns-colorpicker" value="<?php echo esc_attr( $snshadona_product_attribute_color );?>" name="snshadona_product_attribute_color"/>
                    <p class="description"></p>
                </td>
            </tr>

            <tr class="form-field term-snshadona_product_attribute_image">
                <th scope="row" valign="top">
                    <label for="snshadona_product_attribute_image"><?php esc_html_e('Color Image', 'snshadona'); ?></label>
                </th>
                <td>
                    <div id="snshadona_product_attribute_image" style="float: left; margin-right: 10px;">
                        <img src="<?php echo esc_attr( $image_src ) ?>" width="60px" height="60px">
                    </div>
                    <div style="line-height: 60px;">
                        <input type="hidden" id="snshadona_product_attribute_image_id" name="snshadona_product_attribute_image_id" value="<?php echo (int)$snshadona_product_attribute_image_id; ?>">
                        <button type="button" class="snscustom_upload_image_button button"><?php esc_html_e('Upload/Add image', 'snshadona'); ?></button>
                        <button type="button" class="snscustom_remove_image_button button"><?php esc_html_e('Remove image', 'snshadona'); ?></button>
                    </div>
                    <script type="text/javascript">
                        
                        // Only show the "remove image" button when needed
                        if ( '0' === jQuery( '#snshadona_product_attribute_image_id' ).val() ) {
                            jQuery( '.snscustom_remove_image_button' ).hide();
                        }
    
                        // Uploading files
                        var snscustom_file_frame;
    
                        jQuery( document ).on( 'click', '.snscustom_upload_image_button', function( event ) {
    
                            event.preventDefault();
    
                            // If the media frame already exists, reopen it.
                            if ( snscustom_file_frame ) {
                                snscustom_file_frame.open();
                                return;
                            }
    
                            // Create the media frame.
                            snscustom_file_frame = wp.media.frames.downloadable_file = wp.media({
                                title: 'Choose an image',
                                button: {
                                    text: 'Use image'
                                },
                                multiple: false
                            });
    
                            // When an image is selected, run a callback.
                            snscustom_file_frame.on( 'select', function() {
                                var attachment = snscustom_file_frame.state().get( 'selection' ).first().toJSON();
                                jQuery( '#snshadona_product_attribute_image_id' ).val( attachment.id );
                                jQuery( '#snshadona_product_attribute_image' ).find( 'img' ).attr( 'src', attachment.sizes.thumbnail.url );
                                jQuery( '.snscustom_remove_image_button' ).show();
                            });
    
                            // Finally, open the modal.
                            snscustom_file_frame.open();
                        });
    
                        jQuery( document ).on( 'click', '.snscustom_remove_image_button', function() {
                            var $wc_placeholder_img_src = '<?php echo wc_placeholder_img_src(); ?>';
                            jQuery( '#snshadona_product_attribute_image' ).find( 'img' ).attr( 'src', $wc_placeholder_img_src );
                            jQuery( '#snshadona_product_attribute_image_id' ).val( '' );
                            jQuery( '.snscustom_remove_image_button' ).hide();
                            return false;
                        });
        
                    </script>
                    <div class="clear"></div>
                    <p class="description"></p>
                </td>
            </tr>
            <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery('select[id="snshadona_product_attribute_type"]').each(function(){
                    var $thisSelected = jQuery(this).val();
                    if( $thisSelected == 'color' ){
                        jQuery('.term-snshadona_product_attribute_color').stop(true, true).fadeIn(100);
                        jQuery('.term-snshadona_product_attribute_image').stop(true, true).fadeOut(0);
                    }else if( $thisSelected == 'image' ){
                        jQuery('.term-snshadona_product_attribute_image').stop(true, true).fadeIn(100);
                        jQuery('.term-snshadona_product_attribute_color').stop(true, true).fadeOut(0);
                    }else{
                        jQuery('.term-snshadona_product_attribute_color').stop(true, true).fadeOut(0);
                        jQuery('.term-snshadona_product_attribute_image').stop(true, true).fadeOut(0);
                    }

                    jQuery(this).on('change', function(){
                        if( this.value == 'color' ){
                            jQuery('.term-snshadona_product_attribute_color').stop(true, true).fadeIn(100);
                            jQuery('.term-snshadona_product_attribute_image').stop(true, true).fadeOut(0);
                        }else if( this.value == 'image' ){
                            jQuery('.term-snshadona_product_attribute_image').stop(true, true).fadeIn(100);
                            jQuery('.term-snshadona_product_attribute_color').stop(true, true).fadeOut(0);
                        }else{
                            jQuery('.term-snshadona_product_attribute_color').stop(true, true).fadeOut(0);
                            jQuery('.term-snshadona_product_attribute_image').stop(true, true).fadeOut(0);
                        }
                    });
                });
            });
            </script>
            <?php
        }
        // Save term page
        public function snshadona_product_attribute_save_custom_meta($term_id, $tt_id, $taxonomy){
            $fields = array(
                'snshadona_product_attribute_type',
                'snshadona_product_attribute_color',
                'snshadona_product_attribute_image_id'
            );
            
            foreach ($fields as $field){
                if( isset($_POST[$field]) ){
                    $value = !empty($_POST[$field]) ? $_POST[$field] : '';
                    
                    update_woocommerce_term_meta($term_id, $field, $value);
                }
            }
        }
		
	}

	snshadona_Woocommerce::getInstance();
    function snshadona_cart_url(){
        global $woocommerce;
        return esc_url( $woocommerce->cart->get_cart_url() );
    }
    function snshadona_cart_total(){
        global $woocommerce;
        return $woocommerce->cart->get_cart_total();
    }
    // Re-render rating
    add_filter( 'woocommerce_product_get_rating_html', 'snshadona_get_rating_html', 100, 2 );
    function snshadona_get_rating_html(){
        global $woocommerce, $product;
        if( $product && $product->get_average_rating() ) $rating = $product->get_average_rating();
        if( isset($rating) && $rating > 0){
        	$rating_html  = '<div class="star-rating" title="' . sprintf( esc_html__( 'Rated %s out of 5', 'snshadona' ), $rating ) . '">';
    		$rating_html .= '<span class="value" data-width="' . ( ( $rating / 5 ) * 100 ) . '%"><strong class="rating">' . $rating . '</strong> ' . esc_html__( 'out of 5', 'snshadona' ) . '</span>';
        }else{
        	$rating_html  = '<div class="star-rating">';
        }
    	$rating_html .= '</div>';
    	return $rating_html;
    }

    // Set template view mode
    function snshadona_woo_modeview() {
    	global $snshadona_opt;
    	wc_get_template( 'loop/modeview.php', array('modeview' => $snshadona_opt['woo_list_modeview']) );
    }
    // Override quickview
    function snshadona_woo_images_quickview() {
    	wc_get_template( 'single-product/product-image-quickview.php' );
    }

    function snshadona_woo_query($type, $post_per_page=-1, $cat='', $offset=0, $paged=1){
        global $woocommerce;
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $post_per_page,
            'post_status' => 'publish',
        	'offset'            => $offset,
            'paged' => $paged
        );
        switch ($type) {
            case 'best_selling':
                $args['meta_key']='total_sales';
                $args['orderby']='meta_value_num';
                $args['ignore_sticky_posts']   = 1;
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                break;
            case 'featured_product':
                $args['ignore_sticky_posts']=1;
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $args['meta_query'][] = array(
                             'key' => '_featured',
                             'value' => 'yes'
                         );
                $query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                break;
            case 'top_rate':
                add_filter( 'posts_clauses',  array( $woocommerce->query, 'order_by_rating_post_clauses' ) );
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                break;
            case 'recent':
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                break;
            case 'on_sale':
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                $args['post__in'] = wc_get_product_ids_on_sale();
                break;
            case 'recent_review':
                if($post_per_page == -1) $_limit = 4;
                else $_limit = $post_per_page;
                global $wpdb;
                $query = $wpdb->prepare( "
                    SELECT c.comment_post_ID 
                    FROM {$wpdb->prefix}posts p, {$wpdb->prefix}comments c 
                    WHERE p.ID = c.comment_post_ID AND c.comment_approved > %d 
                    AND p.post_type = %s AND p.post_status = %s
                    AND p.comment_count > %d ORDER BY c.comment_date ASC" ,
                    0, 'product', 'publish', 0 );
                $results = $wpdb->get_results($query, OBJECT);
                $_pids = array();
                foreach ($results as $re) {
                    if(!in_array($re->comment_post_ID, $_pids))
                        $_pids[] = $re->comment_post_ID;
                    if(count($_pids) == $_limit)
                        break;
                }

                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                $args['post__in'] = $_pids;
                break;
        }

        if($cat!=''){
            $args['product_cat']= $cat;
        }
        return new WP_Query($args);
    }
    add_action('woocommerce_single_product_summary', 'snshadona_woo_countdown', 12);
    function snshadona_woo_countdown(){ 
       // Get the Sale Price Date To of the product

        $sale_price_dates_to    = ( $date = get_post_meta( get_the_ID(), '_sale_price_dates_to', true ) ) ? date_i18n( 'Y/m/d', $date ) : '';      
        if(!empty($sale_price_dates_to)):
        wp_enqueue_script('countdown');
        ?>
        
        <div class="item-slider-countdown">
            <p><?php esc_html_e('Countdown time discount', 'snshadona');?></p>
            <div class="sns_sale_clock">
                <div><span class="day"></span><?php esc_html_e('D:', 'snshadona');?></div>
                <div><span class="hours"></span><?php esc_html_e('H:', 'snshadona');?></div>
                <div><span class="minutes"></span><?php esc_html_e('M:', 'snshadona');?></div>
                <div><span class="seconds"></span><?php esc_html_e('S', 'snshadona');?></div>
            </div>
            <script type="text/javascript">
                jQuery(document).ready(function($){
                    $('#product-<?php the_ID(); ?> .sns_sale_clock').countdown('<?php echo $sale_price_dates_to; ?>', function(event){
                        $(this).find('.day').html(event.strftime('%D'));
                        $(this).find('.hours').html(event.strftime('%H'));
                        $(this).find('.minutes').html(event.strftime('%M'));
                        $(this).find('.seconds').html(event.strftime('%S'));
                    });
                });

            </script>
        </div>
        <?php endif;  
    }
    //
    add_action('woocommerce_single_product_summary', 'snshadona_woo_addthis', 22);
    function snshadona_woo_addthis(){
        global $snshadona_opt;
        $html = '';
        if ( $snshadona_opt['woo_sharebox'] == 1 ) {
            $html .= '
            <div class="addthis_toolbox addthis_default_style ">
            <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
            <a class="addthis_button_tweet"></a>
            <a class="addthis_button_pinterest_pinit" pi:pinit:layout="horizontal"></a>
            <a class="addthis_counter addthis_pill_style"></a>
            </div>
            <script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-507b2455057cfd5f"></script>
            ';
        }
        echo wp_kses($html, array(
                                'div' => array(
                                    'class' => array(),
                                ),
                                'a' => array(
                                    'href' => array(),
                                    'class' => array(),
                                    'fb:like:layout' => array()
                                ),
                                'script' => array(
                                    'type' => array(),
                                    'src' => array()
                                ),
                            ) );
    }

    //
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
    add_action('woocommerce_after_single_product_summary', 'snshadona_relatedproducts', 20);
    function snshadona_relatedproducts() {
        global $snshadona_opt;
        if ( $snshadona_opt['woo_related'] == '1' ) {
            $args = array(
                'posts_per_page' => $snshadona_opt['woo_related_num'],
                'orderby' => 'rand'
            );
            woocommerce_related_products( apply_filters( 'woocommerce_output_related_products_args', $args ) );
        }else{
            return;
        }
    }
  //  add_action( 'woocommerce_archive_description', 'snshadona_woo_category_image', 2 );
    function snshadona_woo_category_image() {
        if ( is_product_category() ){
            global $wp_query;
            $cat = $wp_query->get_queried_object();
           
            $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
            
            $image = wp_get_attachment_image_src($thumbnail_id, 'full');
            $image = isset($image[0]) ? $image[0] : '';
            if ( $image ) {
                echo '<p class="cate-img"><img src="' . esc_url($image) . '" alt="" /></p>';
            }
        }
    }

    // Override thumbnail
    function snshadona_post_thumbnail_html($html, $post_id, $post_thumbnail_id, $size, $attr) {
        if(snshadona_themeoption('woo_uselazyload') == 1){
            $id = get_post_thumbnail_id();
            $src = wp_get_attachment_image_src($id, $size);
            $alt = get_the_title($id);
            $class = ( isset($attr['class']) ) ? $attr['class'] : '';
            if (strpos($class, 'lazy') !== false) {
                $html = '<img src="'.SNSHADONA_THEME_URI.'/assets/img/prod_loading.gif" alt="'.$alt.'" data-original="' . $src[0] . '" class="' . $class . '" />';
            }
        }
        return $html;
    }
    add_filter('post_thumbnail_html', 'snshadona_post_thumbnail_html', 99, 5);
    function snshadona_product_thumbnail(){
        global $post;
        $size = 'shop_catalog';
        if ( has_post_thumbnail() ) {
            if( snshadona_themeoption('woo_uselazyload') == 1 ){
                echo get_the_post_thumbnail( $post->ID, $size, array('class' => "lazy attachment-$size") );
            }else{
                echo get_the_post_thumbnail( $post->ID, $size );
            }
        } elseif ( wc_placeholder_img_src() ) {
            echo wc_placeholder_img( $size );
        }
    }
    
    function snshadona_get_woocommerce_categories(){
    	$args = array(
    		'taxonomy' => 'product_cat'
    	);
    	 return get_categories($args);
    }
   
    add_action( 'sns_after_shop_loop', 'woo_onsale_layout', 10 );
    function woo_onsale_layout(){
        $woo_onsale_layout  = snshadona_themeoption('woo_onsale_layout', 'carousel');
        $woo_onsale_limit   = snshadona_themeoption('woo_onsale_limit', '5');

        if(is_product_category()){
            $cate = get_queried_object();
            $woo_onsale_layout = get_woocommerce_term_meta($cate->term_id, 'snshadona_woo_onsale_layout');
            $woo_onsale_limit = get_woocommerce_term_meta($cate->term_id, 'snshadona_woo_onsale_limit');

        }

        $on_sale_p = snshadona_woo_query('on_sale', $woo_onsale_limit);
        
        if($on_sale_p->have_posts()):?>
            <div id="sns-listing-onsale-product" class="sns-listing-onsale-product sns-products-list pre-load template-<?php echo esc_attr( $woo_onsale_layout ); ?>">
                <h2 class="wpb_heading">
                    <span><?php echo esc_html__( 'Promotion products', 'snshadona' );?></span>
                </h2>
                <div class="navslider"><span class="prev"></span><span class="next"></span></div>
                <div class="sns-listing-onsale-content">
                    <?php
                    if( $woo_onsale_layout == 'carousel' ):
                        wc_get_template( 'vc/carousel.php', array('loop' => $on_sale_p, 'number_display' => 5, 'number_display_1200' => 5, 'number_display_992' => 4, 'number_display_768' => 3, 'number_display_480' => 2, 'row' => '1', 'id' => 'sns-listing-onsale-product', 'show_countdown' => '') );
                    elseif ( $woo_onsale_layout == 'list' ):
                        while ( $on_sale_p->have_posts() ) : $on_sale_p->the_post();
                                wc_get_template( 'vc/item-grid.php');
                        endwhile;
                    endif;
                    ?>
                </div>
            </div>
        <?php
        endif;

        wp_reset_postdata();
    }

    add_action( 'sns_after_shop_loop', 'woo_custom_block', 11 );
    function woo_custom_block(){
        $woo_onsale_layout = snshadona_themeoption('woo_onsale_layout', 'carousel');

        if(is_product_category()){
            $cate = get_queried_object();
            $woo_onsale_layout = get_woocommerce_term_meta($cate->term_id, 'snshadona_woo_onsale_layout');
            $woo_onsale_limit = get_woocommerce_term_meta($cate->term_id, 'snshadona_woo_onsale_limit');
        }
        if($woo_onsale_layout == 'list'):
            $woo_custom_block   = snshadona_themeoption('woo_custom_block', '');
            ?>
            <div class="woo-custom-block">
                <h2 class="wpb_heading">
                    <span><?php echo apply_filters( 'sns_woo_custom_block_title', esc_html__( 'Custom block', 'snshadona' ) );?></span>
                </h2>
                <div class="woo-custom-block-content">
                    <?php echo $woo_custom_block; ?>
                </div>
            </div>
            <?php
        endif;
    }

    add_action( 'woocommerce_archive_description', 'sns_product_category_description', 11 );
    function sns_product_category_description(){
        if(is_product_category()){
            $cate = get_queried_object();
            $snshadona_product_cat_slideshow = get_woocommerce_term_meta( $cate->term_id, 'snshadona_product_cat_slideshow' );
            if( !empty($snshadona_product_cat_slideshow) ): ?>
                <div class="sns_product_category_slideshow" class="wrap">
                    <?php
                        echo do_shortcode('[rev_slider '.esc_attr($snshadona_product_cat_slideshow).' ]');
                    ?>
                </div>
            <?php
            endif;
        }
    }
}

?>