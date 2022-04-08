<?php
class page_base_securisee_journaliste extends page_base
{

    protected function affiche_menu()
    {
        echo '
				<ul class="navbar-nav">
					<li class="nav-item active"><a class="nav-link"   href="'.$this->path.'/Accueil" >Accueil </a></li>
				</ul>
				<ul class="navbar-nav">
				<li class="nav-item active"><a class="nav-link"   href="'.$this->path.'/lesarticles" >Articles </a></li>
				</ul>
				
				<ul class="navbar-nav">
					<li class="nav-item active"><a class="nav-link"   href="'.$this->path.'/Departement" >Departement </a></li>
				</ul>
				
				<ul class="navbar-nav">
					<li class="nav-item active"><a class="nav-link"   href="'.$this->path.'/Galerie" >Galerie </a></li>
				</ul>
				<ul class="navbar-nav">
					<li class="nav-item active"><a class="nav-link"   href="'.$this->path.'/nature&environnement" >Nature et Environnement </a></li>
				</ul>
                <ul class="navbar-nav">
					<li class="nav-item active"><a class="nav-link"   href="'.$this->path.'/article" >Modifier Articles</a></li>
				</ul>';

    }

    public function affiche()
    {
        ?>
			<!DOCTYPE html>
			<html lang='fr'>
				<head>
					<title><?php echo $this->titre; ?></title>
					<meta http-equiv="content-type" content="text/html; charset=utf-8" />
					<meta name="description" content="<?php echo $this->metadescription; ?>" />
					<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
					
					<?php $this->affiche_keyword(); ?>
					<?php $this->affiche_javascript(); ?>
					<?php $this->affiche_style(); ?>
				</head>
				<body>

				<div class="global">

						<?php $this->affiche_entete(); ?>
						<?php $this->affiche_entete_menu(); ?>
						<?php $this->affiche_menu(); ?>
						<?php $this->affiche_menu_connexion(); ?>
						<?php $this->affiche_footer_menu(); ?>
				

  						<div style="clear:both;">
						  <div style="width:100%;">
						  		<?php echo $this->global; ?>
							</div>
    						<div style="float:left;width:75%;">
     							<?php echo $this->left_sidebar; ?>
    						</div>
    						<div style="float:left;width:25%;">
								<?php echo $this->right_sidebar;?>
    						</div>
  						</div>
						<div style="clear:both;">
							<?php $this->affiche_footer(); ?>
						</div>
					</div>
				</body>
			</html>
		<?php
	}

    

}
?>