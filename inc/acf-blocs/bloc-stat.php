<?php 
$saison_value="2023-2024";
$args=array(
    'post_type'=> 'rencontre',
    'posts_per_page' => -1,
    'meta_query'     => 
    array(  
        array(
            'key'        => 'saisons',
            'compare'    => 'LIKE',
            'value'      => $saison_value
        )
    ),		
    'meta_key' => 'date_de_debut',
    'orderby' => 'meta_value_num',
    'order' => 'DESC',  
);
$rencontres=get_posts($args);
require_once (THEMEDIR.'template-parts/content-judokas-requests-stats-home.php');
$classement_equipes=get_classement($rencontres,$saison_value,5);
   //var_dump($classement);exit(-1);
   $classement_judokas=get_classement_judokas_home($saison_value,5)['total'];
       //var_dump($classement_judokas);exit(-1);      
                
?>


<section class="stat-home" style="background-image: url(/wp-content/uploads/2024/07/statistiques-bg.jpg);background-size:cover;background-repeat:no-repeat; background-position:center;">
 <div class="sondage-width">
    <h2 class="stat-title">STATISTIQUES</h2>
     <div class="bg-stat">
        <div class="col1-stat">
            <h3 class="">ÉQUIPES</h3>
            
            <div class="flx-col1"><h4 class="">NOMBRE DE PTS MARQUÉS</h4> <h4 class="">IPPONS</h4></div>
                <div class="col-flx-stat">
                
                <h4 class="mobile-h4">NOMBRE DE PTS MARQUÉS</h4>
                        <div class="col-nbr-pnt">
                            <?php $i=0;
                                foreach ($classement_equipes as $d){ 
                                if($i>=5){
                                    continue;
                                }
                            ?>
                                <div class="div-eq <?php if($i==0){echo "premier";}?>">
                                    <div class="titre-eq">
                                        <?php echo $d[0]['nom'];?>
                                    </div>
                                    <div class="div-content-eq"> 
                                        <div class="div-num-conf">
                                            <img src="<?php echo $d[0]['image'];?>" alt="<?php echo $d[0]['image'];?>">
                                            <span class="conf-premier"><?php echo $d[0]['conference'];?></span>
                                            <span class="nom-premier"><?php echo $d[0]['nom'];?></span>
                                        </div>
                                        <span class="num-eq"><?php echo $d[0]['points_marqués'];?></span>
                                    </div>
                                </div>
                            <?php $i+=1; } ?>
                        </div>  
                        <h4 class="mobile-h4">IPPONS</h4>
                        <div class="col-nbr-ipp-eq">
                            <?php $i=0;
                                foreach ($classement_equipes as $d){ 
                                if($i>=5){
                                    continue;
                                }
                            ?>
                                <div class="div-eq <?php if($i==0){echo "premier";}?>">
                                    <div class="titre-eq">
                                        <?php echo $d[0]['nom'];?>
                                    </div>
                                    <div class="div-content-eq">  
                                        <div class="div-num-conf">
                                            <img src="<?php echo $d[0]['image'];?>" alt="<?php echo $d[0]['image'];?>">
                                            <span class="conf-premier"><?php echo $d[0]['conference'];?></span><span class="nom-premier"><?php echo $d[0]['nom'];?></span>
                                        </div>
                                        <span class="num-eq"><?php echo $d[0]['ippons_marqués'];?></span>
                                    </div>
                                </div>
                            <?php $i+=1; } ?>
                        </div> 
                </div>
              
        </div>
        <div class="col2-stat">
        <h3 class="">JUDOKAS</h3>
            <div class="flx-col2"><h4 class="">VICTOIRES</h4> <h4 class="">IPPONS</h4></div>
              <div class="col-flx-stat">
              <h4 class="mobile-h4">VICTOIRES</h4>
                    <div class="col-nbr-pnt">
                        <?php $i=0;
                            foreach ($classement_judokas as $d){
                        ?>
                        <div class="div-eq <?php if($i==0){echo "premier";}?>">
                            <div class="titre-eq">
                               <?php echo $d[0]['nom'];?><br>
                            </div>
                                <div class="div-content-eq">
                                    <div class="div-num-conf">
                                         <img src="<?php echo $d[0]['image'];?>" alt="<?php echo $d[0]['image'];?>">
                                         <span class="conf-premier">
                                            Age: <?php echo ($d[0]['age'])?$d[0]['age']:0?><br>
                                            Poids: <?php echo ($d[0]['categorie_de_poids'])?$d[0]['categorie_de_poids']:""?><br>
                                         </span>
                                        <span class="nom-premier"><?php echo $d[0]['nom'];?></span>
                                     </div>
                                        <span class="num-eq"><?php echo ($d[0]['matchs_v'])?$d[0]['matchs_v']:0?></span>
                                </div>
                        </div>
                        <?php $i+=1; } ?>
                    </div>

                    <h4 class="mobile-h4">IPPONS</h4>
                     <div class="col-nbr-ipp-jdk">
                     <?php $i=0;
                            foreach ($classement_judokas as $d){
                        ?>
                        <div class="div-eq <?php if($i==0){echo "premier";}?>">
                                <div class="titre-eq">
                                   <?php echo $d[0]['nom'];?><br>
                                </div>
                                <div class="div-content-eq">
                                    <div class="div-num-conf">
                                        <img src="<?php echo $d[0]['image'];?>" alt="<?php echo $d[0]['image'];?>">
                                        <span class="conf-premier">
                                           Age: <?php echo ($d[0]['age'])?$d[0]['age']:0?><br>
                                           Poids: <?php echo ($d[0]['categorie_de_poids'])?$d[0]['categorie_de_poids']:""?><br>
                                        </span>
                                        <span class="nom-premier"><?php echo $d[0]['nom'];?></span>
                                    </div>
                                    <span class="num-eq"><?php echo ($d[0]['ippons_marqués'])?$d[0]['ippons_marqués']:0?></span>
                                </div>
                        </div>
                        <?php $i+=1; } ?>
                     </div>
                     
                </div>

        </div>
    </div>

          <a href="/statistiques-equipes-judo-pro-league-2023/" class="btn-stat center">Voir toutes les statistiques</a>

 </div>
</section>
