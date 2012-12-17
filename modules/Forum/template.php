<?php
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
defined('INDEX_CHECK') or die;

global $nuked, $bgcolor1, $bgcolor2, $bgcolor3, $bgcolor4;
// Definition des 3 couleurs, par defaut ceux de nuked-klan, vous pouvez les remplacer par un code couleur.
// Exemple : $color1 = "#FFFFFF";

if($nuked['forum_skin'] == "Nk-Help")
{
	$forumcolor1 = "#CCC";
	$forumcolor2 = "#FFF";
	$forumcolor3 = "#EEE";
	$forumcolor4 = "#DD6600";
	
}else if($nuked['forum_skin'] == "Phpbb3-Blue")
{
	$forumcolor1 = "#000";
	$forumcolor2 = "#e1ebf2";
	$forumcolor3 = "#568BD3";
	$forumcolor4 = "#fff";
	$forumcolor5 = "#ccc";
	$forumcolor6 = "#d8d7d7";
	$forumcolor7 = "#6b6665";
	
}else if($nuked['forum_skin'] == "Nk-Gigoss")
{
	$forumcolor1 = "#EA8F09";
	$forumcolor2 = "#DD6600";
	$forumcolor3 = "#2B2B2B";
	$forumcolor4 = "#1B1B1B";
	
}else{
	$color1 = $bgcolor1;
	$color2 = $bgcolor2;
	$color3 = $bgcolor3;
	$color4 = $bgcolor4;
}

// Définition du background de la 1er cellule par defaut un bgcolor3, vous pouvez le remplacer par un background utilisant une image.
// Exemple : $background = "style=\"background-image:url(images/img.gif);\"";
$background = 'style="background: ' . $bgcolor3 . '"';
// Définition du background des catégories de forums par defaut un bgcolor2, vous pouvez le remplacer par un background utilisant une image.
// Exemple : $background_cat = "style=\"background-image:url(images/img2.gif);\"";
$background_cat = 'style="background: ' . $bgcolor2 . '"';

// Fonction de redimentionement des avatars (on, off, local)
$avatar_resize = 'on';

// Fonction de redimentionement des images dans la signature (on, off)
$signature_resize = 'on';

// Largeur maximal de l'avatar
$avatar_width = 150;
//Les images redimentionnée automatiquement sont cliquables (TRUE, FALSE)
$imgClic = TRUE;

//Forcer l'affichage des messages d'édition des posts (on,off)
$force_edit_message = 'off';
?>