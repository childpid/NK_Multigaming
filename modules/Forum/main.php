<?php 
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
defined('INDEX_CHECK') or die ('You can\'t run this file alone.');

global $user, $nuked, $language, $cookie_forum;

translate("modules/Forum/lang/" . $language . ".lang.php");
define('FORUM_PRIMAIRE_TABLE', $nuked['prefix'] . '_forums_primaire');
include('modules/Forum/template.php');

$visiteur = $user ? $user[1] : 0;
$user_last_visit = (empty($user[4])) ? time() : $user[4];

opentable();
// Affichage Forum (Acceuil) - Début Forum Header
echo '<div id="Forum"><div class="ForumHeader">';

/****** Récupération du skin ******/
include('modules/Forum/Skin/' . $nuked['forum_skin'] . '/comun.php');
include('modules/Forum/Skin/' . $nuked['forum_skin'] . '/main.php');

$date_jour = nkDate(time());
$your_last_visite = nkDate($user_last_visit);

if ($nuked['forum_title'] != "")
{
    $title = "Forums " . $nuked['forum_title'];
} 
else
{
    $title = "Forums " . $nuked['name'];
} 

if ($_REQUEST['cat'] != "")
{
	$sql_cat = mysql_query("SELECT nom, cat_primaire, moderateurs  FROM " . FORUM_CAT_TABLE . " WHERE id = '" . $_REQUEST['cat'] . "'");
    list($cat_name, $catprimaire, $modos ) = mysql_fetch_row($sql_cat);
    $cat_name = printSecuTags($cat_name); 
    $catprimaire = printSecuTags($catprimaire); 
	
	$sql_cats = mysql_query("SELECT id, nom FROM " . FORUM_PRIMAIRE_TABLE . " WHERE id = '" . $catprimaire . "'");
    list($cat_pri, $cat_primaire) = mysql_fetch_row($sql_cats);
    $cat_primaire = printSecuTags($cat_primaire); 

    if ($nuked['forum_cat_prim'] == "on")
    { 	
    $nav = "&nbsp;<img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/fleche.png\" alt=\"\" style=\"margin-bottom:-2px;\"/>&nbsp;<a href=\"index.php?file=Forum&amp;cat=" . $cat_pri . "\"><b>" . $cat_primaire . "</b></a>&nbsp;<img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/fleche.png\" alt=\"\" style=\"margin-bottom:-2px;\"/>&nbsp;<b>" . $cat_name . "</b>";
    } 
    else
    {
    $nav = "&nbsp;<img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/fleche.png\" alt=\"\" style=\"margin-bottom:-2px;\"/>&nbsp;<b>" . $cat_name . "</b>";    
    } 
} 
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
	
	if ($user && $user[4] != "")
	{
		$lst = ' - ' . _LASTVISIT . " : " . $your_last_visite;
	} 

	if($nuked['forum_search_secondaire'] == "oui")	
		{
		echo'
		<div class="navbar">
		<div class="navbar-inner">
		<form class="navbar-form" method="get" action="index.php">
		<input type="text" name="query" class="span3" />
		<input type="hidden" name="file" value="Forum" />
		<input type="hidden" name="page" value="search" />
		<input type="hidden" name="do" value="search" />
		<input type="hidden" name="into" value="all" />
		<button type="submit" class="btn">' . _SEARCH . '</button>
		</form>
		</div>
		</div>
		';
	}
	
echo '<ul class="breadcrumb">
		<li class="active">' . _INDEXFORUM . '</li>
		<li class="pull-right">' . _DAYIS . ' : ' . $date_jour . $lst . '</li>
	  </ul>';
//Fin Header Forum
echo '</div>';

echo '<div class="forumcontenu">';		
if ($_REQUEST['cat'] != "")
{
    $main = mysql_query("SELECT nom, id, image FROM " . FORUM_CAT_TABLE . " WHERE '" . $visiteur . "' >= niveau AND id = '" . $_REQUEST['cat'] . "'");
} 
else
{
    $main = mysql_query("SELECT nom, id, image FROM " . FORUM_CAT_TABLE . " WHERE " . $visiteur . " >= niveau ORDER BY ordre, nom");
} 

