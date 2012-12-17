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
.Forum_prevnext_top_d1{ text-align: left; }
.Forum_prevnext_top_d2{ text-align: right; }


/*** Cadre affichange le haut des topics ***/
.Forum_haut_top_t{ width: 100%;	padding: 0px; background: ' . $bgcolor3 . '; }
.Forum_haut_top_r{ height: 22px; }
.Forum_haut_top_d1{ width: 25%; text-align: center; }
.Forum_haut_top_d2{ width: 75%; text-align: center; }


/*** Cadre affichange le centre des topics ***/
.Forum_contenu_top_t{ width: 100%; background: ' . $bgcolor3 . '; }
.Forum_contenu_top_r{ width: 100%; background: ' . $bgcolor2 . '; }
.Forum_contenu_top_d1{ width: 25%; vertical-align: top; padding: 5px; }
.Forum_contenu_top_d2{ width: 75%; vertical-align: top; }
.Forum_contenu_top_r2{ height: 32px; background: ' . $bgcolor1 . '; }
.Forum_contenu_top_d3{ width: 25%; text-align: center; vertical-align: middle;}
.Forum_contenu_top_d4{ width: 75%; vertical-align: middle; padding-left: 5px; }


/*** Cadre affichange le bas des topics ***/
.Forum_bas_top_t{ display: none; }
.Forum_bas_top_r{}
.Forum_bas_top_d1{}


/*** Cadre affichant le Marquer tous les messages comme lus ***/
.Forum_markread_t{ width: 100%; }
.Forum_markread_r{}
.Forum_markread_d{ text-align: right; }


/*** Cadre affichange le sondage des topics ***/
.Forum_sondage_r{ background: ' . $bgcolor4 . '}
.Forum_sondage_d{}

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
.Forum_info_top_t{ padding-top: 20px; }
.Forum_info_top_r1{}
.Forum_info_top_d1{}

</style>';
?>