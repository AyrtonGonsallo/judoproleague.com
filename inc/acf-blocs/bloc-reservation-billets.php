<?php
function bloc_reservation() {
	$evenements_a_reserver= get_sub_field('evenements_a_reserver');
    ///$section_bg=get_sub_field('bloc_avec_couleur_de_fond');
    //var_dump($content_event);
	?>
    <section class="section-reservation">
        <div class="reservation">
            <div>
                <div class="listes-calendrier listes-calendrier4">
                    <?php foreach($evenements_a_reserver as $element_evenement_a_reserver){?>
                        <div class="listes-calendrier-element" >
                            <div class="lcel-image-haut <?php if($element_evenement_a_reserver['inactif']){echo 'evenement-inactif';} ?>"  <?php if($element_evenement_a_reserver['image_de_presentation']): echo 'style="background-image: url('.$element_evenement_a_reserver['image_de_presentation']['url'].');"'; else: echo 'style="background-color: #040a68;"'; endif;?>>
                            </div>
                            <div class="lcel-details">
                                <div class="lcel-lieu"><?php echo $element_evenement_a_reserver['lieu'];?></div>
                                <div class="lcel-details-title">
                                <div><?php echo $element_evenement_a_reserver['titre'];if($element_evenement_a_reserver['poule']){echo ' - '.$element_evenement_a_reserver['poule'];}?></div>
                                    <div><?php echo $element_evenement_a_reserver['jour'].' '.$element_evenement_a_reserver['mois'].' 2022   - '.$element_evenement_a_reserver['horaires'];?> </div>
                                </div>
                                
                                <?php if($element_evenement_a_reserver['lien']):?>
                                    <?php if($element_evenement_a_reserver['inactif']):?>
                                        <div class="lcel-billet-termine"><a href="<?php echo $element_evenement_a_reserver['lien'];?>"   title="Voir les résultats">résultats</a></div>
                                    <?php else:?>
                                        <div class="lcel-billet"><a href="<?php echo $element_evenement_a_reserver['lien'];?>" target="_blank"  title="Billetterie Réservation">réserver</a></div>
                                    <?php endif;?>
                                <?php else:?>                                    
                                    <div class="lcel-billet-termine"><a href="#">à venir</a></div>                              
                                <?php endif;?>
                            </div>
                        </div>
                        <?php }?>
                
                </div>
            </div>
        </div>
        
    </section>
<?php
}