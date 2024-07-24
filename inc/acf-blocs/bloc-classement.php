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

<section class="classmt-home"style="background-image: url(/wp-content/uploads/2024/07/classement-bg.jpg);background-size:cover;background-repeat:no-repeat; background-position:center;">

<div class="sondage-width">


   <h2 class="clssmnt-title">CLASSEMENT DE LA PHASE DE POULE</h2>

       <div class="clssmnt-content">
           <!-- <div class="clssmnt-div-ttl"> <h3 class="clssmnt-h3">Poules</h3></div> -->
<?php for ($i1 = 1; $i1 <= 10; $i1++) {
                    }
                    ?>

           <?php $i=0;
                                foreach ($classement_equipes as $d){ 
                                if($i>=5){
                                    continue;
                                }
                            ?>
              <div class="col-d-v-pts">
                    <div class="clss-eq"> 
                    
                        <img src="<?php echo $d[0]['image'];?>" alt="<?php echo $d[0]['image'];?>">
                        <?php echo $i1 . "-" .$d[0]['nom'];?>
                    </div>

                    <span class="left"><?php echo ($d[0]['defaites'])?$d[0]['defaites']:0?> D</span>
                    <span class="left"><?php echo ($d[0]['victoires'])?$d[0]['victoires']:0?> V</span>
                    <span class="left"><?php echo $d[0]['points_marqués'];?> Pts</span>


              </div>
              <?php 
                $i+=1;
                    }
                ?>


       </div>
         <a href="https://www.rimo0631.odns.fr/tableau-principal-judo-pro-league-2023/" class="btn-classmnt center">Classement complet</a>



</div>

</section>
