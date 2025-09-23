<?php

/**
 * Template Name: Modèle module de pari (classement)
 */

function email_to_pseudo($email) {
    // Partie avant @
    $pseudo = explode('@', $email)[0];

    // Remplacer les points par des espaces
    $pseudo = str_replace('.', ' ', $pseudo);

    // Limiter à 30 caractères
    if(mb_strlen($pseudo) > 15){
        $pseudo = mb_substr($pseudo, 0, 15) . '...';
    }

    return $pseudo;
}
// À placer dans ton template de page, ou via un plugin / code snippet
if ( ! is_user_logged_in() || ! current_user_can('joueur_jpl') ) {
    wp_redirect( site_url('/judopronoschallenge/') );
    exit;
}
get_header();
 $my_user_id = get_current_user_id();
        $my_user = wp_get_current_user();

        $my_pseudo = get_field('pseudo', 'user_'.$my_user_id) ?: $my_user->display_name;
        $my_prenom = get_user_meta($my_user_id, 'first_name', true);
        $my_nom = get_user_meta($my_user_id, 'last_name', true);
        $my_email = $my_user->user_email;

        if (empty($my_prenom) && empty($my_nom)) {
            // Si vide, assigner un pseudo
            $my_pseudo = email_to_pseudo($my_pseudo);  // Mettre un pseudo par défaut si nécessaire
        }else {
            // Sinon, concaténer prénom et nom
            $my_pseudo = $my_prenom . ' ' . $my_nom;
        }
       
        $my_current_points = (int) get_field('total_de_points', 'user_' . $my_user_id);
        $my_series_jouees = (int) get_field('series_jouees', 'user_' . $my_user_id);
        $my_meilleure_serie = (int) get_field('meilleure_serie', 'user_' . $my_user_id);
        $my_paris_effectues = (int) get_field('paris_effectues', 'user_' . $my_user_id);
        $my_classement = (int) get_field('classement', 'user_' . $my_user_id);
        $my_score_exact = (int) get_field('score_exact', 'user_' . $my_user_id);
        $my_paris_gagnes = (int) get_field('paris_gagnes', 'user_' . $my_user_id);
        $my_ratio = $my_paris_effectues > 0  ? ceil($my_paris_gagnes*100 / $my_paris_effectues)  : 0;

        $avatar_id = get_field('avatar', 'user_'.$my_user_id);
        $avatar_url = ($avatar_id)?$avatar_id:"/wp-content/uploads/2025/08/user-icon.png";
?>


<div class="header-paris-mobile">
    <div class="header-box">
        <a href="/module-de-paris-home/">Accueil</a> > <?php echo get_the_title();?>
    </div>
</div>
<main id="primary" class="site-main classmt">
    <section class="listes-equipes page-calendrier">



    <div class="flex-3-pari2">
