<?php
/**
 * pro-league functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package pro-league
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}
define('THEMEDIR',trailingslashit( get_template_directory() ) );  // /home/ligipxrb/public_html/wp-content/themes/mytheme/
define('TEMPLATEURI',trailingslashit(get_template_directory_uri() )); //  url with ending slash https://mysite.com/wp-content/themes/mytheme/
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function pro_league_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on pro-league, use a find and replace
		* to change 'pro-league' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'pro-league', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'pro-league' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'pro_league_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'pro_league_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function pro_league_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'pro_league_content_width', 640 );
}
add_action( 'after_setup_theme', 'pro_league_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function pro_league_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'pro-league' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'pro-league' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'pro_league_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function pro_league_scripts() {
	wp_enqueue_style( 'pro-league-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'pro-league-style', 'rtl', 'replace' );

	wp_enqueue_script( 'pro-league-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script('pro-league-main', get_template_directory_uri() . '/js/main.js', array(), _S_VERSION, true);
	wp_enqueue_script('pro-league-customizer', get_template_directory_uri() . '/js/customizer.js', array(), _S_VERSION, true);

		
	
	wp_enqueue_script('flexslider-js', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array(), _S_VERSION, true);

	wp_register_style('flexslider', get_template_directory_uri() . '/css/flexslider.css', array(), false);
	wp_enqueue_style('flexslider');
		
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'pro_league_scripts' );


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
function my_custom_menu() {
    register_nav_menus(
        array(
            'my-custom-menu' => _( 'Classement menu' ),
        )
    );
}
add_action( 'init', 'my_custom_menu' );

function ajouter_video() {
 
	$my_post = array(
		'post_title'=>$_POST['post_details']['titre_video'],
		'post_type'=>'video_youtube', 
		'post_status' => 'publish',
	);
	$newpost_id = wp_insert_post($my_post);
 
	if($newpost_id) {
		$id = $_POST['post_details']['id_video'];
		$titre = $_POST['post_details']['titre_video'];
		$date_video = $_POST['post_details']['date_video'];
		$lien_image = $_POST['post_details']['lien_image'];
		add_post_meta($newpost_id, 'id', $id);
		add_post_meta($newpost_id, 'titre', $titre);
		add_post_meta($newpost_id, 'image', $lien_image);
		add_post_meta($newpost_id, 'date_dajout',$date_video );
		return "success";

	} else {
	
	return "failed";
	
	}
 
}

add_action( 'wp_ajax_ajouter_video', 'ajouter_video' );
add_action('wp_ajax_nopriv_ajouter_video','ajouter_video');
include_once( get_stylesheet_directory() . '/inc/plugins/acf/acf-custom-widget.php');
include_once( get_stylesheet_directory() . '/inc/plugins/acf/acf-custom-widget2.php');
function register_widget_areas() {

	register_sidebar( array(
	  'name'          => 'bandeau partenaires',
	  'id'            => 'bandeau_partenaires',
	  'description'   => 'le bandeau patenaires du footer',
	  
	));
	register_sidebar( array(
		'name'          => 'Gestionnaire Rencontres',
		'id'            => 'gestionnaire_rencontres',
		'description'   => 'Les rencontres du header',
		
	  ));
	  
	
	
  }
  add_shortcode( 'search_form', function() {
    ob_start();

    get_search_form();

    return ob_get_clean();
} );
  add_action( 'widgets_init', 'register_widget_areas' );





  function my_acf_admin_head() {
	?>
	<style type="text/css">
		div.widget-liquid-left{
			float: unset !important;
    		width: 90%;
		}
		div.widget-liquid-right{
			float: unset !important;
    		width: 90%;
		}
		#post-body.columns-2 #postbox-container-1 {
			float: right;
			margin-right: 0px;
			width: 100%;
		}
		#poststuff #post-body.columns-2 {
    		margin-right: 0px;
		}
		div#widgets-right .sidebars-column-1, div#widgets-right .sidebars-column-2{
			width:100% !important;
			max-width: 100% !important;
		}
	</style>
	<?php
	}
	
	add_action('acf/input/admin_head', 'my_acf_admin_head');


//---------------
// ----------------  sous pages pour équipes

$my_fake_pages = array(
	'infos' => 'Info générales',
	'actus' => 'Actualités',
	'photos' => 'Photos',
	'videos' => 'Vidéos',
	'calendrier_resultats' => 'Calendrier / Résultats',
	'judokas' => 'Judokas',
);
  
add_filter('rewrite_rules_array', 'fsp_insertrules');
add_filter('query_vars', 'fsp_insertqv');
  
// Adding fake pages' rewrite rules
function fsp_insertrules($rules)
{
	global $my_fake_pages;
  
	$newrules = array();
	foreach ($my_fake_pages as $slug => $title)
		$newrules['equipes/([^/]+)/' . $slug . '/?$'] = 'index.php?equipes=$matches[1]&fpage=' . $slug;
  
	return $newrules + $rules;
}
  
// Tell WordPress to accept our custom query variable
function fsp_insertqv($vars)
{
	array_push($vars, 'fpage');
	return $vars;
}

// Remove WordPress's default canonical handling function
 
remove_filter('wp_head', 'rel_canonical');
add_filter('wp_head', 'fsp_rel_canonical');
function fsp_rel_canonical()
{
	global $current_fp, $wp_the_query;
  
	if (!is_singular())
		return;
  
	if (!$id = $wp_the_query->get_queried_object_id())
		return;
  
	$link = trailingslashit(get_permalink($id));
  
	// Make sure fake pages' permalinks are canonical
	if (!empty($current_fp))
		$link .= user_trailingslashit($current_fp);
  
	echo '<link rel="canonical" href="'.$link.'" />';
}
// --------------    sous pages pour calendrier résultats


     
$my_fake_pages2 = array(
        'poules' => 'poules',
        'quarts' => 'quarts',
        'final4' => 'final4',
    );
      
    add_filter('rewrite_rules_array', 'fsp_insertrules2');
	add_filter('rewrite_rules_array', 'fsp_insertrules22');
    add_filter('query_vars', 'fsp_insertqv2');
      
    // Adding fake pages' rewrite rules
    function fsp_insertrules2($rules)
    {
        global $my_fake_pages2;
      
        $newrules2 = array();
        foreach ($my_fake_pages2 as $slug => $title)
            $newrules2['calendrier-resultats-2023/' . $slug . '/?$'] = 'index.php?pagename=calendrier-resultats-2023&fpage=' . $slug;

        return $newrules2 + $rules;
    }
	// Adding fake pages' rewrite rules
    function fsp_insertrules22($rules)
    {
        global $my_fake_pages2;
      
        $newrules22 = array();
        foreach ($my_fake_pages2 as $slug => $title)
			$newrules22['calendrier-resultat-judo-pro-league-2024/' . $slug . '/?$'] = 'index.php?pagename=calendrier-resultat-judo-pro-league-2024&fpage=' . $slug;

        return $newrules22 + $rules;
    }
      
    // Tell WordPress to accept our custom query variable
    function fsp_insertqv2($vars)
    {
        array_push($vars, 'fpage');
        return $vars;
    }
    remove_filter('wp_head', 'rel_canonical');
    add_filter('wp_head', 'fsp_rel_canonical2');
    function fsp_rel_canonical2()
    {
        global $current_fp, $wp_the_query;
      
        if (!is_singular())
            return;
      
        if (!$id = $wp_the_query->get_queried_object_id())
            return;
      
        $link = trailingslashit(get_permalink($id));
      
        // Make sure fake pages' permalinks are canonical
        if (!empty($current_fp))
            $link .= user_trailingslashit($current_fp);
      
        echo '<link rel="canonical" href="'.$link.'" />';
    }
// -------
// 
// 
// --------------    sous pages pour classement
     
$my_fake_pages3 = array(
	'poule-A' => 'poule-A',
	'poule-B' => 'poule-B',
	'poule-C' => 'poule-C',
	'poule-D' => 'poule-D',
);
  
add_filter('rewrite_rules_array', 'fsp_insertrules3');
add_filter('query_vars', 'fsp_insertqv3');
  
// Adding fake pages' rewrite rules
function fsp_insertrules3($rules)
{
	global $my_fake_pages3;
  
	$newrules3 = array();
	foreach ($my_fake_pages3 as $slug => $title)
		$newrules3['classement-judo-pro-league-2023/([^/]+)/' . $slug . '/?$'] = 'index.php?pagename=classement-judo-pro-league-2023&fpage=' . $slug;
  
	return $newrules3 + $rules;
}
  
// Tell WordPress to accept our custom query variable
function fsp_insertqv3($vars)
{
	array_push($vars, 'fpage');
	return $vars;
}
remove_filter('wp_head', 'rel_canonical');
add_filter('wp_head', 'fsp_rel_canonical3');
function fsp_rel_canonical3()
{
	global $current_fp, $wp_the_query;
  
	if (!is_singular())
		return;
  
	if (!$id = $wp_the_query->get_queried_object_id())
		return;
  
	$link = trailingslashit(get_permalink($id));
  
	// Make sure fake pages' permalinks are canonical
	if (!empty($current_fp))
		$link .= user_trailingslashit($current_fp);
  
	echo '<link rel="canonical" href="'.$link.'" />';
}
require THEMEDIR.'inc/fiche_rencontre.php';



function add_eps_acf_columns ( $columns ) {
	return array_merge ( $columns, array (
	  'equipes_par_saisons' => __ ( 'Équipes par saisons' ),
	) );
 }
 function add_sj_acf_columns ( $columns ) {
	return array_merge ( $columns, array (
	  'saisons' => __ ( 'Saisons' ),
	) );
 }

 add_filter ( 'manage_equipes_posts_columns', 'add_sj_acf_columns' );
 add_filter ( 'manage_judoka_posts_columns', 'add_eps_acf_columns' );
 add_filter ( 'manage_rencontre_posts_columns', 'add_sj_acf_columns' );
 
 function custom_column2 ( $column, $post_id ) {
	switch ( $column ) {
		case 'saisons':
			foreach ( get_post_meta ( $post_id, 'saisons', true ) as $metakey ){
				echo $metakey." ";
				// Similarly for all the fields you want to print
			}
			break;
		case 'equipe_judoka':
			echo  get_the_title(get_post_meta ( $post_id, 'equipe_judoka', true)[0]);
			break;
 
	}
 }
 // Populate the custom columns with the ACF data
 function custom_column($column, $post_id) {
    switch ($column) {
        case 'equipes_par_saisons':
            $equipes_par_saisons = get_field('equipes_par_saisons', $post_id);

            if ($equipes_par_saisons) {
                foreach ($equipes_par_saisons as $equipe) {
                    // Obtenir et afficher le titre de l'équipe
                    if (isset($equipe['equipe_judoka'])) {
                        $equipe_judoka_posts = $equipe['equipe_judoka'];
                        if (is_array($equipe_judoka_posts)) {
                            foreach ($equipe_judoka_posts as $post) {
                                if ($post instanceof WP_Post) {
                                    echo get_the_title($post->ID) . ' ';
                                }
                            }
                        } else {
                            if ($equipe_judoka_posts instanceof WP_Post) {
                                echo get_the_title($equipe_judoka_posts->ID) . ' ';
                            }
                        }
                    } else {
                        echo 'N/A ';
                    }

                    // Obtenir et afficher la saison
                    if (isset($equipe['saisons'])) {
                        $saison = $equipe['saisons'];
                        if (is_array($saison)) {
                            echo implode(', ', $saison) . ' ';
                        } else {
                            echo $saison . ' ';
                        }
                    } else {
                        echo 'N/A ';
                    }

                    echo '<br>';
                }
            }
            break;
    }
}

 function custom_column_single_choice ( $column, $post_id ) {
	switch ( $column ) {
		case 'saisons':
			echo get_post_meta ( $post_id, 'saisons', true );
		
 
	}
 }
function custom_rewrite_rules() {
    add_rewrite_rule(
        '^rencontre/([0-9]{4}-[0-9]{4})/([^/]+)/?$',
        'index.php?post_type=rencontre&saisons=$matches[1]&name=$matches[2]',
        'top'
    );
}
add_action( 'init', 'custom_rewrite_rules' );
add_filter('post_type_link', 'replace_custom_post_type_permalink', 10, 2);

function replace_custom_post_type_permalink($post_link, $post) {
    if ('rencontre' === $post->post_type) {
        $saisons = get_field('saisons', $post->ID);
        if ($saisons) {
            $post_link = str_replace('%saisons%', $saisons, $post_link);
        }
    }
    return $post_link;
}

 add_action ( 'manage_equipes_posts_custom_column', 'custom_column2', 10, 2 );
 add_action ( 'manage_judoka_posts_custom_column', 'custom_column', 10, 2 );
 add_action ( 'manage_rencontre_posts_custom_column', 'custom_column_single_choice', 10, 2 );


/********************************/






