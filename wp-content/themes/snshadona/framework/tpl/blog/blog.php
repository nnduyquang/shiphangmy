<?php
$wclass = '';
if ( snshadona_themeoption('blog_class') ) {
	$wclass = snshadona_themeoption('blog_class');
}
$pagination = snshadona_themeoption('pagination', 'def'); // get theme option
?>
<div id="snsmain" class="blog-standard posts sns-blog-posts <?php echo esc_attr($wclass);?>">
<?php 
// Theloop
while ( have_posts() ) : the_post();
    get_template_part( 'framework/tpl/posts/post', get_post_format() );
endwhile;
// Paging
if( $pagination == 'def' || $pagination == '')
	get_template_part('tpl-paging');
?>
</div>
<?php
if( $pagination == 'ajax')
	snshadona_paging_nav_ajax('#snsmain', 'framework/tpl/posts/post' ); // This paging nav should be outside #snsmain div

echo '<input type="hidden" name="hidden_snshadona_blog_layout" value="' . snshadona_themeoption('blog_type') .  '">';