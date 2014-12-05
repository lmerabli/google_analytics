<?php
if( (!empty($_POST['nom'])) AND (!empty($_POST['prenom'])) AND (!empty($_POST['adresse'])) 
	AND (!empty($_POST['code_postale'])) AND (!empty($_POST['ville'])) AND (!empty($_POST['mail'])))
{
	if(preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}#",$_POST['mail']))
	{
		// D'abord, on se connecte à MySQL
		include 'connect_bdd/connection_BDD.php';
				
		// On utilise les fonctions PHP mysql_real_escape_string et htmlspecialchars pour la sécurité
		$nom = mysql_real_escape_string(htmlspecialchars($_POST['nom']));
		$prenom = mysql_real_escape_string(htmlspecialchars($_POST['prenom']));
		$adresse = mysql_real_escape_string(htmlspecialchars($_POST['adresse']));
		$code_postale = mysql_real_escape_string(htmlspecialchars($_POST['code_postale']));
		$ville = mysql_real_escape_string(htmlspecialchars($_POST['ville']));
		$mail = mysql_real_escape_string(htmlspecialchars($_POST['mail']));
		
		// on test si l'adresse emal est deja enregistré
		$ruq = "SELECT * FROM client WHERE EMAIL_CLI= ".$mail." ";
		$rup = mysql_query($ruq);
		$rus = mysql_num_rows($rup);
		
		if($rus == 0)
		{
			$datejour = date("d");
			$datemois = date("m");
			$dateannee = date("Y");
			$lettre = $prenom[0];
			$code = $lettre.$nom.$datejour.$datemois.$dateannee ;
			
			// Ensuite on enregistre le message
			$req= "INSERT INTO client (ID_CLI, NOM_CLI, PRENOM_CLI, ADRESSE_CLI, COD_POST_CLI, VILLE_CLI, 
					EMAIL_CLI, MDP_CLI) VALUES ('', '$nom', '$prenom', '$adresse', '$code_postale','$ville',
					'$mail', '$code')";

			$resultat=mysql_query($req);
			
			//on verifie que l'enregistrement c'est bien effectué
			if($resultat)
			{
				$mail_dest = $mail;
				$sujet = 'Validation inscription';
				$message = "Bonjour, ";
				$message += "Vous vous etes inscrits sur notre site de vente en ligne.";
				$message += "Veuillez notez votre code personnel: ";
				$message += "Code: ".$code;
				$header = 'contact@NumDiscount.fr';
				
				$envoi = mail($mail_dest, $sujet, $message, $header);
				
				
				echo "<script>
				alert('Veuillez notez votre code : ".$code."');
				document.location.href='acceuil.php'
				</script>";
			}
			else
			{
				"<script>
				alert('Echec');
				</script>";
			}
		}
		else
		{
			echo "<script>
			alert ('adresse email deja enregistré !');
			document.location.href='inscription.php'
			</script>";
		}
	}
	else
	{
		echo "<script>
		alert ('adresse email non-valide !');
		document.location.href='inscription.php'
		</script>";
	}
}
	
else
{
	echo "<script>
	alert ('Veuillez remplir tout les champs !');
	document.location.href='inscription.php'
	</script>";
}
?>