<?php
session_start();




if(!empty($_POST['mail']) AND !empty($_POST['code_secu']))
{
	include 'connect_bdd/connection_BDD.php';
	$mail = mysql_real_escape_string($_POST['mail']);
	$code = mysql_real_escape_string($_POST['code_secu']);
	
	//on test si la personne est un administrateur ou un client et si ils sont bien dans la base de donnée
	$raq = "select ID_ADM from administrateur where LOGIN_ADM =\"$mail\" and PASSWORD_ADM =\"$code\" ";
	$rap = mysql_query($raq);
	$bv = mysql_num_rows($rap);
	
	//idem
	$req = "select ID_CLI from client where EMAIL_CLI=\"$mail\" and MDP_CLI =\"$code\" ";
	$resultat= mysql_query($req);
	$nb = mysql_num_rows($resultat);
	
	
	if($bv != 0)
	{
		//c'est un admin on met en session les donnée
		$_SESSION['mail'] = mysql_real_escape_string($_POST['mail']);
		$_SESSION['code_secu'] = mysql_real_escape_string($_POST['code_secu']);
		
		echo "<script>
		document.location.href='gestion_article.php'
		</script>";
	}
	else if ($nb!=0)
		{
			//c'est un client on met en session les donnée
			$_SESSION['mail'] = mysql_real_escape_string($_POST['mail']);
			$_SESSION['code_secu'] = mysql_real_escape_string($_POST['code_secu']);
			
			echo "<script>
			alert ('bien identifier !');
			document.location.href='acceuil.php'
			</script>";
		}
		else
		{
			echo "<script>
			alert ('Identifiant Incorrect !');
			document.location.href='connection.php'
			</script>";
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