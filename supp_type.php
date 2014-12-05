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
		if(isset($_POST['type']))
		{
			//on recupere les id des catégories contenu dans un type
			$monType = $_POST['type'];
			$req = "SELECT * FROM categorie WHERE ID_TYPE=".$monType." ";
			$rep = mysql_query($req);
			while($res=mysql_fetch_assoc($rep))
			{
				$maCategorie = $res['ID_CAT'];
				
				$ryq =" SELECT * FROM produit WHERE ID_CAT=".$maCategorie." ";
				$ryp = mysql_query($ryq);
				while($ryp_produit = mysql_fetch_array($ryp)) //on boucle sur chaque produit d'une catégorie
				{
					//on supprime les images redimensionner grace au lien de la BDD
					$grand_chemin = $ryp_produit['MINI_IMAGE_PROD'];
					$mini_chemin = $ryp_produit['GRANDE_IMAGE_PROD'];
					
					unlink($grand_chemin);
					unlink($mini_chemin);
				}
				//on supprime les produits appartenant a chaque catégorie
				
				$raq = "DELETE FROM produit WHERE ID_CAT=".$maCategorie." ";
				$rap = mysql_query($raq);
			}
			//on supprime les catégorie du type choisit
			$roq = "DELETE FROM categorie WHERE ID_TYPE=".$monType." ";
			$rop = mysql_query($roq);
			
			//puis on supprime le type choisit
			$ruq = "DELETE FROM type WHERE ID_TYPE=".$monType." ";
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
				<h3>Suppression d'un Type</h3>
				<form enctype="multipart/form-data" action="supp_type.php" method="post">		 
					<table>
						<tr>
							<td><label for="type">Type existant :</label></td>
							<td>
								<select name="type" id="type">
									<option value="vide"></option>
									<?php 
										$riq = "SELECT * FROM type";
										$rip = mysql_query($riq);
										while($ris=mysql_fetch_assoc($rip))
										{
											echo "<option value=".$ris['ID_TYPE'].">".$ris['LIBELLE_TYPE']."</option>";
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
