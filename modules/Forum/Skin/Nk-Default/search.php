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

/*** Cadre des erreurs "3typmmine" ***/
.Forum_Psearch_error{ text-align: center; color: #000; width: 40%; margin: auto; }
.Forum_Psearch_error_t{ text-align: center;	color: #000; background: #ccc; margin: auto; }

/*** Cadre du resultat de recherche ***/
.Forum_Psearch_result_t{ width: 100%; padding: 4px; }
.Forum_Psearch_result_r{}
.Forum_Psearch_result_d{}

/*** Cadre haut du formulaire de recherche ***/
.Forum_Psearch_haut_t{ width: 100%;	text-align: center;	background: ' . $bgcolor3 . '; }
.Forum_Psearch_haut_r{ height: 23px; }
.Forum_Psearch_haut_d1{	width: 30%; }
.Forum_Psearch_haut_d2{	width: 30%; }
.Forum_Psearch_haut_d3{	width: 25%; }
.Forum_Psearch_haut_d4{	width: 15%; }

/*** Cadre centre du resultat des recherches ***/
.Forum_Psearch_centre_t{ width: 100%; text-align: center; background: ' . $bgcolor3 . '; }
.Forum_Psearch_centre_r{ height: 34px; background: ' . $bgcolor2 . '; }
.Forum_Psearch_centre_d1{ width: 30%; }
.Forum_Psearch_centre_d2{ width: 30%; }
.Forum_Psearch_centre_d3{ width: 25%; }
.Forum_Psearch_centre_d4{ width: 15%; }

/*** Cadre centre du formulaire de recherche ***/
.Forum_Psearch_centre2_t{ width: 100%; background: ' . $bgcolor3 . '; }
.Forum_Psearch_centre2_r1{ height: 23px; background: ' . $bgcolor2 . '; }
.Forum_Psearch_centre2_r2{ height: 23px; background: ' . $bgcolor2 . '; }
.Forum_Psearch_centre2_r3{ height: 23px; background: ' . $bgcolor2 . '; }
.Forum_Psearch_centre2_r4{ height: 23px; background: ' . $bgcolor2 . '; }
.Forum_Psearch_centre2_r5{ height: 23px; background: ' . $bgcolor2 . '; }
.Forum_Psearch_centre2_r6{ height: 23px; background: ' . $bgcolor2 . '; }
.Forum_Psearch_centre2_d1{ padding-left: 5px; width: 25%; }
.Forum_Psearch_centre2_d2{ width: 75%; }
.Forum_Psearch_centre2_d3{ padding-left: 5px; width: 25%; }
.Forum_Psearch_centre2_d4{ width: 75%; }
.Forum_Psearch_centre2_d5{ padding-left: 5px; width: 25%; }
.Forum_Psearch_centre2_d6{ width: 75%; }
.Forum_Psearch_centre2_d7{ padding-left: 5px; width: 25%; }
.Forum_Psearch_centre2_d8{ width: 75%; }
.Forum_Psearch_centre2_d9{ padding-left: 5px; width: 25%; }
.Forum_Psearch_centre2_d10{ width: 75%; }
.Forum_Psearch_centre2_d11{ width: 100%; text-align: center; }

</style>';
?>