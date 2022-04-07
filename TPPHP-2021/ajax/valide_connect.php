<?php
session_start();
include_once('../class/autoload.php');
$data = array();
$mypdo=new mypdo();


if(isset($_POST['id']) && isset($_POST['mp']) && isset($_POST['categ'] ))
{
    array_push($data,$_POST['id'],$_POST['mp'],$_POST['categ']);

	// exécution de la requête
	$resultat = $mypdo->connect($data);

	if(isset($resultat))
    {
        $donnees = $resultat->fetch(PDO::FETCH_OBJ);
        
        $_SESSION['numID']=$donnees->id; 
        $_SESSION['id']=$data[0];
	    $_SESSION['categ']=$data[2];
	    $data['success']=true;
        $data['message']='Vous êtes bien connecté';

	}
    else if (!isset($resultat))
    {
        $data['succes']=false;
        $data['message']='Identifiant, mot de passe ou catégorie invalide !';
    }

}

echo json_encode($data);
?>