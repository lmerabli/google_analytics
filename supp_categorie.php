<?php
session_start();

if(!empty($_SESSION['mail']) AND !empty($_SESSION['code_secu']))
{
	include 'connect_bdd/connection_BDD.php';
	$mail = ($_SESSION['mail']);
	$code = ($_SESSION['code_secu']);
	
	//on test si la personne est un administrateur ou un client et si ils sont bien dans la base de donn�e
	$raq = "select ID_ADM from administrateur where LOGIN_ADM =\"$mail\" and PASSWORD_ADM =\"$code\" ";
	$rap = mysql_query($raq);
	$bv = mysql_num_rows($rap);
	
	if($bv != 0)
	{
		if(isset($_POST['categorie']))
		{
			$maCategorie = $_POST['categorie'];
			//requete pour recuperer le chemin de l'image 
			$ryq =" SELECT * FROM produit WHERE ID_CAT=".$maCategorie." ";
			$ryp = mysql_query($ryq);
			while($ryp_produit = mysql_fetch_array($ryp)) //on boucle sur chaque produit d'une cat�gorie
			{
				//on supprime les images redimensionner grace au lien de la BDD
				$grand_chemin = $ryp_produit['MINI_IMAGE_PROD'];
				$mini_chemin = $ryp_produit['GRANDE_IMAGE_PROD'];
				
				unlink($grand_chemin);
				unlink($mini_chemin);
			}
			$raq = "DELETE FROM produit WHERE ID_CAT=".$maCategorie." ";
			$rap = mysql_query($raq);
			
			//on supprime la cat�gorie choisit
			$riq = "DELETE FROM categorie WHERE ID_CAT=".$maCategorie." ";
			$rip = mysql_query($riq);
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
				<h3>Suppression d'une Categorie</h3>
				<form enctype="multipart/form-data" action="supp_categorie.php" method="post">		 
					<table>
						<tr>
							<td><label for="categorie">Categorie existant :</label></td>
							<td>
								<select name="categorie" id="categorie">
									<option value="vide"></option>
									<?php 
										$riq = "SELECT * FROM categorie";
										$rip = mysql_query($riq);
										while($ris=mysql_fetch_assoc($rip))
										{
											echo "<option value=".$ris['ID_CAT'].">".$ris['LIBELLE_CAT']."</option>";
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="2"><input type="submit" value="Valider" /></td>
						</tr>
					</table>
				</form>  
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
