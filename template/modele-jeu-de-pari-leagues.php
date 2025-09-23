<?php

/**
 * Template Name: Modèle module de pari (leagues)
 */


// À placer dans ton template de page, ou via un plugin / code snippet
if ( ! is_user_logged_in() || ! current_user_can('joueur_jpl') ) {
    wp_redirect( site_url('/judopronoschallenge/') );
    exit;
}

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
get_header();

?>


<div class="header-paris-mobile">
    <div class="header-box">
        <a href="/module-de-paris-home/">Accueil</a> > <?php echo get_the_title();?>
    </div>
</div>
<main id="primary" class="site-main ligue">
    <section class="listes-equipes page-calendrier">
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

<div class="flx-lig">
<div class="list-lig">
        <h3 class="desktop fs-h3"> Mes ligues</h3>
        <?php
        $user_id = get_current_user_id();
        

        // 1️⃣ Ligues où je suis créateur ou participant
        $my_ligues = get_posts([
            'post_type'      => 'ligue',
            'numberposts'    => -1,
            'meta_query'     => [
                'relation' => 'OR',
                [
                    'key'     => 'createur',
                    'value'   => $user_id,
                    'compare' => '=',
                    'type'    => 'NUMERIC'
                ],
                [
                    'key'     => 'participants',
                    'value'   => '"' . $user_id . '"',
                    'compare' => 'LIKE'
                ]
            ]
        ]);

        // 2️⃣ Demandes d’adhésion en attente (posts "demande")
        $demandes = get_posts([
            'post_type'   => 'demande',
            'numberposts' => -1,
            'meta_query'  => [
                'relation' => 'AND',
                [
                    'key'     => 'parieur',
                    'value'   => $user_id,
                    'compare' => '=',
                    'type'    => 'NUMERIC'
                ],
                [
                    'key'     => 'status',
                    'value'   => 'en_attente',
                    'compare' => 'LIKE',
                ]
            ]
        ]);

        // 3️⃣ Récupérer les ligues associées à ces demandes
        $ligues_from_demandes = [];
        foreach ($demandes as $demande) {
            $ligue_id = get_field('ligue', $demande->ID)[0];
            if ($ligue_id) {
                $ligue_post = get_post($ligue_id);
                if ($ligue_post) {
                    $ligues_from_demandes[] = $ligue_post;
                }
            }
        }

        // 4️⃣ Fusionner les deux tableaux et enlever les doublons
        $all_ligues = array_merge($my_ligues, $ligues_from_demandes);

        // Supprimer les doublons en se basant sur l’ID
        $all_ligues = array_values(array_reduce($all_ligues, function ($carry, $item) {
            $carry[$item->ID] = $item;
            return $carry;
        }, []));

        if ( !empty($all_ligues) ) {
            echo '<table class="my-leagues-list">';
            echo '<thead class="first-li">';
                echo '<td><strong>Nom de la ligue</strong></td>';
                echo '<td><span>Membre(s)</span></td>';
                echo '<td><span class="desktop">Propriétaire</span></td>';
                echo '<td><span>Rôle</span></td>';
                echo '<td><span>Actions</span></td>';
                echo '</thead>';

            foreach ( $all_ligues as $ligue ) {
                // Récupérer les participants (champ relation ACF)
                $participants = get_field('participants', $ligue->ID) ?: [];// retourne un tableau de WP_Post ou vide
                $createur_id = get_field('createur', $ligue->ID);
                 if ($createur_id && !in_array($createur_id, $participants)) {
                    array_unshift($participants, $createur_id);
                }
                $user_data = get_user_by('id', $createur_id);
                $createur_pseudo = get_field('pseudo', 'user_'.$createur_id) ?: $user_data->display_name;
                $createur_prenom = get_user_meta($createur_id, 'first_name', true);
                $createur_nom = get_user_meta($createur_id, 'last_name', true);
                $createur_email = $createur_user->user_email;

                if (empty($createur_prenom) && empty($createur_nom)) {
                    // Si vide, assigner un pseudo
                    $createur_pseudo = email_to_pseudo($createur_pseudo);  // Mettre un pseudo par défaut si nécessaire
                }else {
                    // Sinon, concaténer prénom et nom
                    $createur_pseudo = $createur_prenom . ' ' . $createur_nom;
                }
        
                $total_participants = is_array($participants) ? count($participants) : 1;
                // Logo (champ image ACF avec retour tableau)
                $logo = get_field('logo', $ligue->ID);
                if ($logo) {
                    // Tu as accès à : $logo['id'], $logo['url'], $logo['alt'], $logo['title'], $logo['sizes'], etc.
                    $logo_url = $logo['url'];        // taille originale
                } else{
                    $logo_url = "/wp-content/uploads/2025/09/hand.png";  
                }

                if ($createur_id == $user_id) {
                    $role = 'admin';
                    $icone = '<a href="'.get_permalink($ligue->ID).'">
                    <img src="/wp-content/uploads/2025/09/edit.png" width="30" class="action-icon">
                    </a>';
                } else {
                    // Vérifie si l'utilisateur est parmi les participants
                    $participant_ids = [];

                    if (is_array($participants)) {
                        // Si relation multiple, récupérer les IDs
                        foreach ($participants as $p) {
                            if (is_object($p)) { // ACF relation retourne parfois WP_Post/WP_User
                                $participant_ids[] = $p->ID;
                            } else {
                                $participant_ids[] = $p; // si ID direct
                            }
                        }
                    }
                    $icone = in_array($user_id, $participant_ids) ? '<a href="'.get_permalink($ligue->ID).'">
                    <img src="/wp-content/uploads/2025/09/view-icon.png" width="30" class="action-icon">
                    </a>':'';
                    $role = in_array($user_id, $participant_ids) ? 'participant' : 'en attente';
                }

                echo '<tr>';
                echo '<td><strong><!-- <img src="'.$logo_url.'" width="30"> -->' . get_the_title($ligue->ID) . '</strong></td>';
                echo '<td><span>' . $total_participants.'</span></td>';
                echo '<td><span class="desktop">' . $createur_pseudo.'</span></td>';
                echo '<td><span>' . $role.'</span></td>';
                echo '<td><span>' . $icone.'</span></td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo 'Aucune ligue trouvée pour cet utilisateur.';
        }

        ?>
       </div>

        <div class="flex-2-pari">
             <div class="sub-menu-element round-border-purple bg-lig" >
                <a href="/creer-une-ligue/" class="vertical">
                    
                    <img src="/wp-content/uploads/2025/08/mes-ligues.webp" width="100" class="menu-img-top-big" >
                    <span>Créer ma ligue</span>
                </a>
            </div> 
             <div class="sub-menu-element round-border-purple bg-lig" id="btn-rejoindre-ligue">
                <a href="/rejoindre-une-ligue/" class="vertical">
                    
                    <img src="/wp-content/uploads/2025/08/rejoindre.webp" width="100" class="menu-img-top-big" >
                    <span>Rejoindre une ligue</span>
                </a>
            </div> 
        </div>
</div>
</div>

           

                
</div>

                
        <?php if ( $toast_message ): ?>
        <script>
        jQuery(document).ready(function($){
            // Création du toast
            let $toast = $('<div class="custom-toast"></div>').text("<?php echo esc_js($toast_message); ?>");
            $("body").append($toast);

            // Animation
            $toast.fadeIn(400).delay(3000).fadeOut(600, function(){
                $(this).remove();
            });
        });
        </script>
        <style>
        .custom-toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #222;
            color: #fff;
            padding: 12px 20px;
            border-radius: 6px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.3);
            font-size: 14px;
            display: none;
            z-index: 9999;
        }
        </style>
        <?php endif; ?>

        <script>
