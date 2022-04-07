<?php
session_start();
include_once('../class/autoload.php');
$data = array();
$mypdo=new mypdo();

if(isset($_POST['id_hl']))
{

	// exécution de la requête
	$resultat = $mypdo->highlightbyid($_POST['id_hl']);
	if(isset($resultat))
	{

		// résultats
		$donnees = $resultat->fetch(PDO::FETCH_OBJ);
			//$data[$donnees->ville_id][] = ($donnees->ville_nom_reel);
			$data["img"][] = ($donnees->image);
			$data["titre"][] = ($donnees->titre);
			$data["texte"][] = ($donnees->texte);
			$data["latitude"][] = ($donnees->latitude);
			$data["longitude"][] = ($donnees->longitude);


	}
}

// renvoit un tableau dynamique encodé en json d’une seule ligne
echo json_encode($data);
?>
 
