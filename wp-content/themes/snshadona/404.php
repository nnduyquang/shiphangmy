<?php 
get_header();
?>
<div id="sns_content">
    <div class="container">
        <div class="row sns-content">
            <div class="col-md-12 sns-main">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                    	<div class="sns-notfound-page">
	                    		<div class="sns-notfound-content">
		                        <h1 title="<?php echo esc_attr__('404', 'snshadona'); ?>"><?php echo esc_html__('404', 'snshadona'); ?></h1>
		                        <h5 class="notfound-title"><?php echo esc_html( snshadona_themeoption('notfound_title') ); ?></h5>
		                        <p>
		                        	<?php echo esc_html( snshadona_themeoption('notfound_content') ); ?>
		                        </p>
		                        </div>
		                        <div class="sns-notfound-search-form">
		                        	<form method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
										<div>
											<input type="text" placeholder="<?php echo esc_attr__('Enter the key words', 'snshadona'); ?>" value="" name="s">
											<button type="submit"><i class="fa fa-search"></i></button>
										</div>
									</form>
		                        </div>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>