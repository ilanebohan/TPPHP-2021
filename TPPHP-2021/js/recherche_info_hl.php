<?php
session_start();
include_once('../class/autoload.php');
$data = array();
$mypdo=new mypdo();

if(isset($_POST['id_hl']))
{

	// exécution de la requête
	$resultat = $mypdo->trouve_ville_via_id($_POST['id_hl']);
	if(isset($resultat))
	{

		// résultats
		$donnees = $resultat->fetch(PDO::FETCH_OBJ);
			//$data[$donnees->ville_id][] = ($donnees->ville_nom_reel);
			$data["ville_departement"][] = ($donnees->ville_departement);
			$data["ville_code_postal"][] = ($donnees->ville_code_postal);
			$data["ville_nom_reel"][] = ($donnees->ville_nom_reel);
			$data["ville_latitude_deg"][] = ($donnees->ville_latitude_deg);
			$data["ville_longitude_deg"][] = ($donnees->ville_longitude_deg);


	}
}

// renvoit un tableau dynamique encodé en json d’une seule ligne
echo json_encode($data);
?>
 
