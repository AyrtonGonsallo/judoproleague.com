<?php

/**
 * Template Name: Modèle module de pari (champions de la semaine)
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



function get_champs_groupes_par_semaine() {
    $args = [
        'post_type'      => 'champ_semaine',
        'posts_per_page' => -1,
        'meta_key'       => 'date_semaine',
        'orderby'        => 'meta_value',
        'order'          => 'DESC',
        'meta_type'      => 'DATE',
    ];

    $posts = get_posts($args);

    $groupes = [];

    foreach ($posts as $post) {
        $date_raw = get_field('date_semaine', $post->ID);

        if (!$date_raw) {
            continue;
        }

        // Convertir en DateTime (ton champ est en d/m/Y)
        $date_obj = DateTime::createFromFormat('d/m/Y', $date_raw, wp_timezone());

        if (!$date_obj) {
            continue;
        }

        // Calculer début et fin de la semaine
        $start = clone $date_obj;
        $start->modify('monday this week');

        $end = clone $start;
        $end->modify('sunday this week');

        $cle = $start->format('Y-m-d');

        if (!isset($groupes[$cle])) {
            $groupes[$cle] = [
                'date_debut_semaine' => $start->format('d/m'),
                'date_fin_semaine'   => $end->format('d/m'),
                'donnees'            => [],
            ];
        }

        // Ajouter données avec les champs ACF pour le tri
        $groupes[$cle]['donnees'][] = [
            'id'            => $post->ID,
            'title'         => get_the_title($post),
            'date'          => $date_raw,
            'total_points'  => (int) get_field('total_points', $post->ID),
            'paris_gagnes'  => (int) get_field('paris_gagnes', $post->ID),
            'score_exact'   => (int) get_field('score_exact', $post->ID),
        ];
    }

     // 🔎 Trier chaque semaine selon la logique
    foreach ($groupes as &$semaine) {
        usort($semaine['donnees'], function($a, $b) {
            if ($a['total_points'] === $b['total_points']) {
                if ($a['paris_gagnes'] === $b['paris_gagnes']) {
                    return $b['score_exact'] <=> $a['score_exact'];
                }
                return $b['paris_gagnes'] <=> $a['paris_gagnes'];
            }
            return $b['total_points'] <=> $a['total_points'];
        });
    }
    unset($semaine); // bonne pratique

    return $groupes;
}




?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


<div class="header-paris-mobile">
    <div class="header-box">
        <a href="/module-de-paris-home/">Accueil</a> > <?php echo get_the_title();?>

    </div>
</div>
<main id="primary" class="site-main champions">
    <section class="listes-equipes page-calendrier">

     <?
        $my_user_id = get_current_user_id();
        $my_user = wp_get_current_user();

        $my_pseudo = get_field('pseudo', 'user_'.$my_user_id) ?: $my_user->display_name;
        $my_prenom = get_user_meta($my_user_id, 'first_name', true);
        $my_nom = get_user_meta($my_user_id, 'last_name', true);
       
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

            
<div class="flex-3-pari2 menu-web">
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
       
       


 <h3 class="fs-h3"> Les champions de la semaine 🔥</h3>
<?php $semaines = get_champs_groupes_par_semaine(); ?>
        <div class="semaine-swiper-container">
            <div class="swiper mySemaineSwiper">
                <div class="swiper-wrapper">
                    <?php foreach ($semaines as $semaine) : ?>
                        <div class="swiper-slide">
                            <h3>du <?php echo esc_html($semaine['date_debut_semaine']); ?> au <?php echo esc_html($semaine['date_fin_semaine']); ?></h3>

                            <div class="infos-semaine">
                               
                                <?php 
                                $rang=1;
                                foreach ($semaine['donnees'] as $donnee) : 
                                    if($rang>=4){
                                        continue;
                                    }
                                    $points = get_field('points', $donnee['id']);
                                    $bonus_utilises = get_field('bonus_utilises', $donnee['id']);
                                    $user_id = get_field('user_id', $donnee['id']);
                                    $nom = get_field('nom', $donnee['id']);
                                    $prenom = get_field('prenom', $donnee['id']);
                                    $user = get_user_by('id', $user_id);
                                    $email = $user->user_email;
                                    $pseudo = get_field('pseudo', 'user_'.$user_id) ?: $user->display_name;
                                    if (empty($prenom) && empty($nom)) {
                                        // Si vide, assigner un pseudo
                                        $pseudo = email_to_pseudo($pseudo);  // Mettre un pseudo par défaut si nécessaire
                                    }else {
                                        // Sinon, concaténer prénom et nom
                                        $pseudo = $prenom . ' ' . $nom;
                                    }
                                    
                                    $paris_gagnes = get_field('paris_gagnes', $donnee['id']);
                                    $score_exacts = get_field('score_exacts', $donnee['id']);
                                    $serie_en_cours = get_field('serie_en_cours', $donnee['id']);
                                    $bonus_utilises = get_field('bonus_utilises', $donnee['id']);
                                    
                                    ?>
                                    <div>
                                            
                                            <div class="sem-box">
                                                <div class="card-header">
                                                    <div class="rank-name">
                                                        <div class="round-rank"><?php echo $rang; ?></div>
                                                        <div class=" name-jds"><?php echo $pseudo; ?></div>
                                                    </div>
                                                    <div>
                                                        <div class="lines-2-total"><?php echo esc_html($points); ?> pts</div>
                                                    </div>
                                                </div>
                                                <div class="grid-jds-datas">
                                                    <div class="lines-2">
                                                        <div>Paris gagnés</div>
                                                        <div><?php echo esc_html($paris_gagnes); ?></div>
                                                        
                                                    </div>
                                                    <div class="lines-2">
                                                        <div>Scores exacts</div>
                                                        <div><?php echo esc_html($score_exacts); ?></div>
                                                        
                                                    </div>
                                                    <div class="lines-2">
                                                        <div>Série en cours</div>
                                                        <div><?php echo esc_html($serie_en_cours); ?></div>
                                                        
                                                    </div>
                                                    <div class="lines-2">
                                                        <div>Bonus utilisés</div>
                                                        <div><?php echo esc_html($bonus_utilises); ?></div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        
                                    </div>
                                <?php 
                                $rang+=1;
                            endforeach; ?>
                                    
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>

                <!-- Flèches navigation -->
<div class="swiper-pagination">
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
</div>
        </div>

    
      
    </section>


        
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <script>
    jQuery(document).ready(function($){
        
        var semaineSwiper = new Swiper(".mySemaineSwiper", {
            slidesPerView: 1,        // 1 semaine affichée à la fois
            spaceBetween: 20,
            navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
            },
            loop: false,             // pas de boucle infinie
            allowTouchMove: true,    // swipe activé
        });

        // Exemple : log semaine active
        semaineSwiper.on('slideChange', function () {
            console.log("Semaine affichée : " + (semaineSwiper.activeIndex + 1));
        });
        
        
    });
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
