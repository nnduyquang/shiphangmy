<?php

$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$id = rand().time();

$extra_class = esc_attr($extra_class) ? 'sns-advance '.esc_attr($extra_class) : 'sns-advance';

// class for button
$class_button = '';
if($btn_size != ''){
	$class_button .= ' ' . $btn_size;
}
$class_content = '';
if($content_position != ''){
	$class_content .= ' ' . $content_position;
}


$output .= '<style scoped>';
// Sub heading
if ($sub_heading == 'true') 
$output .= '#sns-advance_'.$id.' .sub_heading_text{
				color:'.esc_attr($sub_heading_color).';
				font-size:'.esc_attr($sub_heading_font_size).';
				text-transform:'.esc_attr($sub_heading_text_transform).';
				font-weight:'.esc_attr($sub_heading_font_weight).';
			}';
// Heading
if ($heading == 'true') 
$output .= '#sns-advance_'.$id.' .heading_text{
				color:'.esc_attr($heading_color).';
				font-size:'.esc_attr($heading_font_size).';
				text-transform:'.esc_attr($heading_text_transform).';
				font-weight:'.esc_attr($heading_font_weight).';
				margin-bottom:'.esc_attr($margin_bottom).';
			}';

$output .= '#sns-advance_'.$id.' .heading_text span{
				color:'.esc_attr($first_letter_color).';
			}';
// Banner position
$output .= '#sns-advance_'.$id.'.left_middle{	
		   left: '.esc_attr($left).';		
			}';
if ($top1 != '')
$output .= '#sns-advance_'.$id.'.left_middle{	
		   top: '.esc_attr($top1).';
			}';
$output .= '#sns-advance_'.$id.'.center_middle{	
		   left: '.esc_attr($left).';		
			}';
if ($top1 != '')
$output .= '#sns-advance_'.$id.'.center_middle{	
		   top: '.esc_attr($top1).';
			}';
$output .= '#sns-advance_'.$id.'.center_top{	
		   top: '.esc_attr($top).';
			}';
if ($bottom != '')
$output .= '#sns-advance_'.$id.'.center_bottom{	
		   bottom: '.esc_attr($bottom).';
			}';
$output .= '#sns-advance_'.$id.' .decription{
			font-size:'.esc_attr($decription_font_size).';
			}';
if ($show_button1 != '') 
$output .= '#sns-advance_'.$id.' .button{
				background:'.esc_attr($btn_color).';
				border-color:'.esc_attr($btn_color).';
				color: '.esc_attr($btn_title_color).';
			}';
$output .= '#sns-advance_'.$id.' .button:hover{
				background:'.snshadona_brightness($btn_color, -50).';
				border-color: '.snshadona_brightness($btn_color, -50).';
				color: '.esc_attr($btn_title_color).';
			}';	
if ($show_button2 != '') 
$output .= '#sns-advance_'.$id.' .button2{
				background:'.esc_attr($btn_color_2).';
				border-color:'.esc_attr($btn_color_2).';
				color: '.esc_attr($btn_title_color_2).';
			}';
$output .= '#sns-advance_'.$id.' .button2:hover{
				background:'.snshadona_brightness($btn_color_2, -50).';
				border-color: '.snshadona_brightness($btn_color_2, -50).';
				color: '.esc_attr($btn_title_color_2).';
			}';			
$output .= '</style>';	
$output .= '<div class="'.$extra_class.'">';
$begin_link = '';
if ( ! empty( $link ) ) {
	$link = vc_build_link( $link );
	$begin_link = '<a class="adv-img '.$image_alignment.'" href="' . esc_url( $link['url'] ) . '"'
	               . ( $link['target'] ? ' target="' . esc_attr( $link['target'] ) . '"' : '' )
	               . ( $link['title'] ? ' title="' . esc_attr( $link['title'] ) . '"' : '' )
	               . '>';
}

if($image != ''){
	$image = preg_replace('/[^\d]/', '', $image);
	$img =   wp_get_attachment_image_src( $image , '');
	$img = '<img src="'.$img[0].'" alt="" />';
	if ( $begin_link !='' ) {
		$img = $begin_link. $img . '</a>';
	}
	$output .= $img;
}
$output .= '<div id="sns-advance_'.$id.'" class="sns-advance-banner banner_content '.esc_attr($class_content).' has-fist-letter-color">';
	if ($sub_heading == 'true' && $sub_heading_text != ''){
		$output .= '<h3 class="sub_heading_text">'.wp_kses($sub_heading_text, array(
										'span' => array(),
										'br' => array(),
									)).'</h3>';
	}

	if ($heading == 'true' && $heading_text != ''){
		$output .= '<h2 class="heading_text">';
		if($first_letter != ''){
			$aar = explode('<br />', $heading_text);
			$i = 0;
			foreach ($aar as $key => $value ) {	
				$a[$i]= $value;					
				if($i == 0){
					$first_heading_text = substr($value,0,1 );
					$last_heading_text = substr($value,1, strlen($value));
					$value = '<span>'.$first_heading_text.'</span>'.$last_heading_text;
				}
				else{
					$first_heading_text = substr($value,1,1 );
					$last_heading_text = substr($value,2, strlen($value));
					$value = '<span>'.$first_heading_text.'</span>'.$last_heading_text;	
					
				}
				$i++;
				$output .= $value.'<br>';
			}
		}
		else{
			$output .= $heading_text;
		}
		$output .= '</h2>';
	}
	if ($content != ''){
		$output .= '<div class="decription">'. $content.'</div>';
	}
	$output .= '<div class="link">';
	$begin_link_btn = '';
	if ( ! empty( $btn_link ) ) {
		$btn_link = vc_build_link( $btn_link );
		$begin_link_btn = '<a class="button '.esc_attr($class_button).'" href="' . esc_url( $btn_link['url'] ) . '"'
		               . ( $btn_link['target'] ? ' target="' . esc_attr( $btn_link['target'] ) . '"' : '' )
		               . ( $btn_link['title'] ? ' title="' . esc_attr( $btn_link['title'] ) . '"' : '' )
		               . '>';
	}
	if ($show_button1 == 'true' && $btn_title != ''){
		if ( $begin_link_btn !='' ) {
			$btn_title = $begin_link_btn. esc_attr($btn_title) .'</a>';		
		}
		$output .= $btn_title;
	}
	$begin_link_btn_2 = '';
	if ( ! empty( $btn_link_2 ) ) {
		$btn_link_2 = vc_build_link( $btn_link_2 );
		$begin_link_btn_2 = '<a class="button button2 '.esc_attr($class_button).'" href="' . esc_url( $btn_link_2['url'] ) . '"'
		               . ( $btn_link_2['target'] ? ' target="' . esc_attr( $btn_link_2['target'] ) . '"' : '' )
		               . ( $btn_link_2['title'] ? ' title="' . esc_attr( $btn_link_2['title'] ) . '"' : '' )
		               . '>';
	}
	if ($show_button2 == 'true' && $btn_title_2 != ''){
		if ( $begin_link_btn_2 !='' ) {
			$btn_title_2 = $begin_link_btn_2. esc_attr($btn_title_2) .'</a>';		
		}
		$output .= $btn_title_2;
	}
	$output .= '</div>';
$output .= '</div>';
//}
$output .= '</div>';
echo $output;
