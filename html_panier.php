<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >

<?php include_once("head.php"); ?>


<body>

<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/SiteVente/"><div id="banniere"></div></a>

<?php include_once("menu.php"); ?> 

<div id="contenu">
	<h2>Votre Panier !</h2>
	<table align='center' >
		<tr>
			<td class="visible"><h5>Désignation</h5></td>
			<td class="visible"><h5>Prix U/HT</h5></td>
			<td class="visible"><h5>Quantité</h5></td>
			<td class="visible"><h5>prix HT</h5></td>
			<td ></td>
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
						<td class='visible' >".$rat['LIBELLE_PROD']."</td>
						<td class='visible'>".$rat['PRIX_PROD']."€</td>
						<td class='visible'>".$qte_command."</td>
						<td class='visible'>".$somme."€</td>
						<td class='visible'> <form action='panier.php?supprimer=vrai&id_produit=".$rat['REFERENCE_PROD']."' method ='post' >
								<input type='submit' name='supp_article' value='X'>
								</form></td>
					</tr>";
				$total_ht = $total_ht + $somme;
			}
			$Total_ht = number_format($total_ht, 2, '.','');
		?>
			<tr class="separe"></tr>
			<tr>
				<td ></td>
				<td ></td>
				<td class="visible" style="text-align:right;">Total Hors Taxe</td>
				<td class="visible"><?php echo $Total_ht; ?>€</td>
				<td ></td>
			</tr>
			<tr>
				<td ></td>
				<td ></td>
				<td class="visible" style="text-align:right;">Frais de Port</td>
				<td class="visible" >30.00€</td>
				<td ></td>
			</tr>
			<tr>
				<td ></td>
				<td ></td>
				<td class="visible" style="text-align:right;">TVA 19,6%</td>
				<?php
				$taux_tva = 19.6;
				$Tva = ($total_ht + 30) * ($taux_tva / 100);
				$tva = number_format($Tva, 2, '.','');
				echo "<td class='visible'>".$tva."€</td>
						<td></td>";
				?>
			</tr>
			<tr>
				<td ></td>
				<td ></td>
				<td class="visible" style="text-align:right;">Total T.T.C</td>
				<?php
				$Total_ttc = $total_ht + 30 + $tva;
				$total_ttc = number_format($Total_ttc, 2, '.','');
				if($Total_ht==0)
				{
					$total_ttc=0;
				}
				
				echo "<td class='visible'>".$total_ttc."€</td>
						<td></td>";
				?>
			</tr>
	</table></br></br>
	<?php
		echo 	"<table align='center'> <tr> <td><form action='acceuil.php?choix=".$choix."&annuler=annul' method ='get' >
				<input type='submit' name='annuler' value='Annuler'>
				</form></td><td>";
					
		echo	"<form action='acceuil.php' method ='post' >
				<input type='submit' name='other_article' value='choisir un autre article'>
				</form></td><td>";
							
		echo	"<form action='confirm_panier.php' method ='post' >
				<input type='submit' name='Valider' value='Valider'>
				</form></td></tr></table>";
	?>
</div>

</body>
</html>