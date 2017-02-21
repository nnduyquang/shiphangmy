<?php
wp_enqueue_script('owlcarousel');
if( $relates->have_posts() ): ?>
	<h3 class="related-title">
        <span><?php echo esc_html__( 'Related Post', 'snshadona' ); ?></span>
    </h3>
    <div class="navslider">
        <span class="prev"></span>
        <span class="next"></span>
    </div>
    <div class="related-content">
		<?php
		while ( $relates->have_posts() ) : $relates->the_post();
        ?>
            <div class="item">
                <?php if ( has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="image">
                        <?php the_post_thumbnail('snshadona_blog_grid3_thumbnail_size'); ?>
                    </a>
                <?php endif; ?>
                 <h4 class="title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    <span class="byline">
                    <?php 
                    esc_html_e('By ', 'snshadona');
                    printf( wp_kses(__( '<a class="author-link" href="%s" ref="author">%s</a>', 'snshadona' ), array(
                                    'a' => array(
                                        'href' => array(),
                                        'class' => array(),
                                        'ref' => array()
                                    ),
                                    ) ), esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),  get_the_author_meta('display_name') ); ?>
                    </span>
                </h4>
            </div>
        <?php
        endwhile; ?>
    </div>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('.post-related .related-content').owlCarousel({
                items: 3,
                responsive : {
                    0 : { items: 1},
                    480 : { items: 2 },
                    768 : { items: 3 },
                    992 : { items: 3 },
                    1200 : { items: 3 }
                },
                loop:true,
                dots: false,
                // animateOut: 'flipInY',
                //animateIn: 'pulse',
                // autoplay: true,
                onInitialized: callback,
                slideSpeed : 800
            });
            function callback(event) {
                if(this._items.length > this.options.items){
                    jQuery('.post-related .navslider').show();
                }else{
                    jQuery('.post-related .navslider').hide();
                }
            }
            jQuery('.post-related .navslider .prev').on('click', function(e){
                e.preventDefault();
                jQuery('.post-related .related-content').trigger('prev.owl.carousel');
            });
            jQuery('.post-related .navslider .next').on('click', function(e){
                e.preventDefault();
                jQuery('.post-related .related-content').trigger('next.owl.carousel');
            });
        });
    </script>
    <?php
    
endif;
?>