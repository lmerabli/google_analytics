<?php
	session_start();
if(!empty($_SESSION['mail']) AND !empty($_SESSION['code_secu']))
{
	$login = $_SESSION['mail'];
	$code = $_SESSION['code_secu'];
	$new_login = $_POST['login'];
	
	include '../connect_bdd/connection_BDD.php';
	$req = "select ID_ADM from administrateur where LOGIN_ADM=\"$login\" and PASSWORD_ADM =\"$code\"  ";
	$resultat= mysql_query($req);
	$nb = mysql_num_rows($resultat);
	
	if(empty($_POST['login']))
	{
		echo "<script>
			alert ('Tu n'a pas le droit de mettre un champs vide !');
			document.location.href='modif_login.php'
			</script>";
	}
	else
	{
		if ($nb!=0)
		{
			$roq = "UPDATE administrateur SET LOGIN_ADM=\"$new_login\" WHERE LOGIN_ADM=\"$login\" and PASSWORD_ADM =\"$code\"  ";
			mysql_query($roq);
			echo "<script>
			document.location.href='connection.php'
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
}
else
{
	echo "<script>
	alert ('Il faut que vous soyez loger !');
	document.location.href='connection.php'
	</script>";
}
?>