<?php
class snshadona_Megamenu_Front extends Walker_Nav_Menu { 
    var $columns = 0;
    var $enablemega = 0;
    var $stylemega = '';
    var $sidebaremega = '';
    var $bgmegacol = '';
    var $customcolumnstyle = '';

    function start_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
       
        $uq = rand(1, 1000);
        
        if($depth === 0 && $this->enablemega && $this->stylemega !=''){
            $menu_top_heading = '';
            $preview_content_div = '';
            $style_inline = '';
            $class = '';
            
            if($this->sidebaremega == 'menu_sidebar_1'){
                $top_sidebar_content = '';
                if (is_active_sidebar('menu_sidebar_1')){
                    ob_start();
                    dynamic_sidebar('menu_sidebar_1');
                    $top_sidebar_content    .= ob_get_clean();
                }
                
                $menu_top_heading .= '<div class="menu-top-sidebar">'.$top_sidebar_content.'</div>';
            }
            
            if($this->stylemega == 'preview'){
                $preview_content_div = '<div class="preview_content">';
            }

            // Background image for Columns tyle
            if($this->stylemega == 'columns' && $this->bgmegacol != ''){
                $style_inline = 'style="background-image: url('.esc_url($this->bgmegacol).'); '. trim($this->customcolumnstyle) .'"';
                $class = ' sub-content-background';
            }

            $output .= "\n$indent<div id=\"sub_content_$uq\" class=\"sub-content dropdownmenu $this->stylemega $class\" $style_inline>$menu_top_heading $preview_content_div <ul class=\"". $this->stylemega ." {replace_class}\">\n";
        }else{
            $output .= "\n$indent<ul class=\"sub-menu {replace_class}\">\n";
        }
       
    }
    function end_lvl(&$output, $depth = 0, $args = array()) { 
        $indent = str_repeat("\t", $depth);
        // add menu sidebar
        if($depth === 0 && $this->enablemega && $this->stylemega !=''){
                $preview_content = '';
                if($this->stylemega == 'preview'){
                    ob_start();
                    ?>

                        <div class="menu-preview-mode-wrap">
                            <h3 class="menu-top-heading"><?php echo esc_html__( 'on sale', 'snshadona' ); ?></h3>
                            <div class="menu-preview-mode-content">
                                <div class="navslider"><span class="prev"><i class="arrow_carrot-left"></i></span><span class="next"><i class="arrow_carrot-right"></i></span></div>
                                <div class="ul-products"></div>
                            </div>
                        </div>
                    </div> <!-- /.preview_content -->
                    <?php
                    $preview_content .= ob_get_clean();
                }

                if ($this->sidebaremega == 'menu_sidebar_2'){ // Menu Sidebar #2
                    $right_sidebar_content = '';
                        ob_start();
                        dynamic_sidebar('menu_sidebar_2');
                        $right_sidebar_content  .= ob_get_clean();
                    
                    $bottom_sidebar = '<div id="right-menu-item-sidebar">'.$right_sidebar_content.'</div>';
                    $output .= "$indent</ul>$preview_content $bottom_sidebar</div>\n";

                }
                else{
                    $output .= "$indent</ul>$preview_content</div>\n";
                }
        }
        else{
            $output .= "$indent</ul>\n";
        }
      
        if ($depth === 0) {
            if($this->enablemega && $this->columns > 0){
                if($this->sidebaremega == 'menu_sidebar_2') $this->columns = $this->columns + 1; // Add a column for Right Sidebar Menu
                $output = str_replace("{replace_class}", "enable-megamenu row-fluid col-".$this->columns."", $output);
                $this->columns = 0;
            }
            else{
                $output = str_replace("{replace_class}", "", $output);
            }
        }
    }    
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        global $wp_query;
        $item_output = $li_text_block_class = $column_class = "";
        if($depth === 0){   
            $this->enablemega = get_post_meta( $item->ID, '_sns_megamenu_item_enable', true);
            $this->stylemega = get_post_meta( $item->ID, '_sns_megamenu_item_style', true);
            $this->sidebaremega = get_post_meta( $item->ID, '_sns_megamenu_item_sidebar', true);
            $this->bgmegacol = get_post_meta( $item->ID, '_sns_megamenu_item_background', true);
            $this->customcolumnstyle = get_post_meta( $item->ID, '_sns_megamenu_item_customcolumnstyle', true);
        }
        if($depth === 1 && $this->enablemega) {
            $this->columns ++;
            if( $item->hidetitlemega != true && $this->stylemega == 'columns'){
                 $title = apply_filters( 'the_title', $item->title, $item->ID );
                if($title != "-" && $title != '"-"'){
                   
                   $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
                   $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
                   $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
                   $attributes .= ! empty( $item->url )        ? ' href="'   . esc_url( $item->url        ) .'"' : '';    
            
                   $item_output .= $args->before;
                   $item_output .= '<h4 class="megamenu-title">';
                   $item_output .= '<a'. $attributes .'>';
                   $item_output .= (get_post_meta( $item->ID, '_sns_megamenu_item_icon', true) != '')?'<img class="sns-megamenu-icon-img" src="'.get_post_meta( $item->ID, '_sns_megamenu_item_icon', true).'" alt=""/>':'';
                   $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
                   $item_output .= '</a></h4>';
                   $item_output .= $args->after;
               }
            }
            if( $this->stylemega == 'preview' ){ // Must be type Product categories and Product Tags
                
                $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
                $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
                $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
                $attributes .= ! empty( $item->url )        ? ' href="'   . esc_url( $item->url        ) .'"' : '';
                
                $description = $item->description;
                //$item_output .= '<pre>'.$item.'</pre>';
                
                $item_output .= $args->before;
                $item_output .= '<div class="item-preview">';
                $item_output .= '<a href="#" data-type="'.$item->object.'" data-term="'.$item->object_id.'" data-posts-per-page="10">';
                $item_output .= (get_post_meta( $item->ID, '_sns_megamenu_item_icon', true) != '')?'<img class="sns-megamenu-icon-img" src="'.get_post_meta( $item->ID, '_sns_megamenu_item_icon', true).'" alt=""/>':'';
                $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
                $item_output .= '</a>';
                $item_output .= '</div>';
                $item_output .= $args->after;
            }
        }else{
            $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
            $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
            $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
            $attributes .= ! empty( $item->url )        ? ' href="'   . esc_url( $item->url        ) .'"' : '';            
        
            $item_output .= $args->before;
            $item_output .= '<a'. $attributes .'>';
            $item_output .= (get_post_meta( $item->ID, '_sns_megamenu_item_icon', true) != '')?'<img class="sns-megamenu-icon-img" src="'.get_post_meta( $item->ID, '_sns_megamenu_item_icon', true).'" alt=""/>':'';
            $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;
        }
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
        if( $depth == 0 && $this->enablemega && $this->stylemega !='') $class_names .= ' enable-mega';
        if ( get_post_meta( $item->ID, '_sns_megamenu_item_icon', true) != '' ) $class_names .= ' have-icon';
        $class_names = ' class="'.$li_text_block_class. esc_attr( $class_names ) . $column_class.'"';
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
        $output .= $indent . '<li '.$id . $value . $class_names .'>'; 
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
    
    /*
     * Method to get content preview mode, must be type product categories and product tags
     */
    function content_preview($type, $item_id, $args){
        if( $type == '' ||  $item_id == ''){
            return;
        }
        $html = '';
        switch ($type){
            case 'product_cat':
                $thumbnail_id = get_woocommerce_term_meta($item_id, 'thumbnail_id', true);
                
                $cat_thumbnail = wp_get_attachment_image_src($thumbnail_id, 'snshadona_megamenu_thumb');
                $image = isset($cat_thumbnail[0]) ? $cat_thumbnail[0] : wc_placeholder_img_src();
                
                $html = '<img src="'.$image.'" alt=""/>';
                break;
            default: 
                break;
        }
        
        return $html;
    }
    
}
?>