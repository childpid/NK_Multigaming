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
    <title>Mise à jour du patch NK Conversion</title>
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
     <h2 style="padding: 20px 0 35px 0;">Bienvenue sur l'assistant de mise à jour du patch NK Conversion</h2>
     <p style="margin: -30px 0 20px 0;">Version 1.1</p>
      
     <h3>Description :</h3>
     <p style="padding-top:10px;">Ce patch est une conversion de votre site Nuked Klan pour répondre aux attentes des utilisateurs Gamers et non gamers.<br />Il contient les modules  <font color="#57a000">Forum</font>,  <font color="#57a000">User</font>,  <font color="#57a000">Team</font> et  <font color="#57a000">Membres</font>. Ajout du module  <font color="#57a000">Equipe</font> de N1pple et mis à jour par Yurty et Sekuline pour la 1.79 (module qui permet d'ajouter autant de teams et de rang que l'on souhaite pour les membres avec un niveau d'admin > 1)</p>    
     
     <h3 style="padding-top:20px;">Liste des modifications :</h3>
     <p style="padding-top:10px;margin-left:30px;">

<u><b>Module Forum :</b></u><br/><br/>
-Correction  édition/ajout modérateur<br/>
-Correction fonction page<br/>
-Correction du lien navigation<br/>
-Correction de la fonction message lu/non lu sur les catégories primaires (Merci à Samoth !)<br/>
-Correction d'une erreur lors de l'affichage des rank colors sur le viewforum<br/>
-Ajout de la possibilité de désactiver les sous catégories depuis l'administration (Vous retrouvez le forum nk d'origine en conservant toutes les autres fonctionnalités du patchs : skins, images, rank colors, edition rapide , etc...)<br/></p>      
     
      <h3 style="padding-top:20px;">Mise à jour du patch :</h3>
      <p style="padding-top:10px;">
         <font color="#57a000">1-</font> Dézipper l'archive<br />
         <font color="#57a000">2-</font> Uploader le contenu du dossier UPLOAD à la racine de votre FTP<br />
         <font color="#57a000">3-</font> Lancer la mise à jour du module par : http://<em><b>votre_adresse</b></em>/update.php<br />
         <font color="#57a000">4-</font> Rendez vous dans l'administration pour configurer votre patch<br />
         <font color="#57a000">Note pour le forum:</font> Créer des catégories primaires, et éditez vos catégories secondaire en choisissant une catégorie primaire pour les voir apparaitre dans le forum.<br />
         <font color="#57a000">Note pour le forum:</font> Vous pouvez desormais si vous le souhaitez désactiver les catégories primaires en cochant la case correspondante dans les préférences de l'administration du module Forum<br />         
      </p>
      <br/>
      <br/>
      <form action="update.php?op=send" method="post">
      <p style="text-align:center;margin-bottom:50px;">
          <input type="submit" class="button" name="conf" value="Poursuivre la mise à jour" />&nbsp;&nbsp;<input type="submit" class="button" name="nul" value="Annuler" />
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



//******Mises à jour des tables******

	$sql = mysql_query("INSERT INTO " . $nuked['prefix'] . "_config (name, value) VALUES ('forum_cat_prim', 'on')");
	

//******Fin mises à jour des tables******


	?><h2 style="text-align:center;padding-top:50px;">Mise à jour du patch "NK Conversion V1.1" éffectuée avec succès.<br /><br />Redirection...</h2><?php
	
	//******Supression automatique du fichier install.php et update.php******
	@unlink("install.php");
	@unlink("update.php");	
	redirect("index.php", 3);

  }
  else if ( isset( $_POST['nul'] ) )
  {
    head();
	@unlink("install.php");
	@unlink("update.php");	
    ?><h2 style="text-align:center;padding-top:50px;">Mise à jour annulée. Redirection vers l'index.</h2><?php
    redirect("index.php", 3);
  }
  else
  {
    header('Location: update.php');
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