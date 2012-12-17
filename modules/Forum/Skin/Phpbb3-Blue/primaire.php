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

/*** Cadre affichant la catégorie primaire ***/
.Forum_ariane_pri_t{ width: 100%; background: ' . $forumcolor3 . ' url("modules/Forum/Skin/' . $nuked['forum_skin'] . '/images/template/navbar.gif"); }
.Forum_ariane_pri_r{ height: 25px; }
.Forum_ariane_pri_d1{ color: ' . $forumcolor4 . '; }
.Forum_ariane_pri_d1 a{ color: ' . $forumcolor4 . '; }

/*** Cadre affichant le contenu haut des catégories primaires ***/
.Forum_haut_pri_t{ width: 100%; background: ' . $forumcolor3 . ' url("modules/Forum/Skin/' . $nuked['forum_skin'] . '/images/template/headerbar.gif"); padding: 0 10px; background-repeat: repeat-x; border-radius: 10px 10px 0 0; clear: both; }
.Forum_haut_pri_r{ height: 22px; color: ' . $forumcolor4 . '; }
.Forum_haut_pri_d1{ width: 7%; }
.Forum_haut_pri_d2{ text-align: center; width: 70%; }
.Forum_haut_pri_d3{ text-align: center;	width: 23%; }

/*** Cadre affichant le contenu des catégories primaires ***/
.Forum_contenu_pri_t{ width: 100%; padding: 2px 0; background: ' . $forumcolor3 . ' url("modules/Forum/Skin/' . $nuked['forum_skin'] . '/images/template/navbar.gif"); color: ' . $bgcolor3 . '; }
.Forum_contenu_pri_r{ width: 100%; height: 44px; background: ' . $forumcolor2 . ' none repeat-x 0 0; }
.Forum_contenu_pri_d1{ width: 7%; text-align: center; }
.Forum_contenu_pri_d2{ width: 70%; padding-left: 5px; }
.Forum_contenu_pri_d2:hover{ background: ' . $forumcolor4 . '; }
.Forum_contenu_pri_d2 a:hover{ color: ' . $forumcolor1 . '; }
.Forum_contenu_pri_d3{ width: 23%; padding-left: 5px; }
.Forum_contenu_pri_d3 a:hover{ color: ' . $forumcolor1 . '; }
.Forum_contenu_pri_r2{ height: 32px; }
.Forum_contenu_pri_d4{ width: 100%;	text-align: center;	background: ' . $forumcolor2 . ' none repeat-x 0 0; }

/*** Cadre affichant le contenu bas des catégories primaires ***/
.Forum_bas_pri_t{ width: 100%; background: ' . $forumcolor3 . ' url("modules/Forum/Skin/' . $nuked['forum_skin'] . '/images/template/headerbar.gif"); padding: 0 10px; background-repeat: repeat-x; border-radius: 0 0 10px 10px;	clear: both; margin-bottom: 20px; }
.Forum_bas_pri_r{ height: 22px; }
.Forum_bas_pri_d{ text-align: right; }
.Forum_bas_pri_d a{ color: ' . $forumcolor4 . '; }
.Forum_bas_pri_d a:hover{ color: ' . $forumcolor1 . '; }

/*** Cadre affichant le Marquer tous les messages comme lus ***/
.Forum_markread_t{ display: none; }
.Forum_markread_r{}
.Forum_markread_d{}

/*** Cadre affichant les icones info (nouveau post ou pas) ***/
.Forum_info_pri_t{ padding-top: 10px; }
.Forum_info_pri_r1{}
.Forum_info_pri_d1{}
.Forum_info_pri_d2{}
.Forum_info_pri_r2{}
.Forum_info_pri_d3{}
.Forum_info_pri_d4{}

</style>';
?>