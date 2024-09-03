	

<?php date_default_timezone_set('Africa/Porto-Novo'); 
setlocale(LC_TIME, 'fr_FR.UTF-8')
?>
<?php $niveaux_a_afficher=get_field('niveaux_a_afficher','widget_gestionnaire_rencontres_widget-2'); ?>
<?php 
$rencontres=array();
if( have_rows('rencontres_a_afficher','widget_gestionnaire_rencontres_widget-2') ){
    while ( have_rows('rencontres_a_afficher','widget_gestionnaire_rencontres_widget-2') ) : the_row();
    $rencontre = get_sub_field('rencontre');
    $rencontres=array_merge($rencontres,$rencontre);
    endwhile;
}

$args_articles=array(
	'post_type'=> 'post',
	'posts_per_page' => 9,
	'orderby' => 'post_date', 
	'order' => 'DESC',
);
$news=get_posts($args_articles);
$news_part1=array_slice($news,0,3);
$news_part2=array_slice($news,3,2);
?>

<?php 
   // $rencontres=get_posts($args);
    $now=date('Y/m/d H:i:s');
?>




<section class="section-side-rencontres" >
    <div class="section-header" style="">
    
        <div class="col-rcntr" style="">
            <h3 class="title-rcntr">LES RENCONTRES</h3>
            
            <?php 
        // Extraire les informations de la première rencontre
        if (!empty($rencontres)) {
            $premiere_rencontre = $rencontres[0];
            $journee = get_field('phase', $premiere_rencontre->ID)[0]->post_title . ' ' . get_field('journee', $premiere_rencontre->ID);
            // Afficher la journée une seule fois ici
            echo '<div class="journee-div">';
            echo '<span>' . $journee . '</span>';
            echo '</div>';
        }
             ?>
        <ul class="sides-rencontres-grid">
            <?php 
                $last_date_rencontre="";
                foreach ($rencontres as $rencontre):
                    $combat=get_field('les_combat', $rencontre->ID)[0];
                    $equipe1 =get_field('equipe_1', $rencontre->ID)[0];
                    $equipe2 =get_field('equipe_2', $rencontre->ID)[0];
                    $score_equipe1 =$combat['nombre_de_combat_gagne_equipe_1'][0];
                    $image1_url=(get_field('logo_miniature', $equipe1->ID))?get_field('logo_miniature', $equipe1->ID):get_the_post_thumbnail_url($equipe1->ID);
                    $image2_url=(get_field('logo_miniature', $equipe2->ID))?get_field('logo_miniature', $equipe2->ID):get_the_post_thumbnail_url($equipe2->ID);
                    $score_equipe2 =$combat['nombre_de_combat_gagne_equipe_2'][0];
                    $date_debut=get_field('date_de_debut', $rencontre->ID, false, false);
                    $date_fin=get_field('date_de_fin', $rencontre->ID, false, false);
                    $statut=get_field('statut', $rencontre->ID)['label'];
                    $abreviation1=(get_field('abreviation', $equipe1->ID))?get_field('abreviation', $equipe1->ID):substr($equipe1->post_title,0,4);
                    $abreviation2=(get_field('abreviation', $equipe2->ID))?get_field('abreviation', $equipe2->ID):substr($equipe2->post_title,0,4);
                    $matchs_liste=get_field('les_combat',$rencontre->ID);
                    $niveau=(get_field('niveau', $rencontre->ID));
                    $date_rencontre=(strftime('%A %d %B %Y',strtotime(get_field('date_de_debut', $rencontre->ID, false, false))));
                    $equipe_gagnante = $matchs_liste[0]['equipe_gagnante'];
                    
                    if($statut=='en cours'){
                        $status='en cours';
                        $lien=get_the_permalink($rencontre->ID);
                        $lien_live=get_field('video_live', $rencontre->ID);
                        $lien_billets=null;
                        $icone_status='icon-rencontre-encours-1.png';
                    }else if($statut=='terminé'){
                        $status='terminé';
                        $lien=get_the_permalink($rencontre->ID);
                        $lien_billets=null;
                        $lien_live=null;
                        $icone_status='icon-rencontre-termine-1.png';
                        /*if((strtotime($now)-strtotime($date_fin))>=86400){
                            continue;
                        }*/
                    }
                    else if($statut=="à venir"){
                        $status='à venir';
                        $icone_status='icon-rencontre-a-venir.png';
                        $lien=get_the_permalink($rencontre->ID);
                        $lien_live=null;
                        $lien_billets=get_field('lien_de_reservation', $rencontre->ID);
                    }
                    //var_dump($equipe1);exit(-1);
                    $nouvelledate=($last_date_rencontre!=$date_rencontre);
                   
                
                ?>
              
                <li class="side-rencontre-card <?php echo ($nouvelledate)?'first-mb':'mb';?>  flip-card splide__slide" >
                    <?php if($nouvelledate){?>
                        <div class="side-rencontre-date"><?php echo $date_rencontre;?></div>
                    <?php }?>
                    
                    <div class="flip-card-inner side-rencontre-mb-20">
                                
                        <div class="side-rencontres-flip-card-front">
                               
                            <div class="side-rencontres-affiche" >
                                <span class="nv-name">
                                    <?php echo $abreviation1;?>
                                </span>
                                <img src="<?php echo $image1_url; ?>" class="nv-img">
                                <?php if (($status!='à venir')){?>
                                    <div class="rcntr-score">
                                    <span class="nv-score">
                                        <?php echo (($status!='à venir')?$score_equipe1:(substr($date_debut,8,2).'/'.substr($date_debut,5,2)));?>
                                    </span>
                                    -
                                    <span class="nv-score">
                                        <?php echo (($status!='à venir')?$score_equipe2:(substr($date_debut,8,2).'/'.substr($date_debut,5,2)));?>
                                    </span>
                                </div>
                                <?php } else{?>
                                    <?php echo '<div class="nv-time">'.substr($date_debut,11,5).'</div>';?>

                                <?php }?>
                                
                                <img src="<?php echo $image2_url; ?>" class="nv-img">
                                <span class="nv-name">
                                    <?php echo $abreviation2;?>
                                </span>
                            </div>
                            <div class="side-rencontres-details">
                            <!-- <div class="journee-div">
                                    <span>
                                      <?php echo get_field('phase', $rencontre->ID)[0]->post_title.' '.get_field('journee', $rencontre->ID); ?>
                                    </span>
                                </div> -->
                                <div>
                                    <span class="nv-staut"> 
                                        <img src="/wp-content/uploads/2023/07/<?php echo $icone_status;?>" class="side-rencontres-img-statut">
                                        <?php echo $status ;?> 
                                        
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="side-rencontres-flip-card-back">
                        <a href="<?php echo $lien;?>" class="nv-all-info">Toutes les infos</a>
                            <?php if($lien_billets){
                                echo '<div class="brd-sep"></div>';
                                echo '<a href="'.$lien_billets.'" target="_blank" class="nv-all-info">Billetterie</a>';
                            }?>
                            <?php if($lien_live){
                                echo '<div class="brd-sep"></div>';
                                echo '<a href="'.$lien_live.'" target="_blank" class="nv-all-info">Suivre le live</a>';
                            }?>
                        </div>
                    </div>
                </li>
                <?php 
                $last_date_rencontre=$date_rencontre;
                        endforeach ?>
                
                <a href="calendrier-resultat-judo-pro-league-2024/"  class="but-rnctr-hm"> Voir toutes les rencontres <i class="fa-solid fa-arrow-right-long"></i></a>

                
            </ul>
        </div>


       <div class="col-actus">
          <div class="flx-tle-but">
                <h2 class="home-articles-title">NOS DERNIÈRES ACTUALITÉS</h2>

                <a href="/actualites-judo-pro-league/" class="but-home-articles">Toutes les actualités <i class="fa-solid fa-arrow-right-long"></i></a>
           </div>



            <div class="news-1-2-3-col">
                <?php if( $news_part1 ): 
                $i=1;
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
                    <?php if($i==1){?>
                        <div class="news-1-2-3-part1">
                    <?php }?>
                    <?php if($i==3){?>
                        <div class="news-1-2-3-part2">
                    <?php }?>
                        <div class="display-home-news-2-col">
                            <?php if($video==null){?><a href="<?= $url; ?>" class="news-link-2-col"><?php }?>
                            <div class="news-img-2-col img-min-h <?php echo $i;?>" style="background-image: url(<?= $img; ?>); <?php if($i==3){echo "min-height: 477px;";}?>">

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
                            <div class="nv-right-content">
                                <a href="<?= $url; ?>" class="news-link-2-col"><h3 class="nv-title-news-3-col"><?= $my_post->post_title?></h3></a>
                                
                            </div>
                        </div>
                        <?php if($i==2 || $i==3){?>
                        </div>
                    <?php }?>
                    <?php $i+=1;
                endforeach; ?>
                <?php endif; ?>        
            </div>
            <div class="news-3-col">
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
                        <div class="display-home-news-2-col">
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
                            <div class="nv-right-content">
                                <a href="<?= $url; ?>" class="news-link-2-col"><h3 class="nv-title-news-3-col"><?= $my_post->post_title?></h3></a>
                                
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>        
            </div>
        
<a href="/actualites-judo-pro-league/" class="btn-presenta btn-mobile center">En savoir plus</a>





</div>









      </div>
    </div>
</section>




	
