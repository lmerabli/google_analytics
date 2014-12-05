<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >

<?php 
	include_once("head.php"); 
	include("destroy.php");
?>

<script>
	function $(leId)
	{
		return document.getElementById(leId);
	}
	function verifChamp()
	{
		if( $('nom').value == "")
		{	$('nom_erreur').style.display = "block";	}
		else
		{	$('nom_erreur').style.display = "none";	}
		
		if( $('prenom').value == "")
		{	$('prenom_erreur').style.display = "block";	}
		else
		{	$('prenom_erreur').style.display = "none";	}
		
		if( $('adresse').value == "")
		{	$('adresse_erreur').style.display = "block";	}
		else
		{	$('adresse_erreur').style.display = "none";	}
		
		if( $('ville').value == "")
		{	$('ville_erreur').style.display = "block";	}
		else
		{	$('ville_erreur').style.display = "none";	}
		
		if($('nom').value == "" || $('prenom').value == "" || $('adresse').value == "" || $('cp').value == "" || $('ville').value == "" || $('email').value == "" )
		{	juste = false;	}
		else
		{	juste = true;	}
		
		if(!$('email').value.match(/^[a-z0-9._-]+@[a-z0-9.-]{2,}[.][a-z]{2,3}$/) || $('email').value == "")
		{	
			$('email_erreur').style.display = "block"; 
			juste = false;
		}
		else
		{
			$('email_erreur').style.display = "none";
			juste = true;
		}
		if(!$('cp').value.match(/^[0-9]{5}$/)  || $('cp').value == "")
		{	
			$('cp_erreur').style.display = "block"; 
			juste = false;
		}
		else
		{	
			$('cp_erreur').style.display = "none"; 
			juste = true;
		}
		return juste;
	}	
</script>

<body>

<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/SiteVente/"><div id="banniere"></div></a>

<?php include_once("menu.php"); ?> 

<div id="contenu">
	<h2>Inscription</h2>
	
	<form action="validation_inscription.php" method="post" onsubmit="return verifChamp();">
		<table style="text-align:right;margin-left:150px;">
			<tbody>
				<tr>
					<td><label for="nom">Nom:</label></td>
					<td><input id="nom" type="text" name="nom" size="45"/></td>
					<td><label id="nom_erreur" for="nom" style="color:red;display:none">Veuillez remplir le champ</label></td>
				</tr>
				<tr>
					<td><label for="prenom">Prénom :</label></td>
					<td><input id="prenom" type="text" name="prenom" size="45"/></td>
					<td><label id="prenom_erreur" for="prenom" style="color:red;display:none">Veuillez remplir le champ</label></td>
				</tr>
				<tr>
					<td><label for="adresse">Adresse :</label></td>
					<td><textarea id="adresse" type="text" name="adresse" rows="4" cols="34"></textarea></td>
					<td><label id="adresse_erreur" for="adresse" style="color:red;display:none">Veuillez remplir le champ</label></td>
				</tr>
				<tr>
					<td><label for="code_postale">Code Postale :</label></td>
					<td><input id="cp" type="text" name="code_postale" size="45"/></td>
					<td><label id="cp_erreur" for="code_postale" style="color:red;display:none">Code Postale Non Valide</label> </td>
				</tr>
				<tr>
					<td><label for="ville">Ville :</label></td>
					<td><input id="ville" type="text" name="ville" size="45"/></td>
					<td><label id="ville_erreur" for="ville" style="color:red;display:none">Veuillez remplir le champ</label></td>
				</tr>
				<tr>
					<td><label for="mail">Adresse mail :</label></td>
					<td><input id="email" type="text" name="mail" size="45"/></td>
					<td><label id="email_erreur" for="mail" style="color:red;display:none">Adresse mail Non Valide</label> </td>
				</tr>
			</tbody>
		</table>
		<div class="centred">
			<input type="submit" value="S'inscrire" />
			<input type="reset" value="Annuler"/>
		</div>
	</form>  
</div>

</body>
</html>