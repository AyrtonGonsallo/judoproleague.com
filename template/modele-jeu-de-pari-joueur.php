<?php

/**
 * Template Name: Modèle module de pari (Page Profil Utilisateur)
 */

// À placer dans ton template de page, ou via un plugin / code snippet
if ( ! is_user_logged_in() || ! current_user_can('joueur_jpl') ) {
    wp_redirect( site_url('/judopronoschallenge/') );
    exit;
}

get_header();

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
?>


<div class="header-paris-mobile">
    <div class="header-box">
        <a href="/module-de-paris-home/">Accueil</a> > <?php echo get_the_title();?>
    </div>
</div>
<main id="primary" class="site-main ">
    <section class="listes-equipes page-calendrier">

        <?
            $user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

            $user = wp_get_current_user();

            $pseudo = get_field('pseudo', 'user_'.$user_id) ?: $user->display_name;
            $prenom = get_user_meta($user_id, 'first_name', true);
            $nom = get_user_meta($user_id, 'last_name', true);
            if (empty($prenom) && empty($nom)) {
                // Si vide, assigner un pseudo
                $pseudo = email_to_pseudo($pseudo);   // Mettre un pseudo par défaut si nécessaire
            }else {
                // Sinon, concaténer prénom et nom
                $pseudo = $prenom . ' ' . $nom;
            }
            $avatar_id = get_field('avatar', 'user_'.$user_id);
            $avatar_url = ($avatar_id)?$avatar_id:"/wp-content/uploads/2025/08/user-icon.png";

            $score_exact = (int) get_field('score_exact', 'user_' . $user_id);
            $serie_en_cours = (int) get_field('serie_en_cours', 'user_' . $user_id);
            $meilleure_serie = (int) get_field('meilleure_serie', 'user_' . $user_id);
            $classement = (int) get_field('classement', 'user_' . $user_id);
            $paris_effectues = (int) get_field('paris_effectues', 'user_' . $user_id);
            $paris_gagnes = (int) get_field('paris_gagnes', 'user_' . $user_id);
            $total_de_points = (int) get_field('total_de_points', 'user_' . $user_id);
            $ratio = $paris_effectues > 0  ? ceil($paris_gagnes *100/ $paris_effectues)   : 0;

             // 1️⃣ Récupérer les paris existants de l'utilisateur
            $paris_finis = get_posts([
                'post_type'      => 'pari',
                'posts_per_page' => -1,
                 'meta_key'       => 'date',
                'orderby'        => 'meta_value',
                'order'          => 'ASC',
                'meta_query'     => [
                'relation' => 'AND',
                    [
                        'key'     => 'user',
                        'value'   => $user_id,
                        'compare' => '=',
                    ],
                    [
                        'key'     => 'status',
                        'value'   => 'termine',
                        'compare' => '=',
                    ]
                ]
            ]);
        ?>

            
        

    <div class="flex-3-pari2">
           <div class="sub-menu-element round-border-purple bg-gray">
                <a href="module-de-paris-paris">
                    <span>Mes paris</span>
                    <img src="/wp-content/uploads/2025/09/paris-pic.png" class="img-30">
                </a>
            </div>
            <div class="sub-menu-element round-border-purple bg-gray">
                <a href="/module-de-paris-ligues">
                    <span>Mes ligues</span>
                    <img src="/wp-content/uploads/2025/09/hand.png" class="img-30">
                </a>
            </div> 
            <div class="sub-menu-element round-border-purple bg-gray">
                <a href="/module-de-paris-classement">
                    <span>Mon classement</span>
                    <img src="/wp-content/uploads/2025/09/cup.png" class="img-30">
                </a>
            </div> 
        </div>

        <div class="divider"></div>
        <h1>Profil de <?php echo ($pseudo); ?></h1>
        <p>Points : <?php echo $total_de_points; ?></p>
        <p>Classement : <?php echo $classement; ?></p>
        <p>Paris éffectués : <?php echo $paris_effectues; ?></p>
        <p>Paris gagnés : <?php echo $paris_gagnes; ?></p>
        <p>Ratio : <?php echo $ratio; ?> %</p>
        <p>Série en cours : <?php echo $meilleure_serie; ?></p>
        <p>Score exacts : <?php echo $score_exact; ?></p>



        
