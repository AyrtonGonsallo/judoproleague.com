<?php

/**
 * Template Name: Modèle liste news
 */

get_header();

$args=array(
	'post_type'=> 'post',
	'posts_per_page' => -1,
	'orderby' => 'post_date', 
	'order' => 'DESC',
);
$news=get_posts($args);


 // Nombre total d'articles
 $total_articles = sizeof($news); // Remplacez par le nombre total d'articles
 $articles_per_page = 10; // Remplacez par le nombre d'articles par page
 
 // Calculer le nombre total de pages
 $total_pages = ceil($total_articles / $articles_per_page);
 
 // Page actuelle
 $current_page = max(1, get_query_var('paged'));
 
 // Préparer les arguments pour paginate_links()
 $pagination_args = array(
     'total' => $total_pages,
     'current' => $current_page,
     'format' => '?paged=%#%',
     'show_all' => false,
     'prev_next' => true,
     'prev_text' => __('&laquo; Précédent'),
     'next_text' => __('Suivant &raquo;'),
     'type' => 'list', // Retourner une liste HTML pour une meilleure personnalisation
 );

 $debut=($current_page-1)*$articles_per_page;
 $fin=$articles_per_page*$current_page;

 $news_part1=array_slice($news,$debut,1);
$news_part2=array_slice($news,$debut+1,6);
$news_part3=array_slice($news,$debut+6,7);

?>

   
<main id="primary" class="site-main blog page-actus">

    
<?php //echo "De ".$debut." à ".$fin?>
    <section class="section-bloc-articles">
