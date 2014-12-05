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
				<h3>Ajout d'un Type</h3>
				<form enctype="multipart/form-data" action="valid_ajout_type.php" method="post">		 
					<table>
						<tr>
							<td><label for="type">Type existant :</label></td>
							<td>
								<select name="type" id="type">
									<option value="vide"></option>
									<?php 
										$req = "SELECT * FROM type";
										$rep = mysql_query($req);
										while($res=mysql_fetch_assoc($rep))
										{
											echo "<option value=".$res['ID_TYPE'].">".$res['LIBELLE_TYPE']."</option>";
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td><label for="libelle">Libelle:</label></td>
							<td><input type="text" name="libelle" /></td>
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
