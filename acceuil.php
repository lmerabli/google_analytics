<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >

<?php include_once("head.php"); ?>


<script>
	function infoCandidat(theId, theChoix) 
	{
		var ret;
		
		hauteur = 650;
		largeur = 700;
		X = Number(screen.width - largeur)/2;
		Y = Number(screen.height- hauteur)/2;
		if(theChoix = "")
		{
			ret = window.showModalDialog("affiche_produit.php?monId="+theId,window,"status:no; dialogLeft:"+X+"px; dialogTop:"+Y+"px; dialogWidth:"+largeur+"px; dialogHeight:"+hauteur +"px; resizable:no; help:no;");
		}
		else
		{
			ret = window.showModalDialog("affiche_produit.php?monId="+theId+"&choix="+theChoix,window,"status:no; dialogLeft:"+X+"px; dialogTop:"+Y+"px; dialogWidth:"+largeur+"px; dialogHeight:"+hauteur +"px; resizable:no; help:no;");
		}
	}
</script>

<body>

<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/SiteVente/"><div id="banniere"></div></a>

<?php include_once("menu.php"); ?> 

<div id="contenu">
		
<?php	
			if(isset($_GET['annuler']) )
			{
				// session_unregister("panier");
				unset($_SESSION['panier']);
				unset($_SESSION['nb']);

			}
			if(!empty($_GET['choix']) OR !empty($_GET['select']) OR !empty($_GET['categ']) )
			{
				
				$choix = $_GET['choix'];
				$req_Categorie = " SELECT LIBELLE_CAT FROM categorie WHERE ID_CAT = '$choix' ";
				$rep_Categorie = mysql_query($req_Categorie);
				$maCategorie = mysql_fetch_assoc($rep_Categorie);
				echo "<h2>".$maCategorie['LIBELLE_CAT']."</h2>";
				
				// Création d'un tableau et d'une 1er ligne (<tr>) 
				echo "<table><tr>";
				$req =" SELECT * FROM produit WHERE ID_CAT = '$choix' ";
				$rep = mysql_query($req);
				
				// Boucle FOR, tant qu'on a des produits à afficher (tant qu'il y a des entrées correspondantes dans la BDD).$i sert à compter le nombre de produit à afficher pour la mise en page.
				
				for ($i = 1; $rep_produit = mysql_fetch_array($rep) ; $i++) 
				{ 
					// Création d'une cellule du tableau avec affichage de qlq infos, lien-nom-image-id du produit.
					echo "
						<td style=\"width:230px; padding:10px 10px 10px 10px; text-align:center; border: 2px outset black;\">																				
							<img  style=\"padding-top:15px;\"  src =\"".$rep_produit['MINI_IMAGE_PROD']."\" id=\"".$rep_produit['REFERENCE_PROD']."\" title=\"".$rep_produit['LIBELLE_PROD']."\" alt=\"".$rep_produit['LIBELLE_PROD']."\" onclick=\"infoCandidat(this.id,".$choix.") \" />
							<br/>
							
								".$rep_produit['LIBELLE_PROD']."<br/>
								".$rep_produit['DESCRIPTIF_PROD']."<br/>
								".$rep_produit['PRIX_PROD']." €<br/>
								".$rep_produit['QUANTITE_PROD_STOCK']." Produits en stock <br/>
							
								<form action='panier.php?id_produit=".$rep_produit['REFERENCE_PROD']."&choix=".$choix."' method ='post' >
								Quantité : <input type='text' name='qte' size='3' value='' ></br></br>
								<input type='submit' name='acheter' value='Acheter'>
								</form><br/>
							
							
						</td>
					";
						
					// On se sert du $i ici pour permettre de créé une nouvelle ligne de tableau tout les 2 produits. Cela me permet d'avoir donc maxi par ligne, 4 produit afficher. 
					if($i % 3 == 0)
					{ 
						echo "</tr><tr>"; 
					}
				}
				// Fermeture de la ligne et du tableau
				echo "</tr></table>";
			}
			else
			{
				$raq =" SELECT * FROM produit LIMIT 0 , 18";
				$rap = mysql_query($raq);
				
				// Création d'un tableau et d'une 1er ligne (<tr>) 
				echo "<table><tr>";

				// Boucle FOR, tant qu'on a des produits à afficher (tant qu'il y a des entrées correspondantes dans la BDD).$i sert à compter le nombre de produit à afficher pour la mise en page.
				for ($i = 1; $rep_produit = mysql_fetch_array($rap) ; $i++) 
				{ 
					
					// Création d'une cellule du tableau avec affichage de qlq infos, lien-nom-image-id du produit.
					echo "
						<td style=\"width:230px; padding:10px 10px 10px 10px; text-align:center; border: 2px outset black;\">
							<img  style=\"padding-top:15px;\" src =\"".$rep_produit['MINI_IMAGE_PROD']."\" id=\"".$rep_produit['REFERENCE_PROD']."\" title=\"".$rep_produit['LIBELLE_PROD']."\" alt=\"".$rep_produit['LIBELLE_PROD']."\" onclick=\"infoCandidat(this.id) \" />
							<br/>
							
								".$rep_produit['LIBELLE_PROD']."<br/>
								".$rep_produit['DESCRIPTIF_PROD']."<br/>
								".$rep_produit['PRIX_PROD']." €<br/>
								".$rep_produit['QUANTITE_PROD_STOCK']." Produits en stock <br/>
							
								<form action='panier.php?id_produit=".$rep_produit['REFERENCE_PROD']."' method ='post' >
								Quantité : <input type='text' name='qte' size='3' value='' ></br></br>
								<input type='submit' name='acheter' value='Acheter'>
								</form><br/>
							
							
						</td>
						
					";
						
					// On se sert du $i ici pour permettre de créé une nouvelle ligne de tableau tout les 2 produits. Cela me permet d'avoir donc maxi par ligne, 4 produit afficher. 
					if($i % 3 == 0)
					{ 
						echo "</tr><tr>"; 
					}
				}
			}
			echo "</table>";
			?>
</div>

</body>
</html>