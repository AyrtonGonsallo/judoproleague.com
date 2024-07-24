	

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
?>

<?php 
   // $rencontres=get_posts($args);
    $now=date('Y/m/d H:i:s');
?>




<section class="section-side-rencontres" >
    <a href="/calendrier-resultat-judo-pro-league-2024" class="btn-classmnt center">Nos rencontres</a>
    <div class="section-header" style="">
    
        <div class="" style="">
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
                        $lien2=null;
                        $icone_status='icon-rencontre-encours-1.png';
                    }else if($statut=='terminé'){
                        $status='terminé';
                        $lien=get_the_permalink($rencontre->ID);
                        $lien2=null;
                        $icone_status='icon-rencontre-termine-1.png';
                        /*if((strtotime($now)-strtotime($date_fin))>=86400){
                            continue;
                        }*/
                    }
                    else if($statut=="à venir"){
                        $status='à venir';
                        $icone_status='icon-rencontre-a-venir.png';
                        $lien=get_the_permalink($rencontre->ID);
                        $lien2=get_field('lien_de_reservation', $rencontre->ID);
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
                                    <div>
                                    <span class="nv-score">
                                        <?php echo (($status!='à venir')?$score_equipe1:(substr($date_debut,8,2).'/'.substr($date_debut,5,2)));?>
                                    </span>
                                    -
                                    <span class="nv-score">
                                        <?php echo (($status!='à venir')?$score_equipe2:(substr($date_debut,8,2).'/'.substr($date_debut,5,2)));?>
                                    </span>
                                </div>
                                <?php } else{?>
                                    <?php echo '<div>'.substr($date_debut,11,5).'</div>';?>

                                <?php }?>
                                
                                <img src="<?php echo $image2_url; ?>" class="nv-img">
                                <span class="nv-name">
                                    <?php echo $abreviation2;?>
                                </span>
                            </div>
                            <div class="side-rencontres-details">
                                <div>
                                    <span>
                                        <?php echo get_field('phase', $rencontre->ID)[0]->post_title.' '.get_field('journee', $rencontre->ID); ?>
                                    </span>
                                </div>
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
                            <?php if($lien2){
                                echo '<div class="brd-sep"></div>';
                                echo '<a href="'.$lien2.'" target="_blank" class="nv-all-info">Billetterie</a>';
                            }?>
                        </div>
                    </div>
                </li>
                <?php 
                $last_date_rencontre=$date_rencontre;
                        endforeach ?>
                
                <a href="calendrier-resultat-judo-pro-league-2024/"  class="but-vid-hm"> Voir toutes les rencontres <i class="fa-solid fa-arrow-right-long"></i></a>

                
            </ul>
        </div>
        <div>       
            
        </div>

    </div>

</section>
