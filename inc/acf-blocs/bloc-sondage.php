<?php
function bloc_sondage() {
	$afficher_le_sondage   = get_sub_field('afficher_le_sondage');
	$afficher_les_resultats   = get_sub_field('afficher_les_resultats');
    
?>
<?php if($afficher_le_sondage || $afficher_les_resultats ){?>
<section class="sondage-home" style="background-image: url(/wp-content/uploads/2024/07/sondage-Background.jpg);">
     <div class="sondage-width">

      <div id="tabs_ippons_semaine" class="tabs-ippons-semaine">
          <div class="title-tabs">
               <h2 class="title-ids">IPPON DE LA SEMAINE</h2>
               <ul class="with-border">
                    <li><a href="#vote-en-cours" class="ippon"><span class="desktop">Vote en cours</span><span class="mobile">En cours</span></a></li>
                    <li><a href="#votes-passes" class="ippon"><span class="desktop">Votes passés</span><span class="mobile">Terminés</span></a></li>
               </ul>
          </div>
          <div id="vote-en-cours">
                <?php if($afficher_le_sondage ){?>
                    <div class="jdk-sdg-w">
                         <?php echo do_shortcode('[ippons_semaine]');?>
                    </div>
               <?php }?>
          </div>
          <div id="votes-passes">
               <?php if($afficher_les_resultats ){?>
                    
                    <?php echo do_shortcode('[ippons_semaine_historique_et_vainqueur]');?>
                         
               <?php }?>
          </div>
     </div>




      
    
     </div>
</section>


  <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
  <script>
jQuery(function($) {
  $("#tabs_ippons_semaine").tabs();
});
</script>
<?php }?>
<?php
}

