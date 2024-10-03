<?php 
$saison_value="2024-2025";
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
$classement_equipes=get_classement($rencontres,$saison_value,50);
   //var_dump($classement);exit(-1);
   $classement_judokas=get_classement_judokas_home($saison_value,5)['total'];
       //var_dump($classement_judokas);exit(-1);      
                
?>

<section class="classmt-home"style="background-image: url(/wp-content/uploads/2024/07/classement-bg.jpg);background-size:cover;background-repeat:no-repeat; background-position:center;">

<div class="sondage-width">


   <h2 class="clssmnt-title">CLASSEMENT DE LA PHASE DE POULE</h2>

   <div class="clssmnt-content">
    <?php 
    $i = 0;
    foreach ($classement_equipes as $d) { 
        $isHidden = $i >= 5 ? 'style="display:none;"' : ''; // Cacher les éléments au-delà des 5 premiers
    ?>
    <div class="col-d-v-pts" <?php echo $isHidden; ?> id="item-<?php echo $i; ?>">
        <div class="clss-eq"> 
            <span><?php echo ($i + 1) ;?></span>
            <img src="<?php echo $d[0]['image'];?>" alt="<?php echo $d[0]['image'];?>">
            <?php echo $d[0]['nom'];?>
        </div>
        <span class="left"><?php echo ($d[0]['victoires']) ? $d[0]['victoires'] : 0; ?> V</span>
        <span class="left"><?php echo ($d[0]['defaites']) ? $d[0]['defaites'] : 0; ?> D</span>
        
        <span class="left"><?php echo $d[0]['points_marqués']; ?> Pts</span>
    </div>
    <?php 
        $i++;
    } 
    ?>

   <!-- Bouton avec icône pour afficher/masquer les éléments -->
   <button id="toggle-items" onclick="toggleItems()" style="background-color: #D015A0; color: white; border: none; padding: 10px; cursor: pointer;">
        <i id="toggle-icon" class="fa-solid fa-chevron-down"></i>
    </button>
</div>


<script>
function toggleItems() {
    var totalItems = <?php echo count($classement_equipes); ?>;
    var isHidden = document.getElementById('item-5').style.display === 'none';

    var content = document.querySelector('.clssmnt-content'); // Select the container

    if (isHidden) {
        // Show all hidden items and add slide-in class
        for (var i = 5; i < totalItems; i++) {
            document.getElementById('item-' + i).style.display = 'grid';
        }
        content.classList.add('slide-in');
    } else {
        // Hide all items and remove slide-in class
        for (var i = 5; i < totalItems; i++) {
            document.getElementById('item-' + i).style.display = 'none';
        }
        content.classList.remove('slide-in');
    }

    // Change the arrow icon based on the state
    var toggleIcon = document.getElementById('toggle-icon');
    toggleIcon.className = isHidden ? 'fa-solid fa-chevron-up' : 'fa-solid fa-chevron-down';
}
</script>



         <!-- <a href="https://www.rimo0631.odns.fr/tableau-principal-judo-pro-league-2023/" class="btn-classmnt center">Classement complet</a> -->



</div>

</section>
