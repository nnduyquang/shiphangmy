<?php

$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$uq = rand().time();
$extra_class = esc_attr($extra_class) ? 'sns_show_video '.esc_attr($extra_class) : 'sns_show_video';
$title_style='';

if ($font_size != ''){
$title_style.='font-size: '.$font_size.';';
}

if ($title_color != ''){
	$title_style.=' color: '.$title_color.';';
}
if ($margin_bottom != ''){
	$title_style.=' margin-bottom: '.$margin_bottom;
}

?>
<style scoped>
		#sns_show_video-<?php echo $uq; ?> .title{  <?php echo $title_style; ?> }
		#sns_show_video-<?php echo $uq; ?> .title span{ color: <?php echo $last_title_color; ?> }
</style>
<?php
$output .= '<div id="sns_show_video-'.esc_attr($uq).'" class="'.$extra_class.'">';

if ($title != ''){
	$output .= '<h3 class="title">'.$title.'<span>'.$last_title.'</span></h3>';
}

if ( $button != ''){
	$output .= '<a class="button btn-popupvideo">'. esc_attr($button);
	$output .= '<span class="overlay"></span>';
	$output .= '</a>';
	 
}
	$output .= '<div class="content">'.$content.'</div>';

//}
$output .= '</div>';
echo $output;
?>
<script type="text/javascript">
	jQuery(document).ready(function($){	
		//show hidden sns after shop loop
		if($('#sns_show_video-<?php echo esc_attr($uq); ?> .content').length) {
			$('#sns_show_video-<?php echo esc_attr($uq); ?> .btn-popupvideo').on('click', function(){
				if($('#sns_show_video-<?php echo esc_attr($uq); ?> .content').hasClass('active')){
					$(this).find('.overlay').fadeOut(250);
					$('#sns_show_video-<?php echo esc_attr($uq); ?> .content').removeClass('active',400);
					$('body').removeClass('show-video', 4000);
				} else {
					$('#sns_show_video-<?php echo esc_attr($uq); ?> .content').addClass('active',400);
					$(this).find('.overlay').fadeIn();
					$('body').addClass('show-video');
				}
			});
		}
	});	
			
</script>