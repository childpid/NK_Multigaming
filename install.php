<?php 
////////////////////////////////////////////////
//  Patch NK Conversion                       //
//	Assemblé par Zdav, Maxxi & Stive          //
//	http://nuked-klan.org                     //
////////////////////////////////////////////////

define ("INDEX_CHECK", 1);

if (is_file('globals.php')) include ("globals.php");
else die('<br /><br /><div style=\"text-align: center;\"><b>install.php doit se trouver près de globals.php</b></div>');
if (is_file('conf.inc.php')) @include ("conf.inc.php");
else die('<br /><br /><div style=\"text-align: center;\"><b>install.php doit se trouver près de conf.inc.php</b></div>');
if (is_file('nuked.php')) include('nuked.php');
else die('<br /><br /><div style=\"text-align: center;\"><b>install.php doit se trouver près de nuked.php</b></div>');


function head()
{
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Installation du patch NK Conversion</title>
        <link rel="stylesheet" href="modules/Admin/css/reset.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="modules/Admin/css/style.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="modules/Admin/css/invalid.css" type="text/css" media="screen" />
    </head>
    <body>
    
    <?php
}

function index()
{
   head();
   ?>

   <div style="width:150px; height:150px; margin : -10px 0 0 61px; float:left;">
      <a href="http://www.nuked-klan.org" target="_blank"><img id="logo" src="modules/Admin/images/logo.png" alt="Simpla Admin logo" /></a>
      <div style="margin : 11px auto 0 auto; color:#888888; font-size:11px;"><center>Patch assemblé par&nbsp;:<br /><br />
          <a href="http://www.nuked-klan.org/index.php?file=Members&op=detail&autor=Zdav" target="_blank" title="Voir le profil sur nk.org">Zdav</a><br />
          <a href="http://www.nuked-klan.org/index.php?file=Members&op=detail&autor=Maxxi" target="_blank" title="Voir le profil sur nk.org">Maxxi</a><br />
          <a href="http://www.nuked-klan.org/index.php?file=Members&op=detail&autor=Stive" target="_blank" title="Voir le profil sur nk.org">Stive</a></center>
      </div>
   </div> 

   <div style="width:750px; margin:20px auto 0 260px;">
     <h2 style="padding: 20px 0 35px 0;">Bienvenue sur l'installation du patch NK Conversion</h2>
     <p style="margin: -30px 0 20px 0;">Version 1.1</p>  
     <h3>Description :</h3>
     <p style="padding-top:10px;">Ce patch est une conversion de votre site Nuked Klan pour répondre aux attentes des utilisateurs Gamers et non gamers.<br />Il contient les modules  <font color="#57a000">Forum</font>,  <font color="#57a000">User</font>,  <font color="#57a000">Team</font> et  <font color="#57a000">Membres</font>. Ajout du module  <font color="#57a000">Equipe</font> de N1pple et mis à jour par Yurty et Sekuline pour la 1.79 (module qui permet d'ajouter autant de teams et de rang que l'on souhaite pour les membres avec un niveau d'admin > 1)</p>    
     
     <h3 style="padding-top:20px;">Liste des modifications :</h3>
     <p style="padding-top:10px;margin-left:30px;"><u><b>Modules User, Team, Membre et Equipe:</b></u><br/><br/>
-Ajout des champs  : Steam, Skype, Facebook , Twitter, Origin, en plus des originaux : Msn, aim, Yim et icq.<br/>
-Choix des champs à afficher depuis l'administration (on peut enfin désactiver les champs aim, Yim et icq :) ).<br/>
-Choix du niveau à partir duquel ces informations sont visibles sur le site.<br/>
-Intégration de ces infos sur les modules : User, Team, Membres, Forum et Equipe.<br/>
-Ajout du user rank color pour le forum uniquement (choix de la couleur du membre en fonction de son rang team)<br/>
-Ajout d'une image pour le rang Team<br/><br/>

<u><b>Module Forum :</b></u><br/><br/>
-Ajout du patch Sous Catégories pour le Forum de Maxxi<br/>
-Ajout de la possibilité de désactiver les Sous Catégories<br/>
-Ajout du Skin Forum par Maxxi: Permet depuis l'administration de changer le design du Forum sous forme de templates, 4 templates disponibles (Nk_defaut, Nk_Guigoz, Nk_help et Nk_phpbb)<br/>
-Tous les composants Skin Forum (titres, champ recherche , modérateurs etc...) peuvent être désactivés via l'administration.<br/>
-Possibilité de créer ses propres skins.<br/>
-Ajout d'images pour les catégories (principales et secondaires + miniatures) via l'administration.<br/>
-Ajout d'images pour les forums via l'administration.<br/>
-Ajout de statistiques dans l'esprit phpbb sur le footer du Forum<br/>
-Ajout de la légende des rangs team dans le footer du forum si activé dans l'administration<br/>
-Ajout des anniversaires si activé dans l'administration<br/>
-Affichage de la couleur des utilisateur en fonction du rang team (ON/OFF via l'admin).<br/>
-Ajout de l'image du rang team dans la partie viewtopic, lorsque l'option est coché dans l'administration<br/>
-Ajout du "en ligne/hors ligne " dans la partie viewtopic<br/>
-Ajout du Jeu préféré et des préférences jeu dans la partie viewtopic lorsque l'option est activé dans l'administration<br/>
-Ajout du patch édition rapide de Maxxi pour le viewtopic.<br/>
-Nouvelle interface pour les messages non lu sur le forum (montrer les nouveaux forum depuis : 1j, 2j etc..)<br/>
-Toutes les images du Forum sont désormais en png<br/>
-and more...</p>      
     
      <h3 style="padding-top:20px;">Installation du patch :</h3>
      <p style="padding-top:10px;">
         <font color="#57a000">1-</font> Dézipper l'archive<br />
         <font color="#57a000">2-</font> Uploader le contenu du dossier UPLOAD à la racine de votre FTP<br />
         <font color="#57a000">3-</font> Lancer l'installation du module par : http://<em><b>votre_adresse</b></em>/install.php<br />
         <font color="#57a000">4-</font> Rendez vous dans l'administration pour configurer votre patch<br />
         <font color="#57a000">Note pour le forum:</font> Créer des catégories primaires, et éditez vos catégories secondaire en choisissant une catégorie primaire pour les voir apparaitre dans le forum.<br />
      </p>
      <br/>
      <br/>
      <form action="install.php?op=send" method="post">
      <p style="text-align:center;margin-bottom:50px;">
          <input type="submit" class="button" name="conf" value="Poursuivre l'installation" />&nbsp;&nbsp;<input type="submit" class="button" name="nul" value="Annuler" />
      </p>
      </form>
   </div>
   
</body>   
   <?php
}

function send()
{
  global $nuked,$db_prefix;
  
  if ( isset( $_POST['conf'] ) )
  {
    head();

//Efface les tables si déjà existantes
	$req = mysql_query("DROP TABLE IF EXISTS ". $nuked['prefix'] ."_staff");
	$req = mysql_query("DROP TABLE IF EXISTS ". $nuked['prefix'] ."_staff_cat");
	$req = mysql_query("DROP TABLE IF EXISTS ". $nuked['prefix'] ."_staff_rang");
	$req = mysql_query("DROP TABLE IF EXISTS ". $nuked['prefix'] ."_staff_status");
	$req = mysql_query("DROP TABLE IF EXISTS ". $nuked['prefix'] ."_forums_primaire");
    
//*****Création des tables****** 
	$sql = "DROP TABLE IF EXISTS " . $nuked['prefix'] . "_page";
	$req = mysql_query($sql);

	$sql = "CREATE TABLE " . $nuked['prefix'] . "_page (
    `id` int(11) NOT NULL auto_increment,
    `niveau` int(1) NOT NULL default '0',
    `titre` varchar(50) NOT NULL default '',
    `content` text NOT NULL,
    `url` varchar(80) NOT NULL default '',
    `type` varchar(5) NOT NULL default '',
    `show_title` int(1) NOT NULL default '0',
    `members` text NOT NULL,
    PRIMARY KEY  (`id`),
    KEY `titre` (`titre`)
	) ENGINE=MyISAM;";
	$req = mysql_query($sql);

	$sql = "INSERT INTO " . $nuked['prefix'] . "_config (name, value) VALUES ('index_page', '');";
	$req = mysql_query($sql);
  
	$sqlchk = mysql_query("SELECT * FROM " . $nuked['prefix'] . "_modules WHERE nom = 'Page'");
	
	if ( mysql_num_rows($sqlchk) == 0 )
	{
		$sql = mysql_query("INSERT INTO " . $nuked['prefix'] . "_modules (id, nom, niveau, admin) VALUES ('', 'Page', 0, 9);");
	}
    
$sql = "CREATE TABLE IF NOT EXISTS `$nuked[prefix]"._users_config."` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` text NOT NULL,
  `icq` text NOT NULL,
  `msn` text NOT NULL,
  `aim` text NOT NULL,
  `yim` text NOT NULL,
  `xfire` text NOT NULL,
  `facebook` text NOT NULL,
  `originea` text NOT NULL,
  `steam` text NOT NULL,
  `twiter` text NOT NULL,
  `skype` text NOT NULL,
  `lien` text NOT NULL,
  `nivoreq` int(1) NOT NULL default '0',  
  PRIMARY KEY (`id`)
)"; 
	$req = mysql_query($sql);

 // Création de la table catégorie primaire */
  $sql = "CREATE TABLE ". $nuked['prefix'] ."_forums_primaire (
    `id` int(11) NOT NULL auto_increment,
    `nom` varchar(100) DEFAULT NULL,    
    `ordre` int(5) NOT NULL default '0',
    `niveau` int(1) NOT NULL default '0',
    `image` varchar(200) NOT NULL default '',    
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;";
$req = mysql_query($sql);

	//Création de la table "staff"
	$sql = "CREATE TABLE ". $nuked['prefix'] ."_staff (
	  `id` int(11) NOT NULL auto_increment,
	  `membre_id` varchar(20) collate latin1_german2_ci NOT NULL default '',
	  `categorie_id` int(11) NOT NULL default '0',
	  `date` int(11) NOT NULL default '0',
	  `status_id` varchar(25) collate latin1_german2_ci NOT NULL default '',
	  `rang_id` varchar(25) collate latin1_german2_ci NOT NULL default '',
	  UNIQUE KEY `id` (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=24 ;";
	$req = mysql_query($sql);

	//Création de la table "staff_cat"
	$sql = "CREATE TABLE ". $nuked['prefix'] ."_staff_cat (
	  `id` int(11) NOT NULL auto_increment,
	  `nom` varchar(255) collate latin1_german2_ci NOT NULL default '',
	  `img` varchar(255) collate latin1_german2_ci NOT NULL default '',
	  `ordre` int(5) NOT NULL default '0',
	  `tag` text collate latin1_german2_ci NOT NULL,
	  `tag2` text collate latin1_german2_ci NOT NULL,
	  UNIQUE KEY `id` (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=11 ;";
	$req = mysql_query($sql);

	//Création de la table "staff_rang"
	$sql = "CREATE TABLE ". $nuked['prefix'] ."_staff_rang (
	  `id` int(11) NOT NULL auto_increment,
	  `nom` varchar(25) collate latin1_german2_ci NOT NULL default '',
	  `ordre` int(5) NOT NULL default '0',
	  UNIQUE KEY `id` (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=10 ;
	";
	$req = mysql_query($sql);

	//Création de la table "staff_status"
	$sql = "CREATE TABLE ". $nuked['prefix'] ."_staff_status (
	  `id` int(11) NOT NULL auto_increment,
	  `nom` varchar(25) collate latin1_german2_ci NOT NULL default '',
	  UNIQUE KEY `id` (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=5 ;
	";
	$req = mysql_query($sql);



//******Mises à jour des tables******

  $sql = mysql_query("ALTER TABLE  " . $nuked['prefix'] . "_users ADD COLUMN (xfire varchar(50), facebook varchar(50), origin varchar(50), steam varchar(50), twitter varchar(50), skype varchar(50))");

  $sql = mysql_query("ALTER TABLE  " . $nuked['prefix'] . "_team_rank ADD COLUMN (image varchar(200), couleur varchar(6))");
 
  $sql = mysql_query("ALTER TABLE  " . $nuked['prefix'] . "_forums ADD COLUMN (image varchar(200))");
  
  $sql = "ALTER TABLE " . $db_prefix . "_forums_cat ADD `moderateurs` text NOT NULL AFTER `niveau`";
  $req = mysql_query($sql);
    
  $sql = "ALTER TABLE " . $db_prefix . "_forums_cat ADD `cat_primaire` int(5) DEFAULT '0' NOT NULL AFTER `id`";
  $req = mysql_query($sql);

  $sql = "ALTER TABLE " . $db_prefix . "_forums_cat ADD `level` int(1) DEFAULT '0' NOT NULL AFTER `nom`";
  $req = mysql_query($sql);

  $sql = "ALTER TABLE " . $db_prefix . "_forums_cat ADD `comment` text NOT NULL AFTER `moderateurs`";
  $req = mysql_query($sql);
  
  $sql = "ALTER TABLE " . $db_prefix . "_games ADD  `description` text NOT NULL AFTER  `titre`";
  $req = mysql_query($sql);

  $sql = mysql_query("ALTER TABLE  " . $nuked['prefix'] . "_forums_cat ADD COLUMN (image varchar(200))");
  $sql = mysql_query("ALTER TABLE  " . $nuked['prefix'] . "_forums_cat ADD COLUMN (imagemini varchar(200))");
	$sql = mysql_query("INSERT INTO " . $nuked['prefix'] . "_config (name, value) VALUES ('forum_cat_prim', 'on')");
	$sql = mysql_query("INSERT INTO " . $nuked['prefix'] . "_config (name, value) VALUES ('image_forums', 'on')");
	$sql = mysql_query("INSERT INTO " . $nuked['prefix'] . "_config (name, value) VALUES ('image_cat_mini', 'on')"); 	  
	$sql = mysql_query("INSERT INTO " . $nuked['prefix'] . "_config (name, value) VALUES ('birthday_forum', 'on')");
	$sql = mysql_query("INSERT INTO " . $nuked['prefix'] . "_config (name, value) VALUES ('gamer_details', 'on')");
	$sql = mysql_query("INSERT INTO " . $nuked['prefix'] . "_config (name, value) VALUES ('profil_details', 'on')");
	$sql = mysql_query("INSERT INTO " . $nuked['prefix'] . "_config (name, value) VALUES ('forum_skin', 'Nk-Default')");
	$sql = mysql_query("INSERT INTO " . $nuked['prefix'] . "_config (name, value) VALUES ('forum_who_primaire', 'oui')");	
	$sql = mysql_query("INSERT INTO " . $nuked['prefix'] . "_config (name, value) VALUES ('forum_who_secondaire', 'oui')");	
	$sql = mysql_query("INSERT INTO " . $nuked['prefix'] . "_config (name, value) VALUES ('forum_who_viewforum', 'oui')");	
	$sql = mysql_query("INSERT INTO " . $nuked['prefix'] . "_config (name, value) VALUES ('forum_who_viewtopic', 'oui')");	
	$sql = mysql_query("INSERT INTO " . $nuked['prefix'] . "_config (name, value) VALUES ('forum_name_primaire', 'oui')");	
	$sql = mysql_query("INSERT INTO " . $nuked['prefix'] . "_config (name, value) VALUES ('forum_name_secondaire', 'oui')");	
	$sql = mysql_query("INSERT INTO " . $nuked['prefix'] . "_config (name, value) VALUES ('forum_name_viewforum', 'oui')");	
	$sql = mysql_query("INSERT INTO " . $nuked['prefix'] . "_config (name, value) VALUES ('forum_name_viewtopic', 'oui')");
	$sql = mysql_query("INSERT INTO " . $nuked['prefix'] . "_config (name, value) VALUES ('forum_search_primaire', 'oui')");
	$sql = mysql_query("INSERT INTO " . $nuked['prefix'] . "_config (name, value) VALUES ('forum_search_secondaire', 'oui')");
	$sql = mysql_query("INSERT INTO " . $nuked['prefix'] . "_config (name, value) VALUES ('forum_search_viewforum', 'oui')");
	$sql = mysql_query("INSERT INTO " . $nuked['prefix'] . "_config (name, value) VALUES ('forum_search_viewtopic', 'oui')");
	$sql = mysql_query("INSERT INTO " . $nuked['prefix'] . "_config (name, value) VALUES ('forum_quick_edit', 'oui')");
	$sql = mysql_query("INSERT INTO " . $nuked['prefix'] . "_config (name, value) VALUES ('forum_quick_modo', 'oui')");
	$sql = mysql_query("INSERT INTO " . $nuked['prefix'] . "_config (name, value) VALUES ('forum_quick_user', 'oui')");


	

//******Ajout du modules dans l'admin******

	//Vérification si INSTALLATION ou REINSTALLATION du module afin de ne pas dupliquer le liens dans l'admin
	$test = mysql_query("SELECT id FROM " . $nuked['prefix'] . "_modules WHERE nom='Equipe'");
	$req = mysql_num_rows($test);
	
	//Ajout du liens dans l'admin
	if($req == 0)
	{
		$sql = mysql_query("INSERT INTO " . $nuked['prefix'] . "_modules (id, nom, niveau, admin) VALUES ('', 'Equipe', 0, 2);");
	}


//******Ajouts dans la base de donnée******

	$sql_insert = mysql_query("INSERT INTO $nuked[prefix]"._users_config." (`id`, `mail`, `icq`, `msn`, `aim`, `yim`, `xfire`, `facebook`, `originea`, `steam`, `twiter`, `skype`, `lien`, `nivoreq`) VALUES
(1, 'on', 'on', 'on', 'on', 'on', 'on', 'on', 'on', 'on', 'on', 'on', 'on', 0)");


	?><h2 style="text-align:center;padding-top:50px;">Installation du patch "NK Conversion V1.1" éffectuée avec succès.<br /><br />Redirection...</h2><?php
	
	//******Supression automatique du fichier install.php******
	@unlink("install.php");
	@unlink("update.php");	
	redirect("index.php", 3);

  }
  else if ( isset( $_POST['nul'] ) )
  {
    head();
	@unlink("install.php");
	@unlink("update.php");	
    ?><h2 style="text-align:center;padding-top:50px;">Installation annulée. Redirection vers l'index.</h2><?php
    redirect("index.php", 3);
  }
  else
  {
    header('Location: install.php');
  }
}

switch($_GET['op'])
{
	case"index":
	index();
	break;
	
	case"send":
	send();
	break;

	default:
	index();
	break;
}