<div class="liste-paris">
   

    <?php 
    // Initialiser les limites de bonus
    $bonus_max = ['x2'=>2, 'x3'=>1, 'joker'=>1];
    // Compter combien ont été utilisés
    $bonus_utilises = ['x2'=>0, 'x3'=>0, 'joker'=>0];

      // Comptage des bonus déjà appliqués sur tous les pronos  
    foreach ($paris_finis as $pari_fini) {
        $bonus_applique = get_field('bonus_applique', $pari_fini->ID);
        if ($bonus_applique && isset($bonus_utilises[$bonus_applique])) {
            $bonus_utilises[$bonus_applique]++;
        }
    }

    // Calculer les bonus restants
    $bonus_restants = [];
    foreach ($bonus_max as $type => $max) {
        $bonus_restants[$type] = $max - ($bonus_utilises[$type] ?? 0);
    }
    
                foreach ($paris_finis as $pari_fini):
                    $rencontre=get_field('rencontre', $pari_fini->ID)[0];
                    $rencontre_id=$rencontre->ID;
                    $equipe1 =get_field('equipe_1', $rencontre_id)[0];
                    $lien_direct = get_the_permalink($rencontre_id);
                    $equipe2 =get_field('equipe_2', $rencontre_id)[0];
                    $score_equipe1 = get_field('score_equipe_1', $pari_fini->ID);
                    $score_final_equipe_1 = get_field('score_final_equipe_1', $pari_fini->ID);
                    $image1_url=(get_field('logo_miniature', $equipe1->ID))?get_field('logo_miniature', $equipe1->ID):get_the_post_thumbnail_url($equipe1->ID);
                    $image2_url=(get_field('logo_miniature', $equipe2->ID))?get_field('logo_miniature', $equipe2->ID):get_the_post_thumbnail_url($equipe2->ID);
                    $score_equipe2 =get_field('score_equipe_2', $pari_fini->ID);
                    $score_final_equipe_2 =get_field('score_final_equipe_2', $pari_fini->ID);
                    $bonus_applique = get_field('bonus_applique', $pari_fini->ID);
                    $vainqueur  = get_field('vainqueur', $pari_fini->ID);
                    $resultats  = get_field('resultats', $pari_fini->ID);
                    $points_obtenus  = get_field('points_obtenus', $pari_fini->ID);
                    $class = ''; // valeur par défaut
                    $class_etat = '';
                    $res_text = '';
                    switch($resultats) {
                        case 'score_et_vainqueur_juste':
                        case 'score_juste':
                        case 'vainqueur_juste':
                            $class = 'paris-vert'; // succès → vert
                            $class_etat='status-paris-gagne'; 
                            $res_text = 'Gagné';
                            break;
                        case 'tout_perdu':
                            $class = 'paris-rouge'; // perdu → rouge
                            $class_etat='status-paris-perdu'; 
                            $res_text = 'Perdu';
                            break;
                        case 'pas_joue':
                        default:
                            $class = 'paris-neutre'; // pas joué ou autre
                            break;
                    }
                    $date_debut=get_field('date_de_debut', $rencontre->ID, false, false);
                     $debut = new DateTime($date_debut, wp_timezone());
                    $date_debut_string = date_i18n('d F Y \à H\h', $debut->getTimestamp());
                    $statut=get_field('status', $pari_fini->ID);
                    $temps_restant = "Terminé";
                    
            ?>
            <div class="pari update-pari <?php echo $class;?>" data-rencontre-id="<?php echo $rencontre_id; ?>"  data-limits='<?php echo json_encode($bonus_restants); ?>'>
        <div class="infos-pari">
            <div class="date-time-pari">
            <?php echo ($date_debut_string); ?>
            </div>
