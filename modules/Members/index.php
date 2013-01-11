<?php 
// -------------------------------------------------------------------------//
// Nuked-KlaN - PHP Portal                                                  //
// http://www.nuked-klan.org                                                //
// -------------------------------------------------------------------------//
// This program is free software. you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License.           //
// -------------------------------------------------------------------------//
if (!defined("INDEX_CHECK")){
    die ('<div>You cannot open this page directly</div>');
} 

global $language, $user;
translate("modules/User/lang/" . $language . ".lang.php");
translate("modules/Members/lang/" . $language . ".lang.php");

$visiteur = !$user ? 0 : $user[1];

$ModName = basename(dirname(__FILE__));
$level_access = nivo_mod($ModName);
if ($visiteur >= $level_access && $level_access > -1){
    compteur("Members");

    function index(){
        global $bgcolor1, $bgcolor2, $bgcolor3, $theme, $nuked;

        $nb_membres = $nuked['max_members'];

        if ($_REQUEST['letter'] == "Autres"){
            $and = "AND pseudo NOT REGEXP '^[a-zA-Z].'";
        } 
        else if ($_REQUEST['letter'] != "" && preg_match("`^[A-Z]+$`", $_REQUEST['letter'])){
            $and = "AND pseudo LIKE '" . $_REQUEST['letter'] . "%'";
        } 
        else{
            $and = "";
        } 

        $sql2 = mysql_query("SELECT pseudo FROM " . USER_TABLE . " WHERE niveau > 0 " . $and);
        $count = mysql_num_rows($sql2);

        if (!$_REQUEST['p']) $_REQUEST['p'] = 1;
        $start = $_REQUEST['p'] * $nb_membres - $nb_membres;


        echo '<div id="Members"><div class="memberstitre">' . _SITEMEMBERS . '</div>';

        $alpha = array ("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "" . _OTHER . "");

        echo '<div class="btn-group"><a class="btn" href="index.php?file=Members">' . _ALL . '</a>';

        foreach($alpha as $lettre){
            echo '<a class="btn" href="index.php?file=Members&amp;letter=' . $lettre . '">' . $lettre . '</a>';
        } 

        echo '</div><div class="membersliste">';

        if ($count > $nb_membres){
            $url_members = "index.php?file=Members&amp;letter=" . $_REQUEST['letter'];
            number($count, $nb_membres, $url_members);
        } 

	    $sql_config = mysql_query("SELECT mail, icq, msn, aim, yim, xfire, facebook, originea, steam, twiter, skype, lien FROM ". $nuked['prefix'] ."_users_config");
		list($c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12) = mysql_fetch_array($sql_config);

				echo '<table><thead><tr>'
				. '<td>'. _NICK . '</td>';
				if ($c1 == 'on'){echo '<td>' . _MAIL . '</td>';}
				if ($c2 == 'on'){echo '<td>' . _ICQ . '</td>';}
				if ($c3 == 'on'){echo '<td>' . _MSN . '</td>';}
				if ($c4 == 'on'){echo '<td>' . _AIM . '</td>';}
				if ($c5 == 'on'){echo '<td>' . _YIM . '</td>';}
				if ($c6 == 'on'){echo '<td>' . _XFIRE . '</td>';}
				if ($c7 == 'on'){echo '<td>' . _FACEBOOK . '</td>';}
				if ($c8 == 'on'){echo '<td>' . _ORIGINEA . '</td>';}
				if ($c9 == 'on'){echo '<td>' . _STEAM . '</td>';}
				if ($c10 == 'on'){echo '<td>' . _TWITER . '</td>';}	
				if ($c11 == 'on'){echo '<td>' . _SKYPE . '</td>';}
				if ($c12 == 'on'){echo '<td>' . _URL . '</td>';}
				echo '</tr></thead><tbody>';

        $sql = mysql_query("SELECT pseudo, url, email, icq, msn, aim, yim, rang, country, xfire, facebook ,origin, steam, twitter, skype FROM " . USER_TABLE . " WHERE niveau > 0 " . $and . " ORDER BY pseudo LIMIT " . $start . ", " . $nb_membres);
        while (list($pseudo, $url, $email, $icq, $msn, $aim, $yim, $rang, $country, $xfire, $facebook ,$origin, $steam, $twitter, $skype) = mysql_fetch_array($sql)){
            list ($pays, $ext) = explode ('.', $country);

            if ($url != "" && preg_match("`http://`i", $url)){
                $home = '<a href="' . $url . '" title="' . $url . '" onclick="window.open(this.href); return false;"><img src="images/user/url.png" alt="" title="' . $url . '" /></a>';
            } 

            if (is_file('themes/' . $theme . '/images/mail.png')){
                $img = 'themes/' . $theme . '/images/mail.png';
            } 
            else{
                $img = 'images/user/email.png';
            }

            echo '<tr>
				  <td>
				  <img src="images/flags/' . $country . '" alt="" title="' . $pays . '" />  
				  <a href="index.php?file=Members&amp;op=detail&amp;autor=' . urlencode($pseudo) . '" title="' . _VIEWPROFIL . '">' . $pseudo . '</a>
				  </td>';
			
			if ($c1 == 'on')
		{
			echo '<td>';

            if ($email != ""){
                echo '<a href="mailto:"' . $email . '"><img src="' . $img . '" alt="" title="' . $email . '" /></a></td>';
            } 
            else{
                echo '<img src="images/user/emailna.png" alt=""/></td>';
            } 
		}
            if ($c2 == 'on')
		{
            echo '<td>';

            if ($icq != ""){
                echo '<a href="http://web.icq.com/whitepages/add_me?uin=' . $icq . '&amp;action=add"><img src="images/user/icq.png" alt="" title="' . $icq . '" /></a></td>';
            } 
            else{
                echo '<img src="images/user/icqna.png" alt=""/></td>';
            } 
		}
		    if ($c3 == 'on')
		{
            echo '<td>';

            if ($msn != ""){
                echo '<a href="mailto:' . $msn . '"><img src="images/user/msn.png" alt="" title="' . $msn . '" /></a></td>';
            } 
            else{
                echo '<img src="images/user/msnna.png" alt=""></td>';
            } 
		}
		    if ($c4 == 'on')
		{
            echo '<td>';

            if ($aim != ""){
                echo '<a href="aim:goim?screenname=' . $aim . '&amp;message=Hi+' . $aim . '+Are+you+there+?"><img src="images/user/aim.png" alt="" title="' . $aim . '" /></a></td>';
            } 
            else{
                echo '<img src="images/user/aimna.png" alt=""/></td>';
            } 
		}
		    if ($c5 == 'on')
		{
            echo '<td>';

            if ($yim != ""){
                echo '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $yim . '&amp;.src=pg"><img  src="images/user/yahoo.png" alt="" title="' . $yim . '" /></a></td>';
            } 
            else{
                echo '<img  src="images/user/yahoona.png" alt=""/></td>';
            } 
		}
		
			if ($c6 == 'on')
		{
            echo '<td>';

            if ($xfire != ""){
                echo '<a href="xfire:add_friend?user=' . $xfire . '"><img  src="images/user/xfire.png" alt="" title="' . $xfire . '" /></a></td>';
            } 
            else{
                echo '<img  src="images/user/xfirena.png" alt=""/></td>';
            } 
		}
		
			if ($c7 == 'on')
		{
            echo '<td>';

            if ($facebook != ""){
                echo '<a href="http://www.facebook.com/' . $facebook . '"><img  src="images/user/facebook.png" alt="" title="' . $facebook . '" /></a></td>';
            } 
            else{
                echo '<img  src="images/user/facebookna.png" alt=""/></td>';
            } 
		}
		
			if ($c8 == 'on')
		{
            echo '<td>';

            if ($origin != ""){
                echo '<img src="images/user/origin.png" alt="" title="' . $origin . '" /></td>';
            } 
            else{
                echo '<img src="images/user/originna.png" alt="" /></td>';
            } 
		}
		
			if ($c9 == 'on')
		{
            echo '<td>';

            if ($steam != ""){
                echo '<a href="http://steamcommunity.com/actions/AddFriend/'. $steam . '"><img  src="images/user/steam.png" alt="" title="' . $steam . '" /></a></td>';
            } 
            else{
                echo '<img src="images/user/steamna.png" alt="" /></td>';
            } 
		}
		
			if ($c10 == 'on')
		{
            echo '<td>';

            if ($twitter != ""){
                echo '<a href="http://twitter.com/#!/' . $twitter . '"><img src="images/user/twitter.png" alt="" title="' . $twitter . '" /></a></td>';
            } 
            else{
                echo '<img src="images/user/twitterna.png" alt=""/></td>';
            } 
		}
		
			if ($c11 == 'on')
		{
            echo '<td>';

            if ($skype != ""){
                echo '<a href="skype:' . $skype . '?call\"><img  src="images/user/skype.png" alt="" title="' . $skype . '" /></a></td>';
            } 
            else{
                echo '<img src="images/user/skypena.png" alt=""/></td>';
            } 
		}
		
			if ($c12 == 'on')
		{
            echo '<td>';

            if ($url != ""){
				
                echo '' . $home . '</td>';
            } 
            else{
                echo '<img  src="images/user/urlna.png" alt=""/></td>';
            } 
		}
        } 

        if ($count == 0){
            echo '<tr><td colspan="8">' . _NOMEMBERS . '</td></tr>';
        }
		
        echo '</table>';

        if ($count > $nb_membres){
            $url_members = "index.php?file=Members&amp;letter=" . $_REQUEST['letter'];
            number($count, $nb_membres, $url_members);
        } 

        $date_install = nkDate($nuked['date_install']);

        if ($_REQUEST['letter'] != ""){
            $_REQUEST['letter'] = htmlentities($_REQUEST['letter']);
            $_REQUEST['letter'] = nk_CSS($_REQUEST['letter']);

            echo '<div class="modulefooter">' . $count . '&nbsp;' . _MEMBERSFOUND . ' ' . $_REQUEST['letter'] . '</div>';
        } 
        else{
            echo '<div class="modulefooter">' . _THEREARE . '&nbsp;' . $count . '&nbsp;' . _MEMBERSREG . '&nbsp;' . $date_install . ' - ';

            if ($count > 0){
                $sql_member = mysql_query("SELECT pseudo FROM " . USER_TABLE . " ORDER BY date DESC LIMIT 0, 1");
                list($member) = mysql_fetch_array($sql_member);
                echo _LASTMEMBER . ' <a href="index.php?file=Members&amp;op=detail&amp;autor=' . urlencode($member) . '">' . $member . '</a></div>';
            } 
            else{
                echo '</div>';
            } 
	}
	echo '</div></div>';

        closetable();
    } 

    function detail($autor){
        global $nuked, $user, $visiteur;
		opentable();
		echo '<div id="Profile">';
		
        $autor = htmlentities($autor, ENT_QUOTES);

			$sql_config = mysql_query("SELECT nivoreq FROM ". $nuked['prefix'] ."_users_config");
		list($nivoreq) = mysql_fetch_array($sql_config);

        $sql = mysql_query("SELECT U.id, U.icq, U.msn, U.aim, U.yim, U.email, U.url, U.date, U.country, U.xfire, U.facebook , U.origin, U.steam, U.twitter, U.skype, S.date FROM " . USER_TABLE . " AS U LEFT OUTER JOIN " . SESSIONS_TABLE . " AS S ON U.id = S.user_id WHERE U.pseudo = '" . $autor . "'");
        $test = mysql_num_rows($sql);

        if ($test > 0){
            list($id_user, $icq, $msn, $aim, $yim, $email, $url, $date, $country, $xfire, $facebook, $origin, $steam, $twitter, $skype, $last_used) = mysql_fetch_array($sql);
            list ($pays, $ext) = explode ('.', $country);

            if ($email != ""){
                $mail = '<a href="mailto:' . $email . '">' . $email . '</a>';
            } 
            else{
                $mail = '';
            } 

            $sql2 = mysql_query("SELECT prenom, age, sexe, ville, motherboard, cpu, ram, video, resolution, son, ecran, souris, clavier, connexion, system, photo FROM " . USER_DETAIL_TABLE . " WHERE user_id = '" . $id_user . "'");
            list($prenom, $birthday, $sexe, $ville, $motherboard, $cpu, $ram, $video, $resolution, $sons, $ecran, $souris, $clavier, $connexion, $osystem, $photo) = mysql_fetch_array($sql2);
			
			$sql4 = mysql_query("SELECT id FROM " . COMMENT_TABLE . " WHERE autor_id = '" . $id_user . "'");
			$nb_comment = mysql_num_rows($sql4);
			
			
			$date = nkDate($date);
			$last_used > 0 ? $last_used=nkDate($last_used) : $last_used='';            

            $titre = htmlentities($titre);
            $pref_1 = htmlentities($pref_1);
            $pref_2 = htmlentities($pref_2);
            $pref_3 = htmlentities($pref_3);
            $pref_4 = htmlentities($pref_4);
            $pref_5 = htmlentities($pref_5);

            if ($birthday != ""){
                list ($jour, $mois, $an) = explode ('/', $birthday);
                $age = date("Y") - $an;
				
                if (date("m") < $mois){
                    $age = $age - 1;
                }
				
                if (date("d") < $jour && date("m") == $mois){
                    $age = $age - 1;
                } 
            } 
            else{
                $age = "";
            } 

            if ($sexe == "male"){
              $sex = _MALE;
            } 
            else if ($sexe == "female"){
                $sex = _FEMALE;
            } 
            else{
                $sex = "";
            } 
			echo '<div class="profilegauche">';
			if ($visiteur == 9){
				echo '<div class="editionprofil">';
               echo '<a class="btn btn-small" href="index.php?file=Admin&amp;page=user&amp;op=edit_user&amp;id_user=' . $id_user . '"> <i class="icon-pencil"></i>' . _EDIT . '</a>';
            
	            if ($id_user != $user[0]){
	                echo "<script type=\"text/javascript\">\n"
							."<!--\n"
							."\n"
							. "function deluser(pseudo, id)\n"
							. "{\n"
							. "if (confirm('" . _DELETEUSER . " '+pseudo+' ! " . _CONFIRM . "'))\n"
							. "{document.location.href = 'index.php?file=Admin&page=user&op=del_user&id_user='+id;}\n"
							. "}\n"
							. "\n"
							. "// -->\n"
							. "</script>\n";

	            	echo '<a class="btn btn-small btn-danger" href="javascript:deluser(' . mysql_real_escape_string(stripslashes($autor)) . ', ' . $id_user . ');"> <i class="icon-trash icon-white"></i>'. _DELETE . '</a>';
	            }
				echo '</div>';
			} 
			echo '<div class="avatar">';
			if ($photo != ""){
				echo '<img class="img-polaroid" src="' . checkimg($photo) . '" alt="" />';
			} 
			else{
				echo '<img class="img-polaroid" src="modules/User/images/noavatar.png" alt="" />';
			}
			echo '</div>';
			if ($user){
                echo '<a class="btn btn-block btn-primary" href="index.php?file=Userbox&amp;op=post_message&amp;for=' . $id_user . '">' . _REQUESTPV . '</a>';
            }
			
			echo '<a class="btn btn-block" href="index.php?file=Search&amp;op=mod_search&amp;autor=' . $autor . '">' . _FINDSTUFF . '</a>';
			echo '<div class="block-widget"><div class="block-widget-header">' . _INFOPERSO . '</div><div class="block-widget-content"><table class="table table-striped table-condensed">';
			echo '<tr><td>' . _NICK . ' :</td><td><img src="images/flags/' . $country . '" alt="' . $pays . '" /> ' . $autor . '</td></tr>';
			
			if ($prenom) echo '<tr><td>' . _LASTNAME . ' :</td><td>' . $prenom . '</td></tr>';
			if ($age) echo '<tr><td>' . _AGE . '</td><td>' . $age . '</td></tr>';
			if ($sex) echo '<tr><td>' . _SEXE . '</td><td>' . $sex . '</td></tr>';
			if ($ville) echo '<tr><td>' . _CITY . '</td><td>' . $ville . '</td></tr>';
			if ($pays) echo '<tr><td>' . _COUNTRY . '</td><td>' . $pays . '</td></tr>';
			if ($date) echo '<tr><td>' . _DATEUSER . '</td><td>' . $date . '</td></tr>';
			if ($last_used) echo '<tr><td>' . _LASTVISIT . '</td><td>' . $last_used . '</td></tr>';
			
			echo '</table></div></div>';
			
			if ($visiteur >= $nivoreq)
{			if ( $mail || $url || $icq || $msn || $aim || $yim || $xfire || $facebook || $origin || $steam || $twitter || $skype ){
			echo '<div class="block-widget"><div class="block-widget-header">' . _INFOCONTACT . '</div><div class="block-widget-content"><table class="table table-striped table-condensed">';
			if ($mail) echo '<tr><td>' . _MAIL . '</td><td>' . $mail . '</td></tr>';
			if ($url && preg_match("`http://`i", $url)) echo '<tr><td>' . _URL . ' :</td><td><a href="' . $url . '" onclick="window.open(this.href); return false;">' . $url . '</a></td></tr>';
			if ($icq) echo '<tr><td>' . _ICQ . ' :</td><td><a href="http://web.icq.com/whitepages/add_me?uin=' . $icq . '&amp;action=add">' . $icq . '</a></td></tr>';
			if ($msn) echo '<tr><td>' . _MSN . ' :</td><td><a href="mailto: . $msn . ">' . $msn . '</a></td></tr>';
			if ($aim) echo '<tr><td>' . _AIM . ' :</td><td><a href="aim:goim?screenname=' . $aim . '&amp;message=Hi+' . $aim . '+Are+you+there+?">' . $aim . '</a></td></tr>';               
			if ($yim) echo '<tr><td>' . _YIM . ' :</td><td><a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $yim . '&amp;.src=pg">' . $yim . '</a></td></tr>';
			if ($xfire) echo '<tr><td>' . _XFIRE . ' :</td><td><a href="xfire:add_friend?user=' . $xfire . '">' . $xfire . '</a></td></tr>';
			if ($facebook) echo '<tr><td>' . _FACEBOOK . ' :</td><td><a href="http://www.facebook.com/' . $facebook . '">' . $facebook . '</a></td></tr>';
			if ($origin) echo '<tr><td>' . _ORIGINEA . ' :</td><td><a href="#">' . $origin. '</a></td></tr>';
			if ($steam) echo '<tr><td>' . _STEAM . ' :</td><td><a href="#">' . $steam . '</a></td></tr>';
			if ($twitter) echo '<tr><td>' . _TWITER . ' :</td><td><a href="http://twitter.com/#!/' . $twitter . '">' . $twitter . '</a></td></tr>';
			if ($skype) echo '<tr><td>' . _SKYPE . ' :</td><td><a href="skype:' . $skype . '?call">' . $skype . '</a></td></tr>';
			echo '</table></div></div>';
 			}
			echo '</div><div class="profiledroit">';	
			if ( $cpu || $ram || $motherboard || $video || $resolution || $sons || $souris || $clavier || $ecran || $osystem || $connexion ){
				echo '<div class="block-widget"><div class="block-widget-header">' . _HARDCONFIG . '</div><div class="block-widget-content"><table class="table table-striped table-condensed">';
				
				if ($cpu) echo '<tr><td>' . _PROCESSOR . ' :</td><td>' . $cpu . '</td></tr>';
				if ($ram) echo '<tr><td>' . _MEMORY . ' :</td><td>' . $ram . '</td></tr>';
				if ($motherboard) echo '<tr><td>' . _MOTHERBOARD . ' :</td><td>' . $motherboard . '</td></tr>';
				if ($video) echo '<tr><td>' . _VIDEOCARD . ' :</td><td>' . $video . '</td></tr>';
				if ($resolution) echo '<tr><td>' . _RESOLUTION . ' :</td><td>' . $resolution . '</td></tr>';
				if ($sons) echo '<tr><td>' . _SOUNDCARD . ' :</td><td>' . $sons . '</td></tr>';
				if ($souris) echo '<tr><td>' . _MOUSE . ' :</td><td>' . $souris . '</td></tr>';
				if ($clavier) echo '<tr><td>' . _KEYBOARD . ' :</td><td>' . $clavier . '</td></tr>';
				if ($ecran) echo '<tr><td>' . _MONITOR . ' :</td><td>' . $ecran . '</td></tr>';
				if ($osystem) echo '<tr><td>' . _SYSTEMOS . ' :</td><td>' . $osystem . '</td></tr>';
				if ($connexion) echo '<tr><td>' . _CONNECT . ' :</td><td>' . $connexion . '</td></tr>';
				echo '</table></div></div>';
			}
			echo '<div class="block-widget"><div class="block-widget-header">' . _PREFGAMES . '</div><div class="block-widget-content">
			<table class="table table-striped"><thead><tr><td>' . _NAME . '</td></tr></thead><tbody>';
			$sql = mysql_query("SELECT game FROM " . GAMES_PREFS_TABLE . " WHERE user_id = '" . $id_user . "'");
			$check = mysql_num_rows($sql);
			if($check > 0) {
			while (list($games) = mysql_fetch_array($sql)){
			$sql1 = mysql_query("SELECT name FROM " . GAMES_TABLE . " WHERE id = '" . $games . "'");
			while (list($nom) = mysql_fetch_array($sql1)){
			echo '<tr><td>' . $nom . '</td></tr>';
			}
			}
			}
			else {
				echo '<tr><td colspan="3">' . _NOGAMESINLIST .'</td></tr>';
			}
			echo '</tbody></table></div></div>';
			}
			
			echo '<div class="block-widget"><div class="block-widget-header">' . _LASTUSERMESS . '</div><div class="block-widget-content"><table class="table table-striped">
			<thead><tr><td>#</td><td>' . _TITLE .'</td><td>' . _DATE . '</td></tr></thead><tbody>';
			
			if ($user_data['count'] == 0){
				echo '<tr><td colspan="3">' . _NOUSERMESS . '</td></tr>';
			}
			else{
				$iforum = 0;
				$sql_forum = mysql_query("SELECT id, titre, date, thread_id, forum_id FROM " . FORUM_MESSAGES_TABLE . " WHERE auteur_id = '" . $id_user . "' ORDER BY id DESC LIMIT 0, 10");
				while (list($mid, $subject, $date, $tid, $fid) = mysql_fetch_array($sql_forum)){
					$subject = htmlentities($subject);
					$subject = nk_CSS($subject);
					$date = nkDate($date);
					
					$iforum++;
					
					$sql_page = mysql_query("SELECT id FROM " . FORUM_MESSAGES_TABLE . " WHERE thread_id = '" . $tid . "'");
					$nb_rep = mysql_num_rows($sql_page);
					
					if ($nb_rep > $nuked['mess_forum_page']){
						$topicpages = $nb_rep / $nuked['mess_forum_page'];
						$topicpages = ceil($topicpages);
						$link_REQUEST = "index.php?file=Forum&amp;page=viewtopic&amp;forum_id=" . $fid . "&amp;thread_id=" . $tid . "&amp;p=" . $topicpages . "#" . $mid;
					}
					else{
						$link_REQUEST = "index.php?file=Forum&amp;page=viewtopic&amp;forum_id=" . $fid . "&amp;thread_id=" . $tid . "#" . $mid;
					}
					
					echo '<tr><td>' . $iforum . '</td>
					<td><a href="' . $link_REQUEST . '">' . $subject . '</a></td>
					<td>' . $date . '</td></tr>';
				}
				
				if ($iforum == 0){
					echo '<tr><td colspan="3">' . _NOUSERMESS . '</td></tr>';
				}
			}
			
			echo '</tbody></table></div></div><div class="block-widget"><div class="block-widget-header">' . _LASTUSERCOMMENT . '</div><div class="block-widget-content"><table class="table table-striped">
			<thead><tr><td>#</td><td>' . _TITLE .'</td><td>' . _DATE . '</td></tr></thead><tbody>';
			
			if ($nb_comment == 0){
				echo '<tr><td colspan="3">' . _NOUSERCOMMENT . '</td></tr>';
			}
			else{
				$icom = 0;
				$sql_com = mysql_query("SELECT im_id, titre, module, date FROM " . COMMENT_TABLE . " WHERE autor_id = '" . $id_user . "' ORDER BY id DESC LIMIT 0, 10");
				while (list($im_id, $titre, $module, $date) = mysql_fetch_array($sql_com)){
					$titre = htmlentities($titre);
					$titre = nk_CSS($titre);
					
					if ($titre != ""){
						$title = $titre;
					}
					else{
						$title = $module;
					}
					
					$date = nkDate($date);
					
					$icom++;
					
					if ($module == "news"){
						$link_title = "<a href=\"index.php?file=News&amp;op=index_comment&amp;news_id=" . $im_id . "\">" . $title . "</a>";
					}
					else if ($module == "Gallery"){
						$link_title = "<a href=\"index.php?file=Gallery&amp;op=description&amp;sid=" . $im_id . "\">" . $title . "</a>";
					}
					else if ($module == "Wars"){
						$link_title = "<a href=\"index.php?file=Wars&amp;op=detail&amp;war_id=" . $im_id . "\">" . $title . "</a>";
					}
					else if ($module == "Links"){
						$link_title = "<a href=\"index.php?file=Links&amp;op=description&amp;link_id=" . $im_id . "\">" . $title . "</a>";
					}
					else if ($module == "Download"){
						$link_title = "<a href=\"index.php?file=Download&amp;op=description&amp;dl_id=" . $im_id . "\">" . $title . "</a>";
					}
					else if ($module == "Survey"){
						$link_title = "<a href=\"index.php?file=Survey&amp;op=affich_res&amp;sid=" . $im_id . "\">" . $title . "</a>";
					}
					else if ($module == "Sections"){
						$link_title = "<a href=\"index.php?file=Sections&amp;op=article&amp;artid=" . $im_id . "\">" . $title . "</a>";
					}
					
					echo '<tr><td>' . $icom . '</td><td>' . $link_title . '</td><td>' . $date . '</td></tr>';
				}
			}
			
			echo '</tbody></table></div></div>';
        }
        else{
            echo '<div>' . _NOMEMBER . '</div>';
        } 
		echo '</div></div>';
		closetable();
    } 
	
	function listing($q,$type='right',$limit=100){
		$q	= strtolower($q);
		$q = nk_CSS($q);
		$q = htmlentities($q, ENT_QUOTES);	
		if (!$q) return;
		
		if (!is_numeric($limit)) $limit = 0;
		if ($limit > 0) $str_limit = "LIMIT 0," . $limit;
		else $str_limit = '';
		
		if ($type=='full') $left = '%';
		else $left = '';
		
		$req_list = "SELECT pseudo FROM " . USER_TABLE . " WHERE lower(pseudo) like '" . $left . $q . "%' ORDER BY pseudo DESC " . $str_limit;
		$sql_list = mysql_query($req_list);
		
		while (list($pseudo) = mysql_fetch_array($sql_list)){
			$pseudo = str_replace('|','',$pseudo);
			echo $pseudo . "\n";
		}
	}

    switch ($_REQUEST['op']){
        case"index":
        index();
        break;

        case"detail":
        detail($_REQUEST['autor']);
        break;        
		
		case"list":
        listing($_REQUEST['q'],$_REQUEST['type'],$_REQUEST['limit']);
        break;

        default:
		index();
    } 
} 
else if ($level_access == -1){
    opentable();
    echo '<div>' . _MODULEOFF . '<a href=\"javascript:history.back()\">' . _BACK . '</a></div>';
    closetable();
} 
else if ($level_access == 1 && $visiteur == 0){
    opentable();
    echo '<div>' . _USERENTRANCE . '<a href="index.php?file=User&amp;op=login_screen">' . _LOGINUSER . '</a>
    <a href="index.php?file=User&amp;op=reg_screen">' . _REGISTERUSER . '</a></b></div>';
    closetable();
} 
else{
    opentable();
    echo '<div>' . _NOENTRANCE . '<a href="javascript:history.back()">' . _BACK . '</a></div>';
    closetable();
} 
?>