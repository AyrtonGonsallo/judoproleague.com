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


<?php  function get_classement(){
	$args = array(
		'post_type'=> 'rencontre',
		'posts_per_page' => -1,
		'meta_key' => 'date_de_debut',
		'orderby' => 'meta_value_num',
		'order' => 'DESC',
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
					$equipe1=get_field( 'equipe_judoka',$judoka1->ID )[0];
					$equipe2=get_field( 'equipe_judoka',$judoka2->ID )[0];
					$results['total'][$judoka1->post_title]=[array("nom"=>$judoka1->post_title)];
					$results['total'][$judoka2->post_title]=[array("nom"=>$judoka2->post_title)];
					
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
					$equipe1=get_field( 'equipe_judoka',$judoka1->ID )[0];
					$equipe2=get_field( 'equipe_judoka',$judoka2->ID )[0];
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
	
	
	
	
	return $results;
}

	?>
						