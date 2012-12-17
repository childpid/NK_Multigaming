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


.Forum_search_t , .Forum_nav_t , .Forum_cadre_haut , .Forum_cadre_bas { font: 12px Calibri,Arial; }


/*** Cadre de recherche ***/
.Forum_search_t{ width: 100%; border: 0px; padding-bottom: 20px; }
.Forum_search_r{}
.Forum_search_d1{ text-align: center; }
.Forum_search_d2{ text-align: right; float: right; padding-right: 30px; }
.Forum_search_d2 a, a:link, a:visited{ transition-duration: 0.5s; transition-property: color;}
.Forum_search_d2 a:hover, a:focus{ color: ' . $forumcolor4 . '; }

/*** Cadre de navigation ***/
.Forum_nav_t{ width: 100%; padding: 0px; border: 0px; }
.Forum_nav_r{}
.Forum_nav_r a, a:link, a:visited{ transition-duration: 0.5s; transition-property: color; }
.Forum_nav_r a:hover, a:focus{ color: ' . $forumcolor4 . '; }
.Forum_nav_d1{ vertical-align: bottom; }
.Forum_nav_d2{ text-align: right; vertical-align: bottom; }

/*** Div du contenu haut ***/
.Forum_cadre_haut{ background: ' . $forumcolor1 . '; border: 1px solid ' . $forumcolor2 . '; }

/*** Div du contenu bas
.Forum_cadre_bas{}

/*** Cadre des membre connectés haut ***/
.Forum_online_t{ width: 100%; text-transform: uppercase;}
.Forum_online_r{ background: url("modules/Forum/Skin/' . $nuked['forum_skin'] . '/images/template/bar_principale.png"); }
.Forum_online_d{ font-weight: bold; text-transform: uppercase; border: 1px solid ' . $forumcolor2 . '; padding-left: 5px; }
.Forum_online_d a, a:link, a:visited{ transition-duration: 0.5s; transition-property: color; }
.Forum_online_d a:hover, a:focus{ color: ' . $forumcolor4 . '; }

/*** Cadre des membre connectés centre ***/
.Forum_online_centre_t{ width: 100%; padding: 1px; }
.Forum_online_centre_r{ background: ' . $forumcolor2 . '; height: 30px; }
.Forum_online_centre_d1{ text-align: center; }
.Forum_online_centre_d2{ padding-left: 5px; }
.Forum_online_centre_d2 a, a:link, a:visited{ transition-duration: 0.5s; transition-property: color; }
.Forum_online_centre_d2 a:hover, a:focus{ color: ' . $forumcolor4 . '; }
.Forum_online_centre_d3{ padding-left: 5px; }
.Forum_online_centre_d3 a, a:link, a:visited{ transition-duration: 0.5s; transition-property: color; }
.Forum_online_centre_d3 a:hover, a:focus{ color: ' . $forumcolor4 . '; }

/*** Cadre des membre connectés bas ***/
.Forum_online_bas_t{ display: none; }
.Forum_online_bas_r{}
.Forum_online_bas_d{}

input,textarea,select{ padding: 2px; border: solid 1px ' . $forumcolor1. '; outline: 0; font: normal 13px/100% Verdana, Tahoma, sans-serif; width: auto; background: -webkit-gradient(linear, left top, left 25, from(' . $forumcolor2 . '), color-stop(4%, ' . $forumcolor3 . '), to(' . $forumcolor2 . ')); background: -moz-linear-gradient(top, ' . $forumcolor2 . ', ' . $forumcolor3 . ' 1px, ' . $forumcolor2 . ' 25px); background: -ms-linear-gradient(top, ' . $forumcolor2 . ' 0%,' . $forumcolor3 . ' 1px,' . $forumcolor2 . ' 25px); border-radius:5px; }
input:hover { background: ' . $forumcolor4 . '; }


</style>';
?>