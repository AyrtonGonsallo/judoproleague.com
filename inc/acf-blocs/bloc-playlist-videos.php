<?php //recuperer les dernieres series
    query_posts(array(
        'post_type'=> 'video_youtube',
        'posts_per_page' => 4,
        'orderby' => 'date',
            'order' => 'DESC'
        ));
        ?>
<section class="videos-playlist" style="background-image: url(/wp-content/uploads/2023/07/bg-video.jpg);">
    <!--div class="title-gallery">
        <h2 class="title-videos">Les dernières vidéos de la Judo Pro League</h2>
        <div class="nv-sep"></div>
    </div-->
    <?php if ( have_posts() ) :
       ?>
        <div class="videos-container" id="videoscontainer">
            <?php while ( have_posts() ) : the_post();?>
                <div class="videos-container-element">
                    <div class="video-preview" style="background-image: url(<?php echo get_field('image')?>);">
                        <div class="button-play-video button-play-video-grande-taille" >
                            <?php echo do_shortcode('[video_lightbox_youtube video_id="'.get_field('id').'" width="640" height="480" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]') ?>
                        </div>
                        <div class="button-play-video button-play-video-mobile" >
                            <?php echo do_shortcode('[video_lightbox_youtube video_id="'.get_field('id').'" width="300" height="160" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]') ?>
                        </div>
                    </div>
                    <div class="video-title-infos">
                        
                        <div ><?php echo get_field('titre');?></div>
                    </div>
                </div>
            <?php endwhile;?> 
        <?php else: ?>
            <p>Aucun résultat :(</p>
        					
    <?php endif; wp_reset_query();?>
    </div>	    
	<a href="liste-videos/"  class="more">
        <img src="/wp-content/uploads/2023/07/play-button.png" class="nv-img-v">
        Toutes les vidéos
    </a>

     
</section>


