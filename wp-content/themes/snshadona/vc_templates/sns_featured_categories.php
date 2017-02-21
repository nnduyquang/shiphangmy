<?php
    $output = '';
    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );
    $tab_titles = $this->snshadona_getListTabTitle();
    $uq = rand().time();
    $extra_class = esc_attr($extra_class) ? 'sns_featured_categories '.esc_attr($extra_class) : 'sns_featured_categories';
?>

<?php
$output .= '<div id="sns_featured_categories-'.esc_attr($uq).'" class="'.$extra_class.'">';
    $i = 0;
    if($title !=''){
        $output .= '<h2 class="wpb_heading"><span>'.$title.'</span></h2>'; 
    }
     $output .= '<div class="content">'; 
        foreach ($tab_titles as $tab) { 
            $i++;
            $output .='<div class="item">';
            $output .='<a class="image" href="'.esc_url(get_category_link($tab['id'])).'" title="'.esc_attr($tab['short_title']).'" >';
            $output .='<img src="'.esc_url($tab['thumbnail']).'" alt=""/>';  
            $output .='</a>';
            $output .='<div class="link">';
            $output .='<a class="title" href="'.esc_url(get_category_link($tab['id'])).'" title="'.esc_attr($tab['short_title']).'" >'.esc_html($tab['short_title']).'</a>';         
            $output .='</div>';
            $output .='</div>';    
        } 
    $output .= '</div>';

$output .= '</div>';
echo $output;
?>