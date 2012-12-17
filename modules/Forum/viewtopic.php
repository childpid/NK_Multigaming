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

global $nuked, $user, $language, $theme;

translate("modules/Forum/lang/" . $language . ".lang.php");
define('FORUM_PRIMAIRE_TABLE', $nuked['prefix'] . '_forums_primaire');
include("modules/Forum/template.php");

opentable();

/****** Récupération du skin ******/
$nuked['forum_skin'] = $nuked['forum_skin'];
include('modules/Forum/Skin/' . $nuked['forum_skin'] . '/comun.php');
include('modules/Forum/Skin/' . $nuked['forum_skin'] . '/viewtopic.php');

if ($nuked['forum_title'] != "")
{
    $title = "Forums " . $nuked['forum_title'];
	$title2 = $nuked['forum_desc'];
} 
else
{
    $title = "Forums " . $nuked['name'];
	$title2 = $nuked['slogan'];
} 

$visiteur = $user ? $user[1] : 0;

$ModName = basename(dirname(__FILE__));
$level_access = nivo_mod($ModName);
if ($visiteur >= $level_access && $level_access > -1)
{
		$nb_mess_for_mess = $nuked['mess_forum_page'];

		$sql = mysql_query("SELECT nom, moderateurs, cat, level FROM " . FORUM_TABLE . " WHERE '" . $visiteur . "' >= niveau AND id = '" . $_REQUEST['forum_id'] . "'");
		$level_ok = mysql_num_rows($sql);

		$sql2 = mysql_query("SELECT titre, view, closed, annonce, last_post, auteur_id, sondage FROM " . FORUM_THREADS_TABLE . " WHERE forum_id = '" . $_REQUEST['forum_id'] . "' AND id = '" . $_REQUEST['thread_id'] . "'");
		$topic_ok = mysql_num_rows($sql2);

		 // No user access
		 if ($level_ok == 0) {
			  echo "<br /><br /><div style=\"text-align: center;\">" . _NOACCESSFORUM . "</div><br /><br />";
		 }
		 // No topic exists
		 else if ($topic_ok == 0) {
			  echo "<br /><br /><div style=\"text-align: center;\">" . _NOTOPICEXIST . "</div><br /><br />";
		 }
		 // User access
		 else 
		{

			if ($user) {

				$SQL = "SELECT id FROM " . FORUM_THREADS_TABLE . " WHERE forum_id = " . (int) $_GET['forum_id'] . " ";
				$req = mysql_query($SQL) or die(mysql_error());
				$thread_table = array();
				while ($res = mysql_fetch_assoc($req)) {
				   $thread_table[] = $res['id'];
				} 

				$visit = mysql_query("SELECT user_id, thread_id, forum_id FROM " . FORUM_READ_TABLE . " WHERE user_id = '" . $user[0] . "'") or die(mysql_error());
				$user_visit = mysql_fetch_assoc($visit);
				$tid = substr($user_visit['thread_id'], 1); // Thread ID
				$fid = substr($user_visit['forum_id'], 1); // Forum ID
				if (!$user_visit || strrpos($user_visit['thread_id'], ',' . $_GET['thread_id'] . ',') === false || strrpos($user_visit['forum_id'], ',' . $_GET['forum_id'] . ',') === false) 
				{

					if (strrpos($user_visit['thread_id'], ',' . $_GET['thread_id'] . ',') === false)
						$tid .= $_GET['thread_id'] . ',';
						$read = false;
						foreach ($thread_table as $thread) {
							 if (strrpos(',' . $tid, ',' . $thread . ',') === false){
								  $read = true;
							}
						} 

						if (strrpos($user_visit['forum_id'], ',' . $_GET['forum_id'] . ',') === false && $read === false)
							 $fid .= $_GET['forum_id'] . ',';

						// Insertion SQL du read
						mysql_query("REPLACE INTO " . FORUM_READ_TABLE . " ( `user_id` , `thread_id` , `forum_id` ) VALUES ( '" . $user[0] . "' , '," . $tid . "' , '," . $fid . "' )") or die(mysql_error());
				} 
			}

			list($nom, $modos, $cat, $level) = mysql_fetch_array($sql);
			$nom = printSecuTags($nom);

			$sql_cat = mysql_query("SELECT nom, cat_primaire FROM " . FORUM_CAT_TABLE . " WHERE id = '" . $cat . "'");
			list($cat_name, $catprimaire) = mysql_fetch_array($sql_cat);
			$cat_name = printSecuTags($cat_name);
			
			$sql_cats = mysql_query("SELECT id, nom FROM " . FORUM_PRIMAIRE_TABLE . " WHERE id = '" . $catprimaire . "'");
			list($cat_pri, $cat_primaire) = mysql_fetch_row($sql_cats);
			$cat_primaire = printSecuTags($cat_primaire); 

			if ($user && $modos != "" && strpos($modos, $user[0]) !== false)
			{
				$administrator = 1;
			} 
			else
			{
				$administrator = 0;
			} 

			list($titre, $read, $closed, $annonce, $lastpost, $topic_aid, $sondage) = mysql_fetch_array($sql2);
			$titre = printSecuTags($titre);
			$titre = nk_CSS($titre);

			$upd = mysql_query("UPDATE " . FORUM_THREADS_TABLE . " SET view = view + 1 WHERE forum_id = '" . $_REQUEST['forum_id'] . "' AND id = '" . $_REQUEST['thread_id'] . "'");

			$sql_next = mysql_query("SELECT id FROM " . FORUM_THREADS_TABLE . " WHERE last_post > '" . $lastpost. "' AND forum_id = '" . $_REQUEST['forum_id'] . "' ORDER BY last_post LIMIT 0, 1");
			list($nextid) = mysql_fetch_array($sql_next);

			if ($nextid != "")
			{
				$next = "<small><a href=\"index.php?file=Forum&amp;page=viewtopic&amp;forum_id=" . $_REQUEST['forum_id'] . "&amp;thread_id=" . $nextid . "\">" . _NEXTTHREAD . "</a> &gt;</small>";
			} 

			$sql_last = mysql_query("SELECT id FROM " . FORUM_THREADS_TABLE . " WHERE last_post < '" . $lastpost . "' AND forum_id = '" . $_REQUEST['forum_id'] . "' ORDER BY last_post DESC LIMIT 0, 1");
			list($lastid) = mysql_fetch_array($sql_last);

			if ($lastid != "")
			{
				$prev = "<small>&lt; <a href=\"index.php?file=Forum&amp;page=viewtopic&amp;forum_id=" . $_REQUEST['forum_id'] . "&amp;thread_id=" . $lastid . "\">" . _LASTTHREAD . "</a>&nbsp;</small>";
			} 
			
			$sql3 = mysql_query("SELECT thread_id FROM " . FORUM_MESSAGES_TABLE . " WHERE thread_id = '" . $_REQUEST['thread_id'] . "'");
			$count = mysql_num_rows($sql3);

			if (!$_REQUEST['p']) $_REQUEST['p'] = 1;
			$start = $_REQUEST['p'] * $nb_mess_for_mess - $nb_mess_for_mess;		

			if ($_REQUEST['highlight'] != "")
			{
				$url_page = "index.php?file=Forum&amp;page=viewtopic&amp;forum_id=" . $_REQUEST['forum_id'] . "&amp;thread_id=" . $_REQUEST['thread_id'] . "&amp;highlight=" . urlencode($_REQUEST['highlight']);
			} 
			else
			{
				$url_page = "index.php?file=Forum&amp;page=viewtopic&amp;forum_id=" . $_REQUEST['forum_id'] . "&amp;thread_id=" . $_REQUEST['thread_id'];
			} 
			
			$nav = "&nbsp;<img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/fleche.png\" alt=\"\" style=\"margin-bottom:-2px;\"/>&nbsp;<a href=\"index.php?file=Forum&amp;cat=" . $cat_pri . "\"><b>" . $cat_primaire . "</b></a>&nbsp;<img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/fleche.png\" alt=\"\" style=\"margin-bottom:-2px;\"/>&nbsp;<a href=\"index.php?file=Forum&amp;cat=" . $cat . "\"><b>" . $cat_name . "</b></a>&nbsp;<img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/fleche.png\" alt=\"\" style=\"margin-bottom:-2px;\"/>&nbsp;<a href=\"index.php?file=Forum&amp;page=viewforum&amp;forum_id=" . $_REQUEST['forum_id'] . "\"><b>" . $nom . "</b></a>&nbsp;<img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/fleche.png\" alt=\"\" style=\"margin-bottom:-2px;\"/>&nbsp;<b>" . $titre . "</b>";

	if($nuked['forum_name_viewtopic'] == "oui" || $nuked['forum_search_viewtopic'] == "oui")	
	{
	echo"	<form method=\"get\" action=\"index.php\">\n"
		. "	<table class=\"Forum_search_t\" width=\"100%\" cellspacing=\"0\">\n"
		. "	<tr class=\"Forum_search_r\">\n";
			
			if($nuked['forum_name_viewtopic'] == "oui")	
			{
			echo "<td class=\"Forum_search_d1\"><big><b>" . $title . "</b></big><br />" . $titre . "</td>\n";
			}
			
			if($nuked['forum_search_viewtopic'] == "oui")	
			{
			echo "<td class=\"Forum_search_d2\"><br /><b>" . _SEARCH . " :</b>\n"
			. "	<input type=\"text\" name=\"query\" size=\"25\" /><br />\n"
			. "	[ <a href=\"index.php?file=Forum&amp;page=search\">" . _ADVANCEDSEARCH . "</a> ]&nbsp;\n"
			. "	<input type=\"hidden\" name=\"file\" value=\"Forum\" />\n"
			. "	<input type=\"hidden\" name=\"page\" value=\"search\" />\n"
			. "	<input type=\"hidden\" name=\"do\" value=\"search\" />\n"
			. "	<input type=\"hidden\" name=\"into\" value=\"all\" />\n"
			. "	</td>\n";
			}
			
	echo "</tr>\n"
		. "	</table>\n"
		. "	</form>\n";	
	}		
	echo "	<table class=\"Forum_prevnext_top_t\" cellspacing=\"0\">\n"
		. "	<tr class=\"Forum_prevnext_top_r\">\n"
		. "	<td class=\"Forum_prevnext_top_d1\">" . $prev . "</td>\n"
		. "	<td class=\"Forum_prevnext_top_d2\">" . $next . "</td>\n"
		. "	</tr>\n"
		. "	</table>\n"
		. "	<table class=\"Forum_nav_t\" cellspacing=\"4\" border=\"0\">\n";

					if ($count > $nb_mess_for_mess)
					{		
						echo"<tr class=\"Forum_prevnext_top_r\">\n"
							. "	<td class=\"Forum_prevnext_top_d1\">\n";
								  number($count, $nb_mess_for_mess, $url_page);
						echo "	</td>\n"
							. "</tr>\n";
					}
					
	echo "	<tr class=\"Forum_nav_r\">\n"
		. "	<td class=\"Forum_nav_d1\"><img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/home.png\" alt=\"\" style=\"margin-bottom:-1px;\"/>&nbsp;<a href=\"index.php?file=Forum\"><b>" . _INDEXFORUM . "</b></a>" . $nav . "</td>\n"
		. "	<td class=\"Forum_nav_d2\">\n";
			
							if ($level == 0 || $visiteur >= $level || $administrator == 1)
							{
								echo "&nbsp;<a href=\"index.php?file=Forum&amp;page=post&amp;forum_id=" . $_REQUEST['forum_id'] . "\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/buttons/" . $language . "/newthread.png\" alt=\"\" title=\"" . _NEWSTOPIC . "\" /></a>&nbsp;";

								if ($closed == 0 || $administrator == 1 || $visiteur >= admin_mod("Forum"))
								{
									echo "&nbsp;<a href=\"index.php?file=Forum&amp;page=post&amp;forum_id=" . $_REQUEST['forum_id'] . "&amp;thread_id=" . $_REQUEST['thread_id'] . "\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/buttons/" . $language . "/reply.png\" alt=\"\" title=\"" . _REPLY . "\" /></a>&nbsp;";
								} 
							} 
			
	echo "	</td>\n"
		. "	</tr>\n"
		. "	</table>\n"		
		. "<div class=\"Forum_cadre_haut\">\n"	
		. "<table class=\"Forum_haut_top_t\" cellspacing=\"1\">\n"
		. "<tr class=\"Forum_haut_top_r\">\n"
		. "<td class=\"Forum_haut_top_d1\">" . _AUTHOR . "</td>\n"
		. "<td id=\"Forum\" class=\"Forum_haut_top_d2\">" . _MESSAGE . "</td>\n"
		. "</table>\n"						
		. "<table class=\"Forum_contenu_top_t\" cellspacing=\"1\" id=\"img_resize_forum\">\n";
			
			if ($sondage == 1)
			{
				echo "	<tr class=\"Forum_sondage_r\">\n"
					. "	<td class=\"Forum_sondage_d\" colspan=\"2\">";

						$sql_poll = mysql_query("SELECT id, titre FROM " . FORUM_POLL_TABLE . " WHERE thread_id = '" . $_REQUEST['thread_id'] . "'");
						list($poll_id, $question) = mysql_fetch_array($sql_poll);
						$question = printSecuTags($question);

						if ($user && $topic_aid == $user[0] && $closed == 0 || $visiteur >= admin_mod("Forum") || $administrator == 1)
						{
							echo "<div style=\"text-align: right;\"><a href=\"index.php?file=Forum&amp;op=edit_poll&amp;poll_id=" . $poll_id . "&amp;forum_id=" . $_REQUEST['forum_id'] . "&amp;thread_id=" . $_REQUEST['thread_id'] . "\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/buttons/" . $language . "/edit.png\" alt=\"\" title=\"" . _EDITPOLL . "\" /></a>&nbsp;<a href=\"index.php?file=Forum&amp;op=del_poll&amp;poll_id=" . $poll_id . "&amp;forum_id=" . $_REQUEST['forum_id'] . "&amp;thread_id=" . $_REQUEST['thread_id'] . "\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/delete.png\" alt=\"\" title=\"" . _DELPOLL . "\" /></a>&nbsp;</div>\n";
						} 

						$check = mysql_query("SELECT auteur_ip FROM " . FORUM_VOTE_TABLE . " WHERE poll_id = '" . $poll_id . "' AND auteur_id = '" . $user[0] . "'");
						$test = mysql_num_rows($check);

						if ($user && $test > 0 || $_REQUEST['vote'] == "view")
						{
							echo "	<table class=\"Forum_sondage_Q_t\" cellspacing=\"2\">\n"
								. "	<tr class=\"Forum_sondage_Q_r1\">\n"
								. "	<td class=\"Forum_sondage_Q_d1\" colspan=\"2\"><b>" . $question . "</b></td>\n"
								. "	</tr>\n";

								$sql_options = mysql_query("SELECT option_vote FROM " . FORUM_OPTIONS_TABLE . " WHERE poll_id = '" . $poll_id . "' ORDER BY id ASC");
								$nbcount = 0;

								while (list($option_vote) = mysql_fetch_array($sql_options))
								{
									$nbcount = $nbcount + $option_vote;
								} 

								$sql_res = mysql_query("SELECT option_vote, option_text FROM " . FORUM_OPTIONS_TABLE . " WHERE poll_id = '" . $poll_id . "' ORDER BY id ASC");
								while (list($optioncount, $option_text) = mysql_fetch_array($sql_res))
								{
									$optiontext = printSecuTags($option_text);

									if ($nbcount <> 0)
									{
										$etat = ($optioncount * 100) / $nbcount ;
									} 
									else
									{
										$etat = 0;
									} 

									$pourcent_arrondi = round($etat);

									echo "	<tr class=\"Forum_sondage_Q_r2\">\n"
										. "	<td class=\"Forum_sondage_Q_d2\">" . $optiontext . "</td>\n"
										. "	<td class=\"Forum_sondage_Q_d3\">";

										if ($etat < 1)
										{
											$width = 2;
										} 
										else
										{
											$width = $etat * 2;
										} 

										if (is_file("themes/" . $theme . "/images/bar.png"))
										{
											$img = "themes/" . $theme . "/images/bar.png";
										} 
										else
										{
											$img = "modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/bar.png";
										} 

									echo "	<img src=\"" . $img . "\" width=\"" . $width . "\" height=\"10\" alt=\"\" title=\"" . $pourcent_arrondi . "%\" />&nbsp;" . $pourcent_arrondi . "% (" . $optioncount . ")\n"
										. "	</td>\n"
										. "	</tr>\n";
									} 
								echo "	<tr class=\"Forum_sondage_Q_r3\"></tr>\n"
									. "	<td class=\"Forum_sondage_Q_d4\" colspan=\"2\"><b>" . _TOTALVOTE . " : </b>" . $nbcount . "</td>\n"
									. "	</tr>\n"
									. "	</table>\n";
								} 
								else
								{
									echo "	<form  method=\"post\" action=\"index.php?file=Forum&amp;op=vote&amp;poll_id=" . $poll_id . "\">\n"
										. "	<table class=\"Forum_sondage_Q_t\" cellspacing=\"1\">\n"
										. "	<tr class=\"Forum_sondage_Q_r1\">\n"
										. "	<td class=\"Forum_sondage_Q_d1\"><b>" . $question . "</b></td>\n"
										. "	</tr>\n";

								$sql_options = mysql_query("SELECT id, option_text FROM " . FORUM_OPTIONS_TABLE . " WHERE poll_id = '" . $poll_id . "' ORDER BY id ASC");
								while (list($voteid, $optiontext) = mysql_fetch_array($sql_options))
								{
									$optiontext = printSecuTags($optiontext);

									echo "	<tr class=\"Forum_sondage_Q_r2\">\n"
										. "	<td class=\"Forum_sondage_Q_d2\"><input type=\"radio\" class=\"checkbox\" name=\"voteid\" value=\"" . $voteid . "\" />&nbsp;" . $optiontext . "</td>\n"
										. "	</tr>\n";
								} 

									echo "	<tr class=\"Forum_sondage_Q_r3\">\n"
										. "	<td class=\"Forum_sondage_Q_d3\">\n"
										. "	<input type=\"hidden\" name=\"forum_id\" value=\"" . $_REQUEST['forum_id'] . "\" />&nbsp;\n"
										. "	<input type=\"hidden\" name=\"thread_id\" value=\"" . $_REQUEST['thread_id'] . "\" />\n"
										. "	</td>\n"
										. "	</tr>\n"
										. "	<tr class=\"Forum_sondage_Q_r4\">\n"
										. "	<td class=\"Forum_sondage_Q_d4\">\n"
										. "	<input type=\"submit\" value=\"" . _TOVOTE . "\" />&nbsp;\n"
										. "	<input type=\"button\" value=\"" . _RESULT . "\" onclick=\"document.location='index.php?file=Forum&amp;page=viewtopic&amp;forum_id=" . $_REQUEST['forum_id'] . "&amp;thread_id=" . $_REQUEST['thread_id'] . "&amp;vote=view'\" />\n"
										. "	</td>\n"
										. "	</tr>\n"
										. "	</table>\n"
										. "	</form>\n";
								} 

			echo "	</td>\n"
				. "	</tr>\n";
			} 
						$sql4 = mysql_query("SELECT id, titre, auteur, auteur_id, auteur_ip, txt, date, edition, usersig, file  FROM " . FORUM_MESSAGES_TABLE . " WHERE thread_id = '" . $_REQUEST['thread_id'] . "' ORDER BY date ASC limit " . $start . ", " . $nb_mess_for_mess."");
						while (list($mess_id, $title, $auteur, $auteur_id, $auteur_ip, $txt, $date, $edition, $usersig, $fichier) = mysql_fetch_row($sql4))
						{
							$title = printSecuTags($title);            

							if ($_REQUEST['highlight'] != "")
							{ 
								$string = trim($_REQUEST['highlight']);
								$string = printSecuTags($string);
								$title = str_replace($string, '<span style="color: #FF0000">' . $string . '</span>', $title);

								$search = explode(" ", $string);
								for($i = 0; $i < count($search); $i++)
								{
									$tab = preg_split("`(<\w+.*?>)`", $txt, -1, PREG_SPLIT_DELIM_CAPTURE);
									foreach ($tab as $key=>$val)
									{
										if (preg_match("`^<\w+`", $val)) $tab[$key] = $val;
										else $tab[$key] = preg_replace("/$search[$i]/","<span style=\"color: #FF0000;\"><b>$0</b></span>", $val);
									}
									$txt = implode($tab);
								} 
							}

							if (strftime("%d %m %Y", time()) ==  strftime("%d %m %Y", $date)) $date = _FTODAY . "&nbsp;" . strftime("%H:%M", $date);
							else if (strftime("%d", $date) == (strftime("%d", time()) - 1) && strftime("%m %Y", time()) == strftime("%m %Y", $date)) $date = _FYESTERDAY . "&nbsp;" . strftime("%H:%M", $date);    
							else $date = _THE . ' ' . nkDate($date);

							$tmpcnt++ % 2 == 1 ? $color = $color1 : $color = $color2;

	echo "	<tr class=\"Forum_contenu_top_r\">\n"
		. "	<td class=\"Forum_contenu_top_d1\"><a name=\"" . $mess_id . "\"></a>\n";

            if ($auteur_id != "")
            {
                $sq_user = mysql_query("SELECT pseudo, niveau, rang, avatar, signature, date, email, icq, msn, aim, yim, url, country, count, game , xfire, facebook ,origin, steam, twitter, skype FROM " . USER_TABLE . " WHERE id = '" . $auteur_id . "'");
                $test = mysql_num_rows($sq_user);
                list($autor, $user_level, $rang, $avatar, $signature, $date_member, $email, $icq, $msn, $aim, $yim, $homepage, $country, $nb_post, $user_game, $xfire, $facebook ,$origin, $steam, $twitter, $skype) = mysql_fetch_array($sq_user);

		$sql_config = mysql_query("SELECT nivoreq FROM ". $nuked['prefix'] ."_users_config");
		list($nivoreq) = mysql_fetch_array($sql_config);

                $online_connect = mysql_query("SELECT user_id FROM " . NBCONNECTE_TABLE . " WHERE user_id = '" . $auteur_id . "'");
                list($connect_id) = mysql_fetch_array($online_connect);

                $sql_game = mysql_query("SELECT name, icon, pref_1, pref_2, pref_3, pref_4, pref_5 FROM " . GAMES_TABLE . " WHERE id = '" . $user_game . "'" );
                  list($game_name, $game_icon, $pref_1, $pref_2, $pref_3, $pref_4, $pref_5) = mysql_fetch_array($sql_game);
                  $game_name = htmlentities($game_name);

                  if ($game_icon != '' && is_file($game_icon)){
                  $game_icone = $game_icon;
                  } 
                  else{
                  $game_icone = 'images/games/nk.gif';
                  }

                  $sql_user_details = mysql_query("SELECT  pref_1, pref_2, pref_3, pref_4, pref_5 FROM " . USER_DETAIL_TABLE . " WHERE user_id = '" . $auteur_id . "'");
                  list($pref1, $pref2, $pref3, $pref4, $pref5) = mysql_fetch_array($sql_user_details);
                  
                  $pref_1 = htmlentities($pref_1);
                  $pref_2 = htmlentities($pref_2);
                  $pref_3 = htmlentities($pref_3);
                  $pref_4 = htmlentities($pref_4);
                  $pref_5 = htmlentities($pref_5);

                if($auteur_id == $connect_id){
                  $online = "" . _STATUT . " : <img src=\"modules/Forum/images/icon_online.png\" alt=\"\" title=\"" . _ONLINESTATUT . "\" style=\"margin-bottom:-3px;cursor:pointer;\" /><br />\n";
                  }
                  else{
                  $online = "" . _STATUT . " : <img src=\"modules/Forum/images/icon_offline.png\" alt=\"\" title=\"" . _OFFLINESTATUT . "\" style=\"margin-bottom:-3px;cursor:pointer;\" /><br />\n";
                  }

                if ($test > 0 && $autor != "")
                {
					// Valeur TRUE = Pas d'heure/minute.
					$date_member = nkDate($date_member, TRUE);

					if ($fichier != "" && is_file("upload/Forum/" . $fichier))
					{
						$url_file = "upload/Forum/" . $fichier;
						$filesize = filesize($url_file) / 1024;
						$arrondi_size = ceil($filesize);
						$file = explode(".", $fichier);
						$ext = count($file)-1;

						if ($user && $auteur_id == $user[0] || $visiteur >= admin_mod("Forum") || $administrator == 1)
						{
							$del = "&nbsp;<a href=\"index.php?file=Forum&amp;op=del_file&amp;forum_id=" . $_REQUEST['forum_id'] . "&amp;thread_id=" . $_REQUEST['thread_id'] . "&amp;mess_id=" . $mess_id . "\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/del.png\" alt=\"\" title=\"" . _DELFILE . "\" /></a>&nbsp;";
						} 
						else
						{
							$del = "";
						} 

					$attach_file = "<br /><img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/file.png\" alt=\"\" title=\"" . _ATTACHFILE . "\" /><a href=\"" . $url_file . "\" onclick=\"window.open(this.href); return false;\" title=\"" . _DOWNLOADFILE . "\">" . $fichier . "</a> (" . $arrondi_size . " Ko)" . $del . "&nbsp;";
					} 
					else
					{
						$attach_file = "";
					} 

					if ($modos != "" && strpos($modos, $auteur_id) !== false)
					{
						$auteur_modo = 1;
									} 
					else
					{
						$auteur_modo = 0;
					} 

					if ($rang > 0 && $nuked['forum_rank_team'] == "on")
					{
                        $sql_rank_team = mysql_query("SELECT titre, image, couleur FROM " . TEAM_RANK_TABLE . " WHERE id = '" . $rang . "'");
                        list($rank_name, $team_rank_image, $rank_color) = mysql_fetch_array($sql_rank_team);
                        $rank_name = printSecuTags($rank_name);
                        $rank_image = $team_rank_image;
					} 
					else
					{
						if ($user_level >= admin_mod("Forum"))
						{
							$user_rank = mysql_query("SELECT nom, image FROM " . FORUM_RANK_TABLE . " WHERE type = 2");
						} 
						else if ($auteur_modo == 1)
						{
							$user_rank = mysql_query("SELECT nom, image FROM " . FORUM_RANK_TABLE . " WHERE type = 1");
						} 
						else
						{
							$user_rank = mysql_query("SELECT nom, image FROM " . FORUM_RANK_TABLE . " WHERE '" . $nb_post . "' >= post AND type = 0 ORDER BY post DESC LIMIT 0, 1");
						} 

						list($rank_name, $rank_image) = mysql_fetch_array($user_rank);
						$rank_name = printSecuTags($rank_name);
					} 
            if ($rang > 0 && $nuked['profil_details'] == "on") {$style_rank = "style=\"color:#" . $rank_color . "\"";}
            else {$style_rank = "";}

                    echo "<img src=\"images/flags/". $country ."\" alt=\"" . $country ."\" />&nbsp;<a href=\"index.php?file=Members&amp;op=detail&amp;autor=" . urlencode($autor) . "\" " . $style_rank . "><b>" . $autor . "</b></a><br />\n";

					if ($rank_name != "")
					{
						echo $rank_name . "<br />\n";
					} 

					if ($rank_image != "")
					{
						echo "<img src=\"" . $rank_image . "\" alt=\"\" /><br /><br />\n";
					} 

					if ($avatar != "")
					{
						if ($avatar_resize == "off") $ar_ok = 0;
						else if (preg_match("`http://`i", $avatar) && $avatar_resize == "local") $ar_ok = 0;
						else  $ar_ok = 1;    
										
						if ($ar_ok == 1) $style = "style=\"border: 0; overflow: auto; max-width: " . $avatar_width . "px;  width: expression(this.scrollWidth >= " . $avatar_width . "? '" . $avatar_width . "px' : 'auto');\"";
						else $style = "style=\"boder:0;\"";
										
						echo "<img src=\"" . checkimg($avatar) . "\" " . $style . "alt=\"\" /><br />\n";
					} 
					else{
						echo '<img src="modules/User/images/noavatar.png" alt="" /><br />'."\n";
					}

					echo _MESSAGES . " : " . $nb_post . "<br />" . _REGISTERED . ": " . $date_member . "<br />\n";

                    if ($visiteur >= admin_mod("Forum") || $administrator == 1)
                    {
                        echo _IP . " : " . $auteur_ip ."<br />\n";
                    }
                    echo $online;

            if ($nuked['gamer_details'] == "on")
            {                       
                        echo "<br />" . _GAME . " : <img src=\"" . $game_icone . "\" alt=\"\" height=\"13px\" width=\"13px\" title=\"" . $game_name . "\" style=\"margin-bottom:-3px;\" /><br />\n";
            if ($pref1) echo "" . $pref_1 . "&nbsp;:&nbsp;" . $pref1 . "<br />\n";
            if ($pref2) echo "" . $pref_2 . "&nbsp;:&nbsp;" . $pref2 . "<br />\n";
            if ($pref3) echo "" . $pref_3 . "&nbsp;:&nbsp;" . $pref3 . "<br />\n";
            if ($pref4) echo "" . $pref_4 . "&nbsp;:&nbsp;" . $pref4 . "<br />\n";
            if ($pref5) echo "" . $pref_5 . "&nbsp;:&nbsp;" . $pref5 . "<br />\n";
            }         
                } 
                else
                {
                    echo "<b>" . $auteur . "</b><br />\n";

                    if ($visiteur >= admin_mod("Forum") || $administrator == 1)
                    {
                        echo _IP . " : " . $auteur_ip;
                    } 
                } 
            } 
            else
            {
                echo "<b>" . $auteur . "</b><br />\n";

                if ($visiteur >= admin_mod("Forum") || $administrator == 1)
                {
                    echo _IP . " : " . $auteur_ip;
                } 
            } 
            
	echo "	</td>\n"
		. "	<td class=\"Forum_contenu_top_d2\">\n"
		. "	<table width=\"100%\" height=\"100%\" cellpadding=\"5\" cellspacing=\"1\" border=\"0\">\n"
		. "	<tr width=\"100%\" height=\"35px;\">\n"
		. "	<td><a href=\"index.php?file=Forum&amp;page=viewtopic&amp;forum_id=" . $_REQUEST['forum_id'] . "&amp;thread_id=" . $_REQUEST['thread_id'] . "&amp;p=" . $_REQUEST['p'] . "#" . $mess_id . "\" title=\"" . _PERMALINK_TITLE . "\"><img src=\"images/posticon.png\" style=\"border:0px;\" alt=\"\" /></a>" . _POSTEDON . " " . $date . "&nbsp;&nbsp;" . $attach_file . "</td>\n"
		. "	<td align=\"right\">";

			if ($closed == 0 && $administrator == 1 || $visiteur >= admin_mod("Forum") || $visiteur >= $level)
			{
				echo "<a href=\"index.php?file=Forum&amp;page=post&amp;forum_id=" . $_REQUEST['forum_id'] . "&amp;thread_id=" . $_REQUEST['thread_id'] . "&amp;mess_id=" . $mess_id . "&amp;do=quote\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/buttons/" . $language . "/quote.png\" alt=\"\" title=\"" . _REPLYQUOTE . "\" /></a>";
			}
			
			/******** Patch Quick.Edit *******/
			if($nuked[forum_quick_edit] == "oui")
			{
				if ($user && $modos != "" && strpos($modos, $user[0]) !== false && $nuked[forum_quick_modo] == "oui") { $moderat = 1; } else { $moderat = 0; }
				if ($user && $auteur_id == $user[0] && $closed == 0 && $nuked[forum_quick_user] == "oui") { $Qedit_user = 1; } else { $Qedit_user = 0; }	 
				
				if($Qedit_user == 1 || $moderat == 1 || $visiteur >= admin_mod("Forum"))
				{
					echo "&nbsp;<a href=\"#" . $mess_id . "\" class=\"Qedit_bouton\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/buttons/" . $language . "/edit.png\" title=\"" . _EDITMESSAGE . "\" alt=\"\" /></a>";
				} else if ($user && $auteur_id == $user[0] && $closed == 0 || $visiteur >= admin_mod("Forum") || $administrator == 1){
					echo "&nbsp;<a href=\"index.php?file=Forum&amp;page=post&amp;forum_id=" . $_REQUEST['forum_id'] . "&amp;mess_id=" . $mess_id . "&amp;do=edit\" ><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/buttons/" . $language . "/edit.png\" title=\"" . _EDITMESSAGE . "\" alt=\"\" /></a>";
				}
				
			} else if ($user && $auteur_id == $user[0] && $closed == 0 || $visiteur >= admin_mod("Forum") || $administrator == 1) {
				echo "&nbsp;<a href=\"index.php?file=Forum&amp;page=post&amp;forum_id=" . $_REQUEST['forum_id'] . "&amp;mess_id=" . $mess_id . "&amp;do=edit\" ><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/buttons/" . $language . "/edit.png\" title=\"" . _EDITMESSAGE . "\" alt=\"\" /></a>";
			}
			/**********************************/

			if ($visiteur >= admin_mod("Forum") || $administrator == 1)
			{
				echo "&nbsp;<a href=\"index.php?file=Forum&amp;op=del&amp;mess_id=" . $mess_id . "&amp;forum_id=" . $_REQUEST['forum_id'] . "&amp;thread_id=" . $_REQUEST['thread_id'] . "\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/delete.png\" alt=\"\" title=\"" . _DELMESSAGE . "\" /></a>";
			} 

			echo "	</td>\n"
				. "	</tr>\n"
				. "	<tr height=\"20\">\n"
				. "	<td colspan=\"2\"><b>" . $title . "</b></td>\n"
				. "	</tr>\n";
								
				/******** Patch Quick.Edit *******/
				/* 		    Ajout de l'id 		 */
			echo"	<tr style=\"vertical-align: top;\">\n"
				. "	<td colspan=\"2\" id=\"" . $mess_id . "\" >" . $txt . "</td>\n"
				. "	</tr>\n";							
				/*********************************/
				
				if ($edition != "")
				{
					echo "	<tr height=\"20\" class=\"QmessEdit\">\n"
						. "	<td colspan=\"2\" valign=\"bottom\"><small><i>" . $edition . "</i></small></td>\n"
						. "	</tr>\n";
				} 
										
				if ($auteur_id != "" && $signature != "" && $usersig == 1)
				{
					echo "	<tr>\n"
						. "	<td colspan=\"2\">" . $signature . "</td>\n"
						. "	</tr>\n";
				} 
				
	echo "	</table>\n"
		. "	</td>\n"
		. "	</tr>\n"
		. "	<tr class=\"Forum_contenu_top_r2\">\n"
		. "	<td class=\"Forum_contenu_top_d3\"><a href=\"#top\" title=\"" . _BACKTOTOP . "\">" . _BACKTOTOP . "</a>&nbsp;|&nbsp;<a href=\"index.php?file=Forum&amp;page=viewtopic&amp;forum_id=" . $_REQUEST['forum_id'] . "&amp;thread_id=" . $_REQUEST['thread_id'] . "&amp;p=" . $_REQUEST['p'] . "#" . $mess_id . "\" title=\"" . _PERMALINK_TITLE . "\">" . _PERMALINK . "</a></td>\n"
		. "	<td class=\"Forum_contenu_top_d4\">";

			if ($test > 0 && $auteur_id != "")
			{
				echo "<a href=\"index.php?file=Members&amp;op=detail&amp;autor=" . urlencode($autor) . "\" title=\"" . _SEEPROFIL . "\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/buttons/" . $language . "/profile.png\" alt=\"\" /></a>&nbsp;";
			} 

			if ($test > 0 && $user && $auteur_id != "")
			{
				echo "<a href=\"index.php?file=Userbox&amp;op=post_message&amp;for=" . $auteur_id . "\" title=\"" . _SENDPM . "\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/message.png\" alt=\"\" /></a>&nbsp;";
			} 

			if ($email != "" && $auteur_id != "")
			{
				echo "<a href=\"mailto:" . $email . "\" title=\"" . _SENDEMAIL . "\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/email.png\" alt=\"\" /></a>&nbsp;";
			} 

			if ($homepage != "" && $auteur_id != "")
			{
				echo "<a href=\"" . $homepage . "\" onclick=\"window.open(this.href); return false;\" title=\"" . _SEEHOMEPAGE . "&nbsp;" . $autor . "\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/website.png\" alt=\"\" /></a>&nbsp;";
			} 

			if ($icq != "" && $auteur_id != "" && $user[1] >= $nivoreq)
			{
				echo "<a href=\"http://web.icq.com/whitepages/add_me?uin=" . $icq . "&amp;action=add\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/icq.png\" title=\"" . $icq . "\" alt=\"\" /></a>&nbsp;";
			} 

			if ($msn != "" && $auteur_id != "" && $user[1] >= $nivoreq)
			{
				echo "<a href=\"mailto:" . $msn . "\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/msn.png\" title=\"" . $msn . "\" alt=\"\" /></a>&nbsp;";
			} 

			if ($aim != "" && $auteur_id != "" && $user[1] >= $nivoreq)
			{
				echo "<a href=\"aim:goim?screenname=" . $aim . "&amp;message=Hi+" . $aim . "+Are+you+there+?\" onclick=\"window.open(this.href); return false;\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/aol.png\" title=\"" . $aim . "\" alt=\"\" /></a>&nbsp;";
			} 

			if ($yim != "" && $auteur_id != "" && $user[1] >= $nivoreq)
			{
				echo "<a href=\"http://edit.yahoo.com/config/send_webmesg?target=" . $yim . "&amp;src=pg\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/yim.png\" title=\"" . $yim . "\" alt=\"\" /></a>&nbsp;";
			}
			
      if ($xfire != "" && $auteur_id != "" && $user[1] >= $nivoreq)
      {
        echo "<a href=\"xfire:add_friend?user=" . $xfire . "\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/xfire.png\" alt=\"\" title=\"" . $xfire . "\" /></a>&nbsp;";
      }

      if ($facebook != "" && $auteur_id != "" && $user[1] >= $nivoreq)
      {
        echo "<a href=\"http://www.facebook.com/" . $facebook . "\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/facebook.png\" alt=\"\" title=\"" . $facebook . "\" /></a>&nbsp;";
      } 

      if ($origin != "" && $auteur_id != "" && $user[1] >= $nivoreq)
      {
        echo "<img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/origin.png\" alt=\"\" title=\"" . $origin . "\" />&nbsp;";
      } 

      if ($steam != "" && $auteur_id != "" && $user[1] >= $nivoreq)
      {
        echo "<a href=\"http://steamcommunity.com/actions/AddFriend/" . $steam . "\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/steam.png\" alt=\"\" title=\"" . $steam . "\" /></a>&nbsp;";
      } 

      if ($twitter != "" && $auteur_id != "" && $user[1] >= $nivoreq)
      {
        echo "<a href=\"http://twitter.com/#!/" . $twitter . "\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/twitter.png\" alt=\"\" title=\"" . $twitter . "\" /></a>&nbsp;";
      } 

      if ($skype != "" && $auteur_id != "" && $user[1] >= $nivoreq)
      {
        echo "<a href=\"skype:" . $skype . "?call\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/skype.png\" alt=\"\" title=\"" . $skype . "\" /></a>&nbsp;";
      } 
			
	echo "	</td>\n"
		. "	</tr>\n";
		
		} 

	echo "	</table>\n"; 
			
			/******** Patch Quick.Edit *******/
			/*********************************/
			echo"	<script src=\"modules/Forum/Quick_edit/jquery.min.js\" type=\"text/javascript\" charset=\"utf-8\"></script>\n"
				. "	<script src=\"modules/Forum/Quick_edit/jquery.jeditable.js\" type=\"text/javascript\" charset=\"utf-8\"></script>\n"
				. "	<script src=\"modules/Forum/Quick_edit/jquery.jeditable.CKEditor.js\" type=\"text/javascript\"></script>\n"
				. "	<script type=\"text/javascript\" src=\"media/ckeditor/ckeditor.js\"></script>\n";
			?>		
				<script type="text/javascript" charset="utf-8">			
				$(document).ready(function(){
					$('.Qedit_bouton').each(function(){
						$(this).click(function(){
							element_message = $(this).parent().parent().next().next().children();
							element_message.editable('enable');
							makeEditable(element_message);
							element_message.click();
							element_message.editable('disable');
						})
					});
				});

				function makeEditable(element){
					element.editable('index.php?file=Forum&op=save&nuked_nude=index',{
						indicator : '<img src=\"modules/Forum/Quick_edit/indicator.gif\">',
						type : 'ckeditor',
						width : '100%',
						height : 'auto',
						onblur : 'ignore',
						submit : '<?php echo _JQSEND; ?>',
						cancel : '<?php echo _JQCANCEL; ?>',
						callback : function() {
							if($(this).parent().next().hasClass('QmessEdit')){
								$('.QmessEdit').remove();
							}
						}
					});
				}
				</script>
			<?php	
			/*********************************/

	echo "<table class=\"Forum_bas_top_t\">\n"
		. "<tr class=\"Forum_bas_top_r\">\n"
		. "<td class=\"Forum_bas_top_d1\"></td>\n"
		. "</tr>\n"
		. "</table>\n"
		. "</div>\n"
		. "<table class=\"Forum_markread_t\" cellspacing=\"1\">\n"
		. "<tr class=\"Forum_markread_r\">\n"
		. "<td class=\"Forum_markread_d\">";

			if ($user[0] != "")
			{
				$sql_notify = mysql_query("SELECT emailnotify FROM " . FORUM_MESSAGES_TABLE . " WHERE thread_id = '" . $_REQUEST['thread_id'] . "' AND auteur_id = '" . $user[0] . "'");
				$user_notify = mysql_num_rows($sql_notify);
							
				if ($user_notify > 0)
				{
					$inotify = 0;
					while(list($notify) = mysql_fetch_array($sql_notify))
					{
						if ($notify == 1)
						{
							$inotify++;
						}
					}
					if ($inotify > 0)
					{
						echo "<a href=\"index.php?file=Forum&amp;op=notify&amp;do=off&amp;forum_id=" . $_REQUEST['forum_id'] . "&amp;thread_id=" . $_REQUEST['thread_id'] . "\">" . _NOTIFYOFF . "</a><br />\n";
					}
					else
					{
						echo "<a href=\"index.php?file=Forum&amp;op=notify&amp;do=on&amp;forum_id=" . $_REQUEST['forum_id'] . "&amp;thread_id=" . $_REQUEST['thread_id'] . "\">" . _NOTIFYON . "</a><br />\n";
					}
				}
			}
			
	echo "	</td>\n"
		. "	</tr>\n"
		. "	</table>\n"
		. "	<table class=\"Forum_nav_t\" cellspacing=\"4\" border=\"0\">\n"
		. "	<tr class=\"Forum_nav_r\">\n";

		if ($count > $nb_mess_for_mess)
		{		
			echo"	<td class=\"Forum_prevnext_top_d1\">\n";
					  number($count, $nb_mess_for_mess, $url_page);
			echo "	</td>\n";
		}
					
	echo "	<td class=\"Forum_nav_d2\">\n";
			
		if ($level == 0 || $visiteur >= $level || $administrator == 1)
		{
			echo "&nbsp;<a href=\"index.php?file=Forum&amp;page=post&amp;forum_id=" . $_REQUEST['forum_id'] . "\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/buttons/" . $language . "/newthread.png\" alt=\"\" title=\"" . _NEWSTOPIC . "\" /></a>&nbsp;";
			if ($closed == 0 || $administrator == 1 || $visiteur >= admin_mod("Forum"))
			{
				echo "&nbsp;<a href=\"index.php?file=Forum&amp;page=post&amp;forum_id=" . $_REQUEST['forum_id'] . "&amp;thread_id=" . $_REQUEST['thread_id'] . "\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/buttons/" . $language . "/reply.png\" alt=\"\" title=\"" . _REPLY . "\" /></a>";
			} 
		} 
			
	echo "</td>\n"
		. "</tr>\n"
		. "</table>\n"
		. "<div class=\"Forum_cadre_bas\">\n";

	$nb = nbvisiteur();
	if($nuked['forum_who_viewtopic'] == "oui")	
	{
	echo "	<table class=\"Forum_online_t\" cellspacing=\"0\">\n"
		. "	<tr class=\"Forum_online_r\">\n"
		. "	<td class=\"Forum_online_d\" colspan=\"5\"><b>" . _FWHOISONLINE . "</b></td>\n"
		. "	</tr>\n"
		. "	</table>\n"
		. "	<table class=\"Forum_online_centre_t\" cellspacing=\"1\">\n"
		. "	<tr class=\"Forum_online_centre_r\">\n"
		. "	<td class=\"Forum_online_centre_d1\"><img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/whoisonline.png\" alt=\"\" /></td>\n"
		. "	<td class=\"Forum_online_centre_d2\">" . _THEREARE . "&nbsp;" . $nb[0] . "&nbsp;" . _FVISITORS . ", " . $nb[1] . "&nbsp;" . _FMEMBERS . "&nbsp;" . _AND . "&nbsp;" . $nb[2] . "&nbsp;" . _FADMINISTRATORS . "&nbsp;" . _ONLINE . "<br />" . _MEMBERSONLINE . " : ";

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
				echo "<a href=\"index.php?file=Members&amp;op=detail&amp;autor=" . urlencode($name) . "\">" . $name . "</a>" . $sep;
			}
			if (mysql_num_rows($online) == NULL) echo '<em>' . _NONE . '</em>';

	echo "	</td>\n"
		. "	<td class=\"Forum_online_centre_d3\"><b>" . _MODO . " :</b>&nbsp;<small>" . $lienmodo . "</small></td>\n"
		. "	</tr>\n"
		. "	</table>\n"
		. "	<table class=\"Forum_online_bas_t\">\n"
		. "	<tr class=\"Forum_online_bas_r\">\n"
		. "	<td class=\"Forum_online_bas_d\"></td>\n"
		. "	</tr>\n"
		. "	</table>\n";
	}		
	echo "	<table class=\"Forum_info_top_t\" cellspacing=\"0\">\n"
		. "	<tr class=\"Forum_info_top_r1\">\n";

				
		if ($visiteur >= admin_mod("Forum") || $administrator == 1)
		{
			echo "<td class=\"Forum_info_top_d1\"><a href=\"index.php?file=Forum&amp;op=del_topic&amp;forum_id=" . $_REQUEST['forum_id'] . "&amp;thread_id=" . $_REQUEST['thread_id'] . "\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/topic_delete.png\" alt=\"\" title=\"" . _TOPICDEL . "\" /></a>"
				. "&nbsp;<a href=\"index.php?file=Forum&amp;op=move&amp;forum_id=" . $_REQUEST['forum_id'] . "&amp;thread_id=" . $_REQUEST['thread_id'] . "\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/topic_move.png\" alt=\"\" title=\"" . _TOPICMOVE . "\" /></a>";

			if ($closed == 1)
			{
				echo "&nbsp;<a href=\"index.php?file=Forum&amp;op=lock&amp;forum_id=" . $_REQUEST['forum_id'] . "&amp;thread_id=" . $_REQUEST['thread_id'] . "&amp;do=open\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/topic_unlock.png\" alt=\"\" title=\"" . _TOPICUNLOCK . "\" /></a>";
			} 
			else
			{
				echo "&nbsp;<a href=\"index.php?file=Forum&amp;op=lock&amp;forum_id=" . $_REQUEST['forum_id'] . "&amp;thread_id=" . $_REQUEST['thread_id'] . "&amp;do=close\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/topic_lock.png\" alt=\"\" title=\"" . _TOPICLOCK . "\" /></a>";
			} 

			if ($annonce == 1)
			{
				echo "&nbsp;<a href=\"index.php?file=Forum&amp;op=announce&amp;forum_id=" . $_REQUEST['forum_id'] . "&amp;thread_id=" . $_REQUEST['thread_id'] . "&amp;do=down\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/topic_down.png\" alt=\"\" title=\"" . _TOPICDOWN . "\" /></a>";
			} 
			else
			{
				echo "&nbsp;<a href=\"index.php?file=Forum&amp;op=announce&amp;forum_id=" . $_REQUEST['forum_id'] . "&amp;thread_id=" . $_REQUEST['thread_id'] . "&amp;do=up\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/topic_up.png\" alt=\"\" title=\"" . _TOPICUP . "\" /></a>";
			} 
		}
		
	echo"	<script type=\"text/javascript\">\nMaxWidth = document.getElementById('Forum').offsetWidth - 300;\n</script>\n"
		. "	</td>\n"
		. "	</tr>\n"
		. "	</table>\n";				
				
	echo '<script type="text/javascript">
		<!--
			var Img = document.getElementById("img_resize_forum").getElementsByTagName("img");
			var NbrImg = Img.length;
			for(var i = 0; i < NbrImg; i++){
				if (Img[i].width > MaxWidth){
					Img[i].style.height = Img[i].height * MaxWidth / Img[i].width+"px";
					Img[i].style.width = MaxWidth+"px";
				}
			}
		-->
		</script>';				
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