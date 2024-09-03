<?php

function prettyPrint($array) {
	echo '<pre>'.print_r($array, true).'</pre>';
}
$steps=array("FINAL FOUR","QUARTS DE FINALE C & D","QUARTS DE FINALE A & B","Poule A","Poule B","Poule C","Poule D");
$results=array();
function array_msort($array, $cols)
	{
		$colarr = array();
		foreach ($cols as $col => $order) {
			$colarr[$col] = array();
			foreach ($array as $k => $row) { $colarr[$col]['_'.$k] = strtolower($row[$col]); }
		}
		$eval = 'array_multisort(';
		foreach ($cols as $col => $order) {
			$eval .= '$colarr[\''.$col.'\'],'.$order.',';
		}
		$eval = substr($eval,0,-1).');';
		eval($eval);
		$ret = array();
		foreach ($colarr as $col => $arr) {
			foreach ($arr as $k => $v) {
				$k = substr($k,1);
				if (!isset($ret[$k])) $ret[$k] = $array[$k];
				$ret[$k][$col] = $array[$k][$col];
			}
		}
		return $ret;
	
	}
	
?>


<?php  function get_classement_judokas_home( $saison_value,$limit){
	$args = array(
		'post_type'=> 'rencontre',
		'posts_per_page' => -1,
		'meta_key' => 'date_de_debut',
		'orderby' => 'meta_value_num',
		'order' => 'DESC',
		'meta_query'     => 
		array(  
			array(
				'key'        => 'saisons',
				'compare'    => 'LIKE',
				'value'      => $saison_value
			)
		),	
	);
	$rencontres = new WP_Query( $args );
	//prettyPrint($rencontres->posts);exit(-1);
	foreach($rencontres->posts as $rencontre){
		$phase=get_field("phase",$rencontre->ID)[0];
		
		$matchs_liste=get_field('les_combat',$rencontre->ID);
		if($matchs_liste){
			//prettyPrint(get_field('les_combat')[0]['combats'][0]);exit(-1); 
			
			//echo sizeof($matchs_liste).' combats<br>';
			foreach($matchs_liste as $matchs){
				
				//echo sizeof($matchs['combats']).' matchs<br>';
				//prettyPrint($matchs['combats']);exit(-1);
				foreach($matchs['combats'] as $match){
					$judoka1=$match['judoka_equipe_1'][0];
					$judoka2=$match['judoka_equipe_2'][0];
					$equipes_par_saisons_1 =get_field('equipes_par_saisons',$judoka1->ID);
					$equipes_par_saisons_2 =get_field('equipes_par_saisons',$judoka2->ID);
					$equipe1=null;
					$equipe2=null;
					//var_dump($equipes_par_saisons);
					if ($equipes_par_saisons_1) {
						foreach ($equipes_par_saisons_1 as $eq1) {
							// Obtenir et afficher le titre de l'équipe
							if (isset($eq1['equipe_judoka']) && isset($eq1['saisons']) ) {
								//var_dump($eq1['saisons'][0]);
									
									if( $eq1['saisons'][0]== $saison_value){
										$equipe1 = $eq1['equipe_judoka'][0];
									}
									
								
							}
							

						}
					}

					//var_dump($equipes_par_saisons);
					if ($equipes_par_saisons_2) {
						foreach ($equipes_par_saisons_2 as $eq2) {
							// Obtenir et afficher le titre de l'équipe
							if (isset($eq2['equipe_judoka']) && isset($eq2['saisons']) ) {
								//var_dump($equipe1['saisons'][0]);
									
									if( $eq2['saisons'][0]== $saison_value){
										$equipe2 = $eq2['equipe_judoka'][0];
									}
									
								
							}
							

						}
					}
					$sigle_club1=' ('.get_field( 'abreviation',$equipe1->ID ).') ';
					$sigle_club2=' ('.get_field( 'abreviation',$equipe2->ID ).') ';
					$club1=($equipe1->post_title)?' ('.$equipe1->post_title.') ':'';
					$club2=($equipe2->post_title)?' ('.$equipe2->post_title.') ':'';
					
					//$club1=(get_field( 'club_actuel',$judoka1->ID ))?' ('.get_field( 'club_actuel',$judoka1->ID ).') ':'';
					//$club2=(get_field( 'club_actuel',$judoka2->ID ))?' ('.get_field( 'club_actuel',$judoka2->ID ).') ':'';
					$results['total'][$judoka1->post_title]=[array("nom"=>get_field( 'prenom_judoka',$judoka1->ID ).' '.get_field( 'nom_judoka',$judoka1->ID ).''.$sigle_club1)];
					$results['total'][$judoka2->post_title]=[array("nom"=>get_field( 'prenom_judoka',$judoka2->ID ).' '.get_field( 'nom_judoka',$judoka2->ID ).''.$sigle_club2)];
					
				}
			}
		}
	}
	foreach($rencontres->posts as $rencontre){
		$phase=get_field("phase",$rencontre->ID)[0];
		$mode_de_calcul_classement=get_field("mode_de_calcul_classement",$rencontre->ID);

		$matchs_liste=get_field('les_combat',$rencontre->ID);
		if($matchs_liste){
			//prettyPrint(get_field('les_combat')[0]['combats'][0]);exit(-1); 
			
			//echo sizeof($matchs_liste).' combats<br>';
			
			foreach($matchs_liste as $matchs){
				$ippons_equ1=0;
				$ippons_equ2=0;
				$i=0;
				$winner= $matchs['equipe_gagnante'];
				foreach($matchs['combats'] as $match){
					//prettyPrint($match);exit(-1);
					$judoka1=$match['judoka_equipe_1'][0];
					$judoka_gagnant=$match['judoka_gagnant'];
					$judoka2=$match['judoka_equipe_2'][0];
					
					$results['total'][$judoka1->post_title][0]["sexe"]=get_field('sexe',$judoka1->ID);
					$results['total'][$judoka2->post_title][0]["sexe"]=get_field('sexe',$judoka2->ID);
					$results['total'][$judoka1->post_title][0]["categorie_de_poids"]=get_field('categorie_de_poids',$judoka1->ID);
					$results['total'][$judoka2->post_title][0]["categorie_de_poids"]=get_field('categorie_de_poids',$judoka2->ID);
					if(get_field('date_de_naissance',$judoka1->ID)){
						$birthDate = explode("/", get_field('date_de_naissance',$judoka1->ID));
						//get age from date or birthdate
						$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
						  ? ((date("Y") - $birthDate[2]))
						  : (date("Y") - $birthDate[2]));
						$results['total'][$judoka1->post_title][0]["age"]=$age;
					}
					if(get_field('date_de_naissance',$judoka2->ID)){
						$birthDate = explode("/", get_field('date_de_naissance',$judoka2->ID));
						//get age from date or birthdate
						$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
						  ? ((date("Y") - $birthDate[2]))
						  : (date("Y") - $birthDate[2]));
						$results['total'][$judoka2->post_title][0]["age"]=$age;
					}
					$results['total'][$judoka1->post_title][0]["categorie_dage"]=get_field('categorie_dage',$judoka1->ID);
					$results['total'][$judoka2->post_title][0]["categorie_dage"]=get_field('categorie_dage',$judoka2->ID);
					$results['total'][$judoka1->post_title][0]["image"]=get_the_post_thumbnail_url($judoka1->ID,'thumbnail')?get_the_post_thumbnail_url ($judoka1->ID,'thumbnail'):'/wp-content/uploads/2023/09/profil.jpg';
					$results['total'][$judoka2->post_title][0]["image"]=get_the_post_thumbnail_url($judoka2->ID,'thumbnail')?get_the_post_thumbnail_url ($judoka2->ID,'thumbnail'):'/wp-content/uploads/2023/09/profil.jpg';
					$results['total'][$judoka1->post_title][0]["post_title"]=$judoka1->post_title;
					$results['total'][$judoka2->post_title][0]["post_title"]=$judoka2->post_title;
					$equipes_par_saisons_1 =get_field('equipes_par_saisons',$judoka1->ID);
					$equipes_par_saisons_2 =get_field('equipes_par_saisons',$judoka2->ID);
					$equipe1=null;
					$equipe2=null;
					//var_dump($equipes_par_saisons);
					if ($equipes_par_saisons_1) {
						foreach ($equipes_par_saisons_1 as $eq1) {
							// Obtenir et afficher le titre de l'équipe
							if (isset($eq1['equipe_judoka']) && isset($eq1['saisons']) ) {
								//var_dump($eq1['saisons'][0]);
									
									if( $eq1['saisons'][0]== $saison_value){
										$equipe1 = $eq1['equipe_judoka'][0];
									}
									
								
							}
							

						}
					}

					//var_dump($equipes_par_saisons);
					if ($equipes_par_saisons_2) {
						foreach ($equipes_par_saisons_2 as $eq2) {
							// Obtenir et afficher le titre de l'équipe
							if (isset($eq2['equipe_judoka']) && isset($eq2['saisons']) ) {
								//var_dump($equipe1['saisons'][0]);
									
									if( $eq2['saisons'][0]== $saison_value){
										$equipe2 = $eq2['equipe_judoka'][0];
									}
									
								
							}
							

						}
					}
					$results['total'][$judoka1->post_title][0]["matchs_joués"]+=1;
					$results['total'][$judoka2->post_title][0]["matchs_joués"]+=1;
					if($i==0){
						$results['total'][$judoka1->post_title][0]["nombre_de_rencontres"]+=1;
						$results['total'][$judoka2->post_title][0]["nombre_de_rencontres"]+=1;
					}if($judoka_gagnant!=null && $judoka_gagnant==1){
						$results['total'][$judoka1->post_title][0]["matchs_v"]+=1;
						$results['total'][$judoka2->post_title][0]["matchs_d"]+=1;
						
					}else if($judoka_gagnant!=null && $judoka_gagnant==2){
						$results['total'][$judoka1->post_title][0]["matchs_d"]+=1;
						$results['total'][$judoka2->post_title][0]["matchs_v"]+=1;
					}else{
						$results['total'][$judoka1->post_title][0]["matchs_nuls"]+=1;
						$results['total'][$judoka2->post_title][0]["matchs_nuls"]+=1;
					}
					
					if($match['valeurs_shidos_judoka_1']){
						if (is_numeric($match['valeurs_shidos_judoka_1']['value'])){
							//$ippons_equ1+=1;
							$results['total'][$judoka1->post_title][0]["shidos_encaissés"]+=$match['valeurs_shidos_judoka_1']['value'];
							$results['total'][$judoka2->post_title][0]["shidos_gagnés"]+=$match['valeurs_shidos_judoka_1']['value'];
						}else if($match['valeurs_shidos_judoka_1']['value']=="H"||$match['valeurs_shidos_judoka_1']['value']=="X"){
							$results['total'][$judoka1->post_title][0]["hansokumake_encaissés"]+=1;
							$results['total'][$judoka2->post_title][0]["hansokumake_gagnés"]+=1;
						}
					}
					if($match['valeurs_shidos_judoka_2']){
						if (is_numeric($match['valeurs_shidos_judoka_2']['value'])){
							//$ippons_equ1+=1;
							$results['total'][$judoka1->post_title][0]["shidos_gagnés"]+=$match['valeurs_shidos_judoka_2']['value'];
							$results['total'][$judoka2->post_title][0]["shidos_encaissés"]+=$match['valeurs_shidos_judoka_2']['value'];
						}else if($match['valeurs_shidos_judoka_2']['value']=="H"||$match['valeurs_shidos_judoka_2']['value']=="X"){
							$results['total'][$judoka1->post_title][0]["hansokumake_gagnés"]+=1;
							$results['total'][$judoka2->post_title][0]["hansokumake_encaissés"]+=1;
						}
					}
					if($mode_de_calcul_classement=="auto"){
						//lire les ippons(ippon1,ippon2) du fichier pour le classement
						$results['total'][$judoka1->post_title][0]["ippons_marqués"]+=$match['valeur_ippons_comptés_judoka_1'];
						$results['total'][$judoka2->post_title][0]["ippons_concédés"]+=$match['valeur_ippons_comptés_judoka_1'];
						$results['total'][$judoka2->post_title][0]["ippons_marqués"]+=$match['valeur_ippons_comptés_judoka_2'];
						$results['total'][$judoka1->post_title][0]["ippons_concédés"]+=$match['valeur_ippons_comptés_judoka_2'];
					}else if($mode_de_calcul_classement=="manual"){	
						
						if (($match['valeur_ippon_judoka_1']>=1)){
							if((is_numeric($match['valeurs_shidos_judoka_2']['value']))){
								//si il y 0,1,2 shidos en face
								$results['total'][$judoka1->post_title][0]["ippons_marqués"]+=$match['valeur_ippon_judoka_1'];
								$results['total'][$judoka2->post_title][0]["ippons_concédés"]+=$match['valeur_ippon_judoka_1'];
							}else if(!(is_numeric($match['valeurs_shidos_judoka_2']['value']))){
								//si il y a penalité H,X,A,F,M en face
								$results['total'][$judoka1->post_title][0]["ippons_marqués"]+=($match['valeur_ippon_judoka_1']-1);
								$results['total'][$judoka2->post_title][0]["ippons_concédés"]+=($match['valeur_ippon_judoka_1']-1);
							}
							
						}
						if (($match['valeur_ippon_judoka_2']>=1)){
							if((is_numeric($match['valeurs_shidos_judoka_1']['value']))){
								//si il y 0,1,2 shidos en face
								$results['total'][$judoka2->post_title][0]["ippons_marqués"]+=$match['valeur_ippon_judoka_2'];
								$results['total'][$judoka1->post_title][0]["ippons_concédés"]+=$match['valeur_ippon_judoka_2'];
							}else if(!(is_numeric($match['valeurs_shidos_judoka_1']['value']))){
								//si il y a penalité H,X,A,F,M en face
								$results['total'][$judoka2->post_title][0]["ippons_marqués"]+=($match['valeur_ippon_judoka_2']-1);
								$results['total'][$judoka1->post_title][0]["ippons_concédés"]+=($match['valeur_ippon_judoka_2']-1);
							}
						}
					}
					if ($match['valeur_wazari__judoka_1']>=1){
						$results['total'][$judoka1->post_title][0]["wazaris_marqués"]+=$match['valeur_wazari__judoka_1'];
						$results['total'][$judoka2->post_title][0]["wazaris_concédés"]+=$match['valeur_wazari__judoka_1'];
					}
					if ($match['valeur_wazari__judoka_2']>=1){
						$results['total'][$judoka2->post_title][0]["wazaris_marqués"]+=$match['valeur_wazari__judoka_2'];
						$results['total'][$judoka1->post_title][0]["wazaris_concédés"]+=$match['valeur_wazari__judoka_2'];
					}
					$results['total'][$judoka2->post_title][0]["points_judoka"]+=($match['points_judoka_2'])?$match['points_judoka_2']:0;
					$results['total'][$judoka1->post_title][0]["points_judoka"]+=($match['points_judoka_1'])?$match['points_judoka_1']:0;
					$i++;
					$results['total'][$judoka1->post_title][0]["step"]='total';
					$results['total'][$judoka2->post_title][0]["step"]='total';
					$results['total'][$judoka1->post_title][0]["judoka_id"]=$judoka1->ID;
					$results['total'][$judoka2->post_title][0]["judoka_id"]=$judoka2->ID;
				}
				if($results['total'][$judoka1->post_title][0]["ippons_marqués"]>=6){
					$results['total'][$judoka1->post_title][0]["bonus"]=1;
				}
				if($results['total'][$judoka2->post_title][0]["ippons_marqués"]>=6){
					$results['total'][$judoka2->post_title][0]["bonus"]=1;
				}
				if ($winner=='équipe 1'){
					$results['total'][$judoka1->post_title][0]["victoires"]+=1;
					$results['total'][$judoka2->post_title][0]["defaites"]+=1;
					$results['total'][$judoka1->post_title][0]["points"]+=3;
					$results['total'][$judoka2->post_title][0]["points"]+=0;
				}
				if ($winner=='inconnue'){
					$results['total'][$judoka1->post_title][0]["nuls"]+=1;
					$results['total'][$judoka2->post_title][0]["nuls"]+=1;
					$results['total'][$judoka1->post_title][0]["points"]+=1;
					$results['total'][$judoka2->post_title][0]["points"]+=1;
				}
				if ($winner=='équipe 2'){
					$results['total'][$judoka1->post_title][0]["defaites"]+=1;
					$results['total'][$judoka2->post_title][0]["victoires"]+=1;
					$results['total'][$judoka1->post_title][0]["points"]+=0;
					$results['total'][$judoka2->post_title][0]["points"]+=3;
				}
				
			}
		}
	}
	//prettyPrint($results);
	//exit(-1);
	
	
	$sorted_results=array();
	$sorted_result_ids=array();
	
	foreach($results['total'] as $result){
		array_push($sorted_result_ids,array("id"=>$result[0]["post_title"],"wazaris_marqués"=>$result[0]["wazaris_marqués"],"matchs_v"=>$result[0]["matchs_v"],"points_judoka"=>$result[0]["points_judoka"],"ippons_marqués"=>$result[0]["ippons_marqués"]));
	}
	
	$sorted_result_ids2=array_slice(array_msort($sorted_result_ids,array('matchs_v'=>SORT_DESC,'ippons_marqués'=>SORT_DESC,'wazaris_marqués'=>SORT_DESC,'points_judoka'=>SORT_DESC)),0,$limit);
	$i=0;
	foreach($sorted_result_ids2 as $s2){
		
		$sorted_results['total'][$s2["id"]]=$results['total'][$s2["id"]];
	}
	
	return $sorted_results;

}



 function get_classement($rencontres,$saison_value,$limit){
	foreach($rencontres as $rencontre){
		//prettyPrint(get_field('les_combat')[0]['combats'][0]);exit(-1); 
		$matchs_liste=get_field('les_combat',$rencontre->ID);
		//echo sizeof($matchs_liste).' combats<br>'; 
		if(!$matchs_liste[0]['combats']){
			$equipe1=get_field( 'equipe_1',$rencontre->ID)[0];
			$equipe2=get_field( 'equipe_2',$rencontre->ID)[0];
			
			//prettyPrint($equipe1);exit(-1); 
			$results[$equipe1->post_title]=[array("nom"=>$equipe1->post_title)];
			$results[$equipe2->post_title]=[array("nom"=>$equipe2->post_title)];
		}else{
			foreach($matchs_liste as $matchs){
			
				//echo sizeof($matchs['combats']).' matchs<br>';
				//prettyPrint($matchs['combats']);exit(-1);
				foreach($matchs['combats'] as $match){
					$judoka1=$match['judoka_equipe_1'][0];
					$judoka2=$match['judoka_equipe_2'][0];
					$equipes_par_saisons_1 =get_field('equipes_par_saisons',$judoka1->ID);
					$equipes_par_saisons_2 =get_field('equipes_par_saisons',$judoka2->ID);
					$equipe1=null;
					$equipe2=null;
					//var_dump($equipes_par_saisons);
					if ($equipes_par_saisons_1) {
						foreach ($equipes_par_saisons_1 as $eq1) {
							// Obtenir et afficher le titre de l'équipe
							if (isset($eq1['equipe_judoka']) && isset($eq1['saisons']) ) {
								//var_dump($eq1['saisons'][0]);
									
									if( $eq1['saisons'][0]== $saison_value){
										$equipe1 = $eq1['equipe_judoka'][0];
									}
									
								
							}
							

						}
					}

					//var_dump($equipes_par_saisons);
					if ($equipes_par_saisons_2) {
						foreach ($equipes_par_saisons_2 as $eq2) {
							// Obtenir et afficher le titre de l'équipe
							if (isset($eq2['equipe_judoka']) && isset($eq2['saisons']) ) {
								//var_dump($equipe1['saisons'][0]);
									
									if( $eq2['saisons'][0]== $saison_value){
										$equipe2 = $eq2['equipe_judoka'][0];
									}
									
								
							}
							

						}
					}
					/**if(!$equipe1 || !$equipe2){
						echo 'erreur';
						prettyPrint($match);exit(-1); 
					}**/
					$results[$equipe1->post_title]=[array("nom"=>$equipe1->post_title)];
					$results[$equipe2->post_title]=[array("nom"=>$equipe2->post_title)];
					$results[$equipe1->post_title][0]["conference"]=get_field('conference',$equipe1->ID);
					$results[$equipe2->post_title][0]["conference"]=get_field('conference',$equipe2->ID);

					$results[$equipe1->post_title][0]["points"]=0;
					$results[$equipe2->post_title][0]["points"]=0;
				}
			}
		}
		
	}
	//prettyPrint($results);exit(-1); 
	foreach($rencontres as $rencontre){
		$mode_de_calcul_classement=get_field("mode_de_calcul_classement",$rencontre->ID);

		$matchs_liste=get_field('les_combat',$rencontre->ID);
		//prettyPrint($mode_de_calcul_classement);exit(1);
		
		if(!$matchs_liste[0]['combats']){
			$equipe1=get_field( 'equipe_1',$rencontre->ID)[0];
			$equipe2=get_field( 'equipe_2',$rencontre->ID)[0];
			$results[$equipe1->post_title][0]["nombre_de_rencontres"]+=0;
			$results[$equipe2->post_title][0]["nombre_de_rencontres"]+=0;
			
		
		}else{
			$equipe1=get_field( 'equipe_1',$rencontre->ID )[0];
			$equipe2=get_field( 'equipe_2',$rencontre->ID )[0];
			if($equipe1->ID){
				$results[$equipe1->post_title][0]["id"]=$equipe1->ID;
				$results[$equipe1->post_title][0]["image"]=get_field('logo_circle', $equipe1->ID);
			}
			if($equipe2->ID){
				$results[$equipe2->post_title][0]["id"]=$equipe2->ID;
				$results[$equipe2->post_title][0]["image"]=get_field('logo_circle', $equipe2->ID);	
			}
					
			$results[$equipe1->post_title][0]["points_marqués"]+=intval($matchs_liste[0]['points_equipe_1']);
			$results[$equipe2->post_title][0]["points_marqués"]+=intval($matchs_liste[0]['points_equipe_2']);
			$results[$equipe1->post_title][0]["bonus"]+=($matchs_liste[0]['bonus_equipe_1'])?intval($matchs_liste[0]['bonus_equipe_1']):0;
			$results[$equipe2->post_title][0]["bonus"]+=($matchs_liste[0]['bonus_equipe_2'])?intval($matchs_liste[0]['bonus_equipe_2']):0;
			foreach($matchs_liste as $matchs){
				
				
				$winner= $matchs['equipe_gagnante'];
				foreach($matchs['combats'] as $match){
					//prettyPrint($match);//exit(-1);
					$judoka1=$match['judoka_equipe_1'][0];
					$judoka2=$match['judoka_equipe_2'][0];
					$equipes_par_saisons_1 =get_field('equipes_par_saisons',$judoka1->ID);
					$equipes_par_saisons_2 =get_field('equipes_par_saisons',$judoka2->ID);
					$equipe1=null;
					$equipe2=null;
					//var_dump($equipes_par_saisons);
					if ($equipes_par_saisons_1) {
						foreach ($equipes_par_saisons_1 as $eq1) {
							// Obtenir et afficher le titre de l'équipe
							if (isset($eq1['equipe_judoka']) && isset($eq1['saisons']) ) {
								//var_dump($eq1['saisons'][0]);
									
									if( $eq1['saisons'][0]== $saison_value){
										$equipe1 = $eq1['equipe_judoka'][0];
									}
									
								
							}
							

						}
					}

					//var_dump($equipes_par_saisons);
					if ($equipes_par_saisons_2) {
						foreach ($equipes_par_saisons_2 as $eq2) {
							// Obtenir et afficher le titre de l'équipe
							if (isset($eq2['equipe_judoka']) && isset($eq2['saisons']) ) {
								//var_dump($equipe1['saisons'][0]);
									
									if( $eq2['saisons'][0]== $saison_value){
										$equipe2 = $eq2['equipe_judoka'][0];
									}
									
								
							}
							

						}
					}
					$judoka_gagnant = $match['judoka_gagnant'];
					if($judoka_gagnant!=null && $judoka_gagnant==1){
						$results[$equipe1->post_title][0]["combats_gagnés"]+=1;
						$results[$equipe2->post_title][0]["combats_perdus"]+=1;
					}else if($judoka_gagnant!=null && $judoka_gagnant==2){
						$results[$equipe2->post_title][0]["combats_gagnés"]+=1;
						$results[$equipe1->post_title][0]["combats_perdus"]+=1;
					}else{
						$results[$equipe1->post_title][0]["combats_nuls"]+=1;
						$results[$equipe2->post_title][0]["combats_nuls"]+=1;
					}
					$results[$equipe1->post_title][0]["combats_j"]+=1;
						$results[$equipe2->post_title][0]["combats_j"]+=1;
					$results[$equipe1->post_title][0]["error"]=$rencontre->ID.' : '.$judoka1->ID.' : '.$judoka1->post_title;
					$results[$equipe2->post_title][0]["error"]=$rencontre->ID.' : '.$judoka2->ID.' : '.$judoka2->post_title;
					//echo($mode_de_calcul_classement)exit(-1);
					if($mode_de_calcul_classement=="auto"){
						//lire les ippons(ippon1,ippon2) du fichier pour le classement
						$results[$equipe1->post_title][0]["ippons_marqués"]+=$match['valeur_ippons_comptés_judoka_1'];
						$results[$equipe2->post_title][0]["ippons_concédés"]+=$match['valeur_ippons_comptés_judoka_1'];
						$results[$equipe2->post_title][0]["ippons_marqués"]+=$match['valeur_ippons_comptés_judoka_2'];
						$results[$equipe1->post_title][0]["ippons_concédés"]+=$match['valeur_ippons_comptés_judoka_2'];
					}else if($mode_de_calcul_classement=="manual"){	
						
						if (($match['valeur_ippon_judoka_1']>=1)){
							if((is_numeric($match['valeurs_shidos_judoka_2']['value']))){
								//si il y 0,1,2 shidos en face
								$results[$equipe1->post_title][0]["ippons_marqués"]+=$match['valeur_ippon_judoka_1'];
								$results[$equipe2->post_title][0]["ippons_concédés"]+=$match['valeur_ippon_judoka_1'];
							}else if(!(is_numeric($match['valeurs_shidos_judoka_2']['value']))){
								//si il y a penalité H,X,A,F,M en face
								$results[$equipe1->post_title][0]["ippons_marqués"]+=($match['valeur_ippon_judoka_1']-1);
								$results[$equipe2->post_title][0]["ippons_concédés"]+=($match['valeur_ippon_judoka_1']-1);
							}
							
						}
						if (($match['valeur_ippon_judoka_2']>=1)){
							if((is_numeric($match['valeurs_shidos_judoka_1']['value']))){
								//si il y 0,1,2 shidos en face
								$results[$equipe2->post_title][0]["ippons_marqués"]+=$match['valeur_ippon_judoka_2'];
								$results[$equipe1->post_title][0]["ippons_concédés"]+=$match['valeur_ippon_judoka_2'];
							}else if(!(is_numeric($match['valeurs_shidos_judoka_1']['value']))){
								//si il y a penalité H,X,A,F,M en face
								$results[$equipe2->post_title][0]["ippons_marqués"]+=($match['valeur_ippon_judoka_2']-1);
								$results[$equipe1->post_title][0]["ippons_concédés"]+=($match['valeur_ippon_judoka_2']-1);
							}
						}
					}
					if ($match['valeur_wazari__judoka_1']>=1){
						$results[$equipe1->post_title][0]["wazaris_marqués"]+=$match['valeur_wazari__judoka_1'];
						$results[$equipe2->post_title][0]["wazaris_concédés"]+=$match['valeur_wazari__judoka_1'];
					}
					if ($match['valeur_wazari__judoka_2']>=1){
						$results[$equipe2->post_title][0]["wazaris_marqués"]+=$match['valeur_wazari__judoka_2'];
						$results[$equipe1->post_title][0]["wazaris_concédés"]+=$match['valeur_wazari__judoka_2'];
					}
					
				}
				
				$results[$equipe1->post_title][0]["nombre_de_rencontres"]+=1;
				$results[$equipe2->post_title][0]["nombre_de_rencontres"]+=1;
				if ($winner=='équipe 1'){
					$results[$equipe1->post_title][0]["victoires"]+=1;
					$results[$equipe2->post_title][0]["defaites"]+=1;
					$results[$equipe1->post_title][0]["points"]+=3;
					$results[$equipe2->post_title][0]["points"]+=0;
				}
				if ($winner=='inconnue'){
					$results[$equipe1->post_title][0]["nuls"]+=1;
					$results[$equipe2->post_title][0]["nuls"]+=1;
					$results[$equipe1->post_title][0]["points"]+=1;
					$results[$equipe2->post_title][0]["points"]+=1;
				}
				if ($winner=='équipe 2'){
					$results[$equipe1->post_title][0]["defaites"]+=1;
					$results[$equipe2->post_title][0]["victoires"]+=1;
					$results[$equipe1->post_title][0]["points"]+=0;
					$results[$equipe2->post_title][0]["points"]+=3;
				}
			}
			
		}
	}	
		
	//prettyPrint($results);
	//exit(-1);
	$sorted_results=array();
	$sorted_result_ids=array();
	
	foreach($results as $result){
		array_push($sorted_result_ids,array("id"=>$result[0]["nom"],"points"=>$result[0]["points"],"points_marqués"=>$result[0]["points_marqués"],"ippons_marqués"=>$result[0]["ippons_marqués"]));
	}
	
	$sorted_result_ids2=array_slice(array_msort($sorted_result_ids,array('points'=>SORT_DESC,'points_marqués'=>SORT_DESC,'ippons_marqués'=>SORT_DESC,'id'=>SORT_ASC)),0,$limit);
	$i=0;
	foreach($sorted_result_ids2 as $s2){
		if($i<2){
			$results[$s2["id"]][0]["qualifié"]=1;
		}else{
			$results[$s2["id"]][0]["qualifié"]=0;
		}
		$i++;
		$sorted_results[$s2["id"]]=$results[$s2["id"]];
	}
	//prettyPrint($sorted_result_ids2);
	//exit(-1);
	return $sorted_results;
}
	?>
						