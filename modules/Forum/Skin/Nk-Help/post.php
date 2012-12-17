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

/*** Cadre haut du formulaire de post / reply ***/
.Forum_Ppost_haut_t{ width: 100%; text-align: center; }
.Forum_Ppost_haut_r{ background: url("modules/Forum/Skin/' . $nuked['forum_skin'] . '/images/template/bar_principale.png"); height: 23px; color: ' . $forumcolor2 . '; text-transform: uppercase; }
.Forum_Ppost_haut_d{ width: 30%; }

/*** Cadre centrale du formulaire de post / reply ***/
.Forum_Ppost_centre_t{ width: 100%; }
.Forum_Ppost_centre_r{ height: 36px; }
.Forum_Ppost_centre_d1{ width: 25%; padding-left: 5px; vertical-align: top; background: ' . $forumcolor3 . '; }
.Forum_Ppost_centre_d2{ width: 75%;	padding-left: 5px; }
.Forum_Ppost_centre_d2 a, a:link, a:visited{ transition-duration: 0.5s; transition-property: color; }
.Forum_Ppost_centre_d2 a:hover, a:focus{ color:	' . $forumcolor4 . '; }
.Forum_Ppost_centre_r2{	height: 36px; }
.Forum_Ppost_centre_d3{ width: 25%; padding-left: 5px; vertical-align: top;	background: ' . $forumcolor3 . '; }
.Forum_Ppost_centre_d4{	width: 75%;	padding-left: 5px; }
.Forum_Ppost_centre_r3{	height: 36px; }
.Forum_Ppost_centre_d5{ width: 25%;	padding-left: 5px; vertical-align: top;	background: ' . $forumcolor3 . '; }
.Forum_Ppost_centre_d6{	width: 75%;	padding-left: 5px; }
.Forum_Ppost_centre_r4{	height: 36px; }
.Forum_Ppost_centre_d7{ width: 25%; padding-left: 5px; vertical-align: top;	background: ' . $forumcolor3 . '; }
.Forum_Ppost_centre_d8{	width: 75%;	padding-left: 5px; }
.Forum_Ppost_centre_r5{	height: 36px; }
.Forum_Ppost_centre_d9{ width: 25%;	padding-left: 5px; vertical-align: top;	background: ' . $forumcolor3 . '; }
.Forum_Ppost_centre_d10{ width: 75%; padding-left: 5px; }
.Forum_Ppost_centre_r6{	height: 36px; }
.Forum_Ppost_centre_d11{ width: 25%; padding-left: 5px;	vertical-align: top; background: ' . $forumcolor3 . '; }
.Forum_Ppost_centre_d12{ width: 75%; padding-left: 5px; }
.Forum_Ppost_centre_r7{	height: 36px; }
.Forum_Ppost_centre_d13{ width: 25%; padding-left: 5px;	vertical-align: top; background: ' . $forumcolor3 . '; }
.Forum_Ppost_centre_d14{ width: 75%; padding-left: 5px; }
.Forum_Ppost_centre_r8{	height: 36px; }
.Forum_Ppost_centre_d15{ width: 100%; padding-top: 10px; padding-bottom: 10px; background: ' . $forumcolor3 . '; }

/*** Cadre bas du formulaire de post / reply ***/
.Forum_Ppost_bas_t{ display: none; }
.Forum_Ppost_bas_r{}
.Forum_Ppost_bas_d{}

/*** Cadre des commentaires du formulaire de post / reply ***/
.Forum_Ppost_comd{ margin-left: auto; margin-right: auto; text-align: left; width: 100%; height: 200px;	overflow: auto;	background: ' . $forumcolor3 . '; border: 1px solid ' . $forumcolor1 . '; }
.Forum_Ppost_com_t{ width: 98%;	padding: 4px; text-align: center; }
.Forum_Ppost_com_r{	text-align: left; }
.Forum_Ppost_com_d1{ width: 20%; padding-top: 5px; padding-left: 5px; }
.Forum_Ppost_com_d2{ width: 80%; padding-top: 5px; padding-left: 5px; }

</style>';
?>