<!-- <div class="temps-restant-pari"> <div class="live-pari"><a href="<?php echo $lien_direct;?>">Résultats rencontre</a></div></div>-->
        </div>

    <div class="grid-3-pari">
        <!-- Équipe 1 -->
       

        <div class="equipe-box">
            <div class="not_checkable_equipe equipe <?php 
                if($vainqueur == 'equipe1'){
                    if ($resultats=='vainqueur_juste' || $resultats=='score_et_vainqueur_juste') {
                        echo 'selected-won';
                    }else {
                        echo 'selected-lost';
                    }
                }
            ?>" data-vainqueur="equipe1">
                <div class="image-equipe-pari" 
                style="background-image:url(<?php echo $image1_url;?>)" >
                </div>
                <div class="title-team-pari"><?php echo get_the_title($equipe1->ID ); ?></div>
            </div>
        </div>

        <div class="grid-5-1-pari">
<div>
            <div class="my-score-equipe <?php 
                if ($vainqueur == 'equipe1') {
                    if (($score_final_equipe_1 == $score_equipe1) && ($score_final_equipe_2 == $score_equipe2)) {
                        echo 'score-won';
                    } else {
                        echo 'score-lost';
                    }
                }
            ?>">
                <input type="number" 
                       value="<?php echo $score_equipe1 ; ?>" readonly>
            </div>
            <div class="pari-score-equipe">
                <input type="number" 
                       value="<?php echo $score_final_equipe_1; ?>" readonly>
            </div>
</div>
            <div class="score-separator-container">
                <div class="score-separator-div">
                
                </div>
            </div>
            <div>

            <div class="my-score-equipe <?php 
                if ($vainqueur == 'equipe2') {
                    if (($score_final_equipe_1 == $score_equipe1) && ($score_final_equipe_2 == $score_equipe2)) {
                        echo 'score-won';
                    } else {
                        echo 'score-lost';
                    }
                }
            ?>">
                <input type="number" 
                       value="<?php echo $score_equipe2 ; ?>" readonly>
            </div>
            <div class="pari-score-equipe">
               <input type="number"
                value="<?php echo $score_final_equipe_2; ?>" readonly>
            </div>
</div>
        </div>

        <!-- Équipe 2 -->
        <div class="equipe-box">
            <div class="not_checkable_equipe equipe <?php 
                if($vainqueur == 'equipe2'){
                    if ($resultats=='vainqueur_juste' || $resultats=='score_et_vainqueur_juste') {
                        echo 'selected-won';
                    }else {
                        echo 'selected-lost';
                    }
                }
            ?>" data-vainqueur="equipe2">
                <div class="image-equipe-pari" 
                style="background-image:url(<?php echo $image2_url;?>)" >
                </div>
                <div class="title-team-pari"><?php echo get_the_title($equipe2->ID ); ?></div>
            </div>
        </div>
    </div>

    <!-- Champ caché pour stocker le vainqueur sélectionné -->
    <input type="hidden" name="vainqueur_predit[<?php echo $rencontre_id; ?>]" 
           class="vainqueur-input" 
           value="<?php echo esc_attr($vainqueur); ?>">

    <!-- Bonus -->
    <div>
            <div class="grid-3-bonus">
               
            </div>
            <div class="details-score-3">
                <?php if($resultats === 'tout_perdu'): ?>
                    <div class="detail-element de-red">Chou blanc 😥</div>
                <?php else: ?>
                    <?php if(in_array($resultats, ['vainqueur_juste','score_et_vainqueur_juste'])): ?>
                        <div class="detail-element de-orange">LA WIN ! ✅ +10pts</div>
                    <?php endif; ?>

                    <?php if(in_array($resultats, ['score_juste','score_et_vainqueur_juste'])): ?>
                        <div class="detail-element de-orange">TOUT PILE 🔥 +20pts</div>
                    <?php endif; ?>

                    <?php if($bonus_applique === 'x2'): ?>
                        <div class="detail-element de-orange bonus-font">Boost x2 💪</div>
                    <?php elseif($bonus_applique === 'x3'): ?>
                        <div class="detail-element de-orange bonus-font">🎯 LA PASSE DE 3 | x3</div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <div class="mes-pts">
               <?php echo $points_obtenus." pts";?>
            </div>

        </div>
    </div>

            <?php 
                endforeach 
            ?>

        </div>
    
 
    </section>

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
