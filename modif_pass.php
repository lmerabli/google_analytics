<?php
	session_start();
if(!empty($_SESSION['mail']) AND !empty($_SESSION['code_secu']))
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
		<form action="valid_modif_pass.php" method="post">
			<table>
				<thead>
					<tr>
						<td colspan="2"><h3>Saisissez un nouveau mot de passe !!</h3></td>
					</tr>
				</thead>
				<tr>
					<td><label for="pass">Nouveau mot de passe :</label></td>
					<td> <input type="text" name="pass" /></td>
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
else
{
	echo "<script>
	alert ('Il faut que vous soyez loger !');
	document.location.href='connection.php'
	</script>";
}
?>