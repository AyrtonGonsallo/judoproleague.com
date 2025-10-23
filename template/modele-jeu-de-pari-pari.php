<?php

/**
 * Template Name: Modèle module de pari (paris)
 */

// À placer dans ton template de page, ou via un plugin / code snippet
if ( ! is_user_logged_in() || ! current_user_can('joueur_jpl') ) {
    wp_redirect( site_url('/judopronoschallenge/') );
    exit;
}





get_header();
$saison_value="2025-2026";
$user_id = get_current_user_id();
$user_info = get_userdata($user_id);
$email = $user_info->user_email;



// 2️⃣ Récupérer toutes les rencontres pour la saison et phase voulues
$args = [
    'post_type'      => 'rencontre',
    'posts_per_page' => -1,
    'meta_key'       => 'date_de_debut',
    'orderby'        => 'meta_value',
    'order'          => 'ASC',
    'meta_query'     => [
        'relation' => 'AND',
        [
            'key'     => 'niveau',
            'compare' => '=',
            'value'   => 'Phase de poules',
        ],
        [
            'key'     => 'journee',
            'value'   => ['journée 1','journée 2','journée 3'],
            'compare' => 'IN'
        ],
        [
            'key'     => 'statut', // remplace par ton champ ACF exact
            'value'   => 'a_venir',
            'compare' => 'LIKE'
        ],
        [
            'key'     => 'saisons',
            'compare' => 'LIKE',
            'value'   => $saison_value,
        ],
    ],
];

$rencontres = get_posts($args);


function get_bonus_label($type){
    $res='';
    switch ($type) {
        case 'x2':
            $res='🎯 Boost X2';
            break;
        case 'x3':
            $res='<img class="banco-3" src="/wp-content/uploads/2025/09/Crédit agricole.png" /> Banco x3';
            break;
        case 'joker':
            $res='🃏 Joker';
            break;
        
        default:
            $res='';
            break;
    }
    return $res;
                
}

?>

<div class="header-paris-mobile">
    <div class="header-box">
        <a href="/module-de-paris-home/">Accueil</a> > <?php echo get_the_title();?>
    </div>
</div>


<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
 <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Knewave&display=swap" rel="stylesheet">



