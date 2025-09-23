<?php

/**
 * Template Name: Modèle module de pari (rejoindre une ligue)
 */


// À placer dans ton template de page, ou via un plugin / code snippet
if ( ! is_user_logged_in() || ! current_user_can('joueur_jpl') ) {
    wp_redirect( site_url('/judopronoschallenge/') );
    exit;
}
$ligue_id = isset($_GET['ligue_id']) ? intval($_GET['ligue_id']) : 0;

get_header();

 function jpl_envoyer_mail($to, $subject, $pseudo, $message) {
        $headers = array('Content-Type: text/html; charset=UTF-8');

        $body = '
        <div style="font-family:Arial,sans-serif; font-size:14px; color:#333;">
            <p>Salut ' . esc_html($pseudo) . ',</p>
            
            <p>' . nl2br(wp_kses_post($message)) . '</p>

            <p>Cordialement,</p>
            <p>L\'équipe Judo Pro League</p>
            
            <p>
                <img src="https://judoproleague.com/wp-content/uploads/2023/07/logo-jpl.png" 
                    alt="Logo Judo Pro League" 
                    style="max-width:150px; margin-top:10px;" />
            </p>
        </div>
        ';

        wp_mail($to, $subject, $body, $headers);
    }

if (isset($_POST['action']) && $_POST['action'] === 'rejoindre_ligue_par_page' && wp_verify_nonce($_POST['ligue_nonce'], 'rejoindre_ligue_par_page_nonce')) {
            $user_id  = get_current_user_id();
            $ligue_id = intval($_POST['ligue_id']);
            $user_id = intval($_POST['user_id']);
            // Récupérer l'objet utilisateur
            $user = get_userdata($user_id);
            $user_name = $user ? $user->display_name : 'Utilisateur '.$user_id;

            // Récupérer le nom de la ligue
            $ligue_title = get_the_title($ligue_id);

            // Créer le post "demande"
            $demande_id = wp_insert_post([
                'post_type'   => 'demande',
                'post_title'  => 'Demande de '.$user_name.' pour la ligue '.$ligue_title,
                'post_status' => 'publish'
            ]);

            if ($demande_id) {
                 // champs ACF
                update_field('date', current_time('mysql'), $demande_id);
                update_field('parieur', $user_id, $demande_id);
                update_field('ligue', $ligue_id, $demande_id);
                update_field('status', 'en_attente', $demande_id);
                 // envoyer mail au créateur
                $createur_id = get_field('createur', $ligue_id);
                 $createur_user = get_user_by('ID', $createur_id);
                
                $parieur_user = get_user_by('ID', $user_id);

                   // Définir l'expéditeur
                    add_filter( 'wp_mail_from', function( $email ) {
                        return 'contact@judoproleague.com';
                    });
                    add_filter( 'wp_mail_from_name', function( $name ) {
                        return 'Judo Pro League';
                    });
                if ($createur_user) {
                  
                    $createur_prenom = get_user_meta($createur_user->ID, 'first_name', true);
                    $parieur_prenom = get_user_meta($parieur_user->ID, 'first_name', true);
                  
                    jpl_envoyer_mail(
                        $parieur_user->user_email,
                        "Ta demande d’accès est bien enregistrée",
                        $parieur_prenom, // prenom
                        "Ta demande pour rejoindre la ligue " . get_the_title($ligue_id) . " a bien été envoyée.\n
                        Elle est désormais entre les mains de l’administrateur de la ligue.\n
                        Tu recevras un mail dès qu’il aura validé ton entrée.\n
                        \n\n
                        — L’équipe Judo Pronos Challenge",
                    );

                    // Mail au créateur
                    jpl_envoyer_mail(
                        $createur_user->user_email,
                        "Nouvelle demande pour rejoindre ta ligue",
                        $createur_prenom, // prenom du créateur
                        
                        "Un utilisateur souhaite rejoindre ta ligue " . get_the_title($ligue_id) . ".\n
                        Sa demande est en attente de ta validation.\n
                        Tu peux gérer les demandes depuis ton espace Ligue.\n
                        <a href='" . get_the_permalink($ligue_id) . "' style='background:#0073aa;color:#fff;padding:10px 15px;text-decoration:none;border-radius:5px;'>Gérer les demandes d’accès</a>
                        \n\n
                        — L’équipe Judo Pronos Challenge"
                    );
                }

                echo "<script>window.ligueCreated = true;</script>";

            } else {
                echo "<p style='color:red'>Erreur lors de la création de la demande.</p>";
            }
        }
