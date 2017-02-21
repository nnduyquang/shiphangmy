<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php
    // Post Quote
    if ( get_post_format() == 'quote' && function_exists('rwmb_meta') && rwmb_meta('snshadona_post_quotecontent') && rwmb_meta('snshadona_post_quoteauthor') ) :
        $uq  = rand().time();
        ?>
        <div class="quote-info quote-info-<?php echo $uq; ?>">
            <?php if ( rwmb_meta('snshadona_post_quotecontent') ) : ?>
            <div class="quote-content gfont"><i class="fa fa-quote-left"></i><?php echo esc_html(rwmb_meta('snshadona_post_quotecontent')); ?><i class="fa fa-quote-right"></i></div>
            <?php endif; ?>
             <?php if ( rwmb_meta('snshadona_post_quoteauthor') ) : ?>
            <div class="quote-author"><?php echo esc_html(rwmb_meta('snshadona_post_quoteauthor')); ?></div>
            <?php endif; ?>
        </div>
        <style scoped>
            .quote-info-<?php echo $uq; ?>{
                <?php if(rwmb_meta('snshadona_post_quote_bg')) : ?>
                background: <?php echo esc_attr(rwmb_meta('snshadona_post_quote_bg')); ?>;
                <?php endif; ?>
                <?php if(rwmb_meta('snshadona_post_quote_color')) : ?>
                color: <?php echo esc_attr(rwmb_meta('snshadona_post_quote_color')); ?>;
                <?php endif; ?>
            }
        </style>
    <?php
    // Post Link
    elseif ( get_post_format() == 'link' && function_exists('rwmb_meta') && rwmb_meta('snshadona_post_linkurl') ) : ?>
        <div class="link-info">
            <a class="gfont" title="<?php echo esc_attr(rwmb_meta('snshadona_post_linktitle')) ?>" href="<?php echo esc_url( rwmb_meta('snshadona_post_linkurl') ) ?>"><?php echo esc_html(rwmb_meta('snshadona_post_linktitle')) ?></a>
           
        </div>
    <?php
    // Post Video
    elseif ( get_post_format() == 'video' && function_exists('rwmb_meta') && rwmb_meta('snshadona_post_video') ) : ?>
        <div class="video-thumb video-responsive">
            <?php
           // echo rwmb_meta('snshadona_post_video');
          //  echo wp_oembed_get(esc_attr(rwmb_meta('snshadona_post_video')));
             echo wp_oembed_get(esc_attr(get_post_meta(get_the_id(), 'snshadona_post_video', true)));
            ?>
            
        </div>
    <?php
    // Post audio
        elseif ( get_post_format() == 'audio' && function_exists('rwmb_meta') && rwmb_meta('snshadona_post_audio') ) : ?>
            <div class="audio-thumb audio-responsive">
                <?php
                echo wp_oembed_get(esc_attr(rwmb_meta('snshadona_post_audio')));
                ?>
            </div>
        <?php
    // Post Gallery
    elseif ( get_post_format() == 'gallery' && function_exists('rwmb_meta') && rwmb_meta('snshadona_post_gallery') ) :
        wp_enqueue_script('owlcarousel');
        ?>
        <div class="gallery-thumb">
            <div class="navslider"><span class="prev"></span><span class="next"></span></div>
            <div class="thumb-container">
            <?php
            foreach (rwmb_meta('snshadona_post_gallery', 'type=image') as $image) {?>
               <div class="item"><img alt="<?php echo esc_attr($image['alt']); ?>" src="<?php echo esc_attr($image['full_url']); ?>"/></div>
            <?php
            }
            ?>
            </div>
            
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery('#post-<?php the_ID() ?> .thumb-container').owlCarousel({
                    items: 1,
                    loop:true,
                    dots: false,
                    // animateOut: 'flipInY',
                    //animateIn: 'pulse',
                    //autoplay: true,
                    autoHeight: true,
                    onInitialized: callback,
                    slideSpeed : 800
                });
                function callback(event) {
                    if(this._items.length > this.options.items){
                        jQuery('#post-<?php the_ID() ?> .navslider').show();
                    }else{
                        jQuery('#post-<?php the_ID() ?> .navslider').hide();
                    }
                }
                jQuery('#post-<?php the_ID() ?> .navslider .prev').on('click', function(e){
                    e.preventDefault();
                    jQuery('#post-<?php the_ID() ?> .thumb-container').trigger('prev.owl.carousel');
                });
                jQuery('#post-<?php the_ID() ?> .navslider .next').on('click', function(e){
                    e.preventDefault();
                    jQuery('#post-<?php the_ID() ?> .thumb-container').trigger('next.owl.carousel');
                });
            });
        </script>
    <?php
    // Post Image
    elseif ( has_post_thumbnail() ) : ?>
        <div class="post-thumb">
            <?php
            $blog_type = snshadona_themeoption('blog_type');
            $img_size = 'full';
            switch ($blog_type){
                case 'layout2';
                    $img_size = 'snshadona_blog_layout2_thumbnail_size';
                    break;
                case 'masonry';
                    $img_size = 'full';
                    break;
                default: // standard post
                    $img_size = 'full';
                    break;
            }?>
                <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( esc_html__( '%s', 'snshadona' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
                <?php
                    the_post_thumbnail($img_size);
                ?>
                </a>
        </div>
    <?php
    endif;?>
    <div class="post-content">
       
        <div class="content">
            <h2 class="page-header">
              <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( esc_html__( 'Permalink to %s', 'snshadona' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
              <?php if( snshadona_themeoption('show_author', 1) == 1 ): ?>
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
                <?php endif; ?>
            </h2>
            
             <?php if( snshadona_themeoption('show_tags', 1) == 1 || snshadona_themeoption('show_comment_count', 1) == 1 || snshadona_themeoption('show_categories', 1) == 1 || snshadona_themeoption('show_date', 1) == 1) : ?>
                <div class="post-meta">
                    <?php
                    // Is sticky or not
                    if ( is_sticky() && ! is_paged() ) { ?>
                        <span class="sticky-post"><?php echo esc_html__( 'Sticky', 'snshadona' ) ; ?></span>
                    <?php
                    }
                    // Date
                    if (snshadona_themeoption('show_date', 1) == 1 && !is_sticky()) : ?>
                        <?php
                        printf( '<span class="entry-date">%1$s<a href="%2$s" rel="bookmark"><time class="published" datetime="%2$s">%3$s</time></a></span>',
                        esc_html('', 'snshadona'),
                        esc_attr( get_the_date( 'c' ) ),
                        get_the_date()
                        );
                        ?>
                    <?php endif; ?>
                    <?php
                    // Edit link
                    edit_post_link(esc_html__('Edit','snshadona'), '<span class="edit-post">', '</span>'); 
                    ?>
                  
                    <?php if( snshadona_themeoption('show_comment_count', 1) == 1 && get_comments_number() ): ?>
                        <span class="post-comment-count">
                        <?php
                        if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
                            echo '<span class="comments-link">';
                          //  esc_html_e('', 'snshadona');
                            /* translators: %s: post title */
                            comments_popup_link( esc_html__( '0 Comments','snshadona' ),  esc_html__( '1 Comment','snshadona' ), '%' . esc_html__(' Comments','snshadona'));
                            echo '</span>';
                        }
                        ?>
                        </span>
                    <?php endif; ?>
                    <?php if( snshadona_themeoption('show_tags', 1) == 1 && get_the_tag_list()): ?>
                        <span class="tags-links"><?php the_tags(esc_html__('Tags: ', 'snshadona'),', '); ?></span>
                    <?php endif; ?>
                     <?php if(snshadona_themeoption('show_categories', 1) == 1):?>
                    <div class="post-cats">
                            <?php if( snshadona_themeoption('show_categories', 1) == 1 && get_the_category_list() ): ?>
                                <span class="cat-links"><?php echo esc_html__('In: ', 'snshadona'); ?><?php echo get_the_category_list(', '); ?></span>
                            <?php endif; ?>
                    </div>
                    <?php endif;?>
                </div>
            <?php endif; ?>
            
            
            <div class="post-excerpt">
                <?php if( empty( $post->post_excerpt ) ) { ?>
                <?php
                $readmore = '<span>'.esc_html__('Read More', 'snshadona').'</span><span class="meta-nav">→</span>';
                if ( is_search() && $post->post_type == 'page' ) {
                    // Trip shortcodes for post type is page on search result page
                    echo strip_shortcodes(get_the_content($readmore));
                }else{
                    the_content($readmore);
                }
                wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'snshadona' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
                ?>
                <?php } else { ?>
                    <p class="excerpt"><?php echo snshadona_excerpt( (int)snshadona_themeoption('excerpt_length', 55) ); ?></p>
                <?php } ?>
            </div>
            <div class="post-meta-more"> 
                <?php if ( snshadona_themeoption('show_readmore', 0) == 1) : ?>
                <div class="read-more">
                    <a class="button" href="<?php echo get_permalink();?>" title="<?php esc_html_e('Read more', 'snshadona');?>"><?php esc_html_e('Read more', 'snshadona');?></a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</article>