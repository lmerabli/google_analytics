<?php
session_start();

if(!empty($_SESSION['mail']) AND !empty($_SESSION['code_secu']))
{
	include 'connect_bdd/connection_BDD.php';
	$mail = ($_SESSION['mail']);
	$code = ($_SESSION['code_secu']);
	
	//on test si la personne est un administrateur ou un client et si ils sont bien dans la base de donnée
	$raq = "select ID_ADM from administrateur where LOGIN_ADM =\"$mail\" and PASSWORD_ADM =\"$code\" ";
	$rap = mysql_query($raq);
	$bv = mysql_num_rows($rap);
	
	if($bv != 0)
	{
		if(isset($_GET['supprimer']) )//si l'utilisateur a presser le boutton supprimer
		{
			$id_prod = mysql_real_escape_string($_GET['id_produit']);
			//requete pour recuperer le chemin de l'image
			$ryq =" SELECT * FROM produit WHERE REFERENCE_PROD=\"$id_prod\" ";
			$ryp = mysql_query($ryq);
			$ryp_produit = mysql_fetch_array($ryp);
			//on supprime les images redimensionner grace au lien de la BDD
			$grand_chemin = $ryp_produit['MINI_IMAGE_PROD'];
			$mini_chemin = $ryp_produit['GRANDE_IMAGE_PROD'];
			
			unlink($grand_chemin);
			unlink($mini_chemin);
			
			//puis on supprime l'article dans la BDD
			$ruq = "DELETE FROM produit WHERE  REFERENCE_PROD='$id_prod' ";
			$rup = mysql_query($ruq);
		}
		
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
	<?php
		include_once("head.php");
	?>
	   <body>
			<?php
				include_once("en_tete.php");
				include_once("menu_droite_admin.php");
			?>  
			<div id="corps">

				<form enctype="multipart/form-data" action="supp_article.php" method="post">		 
					<table>
						<tr>
							<td><label for="type">Type de produit :</label></td>
							<td>
								 <select name="choix" id="type">
								<?php
									$riq = "SELECT * FROM categorie";
									$rip = mysql_query($riq);
									while($ris = mysql_fetch_assoc($rip))
									{
										echo "<option value='".$ris['ID_CAT']."'>".$ris['LIBELLE_CAT']."</option>";
									}
								?>
								</select>							
							</td>
						</tr>
						<tr>
							<td colspan="2"><input type="submit" value="Valider" /></td>
						</tr>					
					</table>
				 
				</form><br/>

				<?php
					if(isset ($_POST['choix']) )
					{
						$choix = $_POST['choix'];
						
						$req =" SELECT * FROM produit WHERE ID_CAT = '$choix' ";
						$rep = mysql_query($req);
						
						echo "<hr/ color = 'black'> <br/>";
						
						// Création d'un tableau et d'une 1er ligne (<tr>) car la flemme de faire des div pour mon affichage
						echo "<table><tr>";
						
						// Boucle FOR, tant qu'on a des produits à afficher (tant qu'il y a des entrées correspondantes dans la BDD).$i sert à compter le nombre de produit à afficher pour la mise en page.
						
						for ($i = 1; $rep_produit = mysql_fetch_array($rep) ; $i++) 
						{ 
							// Création d'une cellule du tableau avec affichage de qlq infos, lien-nom-image-id du produit.
							echo "
								<td style=\"padding-left:25px; border: 2px solid black;\">
									<a href=\"affiche_produit.php?chemin_produit=".$rep_produit['GRANDE_IMAGE_PROD']."&choix=".$choix."\" >
										<img  src =\"".$rep_produit['MINI_IMAGE_PROD']."\" title=\"".$rep_produit['LIBELLE_PROD']."\" alt=\"".$rep_produit['LIBELLE_PROD']."\" />
									</a><br/>
									
										".$rep_produit['LIBELLE_PROD']."<br/>
										".$rep_produit['DESCRIPTIF_PROD']."<br/>
										".$rep_produit['PRIX_PROD']." €<br/>
										".$rep_produit['QUANTITE_PROD_STOCK']." Produit en stock <br/>
									
										<form action='supp_article.php?supprimer=vrai&id_produit=".$rep_produit['REFERENCE_PROD']."&choix=".$choix."' method ='post' >
										<input type='submit' name='supp_article' value='Supprimer'>
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
				?>
		   
			</div>
			<?php
			   include_once("pied.php");
			?>
		
		</body>
	</html>
<?php
	}
}
?>