while (list($nom_cat, $cid, $cat_image) = mysql_fetch_row($main))
{
    $nom_cat = printSecuTags($nom_cat);
	if ($cat_image != "")
	{ 
	$nom_cat = '<img src="' . $cat_image . '"/>';		
	}   
	echo '<div class="forumcategorie"><table class="table table-striped"><caption><a href="index.php?file=Forum&amp;page=main&amp;cat=' . $cid . '">' . $nom_cat . '</a></caption><thead><tr>';
	if ($nuked['image_forums'] == "on")
    { 
    echo '<td colspan="2"></td>';
    }
	else 
	{
	echo '<td></td>';
	}
	echo '<td>' . _FORUMS . '</td><td>' . _SUBJECTS . '</td><td>' . _MESSAGES . '</td><td>' . _LASTPOST . '</td></tr></thead><tbody>';
		
	
				$sqls = mysql_query("SELECT id from " . FORUM_TABLE . " WHERE cat = '" . $cid . "'");
				list($id_cat) = mysql_fetch_row($sqls);	
				if($id_cat)
				{
					$sql = mysql_query("SELECT nom, comment, image, id from " . FORUM_TABLE . " WHERE cat = '" . $cid . "' AND '" . $visiteur . "' >= niveau ORDER BY ordre, nom");
					while (list($nom, $comment, $forum_image, $forum_id) = mysql_fetch_row($sql))
					{
						$nom = printSecuTags($nom);

						$req2 = mysql_query("SELECT forum_id from " . FORUM_THREADS_TABLE . " WHERE forum_id = '" . $forum_id . "'");
						$num_post = mysql_num_rows($req2);

						$req3 = mysql_query("SELECT forum_id from " . FORUM_MESSAGES_TABLE . " WHERE forum_id = '" . $forum_id . "'");
						$num_mess = mysql_num_rows($req3);

						$req4 = mysql_query("SELECT MAX(id) from " . FORUM_MESSAGES_TABLE . " WHERE forum_id = '" . $forum_id . "'");
						$idmax = mysql_result($req4, 0, "MAX(id)");

						$req5 = mysql_query("SELECT id, titre, thread_id, date, auteur, auteur_id, txt FROM " . FORUM_MESSAGES_TABLE . " WHERE id = '" . $idmax . "'");
						list($mess_id, $lp_titre, $thid, $date, $auteur, $auteur_id, $txt) = mysql_fetch_array($req5);			
						$lp_title = htmlentities(printSecuTags($lp_titre));
						$auteur = nk_CSS($auteur);
						
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
						
						if (strlen($lp_titre) > 30)
						{
							$titre_topic = "<a href=\"index.php?file=Forum&amp;page=viewtopic&amp;forum_id=" . $forum_id . "&amp;thread_id=" . $thid . "#" . $mess_id . "\" onmouseover=\"AffBulle('" . mysql_real_escape_string(stripslashes($lp_title)) . "', '" . mysql_real_escape_string(stripslashes($texte)) . "', 400)\" onmouseout=\"HideBulle()\"><b>" . printSecuTags(substr($lp_titre, 0, 30)) . "...</b></a>";
						}
						else
						{
							$titre_topic = "<a href=\"index.php?file=Forum&amp;page=viewtopic&amp;forum_id=" . $forum_id . "&amp;thread_id=" . $thid . "#" . $mess_id . "\" onmouseover=\"AffBulle('" . mysql_real_escape_string(stripslashes($lp_title)) . "', '" . mysql_real_escape_string(stripslashes($texte)) . "', 400)\" onmouseout=\"HideBulle()\"><b>" . printSecuTags($lp_titre) . "</b></a>";
						}

						  if ($user) {
							   $visits = mysql_query("SELECT user_id, forum_id FROM " . FORUM_READ_TABLE . " WHERE user_id = '" . $user[0] . "' AND forum_id LIKE '%" . ',' . $forum_id . ',' . "%' ");
							   $results = mysql_fetch_assoc($visits);
							   if ($num_post > 0 && strrpos($results['forum_id'], ',' . $forum_id . ',') === false) {
								$img = "<img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/forum_new.png\" alt=\"\" />";
							} 
							else
							{
								$img = "<img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/forum.png\" alt=\"\" />";
							} 
						} 
						else
						{
							$img = "<img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/forum.png\" alt=\"\" />";
						} 

						echo '<tr><td>' . $img . '</td>';
        if ($nuked['image_forums'] == "on")
        { 
            if ($forum_image == "")
            { 
            $forum_image = "images/no_forum_image.png";
            }         
              echo '<td><a href="index.php?file=Forum&amp;page=viewforum&amp;forum_id=' . $forum_id . '"><img src="' . $forum_image . '"/></a></div></td>';
        }
							echo '<td onclick="document.location="index.php?file=Forum&amp;page=viewforum&amp;forum_id=' . $forum_id . '">
							<a href="index.php?file=Forum&amp;page=viewforum&amp;forum_id=' . $forum_id . '">' . $nom . '</a><br />' . $comment . '</td>';

						$sql_page = mysql_query("SELECT thread_id FROM " . FORUM_MESSAGES_TABLE . " WHERE thread_id = '" . $thid . "'");
						$nb_rep = mysql_num_rows($sql_page);

						if ($nb_rep > $nuked['mess_forum_page'])
						{
							$topicpages = $nb_rep / $nuked['mess_forum_page'];
							$topicpages = ceil($topicpages);
							$link_post = "index.php?file=Forum&amp;page=viewtopic&amp;forum_id=" . $forum_id . "&amp;thread_id=" . $thid . "&amp;p=" . $topicpages . "#" . $mess_id;
						} 
						else
						{
							$link_post = "index.php?file=Forum&amp;page=viewtopic&amp;forum_id=" . $forum_id . "&amp;thread_id=" . $thid . "#" . $mess_id;
						} 

						echo '<td>' . $num_post . '</td><td>' . $num_mess . '</td><td> ';

										if ($num_mess > 0)
										{
											if ($auteur_id != "")
											{
												$sq_user = mysql_query("SELECT pseudo, country, rang  FROM " . USER_TABLE . " WHERE id = '" . $auteur_id . "'");
												$test = mysql_num_rows($sq_user);
												list($author, $country, $autor_rank) = mysql_fetch_array($sq_user);
                        
                        if ($nuked['profil_details'] == "on")
                        { 
                        $sql_rank_team_autor = mysql_query("SELECT couleur FROM " . TEAM_RANK_TABLE . " WHERE id = '" . $autor_rank . "'");
                        list($thecolor) = mysql_fetch_array($sql_rank_team_autor);
                        $rank_color_autor = "style=\"color: #" . $thecolor . ";\""; 
                        } else {$rank_color_autor = "";}

												if ($test > 0 && $author != "")
												{
													$autor = $author;
												} 
												else
												{
													$autor = $auteur;
												} 
											} 
											else
											{
												$autor = $auteur;
											} 

												if (strftime("%d %m %Y", time()) ==  strftime("%d %m %Y", $date)) $date = _FTODAY . "&nbsp;" . strftime("%H:%M", $date);
												else if (strftime("%d", $date) == (strftime("%d", time()) - 1) && strftime("%m %Y", time()) == strftime("%m %Y", $date)) $date = _FYESTERDAY . "&nbsp;" . strftime("%H:%M", $date);    
												else $date = _THE . "&nbsp;" . nkDate($date);

												echo $date . "<br />";
												echo _IN . "&nbsp;<span style=\"font-size:9px;\">" . $titre_topic . "</span><br />";

												if ($auteur_id != "")
												{
                        echo _BY . "<a href=\"index.php?file=Members&amp;op=detail&amp;autor=" . urlencode($autor) . "\" " . $rank_color_autor . "><b> " . $autor . "</b></a>";
												} 
												else
												{
													echo _BY . "<b>" . $autor . "</b>";
												} 

											echo "&nbsp;<a href=\"" . $link_post . "\"><img style=\"border: 0;\" src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/icon_latest_reply.png\" alt=\"\" title=\"" . _SEELASTPOST . "\" /></a>";
										} 
										else
										{
											echo _NOPOST;
										} 
						echo '</td></tr>';
					} 
				}
				else
				{
					echo '<tr><td colspan="5">' . _NOFORUM . '</td>';
				}	

echo '</tbody></table></div>';
} 