/************************************* back-office-rencontre*********************************************/
function custom_admin_css() {
	wp_enqueue_style('custom-admin-style', get_template_directory_uri() . '/custom-admin.css');
	wp_enqueue_style('custom-admin-style-2', get_template_directory_uri() . '/custom-admin-2.css');
	// Charger les fichiers JavaScript
    wp_enqueue_script('custom-admin-script', get_template_directory_uri() . '/custom-admin.js', array('jquery'), null, true);

}
add_action('admin_head', 'custom_admin_css');
/***********************************************************************************************************/


// Ajouter le champ de recherche auto-complété dans l'admin des images
function add_custom_image_fields_autocomplete($form_fields, $post) {
    $related_judoka_1 = get_post_meta($post->ID, 'related_judoka_1', true);
    $related_judoka_2 = get_post_meta($post->ID, 'related_judoka_2', true);
    $related_saison = get_post_meta($post->ID, 'related_saison', true);
    
    // Tableau de saisons
    $saisons = array(
        '2023-2024' => '2023-2024',
        '2024-2025' => '2024-2025',
        // Ajoutez d'autres saisons si nécessaire
    );

    // Obtenir tous les judokas
    $selected_judokas = get_posts(array('post_type' => 'judoka', 'numberposts' => -1)); 

    // Champ de recherche pour sélectionner un judoka
    ob_start(); ?>
    <input type="text" id="judoka-search" placeholder="Rechercher un judoka">
    <div id="judoka-results"></div>

    <p>Judokas associés à cette image</p>
    
    <label for="judoka1-select">Sélectionnez le judoka 1:</label>
    <select name="attachments[<?php echo $post->ID; ?>][related_judoka_1]" id="judoka1-select">
        <option value="">Choisir un judoka</option>
        <?php foreach ($selected_judokas as $judoka) : ?>
            <option value="<?php echo esc_attr($judoka->ID); ?>" <?php selected($related_judoka_1, $judoka->ID); ?>>
                <?php echo esc_html($judoka->post_title); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="judoka2-select">Sélectionnez le judoka 2:</label>
    <select name="attachments[<?php echo $post->ID; ?>][related_judoka_2]" id="judoka2-select">
        <option value="">Choisir un judoka</option>
        <?php foreach ($selected_judokas as $judoka) : ?>
            <option value="<?php echo esc_attr($judoka->ID); ?>" <?php selected($related_judoka_2, $judoka->ID); ?>>
                <?php echo esc_html($judoka->post_title); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <!-- Champ de sélection de saison -->
    <label for="saison-select">Sélectionnez une saison :</label>
    <select name="attachments[<?php echo $post->ID; ?>][related_saison]" id="saison-select">
        <option value="">Choisir une saison</option>
        <?php foreach ($saisons as $key => $value) : ?>
            <option value="<?php echo esc_attr($key); ?>" <?php selected($related_saison, $key); ?>>
                <?php echo esc_html($value); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <?php $field_html = ob_get_clean();

    $form_fields['related_judokas_autocomplete'] = array(
        'label' => 'Judokas associés',
        'input' => 'html',
        'html'  => $field_html,
    );

    return $form_fields;
}
add_filter('attachment_fields_to_edit', 'add_custom_image_fields_autocomplete', 10, 2);