<main id="primary" class="site-main pari">
    <section class="listes-equipes page-calendrier page-pari">

     <?
        $user_id = get_current_user_id();
        $user = wp_get_current_user();

        $pseudo = get_field('pseudo', 'user_'.$user_id) ?: $user->display_name;
        $prenom = get_user_meta($user_id, 'first_name', true);
        $nom = get_user_meta($user_id, 'last_name', true);
        $avatar_id = get_field('avatar', 'user_'.$user_id);
        $avatar_url = ($avatar_id)?$avatar_id:"/wp-content/uploads/2025/08/user-icon.png";
        ?>

            

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
            <a href="/module-de-paris-classement" class="disabled">
                <img src="/wp-content/uploads/2025/09/medals.webp" width="30" class="menu-icon">
                <span>Mon classement</span>
            </a>
        </div>
    </div>

        
    <div id="tabs" class="tabs-poules">
  <ul>
    <li><a href="#tabs-1" class="nv-journee"><span class="desktop">Rencontres à venir</span><span class="mobile">À venir</span></a></li>
    <li><a href="#tabs-3" class="nv-journee"><span class="desktop">Rencontres en cours</span><span class="mobile">En cours</span></a></li>
    <li><a href="#tabs-2" class="nv-journee"><span class="desktop">Rencontres terminées</span><span class="mobile">Terminés</span></a></li>
  </ul>


  <div id="tabs-1">
        <form method="post" action="">
        <div class="liste-paris-add-update">
            <?php 

                // Initialiser les limites de bonus
                $bonus_max = ['x2'=>2, 'x3'=>1, 'joker'=>1];
                // Compter combien ont été utilisés
                $bonus_utilises = ['x2'=>0, 'x3'=>0, 'joker'=>0];
                $bonus_restants = [];
    
                foreach ($rencontres as $rencontre):
                    $rencontre_id=$rencontre->ID;
                    $equipe1 =get_field('equipe_1', $rencontre->ID)[0];
                    $equipe2 =get_field('equipe_2', $rencontre->ID)[0];
                    $image1_url=(get_field('logo_circle', $equipe1->ID))?get_field('logo_circle', $equipe1->ID):get_the_post_thumbnail_url($equipe1->ID);
                    $image2_url=(get_field('logo_circle', $equipe2->ID))?get_field('logo_circle', $equipe2->ID):get_the_post_thumbnail_url($equipe2->ID);
                    $statut=get_field('statut', $rencontre->ID)['label'];
                    $date_debut=get_field('date_de_debut', $rencontre->ID, false, false);
                    if($statut=='en cours'){
                        $status='en cours';
                        
                    }else if($statut=='terminé'){
                        $status='terminé';
                    }
                    else if($statut=="à venir"){
                        $status='à venir';
                    }
                    $now = new DateTime("now", wp_timezone()); // tient compte du fuseau WP
                    $debut = new DateTime($date_debut, wp_timezone());
                    $date_debut_string = date_i18n('d F Y \à H\h', $debut->getTimestamp());

                    // Calcul de la différence
                    $interval = $now->diff($debut);

                    if ($debut > $now) {
                        // Temps restant formaté
                        $temps_restant = $interval->days . "J " . $interval->h . "H " . $interval->i . "M";
                    } else {
                        $temps_restant = "Terminé";
                    }

                    $paris_en_cours1 = get_posts([
                        'post_type'      => 'pari',
                        'posts_per_page' => 1,
                        'meta_query'     => [
                            'relation' => 'AND',
                            [
                                'key'     => 'user',
                                'value'   => $user_id,
                                'compare' => '=',
                            ],
                            [
                                'key'     => 'status',
                                'value'   => 'a_venir',
                                'compare' => '=',
                            ],
                            [
                                'key'     => 'rencontre',
                                'value'   => $rencontre_id,
                                'compare' => '=',
                            ]
                        ]
                    ]);
                    $pari = $paris_en_cours1[0];
                    if(!empty($paris_en_cours1)){
                        $score_equipe1 = get_field('score_equipe_1', $pari->ID);
                        $score_equipe2 =get_field('score_equipe_2', $pari->ID);
                        $bonus_applique = get_field('bonus_applique', $pari->ID);
                        $vainqueur  = get_field('vainqueur', $pari->ID);

                        
                        if ($bonus_applique && isset($bonus_utilises[$bonus_applique])) {
                            $bonus_utilises[$bonus_applique]++;
                        }
                        

                        // Calculer les bonus restants
                        foreach ($bonus_max as $type => $max) {
                            $bonus_restants[$type] = $max - ($bonus_utilises[$type] ?? 0);
                        }

                    }else{
                        $score_equipe1 = 0;
                        $score_equipe2 = 0;
                        $vainqueur="nul";
                        $bonus_applique ="aucun : Aucun";
                    }
            ?>
               <div class="pari add-pari" data-rencontre-id="<?php echo $rencontre_id; ?>">
    <div class="infos-pari">
        <div class="date-time-pari">
        <?php echo ($date_debut_string); ?>
        </div>
        <div class="temps-restant-pari">
        <?php echo ($temps_restant); ?>
        </div>
    </div>

    <div class="grid-3-pari">
        <!-- Équipe 1 -->
        <div class="equipe-box">
            <div class=" equipe checkable_equipe <?php echo ($vainqueur=='equipe1'?'selected':''); ?>" 
             data-vainqueur="equipe1">
                <div class="image-equipe-pari" 
                style="background-image:url(<?php echo $image1_url;?>)">
                </div>
                <div class="title-team-pari">
                <?php echo get_the_title($equipe1->ID ); ?>
            </div>
            </div>
        </div>

        <div class="grid-3-1-pari">
            <div class="score-equipe">
                <input type="text" name="score_equipe_1[<?php echo $rencontre_id; ?>]" class="score1" placeholder="0" inputmode="numeric" pattern="[0-9]*" value="<?php echo esc_attr($score_equipe1 ?: ''); ?>">
            </div>
            <div class="center-dots">
                -
            </div>
            <div class="score-equipe">
                <input type="text" name="score_equipe_2[<?php echo $rencontre_id; ?>]" class="score1" placeholder="0" inputmode="numeric" pattern="[0-9]*" value="<?php echo esc_attr($score_equipe2 ?: ''); ?>">
            </div>
        </div>

        <div class="equipe-box">
            <!-- Équipe 2 -->
            <div class=" equipe checkable_equipe <?php echo ($vainqueur=='equipe2'?'selected':''); ?>" 
             
             data-vainqueur="equipe2">
                <div class="image-equipe-pari" 
                    style="background-image:url(<?php echo $image2_url;?>)" 
                    >
                </div>
                <div class="title-team-pari">
                    <?php echo get_the_title($equipe2->ID ); ?>
                </div>
            </div>
             
        </div>
    </div>
    
    <!-- Champ caché pour stocker le vainqueur sélectionné -->
    <input type="hidden" name="vainqueur_predit[<?php echo $rencontre_id; ?>]" class="vainqueur-input">

    <!-- Bonus -->
    <div>
        
        <div class="grid-3-bonus">
            <?php foreach ($bonus_max as $type => $limite) : 
                $selected_class = ($bonus_applique==$type)?'selected':'';
                $restant = $bonus_restants[$type];

                
            ?>
                <button type="button" class="bonus-pari bonus-font bonus-pari-add <?php echo $selected_class; ?>" 
                        data-bonus="<?php echo $type; ?>" 
                        data-limit="<?php echo $restant; ?>"
                        <?php echo ($restant <= 0 && !$selected_class)?'disabled':''; ?>>
                    <?php echo get_bonus_label($type); ?> 
                    <span class="bonus-count bonus-partie-add"><?php echo $restant; ?></span>
                </button>
            <?php endforeach; ?>
            <input type="hidden" name="bonus_applique[<?php echo $rencontre_id; ?>]" class="bonus-input" value="<?php echo esc_attr($bonus_applique); ?>">
        
        </div>

        
    </div>
