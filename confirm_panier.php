<?php
	session_start();
	if(!empty($_SESSION['mail']) AND !empty($_SESSION['code_secu']) )//test si la personne est bien connecter
	{
		$mail = $_SESSION['mail'];
		$code = $_SESSION['code_secu'];
		
		if(isset($_SESSION['panier']) AND isset($_SESSION['nb']) )
		{	
			$panier = $_SESSION['panier'];	
			$nb = $_SESSION['nb'];
		
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >

<?php include_once("head.php"); ?>

<bbody>

<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/SiteVente/"><div id="banniere"></div></a>

<?php include_once("menu.php"); ?> 

<div id="contenu">
	<h2>Votre Panier !</h2>
	<table align ='center'>
		<tr>
			<td class ="visible"><h3>Désignation</h3></td>
			<td class ="visible"><h3>Prix U/HT</h3></td>
			<td class ="visible"><h3>Quantité</h3></td>
			<td class ="visible"><h3>prix HT</h3></td>
		</tr>
		<?php
			$total_ht = 0;
			for ($i=0; $i<$nb;	$i+=2)
			{
				$id_prod = $panier[$i];
				$qte_command=$panier[$i+1];
				$raq = "SELECT * FROM produit WHERE REFERENCE_PROD = '$id_prod' ";
				$rap = mysql_query($raq);
				$rat = mysql_fetch_array($rap) ;
				
				$Somme = $rat['PRIX_PROD'] * $qte_command;
				$somme = number_format($Somme, 2, '.','');
				echo"<tr>
						<td class ='visible'>".$rat['LIBELLE_PROD']."</td>
						<td class ='visible'>".$rat['PRIX_PROD']."€</td>
						<td class ='visible'>".$qte_command."</td>
						<td class ='visible'>".$somme."€</td>
					</tr>";
				$total_ht = $total_ht + $somme;
				$Total_ht = number_format($total_ht, 2, '.','');
			}
		?>
			<tr class ="separe"></tr>
			<tr>
				<td colspan = 2></td>
				<td class ="visible">Total Hors Taxe</td>
				<td class ="visible"><?php echo $Total_ht; ?>€</td>
			</tr>
			<tr>
				<td colspan = 2></td>
				<td class ="visible">Frais de Port</td>
				<td class ="visible">30.00€</td>
			</tr>
			<tr>
				<td colspan = 2></td>
				<td class ="visible">TVA 19,6%</td>
				<?php
				$taux_tva = 19.6;
				$Tva = ($total_ht + 30) * ($taux_tva / 100);
				$tva = number_format($Tva, 2, '.','');
				echo "<td class ='visible'>".$tva."€</td>";
				?>
			</tr>
			<tr>
				<td colspan = 2></td>
				<td class ="visible">Total T.T.C</td>
				<?php
				$Total_ttc = $total_ht + 30 + $tva;
				$total_ttc = number_format($Total_ttc, 2, '.','');
				echo "<td class ='visible'>".$total_ttc."€</td>";
				?>
			</tr>
			<tr class ="separe"></tr>
			<tr class ="separe"></tr>
	</table>

	<?php
		$roq = "select * from client where EMAIL_CLI='$mail' and MDP_CLI='$code' ";
		$rop = mysql_query($roq);
		$info_cli = mysql_fetch_assoc($rop);

	echo "
	<table class ='affiche' align ='center'>
		<tr>
			<td class ='visible' colspan = 2><h4 style='background-image:none;'>Information Client</h4></td>
		</tr>
		<tr>
			<td class ='visible' style='text-align:right;'>Nom : </td>
			<td class ='visible'>".$info_cli['NOM_CLI']."</td>
		</tr>
		<tr>
			<td class ='visible' style='text-align:right;'>Prénom : </td>
			<td class ='visible'>".$info_cli['PRENOM_CLI']."</td>
		</tr>
		<tr>
			<td class ='visible' style='text-align:right;'>Adresse : </td>
			<td class ='visible'>".$info_cli['ADRESSE_CLI']."<br/>
			".$info_cli['COD_POST_CLI']." ".$info_cli['VILLE_CLI']."</td>
		</tr>
		<tr>
			<td class ='visible' style='text-align:right;'>Email : </td>
			<td class ='visible'>".$info_cli['EMAIL_CLI']."</td>
		</tr>
	</table></br></br>

	";


		echo 	"<table align='center'> <tr> <td><form action='acceuil.php?annuler=annul' method ='get' >
				<input type='submit' name='annuler' value='Annuler'>
				</form></td><td>";
							
		echo	"<form action='payement.php' method ='post' >
				<input type='submit' name='Valider' value='Valider'>
				</form></td></tr></table>";
	?>
</div>

</body>
</html>

<?php	
		}
		else
		{
			echo "<script>
			alert ('Votre panier est vide !');
			document.location.href='acceuil.php'
			</script>";
		}
	}
	else
	{
		echo "<script>
			alert ('Vous devez vous connecter pour pouvoir effectuer un achat !');
			document.location.href='acceuil.php'
			</script>";
	}
?>