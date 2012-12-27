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
$style_cat = "margin-top:-1px;";
}

echo'<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />';
echo'<style type="text/css">

/*** Cadre affichant la catégorie secondaire ***/
.Forum_ariane_t{ width: 100%; ' . $style_cat . '; background: url("modules/Forum/Skin/' . $nuked['forum_skin'] . '/images/template/table_bg.jpg") repeat-x scroll 0 0 ' . $forumcolor4 . '; vertical-align: middle; }
.Forum_ariane_r{ height: 33px; }
.Forum_ariane_d1{ background: url("modules/Forum/Skin/' . $nuked['forum_skin'] . '/images/template/top_bg.jpg") repeat-x scroll 0 0 transparent; }

/*** Cadre affichant le contenu haut des catégories secondaires ***/
.Forum_haut_t{ width: 100%; background: url("modules/Forum/Skin/' . $nuked['forum_skin'] . '/images/template/mbgb.jpg") repeat-x scroll 0 0 transparent; height: 45px; vertical-align: middle; }
.Forum_haut_r{ height: 22px; color: ' . $forumcolor4 . '; font: bold 12px Tahoma; }
.Forum_haut_d1{ width: 5%; }
.Forum_haut_d2{ text-align: center; width: 40%; }
.Forum_haut_d3{ text-align: center; width: 15%; }
.Forum_haut_d4{	text-align: center; width: 15%; }
.Forum_haut_d5{	text-align: center;	width: 25%; }

/*** Cadre affichant le contenu des catégories secondaires ***/
.Forum_contenu_t{ width: 100%; background: none repeat scroll 0 0 ' . $forumcolor4 . '; margin-top: -2px; }
.Forum_contenu_r{ width: 100%; height: 44px; background: none repeat scroll 0 0 ' . $forumcolor3 . '; }
.Forum_contenu_d1{ width: 5%; text-align: center; }
.Forum_contenu_d2{ width: 40%; padding-left: 5px; }
.Forum_contenu_d3{ width: 15%; text-align: center; }
.Forum_contenu_d4{ width: 15%; text-align: center; }
.Forum_contenu_d5{ width: 25%; padding-left: 5px; }
.Forum_contenu_r2{ height: 32px; }
.Forum_contenu_d6{ width: 100%; text-align:center; }

/*** Cadre affichant le contenu bas des catégories ***/
.Forum_bas_t{ display: none; }
.Forum_bas_r{}
.Forum_bas_d{}

/*** Cadre affichant le Marquer tous les messages comme lus ***/
.Forum_markread_t{ width: 100%; padding-right: 5px; background: url("modules/Forum/Skin/' . $nuked['forum_skin'] . '/images/template/mbg.jpg") repeat-x scroll 0 0 transparent; height: 45px; vertical-align: middle; font: bold 10px Tahoma; color: ' . $forumcolor1 . ';}
.Forum_markread_t a{ font: bold 10px Tahoma; color: ' . $forumcolor1 . ';}
.Forum_markread_t a:hover{ color: ' . $forumcolor2 . '; }
.Forum_markread_r{}
.Forum_markread_d{ text-align: right; }

/*** Cadre affichant les icones info (nouveau post ou pas) ***/
.Forum_info_t{ padding: 5px; color: ' . $forumcolor4 . '; }
.Forum_info_r1{}
.Forum_info_d1{}
.Forum_info_d2{}
.Forum_info_r2{}
.Forum_info_d3{}
.Forum_info_d4{}

</style>';
?>