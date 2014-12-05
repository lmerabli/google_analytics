<?php
session_start();

if(!empty($_SESSION['mail']) AND !empty($_SESSION['code_secu']))
{
	include 'connect_bdd\connection_BDD.php';
	$mail = ($_SESSION['mail']);
	$code = ($_SESSION['code_secu']);
	
	//on test si la personne est un administrateur ou un client et si ils sont bien dans la base de donnée
	$raq = "select ID_ADM from administrateur where LOGIN_ADM =\"$mail\" and PASSWORD_ADM =\"$code\" ";
	$rap = mysql_query($raq);
	$bv = mysql_num_rows($rap);
	
	if($bv != 0)
	{
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
				<h3>Ajout D'un Nouveau Produit</h3></br>
				<form enctype="multipart/form-data" action="valid_ajout_article.php" method="post">		 
					<table>
						<tr>
							<td><label for="libelle">Libelle:</label> </td>
							<td><input type="text" name="libelle" /></td>
						</tr>
						<tr>
							<td><label for="descriptif">Descriptif :</label></td>
							<td> <input type="text" name="descriptif" /></td>
						</tr>
						<tr>
							<td><label for="prix">Prix :</label></td>
							<td><input type="text" name="prix" /></td>
						</tr>
						<tr>
							<td><label for="image">Image : </label></td>
							<td><input type="file" name="image" id="image" /></td>
						</tr>
						<tr>
							<td><label for="quantite">Quantité :</label></td>
							<td><input type="text" name="quantite" /></td>
						</tr>
						<tr>
							<td><label for="categorie">Choisir une Catégorie :</label></td>
							<td>
								<select name="categorie" id="categorie" style="width:146px">
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
						<td colspan="2">
							<input type="submit" value="Valider" />
							<input type="reset" value="Annuler"/>
						</td>
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
else
{
	echo "<script>
	alert ('Veuillez remplir tout les champs !');
	document.location.href='connection.php'
	</script>";
}
?>
