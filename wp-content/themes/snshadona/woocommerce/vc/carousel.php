<?php 
global $product;
?>
<ul class="products product_list grid zoomOut">
<?php
if( isset($row) && $row == '2'):
	$i = 2;
	$class = 'item product';
	if ( isset($animate) && $animate) :
	$class .= ' item-animate';
	endif;
	if ( isset($eclass) && $eclass) :
	$class .= ' '.$eclass;
	endif;
	?>
	
	<?php
	while ( $loop->have_posts() ) : $loop->the_post();
		if($i % 2 == 0):?>
		<li class="<?php echo $class; ?>">
		<?php
		endif;		
	    	wc_get_template( 'vc/item.php' );
	    	
	    if($i % 2 != 0):?>
    	</li>
    	<?php
    	endif;
    	$i++;
	endwhile; ?>
<?php
else: // Default carousel template
	$countdown = '';
	if(isset($show_countdown))
		$countdown = $show_countdown;
	while ( $loop->have_posts() ) : $loop->the_post(); ?>
	    <?php
	    $arra_att = array('show_countdown' => $countdown);
	    if ( isset($animate) && $animate) :
			$arra_att = array_merge($arra_att, array('animate' => $animate));
		endif;
	    if ( isset($eclass) && $eclass) :
			$arra_att = array_merge($arra_att, array( 'eclass' => $eclass));
		endif;
	   
	    wc_get_template( 'vc/item-grid.php', $arra_att);
	    ?>
	<?php endwhile; ?>
<?php endif; ?>
</ul>
<?php if(isset($wrap_id)){
	$id = $wrap_id . ' #'.$id;
} ?>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('#<?php echo $id;?> ul').owlCarousel({
		items: <?php echo intval($number_display) ?>,
		responsive : {
			  0 : { items: 1 },
		    480 : { items: <?php echo intval($number_display_480) ?> },
		    768 : { items: <?php echo intval($number_display_768) ?> },
		    992 : { items: <?php echo intval($number_display_992) ?> },
		    1200 : { items: <?php echo intval($number_display_1200) ?> },
		    1600 : { items: <?php echo intval($number_display) ?> }
		},
		loop:true,
        dots: false,
	    // autoplay: true,
        onInitialized: callback,
        slideSpeed : 800
	});
	function callback(event) {

		if(this._items.length > this.options.items){
	        jQuery('#<?php echo $id;?> .navslider').show();
	    }else{
	        jQuery('#<?php echo $id;?> .navslider').hide();
	    }
	}
	jQuery('#<?php echo $id;?> .navslider .prev').on('click', function(e){
		if( jQuery('body').hasClass('use_lazyload') ){
			var timeout = setTimeout(function() {
		        jQuery("#<?php echo esc_attr($id);?> img.lazy:not(.loaded)").trigger("appear")
		    }, 1000);
		}
		e.preventDefault();
		jQuery('#<?php echo $id;?> ul').trigger('prev.owl.carousel');
	});
	jQuery('#<?php echo $id;?> .navslider .next').on('click', function(e){
		if( jQuery('body').hasClass('use_lazyload') ){
			var timeout = setTimeout(function() {
		        jQuery("#<?php echo esc_attr($id);?> img.lazy:not(.loaded)").trigger("appear")
		    }, 1000);
		}
		e.preventDefault();
		jQuery('#<?php echo $id;?> ul').trigger('next.owl.carousel');
	});
});
</script>