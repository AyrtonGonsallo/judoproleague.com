<?php



/**

 * Template Name: Modèle videos(new)

 */



get_header();



$img="/wp-content/uploads/2022/12/image00011.webp";

?>

<main id="primary" class="blog site-main liste-videos">
    <section class="nv-liste-judoka pd-5">

        <div class="container">

            <?php //recuperer les dernieres series

                query_posts(array('post_type'=> 'video_youtube','posts_per_page' => -1,'order' => 'DESC','orderby' => 'date',		)

                );

            ?>

            <?php if ( have_posts() ) :
              $i=0;
            ?>

                <div class="videos-container" id="videoscontainer">

                    <?php while ( have_posts() ) : the_post();  
                        
                        $image_url=($i==0)?str_replace("hq","maxres",get_field('image')):get_field('image');
                        ?>

                        <div class="videos-container-element">

                            <div class="video-preview" style="background-image: url(<?php echo $image_url;?>);">

                                <div class="button-play-video button-play-video-grande-taille" >

                                    <?php echo do_shortcode('[video_lightbox_youtube video_id="'.get_field('id').'" width="640" height="480" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]') ?>

                                </div>

                                <div class="button-play-video button-play-video-mobile" >

                                    <?php echo do_shortcode('[video_lightbox_youtube video_id="'.get_field('id').'" width="300" height="160" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]') ?>

                                </div>

                            </div>                        

                            <h3 class="nv-title-news-3-col"><?php echo get_field('titre');?></h3>

                        </div>

                    <?php 
                    $i+=1;
                endwhile;?> 

                <?php else: ?>

                    <p>Aucun résultat.</p>

                                    

            <?php endif; wp_reset_query();?>

            </div>

        </div>

    </section>

</main>

    

    



    <?php

get_footer();

?>

