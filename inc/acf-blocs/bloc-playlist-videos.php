<?php //recuperer les dernieres series
    $args =array(
        'post_type'=> 'video_youtube',
        'posts_per_page' => 4,
        'meta_key' => 'date_dajout',
        'orderby' => 'meta_value',
            'order' => 'DESC'
        );
        $videos = get_posts( $args );
        $videos_desktop_1 = array_slice(get_posts( $args ),0,1);
        $videos_desktop_2 = array_slice(get_posts( $args ),1,4);
        ?>
<section class="videos-playlist" style="background-image: url(/wp-content/uploads/2024/07/bg-videos.jpg);background-size:cover;background-repeat:no-repeat; background-position:center;">
   <div class="div-videos">
        <div class="flx-tle-but">
            <h2 class="sondg-title">NOS VIDÉOS</h2>
            <a href="liste-videos/"  class="but-vid-hm"> Toutes les vidéos <i class="fa-solid fa-arrow-right-long"></i></a>
        </div>
 <!--div class="title-gallery">
         <h2 class="title-videos">Les dernières vidéos de la Judo Pro League</h2>
        <div class="nv-sep"></div>
    </div-->
    <?php if ( $videos) :
       ?>
        <div class="videos-container" id="videoscontainer">
            <?php foreach ( $videos as $video ){?>
                <div class="videos-container-element">
                    <div class="video-preview" style="background-image: url(<?php echo get_field('image',$video->ID)?>);">
                        <div class="button-play-video button-play-video-grande-taille" >
                            <?php echo do_shortcode('[video_lightbox_youtube video_id="'.get_field('id',$video->ID).'" width="640" height="480" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]') ?>
                        </div>
                        <div class="button-play-video button-play-video-mobile" >
                            <?php echo do_shortcode('[video_lightbox_youtube video_id="'.get_field('id',$video->ID).'" width="300" height="160" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]') ?>
                        </div>
                    </div>
                    <div class="video-title-infos">
                        <div ><?php echo get_field('titre',$video->ID);?></div>
                    </div>
                </div>
            <?php }?> 
        <?php else: ?>
            <p>Aucun résultat :(</p>
        					
    <?php endif; wp_reset_query();?>

    </div>	


    <?php if ( $videos_desktop_2) :
       ?>
        <div class="videos-container2" id="videoscontainer">
                <div class="videos-container-element">
                    <div class="video-preview" style="background-image: url(<?php echo str_replace("hq","maxres",get_field('image',$videos_desktop_1[0]->ID))?>);">
                        <div class="button-play-video button-play-video-grande-taille" >
                            <?php echo do_shortcode('[video_lightbox_youtube video_id="'.get_field('id',$videos_desktop_1[0]->ID).'" width="640" height="480" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]') ?>
                        </div>
                        <div class="button-play-video button-play-video-mobile" >
                            <?php echo do_shortcode('[video_lightbox_youtube video_id="'.get_field('id',$videos_desktop_1[0]).'" width="300" height="160" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]') ?>
                        </div>
                    </div>
                    <div class="video-title-infos">
                        <div ><?php echo get_field('titre',$videos_desktop_1[0]);?></div>
                    </div>
                </div>
                <div class="videos-3">
                    <?php foreach ( $videos_desktop_2 as $video ){?>
                        <div class="videos-container-element">
                            <div class="video-preview" style="background-image: url(<?php echo get_field('image',$video->ID)?>);">
                                <div class="button-play-video button-play-video-grande-taille" >
                                    <?php echo do_shortcode('[video_lightbox_youtube video_id="'.get_field('id',$video->ID).'" width="640" height="480" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]') ?>
                                </div>
                                <div class="button-play-video button-play-video-mobile" >
                                    <?php echo do_shortcode('[video_lightbox_youtube video_id="'.get_field('id',$video->ID).'" width="300" height="160" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]') ?>
                                </div>
                            </div>
                            <div class="video-title-infos">
                                <div ><?php echo get_field('titre',$video->ID);?></div>
                            </div>
                        </div>
                    <?php }?> 
                </div>
        <?php else: ?>
            <p>Aucun résultat :(</p>
        					
    <?php endif; wp_reset_query();?>
    
        
 </div>
     
<a href="liste-videos/" class="btn-classmnt btn-mobile center">Toutes les vidéos</a>
</section>


