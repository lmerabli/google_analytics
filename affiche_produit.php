<?php
	session_start();
?>
<html>
<?php
if(isset($_GET['choix']))
{	$choix = $_GET['choix'];	}
else
{	$choix = 0;	}

include_once("connect_bdd/connection_BDD.php");
$TheId = $_GET['monId'];
$req = "SELECT GRANDE_IMAGE_PROD FROM produit WHERE REFERENCE_PROD='".$TheId."' ";
$rep = mysql_query($req);
$res = mysql_fetch_assoc($rep);


echo "<table> <tr>";
// Création d'une cellule du tableau avec affichage de qlq infos, lien-nom-image-id du produit.
					echo "
						<td style=\"padding-left:25px;\">
								<img  src =\"".$res['GRANDE_IMAGE_PROD']."\" />
						</td>
					";
echo "		</tr>
			<tr>
				<td>
							<a href=\"acceuil.php?choix=".$choix."\">Retour</a>
						</td>
			</tr>
		</table>";					
?>
</html>