</div>

            <?php 
                endforeach 
            ?>

        </div>
        
</form>
  </div>
  <div id="tabs-2">
    <?php  
   
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

<div class="liste-paris">
   

    <?php 
    // Initialiser les limites de bonus
    $bonus_max = ['x2'=>2, 'x3'=>1, 'joker'=>1];
    // Compter combien ont été utilisés
    $bonus_utilises = ['x2'=>0, 'x3'=>0, 'joker'=>0];

      // Comptage des bonus déjà appliqués sur tous les paris
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
                    $image1_url=(get_field('logo_circle', $equipe1->ID))?get_field('logo_circle', $equipe1->ID):get_the_post_thumbnail_url($equipe1->ID);
                    $image2_url=(get_field('logo_circle', $equipe2->ID))?get_field('logo_circle', $equipe2->ID):get_the_post_thumbnail_url($equipe2->ID);
                    $score_equipe2 =get_field('score_equipe_2', $pari_fini->ID);
                    $score_final_equipe_2 =get_field('score_final_equipe_2', $pari_fini->ID);
                    $bonus_applique = get_field('bonus_applique', $pari_fini->ID);
                    $vainqueur  = get_field('vainqueur', $pari_fini->ID);
                    $resultats  = get_field('resultats', $pari_fini->ID);
                    $multiplicateur  = get_field('multiplicateur', $pari_fini->ID);
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
        <div>
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
                        value="<?php echo $score_final_equipe_1 ; ?>" readonly>
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
                        value="<?php echo $score_final_equipe_2 ; ?>" readonly>
                    </div>
                
                </div>
            </div>
            <div class="mes-scores-paries">
               Ton prono : <?php echo $score_equipe1;?> - <?php echo $score_equipe2;?>
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
                <?php if( $multiplicateur !== 'x1'): ?>
                    <div class="detail-element de-orange bonus-font">Série <?php echo $multiplicateur;?></div>
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


  </div>

  <div id="tabs-3">
     <?php  
   
    // 1️⃣ Récupérer les paris existants de l'utilisateur
    $paris_en_cours = get_posts([
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
                'value'   => 'a_venir',
                'compare' => '=',
            ]
        ]
    ]);
    ?>

   
        <div class="liste-paris">
   

    <?php 
    // Initialiser les limites de bonus
    $bonus_max = ['x2'=>2, 'x3'=>1, 'joker'=>1];
    // Compter combien ont été utilisés
    $bonus_utilises = ['x2'=>0, 'x3'=>0, 'joker'=>0];

      // Comptage des bonus déjà appliqués sur tous les paris
    foreach ($paris_en_cours as $pari_en_cours) {
        $bonus_applique = get_field('bonus_applique', $pari_en_cours->ID);
        if ($bonus_applique && isset($bonus_utilises[$bonus_applique])) {
            $bonus_utilises[$bonus_applique]++;
        }
    }

    // Calculer les bonus restants
    $bonus_restants = [];
    foreach ($bonus_max as $type => $max) {
        $bonus_restants[$type] = $max - ($bonus_utilises[$type] ?? 0);
    }
    
                foreach ($paris_en_cours as $pari_en_cours):
                    $rencontre=get_field('rencontre', $pari_en_cours->ID)[0];
                    $statut=get_field('statut', $rencontre->ID)['label'];
                    $date_debut=get_field('date_de_debut', $rencontre->ID, false, false);
                    if($statut!='en cours'){
                       continue;
                        
                    }
                    $rencontre_id=$rencontre->ID;
                    $lien_direct = get_the_permalink($rencontre_id);
                    $equipe1 =get_field('equipe_1', $rencontre_id)[0];
                    $equipe2 =get_field('equipe_2', $rencontre_id)[0];
                    $score_equipe1 = get_field('score_equipe_1', $pari_en_cours->ID);
                    $image1_url=(get_field('logo_circle', $equipe1->ID))?get_field('logo_circle', $equipe1->ID):get_the_post_thumbnail_url($equipe1->ID);
                    $image2_url=(get_field('logo_circle', $equipe2->ID))?get_field('logo_circle', $equipe2->ID):get_the_post_thumbnail_url($equipe2->ID);
                    $score_equipe2 =get_field('score_equipe_2', $pari_en_cours->ID);
                    $bonus_applique = get_field('bonus_applique', $pari_en_cours->ID);
                    $vainqueur  = get_field('vainqueur', $pari_en_cours->ID);
                    $date_debut=get_field('date_de_debut', $rencontre->ID, false, false);
                   
                        $status='en cours';
                   
                    $now = new DateTime("now", wp_timezone()); // tient compte du fuseau WP
                    $debut = new DateTime($date_debut, wp_timezone());
                    $date_debut_string = date_i18n('d F Y \à H\h', $debut->getTimestamp());
                    // Calcul de la différence
                    $interval = $now->diff($debut);

                    if ($debut > $now) {
                        // Temps restant formaté
                        $temps_restant = $interval->days . "J " . $interval->h . "H " . $interval->i . "M";
                    } else {
                        $temps_restant = "Terminé";
                    }
            ?>
            <div class="pari update-pari" data-rencontre-id="<?php echo $rencontre_id; ?>"  data-limits='<?php echo json_encode($bonus_restants); ?>'>
        <div class="infos-pari">
            <div class="date-time-pari">
            <?php echo ($date_debut_string); ?>
            </div>
            <div class="temps-restant-pari">
                <div class="live-pari"><a href="<?php echo $lien_direct;?>">Live</a></div>
            </div>
        </div>
        
    <div class="grid-3-pari">
        <!-- Équipe 1 -->
        <div class="equipe-box">
            <div class="not_checkable_equipe equipe <?php echo ($vainqueur=='equipe1'?'selected':''); ?>"  
            data-vainqueur="equipe1">
                <div class="image-equipe-pari" 
                style="background-image:url(<?php echo $image1_url;?>)" >
                </div>
                <div class="title-team-pari"><?php echo get_the_title($equipe1->ID ); ?></div>
            </div>
        </div>
      

        <div class="grid-3-1-pari">
            <div class="score-equipe">
                <input type="number" 
                       name="score_equipe_1[<?php echo $rencontre_id; ?>]" 
                       min="0" max="15" 
                       placeholder="0" 
                       value="<?php echo esc_attr($score_equipe1 ?: ''); ?>" readonly>
            </div>
            <div class="center-dots">
                -
            </div>
            <div class="score-equipe">
                <input type="number" 
                       name="score_equipe_2[<?php echo $rencontre_id; ?>]" 
                       min="0" max="15" 
                       placeholder="0" 
                       value="<?php echo esc_attr($score_equipe2 ?: ''); ?>" readonly>
            </div>
        </div>

        <!-- Équipe 2 -->
        <div class="equipe-box">
            <div class="not_checkable_equipe equipe <?php echo ($vainqueur=='equipe2'?'selected':''); ?>"  
            data-vainqueur="equipe2">
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
                <?php foreach ($bonus_max as $type => $limite) : 
                    $selected_class = ($bonus_applique==$type)?'selected':'';
                    $restant = $bonus_restants[$type];
                ?>
                    <button type="button" class="bonus-pari  bonus-font bonus-pari-update <?php echo $selected_class; ?>" 
                            data-bonus="<?php echo $type; ?>" 
                            data-limit="<?php echo $restant; ?>"
                            <?php echo ($restant <= 0 && !$selected_class)?'disabled':''; ?>>
                        <?php echo get_bonus_label($type); ?> 
                        <span class="bonus-count bonus-partie-update"><?php echo $restant; ?></span>
                    </button>
                <?php endforeach; ?>
                <input type="hidden" name="bonus_applique[<?php echo $rencontre_id; ?>]" class="bonus-input" value="<?php echo esc_attr($bonus_applique); ?>">
           
            </div>

        </div>
    </div>

            <?php 
                endforeach 
            ?>

        </div>
        

  </div>
  
