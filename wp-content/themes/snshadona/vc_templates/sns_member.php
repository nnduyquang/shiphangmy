<?php

$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$extra_class = esc_attr($extra_class) ? 'sns-member '.esc_attr($extra_class) : 'sns-member';
$output .= '<div class="'.$extra_class.'">';
$begin_link = '';
if ( ! empty( $link ) ) {
	$link = vc_build_link( $link );
	$begin_link = '<a href="' . esc_url( $link['url'] ) . '"'
	               . ( $link['target'] ? ' target="' . esc_attr( $link['target'] ) . '"' : '' )
	               . ( $link['title'] ? ' title="' . esc_attr( $link['title'] ) . '"' : '' )
	               . '>';
}
if($avartar != ''){
	$avartar = preg_replace('/[^\d]/', '', $avartar);
	$img =   wp_get_attachment_image_src( $avartar , '');
	$img = '<img src="'.$img[0].'" alt="'.esc_attr($name).'" />';
	if ( $begin_link !='' ) {
		$img = $begin_link. $img . '</a>';
	}
	
	$avartar_class = ($avartar_style!='') ? 'avartar '.$avartar_style :'avartar';
	$output .= '<div class="'.$avartar_class.'">'.$img.'</div>';
}
if ($name != ''){
	if ( $begin_link !='' ) {
		$name = $begin_link. esc_attr($name) . '</a>';
	}
	$output .= '<h3 class="name">'.$name.'</h3>';
}
if ($role != ''){
	$output .= '<p class="role">'.'- '.esc_attr($role).'</p>';
}

if (trim(strip_tags($content)) != ''){
	$output .= '<div class="short_desc">'.$content.'</div>';
}
	$social = '<div class="social-icons"><ul>';
	if( $facebook != '') {
	 	$social .= '<li><a class="facebook" href="' . esc_url( $facebook ) . '" target="_blank" title="Facebook"></a></li>';
	}
	if( $twitter != '') {
	 	$social .= '<li><a class="twitter" href="' . esc_url( $twitter ) . '" target="_blank" title="twitter"></a></li>';
	}
	if( $google != '') {
	 	$social .= '<li><a class="google-plus" href="' . esc_url( $google ) . '" target="_blank" title="google plus"></a></li>';
	}
	if( $youtube != '') {
	 	$social .= '<li><a class="youtube" href="' . esc_url( $youtube ) . '" target="_blank" title="youtube"></a></li>';
	}
	if( $pinterest != '') {
	 	$social .= '<li><a class="pinterest" href="' . esc_url( $pinterest ) . '" target="_blank" title="pinterest"></a></li>';
	}	
	$social .= '</ul></div>';
	$output .= $social;
//}
$output .= '</div>';
echo $output;
