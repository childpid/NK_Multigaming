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

/*** Cadre de recherche ***/
.Forum_search_t{ width: 100%; border: 0px; padding: 20px; color: ' . $bgcolor3 . '; }
.Forum_search_t a:hover{ color: ' . $forumcolor1 . '; }
.Forum_search_r{}
.Forum_search_d1{ text-align: center; }
.Forum_search_d2{ text-align: right; float: right; padding-right: 30px; }

/*** Cadre de navigation ***/
.Forum_nav_t{ width: 100%; padding: 0px; border: 0px; color: ' . $bgcolor3 . '; }
.Forum_nav_t a:hover{ color: ' . $forumcolor1 . '; }
.Forum_nav_r{}
.Forum_nav_d1{ vertical-align: bottom; padding-left: 4px; }
.Forum_nav_d2{ text-align: right; vertical-align: bottom; padding-right: 8px; }

/*** Div du contenu haut ***/
.Forum_cadre_haut{}

/*** Div du contenu bas ***/
.Forum_cadre_bas{}

/*** Cadre des membre connectés haut ***/
.Forum_online_t{ width: 100%; background: ' . $forumcolor3 . ' url("modules/Forum/Skin/' . $nuked['forum_skin'] . '/images/template/headerbar.gif"); background-repeat: repeat-x; border-radius: 10px 10px 0 0; margin-top: 35px; }
.Forum_online_r{ height: 23px; color: ' . $forumcolor4 . '; }
.Forum_online_d{ padding-left: 5px; }

/*** Cadre des membre connectés centre ***/
.Forum_online_centre_t{ width: 100%; background: ' . $forumcolor3 . ' url("modules/Forum/Skin/' . $nuked['forum_skin'] . '/images/template/headerbar.gif"); }
.Forum_online_centre_r{ height: 30px; background: ' . $forumcolor2 . ' none repeat-x 0 0; }
.Forum_online_centre_r a:hover{ color: ' . $forumcolor1 . '; }
.Forum_online_centre_d1{ text-align: center; }
.Forum_online_centre_d2{ padding-left: 5px; }
.Forum_online_centre_d3{ padding-left: 5px; }

/*** Cadre des membre connectés bas ***/
.Forum_online_bas_t{ width: 100%; background: ' . $forumcolor3 . ' url("modules/Forum/Skin/' . $nuked['forum_skin'] . '/images/template/headerbar.gif"); background-repeat: repeat-x; border-radius: 0 0 10px 10px; }
.Forum_online_bas_r{ height: 22px; }
.Forum_online_bas_d{ text-align: right; padding-right: 5px; }

</style>';
?>