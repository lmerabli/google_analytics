<div id="menu_gauche">
	<div class="title">Menu</div>
	<div class="interne">
		<ul>
			<li><a><strong>
			<?php 
			if(!empty($_SESSION['mail']) AND !empty($_SESSION['code_secu']))
			{
				$requete =  "select * from client where EMAIL_CLI ='".$_SESSION['mail']."' AND MDP_CLI = '".$_SESSION['code_secu']."'  ";
				$reponse = mysql_query($requete);
				$lesReponse = mysql_fetch_array($reponse);

					
				echo  $lesReponse['NOM_CLI']." ".$lesReponse['PRENOM_CLI']." est connecté";
			}
			?>
			</strong></a></li>
			<?php if(!empty($_SESSION['mail']) AND !empty($_SESSION['code_secu'])){
				echo '
					<li><a href="deconnection.php">Déconnexion</a></li>
				';
			} ?>
			<?php if(empty($_SESSION['mail']) AND empty($_SESSION['code_secu'])){
				echo '
					<li><a href="inscription.php">Inscription</a></li>
					<li><a href="connection.php">Connexion</a></li>
				';
			} ?>
			<li><a href="confirm_panier.php">Mon Panier</a></li>
			<li><a href="acceuil.php">Index</a></li>
		</ul>
	</div>
	
<?php
	$rzq = "SELECT * FROM type";
	$rzp = mysql_query($rzq);
	$rzs = mysql_num_rows($rzp);
	
	echo "<script>
			function $(leId)
			{
				return document.getElementById(leId);
			}
	
			function deroulant(selection)
			{
				switch(selection)
				{
	";
	
	$roq = "SELECT * FROM type";
	$rop = mysql_query($roq);
	
	$num=0;
	while($ros=mysql_fetch_assoc($rop))
	{
		$num++;
		echo "case\"menu_".$ros['LIBELLE_TYPE']."\":";
		
		$i=0;
		$ryq = "SELECT * FROM type";
		$ryp = mysql_query($ryq);
		while($rys=mysql_fetch_assoc($ryp))
		{	
			$i++;
			if($i == $num)
			{$monDisplay = "block"; }
			else
			{$monDisplay = "none"; }
			echo "$('sous_menu_".$rys['LIBELLE_TYPE']."').style.display = \"".$monDisplay."\" ; ";
		}
		echo "break;";
	}
	echo "		}
			} 
		</script>
	"; 
?>

	<?php
		$riq = "SELECT * FROM type";
		$rip = mysql_query($riq);
		
		while($ris=mysql_fetch_assoc($rip))
		{
			echo "<div style='border-bottom:solid 1px black; cursor:pointer;' class='title2' id='menu_".$ris['LIBELLE_TYPE']."' onclick='deroulant(\"menu_".$ris['LIBELLE_TYPE']."\")'>
					".$ris['LIBELLE_TYPE']."
					</div>
				<div id='sous_menu_".$ris['LIBELLE_TYPE']."' style='display:none'>
			";	
			
			$ruq = "SELECT * FROM categorie WHERE ID_TYPE = ".$ris['ID_TYPE']." ";
			$rup = mysql_query($ruq);
			echo "	<div class='interne'><ul>";
			while($rus=mysql_fetch_assoc($rup))
			{
				echo "<li><a href='acceuil.php?choix=".$rus['ID_CAT']."'>".$rus['LIBELLE_CAT']."</a></li>";
			}
			
			echo"</ul></div></div>";
		}
	?>
</div>

