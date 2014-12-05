<script>
	function deroulant(selection)
	{
		switch(selection)
		{
			case"menu_general":
				document.getElementById('sous_menu_general').style.display = "block" ;
				document.getElementById('sous_menu_article').style.display = "none" ;
				document.getElementById('sous_menu_type').style.display = "none" ;
				document.getElementById('sous_menu_categorie').style.display = "none" ;
				break;
				
			case"menu_article":
				document.getElementById('sous_menu_general').style.display = "none" ;
				document.getElementById('sous_menu_article').style.display = "block" ;
				document.getElementById('sous_menu_type').style.display = "none" ;
				document.getElementById('sous_menu_categorie').style.display = "none" ;
				break;
				
			case"menu_type":
				document.getElementById('sous_menu_general').style.display = "none" ;
				document.getElementById('sous_menu_article').style.display = "none" ;
				document.getElementById('sous_menu_type').style.display = "block" ;
				document.getElementById('sous_menu_categorie').style.display = "none" ;
				break;
				
			case"menu_categorie":
				document.getElementById('sous_menu_general').style.display = "none" ;
				document.getElementById('sous_menu_article').style.display = "none" ;
				document.getElementById('sous_menu_type').style.display = "none" ;
				document.getElementById('sous_menu_categorie').style.display = "block" ;
				break;
				
			case"":
				document.getElementById('sous_menu_general').style.display = "none" ;
				document.getElementById('sous_menu_article').style.display = "none" ;
				document.getElementById('sous_menu_type').style.display = "none" ;
				document.getElementById('sous_menu_categorie').style.display = "none" ;
				break;
		}
	} 
</script>

<div id="menu_droite_admin">
	<div id="menu_general" style="border:1px solid black" onclick="deroulant('menu_general')">
		<span class="menu">Menu Administrateur</span><br/>
	</div>
	<div id="sous_menu_general" style="display:none">
		<a href="gestion_article.php">Retour index</a><br/>
		<a href="modif_login.php">Modifier login</a><br/>
		<a href="modif_pass.php">Modifier password</a><br/>
		<a href="deconnection.php">Quitter</a><br/>
	</div>
		<div id="menu_article" style="border:1px solid black" onclick="deroulant('menu_article')">
		<span class="menu">Gestion des articles</span><br/>
	</div>
	<div id="sous_menu_article" style="display:none">
		<a href="gestion_article.php">Ajouter un article</a><br/>
		<a href="supp_article.php">Supprimer un article</a><br/>
	</div>
	<div id="menu_type" style="border:1px solid black" onclick="deroulant('menu_type')">
		<span class="menu">Gestion des types</span><br/>
	</div>
	<div id="sous_menu_type" style="display:none">
		<a href="ajout_type.php">Ajouter un type</a><br/>
		<a href="supp_type.php">Supprimer un type</a><br/>
	</div>
	<div id="menu_categorie" style="border:1px solid black" onclick="deroulant('menu_categorie')">
		<span class="menu">Gestion des categories</span><br/>
	</div>
	<div id="sous_menu_categorie" style="display:none">
		<a href="ajout_categorie.php">Ajouter une categorie</a><br/>
		<a href="supp_categorie.php">Supprimer une categorie</a><br/>
	</div>
</div>