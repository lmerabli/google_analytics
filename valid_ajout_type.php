<?php
session_start();
if(!empty($_SESSION['mail']) AND !empty($_SESSION['code_secu']) )
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
		$libelle = $_POST['libelle'];
		$req = "INSERT INTO type(id_type, libelle_type) VALUES('', '".$libelle."')";
		$rep = mysql_query($req);
		
		echo "<script>
		document.location.href='ajout_type.php'
		</script>";

	}
	else
	{
		echo "<script>
		alert ('Vous devez etre administrateur pour vous acceder a cette page !');
		document.location.href='gestion_article.php'
		</script>";
	}
}
?>