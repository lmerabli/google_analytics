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
	
	$datejour = date("d");
	$datemois = date("m");
	$dateannee = date("Y");
	$name = $_FILES['image']['name'];
	$lettre1 = $name[0];
	$lettre2 = $name[2];
	$lettre3 = $name[4];
	$reference = $lettre1.$datejour.$lettre2.$datemois.$lettre3.$dateannee ;
	
	//on isole l'extention que l'on ne doit pas modifier
	$temp = strtolower(strrchr($_FILES['image']['type'], '/'));
	$temp=substr($temp, 1);
		
	if( $temp == 'jpg' OR $temp == 'png' OR $temp == 'gif')
	{
		$nom_image = $reference.substr($_FILES['image']['name'], -4);
		$reference=substr($nom_image, 0, -3);
	}
	elseif($temp == 'jpeg')
		{
			$nom_image = $reference.substr($_FILES['image']['name'], -5);
			$reference=substr($nom_image, 0, -4);
		}
	$target_grande = 'grande_image/'.$nom_image;
	$target_petite = 'petite_image/'.$nom_image;
	//on renomme l'image en gardant l'extension et en mettant l'identifiant du produit
	
	
	if($bv != 0)
	{
			//Indique si le fichier a été téléchargé
			if(!is_uploaded_file($_FILES['image']['tmp_name']))
				echo "<script>
				alert ('Un problème est survenu durant l opération. Veuillez réessayer !');
				document.location.href='gestion_article.php'
				</script>";
			else 
			{
				//liste des extensions possibles    
				$extensions = array('/png', '/gif', '/jpg', '/jpeg');
				//récupère la chaîne à partir du dernier / pour connaître l'extension
				$extension = strtolower(strrchr($_FILES['image']['type'], '/'));
				//vérifie si l'extension est dans notre tableau            
				if(!in_array($extension, $extensions))
				{
					echo "<script>
					alert ('Vous devez uploader un fichier de type png, gif, jpg, jpeg !');
					document.location.href='gestion_article.php'
					</script>";
				}
				else 
				{    
					$max_size   = 4000000;//poid de l'image
					$max_dimension = 800;// taille en px de la grande image
					$max_dimension_min = 200;// taille en px de la petite image

					//ici 1er upload de l'image
					//on enregistre l'image en la renomant
					move_uploaded_file($_FILES['image']['tmp_name'],$target_grande);
					
				// On redimensionne en fonction de $max_dimension, on enlève l'ancienne image qui était trop grande et on met la nouvelle
					$dimension=getimagesize($target_grande);
					if(($dimension[0]>$dimension[1]) OR ($dimension[0]==$dimension[1])) 
					{ 
						$reduc=$max_dimension/$dimension[0];
						$coef_h=$dimension[1]*$reduc;
						$coef_l=$max_dimension;
					}
					elseif($dimension[0]<$dimension[1]) 
					{ 
						$reduc=$max_dimension/$dimension[1]; 
						$coef_l=$dimension[0]*$reduc;
						$coef_h=$max_dimension;
					}
					// FIN
					
					$chemin = imagecreatefromjpeg($target_grande);
					$nouvelle = imagecreatetruecolor ($coef_l, $coef_h); 
					//on fait un "sample" de l'image uploadé et on redimentionne
					imagecopyresampled($nouvelle,$chemin,0,0,0,0,$coef_l,$coef_h,$dimension[0],$dimension[1]);
					//ON EN FAIT UN PNG ET ON DESTROY L'originale
					imagepng($nouvelle,$target_grande); 
					imagedestroy ($chemin);
				// FIN
				
					
				// On redimensionne pour créé la miniature en fonction de $max_dimension_min	
					$dimension=getimagesize($target_grande);
					if(($dimension[0]>$dimension[1]) OR ($dimension[0]==$dimension[1])) 
					{
						$reduc=$max_dimension_min/$dimension[0]; 
						$coef_h=$dimension[1]*$reduc;
						$coef_l=$max_dimension_min;
					}
					elseif($dimension[0]<$dimension[1]) 
					{
						$reduc=$max_dimension_min/$dimension[1]; 
						$coef_l=$dimension[0]*$reduc;
						$coef_h=$max_dimension_min;
					}
				// FIN	
					
				// On uplooad la miniature	
					$chemin = imagecreatefromPNG($target_grande); //on refait une copie de la 1er copie
					$nouvelle = imagecreatetruecolor ($coef_l, $coef_h); //on redimentionne
					//on refait un sample pour conserver le rapport hauteur X largeur
					//et on en fait un png
					imagecopyresampled($nouvelle,$chemin,0,0,0,0,$coef_l,$coef_h,$dimension[0],$dimension[1]); 
					imagepng($nouvelle,$target_petite); //on génère la nouvelle image
					imagedestroy ($chemin);					
				// FIN

					//récupération des infos saisies
					$libelle = mysql_escape_string($_POST['libelle']);
					$descriptif = mysql_escape_string($_POST['descriptif']);
					$prix = mysql_escape_string($_POST['prix']);
					$quantite = mysql_escape_string($_POST['quantite']);
					$categorie = mysql_escape_string($_POST['categorie']);
					//Il ne reste qu'à insérer tout ça dans notre table.
					$req = "INSERT INTO produit(reference_prod, id_cat, libelle_prod, descriptif_prod, prix_prod, mini_image_prod, grande_image_prod, quantite_prod_stock) VALUES('".$reference."', '".$categorie."','".$libelle."', '".$descriptif."', '".$prix."', '".$target_petite."', '".$target_grande."', '".$quantite."')";
					mysql_query($req) or exit (mysql_error());

					echo "<script>
					alert ('L insertion s est bien déroulée !');
					document.location.href='gestion_article.php'
					</script>";
				}
			}
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