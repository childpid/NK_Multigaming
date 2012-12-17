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

global $nuked, $language;

translate("modules/Forum/lang/" . $language . ".lang.php");
define('FORUM_PRIMAIRE_TABLE', $nuked['prefix'] . '_forums_primaire');
include("modules/Forum/template.php");

opentable();

/****** Récupération du skin ******/
include('modules/Forum/Skin/' . $nuked['forum_skin'] . '/comun.php');
include('modules/Forum/Skin/' . $nuked['forum_skin'] . '/search.php');

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
    if ($_REQUEST['do'] == "search")
    {
		$where = "AS M , " . FORUM_TABLE . " AS F , " . FORUM_CAT_TABLE . " AS C WHERE";

		if (is_int(strpos($_REQUEST['id_forum'], 'cat_')))
		{
				$cat = preg_replace("`cat_`i", "", $_REQUEST['id_forum']);
				$where .= " F.cat = '" . $cat . "' AND";
		}
			else if ($_REQUEST['id_forum'] != "")
			{
				$cat = $_REQUEST['id_forum'];
				$where .= " M.forum_id = '" . $cat . "' AND";
			}
		else
		{
				$cat = 0;
		}

		$where .= " F.cat = C.id AND '" . $visiteur . "' >= C.niveau AND M.forum_id = F.id AND '" . $visiteur . "' >= F.niveau AND";

		if ($_REQUEST['limit'] == "" || !is_numeric($_REQUEST['limit'])) $_REQUEST['limit'] = 50;
		if (!$_REQUEST['p']) $_REQUEST['p'] = 1;
		$start = $_REQUEST['p'] * $_REQUEST['limit'] - $_REQUEST['limit'];

		$_REQUEST['autor'] = trim($_REQUEST['autor']);

		if (preg_match("`%20union%20`i", $_REQUEST['query']) ||preg_match("` union `i", $_REQUEST['query']) || preg_match("`\*union\*`i", $_REQUEST['query']) || preg_match("`\+union\+`i", $_REQUEST['query']) || preg_match("`\*`i", $_REQUEST['query']) || !is_numeric($cat))
		{
			echo"	<div class=\"Forum_Psearch_error\"><big>What are you trying to do ?</big></div>\n";
					redirect("index.php?file=Forum&page=search", 2);
					closetable();
					footer();
					exit();
		}

		$_REQUEST['query'] = mysql_real_escape_string(stripslashes($_REQUEST['query']));
		$_REQUEST['query'] = trim($_REQUEST['query']);

		if ($_REQUEST['date_max'] != "" && !preg_match("`[^0-9]`i", $_REQUEST['date_max']))
		{
			$req = "SELECT M.id, M.auteur, M.auteur_id, M.titre, M.txt, M.thread_id, M.forum_id, M.date FROM " . FORUM_MESSAGES_TABLE . " " . $where . " M.date > '" . $_REQUEST['date_max'] . "' ORDER BY M.date DESC";
			$result = mysql_query($req);
		} 
		else if (($_REQUEST['query'] != "" && strlen($_REQUEST['query']) < 3) || ($_REQUEST['autor'] != "" && strlen($_REQUEST['autor']) < 3))
		{
			echo"	<div class=\"Forum_Psearch_error\">" . _3CHARSMIN . "</div>";
					redirect("index.php?file=Forum&page=search", 2);
					closetable();
					footer();
					exit();
		} 
		else if ($_REQUEST['query'] != "" || $_REQUEST['autor'] != "")
		{
			$and = "";

			if ($_REQUEST['autor'] != "" && $_REQUEST['query'] != "")
			{ 
				$_REQUEST['autor'] = nk_CSS($_REQUEST['autor']);
				$_REQUEST['autor'] = htmlentities($_REQUEST['autor'], ENT_QUOTES);
				$and .= "(M.auteur LIKE '%" . $_REQUEST['autor'] . "%') AND ";
			}
			else if ($_REQUEST['autor'] != "")
			{ 
				$_REQUEST['autor'] = nk_CSS($_REQUEST['autor']);
				$_REQUEST['autor'] = htmlentities($_REQUEST['autor'], ENT_QUOTES);
				$and .= "(M.auteur LIKE '%" . $_REQUEST['autor'] . "%')";
			}

			if ($_REQUEST['searchtype'] == "matchexact" && $_REQUEST['query'] != "")
			{
				if ($_REQUEST['into'] == "message")
				{
					$and .= "(M.txt LIKE '%" . $_REQUEST['query'] . "%')";
				} 
				else if ($_REQUEST['into'] == "subject")
				{
					$and .= "(M.titre LIKE '%" . $_REQUEST['query'] . "%')";
				} 
				else
				{
					$and .= "(M.txt LIKE '%" . $_REQUEST['query'] . "%' OR M.titre LIKE '%" . $_REQUEST['query'] . "%')";
				} 
			} 
			else if ($_REQUEST['query'] != "")
			{
				$search = explode(" ", $_REQUEST['query']);
				$sep = "";
				$and .= "(";
				for($i = 0; $i < count($search); $i++)
				{
					if ($_REQUEST['into'] == "message")
					{
						$and .= $sep . "M.txt LIKE '%" . $search[$i] . "%'";
					} 
					else if ($_REQUEST['into'] == "subject")
					{
						$and .= $sep . "M.titre LIKE '%" . $search[$i] . "%'";
					} 
					else
					{
						$and .= $sep . "(M.txt LIKE '%" . $search[$i] . "%' OR M.titre LIKE '%" . $search[$i] . "%')";
					}
					
					if ($_REQUEST['searchtype'] == "matchor") $sep = " OR ";
					else $sep = " AND ";
				} 
				$and .= ")";
			} 

				$req = "SELECT M.id, M.auteur, M.auteur_id, M.titre, M.txt, M.thread_id, M.forum_id, M.date FROM " . FORUM_MESSAGES_TABLE . " " . $where . " " . $and . " ORDER BY M.date DESC";
				$result = mysql_query($req);
		} 
		else
		{
			echo"	<div class=\"Forum_Psearch_error\">" . _NOWORDSTOSEARCH . "</div>\n";
					redirect("index.php?file=Forum&page=search", 2);
					closetable();
					footer();
					exit();
		} 

		$nb_result = mysql_num_rows($result);

		echo "	<br />\n"
			. "	<table class=\"Forum_Psearch_result_t\" cellspacing=\"0\">\n"
			. "		<tr class=\"Forum_Psearch_result_r\">\n"
			. "			<td class=\"Forum_Psearch_result_d\"><big><b>" . _FSEARCHRESULT . "</b></big> - " . $nb_result . "&nbsp;" . _FSEARCHFOUND . "</td>\n"
			. "		</tr>\n"
			. "	</table>\n";

echo "		<table class=\"Forum_nav_t\" cellspacing=\"4\" border=\"0\">\n"
		. "		<tr class=\"Forum_nav_r\">\n"
		. "			<td class=\"Forum_nav_d1\"><a href=\"index.php?file=Forum\"><b>" . _INDEXFORUM . "</b></a> -&gt; <a href=\"index.php?file=Forum&amp;page=search\"><b>" . _SEARCH . "</b></a></td>\n"
		. "		</tr>\n"
		. "	</table>\n";			
			
			
				$url = "index.php?file=Forum&amp;page=search&amp;op=" . $op . "&amp;query=" . urlencode($_REQUEST['query']) . "&amp;autor=" . urlencode($_REQUEST['autor']) . "&amp;do=" . $_REQUEST['do'] . "&amp;into=" . $_REQUEST['into'] . "&amp;searchtype=" . $_REQUEST['searchtype'] . "&amp;id_forum=" . $_REQUEST['id_forum'] . "&amp;limit=" . $_REQUEST['limit'] . "&amp;date_max=" . $_REQUEST['date_max'];
				if ($nb_result > $_REQUEST['limit']) number($nb_result, $_REQUEST['limit'], $url);

echo"<div class=\"Forum_encadrement\">\n";

echo "		<table class=\"Forum_Psearch_haut_t\" cellspacing=\"1\">\n"
		. "		<tr class=\"Forum_Psearch_haut_r\">\n"
		. "			<td class=\"Forum_Psearch_haut_d1\"><b>" . _FORUMS . "</b></td>\n"
		. "			<td class=\"Forum_Psearch_haut_d2\"><b>" . _SUBJECTS . "</b></td>\n"
		. "			<td class=\"Forum_Psearch_haut_d3\"><b>" . _AUTHOR . "</b></td>\n"
		. "			<td class=\"Forum_Psearch_haut_d4\"><b>" . _DATE . "</b></td>\n"
		. "		</tr>\n"
		. "	</table>\n";

echo "		<table class=\"Forum_Psearch_centre_t\" cellspacing=\"1\">\n";

				if ($nb_result > 0)
				{
					mysql_data_seek($result, $start);
					for($i = 0;$i < $_REQUEST['limit'];$i++)
					{
						if (list($mess_id, $auteur, $auteur_id, $titre, $txt, $thread_id, $forum_id, $date) = mysql_fetch_row($result))
						{
							$sql_forum = mysql_query("SELECT nom, niveau FROM " . FORUM_TABLE . " WHERE id = '" . $forum_id . "'");
							list($forum_name, $forum_level) = mysql_fetch_row($sql_forum);
							$date = nkDate($date);
							$forum_name = htmlentities($forum_name);

							$auteur = nk_CSS($auteur);

							$texte = strip_tags($txt);
							$title = htmlentities($titre);
							$title = nk_CSS($title);

							if (!preg_match("`[a-zA-Z0-9\?\.]`", $texte))
							{
								$texte = _NOTEXTRESUME;
							} 

							if (strlen($texte) > 150)
							{
								$texte = substr($texte, 0, 150) . "...";
							} 

							$texte = nk_CSS($texte);
							$texte = htmlentities($texte);
								
							$sql_page = mysql_query("SELECT thread_id FROM " . FORUM_MESSAGES_TABLE . " WHERE thread_id = '" . $thread_id . "'");
							$nb_rep = mysql_num_rows($sql_page);

							if ($nb_rep > $nuked['mess_forum_page'])
							{
								$topicpages = $nb_rep / $nuked['mess_forum_page'];
								$topicpages = ceil($topicpages);
								$page_num = "&amp;p=" . $topicpages . "#" . $mess_id;
							} 
							else
							{
								$page_num = "#" . $mess_id;
							} 

							if (strlen($titre) > 30)
							{
								$titre_topic = "<a href=\"index.php?file=Forum&amp;page=viewtopic&amp;forum_id=" . $forum_id . "&amp;thread_id=" . $thread_id . "&amp;highlight=" . urlencode($_REQUEST['query']) . $page_num . "\" onmouseover=\"AffBulle('" . $title . "', '" . $texte . "', 320)\" onmouseout=\"HideBulle()\"><b>" . htmlentities(substr($titre, 0, 30)) . "...</b></a>";
							} 
							else
							{
								$titre_topic = "<a href=\"index.php?file=Forum&amp;page=viewtopic&amp;forum_id=" . $forum_id . "&amp;thread_id=" . $thread_id . "&amp;highlight=" . urlencode($_REQUEST['query']) . $page_num . "\" onmouseover=\"AffBulle('" . $title . "', '" . $texte . "', 320)\" onmouseout=\"HideBulle()\"><b>" . $title . "</b></a>";
							} 

							if ($auteur_id != "")
							{
								$sql_user = mysql_query("SELECT pseudo FROM " . USER_TABLE . " WHERE id = '" . $auteur_id . "'");
								$test = mysql_num_rows($sql_user);
								list($autors) = mysql_fetch_row($sql_user);

									if ($test > 0 && $autors != "")
									{
										$author = "<a href=\"index.php?file=Members&amp;op=detail&amp;autor=" . urlencode($autors) . "\">" . $autors . "</a>";
									} 
									else
									{
										$author = $auteur;
									} 
							} 
							else
							{
								$author = $auteur;
							} 


							if ($visiteur >= $forum_level)
							{
								echo "	<tr class=\"Forum_Psearch_centre_r\">\n"
									. "		<td class=\"Forum_Psearch_centre_d1\"><a href=\"index.php?file=Forum&amp;page=viewforum&amp;forum_id=" . $forum_id . "\"><b>" . $forum_name . "</b></a></td>\n"
									. "		<td class=\"Forum_Psearch_centre_d2\">" . $titre_topic . "</td>\n"
									. "		<td class=\"Forum_Psearch_centre_d3\">" . $author . "</td>\n"
									. "		<td class=\"Forum_Psearch_centre_d4\">" . $date . "</td>\n"
									. "	</tr>\n";
							} 
						} 
					} 
				} 
				else
				{
					$rquery = htmlentities($_REQUEST['query']);
					$rquery = nk_CSS($rquery);
					$rquery = stripslashes($rquery);

					if ($_REQUEST['query'] != "")
					{
						$result = _FNOSEARCHFOUND . " <b><i>" . $rquery . "</i></b>";
					} 
					else if ($_REQUEST['autor'] != "")
					{
						$result = _FNOSEARCHFOUND . " <b><i>" . $_REQUEST['autor'] . "</i></b>";
					} 
					else if ($_REQUEST['date_max'] != "" && !preg_match("`[^0-9]`i", $_REQUEST['date_max']))
					{
						$result = _FNOLASTVISITMESS;
					} 
					else
					{
						$result = _FNOSEARCHRESULT;
					} 

					echo "		<tr class=\"Forum_Psearch_error_t\">\n"
						. "			<td colspan=\"4\">" . $result . "</td>\n"
						. "		</tr>\n";
					} 

echo "		</table>\n"
	. "	</div>\n";

		$url = "index.php?file=Forum&amp;page=search&amp;op=" . $op . "&amp;query=" . urlencode($_REQUEST['query']) . "&amp;autor=" . urlencode($_REQUEST['autor']) . "&amp;do=" . $_REQUEST['do'] . "&amp;into=" . $_REQUEST['into'] . "&amp;searchtype=" . $_REQUEST['searchtype'] . "&amp;id_forum=" . $_REQUEST['id_forum'] . "&amp;limit=" . $_REQUEST['limit'] . "&amp;date_max=" . $_REQUEST['date_max'];
		if ($nb_result > $_REQUEST['limit']) number($nb_result, $_REQUEST['limit'], $url);

		echo "	<form method=\"get\" action=\"index.php\">\n"
			. "	<div class=\"Forum_research\">\n"
			. "		<input type=\"hidden\" name=\"file\" value=\"Forum\" />\n"
			. "		<input type=\"hidden\" name=\"page\" value=\"search\" />\n"
			. "		<input type=\"hidden\" name=\"do\" value=\"search\" />\n"
			. "		<input type=\"hidden\" name=\"into\" value=\"all\" />\n"
			. "		<b>" . _SEARCH . " :</b> <input type=\"text\" name=\"query\" size=\"25\" />&nbsp;<input type=\"submit\" value=\"" . _SEND . "\" />\n"
			. "	</div></form><br />\n";
    } 
    else
    {

	echo "	<script type=\"text/javascript\">\n"
        . "    $(document).ready(function() {\n"
        . "    $(\"#autor\").autocomplete(\"index.php?file=Members&op=list&nuked_nude=index\",{
                minChars:2,
                max:200
            });
                });\n"
        . "    </script>\n";
		
		
