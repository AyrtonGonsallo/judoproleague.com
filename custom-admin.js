// jQuery(document).ready(function($) {
//     // Votre code JavaScript personnalisé ici
//     console.log('Custom admin JS loaded!');
//     const headerDiv = $("<div class='block-acf-title block-liens'>Liens</div>"); // Changez "Titre de la Section" selon vos besoins

//     // Insérez la nouvelle div avant les éléments sélectionnés
//     $(headerDiv).insertBefore(".acf-field-64d38e5b22c75");
//     $( ".acf-field-64d38e5b22c75, .acf-field-64b0223d946c9, .acf-field-64b020b56a893" ).wrapAll( "<div class='block-liens-datas' />");

//     $( ".block-liens,.block-liens-datas" ).wrapAll( "<div class='new block-acf' />");
// });
jQuery(document).ready(function(jQuery) {
    // Votre code JavaScript personnalisé ici
    console.log('Custom admin JS loaded!');
        // Troisième section - "Infos"
    const headerDivInfos = jQuery("<div class='block-acf-title block-infos'>Infos</div>");
    jQuery(headerDivInfos).insertBefore(".acf-field-64b023183d968");  // Insérer avant le champ "Infos"
    
    // Regrouper les champs ACF sous la section "Infos"
    jQuery(".acf-field-64b023183d968, .acf-field-65e06ff8c068e, .acf-field-64b021e8946c7, .acf-field-64d36c965a371, .acf-field-64b020b566db5").wrapAll("<div class='block-infos-datas' />");

    // Envelopper la section "Infos"
    jQuery(".block-infos, .block-infos-datas").wrapAll("<div class='new block-acf block-infos' />");  
    // Première section - "Liens"
    const headerDivLiens = jQuery("<div class='block-acf-title block-liens'>Liens</div>");
    jQuery(headerDivLiens).insertBefore(".acf-field-64d38e5b22c75");  // Insérer avant le champ "Liens"
    
    // Regrouper les champs ACF sous la section "Liens"
    jQuery(".acf-field-64d38e5b22c75, .acf-field-64b0223d946c9, .acf-field-64b020b56a893").wrapAll("<div class='block-liens-datas' />");

    // Envelopper la section "Liens"
    jQuery(".block-liens, .block-liens-datas").wrapAll("<div class='new block-acf block-liens' />");


    // Deuxième section - "Niveau"
    const headerDivNiveau = jQuery("<div class='block-acf-title block-niveau'>Niveau</div>");
    jQuery(headerDivNiveau).insertBefore(".acf-field-64b02109946c5");  // Insérer avant le champ "Niveau"
    
    // Regrouper les champs ACF sous la section "Niveau"
    jQuery(".acf-field-64b1258ae733d, .acf-field-64b02109946c5, .acf-field-651acaba47511").wrapAll("<div class='block-niveau-datas' />");

    // Envelopper la section "Niveau"
    jQuery(".block-niveau, .block-niveau-datas").wrapAll("<div class='new block-acf block-niveau' />");

    /************************************************************************************************/
	
	// 1 section - "Video"
    const headerDivVideo = jQuery("<div class='block-acf-title block-video'>Vidéo</div>");
    jQuery(headerDivVideo).insertBefore(".acf-field-637ced16c9a12");  // Insérer avant le champ 
    
    // Regrouper les champs ACF sous la section "Video"
    jQuery(".acf-field-637ced16c9a12, .acf-field-637cecf8c9a11, .acf-field-637ced35c9a14, .acf-field-66c5b0d34a1f2").wrapAll("<div class='block-video-datas' />");

    // Envelopper la section "Video"
    jQuery(".block-video, .block-video-datas").wrapAll("<div class='new block-acf block-video' />");
	
	/********************************************/
	
    // 2 section - "Taggage"
    const headerDivTaggage = jQuery("<div class='block-acf-title block-taggage'>Taggage</div>");
    jQuery(headerDivTaggage).insertBefore(".acf-field-64c79eee47f63");  // Insérer avant le champ
    
    // Regrouper les champs ACF sous la section "Taggage"
    jQuery(".acf-field-64c79eee47f63 , .acf-field-64c79f0c47f64, .acf-field-66c5b0b64a1f1").wrapAll("<div class='block-taggage-datas' />");

    // Envelopper la section "Taggage"
    jQuery(".block-taggage, .block-taggage-datas").wrapAll("<div class='new block-acf block-taggage' />");
    
 



});