jQuery(document).ready(function($){
    $('.info-bulle').hover(function(){
        var title = $(this).attr('title');
        $(this).data('tipText', title).removeAttr('title');
        $('<p class="tooltip"></p>')
            .text(title)
            .appendTo('body')
            .fadeIn('slow');
    }, function() {
        $(this).attr('title', $(this).data('tipText'));
        $('.tooltip').remove();
    }).mousemove(function(e) {
        $('.tooltip')
            .css({ top: e.pageY + 10, left: e.pageX + 10 });
    });
});
</script>

<style>
.tooltip {
    position: absolute;
    background: #333;
    color: #fff;
    padding: 6px 10px;
    border-radius: 4px;
    font-size: 13px;
    pointer-events: none;
    z-index: 9999;
}
.info-bulle {
    cursor: pointer;
    margin-left: 5px;
}
</style>

         <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" defer></script>
        <script>
        jQuery(document).ready(function($){
            $("#btn-creer-ligue").on("click", function(){
                $("#form-creer-ligue").slideToggle();
                $("#form-rejoindre-ligue").slideUp(); // cacher l'autre si ouvert
            });

            $("#btn-rejoindre-ligue").on("click", function(){
                $("#form-rejoindre-ligue").slideToggle();
                $("#form-creer-ligue").slideUp(); // cacher l'autre si ouvert
            });

            $('#leagues_table').DataTable( {
                language: {
                    processing:     "Traitement en cours...",
                    search:         "",
                    searchPlaceholder: "Rechercher une ligue",
                    info:           "Affichage des &eacute;lements _START_ &agrave; _END_",
                    infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 lignes",
                    infoFiltered:   "(filtr&eacute; de _MAX_ lignes au total)",
                    infoPostFix:    "",
                    loadingRecords: "Chargement en cours...",
                    zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher",
                    emptyTable:     "Aucune donnée disponible dans le tableau",
                    paginate: {
                        first:      "Premier",
                        previous:   "<i class='fa fa-arrow-left'></i>",
                        next:       "<i class='fa fa-arrow-right'></i>",
                        last:       "Dernier"
                    },
                    aria: {
                        sortAscending:  ": activer pour trier la colonne par ordre croissant",
                        sortDescending: ": activer pour trier la colonne par ordre décroissant"
                    }
                },
                "paging": false,
                info: false,
                pageLength: 100,
                lengthChange: false,


               
        } );
// Ajouter l’icône recherche 🔍 après le champ
   $(".dataTables_filter").css("position", "relative");
   $(".dataTables_filter input").css("padding-right", "25px");
   $(".dataTables_filter").append('<i class="fa fa-search search-icon"></i>');

   // Style de l’icône
   $(".dataTables_filter .fa-search").css({
       "position": "absolute",
       "right": "10px",
       "top": "50%",
       "transform": "translateY(-50%)",
       "color": "#999",
       "pointer-events": "none"
   });
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