echo "		<table class=\"Forum_nav_t\" cellspacing=\"4\" border=\"0\">\n"
		. "		<tr class=\"Forum_nav_r\">\n"
		. "			<td class=\"Forum_nav_d1\"><a href=\"index.php?file=Forum\"><b>" . _INDEXFORUM . "</b></a> -&gt; <b>" . _SEARCH . "</b></td>\n"
		. "		</tr>\n"
		. "	</table>\n";	
		
echo"<div class=\"Forum_encadrement\">\n";
		
echo "			<form method=\"post\" action=\"index.php?file=Forum&amp;page=search&amp;do=search\">\n"
        . "		<table class=\"Forum_Psearch_haut_t\" cellspacing=\"1\">\n"
        . "			<tr class=\"Forum_Psearch_haut_r\">\n"
		. "				<td class=\"Forum_Psearch_haut_d2\"><b>" . _SEARCHING . "</b></td>\n"
		. "			</tr>\n"
		. "		</table>\n";
		
		
echo "			<table class=\"Forum_Psearch_centre2_t\" cellspacing=\"1\">\n"
        . "			<tr class=\"Forum_Psearch_centre2_r1\">\n"
		. "				<td class=\"Forum_Psearch_centre2_d1\"><b>" . _KEYWORDS . " :</b></td>\n"
		. "				<td class=\"Forum_Psearch_centre2_d2\">&nbsp;<input type=\"text\" name=\"query\" size=\"30\" />\n"
		. "					\n"
        . "					<br /><input type=\"radio\" class=\"checkbox\" name=\"searchtype\" value=\"matchor\" />" . _MATCHOR . "\n"
        . "					<br /><input type=\"radio\" class=\"checkbox\" name=\"searchtype\" value=\"matchand\" checked=\"checked\" />" . _MATCHAND . "\n"
        . "					<br /><input type=\"radio\" class=\"checkbox\" name=\"searchtype\" value=\"matchexact\" />" . _MATCHEXACT . "</td>\n"
		. "			</tr>\n"
        . "			<tr class=\"Forum_Psearch_centre2_r2\">\n"
		. "				<td class=\"Forum_Psearch_centre2_d3\"><b>" . _AUTHOR . " :</b></td>\n"
		. "				<td class=\"Forum_Psearch_centre2_d4\">&nbsp;<input type=\"text\" name=\"autor\" id=\"autor\" size=\"30\" /></td>\n"
		. "			</tr>\n"
        . "			<tr class=\"Forum_Psearch_centre2_r3\">\n"
		. "				<td class=\"Forum_Psearch_centre2_d5\"><b>" . _FORUM . " :</b></td>\n"
		. "				<td class=\"Forum_Psearch_centre2_d6\">&nbsp;<select name=\"id_forum\">\n"
		. "					<option value=\"\">" . _ALL . "</option>\n";

							$sql_cat = mysql_query("SELECT id, nom FROM " . FORUM_CAT_TABLE . " WHERE '" . $visiteur . "' >= niveau ORDER BY ordre, nom");
							while (list($cat, $cat_name) = mysql_fetch_row($sql_cat))
							{
								$cat_name = htmlentities($cat_name);

								echo "<option value=\"cat_" . $cat . "\">* " . $cat_name . "</option>\n";

								$sql_forum = mysql_query("SELECT nom, id FROM " . FORUM_TABLE . " WHERE cat = '" . $cat . "' AND '" . $visiteur . "' >= niveau ORDER BY ordre, nom");
								while (list($forum_name, $fid) = mysql_fetch_row($sql_forum))
								{
									$forum_name = htmlentities($forum_name);

									echo "<option value=\"" . $fid . "\">&nbsp;&nbsp;&nbsp;" . $forum_name . "</option>\n";
								} 
							} 

