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
.Forum_prevnext_for_r{}
.Forum_prevnext_for_d{ text-align: left; }

/*** Cadre affichant le haut du contenu des forums ***/
.Forum_haut_for_t{ width: 100%; padding: 1px; }
.Forum_haut_for_r{ background: url("modules/Forum/Skin/' . $nuked['forum_skin'] . '/images/template/bar_principale.png"); text-transform: uppercase; }
.Forum_haut_for_d1{ width: 4%; }
.Forum_haut_for_d2{ text-align: center; width: 45%; text-transform: uppercase; }
.Forum_haut_for_d3{ text-align: center;	width: 15%;	text-transform: uppercase; }
.Forum_haut_for_d4{	text-align: center;	width: 8%; text-transform: uppercase; }
.Forum_haut_for_d5{ text-align: center;	width: 8%; text-transform: uppercase; }
.Forum_haut_for_d6{	text-align: center;	width: 20%;	text-transform: uppercase; }

/*** Cadre affichant le contenu des forums ***/
.Forum_contenu_for_t{ width: 100%; }
.Forum_contenu_for_r{ width: 100%; background: ' . $forumcolor2 . '; }
.Forum_contenu_for_d1{ width: 4%; text-align: center; }
.Forum_contenu_for_d2{ width: 45%; padding-left: 5px; }
.Forum_contenu_for_d2 a, a:link, a:visited{ transition-duration: 0.5s; transition-property: color; }
.Forum_contenu_for_d2 a:hover, a:focus{ color: ' . $forumcolor4 . '; }
.Forum_contenu_for_d3{ width: 15%; text-align: center; }
.Forum_contenu_for_d3 a, a:link, a:visited{ transition-duration: 0.5s; transition-property: color; }
.Forum_contenu_for_d3 a:hover, a:focus{ color: ' . $forumcolor4 . '; }
.Forum_contenu_for_d4{ width: 8%; text-align: center; }
.Forum_contenu_for_d5{ width: 8%; text-align: center; }
.Forum_contenu_for_d6{ width: 20%; text-align: center; }
.Forum_contenu_for_d6 a, a:link, a:visited{ transition-duration: 0.5s; transition-property: color; }
.Forum_contenu_for_d6 a:hover, a:focus{ color: ' . $forumcolor4 . '; }
.Forum_contenu_for_r2{ background: ' . $forumcolor2 . ';	height: 32px; }
.Forum_contenu_for_error{ width: 100%; text-align: center; }

/*** Cadre affichant le bas du contenu des forums ***/
.Forum_bas_for_t{ display: none; }
.Forum_bas_for_r{}
.Forum_bas_for_d{}

/*** Cadre affichant le Marquer tous les messages comme lus ***/
.Forum_markread_t{ width: 100%; }
.Forum_markread_r{}
.Forum_markread_d{ text-align: right; }
.Forum_markread_d a, a:link, a:visited{ transition-duration: 0.5s; transition-property: color; }
.Forum_markread_d a:hover, a:focus{ color: ' . $forumcolor4 . '; }

/*** Cadre affichant les icones informatifs ***/
.Forum_info_for_t{ padding-top: 20px; }
.Forum_info_for_r1{}
.Forum_info_for_d1{}
.Forum_inf_foro_d2{}
.Forum_info_for_d3{ padding-left: 20px; }
.Forum_info_for_d4{}
.Forum_info_for_r2{}
.Forum_info_for_d5{}
.Forum_info_for_d6{}
.Forum_info_for_d7{ padding-left: 20px; }
.Forum_info_for_d8{}
.Forum_info_for_r3{}
.Forum_info_for_d9{}
.Forum_info_for_d10{}
.Forum_info_for_d11{ padding-left: 20px; }
.Forum_info_for_d12{}

/*** Cadre affichant les options de nvigations Sauter vers / Montrer les sujets depuis ***/
.Forum_option_t{ padding: 5px; margin-top: 20px; }
.Forum_option_r{}
.Forum_option_d1{}
.Forum_option_d2{}

</style>';
?>