<div class="sub-menu-element round-border-purple bg-gray flex">
     <a href="/module-de-paris-home">
        <img src="/wp-content/uploads/2025/09/home.webp" width="30" class="menu-icon">
        <span>Accueil</span>
     </a>
 </div>
           <div class="sub-menu-element round-border-purple bg-gray flex">
                <a href="module-de-paris-paris">
                   <img src="/wp-content/uploads/2025/09/classer.webp" width="30" class="menu-icon">
                   <span>Mes pronos</span>
                </a>
            </div>
            <div class="sub-menu-element round-border-purple bg-gray flex">
                <a href="/module-de-paris-ligues">
                    <img src="/wp-content/uploads/2025/09/users.webp" width="30" class="menu-icon">
                    <span>Mes ligues</span>
                </a>
            </div> 
            <div class="sub-menu-element round-border-purple bg-gray flex">
                <a href="/module-de-paris-classement">
                    <img src="/wp-content/uploads/2025/09/medals.webp" width="30" class="menu-icon">
                    <span>Mon classement</span>
                </a>
            </div> 
        </div>

       <!-- Popup Joueur (masquée au départ) -->
        <div id="player-popup" class="player-popup-screen" style="display:none;">
            <div class="player-popup-content">
                <span class="player-popup-close">×</span>
                <div id="player-popup-content">
                    <!-- Contenu AJAX ici -->
                </div>
            </div>
        </div>


        <div id="tabs2" class="tabs-poules">
            <ul>
                <li><a href="#tabs-cg" class="nv-journee">Classement Général </a></li>
                <li><a href="#tabs-cpl" class="nv-journee">Classement par ligue </a></li>
                
            </ul>



            
            <div id="tabs-cg">
                <div class="">
                    <div>
                        <?php
                            
                            $all_users = $wpdb->get_results("
                                SELECT u.ID
                                FROM {$wpdb->users} u
                                INNER JOIN {$wpdb->usermeta} m1 ON u.ID = m1.user_id AND m1.meta_key = 'classement'
                                INNER JOIN {$wpdb->usermeta} m2 ON u.ID = m2.user_id AND m2.meta_key = '{$wpdb->prefix}capabilities'
                                WHERE m2.meta_value LIKE '%joueur_jpl%'
                                ORDER BY CAST(m1.meta_value AS UNSIGNED) ASC
                                LIMIT 10
                            ");
                            
                            if ( !empty($all_users) ): 
                        ?>
                        <h3 class="desktop fs-h3">Classement</h3>

                            <table id="tableau_classement_general_parieurs" class="display table-ranking">
<thead class="no-head">
  <tr>
    <th>Joueur</th>
    <th style="text-align:center;">
      <span class="desktop">Victoires / Pronos</span>
      <span class="mobile">Victoires</span>
    </th>
    <th style="text-align:center;">
      <span class="desktop">Score exact</span>
      <span class="mobile">Score</span>
    </th>
    <th style="text-align:center;">
      <span class="desktop">Meilleure série</span>
      <span class="mobile">MS</span>
    </th>
    <th style="text-align:center;">Points</th>
  </tr>
</thead>
                                <tbody>
                                <?php 
                                $is_in_table = false;

                                foreach ( $all_users as $user ):
                                    
                                    $user_id = $user->ID;
                                    $prenom  = get_user_meta($user_id, 'first_name', true);
                                    $nom     = get_user_meta($user_id, 'last_name', true);
                                    $user_data = get_user_by('id', $user_id);
                                    $pseudo = get_field('pseudo', 'user_'.$user_id) ?: $user_data->display_name;
                                    if (empty($prenom) && empty($nom)) {
                                        // Si vide, assigner un pseudo
                                        $pseudo = email_to_pseudo($pseudo);   // Mettre un pseudo par défaut si nécessaire
                                    }else {
                                        // Sinon, concaténer prénom et nom
                                        $pseudo = $prenom . ' ' . $nom;
                                    }
                                    $current_points = (int) get_field('total_de_points', 'user_' . $user_id);
                                    $score_exact = (int) get_field('score_exact', 'user_' . $user_id);
                                    $classement = (int) get_field('classement', 'user_' . $user_id);
                                    $paris_effectues = (int) get_field('paris_effectues', 'user_' . $user_id);
                                    $series_jouees = (int) get_field('series_jouees', 'user_' . $user_id);
                                    $meilleure_serie = (int) get_field('meilleure_serie', 'user_' . $user_id);
                                    $paris_gagnes = (int) get_field('paris_gagnes', 'user_' . $user_id);

                                    $ratio = $paris_effectues > 0  ? ceil($paris_gagnes *100 / $paris_effectues)  : 0;
                                    $permalink = esc_url( site_url('/module-de-paris-joueur/?user_id=' . $user_id) );

                                    $row_class = "";
                                    if ($user_id == $my_user_id) {
                                        $row_class = "my-row"; 
                                        $is_in_table = true;
                                    }
                                
                                ?>
                                    <tr class="cg-table-tr <?= $row_class; ?>">
                                        <td>
                                            <?php echo $classement.". <a href='#' class='open-player-popup' data-user-id=".$user_id.">". $pseudo."</a>";?>
                                        </td>
                                        <td style="text-align:center;">
                                            <?php echo $paris_gagnes;?>/<?php echo $paris_effectues;?> - <?php echo $ratio;?> %
                                        </td>
                                        <td style="text-align:center;">
                                            <?php echo $score_exact;?>
                                        </td>
                                        <td style="text-align:center;">
                                            <?php echo $meilleure_serie;?>
                                        </td>
                                        <td style="text-align:center;">
                                            <?php echo $current_points;?>
                                        </td>
                                    </tr>
                                <?php 
                                    
                                    endforeach; 
                                ?>
                                <?php if (!$is_in_table): 
                                    $my_permalink = esc_url( site_url('/module-de-paris-joueur/?user_id=' . $my_user_id) );
                                    ?>
                                    <tr class="cg-table-tr my-row ">
                                        <td>
                                            <?php echo $my_classement.". <a href='{$my_permalink}'>". $my_pseudo."</a>";?>
                                        </td>
                                        <td style="text-align:center;">
                                            <?php echo $my_paris_gagnes;?>/<?php echo $my_paris_effectues;?> - <?php echo $my_ratio;?> %
                                        </td>
                                        <td style="text-align:center;">
                                            <?php echo $my_score_exact;?>
                                        </td>
                                        <td style="text-align:center;">
                                            <?php echo $my_meilleure_serie;?>
                                        </td>
                                        <td style="text-align:center;">
                                            <?php echo $my_current_points;?>
                                        </td>
                                    </tr>
                            
                                <?php endif; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p>Pas de parieurs.</p>
                        <?php endif; ?>
                    </div>
                    
                </div>

                <br><br>
                
            </div>

            <div id="tabs-cpl">
                <?php
                $all_ligues = get_posts([
                    'post_type'   => 'ligue',
                    'numberposts' => -1,
                    'meta_query'  => [
                        'relation' => 'OR',
                        [
                            'key'     => 'createur',
                            'value'   => $my_user_id,
                            'compare' => 'LIKE',
                        ],
                        [
                            'key'     => 'participants',
                            'value'   => '"' . $my_user_id . '"', // important si c’est stocké en serialized array (ACF)
                            'compare' => 'LIKE',
                        ],
                    ],
                ]);


                

                if (!empty($all_ligues)) {
                
                        ?>



<div class="swiper mySwiper">
    <div class="swiper-wrapper">
        <?php foreach ($all_ligues as $ligue): 
            $nom = get_the_title($ligue->ID);
        ?>
        <div class="swiper-slide">
            <button 
            class="ligue-btn" 
            data-id="<?php echo $ligue->ID; ?>">
            <?php echo esc_html($nom); ?>
            </button>
        </div>
        <?php endforeach; ?>
    </div>


<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Init -->
<script>
  var swiper = new Swiper(".mySwiper", {
    slidesPerView: 4,   // 4 colonnes visibles
    spaceBetween: 20,   // espace entre colonnes
    slidesPerGroup: 1,  
    loop: true,        
    grabCursor: true, // curseur main sur desktop
  simulateTouch: true, // autorise le drag avec souris
  mousewheel: false, // facultatif, si tu veux scroll avec molette
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    breakpoints: {
      0: { slidesPerView: 2.5 },
      640: { slidesPerView: 5 },
      1024: { slidesPerView: 5 }
    }
  });

  
</script>

    
            <?php
                // 🔽 Contenus cachés
                echo '<div id="ligues-content">';
                foreach ($all_ligues as $ligue) {
                    $logo = get_field('logo', $ligue->ID);
                    $participants = get_field('participants', $ligue->ID) ?: [];
                     $createur_id = get_field('createur', $ligue->ID);
                    if ($createur_id && !in_array($createur_id, $participants)) {
                        array_unshift($participants, $createur_id);
                    }

                    $logo_url = $logo ? $logo['url'] : "/wp-content/uploads/2025/09/hand.png";

                    echo '<div id="ligue-'.$ligue->ID.'" class="ligue-block" style="display:none;">';
                    
                    echo '<h3 class="desktop fs-h3"> Classement '.get_the_title($ligue->ID).'</h3>';
                    
                    if (!empty($participants)) {
                        // 🔽 Construire tableau des joueurs avec stats
                        $data = [];
                        foreach ($participants as $participant_id) {
                            
                            $prenom  = get_user_meta($participant_id, 'first_name', true);
                            $nom     = get_user_meta($participant_id, 'last_name', true);
                            $user = get_user_by('id', $participant_id);
                            $pseudo = get_field('pseudo', 'user_'.$participant_id) ?: $user->display_name;
                            if (empty($prenom) && empty($nom)) {
                                // Si vide, assigner un pseudo
                                $pseudo = email_to_pseudo($pseudo);   // Mettre un pseudo par défaut si nécessaire
                            }else {
                                // Sinon, concaténer prénom et nom
                                $pseudo = $prenom . ' ' . $nom;
                            }
                            $permalink = esc_url( site_url('/module-de-paris-joueur/?user_id=' . $participant_id) );
                            $paris_gagnes = (int) get_field('paris_gagnes', 'user_' . $participant_id);
                            $paris_effectues = (int) get_field('paris_effectues', 'user_' . $participant_id);
                            $ratio = $paris_effectues > 0  ? ceil($paris_gagnes *100 / $paris_effectues)   : 0;
                            $data[] = [
                                'id'       => $participant_id,
                                'nom'      => $nom,
                                'prenom'   => $prenom,
                                'pseudo'   => $pseudo,
                                'paris_gagnes'   => $paris_gagnes,
                                'paris_effectues'   => $paris_effectues,
                                'permalink'      => $permalink,
                                'points'   => (int) get_field('total_de_points', 'user_' . $participant_id),
                                'score_exact'   => (int) get_field('score_exact', 'user_' . $participant_id),
                                'classement'   => (int) get_field('classement', 'user_' . $participant_id),
                                'ratio'   => $ratio,
                                'meilleure'=> (int) get_field('meilleure_serie', 'user_' . $participant_id),
                                'gagnes'   => (int) get_field('paris_gagnes', 'user_' . $participant_id),
                            ];
                        }

                        // 🔽 Trier par points décroissants (change "points" par ce que tu veux classer)
                        usort($data, function($a, $b) {
                            return $b['points'] <=> $a['points'];
                        });

                        echo '<table id="tableau_classement_par_ligue'.$ligue->ID.'" class="display table-ranking">';
                            echo '
                            <thead>
                              <tr>
                                <th>Rang</th>
                                <th>Joueur</th>
                                <th style="text-align:center;">
                                  <span class="desktop">Victoires / Pronos</span>
                                  <span class="mobile">Ratio</span>
                                </th>
                                <th style="text-align:center;">
                                  <span class="desktop">Score exact</span>
                                  <span class="mobile">Score</span>
                                </th>
                                <th style="text-align:center;">
                                  <span class="desktop">Meilleure série</span>
                                  <span class="mobile">MS</span>
                                </th>
                                <th style="text-align:center;">Points</th>
                              </tr>
                            </thead>
                            <tbody>';

                    $rang=1;
                        foreach ($data as $row) {
                            if ($row['id'] == $my_user_id) {
                                $row_class = "my-row"; 
                            }else{
                                $row_class = ""; 
                            }
                            echo '<tr class="cg-table-tr '.$row_class.'">';
                            echo '<td>'.$rang.'</td>';
                            echo '<td><a href="'.$row['permalink'].'">'.$row['pseudo'].'</a></td>';
                            echo '<td style="text-align:center;">'.$row['paris_gagnes'].'/'.$row['paris_effectues'].' - '.$row['ratio'].' %</td>';
                            echo '<td style="text-align:center;">'.$row['score_exact'].'</td>';
                            echo '<td style="text-align:center;">'.$row['meilleure'].'</td>';
                            echo '<td style="text-align:center;">'.$row['points'].'</td>';
                            echo '</tr>';
                            $rang+=1;
                            
                        }

                        echo '</tbody></table>';
                    } else {
                        echo '<p>Pas de parieurs.</p>';
                    }

                    echo '</div>'; // fin ligue-block
                }
                echo '</div>'; // fin ligues-content
            } else {
                echo 'Aucune ligue trouvée.';
            }
            ?>

        </div>
       
        
</div>
</div>
</section>


<style>

    .player-popup-screen {
        display: none; 
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.6);
        z-index: 10000; /* au-dessus du reste */
    }

    .player-popup-content {
        position: fixed;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        width: 90%;
        max-width: 500px;
        max-height: 80vh;
        overflow-y: auto;
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        z-index: 10001;
    }

    .player-popup-close {
        position: absolute;
        top: 10px; right: 15px;
        font-size: 22px;
        cursor: pointer;
    }
