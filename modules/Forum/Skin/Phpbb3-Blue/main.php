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

if ($nuked['forum_cat_prim'] == "off")
{ 
$style_cat = "margin-top:20px; border-radius: 10px 10px 0 0;";
$style_cat_titre = "margin-bottom: 0px;";
}

echo'<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />';
echo'<style type="text/css">

/*** Cadre affichant la catégorie secondaire ***/
.Forum_ariane_t{ width: 100%;' . $style_cat .'; background: ' . $forumcolor3 . ' url("modules/Forum/Skin/' . $nuked['forum_skin'] . '/images/template/navbar.gif"); }
.Forum_ariane_r{ height: 26px; }
.Forum_ariane_d1{ color: ' . $forumcolor4 . '; }
.Forum_ariane_d1 a{ color: ' . $forumcolor4 . '; }

/*** Cadre affichant le contenu haut des catégories secondaires ***/
.Forum_haut_t{ width: 100%; ' . $style_cat_titre .' ; background: ' . $forumcolor3 . ' url("modules/Forum/Skin/' . $nuked['forum_skin'] . '/images/template/headerbar.gif"); padding: 0 10px; background-repeat: repeat-x; border-radius: 10px 10px 10px 10px; clear: both; }
.Forum_haut_r{ height: 24px; color: ' . $forumcolor4 . '; }
.Forum_haut_d1{ width: 5%; }
.Forum_haut_d2{ text-align: center;	width: 40%; }
.Forum_haut_d3{	text-align: center;	width: 15%; }
.Forum_haut_d4{	text-align: center;	width: 15%; }
.Forum_haut_d5{	text-align: center;	width: 25%; }

/*** Cadre affichant le contenu des catégories secondaires ***/
.Forum_contenu_t{ width: 100%; padding: 2px 0; background: ' . $forumcolor3 . ' url("modules/Forum/Skin/' . $nuked['forum_skin'] . '/images/template/navbar.gif"); color: ' . $bgcolor3 . '; }
.Forum_contenu_r{ width: 100%; height: 44px; background: ' . $forumcolor2 . ' none repeat-x 0 0; }
.Forum_contenu_d1{ width: 5%; text-align: center; }
.Forum_contenu_d2{ width: 40%; padding-left: 5px; }
.Forum_contenu_d2:hover{ background: ' . $forumcolor4 . '; }
.Forum_contenu_d2 a:hover{ color: ' . $forumcolor1 . '; }
.Forum_contenu_d3{ width: 15%; text-align: center; }
.Forum_contenu_d4{ width: 15%; text-align: center; background: ' . $forumcolor2 . ' none repeat-x 0 0; }
.Forum_contenu_d5{ width: 25%; padding-left: 5px; }
.Forum_contenu_d5 a:hover{ color: ' . $forumcolor1 . '; }
.Forum_contenu_r2{ height: 32px; }
.Forum_contenu_d6{ width: 100%;	text-align:center; background: ' . $forumcolor2 . ' none repeat-x 0 0; }

/*** Cadre affichant le contenu bas des catégories ***/
.Forum_bas_t{ width: 100%; background: ' . $forumcolor3 . ' url("modules/Forum/Skin/' . $nuked['forum_skin'] . '/images/template/headerbar.gif"); padding: 0 10px; background-repeat: repeat-x; border-radius: 0 0 10px 10px; clear: both; }
.Forum_bas_r{ height: 22px; color: ' . $forumcolor4 . '; }
.Forum_bas_d{ text-align: right; }
.Forum_bas_d a{ color: ' . $forumcolor4 . '; }
.Forum_bas_d a:hover{ color: ' . $forumcolor1 . '; }

/*** Cadre affichant le Marquer tous les messages comme lus ***/
.Forum_markread_t{ width: 100%; padding-right: 8px; }
.Forum_markread_r{}
.Forum_markread_d{ text-align: right; }
.Forum_markread_d a, a:link, a:visited{ transition-duration: 0.5s; transition-property: color; }
.Forum_markread_d a:hover, a:focus{ color: ' . $forumcolor1 . '; }

/*** Cadre affichant les icones info (nouveau post ou pas) ***/
.Forum_info_t{ padding-top: 10px; }
.Forum_info_r1{}
.Forum_info_d1{}
.Forum_info_d2{}
.Forum_info_r2{}
.Forum_info_d3{}
.Forum_info_d4{}

</style>';
?>