echo '</div>';

echo '<div class="forumfooter"><div class="linksfooter">';
	if ($user)
	{
	echo '<a href="index.php?file=Forum&amp;op=mark">' . _MARKREAD . '</a>';
	} 
	if ($user && $user[4] != "")
	{
	echo '<br /><a href="index.php?file=Forum&amp;page=search&amp;do=search&amp;date_max=' . $user[4] . '">' . _VIEWLASTVISITMESS . '</a>';
	} 
echo '</div>';

$nb = nbvisiteur();

    $sql_tmessage = mysql_query("SELECT id FROM " . FORUM_MESSAGES_TABLE . " ");
    $nb_tmessage = mysql_num_rows($sql_tmessage);
    
    $sql_tusers = mysql_query("SELECT id FROM " . USER_TABLE . " ");
    $nb_tusers = mysql_num_rows($sql_tusers);
    
    $sql_luser = mysql_query("SELECT pseudo FROM " . USER_TABLE . " ORDER BY date DESC LIMIT 1");
    list($last_user) = mysql_fetch_array($sql_luser);

if($nuked['forum_who_secondaire'] == "oui")	
{
echo '<div class="block-widget"><div class="block-widget-header">' . _FWHOISONLINE . '</div><div class="block-widget-content">
<table class="table table-striped table-condensed">
<tr><td>' . _MEMBERTOTALMESSAGES . '&nbsp;<b>' . $nb_tmessage . '</b>&nbsp;' . _MESSAGES2 . '</td></tr>
<tr><td>'. _WEHAVE . '&nbsp;<b>' . $nb_tusers . '</b>&nbsp;' . _REGISTEREDUSERS . '</td></tr>
<tr><td>'. _LASTREGISTEREDUSER . '&nbsp;<b>&nbsp;<a href="index.php?file=Members&amp;op=detail&amp;autor=' . $last_user . '"><b>' . $last_user . '</b></a></td></tr>'; 
if ($nuked['profil_details'] == "on")
{   
  echo '<tr><td>' . _RANKLEGEND . '&nbsp;:&nbsp;';
  $sql_rank_team = mysql_query("SELECT titre, couleur FROM " . TEAM_RANK_TABLE . " ORDER BY ordre LIMIT 0, 20");
  while (list($rank_titre, $rank_color) = mysql_fetch_array($sql_rank_team))
  {	
      $rank_color1 = "style=\"color: #" . $rank_color . ";\"";
      echo "[&nbsp;<span " . $rank_color1 . "><b>" . $rank_titre . "</b></span>&nbsp;]&nbsp;";
  }  
  echo '</td></tr>';
}


echo '<tr><td>' . _THEREARE . '&nbsp;' . $nb[0] . '&nbsp;' . _FVISITORS . ', ' . $nb[1] . '&nbsp;' . _FMEMBERS . '&nbsp;' . _AND . '&nbsp;' . $nb[2] . '&nbsp;' . _FADMINISTRATORS . '&nbsp;' . _ONLINE . '</td></tr>
 <tr><td>' . _MEMBERSONLINE . ' : ';

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
echo '</td></tr><tr><td>' . _MODO . ' :</b>&nbsp;<small>' . $lienmodo . '</td></tr>';

if (mysql_num_rows($online) == NULL) echo '<em>' . _NONE . '</em>';

// Les anniversaires //
if ($nuked['birthday_forum'] == "on")
{
	  echo '<tr><td>';
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
		echo "" . _TODAY . ", ";
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
	echo '</td></tr>';
}		
// Fin anniversaire

echo '</table></div></div>';
}	
	
echo "	<table class=\"Forum_info_t\" cellspacing=\"0\">\n"
	. "		<tr class=\"Forum_info_r1\">\n"
	. "			<td class=\"Forum_info_d1\"><img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/forum_new.png\" alt=\"\" /></td>\n"
	. "			<td class=\"Forum_info_d2\">&nbsp;" . _NEWSPOSTLASTVISIT . "</td>\n"
	. "		</tr>\n"
	. "		<tr class=\"Forum_info_r2\">\n"
	. "			<td class=\"Forum_info_d3\"><img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/images/forum.png\" alt=\"\" /></td>\n"
	. "			<td class=\"Forum_info_d4\">&nbsp;" . _NOPOSTLASTVISIT . "</td>\n"
	. "		</tr>\n"
	. "</table>\n";
	
	
echo '</div></div></div>';	
closetable();
?>
