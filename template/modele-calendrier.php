<?php

/**
 * Template Name: Modèle calendrier
 */

get_header();
$titlebar   = get_field('header_de_la_page');
$title   = get_field('titre_de_la_page');
$premier_tour= get_field('1er_tour');
$quarts_de_finales= get_field('quarts_de_finale');
$final_four= get_field('final_four');
?>

<main id="primary" class="site-main ">
    <section class="listes-equipes page-calendrier">
    <h1 class="h1-equipes">Calendrier de la judo pro league</h1>
        <div>
            <h3 class="h3-calendrier">1er tour</h3>
            <div class="listes-calendrier listes-calendrier1">
                <?php foreach($premier_tour as $element_premier_tour){?>
                    <div class="listes-calendrier-element" >
                    <div class="lcel-image-haut <?php if($element_premier_tour['inactif']){echo 'evenement-inactif';} ?>"  <?php if($element_premier_tour['image_de_presentation']): echo 'style="background-image: url('.$element_premier_tour['image_de_presentation']['url'].');"'; else: echo 'style="background-color: #040a68;"'; endif;?>>
                            </div>
                        <div class="lcel-details">
                            <div class="lcel-lieu"><?php echo $element_premier_tour['lieu'];?></div>
                            <div class="lcel-details-title">
                                <div><?php echo $element_premier_tour['titre'].' - '.$element_premier_tour['poule'];?></div>
                                <div><?php echo $element_premier_tour['jour'].' '.$element_premier_tour['mois'].' 2022   - '.$element_premier_tour['horaires'];?>  </div>
                            </div>
                            
                            <?php if($element_premier_tour['lien']):?>
                                <?php if($element_premier_tour['inactif']):?>
                                    <div class="lcel-billet-termine"><a href="<?php echo $element_premier_tour['lien'];?>"   title="Voir les résultats">résultats</a></div>
                                <?php else:?>
                                    <div class="lcel-billet"><a href="<?php echo $element_premier_tour['lien'];?>" target="_blank"  title="Billetterie Réservation">réserver</a></div>
                                <?php endif;?>
                            <?php else:?>                                    
                                <div class="lcel-billet-termine"><a href="#">à venir</a></div>                              
                            <?php endif;?>
                        </div>
                    </div>
                <?php }?>
            
            </div>
        </div>
        <div>
            <h3 class="h3-calendrier">Quarts de finale</h3>
            <div class="listes-calendrier listes-calendrier2">
                <?php $i=0;foreach($quarts_de_finales as $quarts_de_finale){
                    if($i==0):echo '<div class="listes-calendrier-element"  style="grid-area: b;">';
                    else:echo '<div class="listes-calendrier-element"  style="grid-area: c;">';
                    endif;
                    ?>
                    
                        <div class="lcel-image-haut <?php if($quarts_de_finale['inactif']){echo 'evenement-inactif';} ?>" <?php if($quarts_de_finale['image_de_presentation']): echo 'style="background-image: url('.$quarts_de_finale['image_de_presentation']['url'].');"'; else: echo 'style="background-color: #040a68;"'; endif;?>>
                            
                        </div>
                        <div class="lcel-details">
                            <div class="lcel-lieu"><?php echo $quarts_de_finale['lieu'];?></div>
                            <div class="lcel-details-title">
                                <div><?php echo $quarts_de_finale['titre'];?></div>
                                <div><?php echo $quarts_de_finale['jour'].' '.$quarts_de_finale['mois'].' 2022   - '.$quarts_de_finale['horaires'];?> </div>
                            </div>
                            
                            <?php if($quarts_de_finale['lien']):?>
                                <?php if($quarts_de_finale['inactif']):?>                                    
                                    <div class="lcel-billet-termine"><a href="<?php echo $quarts_de_finale['lien'];?>"   title="Voir les résultats">résultats</a></div>
                                <?php else:?>                                    
                                    <div class="lcel-billet"><a href="<?php echo $quarts_de_finale['lien'];?>" target="_blank"  title="Billetterie Réservation">réserver</a></div>
                                <?php endif;?> 
                            <?php else:?>                                    
                                <div class="lcel-billet-termine"><a href="#">à venir</a></div>                              
                            <?php endif;?>
                        </div>
                    </div>
                <?php $i++;}?>
            </div>

        <div>
            <h3 class="h3-calendrier">Final Four</h3>
            <div class="listes-calendrier listes-calendrier3">
                <?php foreach($final_four as $ff){?>
                    <div class="listes-calendrier-element"  style="grid-area: c;">
                        <div class="lcel-image-haut <?php if($ff['inactif']){echo 'evenement-inactif';} ?>" <?php if($ff['image_de_presentation']): echo 'style="background-image: url('.$ff['image_de_presentation']['url'].');"'; else: echo 'style="background-color: #040a68;"'; endif;?>>
                            
                        </div>
                        <div class="lcel-details">
                            <div class="lcel-lieu"><?php echo $ff['lieu'];?></div>
                            <div class="lcel-details-title">
                                <div><?php echo $ff['titre'];?></div>
                                <div><?php echo $ff['jour'].' '.$ff['mois'].' 2022   - '.$ff['horaires'];?> </div>
                            </div>
                            
                            <?php if($ff['lien']):?>
                                <?php if($ff['inactif']):?>
                                    <div class="lcel-billet-termine"><a href="<?php echo $ff['lien'];?>"   title="Voir les résultats">résultats</a></div>
                                <?php else:?>                                            
                                    <div class="lcel-billet"><a href="<?php echo $ff['lien'];?>" target="_blank"  title="Billetterie Réservation">réserver</a></div>
                                <?php endif;?> 
                            <?php else:?>                                    
                                <div class="lcel-billet-termine"><a href="#">à venir</a></div>                              
                            <?php endif;?>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>
    </section>

    <?php
get_footer();
?>