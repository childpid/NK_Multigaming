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

/*** Cadre affichant la catégorie secondaire ***/
.Forum_ariane_t{ width: 100%; }
.Forum_ariane_r{ background: url("modules/Forum/Skin/' . $nuked['forum_skin'] . '/images/template/bar_secondaire.png"); height: 26px; }
.Forum_ariane_d1{}
.Forum_ariane_d1 a, a:link, a:visited{ transition-duration: 0.5s; transition-property: color; }
.Forum_ariane_d1 a:hover, a:focus{ color: ' . $forumcolor4 . '; }

/*** Cadre affichant le contenu haut des catégories secondaires ***/
.Forum_haut_t{ width: 100%; height: 23px; padding: 1px; background: url("modules/Forum/Skin/' . $nuked['forum_skin'] . '/images/template/bar_principale.png");border:1px solid ' . $forumcolor1 . ';}
.Forum_haut_r{ text-transform: uppercase; }
.Forum_haut_d1{ width: 5%; }
.Forum_haut_d2{	text-align: center;	width: 40%;	text-transform: uppercase; }
.Forum_haut_d3{	text-align: center;	width: 15%; text-transform: uppercase; }
.Forum_haut_d4{	text-align: center;	width: 15%; text-transform: uppercase; }
.Forum_haut_d5{	text-align: center;	width: 25%;	text-transform: uppercase; }

/*** Cadre affichant le contenu des catégories secondaires ***/
.Forum_contenu_t{ width: 100%; margin-top: -1px; }
.Forum_contenu_r{ width: 100%; background: ' . $forumcolor2 . '; }
.Forum_contenu_d1{ width: 5%; text-align: center; }
.Forum_contenu_d2{ width: 40%; padding-left: 5px; }
.Forum_contenu_d2 a, a:link, a:visited{	transition-duration: 0.5s; transition-property: color; }
.Forum_contenu_d2 a:hover, a:focus{	color: ' . $forumcolor4 . '; }
.Forum_contenu_d3{ width: 15%; text-align: center; }
.Forum_contenu_d4{ width: 15%; text-align: center; }
.Forum_contenu_d5{ width: 25%; padding-left: 5px; }
.Forum_contenu_d5 a, a:link, a:visited{ transition-duration: 0.5s; transition-property: color; }
.Forum_contenu_d5 a:hover, a:focus{ color: ' . $forumcolor4 . '; }
.Forum_contenu_r2{ background: ' . $forumcolor2 . '; height: 32px; }
.Forum_contenu_d6{ width: 100%; text-align:center; background: ' . $forumcolor1 . '; }

/*** Cadre affichant le contenu bas des catégories ***/
.Forum_bas_t{ display: none; }
.Forum_bas_r{}
.Forum_bas_d{}

/*** Cadre affichant le Marquer tous les messages comme lus ***/
.Forum_markread_t{ display: none; }
.Forum_markread_r{}
.Forum_markread_d{}

/*** Cadre affichant les icones info (nouveau post ou pas) ***/
.Forum_info_t{ padding-top: 20px; }
.Forum_info_r1{}
.Forum_info_d1{}
.Forum_info_d2{}
.Forum_info_r2{}
.Forum_info_d3{}
.Forum_info_d4{}

</style>';
?>