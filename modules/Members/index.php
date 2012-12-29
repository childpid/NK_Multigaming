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

        $sql2 = mysql_query("SELECT pseudo FROM " . USER_TABLE . " WHERE team = '' AND niveau > 0 " . $and);
        $count = mysql_num_rows($sql2);

        if (!$_REQUEST['p']) $_REQUEST['p'] = 1;
        $start = $_REQUEST['p'] * $nb_membres - $nb_membres;

        opentable();

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

        $sql = mysql_query("SELECT pseudo, url, email, icq, msn, aim, yim, rang, country, xfire, facebook ,origin, steam, twitter, skype FROM " . USER_TABLE . " WHERE team = '' " . $and . " AND niveau > 0 ORDER BY pseudo LIMIT " . $start . ", " . $nb_membres);
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

            echo '<div>' . $count . '&nbsp;' . _MEMBERSFOUND . ' ' . $_REQUEST['letter'] . '</div>';
        } 
        else{
            echo '<div class="modulefooter">' . _THEREARE . '&nbsp;' . $count . '&nbsp;' . _MEMBERSREG . '&nbsp;' . $date_install . ' - ';

            if ($count > 0){
                $sql_member = mysql_query("SELECT pseudo FROM " . USER_TABLE . " WHERE team = '' ORDER BY date DESC LIMIT 0, 1");
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
        global $nuked, $bgcolor1, $bgcolor2, $bgcolor3, $user, $visiteur;

        opentable();

        $autor = htmlentities($autor, ENT_QUOTES);

			$sql_config = mysql_query("SELECT nivoreq FROM ". $nuked['prefix'] ."_users_config");
		list($nivoreq) = mysql_fetch_array($sql_config);

        $sql = mysql_query("SELECT U.id, U.icq, U.msn, U.aim, U.yim, U.email, U.url, U.date, U.game, U.country, U.xfire, U.facebook , U.origin, U.steam, U.twitter, U.skype, S.date FROM " . USER_TABLE . " AS U LEFT OUTER JOIN " . SESSIONS_TABLE . " AS S ON U.id = S.user_id WHERE U.pseudo = '" . $autor . "'");
        $test = mysql_num_rows($sql);

        if ($test > 0){
            list($id_user, $icq, $msn, $aim, $yim, $email, $url, $date, $game_id, $country, $xfire, $facebook, $origin, $steam, $twitter, $skype, $last_used) = mysql_fetch_array($sql);
            list ($pays, $ext) = explode ('.', $country);

            if ($email != ""){
                $mail = '<a href="mailto:' . $email . '">' . $email . '</a>';
            } 
            else{
                $mail = '';
            } 

            $sql2 = mysql_query("SELECT prenom, age, sexe, ville, motherboard, cpu, ram, video, resolution, son, ecran, souris, clavier, connexion, system, photo, pref_1, pref_2, pref_3, pref_4, pref_5 FROM " . USER_DETAIL_TABLE . " WHERE user_id = '" . $id_user . "'");
            list($prenom, $birthday, $sexe, $ville, $motherboard, $cpu, $ram, $video, $resolution, $sons, $ecran, $souris, $clavier, $connexion, $osystem, $photo, $pref1, $pref2, $pref3, $pref4, $pref5) = mysql_fetch_array($sql2);

            $sql3 = mysql_query("SELECT titre, pref_1, pref_2, pref_3, pref_4, pref_5 FROM " . GAMES_TABLE . " WHERE id = '" . $game_id . "'");
            list($titre, $pref_1, $pref_2, $pref_3, $pref_4, $pref_5) = mysql_fetch_array($sql3);
	    
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

            if ($visiteur == 9){
               echo '<div><a href="index.php?file=Admin&amp;page=user&amp;op=edit_user&amp;id_user=' . $id_user . '"><img  src="images/edition.gif" alt="" title="' . _EDIT . '" /></a>';
            
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

	            	echo '<a href="javascript:deluser(' . mysql_real_escape_string(stripslashes($autor)) . ', ' . $id_user . ');"><img  src="images/delete.gif" alt="" title="' . _DELETE . '" /></a>';
	            }
				
			echo '</div>';
			} 
			echo '<table>
				  <tr><td>' . _INFOPERSO . '</td></tr>
				  <tr><td><table>
			      <tr><td><b>&nbsp;&nbsp;»' . _NICK . '&nbsp;:&nbsp;</b></td><td><img src="images/flags/' . $country . '" alt="' . $pays . '" />&nbsp;' . $autor . '</td></tr>';
			
			if ($prenom) echo "<tr><td><b>&nbsp;&nbsp;» " . _LASTNAME . "&nbsp;:&nbsp;</b></td><td>" . $prenom . "</td></tr>\n";
			if ($age) echo "<tr><td><b>&nbsp;&nbsp;» " . _AGE . "&nbsp;:&nbsp;</b></td><td>" . $age . "</td></tr>\n";
			if ($sex) echo "<tr><td><b>&nbsp;&nbsp;» " . _SEXE . "&nbsp;:&nbsp;</b></td><td>" . $sex . "</td></tr>\n";
			if ($ville) echo "<tr><td><b>&nbsp;&nbsp;» " . _CITY . "&nbsp;:&nbsp;</b></td><td>" . $ville . "</td></tr>\n";
			if ($pays) echo "<tr><td><b>&nbsp;&nbsp;» " . _COUNTRY . "&nbsp;:&nbsp;</b></td><td>" . $pays . "</td></tr>\n";
			
if ($visiteur >= $nivoreq)
{			
			if ($mail) echo "<tr><td><b>&nbsp;&nbsp;» " . _MAIL . "&nbsp;:&nbsp;</b></td><td>" . $mail . "</td></tr>\n";
			if ($url && preg_match("`http://`i", $url)) echo "<tr><td><b>&nbsp;&nbsp;» " . _URL . "&nbsp;:&nbsp;</b></td><td><a href=\"" . $url . "\" onclick=\"window.open(this.href); return false;\">" . $url . "</a></td></tr>\n";
			if ($icq) echo "<tr><td><b>&nbsp;&nbsp;» " . _ICQ . "&nbsp;:&nbsp;</b></td><td><a href=\"http://web.icq.com/whitepages/add_me?uin=" . $icq . "&amp;action=add\">" . $icq . "</a></td></tr>"; 
			if ($msn) echo "<tr><td><b>&nbsp;&nbsp;» " . _MSN . "&nbsp;:&nbsp;</b></td><td><a href=\"mailto:" . $msn . "\">" . $msn . "</a></td></tr>";
			if ($aim) echo "<tr><td><b>&nbsp;&nbsp;» " . _AIM . "&nbsp;:&nbsp;</b></td><td><a href=\"aim:goim?screenname=" . $aim . "&amp;message=Hi+" . $aim . "+Are+you+there+?\">" . $aim . "</a></td></tr>";                
			if ($yim) echo "<tr><td><b>&nbsp;&nbsp;» " . _YIM . "&nbsp;:&nbsp;</b></td><td><a href=\"http://edit.yahoo.com/config/send_webmesg?.target=" . $yim . "&amp;.src=pg\">" . $yim . "</a></td></tr>";
			if ($xfire) echo "<tr><td><b>&nbsp;&nbsp;» " . _XFIRE . "&nbsp;:&nbsp;</b></td><td><a href=\"xfire:add_friend?user=" . $xfire . "\">" . $xfire . "</a></td></tr>";
			if ($facebook) echo "<tr><td><b>&nbsp;&nbsp;» " . _FACEBOOK . "&nbsp;:&nbsp;</b></td><td><a href=\"http://www.facebook.com/" . $facebook . "\">" . $facebook . "</a></td></tr>";
			if ($origin) echo "<tr><td><b>&nbsp;&nbsp;» " . _ORIGINEA . "&nbsp;:&nbsp;</b></td><td><a href=\"#\">" . $origin. "</a></td></tr>";
			if ($steam) echo "<tr><td><b>&nbsp;&nbsp;» " . _STEAM . "&nbsp;:&nbsp;</b></td><td><a href=\"#\">" . $steam . "</a></td></tr>";
			if ($twitter) echo "<tr><td><b>&nbsp;&nbsp;» " . _TWITER . "&nbsp;:&nbsp;</b></td><td><a href=\"http://twitter.com/#!/" . $twitter . "\">" . $twitter . "</a></td></tr>";
			if ($skype) echo "<tr><td><b>&nbsp;&nbsp;» " . _SKYPE . "&nbsp;:&nbsp;</b></td><td><a href=\"skype:" . $skype . "?call\">" . $skype . "</a></td></tr>";
 }
			if ($date) echo "<tr><td><b>&nbsp;&nbsp;» " . _DATEUSER . "&nbsp;:&nbsp;</b></td><td>" . $date . "</td></tr>";
			if ($last_used) echo "<tr><td><b>&nbsp;&nbsp;» " . _LASTVISIT . "&nbsp;:&nbsp;</b></td><td>" . $last_used . "</td></tr>";
			
			echo '</table></td><td>';
			
			if ($photo != ""){
				echo '<img src="' . checkimg($photo) . '" alt="" />';
			} 
			else{
				echo '<img src="modules/Members/images/pas_image.jpg" alt="" />';
			}
			

			
			if ( $cpu || $ram || $motherboard || $video || $resolution || $sons || $souris || $clavier || $ecran || $osystem || $connexion ){
				echo '<tr><td>' . _HARDCONFIG . '</td></tr>
					  <tr><td><table>';
				
				if ($cpu) echo "<tr><td><b>&nbsp;&nbsp;» " . _PROCESSOR . "&nbsp;:&nbsp;</b></td><td>" . $cpu . "</td></tr>\n";
				if ($ram) echo "<tr><td><b>&nbsp;&nbsp;» " . _MEMORY . "&nbsp;:&nbsp;</b></td><td>" . $ram . "</td></tr>\n";
				if ($motherboard) echo "<tr><td><b>&nbsp;&nbsp;» " . _MOTHERBOARD . "&nbsp;:&nbsp;</b></td><td>" . $motherboard . "</td></tr>\n";
				if ($video) echo "<tr><td><b>&nbsp;&nbsp;» " . _VIDEOCARD . "&nbsp;:&nbsp;</b></td><td>" . $video . "</td></tr>\n";
				if ($resolution) echo "<tr><td><b>&nbsp;&nbsp;» " . _RESOLUTION . "&nbsp;:&nbsp;</b></td><td>" . $resolution . "</td></tr>\n";
				if ($sons) echo "<tr><td><b>&nbsp;&nbsp;» " . _SOUNDCARD . "&nbsp;:&nbsp;</b></td><td>" . $sons . "</td></tr>\n";
				if ($souris) echo "<tr><td><b>&nbsp;&nbsp;» " . _MOUSE . "&nbsp;:&nbsp;</b></td><td>" . $souris . "</td></tr>\n";
				if ($clavier) echo "<tr><td><b>&nbsp;&nbsp;» " . _KEYBOARD . "&nbsp;:&nbsp;</b></td><td>" . $clavier . "</td></tr>\n";
				if ($ecran) echo "<tr><td><b>&nbsp;&nbsp;» " . _MONITOR . "&nbsp;:&nbsp;</b></td><td>" . $ecran . "</td></tr>\n";
				if ($osystem) echo "<tr><td><b>&nbsp;&nbsp;» " . _SYSTEMOS . "&nbsp;:&nbsp;</b></td><td>" . $osystem . "</td></tr>\n";
				if ($connexion) echo "<tr><td><b>&nbsp;&nbsp;» " . _CONNECT . "&nbsp;:&nbsp;</b></td><td>" . $connexion . "</td></tr>\n";
				
				echo "</table></td></tr>\n";
			}
			
			if ( $pref1 || $pref2 || $pref3 || $pref4 || $pref5 ){
				echo '<tr><td>' . $titre . ' :</td></tr>';
				echo '<tr><td><table>';
				
				if ($pref1) echo "<tr><td><b>&nbsp;&nbsp;» " . $pref_1 . "&nbsp;:&nbsp;</b></td><td>" . $pref1 . "</td></tr>\n";
				if ($pref2) echo "<tr><td><b>&nbsp;&nbsp;» " . $pref_2 . "&nbsp;:&nbsp;</b></td><td>" . $pref2 . "</td></tr>\n";
				if ($pref3) echo "<tr><td><b>&nbsp;&nbsp;» " . $pref_3 . "&nbsp;:&nbsp;</b></td><td>" . $pref3 . "</td></tr>\n";
				if ($pref4) echo "<tr><td><b>&nbsp;&nbsp;» " . $pref_4 . "&nbsp;:&nbsp;</b></td><td>" . $pref4 . "</td></tr>\n";
				if ($pref5) echo "<tr><td><b>&nbsp;&nbsp;» " . $pref_5 . "&nbsp;:&nbsp;</b></td><td>" . $pref5 . "</td></tr>\n";
				
				echo "</table>";
			}
			
			echo '</td></tr></table><div>';
			
            if ($user){
                echo "&nbsp;[&nbsp;<a href=\"index.php?file=Userbox&amp;op=post_message&amp;for=" . $id_user . "\">" . _SENDPV . "</a>&nbsp;]&nbsp;\n";
            }
			
			echo "&nbsp;[&nbsp;<a href=\"index.php?file=Search&amp;op=mod_search&amp;autor=" . $autor . "\">" . _FINDSTUFF . "</a>&nbsp;]&nbsp;</div><br />\n";
        }
        else{
            echo '<div>' . _NOMEMBER . '</div>';
        } 

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