?>


<div class="header-paris-mobile">
    <div class="header-box">
        <a href="/module-de-paris-home/">Accueil</a> > <a href="/module-de-paris-ligues/">Mes ligues</a> > <?php echo get_the_title();?>

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


<div class="flex-3-pari2" style="margin-bottom:4%";>
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

<div class="">


    <h3 class="desktop fs-h3">Rejoindre une ligue</h3>
     
    <div id="form-rejoindre-ligue" >
        <?php  if( !$ligue_id ): ?>           
            <?php
            
                $all_ligues = get_posts([
                    'post_type'      => 'ligue',
                    'numberposts'    => -1,
                    'meta_query'  => [
                        [
                            'key'     => 'status',
                            'value'   => 'ouvert',
                            'compare' => 'LIKE',
                        ],
                    ],
                    
                ]);
            
                if (  !empty($all_ligues) ): ?>
                <table id="leagues_table" class="display">
                    <thead class="no-head">
                        <tr>
                            <th>Titre</th>
                            <th>Participants</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ( $all_ligues as $ligue ):
                        $participants = get_field('participants', $ligue->ID);
                        $createur_id = get_field('createur', $ligue->ID);
                        $total_participants = is_array($participants) ? count($participants)+1 : 1;

                        $logo = get_field('logo', $ligue->ID);
                        $logo_url = $logo ? $logo['url'] : "/wp-content/uploads/2025/09/hand.png";
                        $logo_alt = $logo ? $logo['alt'] : get_the_title($ligue->ID);

                        if ($createur_id == $user_id) {
                            $role = 'propriétaire';
                        } else {
                            $participant_ids = [];
                            if (is_array($participants)) {
                                foreach ($participants as $p) {
                                    $participant_ids[] = is_object($p) ? $p->ID : $p;
                                }
                            }
                            $role = in_array($user_id, $participant_ids) ? 'déjà membre' : 'demander';
                        }

                        // Vérifier s'il existe déjà une demande en attente pour cet utilisateur dans cette ligue
                        $demandes_user = get_posts([
                            'post_type'   => 'demande',
                            'numberposts' => -1,
                            'meta_query'  => [
                                'relation' => 'AND',
                                [
                                    'key'     => 'ligue',
                                    'value'   => $ligue->ID, // ligue actuelle
                                    'compare' => 'LIKE',
                                ],
                                [
                                    'key'     => 'parieur',  // champ ACF contenant l'utilisateur
                                    'value'   => $user_id,
                                    'compare' => 'LIKE',
                                ],
                                [
                                    'key'     => 'status',
                                    'value'   => 'en_attente',
                                    'compare' => 'LIKE',
                                ]
                            ]
                        ]);

                        // Si une demande existe déjà, on change le rôle à 'demande en cours'
                        if (!empty($demandes_user)) {
                            $role = 'demande en cours';
                        }
                    ?>
                        <?php if ($role === 'demander'): ?>
                            <tr class="all-leagues-table-tr2 ligue-row" data-ligue-id="<?= esc_attr($ligue->ID); ?>">
                                <td><!--<img src="<?= esc_url($logo_url); ?>" width="30" alt="<?= esc_attr($logo_alt); ?>">--> <?= esc_html(get_the_title($ligue->ID)); ?></td>
                                <td><?= $total_participants; ?> participants <i class="fa fa-angle-right"></i></td>
                                
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucune ligue trouvée pour cet utilisateur.</p>
            <?php endif; ?>
        <?php else: ?>
            <?php 
            $ligue_post = get_post($ligue_id);
                if ($ligue_post && $ligue_post->post_type === 'ligue') {
                    $nom = get_the_title($ligue_post);
                    $participants = get_field('participants', $ligue_id) ?: [];
                    $createur_id = get_field('createur', $ligue_id);
                    if ($createur_id && !in_array($createur_id, $participants)) {
                        array_unshift($participants, $createur_id);
                    }

                    ?>
                    <div class="ligue-detail">
                        <div class="title-button">
                            <h2><?= esc_html($nom); ?></h2>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="action" value="rejoindre_ligue_par_page">
                                <input type="hidden" name="user_id" value="<?= $user_id; ?>">
                                <input type="hidden" name="ligue_id" value="<?= esc_attr($ligue_id); ?>">
                                <?php wp_nonce_field('rejoindre_ligue_par_page_nonce', 'ligue_nonce'); ?>
                                <button type="submit" class="action-button">Rejoindre la ligue</button>
                            </form>
                        </div>
                        <?php if (!empty($participants)) {
                            // 🔽 Construire tableau des joueurs avec stats
                            $data = [];
                            
                            foreach ($participants as $participant_id) {
                                $prenom  = get_user_meta($participant_id, 'first_name', true);
                                $pseudo = get_userdata($participant_id)->user_login;
                                $nom     = get_user_meta($participant_id, 'last_name', true);
                                $permalink = esc_url( site_url('/module-de-paris-joueur/?user_id=' . $participant_id) );
                                $paris_gagnes = (int) get_field('paris_gagnes', 'user_' . $participant_id);
                                $paris_effectues = (int) get_field('paris_effectues', 'user_' . $participant_id);
                                $paris_perdus = $paris_effectues-$paris_gagnes;
                                $ratio = $paris_effectues > 0  ? ceil($paris_gagnes *100 / $paris_effectues)   : 0;
                                $data[] = [
                                    'id'       => $participant_id,
                                    'nom'      => $nom,
                                    'prenom'   => $prenom,
                                    'pseudo'   => $pseudo,
                                    'permalink'      => $permalink,
                                    'points'   => (int) get_field('total_de_points', 'user_' . $participant_id),
                                    'paris_gagnes'   => $paris_gagnes,
                                    'paris_perdus'   => $paris_perdus,
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
                            echo '<thead><tr>
                                    <th>Clt</th>
                                    <th>Pseudo</th>
                                    <th><span class="desktop">G : P</span><span class="mobile">G : P</span></th>
                                    <th><span class="desktop">Ratio</span><span class="mobile">Ratio</span></th>
                                    <th>Points</th>
                                </tr></thead><tbody>';

                            $rang=1;
                            foreach ($data as $row) {
                                echo '<tr class="cg-table-tr">';
                                echo '<td>'.$rang.'</td>';
                                 echo '<td>'.$row['pseudo'].'</td>';
                                echo '<td>'.$row['paris_gagnes'].' : '.$row['paris_perdus'].'</td>';
                                echo '<td>'.$row['ratio'].' %</td>';
                                echo '<td>'.$row['points'].'</td>';
                                echo '</tr>';
                                $rang+=1;
                                
                            }

                            echo '</tbody></table>';
                        } else {
                            echo '<p>Pas de parieurs.</p>';
                        }
                        ?>
                        
                    </div>
                    <?php
                }

            ?>
        <?php endif; ?>
      
</div>

                <div id="toast" class="toast">✅ Demande envoyée avec succès !</div>
       

        <style>
            /* --- Toast notification --- */
            .toast {
            visibility: hidden;
            min-width: 250px;
            margin-left: -125px;
            background-color: #28a745;
            color: #fff;
            text-align: center;
            border-radius: 4px;
            padding: 12px;
            position: fixed;
            z-index: 9999;
            left: 50%;
            bottom: 30px;
            font-size: 16px;
            opacity: 0;
            transition: opacity 0.5s, bottom 0.5s;
            }
            .toast.show {
            visibility: visible;
            opacity: 1;
            bottom: 50px;
            }
            .title-button{
                display: flex;
                justify-content: space-between;
            }
            .action-button{
                    background-color: #1724f6;
                    color: #fff;
                    border-radius: 8px;
                    border: solid 1px #040A68;
                    padding: 10px 20px;
            }
            .all-leagues-table-tr2{
                background-color: #e1a0fc;
                padding: 4px 10px;
                border-radius: 8px;
                border-spacing: 10px;
                display: grid;
                grid-template-columns: 3fr  1fr;
                margin: 10px 0px;
                align-items: center;
                cursor: pointer;
            }
        </style>
       

        

         <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" defer></script>
        <script>
        jQuery(document).ready(function($){
              if (window.ligueCreated) {
                    const $toast = $("#toast");
                    $toast.addClass("show");

                    // cacher après 2.5s
                    setTimeout(() => {
                    $toast.removeClass("show");
                    // redirection différée
                    window.location.href = "/module-de-paris-ligues/"; 
                    }, 2500);
                }

          $(".ligue-row").on("click", function() {
            const ligueId = $(this).data("ligue-id");
            if (ligueId) {
            const url = new URL(window.location.href);
            url.searchParams.set('ligue_id', ligueId);
            window.location.href = url.toString();
            }
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
