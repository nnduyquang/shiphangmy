<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

$class = 'grid';
$id = 'sns_woo_list';
if ( !is_product() && !is_cart() ) :
	//$class .=' row';
	$viewmode = snshadona_themeoption('woo_list_modeview');
	if (isset($_COOKIE['sns_woo_list_modeview']) && $_COOKIE['sns_woo_list_modeview']== 'grid') {
		$class = $class;
	}elseif (isset($_COOKIE['sns_woo_list_modeview']) && $_COOKIE['sns_woo_list_modeview']== 'list') {
	    $class = 'list';
	}elseif (isset($_COOKIE['sns_woo_list_modeview']) && $_COOKIE['sns_woo_list_modeview']== 'list-table') {
	    $class = 'list-table';
	}
	else{
	    if ( $viewmode == 'grid' ){
	    	$class = $class;
	    }elseif($viewmode == 'list'){
	    	$class = 'list';
	    }
	    else{
	    	$class = 'list-table';
	    }
	}
else:
	$id .= rand();
endif;
$class .= ' row';
?>
<div class="prdlist-content">
	<ul id="<?php echo $id; ?>" class="products product_list <?php echo $class; ?>">