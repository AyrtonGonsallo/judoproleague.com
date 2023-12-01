<?php
function bloc_une() {
	$news   = get_sub_field('article');
	$i=0;
?>

<section class="section-a-la-une">
        <div class="cta-txt">
        <?php 
                if( $news ): 
            ?>
                <?php 
                    foreach( $news as $my_post ):						
						$i=$i+1;
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
                    <div style="" class="slide mobile<?= $i;?>">
                        <a href="<?= $url; ?>" class="news-link"><h3 class="title-news-3-col">
                            <div class="img-une" style="background-image: url(<?= $img; ?>);">
                                <?php
                                    if($video!=null){
                                        $id = explode('watch?v=', $video)[1];//https://www.youtube.com/watch?v=EBmDX7MNHSI
                                        echo '<div class="video la-une video-grande-taille">'.
                                            do_shortcode('[video_lightbox_youtube video_id="'.$id.'" width="640" height="480" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]').
                                        '</div>';
                                                    echo '<div class="video la-une video-mobile">'.
                                            do_shortcode('[video_lightbox_youtube video_id="'.$id.'" width="300" height="160" anchor="'.get_site_url().'/wp-content/uploads/2022/11/play.webp"]').
                                        '</div>';?>
                                
                                    <?php
                                    }
                                ?>
                            </div>
                        </a>
                        <?php
                        if($video==null){?>
                            <div class="news-content">
                                <span class="nv-date"><?php $date=get_the_date('j F Y', $my_post->ID ); echo $date; ?></span>
                                <a href="<?= $url; ?>" class="news-link"><h3 class="nv-title-news-2-col"><?= $my_post->post_title?></h3></a>
                            </div>
                        <?php }?>
                        <?php
                        if($video!=null){?>
                            <div class="news-content">
                                <span class="nv-date"><?php $date=get_the_date('j F Y', $my_post->ID ); echo $date; ?></span>
                                <h3 class="nv-title-news-2-col video-grande-taille">
                                 <?php echo do_shortcode('[video_lightbox_youtube video_id="'.$id.'" width="640" height="480" anchor="'.$my_post->post_title.'"]');?>
                                </h3>
                                <h3 class="nv-title-news-2-col video-mobile">
                                 <?php echo do_shortcode('[video_lightbox_youtube video_id="'.$id.'" width="300" height="160" anchor="'.$my_post->post_title.'"]');?>
                                </h3>
                            </div>
                        <?php }?>
                    </div>
                <?php
			endforeach; ?>
            <?php endif; ?>        
        </div>
</section>

<?php
}