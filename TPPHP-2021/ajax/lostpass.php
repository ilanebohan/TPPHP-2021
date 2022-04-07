<?php
session_start();
include_once('../class/autoload.php');
$data = array();
$mypdo=new mypdo();
$controleur=new controleur();

//echo 'début lostpass.php';

if(isset($_POST['id']))
{
    array_push($data,$_POST['id']);


    $idUser = $mypdo->selectID($_POST['id']);
    $donnees = $idUser->fetch(PDO::FETCH_OBJ);
    array_push($data,$donnees->id); 

    $resultat = $mypdo->idExist($data);

    

    if(isset($resultat))
    {
        array_push($data,uniqid());
        $resultatInsert = $mypdo->insertToken($data);
        //echo 'après insert';

        $destinataire = 'pyro1eldiablo@gmail.com';
        $envoyeur = 'ilane.bohan@gmail.com';
        $sujet = 'Réinitialisation de mot de passe';
        $message = 'Bonjour ..., 
        Suite à une demande de réinitialisation de mot de passe, voici le lien vous permettant de le faire : 
        http://localhost/TPPHP-2021/reset/'.$data[2].'';

        if ($controleur->send_mail($destinataire, $envoyeur, $sujet, $message)) //Si mail bien envoyé 
        {
            $data['success']=true;
            $data['message']='Veuillez consulter votre boite mail !';
        }
        else 
        {
            $data['succes']=false;
            $data['message']='Problème envoi de mail !';
        }
        
    }
    else if (!isset($resultat))
    {
        $data['succes']=false;
        $data['message']='Problème login';
    }
}

echo json_encode($data);



?>