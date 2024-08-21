<?php
function bloc_articles() {
    $news   = get_sub_field('articles');
    //var_dump($news);exit();
    ?>
    <section class="section-articles">
        <div class="news-3-col">
        <?php 
                if( $news ): 
            ?>
                <?php 
                    foreach( $news as $my_post ): 
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
                    <div class="display-news-3-col">
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
								}
							?>
						</div>
						<?php if($video==null){ ?></a><?php }?>
                        <div class="news-content">
                            <span><?php $date=get_the_date('j F Y', $my_post->ID ); echo $date; ?></span>
                            <a href="<?= $url; ?>" class="news-link-2-col"><h3 class="title-news-3-col"><?= $my_post->post_title?></h3></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>        
        </div>
        <a href="/actualites-judo-pro-league/" class="more-actu">Toutes les actualités <i class="fa-solid fa-arrow-right-long"></i></a>
    </section>
<?php
}
