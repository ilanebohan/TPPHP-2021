<?php
	session_start(['cookie_lifetime' => 43200,'cookie_secure' => true,'cookie_httponly' => true]);

	$_SESSION["KCFINDER"] = array("disabled" => false);

	include_once('class/autoload.php');
	
	if (isset($_SESSION['id']))
	{
		switch ($_SESSION['categ']) 
		{
			case '1':
				$site = new page_base_securisee_admin();
				break;
			case '2':
				$site = new page_base_securisee_redacteur();
				break;
			case '3':
				$site = new page_base_securisee_journaliste();
				break;
		}
	}
	else if (!isset($_SESSION['id']))
	{
		$site = new page_base();
	}


	//$site = new page_base();
	//connexionSecurise();
	
	$controleur=new controleur();
	$request = strtolower($_SERVER['REQUEST_URI']);
	$params = explode('/', trim($request, '/'));
    $params = array_filter($params);
	if (!isset($params[1]))
	{
		$params[1]='accueil';
	}
	switch ($params[1]) {
		case 'accueil' :
			$site->titre='Accueil';
			$site-> right_sidebar=$site->rempli_right_sidebar();
			$site-> left_sidebar=$controleur->retourne_article($site->titre);
			$site->global=$controleur->caroussel();
			$site->affiche();
			break;
		case 'connexion' :
			$site->titre='Connexion';
			$site->js='jquery.validate.min';
			$site->js='messages_fr';
			$site->js='tooltipster.bundle.min';
			$site->js='connexion';
			$site->js='all';
			$site->css='tooltipster.bundle.min';
			$site->css='all';
			$site->css='tooltipster-sideTip-light.min';
			$site-> right_sidebar=$site->rempli_right_sidebar();
			$site-> left_sidebar=$controleur->retourne_formulaire_login();
			$site-> left_sidebar=$controleur->retourne_modal_message();
			$site->affiche();
			break;
		case 'deconnexion' :
			$_SESSION=array();
			session_destroy();
			echo '<script>document.location.href="Accueil"; </script>';
			break;
		case 'departement' :
			$site->titre='Departement';
			$site->js='departement';
			$site->js='jquery.dataTables.min';
			$site->js='dataTables.bootstrap4.min';
			$site->css='dataTables.bootstrap4.min';
			$site->titre='Departement';
			$site-> left_sidebar=$controleur->retourne_departement();
			$site->affiche();
			break;
		case 'galerie' : 
			$site->titre='Galerie d\'Images';
			$site-> right_sidebar=$site->rempli_right_sidebar();
			$site->global=$controleur->affiche_galerie();
			$site->global=$controleur->retourne_modal_hl($site->path);
			$site->css = 'ol';
			$site->js = 'ol';
			$site->js='galerie';
			$site->affiche();
			break;
		case 'nature&environnement':
			$site->titre="Nature & Environnement";
			$site->global=$controleur->articles_scienceavenir();
			$site->global=$controleur->articles_lemonde();
			$site->affiche();
			break;
		case 'article':
			if (isset($_SESSION['id']))
			{
				$site->titre="Articles";
				if ($_SESSION['categ'] == '1') // Si il est admin
				{
					$site->js="Modifarticle";
					$site->js='jquery.dataTables.min';
					$site->js='dataTables.bootstrap4.min';
					$site->css='dataTables.bootstrap4.min';
					$site->right_sidebar=$controleur->retourne_article_journaliste();
					$site->right_sidebar=$controleur->retourne_formulaire_article();
					$site->affiche();
					break;
				}
				if ($_SESSION['categ'] == '2') // Si il est rédacteur
				{
					$site->js="Modifarticle";
					$site->js='jquery.dataTables.min';
					$site->js='dataTables.bootstrap4.min';
					$site->css='dataTables.bootstrap4.min';
					$site->right_sidebar=$controleur->retourne_article_journaliste();
					$site->right_sidebar=$controleur->retourne_formulaire_article();
					$site->affiche();
					break;
					
				}
				if ($_SESSION['categ'] == '3') // Si il est journaliste
				{
					echo "<script src='js/ckeditor/ckeditor.js'></script>\n";
					$site->js='all';
					$site->css='all';
					$site->js="Modifarticle";
					$site->js='jquery.dataTables.min';
					$site->js='dataTables.bootstrap4.min';
					$site->js='datepicker-fr';
					$site->js='jquery-ui.min';
					$site->css='jquery-ui.min';
					$site->css='jquery-ui.theme.min';
					$site->css='dataTables.bootstrap4.min';
					$site->left_sidebar=$controleur->retourne_article_journaliste();
					$site->left_sidebar=$controleur->retourne_formulaire_article();
					$site->left_sidebar=$controleur->retourne_modal_message();
					$site->affiche();
					break;
					
				}
				$site->affiche();
				break;

			}
			else if (!isset($_SESSION['id']))
			{
				break;
			}
		case 'perdu' :
			$site->titre="Mot de passe perdu";
			$site->js='jquery.validate.min';
			$site->js='messages_fr';
			$site->js='tooltipster.bundle.min';
			$site->js='lostpass';
			$site->js='all';
			$site->css='tooltipster.bundle.min';
			$site->css='all';
			$site->css='tooltipster-sideTip-light.min';
			$site-> right_sidebar=$site->rempli_right_sidebar();
			$site->left_sidebar=$controleur->retourne_modal_lostpass();
			$site->left_sidebar=$controleur->retourne_modal_message();
			$site->affiche();
			break;
		case 'reset':
			$_SESSION['token'] = $params[2];
			$site->titre="Réinitialisation de mot de passe";
			$site->js='jquery.validate.min';
			$site->js='messages_fr';
			$site->js='tooltipster.bundle.min';
			$site->js='reset_pass';
			$site->js='all';
			$site->css='tooltipster.bundle.min';
			$site->css='all';
			$site->css='tooltipster-sideTip-light.min';
			$site-> right_sidebar=$site->rempli_right_sidebar();
			$site->left_sidebar=$controleur->reset_pass();
			$site->left_sidebar=$controleur->retourne_modal_message();
			$site->affiche();
			break;
		default: 
			$site->titre='404-Erreur de lien';
			$site-> right_sidebar=$site->rempli_right_sidebar();
			$site-> left_sidebar='<img src="'.$site->path.'/image/erreur-404.png" alt="Erreur de liens">';
			$site->affiche();
			break;
	}	



/*
function connexionSecurise()
{
	if (isset($_SESSION['id']))
	{
		switch ($_SESSION['categ']) 
		{
			case '1':
				$site = new page_base_securisee_admin();
				break;
			case '2':
				$site = new page_base_securisee_redacteur();
				break;
			case '3':
				$site = new page_base_securisee_journaliste();
				break;
		}
	}
	else if (!isset($_SESSION['id']))
	{
		$site = new page_base();
	}
}*/



	
?>


