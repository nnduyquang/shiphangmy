<?php
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );  
extract( $atts );

global $post, $snshadona_opt, $snshadona_blog_pagination;
$snshadona_blog_pagination = $pagination;

$page = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);
if(!$page) $page = 1;
$args = array(
	'post_type' => 'post',
	'post_status' => 'publish',
	'posts_per_page' => (int)$posts_per_page,
	'paged'          => $page,
);

if(!empty($category)){
	$cat_id = explode(',', $category );
	$args['tax_query'] = array(
		array(
			'taxonomy' => 'category',
			'field' => 'slug',
			'terms' => $cat_id
		)
	);
}

$extra_class = (trim($extra_class) != '') ? ' '.$extra_class : '';
global $paged, $wp, $wp_query;
$temp_query = $wp_query;

$query = new WP_Query($args);

// helper for load more ajax
$wp_query = $query;

global $wp_query, $wp;

$js_params['current_url'] = esc_url( home_url( $wp->request ) );

$js_query_vars = '';
foreach ( $query->query as $key => $value ){
	if( is_numeric($value) ){
		$js_query_vars .= '"'.$key.'":'.$value.',';
	}elseif( is_array($value) ){
		$output = array();
		foreach ($value as $json_arr){
			$output[] = '"'.$json_arr.'"';
		}
		$js_query_vars .= '"'.$key.'":['.implode(',', $output).'],';
	}else{
		$js_query_vars .= '"'.$key.'":"'.$value.'",';
	}
}

if( have_posts() ) :
	snshadona_set_themeoption('blog_class', ' sns-blog-page '.$extra_class);
	snshadona_set_themeoption('blog_type', $blog_type);
	snshadona_set_themeoption('excerpt_length', $excerpt_length);
	snshadona_set_themeoption('show_readmore', $show_readmore);
	snshadona_set_themeoption('pagination', $pagination);
	ob_start();
	?>
	<script type="text/javascript">
	     var sns = {"ajaxurl":"<?php echo esc_url( admin_url( 'admin-ajax.php' ) );?>","query_vars":{<?php echo $js_query_vars; ?>},"current_url":"<?php echo esc_url( home_url($wp->request) );?>" }
	</script>
	<?php
	get_template_part( 'framework/tpl/blog/blog', $blog_type );
	$output .= ob_get_clean();
endif;
$wp_query = $temp_query;

wp_reset_postdata();
echo $output;