echo "					</select></td>\n"
	. "				</tr>\n"
    . "				<tr class=\"Forum_Psearch_centre2_r4\">\n"
	. "					<td class=\"Forum_Psearch_centre2_d7\"><b>" . _SEARCHINTO . " :</b></td>\n"
	. "					<td class=\"Forum_Psearch_centre2_d8\">&nbsp;\n"
	. "						<input type=\"radio\" class=\"checkbox\" name=\"into\" value=\"subject\" />" . _SUBJECTS . "&nbsp;\n"
	. "						<input type=\"radio\" class=\"checkbox\" name=\"into\" value=\"message\" />" . _MESSAGES . "&nbsp;\n"
	. "						<input type=\"radio\" class=\"checkbox\" name=\"into\" value=\"all\" checked=\"checked\" />" . _BOTH . "\n"
	. "					</td>\n"
	. "				</tr>\n"
    . "				<tr class=\"Forum_Psearch_centre2_r5\">\n"
	. "					<td class=\"Forum_Psearch_centre2_d9\"><b>" . _NBANSWERS . " :</b></td>\n"
	. "					<td class=\"Forum_Psearch_centre2_d10\">&nbsp;\n"
	. "						<input type=\"radio\" class=\"checkbox\" name=\"limit\" value=\"10\" />10 &nbsp;\n"
	. "						<input type=\"radio\" name=\"limit\" class=\"checkbox\" value=\"50\" checked=\"checked\" />50&nbsp;\n"
	. "						<input type=\"radio\" name=\"limit\" class=\"checkbox\" value=\"100\" />100\n"
	. "					</td>\n"
	. "				</tr>\n"
    . "				<tr class=\"Forum_Psearch_centre2_r6\">\n"
	. "					<td class=\"Forum_Psearch_centre2_d11\" colspan=\"2\"><input type=\"submit\" value=\"" . _SEARCHING . "\" /></td>\n"
	. "				</tr>\n"
	. "			</table>\n"
	. "			</form>\n";
echo"		</div>";
    } 
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
