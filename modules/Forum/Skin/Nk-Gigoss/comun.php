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
.Forum_search_t{ border-collapse: collapse; font: bold 10px Tahoma; color: ' . $forumcolor1 . ';}
.Forum_search_t a{ border-collapse: collapse; font: bold 10px Tahoma; color: ' . $forumcolor1 . ';}
.Forum_search_t a:hover{ color: ' . $forumcolor2 . '; }
.Forum_search_r{ background: url("modules/Forum/Skin/' . $nuked['forum_skin'] . '/images/template/top_bg.jpg") repeat-x scroll 0 0 transparent; height: 106px; vertical-align: middle; }
.Forum_search_d1{ text-align: center; width: 50%; }
.Forum_search_d2{ text-align: center;}

/*** Cadre de navigation ***/
.Forum_nav_t{ font: bold 10px Tahoma; color: ' . $forumcolor1 . '; width: 100%; border-collapse: collapse;}
.Forum_nav_t a{ font: bold 10px Tahoma; color: ' . $forumcolor1 . ';}
.Forum_nav_t a:hover{ color: ' . $forumcolor2 . '; }
.Forum_nav_r{ background: url("modules/Forum/Skin/' . $nuked['forum_skin'] . '/images/template/mbg.jpg") repeat-x scroll 0 0 transparent; height: 45px; vertical-align: middle; }
.Forum_nav_d1{ padding-left: 5px;}
.Forum_nav_d2{ text-align: right; padding-right: 5px;}

/*** Div du contenu haut ***/
.Forum_cadre_haut { font: bold 10px Tahoma; color: ' . $forumcolor1 . ';  }
.Forum_cadre_haut a { font: bold 10px Tahoma; color: ' . $forumcolor1 . ';  }
.Forum_cadre_haut a;hover { color: ' . $forumcolor2 . '; }

/*** Div du contenu bas ***/
.Forum_cadre_bas { font: bold 10px Tahoma; color: ' . $forumcolor1 . ';  }
.Forum_cadre_bas a { font: bold 10px Tahoma; color: ' . $forumcolor1 . ';  }
.Forum_cadre_bas a;hover { color: ' . $forumcolor2 . '; }

/*** Cadre des membre connectés haut ***/
.Forum_online_t{ width: 100%; background: url("modules/Forum/Skin/' . $nuked['forum_skin'] . '/images/template/mbgb.jpg") repeat-x scroll 0 0 transparent; vertical-align: middle; }
.Forum_online_r{ height: 23px; color: ' . $forumcolor3 . '; }
.Forum_online_d{ padding-left: 5px; }

/*** Cadre des membre connectés centre ***/
.Forum_online_centre_t{ width: 100%; background: none repeat scroll 0 0 ' . $forumcolor4 . '; margin-top: -2px; }
.Forum_online_centre_r{ height: 30px; background: none repeat scroll 0 0 ' . $forumcolor3 . '; }
.Forum_online_centre_d1{ text-align: center; }
.Forum_online_centre_d2{ padding-left: 5px; }
.Forum_online_centre_d3{ padding-left: 5px; }

/*** Cadre des membre connectés bas ***/
.Forum_online_bas_t{ display: none; }
.Forum_online_bas_r{}
.Forum_online_bas_d{ text-align: right;	padding-right: 5px;}

</style>';
?>