<h1 class="result-h1">Actualités de la Judo Pro League</h1>

        <div class="news-1-col">
            <?php if( $news_part1 ): 
                foreach( $news_part1 as $my_post ): 
                    $video   = get_field('videos_a_la_une');
                    $video = get_field( "videos_a_la_une", $my_post->ID );
                    $img= get_the_post_thumbnail_url($my_post->ID,'full');
                    $url_externe=get_field('activer_lien_poule', $my_post->ID);
                    if($url_externe=='Activer'){ 
                        $url=get_field('lien_classement', $my_post->ID);
                    }
                    else{
                        $url=get_permalink($my_post->ID);
                    }
                    $content = $my_post->post_content;
                    $excerpt = substr($content, 0, 230);
                ?>
                    <div class="display-news-2-col-reverse">
                        <?php if($video==null){?><a href="<?= $url; ?>" class="news-link-2-col"><?php }?>
                        <div class="news-img-2-col" style="background-image: url(<?= $img; ?>);">
                            <?php
                                if($video!=null){
                                    $id = explode('watch?v=', $video)[1];//https://www.youtube.com/watch?v=EBmDX7MNHSI
                                    echo '<div class="video video-grande-taille">'.
                                            do_shortcode('[video_lightbox_youtube video_id="'.$id.'" width="640" height="480" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]').
                                        '</div>';
                                    echo '<div class="video video-mobile">'.
                                            do_shortcode('[video_lightbox_youtube video_id="'.$id.'" width="300" height="160" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]').
                                        '</div>';?>
                            <?php
                                }?>
                        </div>
                        <?php if($video==null){ ?></a><?php }?>
                        <div class="nv-right-content">
                            <a href="<?= $url; ?>" class="news-link-2-col"><h3 class="nv-title-news-3-col"><?= $my_post->post_title?></h3></a>
                            <span><?php $date=get_the_date('j F Y', $my_post->ID ); echo $date; ?></span>
                            <div class="entry-content">
                                    <?php 
                                        $excerpt = get_the_excerpt($my_post->ID);
                                        echo wp_trim_words( $excerpt, 22, '  [...]' ); 
                                    ?>
                                </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            <?php endif; ?>        
        </div>
        
        <div class="news-3-2-1-col">
            <div class="news-2-col">
                <?php if( $news_part2 ): 
                    foreach( $news_part2 as $my_post ): 
                        $video   = get_field('videos_a_la_une');
                        $video = get_field( "videos_a_la_une", $my_post->ID );
                        $img= get_the_post_thumbnail_url($my_post->ID,'full');
                        $url_externe=get_field('activer_lien_poule', $my_post->ID);
                        if($url_externe=='Activer'){ 
                            $url=get_field('lien_classement', $my_post->ID);
                        }
                        else{
                            $url=get_permalink($my_post->ID);
                        }
                        $content = $my_post->post_content;
                        $excerpt = substr($content, 0, 230);
                    ?>
                        <div class="display-news-1-col">
                            <?php if($video==null){?><a href="<?= $url; ?>" class="news-link-2-col"><?php }?>
                            <div class="news-img-2-col" style="background-image: url(<?= $img; ?>);">
                                <?php
                                    if($video!=null){
                                        $id = explode('watch?v=', $video)[1];//https://www.youtube.com/watch?v=EBmDX7MNHSI
                                        echo '<div class="video video-grande-taille">'.
                                                do_shortcode('[video_lightbox_youtube video_id="'.$id.'" width="640" height="480" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]').
                                            '</div>';
                                        echo '<div class="video video-mobile">'.
                                                do_shortcode('[video_lightbox_youtube video_id="'.$id.'" width="300" height="160" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]').
                                            '</div>';?>
                                <?php
                                    }?>
                            </div>
                            <?php if($video==null){ ?></a><?php }?>
                            <div class="nv-right-content">
                                <a href="<?= $url; ?>" class="news-link-2-col"><h3 class="nv-title-news-3-col"><?= $my_post->post_title?></h3></a>
                                <span><?php $date=get_the_date('j F Y', $my_post->ID ); echo $date; ?></span>
                                <div class="entry-content">
                                    <?php 
                                        $excerpt = get_the_excerpt($my_post->ID);
                                        echo wp_trim_words( $excerpt, 22, '  [...]' ); 
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                <?php endif; ?>        
            </div>
            <!-- <div class="news-1-col">
                <?php if( $news_part3 ): 
                    foreach( $news_part3 as $my_post ): 
                        $video   = get_field('videos_a_la_une');
                        $video = get_field( "videos_a_la_une", $my_post->ID );
                        $img= get_the_post_thumbnail_url($my_post->ID,'full');
                        $url_externe=get_field('activer_lien_poule', $my_post->ID);
                        if($url_externe=='Activer'){ 
                            $url=get_field('lien_classement', $my_post->ID);
                        }
                        else{
                            $url=get_permalink($my_post->ID);
                        }
                        $content = $my_post->post_content;
                        $excerpt = substr($content, 0, 230);
                    ?>
                        <div class="display-news-2-col">
                            <?php if($video==null){?><a href="<?= $url; ?>" class="news-link-2-col"><?php }?>
                            <div class="news-img-2-col" style="background-image: url(<?= $img; ?>);">
                                <?php
                                    if($video!=null){
                                        $id = explode('watch?v=', $video)[1];//https://www.youtube.com/watch?v=EBmDX7MNHSI
                                        echo '<div class="video video-grande-taille">'.
                                                do_shortcode('[video_lightbox_youtube video_id="'.$id.'" width="640" height="480" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]').
                                            '</div>';
                                        echo '<div class="video video-mobile">'.
                                                do_shortcode('[video_lightbox_youtube video_id="'.$id.'" width="300" height="160" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]').
                                            '</div>';?>
                                <?php
                                    }?>
                            </div>
                            <?php if($video==null){ ?></a><?php }?>
                            <div class="nv-right-content">
                                <a href="<?= $url; ?>" class="news-link-2-col"><h3 class="nv-title-news-3-col"><?= $my_post->post_title?></h3></a>
                                <span><?php $date=get_the_date('j F Y', $my_post->ID ); echo $date; ?></span>
                                <div class="entry-content">
                                    <?php 
                                        $excerpt = get_the_excerpt($my_post->ID);
                                        echo wp_trim_words( $excerpt, 22, '  [...]' ); 
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                <?php endif; ?>        
            </div> -->
        </div>

       
        <?php 
       
// Afficher la pagination
echo paginate_links($pagination_args);
        ?>
    </section>
<script>
/****** Equal (min-height) for textes,titles, exc in inline blocs *****/
var max_heightTxt =(classes)=>{
            var max_height_txt = jQuery(classes).map(function (){return jQuery(this).height();}).get();
            minHeightTxt = Math.max.apply(null, max_height_txt);
            jQuery(classes).css( "min-height",minHeightTxt );
        }
   
        //dupliquer le code suivant ou cas de besoin d'autres element de méme hauteur !
        setTimeout(function() {
        max_heightTxt('.page-actus .news-3-2-1-col .nv-right-content');
        max_heightTxt('.page-actus .display-news-1-col .entry-content');
    }, 5);
        </script>
</main><!-- #main -->

<?php
get_sidebar();
get_footer();
