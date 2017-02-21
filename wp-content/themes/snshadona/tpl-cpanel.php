<?php
$theme_color = snshadona_themeoption('theme_color', '#e22020');

// Get page meta data
if (function_exists('rwmb_meta') && rwmb_meta('snshadona_page_themecolor') == 1) {
	$theme_color = rwmb_meta('snshadona_theme_color') != '' ? rwmb_meta('snshadona_theme_color') : $theme_color;
}

$theme_color = str_replace('#', '', $theme_color);
$boxedlayout =  snshadona_themeoption('use_boxedlayout');
$stickymenu = snshadona_themeoption('use_stickmenu');

?>
<div id="sns_cpanel">
    <div class="cpanel-head">
    	<a class="button btn-buy" href="#" title="<?php echo esc_html__('Buy Theme Now', 'snshadona'); ?>"><?php echo esc_html__('Buy Theme Now', 'snshadona'); ?></a>
    </div>
    <div class="cpanel-set">
    	<div class="form-group">
    		<div class="col-xs-12">
				<label><?php echo esc_html__('Theme Color', 'snshadona'); ?></label>
				<div class="" id="cpanel_themecolor">
					<a class="<?php echo ( $theme_color == 'c4b498' ) ? 'active color' : 'color'; ?>" href="<?php echo ( get_page(370) ) ? esc_url( get_page_link(370) ) : '' ; ?>" data-color="c4b498">#c4b498</a>
					<a class="<?php echo ( $theme_color == 'e0da1a' ) ? 'active color' : 'color'; ?>" href="<?php echo ( get_page(1346) ) ? esc_url( get_page_link(1346) ) : '' ; ?>" data-color="e0da1a">#e0da1a</a>
                    <a class="<?php echo ( $theme_color == '17a7f1' ) ? 'active color' : 'color'; ?>" href="<?php echo ( get_page(374) ) ? esc_url( get_page_link(374) ) : '' ; ?>" data-color="17a7f1">#17a7f1</a>
				</div>

				<p><?php echo esc_html__('You can also sellect color codes via admin theme options', 'snshadona'); ?></p>
			</div>		
		</div>
		<?php
		$scss_compile = snshadona_themeoption('advance_scss_compile');
		?>
		
		<div class="form-group">
			<div class="col-xs-12">
				<label><?php echo esc_html__('Always Compile SCSS', 'snshadona'); ?></label>
				<div class="content scss_compile">
					<a class="<?php echo ($scss_compile == 2)?'active menu':'menu'; ?>" href="#" data-scsscompile="2">Yes</a>
					<a class="<?php echo ($scss_compile == 1)?'active menu':'menu'; ?>" href="#" data-scsscompile="1">No</a>
					<input type="hidden" name="scss_compile" value="<?php echo esc_attr($scss_compile); ?>"/>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-xs-12">
				<label><?php echo esc_html__('Enable sticky menu', 'snshadona'); ?></label>
				<div class="content sticky_menu">
					<a class="<?php echo ($stickymenu == 1)?'active menu':'menu'; ?>" href="#" data-sticky="1">Yes</a>
					<a class="<?php echo ($stickymenu == 0)?'active menu':'menu'; ?>" href="#" data-sticky="0">No</a>
					<input type="hidden" name="sticky_menu" value="<?php echo esc_attr($stickymenu); ?>"/>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-xs-12">
				<label><?php echo esc_html__('Use boxed Layout', 'snshadona'); ?></label>
				<div class="content boxed_layout">
					<a class="<?php echo ($boxedlayout == 1)?'active layout':'layout'; ?>" href="#" data-boxed="1">Yes</a>
					<a class="<?php echo ($boxedlayout == 0)?'active layout':'layout'; ?>" href="#" data-boxed="0">No</a>
					<input type="hidden" name="sns_boxed_layout" value="<?php echo esc_attr($boxedlayout); ?>" />
				</div>
			</div>
		</div>
    </div>
    <div class="cpanel-bottom">
    	<div class="form-group">
			<div class="col-xs-12">
				<div class="button-action">
					<!--<a class="button btn-preview" href="#"><?php //echo esc_html__('Preview', 'snshadona'); ?></a> -->
					<a class="button btn-reset" href="#"><?php echo esc_html__('Reset Options', 'snshadona'); ?></a>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-xs-12">
				<!-- <label>Cpanel tool</label> -->
				<p><?php echo esc_html__('That is some options to demo for you.', 'snshadona'); ?></p>
			</div>
		</div>
	</div>
    <div id="sns_cpanel_btn">
        <i class="fa fa-cog fa-spin"></i>
    </div>
	<script type="text/javascript">
	// <![CDATA[
	jQuery(document).ready(function($){
		
		$('#sns_cpanel_btn').click(function(){
			if( !$('#sns_cpanel').hasClass('open') ){
				$('#sns_cpanel').animate({right:'0px'});
				$('#sns_cpanel').addClass('open');
			}else{
				$('#sns_cpanel').animate({right:'-290px'});
				$('#sns_cpanel').removeClass('open');
			}
		});
		
		// SCSS Compile
		$('#sns_cpanel .scss_compile a').click(function(){
            var scsscompile = $(this).data('scsscompile');
            var href = $(this).attr('href');
            $('#sns_cpanel').addClass('wait');
            $.ajax({
                url: ajaxurl,
                data:{
                	action : 'sns_setcookies',
                	key	: 'advance_scss_compile',
                	value : scsscompile
                },
                type: 'POST',
                success:function(result){
                	if ( href != '#' ) window.location.href = href;
                	else window.location.href = window.location.href;
                }
            });
            return false;
        });
		
		$('#cpanel_themecolor a').each(function(){
			$(this).css({
				'background-color': '#'+$(this).data('color')
			});
		})

		// Click theme color
		$('#cpanel_themecolor a').click(function(){
            var color = $(this).data('color');
            var href = $(this).attr('href');
            $('#sns_cpanel').addClass('wait');
            if ( href != '#' ) window.location.href = href;
            else window.location.href = window.location.href;
            return false;
        });

        // Click Boxed Layout
		$('#sns_cpanel .boxed_layout a').click(function(){
            var boxed = $(this).attr('data-boxed');
            var href = $(this).attr('href');
            $('#sns_cpanel').addClass('wait');
            $.ajax({
                url: ajaxurl,
                data:{
                	action : 'sns_setcookies',
                	key	: 'use_boxedlayout',
                	value : boxed
                },
                type: 'POST',
                success:function(result){
                	if ( href != '#' ) window.location.href = href;
                	else window.location.href = window.location.href;
                }
            });
            return false;
        });
        
        // Click Sticky Menu
		$('#sns_cpanel .sticky_menu a').click(function(){
            var sticky = $(this).data('sticky');
            var href = $(this).attr('href');
            $('#sns_cpanel').addClass('wait');
            $.ajax({
                url: ajaxurl,
                data:{
                	action : 'sns_setcookies',
                	key	: 'use_stickmenu',
                	value : sticky
                },
                type: 'POST',
                success:function(result){
                	if ( href != '#' ) window.location.href = href;
                	else window.location.href = window.location.href;
                }
            });
            return false;
        });
        
        // Reset cookie
        $('#sns_cpanel .btn-reset').click(function(){
            var href = '<?php echo site_url(); ?>';
            $('#sns_cpanel').addClass('wait');
            $.ajax({
                url: ajaxurl,
                data:{
                	action : 'sns_resetcookies'
                },
                type: 'POST',
                success:function(result){
                	if ( href != '#' ) window.location.href = href;
                	else window.location.href = window.location.href;
                }
            });
            return false;
        });
	});
	// ]]>
	</script>
</div>