// Sauvegarder les judokas associés lors de la sauvegarde des métadonnées de l'image
function save_related_judokas_meta($post, $attachment) {
	error_log('attachement is : ' . print_r($attachment, true));
        $judoka1_id = sanitize_text_field($attachment['related_judoka_1']);
		$judoka2_id = sanitize_text_field($attachment['related_judoka_2']);
		$saison = sanitize_text_field($attachment['related_saison']);
        update_post_meta($post['ID'], 'related_judoka_1', $judoka1_id);
		update_post_meta($post['ID'], 'related_judoka_2', $judoka2_id);
		update_post_meta($post['ID'], 'related_saison', $saison);
    
    return $post;
}
add_filter('attachment_fields_to_save', 'save_related_judokas_meta', 10, 2);


function hide_description_for_specific_post() {
    global $pagenow, $post;
    // Vérifie que nous sommes sur la page d'édition d'un post spécifique (ID 14)
    if ( $pagenow == 'post.php' && isset($post->ID) && $post->ID == 14 ) {
        echo '<style>
            #postdivrich { display: none !important; }
        </style>';
    }
}
add_action('admin_head', 'hide_description_for_specific_post');
function add_custom_editor_body_class($classes) {
    global $post;
    if ($post) {
        $classes .= ' page-id' . $post->ID;
    }
	// Assurez-vous que vous êtes sur la page d'édition d'une galerie
    if ( $post && get_post_type( $post ) == 'galerie' ) {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                // Ajoute un lien après le bouton "Mettre à jour"
                $('#publishing-action').append('<a href="/wp-admin/admin.php?page=image-multi-selector&galerie=<? echo $post->ID;?>" target="_blank" class="button button-secondary images-tagger-link" style="margin-left: 10px;">Taguer les images</a>');
				$('.acf-gallery-toolbar').append('<a href="/wp-admin/admin.php?page=image-multi-selector&galerie=<? echo $post->ID;?>" target="_blank" class="button button-secondary images-tagger-link" style="margin-left: 10px;">Taguer les images</a>');
				
			});
        </script>
        <?php
    }
    return $classes;
}
add_filter('admin_body_class', 'add_custom_editor_body_class');


