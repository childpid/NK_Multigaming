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

global $nuked, $user, $language, $cookie_forum;

translate("modules/Forum/lang/" . $language . ".lang.php");
define('FORUM_PRIMAIRE_TABLE', $nuked['prefix'] . '_forums_primaire');
include("modules/Forum/template.php");

opentable();

/****** Récupération du skin ******/
$nuked['forum_skin'] = $nuked['forum_skin'];
include('modules/Forum/Skin/' . $nuked['forum_skin'] . '/comun.php');
include('modules/Forum/Skin/' . $nuked['forum_skin'] . '/viewforum.php');

if (!$user)
{
    $visiteur = 0;
}
else
{
    $visiteur = $user[1];
}
$ModName = basename(dirname(__FILE__));
$level_access = nivo_mod($ModName);
if ($visiteur >= $level_access && $level_access > -1)
{
    $nb_mess_for = $nuked['thread_forum_page'];

    if ($_REQUEST['date_max'] != "")
    {
        $date_jour = time();
        $date_select = $date_jour - $_REQUEST['date_max'];
    }

    if ($_REQUEST['date_max'] != "")
    {
        $sql2 = mysql_query("SELECT forum_id FROM " . FORUM_THREADS_TABLE . " WHERE forum_id = '" . $_REQUEST['forum_id'] . "' AND date > '" . $date_select . "' ORDER BY last_post DESC");
    }
    else
    {
        $sql2 = mysql_query("SELECT forum_id FROM " . FORUM_THREADS_TABLE . " WHERE forum_id = '" . $_REQUEST['forum_id'] . "' ORDER BY last_post DESC");
    }
	
	
if ($nuked['forum_title'] != "")
{
    $title = "Forums " . $nuked['forum_title'];
} 
else
{
    $title = "Forums " . $nuked['name'];
} 

    $count = mysql_num_rows($sql2);

    $p = !$_GET['p']?1:$_GET['p'];
    $start = $p * $nb_mess_for - $nb_mess_for;

    $sql = mysql_query("SELECT nom, moderateurs, cat, level FROM " . FORUM_TABLE . " WHERE '" . $visiteur . "' >= niveau AND id = '" . $_REQUEST['forum_id'] . "'");
    $level_ok = mysql_num_rows($sql);

    if ($level_ok == 0)
    {
        echo "<br /><br /><div style=\"text-align: center;\">" . _NOACCESSFORUM . "</div><br /><br />";
    }
    else
    {
        list($nom, $modos, $cat, $level) = mysql_fetch_array($sql);
        $nom = printSecuTags($nom);

 		$sql_cat = mysql_query("SELECT nom, cat_primaire  FROM " . FORUM_CAT_TABLE . " WHERE id = '" . $cat . "'");
		list($cat_name, $catprimaire) = mysql_fetch_row($sql_cat);
		$cat_name = printSecuTags($cat_name); 
		$catprimaire = printSecuTags($catprimaire); 
		
		$sql_cats = mysql_query("SELECT id, nom FROM " . FORUM_PRIMAIRE_TABLE . " WHERE id = '" . $catprimaire . "'");
		list($cat_pri, $cat_primaire) = mysql_fetch_row($sql_cats);
		$cat_primaire = printSecuTags($cat_primaire); 
	 

		if ($modos != "")
		{
			$moderateurs = explode('|', $modos);
			for ($i = 0;$i < count($moderateurs);$i++)
			{
				if ($i > 0) $sep = ",&nbsp;";
				$sql2 = mysql_query("SELECT pseudo FROM " . USER_TABLE . " WHERE id = '" . $moderateurs[$i] . "'");
				list($modo_pseudo) = mysql_fetch_row($sql2);
				$modo .= $sep . $modo_pseudo;
			}
			$lienmodo = "<a href=\"index.php?file=Members&op=detail&autor=" . $modo . "\" alt=\"" . _SEEMODO . "" . $modo . "\" title=\"" . _SEEMODO . "" . $modo . "\">" . $modo . "</a>";
		}
		else
		{
			$modo = _NONE;
			$lienmodo = $modo;
		}

		if ($user && $modos != "" && strpos($user[0], $modos))
		{
			$administrator = 1;
		}
		else
		{
			$administrator = 0;
		}	
		
		$nav = "&nbsp;<img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/fleche.png\" alt=\"\" style=\"margin-bottom:-2px;\"/>&nbsp;<a href=\"index.php?file=Forum&amp;cat=" . $cat_pri . "\"><b>" . $cat_primaire . "</b></a>&nbsp;<img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/fleche.png\" alt=\"\" style=\"margin-bottom:-2px;\"/>&nbsp;<a href=\"index.php?file=Forum&amp;page=main&amp;cat=" . $cat . "\"><b>" . $cat_name . "</b></a>&nbsp;<img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/fleche.png\" alt=\"\" style=\"margin-bottom:-2px;\"/>&nbsp;<b>" . $nom . "</b>";

if($nuked['forum_name_viewforum'] == "oui" || $nuked['forum_search_viewforum'] == "oui")	
{
echo"		<form method=\"get\" action=\"index.php\">\n"
		. "	<table class=\"Forum_search_t\" width=\"100%\" cellspacing=\"0\">\n"
		. "		<tr class=\"Forum_search_r\">\n";
		
		if($nuked['forum_name_viewforum'] == "oui")	
		{
		echo "		<td class=\"Forum_search_d1\"><big><b>" . $title . "</b></big><br />" . $nom . "</td>\n";
		}
		
		if($nuked['forum_search_viewforum'] == "oui")	
		{
		echo "			<td class=\"Forum_search_d2\"><br /><b>" . _SEARCH . " :</b>\n"
		. "				<input type=\"text\" name=\"query\" size=\"25\" /><br />\n"
		. "				[ <a href=\"index.php?file=Forum&amp;page=search\">" . _ADVANCEDSEARCH . "</a> ]&nbsp;\n"
		. "				<input type=\"hidden\" name=\"file\" value=\"Forum\" />\n"
		. "				<input type=\"hidden\" name=\"page\" value=\"search\" />\n"
		. "				<input type=\"hidden\" name=\"do\" value=\"search\" />\n"
		. "				<input type=\"hidden\" name=\"into\" value=\"all\" />\n"
		. "			</td>\n";
		}
		
		echo "		</tr>\n"
		. "	</table>\n"
		. "	</form>\n";	
}		
echo"		<table class=\"Forum_nav_t\" cellspacing=\"4\" border=\"0\">\n";

				if ($count > $nb_mess_for)
				{		
					echo"<tr class=\"Forum_prevnext_r\">\n"
						. "	<td class=\"Forum_prevnext_d\">\n";
							  $url_page = "index.php?file=Forum&amp;page=viewforum&amp;forum_id=" . $_REQUEST['forum_id'] . "&amp;date_max=" . $_REQUEST['date_max'];
							  number($count, $nb_mess_for, $url_page);
					echo "	</td>\n"
						. "</tr>\n";
				}
				
echo "			<tr class=\"Forum_nav_r\">\n"
		. "			<td class=\"Forum_nav_d1\"><img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/home.png\" alt=\"\" style=\"margin-bottom:-1px;\"/>&nbsp;<a href=\"index.php?file=Forum\"><b>" . _INDEXFORUM . "</b></a>" . $nav . "</td>\n"
		. "			<td class=\"Forum_nav_d2\">\n";
		
						if ($level == 0 || $user[1] >= $level || $administrator == 1)
						{
							echo "&nbsp;<a href=\"index.php?file=Forum&amp;page=post&amp;forum_id=" . $_REQUEST['forum_id'] . "\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/buttons/" . $language . "/newthread.png\" alt=\"\" title=\"" . _NEWSTOPIC . "\" /></a>";
						}
		
echo "				</td>\n"
		. "		</tr>\n"
		. "	</table>\n";

echo"<div class=\"Forum_cadre_haut\">\n";

echo "		<table class=\"Forum_haut_for_t\" cellspacing=\"1\">\n"
		. "		<tr class=\"Forum_haut_for_r\">\n"
		. "			<td class=\"Forum_haut_for_d1\">&nbsp;</td>\n"
		. "			<td class=\"Forum_haut_for_d2\"><b>" . _SUBJECTS . "</b></td>\n"
        . "			<td class=\"Forum_haut_for_d3\"><b>" . _AUTHOR . "</b></td>\n"
		. "			<td class=\"Forum_haut_for_d4\"><b>" . _ANSWERS . "</b></td>\n"
		. "			<td class=\"Forum_haut_for_d5\"><b>" . _VIEWS . "</b></td>\n"
        . "			<td class=\"Forum_haut_for_d6\"><b>" . _LASTPOST . "</b></td>\n"
		. "		</tr>\n"
		. "	</table>\n";			
				
echo "		<table class=\"Forum_contenu_for_t\" cellspacing=\"1\">\n";

        if ($count == 0)
        {
            echo "	<tr class=\"Forum_contenu_for_r2\">\n"
				. "		<td class=\"Forum_contenu_for_error\" colspan=\"6\">" . _NOPOSTFORUM . "</td>\n"
				. "	</tr>\n";
        }

						if ($_REQUEST['date_max'] != "")
						{
							$sql3 = mysql_query("SELECT id, titre, auteur, view, closed, annonce, sondage FROM " . FORUM_THREADS_TABLE . " WHERE forum_id = '" . $_REQUEST['forum_id'] . "' AND date > '" . $date_select . "' ORDER BY annonce DESC, last_post DESC LIMIT " . $start . ", " . $nb_mess_for."");
						}
						else
						{
							$sql3 = mysql_query("SELECT id, titre, auteur, auteur_id, view, closed, annonce, sondage FROM " . FORUM_THREADS_TABLE . " WHERE forum_id = '" . $_REQUEST['forum_id'] . "' ORDER BY annonce DESC, last_post DESC LIMIT " . $start . ", " . $nb_mess_for."");
						}

						while (list($thread_id, $titre, $auteur, $auteur_id, $nb_read, $closed, $annonce, $sondage) = mysql_fetch_row($sql3))
						{
							$sql8 = mysql_query("SELECT txt FROM " . FORUM_MESSAGES_TABLE . " WHERE thread_id = '" . $thread_id . "' ORDER BY id LIMIT 0, 1");
							list($txt) = mysql_fetch_array($sql8);

							$auteur = nk_CSS($auteur);

							$txt = str_replace("\r", "", $txt);
							$txt = str_replace("\n", " ", $txt);

							$texte = strip_tags($txt);

							if (!preg_match("`[a-zA-Z0-9\?\.]`i", $texte))
							{
								$texte = _NOTEXTRESUME;
							}

							if (strlen($texte) > 150)
							{
								$texte = substr($texte, 0, 150) . "...";
							}

							$texte = htmlentities($texte);
							$texte = nk_CSS($texte);

							$title = htmlentities(printSecuTags($titre));

							if (strlen($titre) > 30)
							{
								$titre_topic = "<a href=\"index.php?file=Forum&amp;page=viewtopic&amp;forum_id=" . $_REQUEST['forum_id'] . "&amp;thread_id=" . $thread_id . "\" onmouseover=\"AffBulle('" . mysql_real_escape_string(stripslashes($title)) . "', '" . mysql_real_escape_string(stripslashes($texte)) . "', 400)\" onmouseout=\"HideBulle()\"><b>" . printSecuTags(substr($titre, 0, 30)) . "...</b></a>";
							}
							else
							{
								$titre_topic = "<a href=\"index.php?file=Forum&amp;page=viewtopic&amp;forum_id=" . $_REQUEST['forum_id'] . "&amp;thread_id=" . $thread_id . "\" onmouseover=\"AffBulle('" . mysql_real_escape_string(stripslashes($title)) . "', '" . mysql_real_escape_string(stripslashes($texte)) . "', 400)\" onmouseout=\"HideBulle()\"><b>" . printSecuTags($titre) . "</b></a>";
							}

							$sql4 = mysql_query("SELECT file FROM " . FORUM_MESSAGES_TABLE . " WHERE thread_id = '" . $thread_id . "'");
							$nb_rep = mysql_num_rows($sql4) - 1;

							$fichier_joint = 0;
							while (list($url_file) = mysql_fetch_row($sql4))
							{
								if ($url_file != "") $fichier_joint++;
							}

							$sql6 = mysql_query("SELECT MAX(id) FROM " . FORUM_MESSAGES_TABLE . " WHERE thread_id = '" . $thread_id . "'");
							$idmax = mysql_result($sql6, 0, "MAX(id)");

							$sql7 = mysql_query("SELECT id, date, auteur, auteur_id FROM " . FORUM_MESSAGES_TABLE . " WHERE id = '" . $idmax . "'");
							list($mess_id, $last_date, $last_auteur, $last_auteur_id) = mysql_fetch_array($sql7);
							$last_auteur = nk_CSS($last_auteur);
							
							if ($user) {
								$visitx = mysql_query("SELECT user_id FROM " . FORUM_READ_TABLE . " WHERE user_id = '" . $user[0] . "' AND `thread_id` LIKE '%" . ',' . $thread_id . ',' . "%' ");
								$results = mysql_num_rows($visitx);
								$user_visitx = $results;
							} else {
								$user_visitx = 0;
							}
							
							if ($user && $closed == 1 && ($user_visitx == 0))
							{
								$img = "<img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/folder_new_lock.png\" alt=\"\" />";
							}
							else if ($closed == 1)
							{
								$img = "<img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/folder_lock.png\" alt=\"\" />";
							}
							else if ($user && $nb_rep >= $nuked['hot_topic'] && ($user_visitx == 0))
							{
								$img = "<img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/folder_new_hot.png\" alt=\"\" />";
							}
							else if ($user && ($user_visitx >= 0) && $nb_rep >= $nuked['hot_topic'])
							{
								$img = "<img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/folder_hot.png\" alt=\"\" />";
							}
							else if ($user && ($user_visitx == 0) && $nb_rep < $nuked['hot_topic'])
							{
								$img = "<img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/folder_new.png\" alt=\"\" />";
							}
							else
							{
								$img = "<img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/folder.png\" alt=\"\" />";
							}

							if ($annonce == 1)
							{
								$a_img = "<img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/announce.png\" alt=\"\" title=\"" . _ANNOUNCE . "\" />&nbsp;";
							}
							else
							{
								$a_img = "";
							}

							if ($sondage == 1)
							{
								$s_img = "<img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/poll.png\" alt=\"\" title=\"" . _SURVEY . "\" />&nbsp;";
							}
							else
							{
								$s_img = "";
							}

							if ($fichier_joint > 0)
							{
								$f_img = "<img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/clip.png\" alt=\"\" title=\"" . _ATTACHFILE . " (" . $fichier_joint . ")\" />&nbsp;";
							}
							else
							{
								$f_img = "";
							}

							$title = $a_img . $s_img . $f_img . $titre_topic;

							$posts = $nb_rep + 1;
							if ($posts > $nuked['mess_forum_page'])
							{
								$topicpages = $posts / $nuked['mess_forum_page'];
								$topicpages = ceil($topicpages);

								$link_post = "index.php?file=Forum&amp;page=viewtopic&amp;forum_id=" . $_REQUEST['forum_id'] . "&amp;thread_id=" . $thread_id . "&amp;p=" . $topicpages . "#" . $mess_id;

								for ($l = 1; $l <= $topicpages; $l++)
								{
									$pagelinks .= " <a href=\"index.php?file=Forum&amp;page=viewtopic&amp;forum_id=" . $_REQUEST['forum_id'] . "&amp;thread_id=" . $thread_id . "&amp;p=" . $l . "\">" . $l . "</a>";
								}

								$multipage2 = "<small>( " . _PAGES . ": " . $pagelinks . " )</small>";
								$pagelinks = "";
							}
							else
							{
								$multipage2 = "";
								$link_post = "index.php?file=Forum&amp;page=viewtopic&amp;forum_id=" . $_REQUEST['forum_id'] . "&amp;thread_id=" . $thread_id . "#" . $mess_id;
							}

							if ($auteur_id != "")
							{
								$sql5 = mysql_query("SELECT pseudo, country, rang FROM " . USER_TABLE . " WHERE id = '" . $auteur_id . "'");
								$test = mysql_num_rows($sql5);
								list($autor, $country, $autor_rank) = mysql_fetch_array($sql5);

                if ($nuked['profil_details'] == "on")
                {
                  $sql_rank_team_autor = mysql_query("SELECT couleur FROM " . TEAM_RANK_TABLE . " WHERE id = '" . $autor_rank . "'");
                  list($thecolor) = mysql_fetch_array($sql_rank_team_autor);
                  $rank_color_autor = "style=\"color: #" . $thecolor . ";\"";
                } else {$rank_color_autor = "";} 

								if ($test > 0 && $autor != "")
								{
									$initiat = "<a href=\"index.php?file=Members&amp;op=detail&amp;autor=" . urlencode($autor) . "\" " . $rank_color_autor . "><b>" . $autor . "</b></a>";
								}
								else
								{
									$initiat = "<b>" . $auteur . "</b>";
								}
							}
							else
							{
								$initiat = "<b>" . $auteur . "</b>";
							}
						
echo "				<tr class=\"Forum_contenu_for_r\">\n"
	. "					<td class=\"Forum_contenu_for_d1\">" . $img . "</td>\n"
	. "					<td class=\"Forum_contenu_for_d2\">" . $title . $multipage2 . "</td>\n"
    . "					<td class=\"Forum_contenu_for_d3\">" . $initiat . "</td>\n"
    . "					<td class=\"Forum_contenu_for_d4\">" . $nb_rep . "</td>\n"
    . "					<td class=\"Forum_contenu_for_d5\">" . $nb_read . "</td>\n"
	. "					<td class=\"Forum_contenu_for_d6\">\n";
												
							if (strftime("%d %m %Y", time()) ==  strftime("%d %m %Y", $last_date)) $last_date = _FTODAY . "&nbsp;" . strftime("%H:%M", $last_date);
							else if (strftime("%d", $last_date) == (strftime("%d", time()) - 1) && strftime("%m %Y", time()) == strftime("%m %Y", $last_date)) $last_date = _FYESTERDAY . "&nbsp;" . strftime("%H:%M", $last_date);
							else $last_date = _THE . "&nbsp;" . nkDate($last_date); 

							echo $last_date . "<br />";
							
							if ($last_auteur_id != "")
							{
								$sql8 = mysql_query("SELECT pseudo, country, rang FROM " . USER_TABLE . " WHERE id = '" . $last_auteur_id . "'");
								$test1 = mysql_num_rows($sql8);
								list($last_autor, $last_country, $last_autor_rank) = mysql_fetch_array($sql8);

                if ($nuked['profil_details'] == "on")
                 {
                  $sql_lastrank_team_autor = mysql_query("SELECT couleur FROM " . TEAM_RANK_TABLE . " WHERE id = '" . $autor_rank . "'");
                  list($thecolorlast) = mysql_fetch_array($sql_lastrank_team_autor);
                  $lastrank_color_autor = "style=\"color: #" . $thecolorlast . ";\"";
                } else {$lastrank_color_autor = "";}

								if ($test1 > 0 && $last_autor != "")
								{
									echo _BY . "&nbsp;<a href=\"index.php?file=Members&amp;op=detail&amp;autor=" . $last_autor . "\" " . $lastrank_color_autor . "><b>" . $last_autor . "</b></a>";
								}
								else
								{
									echo _BY . "&nbsp;<b>" . $last_auteur . "</b>";
								}
							}
							else
							{
								echo _BY . "&nbsp;<b>" . $last_auteur . "</b>";
							}

echo "						&nbsp;<a href=\"" . $link_post . "\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/icon_latest_reply.png\" alt=\"\" title=\"" . _SEELASTPOST . "\" /></a>\n"
	. "					</td>\n"
	. "				</tr>\n";
						}

echo "		</table>\n";

echo "	<table class=\"Forum_bas_for_t\">\n"
	. "		<tr class=\"Forum_bas_for_r\">\n"
	. "			<td class=\"Forum_bas_for_d\"></td>\n"
	. "		</tr>\n"
	. "	</table>\n";

echo"</div>";

echo "		<table class=\"Forum_markread_t\" cellspacing=\"1\">\n"
		. "			<tr class=\"Forum_markread_r\">\n"
		. "				<td class=\"Forum_markread_d\">";

								if ($user)
								{
									echo "<a href=\"index.php?file=Forum&amp;op=mark\">" . _MARKREAD . "</a>";
								} 
								if ($user && $user[4] != "")
								{
									echo "<br /><a href=\"index.php?file=Forum&amp;page=search&amp;do=search&amp;date_max=" . $user[4] . "\">" . _VIEWLASTVISITMESS . "</a>";
								} 

echo "			</td>\n"
		. "			</tr>\n"
		. "		</table>\n";
			
echo"		<table class=\"Forum_nav_t\" cellspacing=\"4\" border=\"0\">\n"
	. "		<tr class=\"Forum_nav_r\">\n";

				if ($count > $nb_mess_for)
				{		
					echo"<td class=\"Forum_prevnext_for_d\">\n";
							  $url_page = "index.php?file=Forum&amp;page=viewforum&amp;forum_id=" . $_REQUEST['forum_id'] . "&amp;date_max=" . $_REQUEST['date_max'];
							  number($count, $nb_mess_for, $url_page);
					echo "	</td>\n";
				}
				
echo "			<td class=\"Forum_nav_d2\">\n";
		
					if ($level == 0 || $user[1] >= $level || $administrator == 1)
					{
						echo "&nbsp;<a href=\"index.php?file=Forum&amp;page=post&amp;forum_id=" . $_REQUEST['forum_id'] . "\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/buttons/" . $language . "/newthread.png\" alt=\"\" title=\"" . _NEWSTOPIC . "\" /></a>";
					}
		
echo "			</td>\n"
	. "		</tr>\n"
	. "</table>\n";
			
echo"<div class=\"Forum_cadre_bas\">\n";

$nb = nbvisiteur();

    $sql_tmessage = mysql_query("SELECT id FROM " . FORUM_MESSAGES_TABLE . " ");
    $nb_tmessage = mysql_num_rows($sql_tmessage);
    
    $sql_tusers = mysql_query("SELECT id FROM " . USER_TABLE . " ");
    $nb_tusers = mysql_num_rows($sql_tusers);
    
    $sql_luser = mysql_query("SELECT pseudo FROM " . USER_TABLE . " ORDER BY date DESC LIMIT 1");
    list($last_user) = mysql_fetch_array($sql_luser);

if($nuked['forum_who_viewforum'] == "oui")	
{
echo "	<table class=\"Forum_online_t\" cellspacing=\"0\">\n"
	. "		<tr class=\"Forum_online_r\">\n"
	. "			<td class=\"Forum_online_d\" colspan=\"5\"><b>" . _FWHOISONLINE . "</b></td>\n"
	. "		</tr>\n"
	. "	</table>\n";

echo "	<table class=\"Forum_online_centre_t\" cellspacing=\"1\">\n"
	. "		<tr class=\"Forum_online_centre_r\">\n"
	. "			<td class=\"Forum_online_centre_d1\"><img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/whoisonline.png\" alt=\"\" /></td>\n"
	. "			<td class=\"Forum_online_centre_d2\">\n"
. "". _MEMBERTOTALMESSAGES ."&nbsp;<b>" . $nb_tmessage . "</b>&nbsp;" . _MESSAGES2 . ".<br />\n"
. "". _WEHAVE ."&nbsp;<b>" . $nb_tusers . "</b>&nbsp;" . _REGISTEREDUSERS . ".<br />\n"
. "". _LASTREGISTEREDUSER ."&nbsp;<a href=\"index.php?file=Members&amp;op=detail&amp;autor=" . $last_user . "\"><b>" . $last_user . "</b></a><br /><br />\n"

. "" . _THEREARE . "&nbsp;" . $nb[0] . "&nbsp;" . _FVISITORS . ", " . $nb[1] . "&nbsp;" . _FMEMBERS . "&nbsp;" . _AND . "&nbsp;" . $nb[2] . "&nbsp;" . _FADMINISTRATORS . "&nbsp;" . _ONLINE . "\n";

if ($nuked['profil_details'] == "on")
{   
  echo "<br />" . _RANKLEGEND . "&nbsp;:&nbsp;\n";

$sql_rank_team = mysql_query("SELECT titre, couleur FROM " . TEAM_RANK_TABLE . " ORDER BY ordre LIMIT 0, 20");
  while (list($rank_titre, $rank_color) = mysql_fetch_array($sql_rank_team))
  {	
      $rank_color1 = "style=\"color: #" . $rank_color . ";\"";
      echo "[&nbsp;<span " . $rank_color1 . "><b>" . $rank_titre . "</b></span>&nbsp;]&nbsp;";
  }    
}


echo "<br />" . _MEMBERSONLINE . " : ";

$i = 0;
$online = mysql_query("SELECT username FROM " . NBCONNECTE_TABLE . " WHERE type > 0 ORDER BY date");
while (list($name) = mysql_fetch_row($online))
{
    $i++;
    if ($i == $nb[3])
    {
        $sep = "";
    } 
    else
    {
        $sep = ", ";
    } 

$sql_user_details = mysql_query("SELECT pseudo, count, avatar, country FROM " . USER_TABLE . " WHERE pseudo = '" . $name . "'");
   
    while (list($pseudof, $userfcount, $avatar, $country) = mysql_fetch_array($sql_user_details))
    {
        echo "<img src=\"images/flags/". $country ."\" alt=\"" . $country ."\" style=\"margin-bottom:-2px;\" />\n";
  	}
        if ($nuked['profil_details'] == "on")
        {  	
              $sq_user1 = mysql_query("SELECT rang FROM " . USER_TABLE . " WHERE pseudo = '" . $name . "'");
              list($rang2) = mysql_fetch_array($sq_user1);
              $sql_rank_team = mysql_query("SELECT couleur FROM " . TEAM_RANK_TABLE . " WHERE id = '" . $rang2 . "'");
              list($lacouleur) = mysql_fetch_array($sql_rank_team);
              $rank_color = "style=\"color: #" . $lacouleur . ";\"";
        } else {$rank_color = "";}


    echo "<a href=\"index.php?file=Members&amp;op=detail&amp;autor=" . urlencode($name) . "\" " . $rank_color . ">" . $name . "</a>" . $sep;
}

if (mysql_num_rows($online) == NULL) echo '<em>' . _NONE . '</em>';

// Les anniversaires //
if ($nuked['birthday_forum'] == "on")
{
	  $y = date("Y");
	  $m = date("m");
	  $d = date("d");
	  
	  if ($d < 10){$d = str_replace("0", "", $d);}
	  if ($m < 10){$m = str_replace("0", "", $m);}
	  
	  $sqlaniv1 = mysql_query("SELECT age FROM " . USER_DETAIL_TABLE . " WHERE age LIKE '%$d/$m%'");
	  $nb_aniv = mysql_num_rows($sqlaniv1);
	  
		while (list($anivjourn) = mysql_fetch_array($sqlaniv1))
		{
			list ($journ, $moisn, $ann) =  split ('[/]', $anivjourn);
			if ($d != $journ || $m != $moisn)
			{		
			$nb_aniv = $nb_aniv - 1;
			}
		}	  
		echo "<br /><br />" . _TODAY . ", ";
		if ($nb_aniv == 0)
		echo "" . _BIRTHDAY1 . "";
		elseif ($nb_aniv == 1)
		echo "" . _BIRTHDAY2 . "";
		else
		echo "" . _THEREARE2 . " $nb_aniv " . _BIRTHDAY3 . "";
			$a = 0;
			$sqlaniv = mysql_query("SELECT user_id, age, pseudo, rang FROM " . USER_DETAIL_TABLE . " INNER JOIN " . USER_TABLE . " ON user_id = id WHERE niveau > 0 ");
			while (list($anivid, $anivjour, $anivpseudo, $rang2) = mysql_fetch_array($sqlaniv))
			{
			list ($jour, $mois, $an) = split ('[/]', $anivjour);
				$age = $y - $an;
				if ($m < $mois)
				{
					$age = $age - 1;
				} 
				if ($d < $jour && $m == $mois)
				{
					$age = $age - 1;
				} 

			if ($d == $jour && $m == $mois)
			{
			if ($lacouleur1) $rank_color1 = "style=\"color: #" . $lacouleur1 . ";\"";
			else $rank_color1 = "";
			$anivpseudo = stripslashes($anivpseudo);
			$a++;
			if ($a != $nb_aniv)
			{
			$virg = ", ";
			}
			else
			{
			$virg = " ";
			}
if ($nuked['profil_details'] == "on")
{					
			$sql_rank_team2 = mysql_query("SELECT couleur FROM " . TEAM_RANK_TABLE . " WHERE id = '" . $rang2 . "'");
			list($lacouleur2) = mysql_fetch_array($sql_rank_team2);
			if ($lacouleur2) $rank_color2 = "style=\"color: #" . $lacouleur2 . ";\"";
			else $rank_color2 = "";
} else {$rank_color2 = "";}			
		
			echo " <a href=\"index.php?file=Members&amp;op=detail&amp;autor=" . $anivpseudo . "\" " . $rank_color2 . "><b> " . $anivpseudo . "</b></a> (" . $age . " " . _ANS . ")" . $virg . "";
			}
		}
}		
// Fin anniversaire

echo "			</td>\n"
	. "			<td class=\"Forum_online_centre_d3\"><b>" . _MODO . " :</b>&nbsp;<small>" . $lienmodo . "</small></td>\n"
	. "		</tr>\n"
	. "	</table>\n";
		
				
			echo "	<table class=\"Forum_online_bas_t\">\n"
				. "		<tr class=\"Forum_online_bas_r\">\n"
				. "			<td class=\"Forum_online_bas_d\"></td>\n"
				. "		</tr>\n"
				. "	</table>\n";
}	
echo "	<table class=\"Forum_info_for_t\" cellspacing=\"0\">\n"
	. "		<tr class=\"Forum_info_for_r1\">\n"
	. "			<td class=\"Forum_info_for_d1\">&nbsp;<img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/folder_new.png\" alt=\"\" /></td>\n"
	. "			<td class=\"Forum_info_for_d2\">&nbsp;" . _POSTNEW . "</td>\n"
	. "			<td class=\"Forum_info_for_d3\">&nbsp;<img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/folder_lock.png\" alt=\"\" /></td>\n"
	. "			<td class=\"Forum_info_for_d4\">&nbsp;" . _SUBJECTCLOSE . "</td>\n"
	. "		</tr>\n"
	. "		<tr class=\"Forum_info_for_r2\">\n"
	. "			<td class=\"Forum_info_for_d5\">&nbsp;<img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/folder.png\" alt=\"\" /></td>\n"
	. "			<td class=\"Forum_info_for_d6\">&nbsp;" . _NOPOSTNEW . "</td>\n"
	. "			<td class=\"Forum_info_for_d7\">&nbsp;<img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/folder_new_hot.png\" alt=\"\" /></td>\n"
	. "			<td class=\"Forum_info_for_d8\">&nbsp;" . _POSTNEWHOT . "</td>\n"
	. "		</tr>\n"
	. "		<tr class=\"Forum_info_for_r3\">\n"
	. "			<td class=\"Forum_info_for_d9\">&nbsp;<img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/folder_new_lock.png\" alt=\"\" /></td>\n"
	. "			<td class=\"Forum_info_for_d10\">&nbsp;" . _POSTNEWCLOSE . "</td>\n"
	. "			<td class=\"Forum_info_for_d11\">&nbsp;<img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/folder_hot.png\" alt=\"\" /></td>\n"
	. "			<td class=\"Forum_info_for_d12\">&nbsp;" . _NOPOSTNEWHOT . "</td>\n"
	. "		</tr>\n"
	. "	</table>\n";

	

echo "	<table class=\"Forum_option_t\" cellspacing=\"0\">\n"
	. "		<tr class=\"Forum_option_r\">\n"
	. "			<td class=\"Forum_option_d1\">\n"
	. "				<form method=\"post\" action=\"index.php?file=Forum&amp;page=viewforum\">\n"
	. "				<div>" . _JUMPTO . " : <select name=\"forum_id\" onchange=\"submit();\">\n"
	. "				<option value=\"\">" . _SELECTFORUM . "</option>";

					$sql_forum = mysql_query("SELECT nom, id FROM " . FORUM_TABLE . " WHERE cat = '" . $cat . "' ORDER BY ordre, nom");
					while (list($forum_name, $fid) = mysql_fetch_row($sql_forum))
					{
						$forum_name = printSecuTags($forum_name);

						echo "<option value=\"" . $fid . "\">" . $forum_name . "</option>\n";
					}

echo "				</select></div></form></td>\n"
	. "			<td class=\"Forum_option_d2\">\n"
	. "				<form method=\"post\" action=\"index.php?file=Forum&amp;page=viewforum&amp;forum_id=" . $_REQUEST['forum_id'] . "\">\n"
	. "				<div>&nbsp;&nbsp;" . _SEETHETOPIC . " : <select name=\"date_max\" onchange=\"submit();\">\n"
	. "				<option>" . _THEFIRST . "</option>\n"
	. "				<option value=\"86400\">" . _ONEDAY . "</option>\n"
	. "				<option value=\"604800\">" . _ONEWEEK . "</option>\n"
	. "				<option value=\"2592000\">" . _ONEMONTH . "</option>\n"
	. "				<option value=\"15552000\">" . _SIXMONTH . "</option>\n"
	. "				<option value=\"31104000\">" . _ONEYEAR . "</option></select></div>\n"
	. "				</form>\n"
	. "			</td>\n"
	. "		</tr>\n"
	. "	</table>\n";
    }
echo"</div>";
}
else if ($level_access == -1)
{
    echo "<br /><br /><div style=\"text-align: center;\">" . _MODULEOFF . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />";
}
else if ($level_access == 1 && $visiteur == 0)
{
    echo "<br /><br /><div style=\"text-align: center;\">" . _USERENTRANCE . "<br /><br /><b><a href=\"index.php?file=User&amp;op=login_screen\">" . _LOGINUSER . "</a> | <a href=\"index.php?file=User&amp;op=reg_screen\">" . _REGISTERUSER . "</a></b></div><br /><br />";
}
else
{
    echo "<br /><br /><div style=\"text-align: center;\">" . _NOENTRANCE . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />";
}

closetable();

?>
