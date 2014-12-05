<?php
session_start();
	if(!empty($_SESSION['mail']) AND !empty($_SESSION['code_secu']) )//test si la personne est bien connecter
	{
		if(isset($_GET['supprimer']) )//si l'utilisateur a presser le boutton supprimer on va enlever 
		{	//l'article du tableau et ne pas faire les tests suivant pour eviter les erreurs et ne pas incrémenter le tableau
			include_once("connect_bdd/connection_BDD.php");
			$id_prod = mysql_real_escape_string($_GET['id_produit']);
			$panier = $_SESSION['panier'];
			$nb = $_SESSION['nb'];
			
			$i = array_search($id_prod,$panier);//cherche le produit par son id, et donne son positionnement dans le tableau
			unset($panier[$i]);//on supprime la case $i qui contient l'id du produit
			unset($panier[$i+1]);//on supprime la case $i+1 qui contient la quantité du produit commander
			$tab1 = array_slice($panier, 0, ($i-1)*2);//tab1 recoit les element du tableau avant $i
			$tab2 = array_slice($panier, -($i), count($panier) - $i+1);//tab2 recoit les element du tableau apres $i+1
			$panier = array_merge($tab1, $tab2);//on fusionne les deux, les emplacement de $i et $i+1 n'existe plus
			$nb = $nb-2;
			
			$_SESSION['panier']=$panier;
			$_SESSION['nb'] = $nb;
			
			if(isset($_GET['choix']))
			{	$choix = mysql_real_escape_string($_GET['choix']);	}
			else
			{	$choix = 0;	}
			include("html_panier.php");
		}
		else
		{
			if(!empty($_POST['qte']) )//test si une quantité a ete saisi
			{
				if(is_numeric($_POST['qte']) AND $_POST['qte']>0 AND ctype_digit($_POST['qte'])==true)// test si un nombre est bien saisie
				{
					include_once("connect_bdd/connection_BDD.php");
					$qte_command = mysql_real_escape_string($_POST['qte']);
					$id_prod = mysql_real_escape_string($_GET['id_produit']);
					if(isset($_GET['choix']))
					{	$choix = mysql_real_escape_string($_GET['choix']);	}
					else
					{	$choix = 0;	}
					
					//requete qui recupere la quantité en stock du produit choisit
					$req = "SELECT QUANTITE_PROD_STOCK FROM produit WHERE REFERENCE_PROD = '$id_prod' ";
					$rep = mysql_query($req);
					$qte_stock = mysql_fetch_array($rep);
					if($qte_command <= $qte_stock['QUANTITE_PROD_STOCK'])//test si la quantité commander est bien dans le stock
					{
						$panier=array();
						$nb=0;
						
						if (isset($_SESSION['panier']))//si la session existe et n'est pas nul
						{	//on recupere le tableau en cession et on l'incremente avec les variables get/post
							$nb = $_SESSION['nb'];
							$panier = $_SESSION['panier'];
							$provisoir=false;

								if(in_array($id_prod, $panier) )
								{
									// $trouve = $i;
									$position = array_keys($panier, $id_prod);
									$provisoir= true;
									$trouve = $position[0];
								}
								else
								{
									$provisoir=false;
								}
							
							if($provisoir == true)//si le produit existe deja 
							{
								$tt_qte_com = $panier[$trouve+1] + $qte_command;
								if($tt_qte_com <= $qte_stock['QUANTITE_PROD_STOCK'])//si la quantité général d'un produit doit etre <= au stock
								{
									$panier[$trouve+1] = $panier[$trouve+1] + $qte_command;
								}
								else//sinon on redirige
								{
									$selection = $qte_stock['QUANTITE_PROD_STOCK'] - $panier[$trouve+1];
									
									if(isset($_GET['choix']))
									{	$choix = mysql_real_escape_string($_GET['choix']);	}
									else
									{	$choix = 0;	}

									$qte_prod_stock = $qte_stock['QUANTITE_PROD_STOCK'];
		
									echo "<script>
										alert ('Vous avez deja selectionné ".$panier[$trouve+1]." articles, et nous en avons que ".$qte_prod_stock." en stock. Vous pouvez selectionner que ".$selection." articles !! ');	
										document.location.href='acceuil.php?choix=".$choix."'
										</script>";
								}
							}
							else//sinon on incremente le tableau avec un nouveau produit et la quantité lié
							{
								$panier[$nb] = $id_prod;
								$panier[$nb+1] = $qte_command;
								$nb= $nb+2;
							}
						}
						else
						{	//sinon on incrémente le tableau pour la premiere fois
							$panier[$nb] = $id_prod;
							$panier[$nb+1]=$qte_command;
							$nb= $nb+2;
						}
					
					//envoi du panier en session
					$_SESSION['panier']=$panier;
					$_SESSION['nb'] = $nb;	
						
					include("html_panier.php");//on inclue la page html

					}
					else
					{
						if(isset($_GET['choix']))
						{	$choix = $_GET['choix'];	}
						else
						{	$choix = 0;	}
						echo "<script>
							alert ('Veuillez entrer une quantité inférieur au stock annoncé!!');
							document.location.href='acceuil.php?choix=".$choix."'
							</script>";
					}
				}
				else
				{
					if(isset($_GET['choix']))
					{	$choix = $_GET['choix'];	}
					else
					{	$choix = 0;	}
					echo "<script>
						alert ('Veuillez entrer un entier positif !!');
						document.location.href='acceuil.php?choix=".$choix."'
						</script>";
				}
			}
			else
			{
				if(isset($_GET['choix']))
				{	$choix = $_GET['choix'];	}
				else
				{	$choix = 0;	}
				echo "<script>
					alert ('Veuillez entrer une quantité !!');
					document.location.href='acceuil.php?choix=".$choix."'
					</script>";
			}
		}
	}
	else
	{
		if(isset($_GET['choix']))
		{	$choix = $_GET['choix'];	}
		else
		{	$choix = 0;	}
		echo "<script>
			alert ('Vous devez vous connecter pour pouvoir effectuer un achat !');
			document.location.href='acceuil.php?choix=".$choix."'
			</script>";
	}
?>