// Enregistrer les judokas et la saison associés aux images sélectionnées
function save_related_judokas() {
    // Vérifier les permissions de l'utilisateur
    if (!current_user_can('edit_posts')) {
        wp_send_json_error('Vous n\'avez pas la permission d\'effectuer cette action.');
        return;
    }

    // Récupérer les données envoyées via AJAX
    $image_ids = isset($_POST['images']) ? $_POST['images'] : array();
    $judoka1_id = sanitize_text_field($_POST['judoka1']);
    $judoka2_id = sanitize_text_field($_POST['judoka2']);
    $saison = sanitize_text_field($_POST['saison']);

    // Vérifier qu'il y a des images sélectionnées
    if (empty($image_ids)) {
        wp_send_json_error('Aucune image sélectionnée.');
        return;
    }

    // Parcourir chaque image et sauvegarder les métadonnées
    foreach ($image_ids as $image_id) {
        update_post_meta($image_id, 'related_judoka_1', $judoka1_id);
        update_post_meta($image_id, 'related_judoka_2', $judoka2_id);
        update_post_meta($image_id, 'related_saison', $saison);
    }

    wp_send_json_success();
}
add_action('wp_ajax_save_related_judokas', 'save_related_judokas');

function filter_acf_rencontre_relationship_query( $args, $field, $post_id ) {
    // Vérifier si le champ est celui qui concerne "rencontre"
    if ( $field['name'] === 'rencontre' ) {
        
		// Filtrer par saison
		$args['meta_query'][] = array(
			'key'     => 'saisons', // Le nom de votre champ personnalisé qui stocke les saisons
			'value'   => "2024-2025",
			'compare' => 'LIKE'
		);
        
        // Trier par date_de_debut (descendant)
        $args['orderby'] = 'title'; // Trier par valeur numérique
        $args['order'] = 'ASC'; // Trier dans l'ordre décroissant
    }

    return $args;
}
add_filter( 'acf/fields/relationship/query/name=rencontre', 'filter_acf_rencontre_relationship_query', 10, 3 );
