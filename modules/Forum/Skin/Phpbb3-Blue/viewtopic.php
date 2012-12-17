<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
if (!defined("INDEX_CHECK"))
{
    die ("<div style=\"text-align: center;\">You cannot open this page directly</div>");
}

echo'<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />';
echo'<style type="text/css">

/*** Cadre affichant page suivante / precedente ***/
.Forum_prevnext_top_t{ width: 100%; }
.Forum_prevnext_top_r{}
.Forum_prevnext_top_r a:hover{ color: ' . $forumcolor1 . '; }
.Forum_prevnext_top_d1{ text-align: left; }
.Forum_prevnext_top_d2{ text-align: right; }


/*** Cadre affichange le haut des topics ***/
.Forum_haut_top_t{ width: 100%; background: ' . $forumcolor3 . ' url("modules/Forum/Skin/' . $nuked['forum_skin'] . '/images/template/headerbar.gif"); padding: 0 10px; background-repeat: repeat-x; border-radius: 10px 10px 0 0; clear: both; }
.Forum_haut_top_r{ height: 22px; color: ' . $forumcolor4 . '; }
.Forum_haut_top_d1{ width: 25%; text-align: center; }
.Forum_haut_top_d2{	width: 75%; text-align: center; }


/*** Cadre affichange le centre des topics ***/
.Forum_contenu_top_t{ width: 100%; padding: 2px 0; background: ' . $forumcolor3 . ' url("modules/Forum/Skin/' . $nuked['forum_skin'] . '/images/template/navbar.gif"); color: ' . $bgcolor3 . '; }
.Forum_contenu_top_r{ width: 100%; height: 44px; background: ' . $forumcolor2 . ' none repeat-x 0 0; }
.Forum_contenu_top_d1{ width: 25%; vertical-align: top; padding: 5px;}
.Forum_contenu_top_d1 a:hover{ color: ' . $forumcolor1 . '; }
.Forum_contenu_top_d2{ width: 75%; vertical-align: top; }
.Forum_contenu_top_r2{ height: 28px; background: ' . $bgcolor1 . '; }
.Forum_contenu_top_d3{ width: 25%; text-align: center; vertical-align: middle; }
.Forum_contenu_top_d3 a:hover{ color: ' . $forumcolor1 . '; }
.Forum_contenu_top_d4{ width: 75%; vertical-align: middle; padding-right: 5px; text-align: right; }


/*** Cadre affichange le bas des topics ***/
.Forum_bas_top_t{ width: 100%; background: ' . $forumcolor3 . ' url("modules/Forum/Skin/' . $nuked['forum_skin'] . '/images/template/headerbar.gif"); padding: 0 10px; background-repeat: repeat-x; border-radius: 0 0 10px 10px; clear: both; }
.Forum_bas_top_r{ height: 22px; }
.Forum_bas_top_d1{ text-align: right; }
.Forum_bas_top_d1 a{ color: ' . $forumcolor4 . '; }
.Forum_bas_top_d1 a:hover{ color: ' . $forumcolor1 . '; }


/*** Cadre affichant le Marquer tous les messages comme lus ***/
.Forum_markread_t{ width: 100%; }
.Forum_markread_r{}
.Forum_markread_d{ text-align: right; }
.Forum_markread_d a, a:link, a:visited{ transition-duration: 0.5s; transition-property: color; }
.Forum_markread_d a:hover, a:focus{ color: ' . $forumcolor1 . '; }


/*** Cadre affichange le sondage des topics ***/
.Forum_sondage_r{ background: ' . $bgcolor1 . ';}
.Forum_sondage_d{ color: ' . $forumcolor4 . '; }

/*** Cadre affichange les questions du sondage des topics ***/
.Forum_sondage_Q_t{ margin-left: auto; margin-right: auto; text-align: left; padding: 4px; }
.Forum_sondage_Q_r1{}
.Forum_sondage_Q_d1{}
.Forum_sondage_Q_r2{}
.Forum_sondage_Q_d2{}
.Forum_sondage_Q_d3{}
.Forum_sondage_Q_r3{}
.Forum_sondage_Q_d4{}
.Forum_sondage_Q_r4{}


/*** Cadre affichant les icones deplacer / supprimer ... ***/
.Forum_info_top_t{ width: 130px; padding: 5px; padding-bottom: 1px; border-radius: 6px; box-shadow: 1px 1px 2px rgba(0,0,0,.4); background: ' . $forumcolor6 . '; border: 1px solid ' . $forumcolor7 . '; text-align: center;	margin: auto; margin-top: 20px;}
.Forum_info_top_r1{}
.Forum_info_top_d1{}

</style>';
?>