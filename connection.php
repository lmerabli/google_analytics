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
		juste = true;
		if($('email').value != "admin")
		{
			if(!$('email').value.match(/^[a-z0-9._-]+@[a-z0-9.-]{2,}[.][a-z]{2,3}$/) && $('email').value != "")
				{	
					$('email_erreur').style.display = "block";
					juste = false;
				}
				else
				{	
					$('email_erreur').style.display = "none"; 
					juste = true;
				}
		}
		return juste;
	}	
</script

<body>

<body>

<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/SiteVente/"><div id="banniere"></div></a>

<?php include_once("menu.php"); ?> 

<div id="contenu">
	<h2>Connexion</h2>
	<form action="validation_connection.php" method="post" onsubmit="return verifChamp();">
		<table style="text-align:right;margin-left:200px;">
			<tr>
				<td><label for="mail">Adresse mail :</label></td>
				<td> <input id="email" type="text" name="mail" /></td>
				<td><label id="email_erreur" for="mail" style="color:red;display:none">Adresse mail Non Valide</label> </td>
			</tr>
			<tr>
				<td><label for="code_secu">Code d'identification :</label></td>
				<td><input type="password" name="code_secu" /></td>
				<td></td>
			</tr>			
		</table>
		<div class="centred">
			<br /><input type="submit" value="connexion" />
		</div>
	</form>  
</div>

</body>
</html>