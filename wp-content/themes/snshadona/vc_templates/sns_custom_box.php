<?php
/*
* SNS Custom Box
*/

$output = '';
$id = rand().time();
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

vc_icon_element_fonts_enqueue( $icon_type ); 
$icon_style = '';
if( $icon_color != '' ){
	$icon_style .= 'color:'.esc_attr($icon_color).';';
}
if( $icon_font_size != '' ){
	$icon_style .= 'font-size:'.esc_attr($icon_font_size).';';
}

$tclass = 'sns-custom-box faa-parent';


$icon_style .= 'display: inline-block;';
$tclass .= ( trim(esc_attr($extra_class))!='' )?' '.esc_attr($extra_class):'';
$tclass .= esc_attr($this->getCSSAnimation( $css_animation ));

if($icon_image != ''){
	$icon_image = preg_replace('/[^\d]/', '', $icon_image);
	$img =   wp_get_attachment_image_src( $icon_image , '');
}
$border_style = '';
if($icon_bgcolor != ''){
	$icon_style .= 'background:'.esc_attr($icon_bgcolor).';';
	$border_style .= 'border: 3px solid '.esc_attr($icon_bgcolor).';';
}
$title_style = '';
if($title_color != ''){
	$title_style .= 'color:'.esc_attr($title_color).';';
}
if($box_template != ''){
	$tclass .= ' '.esc_attr($box_template);
}


ob_start();
?>

<div id="sns-custombox-<?php echo $id; ?>" class="<?php echo esc_attr($tclass); ?> animated-hover" >
	<style scoped>
			#sns-custombox-<?php echo $id; ?> .custom-box-wrapper  span{ <?php echo $icon_style; ?> }
			#sns-custombox-<?php echo $id; ?> .custom-box-wrapper .icon{  <?php echo $icon_style; ?> }
			#sns-custombox-<?php echo $id; ?> .custom-box-wrapper  .wpb_heading a{ <?php echo $title_style; ?> }
			#sns-custombox-<?php echo $id; ?> .custom-box-wrapper .icon:before{  <?php echo $border_style; ?> }

	</style>
	<div class="custom-box-wrapper <?php echo $text_align; ?>">
		<div class="icon">
			<?php if($icon_image != ''): ?>
				<img src="<?php echo $img[0] ?>" alt="" />
			<?php else: ?>
				<span class="vc_icon_element-icon <?php echo esc_attr( ${"icon_" . $icon_type} ); ?> faa-horizontal"></span>
			<?php endif; ?>	
		</div>
		<div class="content-custom-box">
			<?php if($title != ''):?>
			<h2 class="wpb_heading"><a href="<?php echo esc_url( $link ) ?>"><?php echo esc_html( $title ) ?></a></h2>
			<?php endif; ?>
			<?php if($desc != ''):?>
			<p><?php echo esc_html( $desc ); ?></p>
			<?php endif; ?>
			<?php if($show_link == 'true'): ?>
				<a class="read_more" href="<?php echo esc_url( $link ) ?>"><?php echo esc_html( 'Read more','snshadona' ) ?></a>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php


$output = ob_get_clean();
echo $output;