</style>

        
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
    <script>
    $( function() {
        $( "#cpl-position" ).hide();
        $( "#tabs2" ).tabs();
        // Gestion du select ligues (afficher/masquer les blocs)
        
       // Quand on clique sur un bouton dans le Swiper
        $(document).on("click", ".ligue-btn", function() {
            let ligueID = $(this).data("id");

            // cacher tous les blocs
            $(".ligue-block").hide();

            // afficher le bloc correspondant
            if (ligueID) {
                console.log("ligue choisie : " + ligueID);
                $("#ligue-" + ligueID).show();
            }
        $( "#cpl-position" ).show();
            // Optionnel : mettre le bouton actif visuellement
            $(".ligue-btn").removeClass("active");
            $(this).addClass("active");
        });


        $(document).on("click", ".open-player-popup", function(e){
            e.preventDefault();

            let user_id = $(this).data("user-id");

            $.ajax({
                url: ajaxurl, 
                method: "POST",
                data: {
                    action: "get_player_popup",
                    user_id: user_id
                },
                beforeSend: function(){
                    $("#player-popup-content").html("<p>Chargement...</p>");
                    $("#player-popup").fadeIn();
                },
                success: function(response){
                    $("#player-popup-content").html(response);
                },
                error: function(){
                    $("#player-popup-content").html("<p>Erreur de chargement</p>");
                }
            });
        });

        // Fermer seulement avec la croix
        $(document).on("click", ".player-popup-close", function(){
            $("#player-popup").fadeOut();
        });


    
  
    } );
    </script>


   

    <?php
get_footer();
?>

<div class="footer-menu-mobile-paris mobile">
    <div>
        <div class="flex-4-footer">
           
           <div class="sub-menu-element ">
                <a href="/module-de-paris-home/" class="vertical">
                    <img src="/wp-content/uploads/2025/09/home.webp" width="30" class="menu-img">
                    <span>Accueil</span>
                </a>
            </div>
            <div class="sub-menu-element ">
                <a href="/module-de-paris-paris/" class="vertical">
                    
                    <img src="/wp-content/uploads/2025/09/classer.webp" width="30" class="menu-img">
                    <span>Mes pronos</span>
                </a>
            </div> 
            <div class="sub-menu-element ">
                <a href="/module-de-paris-ligues" class="vertical">
                    <img src="/wp-content/uploads/2025/09/users.webp" width="30" class="menu-img">
                    <span>Mes ligues</span>
                </a>
            </div>
            <div class="sub-menu-element ">
                <a href="/module-de-paris-classement" class="vertical">
                    <img src="/wp-content/uploads/2025/09/medals.webp" width="30" class="menu-img">
                    <div class="champ2"><span>Classement</span></div>
                </a>
            </div>
        </div>
    </div>
</div>