</div>


<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#tabs" ).tabs();
  } );
  </script>


 <script>
 jQuery(document).ready(function($){
let previousValue = {};
    //validation 

    function validerPari($pari,cas_egalite,$input){
        $pari.find(".message-echec").remove();
        $pari.find(".message-succes").remove();
        let rencontreID=$pari.data('rencontre-id');
        let $equipe1div=$pari.find('.checkable_equipe[data-vainqueur="equipe1"]');
        let $equipe2div=$pari.find('.checkable_equipe[data-vainqueur="equipe2"]');

        let val1 = $pari.find("input[name^='score_equipe_1']").val();
        let val2 = $pari.find("input[name^='score_equipe_2']").val();

        if (val1 === "" || val2 === "") {
            return; // ne rien faire si un des deux est vide
        }

        
        let s1 = parseInt(val1, 10);
        let s2 = parseInt(val2, 10);

        let total = s1 + s2;

        let $vainqueurInput = $pari.find(".vainqueur-input");
        console.log("validation rencontre ",rencontreID,)
        console.log("s1 ",s1,)
        console.log("s2 ",s2,)
        console.log("total ",total)
        console.log("vainqueur ",$vainqueurInput.val())
        if(!cas_egalite){
            // Reset état
            $vainqueurInput.val("");
            $pari.find(".checkable_equipe").removeClass("disabled");
            $pari.find(".message-egalite").remove(); 
        }
        

        // Vérif total
        if(total > 10){
            console.log(previousValue)
            // Réinitialiser les scores
             if ($input) {
                $input.val(previousValue[$input[0].name] || 0);
            }

            $pari.append('<div class=" message-echec">⚠️ Le score total ne peut pas être supérieur à 10.</div>');

            return false;
        }

        // Détermination vainqueur
        if(s1 > s2){
            $vainqueurInput.val("equipe1");
            $equipe2div.addClass("disabled");
            $equipe2div.removeClass('selected');
            $equipe1div.addClass('selected');
        } 
        else if(s2 > s1){
            $vainqueurInput.val("equipe2");
            $equipe2div.addClass("selected");
            $equipe1div.addClass('disabled');
            $equipe1div.removeClass('selected');
        } 
        else if(s1 === s2 && (s1 !== 0 || s2 !== 0)){
            // Cas égalité → message
            // Réinitialiser classes des deux équipes
            if(!cas_egalite){
                $equipe1div.add($equipe2div).removeClass('selected disabled');
                  $pari.find(".message-egalite").remove();
                $pari.append('<div class="message-egalite message-echec" >⚠️ Pour les cas d\'égalité, veuillez sélectionner un gagnant afin de valider le pari.</div>');

            }
          
            
        }

         // ✅ si on a un vainqueur
        if($vainqueurInput.val()){
            envoyerPari($pari, rencontreID, s1, s2, $vainqueurInput.val());
        }

        return true;
    }

    function envoyerPari($pari, rencontreID, s1, s2, vainqueur){
        $.post(ajaxurl, {
            action: "enregistrer_pari",
            rencontre_id: rencontreID,
            score1: s1,
            score2: s2,
            vainqueur: vainqueur,
            bonus: $pari.find(".bonus-input").val() || "aucun"
        }, function(response){
            $pari.find(".message-succes").remove();
            $pari.append('<div class="message-succes" >✅ '+response.data+'</div>');
            console.log("Réponse serveur :", response);
        });
    }
$(".liste-paris-add-update").on("focus", "input[type='text']", function() {
    previousValue[this.name] = $(this).val();
});
    // Sur saisie de score
    $(".liste-paris-add-update").on("input", "input[type='text']", function(){
        let $pari = $(this).closest(".pari");
        let $input = $(this);
        validerPari($pari, false, $input);
    });
    // Sur clic sur un bonus
    $(".liste-paris-add-update").on("click", ".bonus-pari-add", function(){
        let $pari = $(this).closest(".pari");
        validerPari($pari,false,null);
    });

    // Clic sur logo en cas d'égalité
    $(".liste-paris-add-update").on("click", ".checkable_equipe", function(){
        let $pari = $(this).closest(".pari");
        if($(this).hasClass("disabled")) return; // bloqué
        let gagnant = $(this).data("vainqueur");
        $(this).addClass("selected");
        console.log("egalite vainqueur selected",gagnant)
        $pari.find(".vainqueur-input").val(gagnant);
        $pari.find(".message-egalite").remove();
        validerPari($pari,true,null);
    });


    //validation finie

 $('.add-pari').each(function(){
        var $pari = $(this);

        // Sélection de l'équipe
        $pari.find('.checkable_equipe').on('click', function(){
            $pari.find('.checkable_equipe').removeClass('selected');
            $(this).addClass('selected');
            $pari.find('.vainqueur-input').val($(this).data('vainqueur'));
        });

    })


    




    // 1. Compteurs max
    let bonusMax = <?php echo json_encode($bonus_max); ?>;
    // 2. Compteurs utilisés
    let bonusUsed = <?php echo json_encode($bonus_utilises); ?>;
    console.log("bonus used",bonusUsed)

    // 3. Rafraîchir l'affichage de tous les boutons
    function refreshBonusDisplay() {
        $(".bonus-pari-add").each(function() {
            let type = $(this).data("bonus");
            let restant = bonusMax[type] - bonusUsed[type];
            if (restant < 0) restant = 0;
            $(this).find(".bonus-partie-add").text(restant);

            // Activation/désactivation selon le nombre restant
            if(restant <= 0 && !$(this).hasClass("selected")){
                $(this).prop("disabled", true);
            } else {
                $(this).prop("disabled", false);
            }
        });
    }

    // 4. Gestion du clic sur un bouton bonus
    $(".bonus-pari-add").on("click", function() {
        let $btn = $(this);
        let type = $btn.data("bonus");
        let $pari = $btn.closest(".pari");
        let $input = $pari.find(".bonus-input");

        let currentlySelected = $pari.find(".bonus-pari-add.selected");
        let selectedBonus = currentlySelected.data("bonus");

        if($btn.hasClass("selected")){
            // Décoche le même bonus
            $btn.removeClass("selected");
            $input.val("");
            bonusUsed[type]--;
        } else {
            // Vérifie qu'il reste des bonus
            let globalRestant = bonusMax[type] - bonusUsed[type];
            
            if(globalRestant > 0){
                // Si un autre bonus était déjà sélectionné sur ce pari, on le libère
                if(currentlySelected.length){
                    currentlySelected.removeClass("selected");
                    $pari.find(".bonus-input").val("");
                    bonusUsed[selectedBonus]--;
                }

                // Appliquer le nouveau bonus
                $btn.addClass("selected");
                $input.val(type);
                bonusUsed[type]++;
            } else {
                alert("Plus de bonus " + type + " disponibles !");
            }
        }

        // Mise à jour affichage global
        refreshBonusDisplay();
    });

    // 5. Initialiser affichage au chargement
    refreshBonusDisplay();


  

    
});



</script>
 
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
