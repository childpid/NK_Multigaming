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
	
	global $language, $user, $cookie_captcha;
	translate('modules/User/lang/' . $language . '.lang.php');
	translate('modules/Members/lang/' . $language . '.lang.php');
	
	// Inclusion syst�me Captcha
	include_once('Includes/nkCaptcha.php');
	include_once('Includes/hash.php');
	
	// On determine si le captcha est actif ou non
	if (_NKCAPTCHA == 'off') $captcha = 0;
	else if ((_NKCAPTCHA == 'auto' OR _NKCAPTCHA == 'on') && $user[1] > 0)  $captcha = 0;
	else $captcha = 1;
	function leftpannel() {
		global $user, $nuked;
		echo '<div class="profilegauche">';
		$sql3 = mysql_query('SELECT U.pseudo, U.url, U.mail, U.date, U.avatar, U.count, S.last_used FROM ' . USER_TABLE . ' AS U LEFT OUTER JOIN ' . SESSIONS_TABLE . ' AS S ON U.id = S.user_id WHERE U.id = "' . $user[0] . '"');
        $user_data = mysql_fetch_array($sql3);
		$avatar = !$user_data['avatar'] ? 'modules/User/images/noavatar.png' : checkimg($user_data['avatar']);
		$last_used = $user_data['last_used'] > 0 ? nkDate($user_data['last_used']) : 'N/A';
		$website = !$user_data['url'] ? 'N/A' : $user_data['url'];
		echo '<div class="avatar"><img src="' . $avatar .'" class="img-polaroid" ></div>';
		echo '
		<ul class="nav nav-list">
		<li class="nav-header">' . _YOURACCOUNT . '</li>';
		if($_REQUEST['op'] == index) {
			echo '<li class="active"><a href="#">' . _INFO . '</a></li>';
		}
		else {
			echo '<li><a href="index.php?file=User">' . _INFO . '</a></li>';
		}
		if($_REQUEST['op'] == edit_account) {
			echo '<li class="active"><a href="#">' . _PROFIL . '</a></li>';
		}
		else {
			echo '<li><a href="index.php?file=User&amp;op=edit_account">' . _PROFIL . '</a></li>';
		}
		if($_REQUEST['op'] == edit_pref) {
			echo '<li class="active"><a href="#">' ._PREF . '</a></li>';
		}
		else {
			echo '<li><a href="index.php?file=User&amp;op=edit_pref">' . _PREF . '</a></li>';
		}
		if($_REQUEST['op'] == edit_games) {
			echo '<li class="active"><a href="index.php?file=User&amp;op=edit_games">' ._PREFGAMES . '</a></li>';
		}
		else {
			echo '<li><a href="index.php?file=User&amp;op=edit_games">' . _PREFGAMES . '</a></li>';
		}
		if($_REQUEST['op'] == change_theme) {
			echo '<li class="active"><a href="#">' . _THEMESELECT . '</a></li>';
		}
		else {
			echo '<li><a href="index.php?file=User&amp;op=change_theme">' . _THEMESELECT . '</a></li>';
		}
		echo '<li><a href="index.php?file=User&amp;nuked_nude=index&amp;op=logout">' . _USERLOGOUT . '</a></li>
		<li class="nav-header infos">' . _ACCOUNT .'</li>
        <li><b>' . _NICK . ' :</b> ' . $user_data['pseudo'] . '</li>
        <li><b>' . _WEBSITE . ' :</b> ' . $website . '</li>
        <li><b>' . _MAIL . ' :</b> ' . $user_data['mail'] . '</li>
        <li><b>' . _DATEUSER . ' : </b> ' . nkDate($user_data['date'], TRUE) . '</li>
        <li><b>' . _LASTVISIT . ' : </b> ' . $last_used . '</li>
		</ul></div>';
	}
	
	
	function index(){
		global $user, $nuked;
		echo '<div id="User">';
		if ($user){
			opentable();
			leftpannel();
			echo '<div class="profiledroit"><div class="block-widget"><div class="block-widget-header">' .  _MESSPV . '</div><div class="block-widget-content"><table class="table table-striped"><tbody>';
			
			$sql2 = mysql_query('SELECT mid FROM ' . USERBOX_TABLE . ' WHERE user_for = "' . $user[0] . '" AND status = 1');
			$nb_mess_lu = mysql_num_rows($sql2);
			
			$msg_not_read = ($user[5] > 0) ? '<a href="index.php?file=Userbox"><b>' . $user[5] . '</b></a>' : '<b>' . $user[5] . '</b>';
			
			echo '<tr><td>' . _NOTREAD . '</td><td>' . $msg_not_read . '</td></tr>';
			
			$nb_mess_lu = ($nb_mess_lu > 0) ? '<a href="index.php?file=Userbox"><b>' . $nb_mess_lu . '</b></a>' : '<b>' . $nb_mess_lu . '</b>';
			
			echo '<tr><td>' . _READ . '</td><td> ' . $nb_mess_lu . '</td></tr></tbody><tfoot><tr><td colspan="2">
			<a class="btn" href="index.php?file=Userbox">' . _READPV .'</a>
			<a class="btn" href="index.php?file=Userbox&amp;op=post_message">' . _REQUESTPV .'</a>
			</td></tr></tfoot></table></div></div>
			<div class="block-widget"><div class="block-widget-header">' . _YOURSTATS . '</div><div class="block-widget-content"><table class="table table-striped">
			<thead><tr><td>' . _NAME .'</td><td>' . _COUNT . '</td></tr></thead><tbody>';
			
			$sql4 = mysql_query("SELECT id FROM " . COMMENT_TABLE . " WHERE autor_id = '" . $user[0] . "'");
			$nb_comment = mysql_num_rows($sql4);
			
			$sql5 = mysql_query("SELECT id FROM " . SUGGEST_TABLE . " WHERE user_id = '" . $user[0] . "'");
			$nb_suggest = mysql_num_rows($sql5);
			
			echo '<tr><td>' . _MESSINFORUM . '</td><td>' . $user_data['count'] . '</td></tr>
			<tr><td>' . _USERCOMMENT . '</td><td>' . $nb_comment . '</td></tr>
			<tr><td>' . _USERSUGGEST . '</td><td>' . $nb_suggest . '</td></tr></tbody></table></div></div>
			<div class="block-widget"><div class="block-widget-header">' . _LASTUSERMESS . '</div><div class="block-widget-content"><table class="table table-striped">
			<thead><tr><td>#</td><td>' . _TITLE .'</td><td>' . _DATE . '</td></tr></thead><tbody>';
			
			if ($user_data['count'] == 0){
				echo '<tr><td colspan="3">' . _NOUSERMESS . '</td></tr>';
			}
			else{
				$iforum = 0;
				$sql_forum = mysql_query("SELECT id, titre, date, thread_id, forum_id FROM " . FORUM_MESSAGES_TABLE . " WHERE auteur_id = '" . $user[0] . "' ORDER BY id DESC LIMIT 0, 10");
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
				$sql_com = mysql_query("SELECT im_id, titre, module, date FROM " . COMMENT_TABLE . " WHERE autor_id = '" . $user[0] . "' ORDER BY id DESC LIMIT 0, 10");
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
					
					if ($j1 == 0){
						$bg1 = $bgcolor2;
						$j1++;
					}
					else{
						$bg1 = $bgcolor1;
						$j1 = 0;
					}
					
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
			
			echo '</tbody></table></div></div></div></div>';
			closetable();
		}
		else{
			redirect("index.php?file=User&op=login_screen", 0);
		}
		echo '</div>';
	}
	
	function reg_screen(){
		global $nuked, $user, $language, $captcha;
		
		if ($user){
			redirect("index.php?file=User&op=edit_account", 0);
		}
		echo '<div id="user">';
		
		if ($nuked['inscription'] != "off"){
			if ($nuked['inscription_charte'] != "" && !isset($_REQUEST['charte_agree'])){
				$disclaimer = html_entity_decode($nuked['inscription_charte']);
				
				echo "<br /><table style=\"margin-left: auto;margin-right: auto;text-align: left;\" width=\"90%\" cellspacing=\"1\" cellpadding=\"1\" border=\"0\">\n"
				. "<tr><td align=\"center\"><big><b>" . _NEWUSERREGISTRATION . "</b></big></td></tr>\n"
				. "<tr><td>&nbsp;</td></tr><tr><td>" . $disclaimer . "</td></tr></table>\n"
				. "<form method=\"post\" action=\"index.php?file=User&amp;op=reg_screen\">\n"
				. "<div style=\"text-align: center;\"><input type=\"hidden\" name=\"charte_agree\" value=\"1\" />\n"
				. "<input type=\"submit\" value=\"" . _IAGREE . "\" />&nbsp;<input type=\"button\" value=\"" . _IDESAGREE . "\" onclick=\"javascript:history.back()\" /></div></form><br />\n";
			}
			else{
				echo "<script type=\"text/javascript\">\n"
				."<!--\n"
				. "\n"
				."function trim(string)\n"
				."{"
				."return string.replace(/(^\s*)|(\s*$)/g,'');"
				."}\n"
				."\n"
				. "function verifchamps()\n"
				. "{\n"
				. "pseudo = trim(document.getElementById('reg_pseudo').value);\n"
				."\n"
				. "if (pseudo.length < 3)\n"
				. "{\n"
				. "alert('" . _3TYPEMIN . "');\n"
				. "return false;\n"
				. "}\n";
				
				if ($nuked['inscription'] != "mail"){
					echo "\n"
					. "pass = trim(document.getElementById('reg_pass').value);\n"
					. "if (pass.length < 4)\n"
					. "{\n"
					. "alert('" . _4TYPEMIN . "');\n"
					. "return false;\n"
					. "}\n"
					. "\n"
					. "if (document.getElementById('reg_pass').value != document.getElementById('conf_pass').value)\n"
					. "{\n"
					. "alert('" . _PASSFAILED . "');\n"
					. "return false;\n"
					. "}\n";
				}
				
				echo "if (document.getElementById('reg_mail').value.indexOf('@') == -1)\n"
				. "{\n"
				. "alert('" . _MAILFAILED . "');\n"
				. "return false;\n"
				. "}\n"
				. "\n"
				. "return true;\n"
				. "}\n"
				."\n"
				. "// -->\n"
				. "</script>\n";
				
				echo "<link rel=\"stylesheet\" href=\"media/css/checkSecurityPass.css\" type=\"text/css\" media=\"screen\" />\n"
				. "<script type=\"text/javascript\" src=\"media/js/checkSecurityPass.js\"></script>\n"
				. "<br /><div style=\"text-align: center;\"><big><b>" . _NEWUSERREGISTRATION . "</b></big></div><br /><br />\n"
				. "<form method=\"post\" action=\"index.php?file=User&amp;op=reg\" onsubmit=\"return verifchamps();\">\n"
				. "<table style=\"margin-left:auto;margin-right:auto;text-align:left;width:70%;\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\">\n"
				. "<tr><td><b>" . _NICK . "</b> (" . _REQUIRED . ")</td><td><input id=\"reg_pseudo\" type=\"text\" name=\"pseudo\" size=\"30\" maxlength=\"30\" /> *</td></tr>\n";
				
				if ($nuked['inscription'] != "mail"){
					echo "<tr><td><b>" . _USERPASSWORD . "</b> (" . _REQUIRED . ")</td><td><input id=\"reg_pass\" type=\"password\" onkeyup=\"evalPwd(this.value);\" name=\"pass_reg\" size=\"10\" maxlength=\"15\" /> * \n"
					. "<div id=\"sm\">" . _PASSCHECK ." <ul><li id=\"weak\" class=\"nrm\">" ._PASSWEAK . "</li><li id=\"medium\" class=\"nrm\">" ._PASSMEDIUM . "</li><li id=\"strong\" class=\"nrm\">" ._PASSHIGH . "</li></ul></div></td></tr>\n"
					. "<tr><td><b>" . _PASSCONFIRM . "</b> (" . _REQUIRED . ")</td><td><input id=\"conf_pass\" type=\"password\" name=\"pass_conf\" size=\"10\" maxlength=\"15\" /> *</td></tr>\n";
				}
				
				echo "<tr><td><b>" . _MAIL . " " . _PRIVATE . "</b> (" . _REQUIRED . ")</td><td><input id=\"reg_mail\" type=\"text\" name=\"mail\" size=\"30\" maxlength=\"80\" /> *</td></tr>\n"
				. "<tr><td><b>" . _MAIL . " " . _PUBLIC . "</b> (" . _OPTIONAL . ")</td><td><input type=\"text\" name=\"email\" size=\"30\" maxlength=\"80\" /></td></tr>\n"
				. "<tr><td><b>" . _COUNTRY . "</b> (" . _OPTIONAL . ")</td><td><select name=\"country\">";
				
				if ($language == "french"){
					$pays = "France.gif";
				}
				
				$rep = Array();
				$handle = @opendir("images/flags");
				while (false !== ($f = readdir($handle))){
					if ($f != ".." && $f != "." && $f != "index.html" && $f != "Thumbs.db"){
						$rep[] = $f;
					}
				}
				
				closedir($handle);
				sort ($rep);
				reset ($rep);
				
				while (list ($key, $filename) = each ($rep)){
					if ($filename == $pays){
						$checked = "selected=\"selected\"";
					}
					else{
						$checked = "";
					}
					
					list ($country, $ext) = explode ('.', $filename);
					echo "<option value=\"" . $filename . "\" " . $checked . ">" . $country . "</option>\n";
				}
				
				echo "</select></td></tr>\n"
				. "<tr><td><b>" . _GAME . "</b> (" . _OPTIONAL . ")</td><td><select name=\"game\">\n";
				
				$sql = mysql_query("SELECT id, name FROM " . GAMES_TABLE . " ORDER BY name");
				while (list($game_id, $nom) = mysql_fetch_array($sql)){
					$nom = htmlentities($nom);
					echo "<option value=\"" . $game_id . "\">" . $nom . "</option>\n";
				}
				
				echo "</select></td></tr>\n";
				
				if ($captcha == 1) create_captcha(2);
				
				echo "<tr><td colspan=\"2\">&nbsp;</td></tr>\n"
				. "<tr><td colspan=\"2\" align=\"center\"><input class=\"btn\" type=\"submit\" value=\"" . _USERREGISTER . "\" /></td></tr></table></form><br />\n";
			}
		}
		else{
			echo "<br /><br /><div style=\"text-align: center;\">" . _REGISTRATIONCLOSE . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />\n";
		}
		echo '</div>';
	}
	
	function edit_account(){
		global $nuked, $user;
		
		define('EDITOR_CHECK', 1);
		echo '<div id="User">';
		if ($user){
			$sql = mysql_query("SELECT pseudo, pass, url, mail, email, icq, msn, aim, yim, avatar, signature, country, game, xfire, facebook ,origin, steam, twitter, skype FROM " . USER_TABLE . " WHERE id = '" . $user[0] . "'");
			list($nick, $pass, $url, $mail, $email, $icq, $msn, $aim, $yim, $avatar, $signature, $pays, $jeu, $xfire, $facebook ,$origin, $steam, $twitter, $skype) = mysql_fetch_array($sql);
			
			$sql_config = mysql_query("SELECT mail, icq, msn, aim, yim, xfire, facebook, originea, steam, twiter, skype, lien FROM ". $nuked['prefix'] ."_users_config");
			list($c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $c12) = mysql_fetch_array($sql_config);
			
			leftpannel();
			
			echo "<script type=\"text/javascript\">\n"
			."<!--\n"
			."\n"
			. "function verifchamps()\n"
			. "{\n"
			. "\n"
			. "if (document.getElementById('edit_pseudo').value.length < 3)\n"
			. "{\n"
			. "alert('" . _3TYPEMIN . "');\n"
			. "return false;\n"
			. "}\n"
			. "\n"
			. "if (document.getElementById('edit_mail').value.indexOf('@') == -1)\n"
			. "{\n"
			. "alert('" . _MAILFAILED . "');\n"
			. "return false;\n"
			. "}\n"
			. "\n"
			. "return true;\n"
			. "}\n"
			."\n"
			. "// -->\n"
			. "</script>\n";
			
			echo '<div class="profiledroit">
			<div class="alert">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			'. _PASSFIELD . '
			</div>';
			echo '<div class="block-widget"><div class="block-widget-header">' . _PROFIL . '</div><div class="block-widget-content">'
			. "<form method=\"post\" action=\"index.php?file=User&amp;op=update\" enctype=\"multipart/form-data\" onsubmit=\"return verifchamps();\">\n"
			. "<table class=\"table table-striped table-condensed\">\n"
			. "<tr><td><b>" . _NICK . " : </b></td><td><input id=\"edit_pseudo\" type=\"text\" name=\"nick\" size=\"30\" maxlength=\"30\" value=\"" . $nick . "\" /> *</td></tr>\n"
			. "<tr><td><b>" . _USERPASSWORD . " : </b></td><td><input type=\"password\" name=\"pass_reg\" size=\"10\" maxlength=\"15\" autocomplete=\"off\" /> *</td></tr>\n"
			. "<tr><td><b>" . _PASSCONFIRM . " : </b></td><td><input type=\"password\" name=\"pass_conf\" size=\"10\" maxlength=\"15\" autocomplete=\"off\" /> *</td></tr>\n"
			. "<tr><td><b>" . _MAIL . " " . _PRIVATE . " : </b></td><td><input id=\"edit_mail\" type=\"text\" name=\"mail\" size=\"30\" maxlength=\"80\" value=\"" . $mail. "\" /> *</td></tr>\n"
			. "<tr><td><b>" . _USERPASSWORD . " (" . _PASSOLD . ") :</b></td><td><input type=\"password\" name=\"pass_old\" size=\"10\" maxlength=\"15\" /> *</td></tr>\n";
			if ($c1 == 'on'){echo "<tr><td><b>" . _MAIL . " " . _PUBLIC . " : </b></td><td><input type=\"text\" name=\"email\" size=\"30\" maxlength=\"80\" value=\"" . $email . "\" /></td></tr>\n";}
			if ($c2 == 'on'){echo "<tr><td><b>" . _ICQ . " : </b></td><td><input type=\"text\" name=\"icq\" size=\"30\" maxlength=\"30\" value=\"" . $icq . "\" /></td></tr>\n";}
			if ($c3 == 'on'){echo "<tr><td><b>" . _MSN . " : </b></td><td><input type=\"text\" name=\"msn\" size=\"30\" maxlength=\"80\" value=\"" . $msn . "\" /></td></tr>\n";}
			if ($c4 == 'on'){echo "<tr><td><b>" . _AIM . " : </b></td><td><input type=\"text\" name=\"aim\" size=\"30\" maxlength=\"30\" value=\"" . $aim . "\" /></td></tr>\n";}
			if ($c5 == 'on'){echo "<tr><td><b>" . _YIM . " : </b></td><td><input type=\"text\" name=\"yim\" size=\"30\" maxlength=\"30\" value=\"" . $yim . "\" /></td></tr>\n";}
			if ($c6 == 'on'){echo "<tr><td><b>" . _XFIRE . " : </b></td><td><input type=\"text\" name=\"xfire\" size=\"30\" maxlength=\"30\" value=\"" . $xfire . "\" /></td></tr>\n";}
			if ($c7 == 'on'){echo "<tr><td><b>" . _FACEBOOK . " : </b></td><td><input type=\"text\" name=\"facebook\" size=\"30\" maxlength=\"30\" value=\"" . $facebook . "\" /></td></tr>\n";}
			if ($c8 == 'on'){echo "<tr><td><b>" . _ORIGINEA . " : </b></td><td><input type=\"text\" name=\"origin\" size=\"30\" maxlength=\"30\" value=\"" . $origin . "\" /></td></tr>\n";}
			if ($c9 == 'on'){echo "<tr><td><b>" . _STEAM . " : </b></td><td><input type=\"text\" name=\"steam\" size=\"30\" maxlength=\"30\" value=\"" . $steam . "\" /></td></tr>\n";}
			if ($c10 == 'on'){echo "<tr><td><b>" . _TWITER . " : </b></td><td><input type=\"text\" name=\"twitter\" size=\"30\" maxlength=\"30\" value=\"" . $twitter . "\" /></td></tr>\n";}	
			if ($c11 == 'on'){echo "<tr><td><b>" . _SKYPE . " : </b></td><td><input type=\"text\" name=\"skype\" size=\"30\" maxlength=\"30\" value=\"" . $skype . "\" /></td></tr>\n";}	
			if ($c12 == 'on'){echo "<tr><td><b>" . _WEBSITE . " : </b></td><td><input type=\"text\" name=\"url\" size=\"40\" maxlength=\"80\" value=\"" . $url . "\" /></td></tr>\n";}
			echo "<tr><td><b>" . _COUNTRY . " : </b></td><td><select name=\"country\">\n";
			
			$rep = Array();
			$handle = @opendir("images/flags");
			while (false !== ($f = readdir($handle))){
				if ($f != ".." && $f != "." && $f != "index.html" && $f != "Thumbs.db"){
					$rep[] = $f;
				}
			}
			
			closedir($handle);
			sort ($rep);
			reset ($rep);
			
			while (list ($key, $filename) = each ($rep)){
				if ($filename == $pays){
					$checked = "selected=\"selected\"";
				}
				else{
					$checked = "";
				}
				
				list ($country, $ext) = explode ('.', $filename);
				echo "<option value=\"" . $filename . "\" " . $checked . ">" . $country . "</option>\n";
			}
			
			echo "</select></td></tr>";
			
			if ($nuked['avatar_upload'] == "on" || $nuked['avatar_url'] == "on"){
				echo "<tr><td><b>" . _AVATAR . " : </b></td>\n";
				
				if($nuked['avatar_url'] != "on") $disable = 'disabled="disabled"';
				else $disable = "";
				
				echo "<td><input type=\"text\" id=\"edit_avatar\" name=\"avatar\" size=\"40\" maxlength=\"100\" value=\"" . $avatar . "\" ".$disable." />"
				. "&nbsp;[ <a  href=\"#\" onclick=\"javascript:window.open('index.php?file=User&amp;nuked_nude=index&amp;op=show_avatar','Avatar','toolbar=0,location=0,directories=0,status=0,scrollbars=1,resizable=0,copyhistory=0,menuBar=0,width=350,height=450,top=30,left=0');return(false)\">" . _SEEAVATAR . "</a> ]</td></tr><tr><td>&nbsp;</td>\n";
				
				if ($nuked['avatar_upload'] == "on"){
					echo "<td><input type=\"file\" name=\"fichiernom\" /></td></tr>\n";
				}
				else{
					echo "<td>&nbsp;</td></tr>\n";
				}
			}
			
			echo "<tr><td><b>" . _SIGN . " :</b></td><td><textarea id=\"e_basic\" name=\"signature\" rows=\"10\" cols=\"60\">" . $signature . "</textarea></td></tr>\n";
			
			if ($nuked['user_delete'] == "on"){
				echo "<tr><td colspan=\"2\" align=\"center\">"._DELMYACCOUNT." <input class=\"checkbox\" type=\"checkbox\" name=\"remove\" value=\"ok\" /></td></tr>\n";
			}
			
			echo "<tr><td colspan=\"2\" align=\"center\"><input class=\"btn\" type=\"submit\" name=\"Submit\" value=\"" . _MODIF . "\" />\n"
			. "<input type=\"hidden\" name=\"pass\" value=\"" . $pass . "\" /></td></tr></table></form><br /></div></div></div>\n";
		}
		else{
			echo "<br /><br /><div style=\"text-align: center;\">" . _USERENTRANCE . "</div><br /><br />";
			redirect("index.php?file=User&op=login_screen", 2);
		}
	}
	
	function edit_pref(){
		global $user, $nuked, $bgcolor3, $bgcolor2, $bgcolor1;
		
		if ($user){
			echo '<div id="User">';
			$sql = mysql_query("SELECT prenom, age, sexe, ville, motherboard, cpu, ram, video, resolution, son, ecran, souris, clavier, connexion, system, photo FROM " . USER_DETAIL_TABLE . " WHERE user_id = '" . $user[0] . "'");
			list($prenom, $age, $sexe, $ville, $motherboard, $cpu, $ram, $video, $resolution, $sons, $ecran, $souris, $clavier, $connexion, $osystem, $photo) = mysql_fetch_array($sql);
			
			if ($age != ""){
				list ($jour, $mois, $an) = explode ('/', $age);
			}
			
			leftpannel();
			
			echo '<div class="profiledroit"><div class="block-widget"><div class="block-widget-header">' . _INFOPERSO . '</div><div class="block-widget-content">
			<form method="post" action="index.php?file=User&amp;op=update_pref" enctype="multipart/form-data">
			<table class="table table-striped table-condensed">
			<tr><td>' . _LASTNAME . ' :</td><td><input type="text" name="prenom" value="' . $prenom . '" class="span3" /></td></tr>
			<tr><td><b> ' . _BIRTHDAY . ' :</b></td><td><select name="jour">';
			
			if ($jour != ""){
				echo "<option>" . $jour . "</option>\n";
			}
			else{
				$checked1 = "selected=\"selected\"";
			}
			
			$day = 1;
			while ($day < 32){
				if ($day == date("d")){
					echo "<option value=\"" . $day . "\" " . $checked1 . ">" . $day . "</option>\n";
				}
				else{
					echo "<option value=\"" . $day . "\">" . $day . "</option>\n";
				}            
				$day++;
			}
			
			echo "</select>&nbsp;<select name=\"mois\">\n";
			
			if ($mois != ""){
				echo "<option value=\"" . $mois . "\">" . $mois . "</option>\n";
			}
			else{
				$checked2 = "selected=\"selected\"";
			}
			
			$month = 1;
			while ($month < 13){
				if ($month == date("m")){
					echo "<option value=\"" . $month . "\" " . $checked2 . ">" . $month . "</option>\n";
				}
				else{
					echo "<option value=\"" . $month . "\">" . $month . "</option>\n";
				}
				$month++;
			}
			
			echo "</select>&nbsp;<select name=\"an\">\n";
			
			if ($an != ""){
				echo "<option value=\"" . $an . "\">" . $an . "</option>\n";
			}
			else{
				$checked3 = "selected=\"selected\"";
			}
			
			$year = 1900;
			$lastyear = date("Y") + 1;
			
			while ($year < $lastyear){
				if ($year == date("Y")){
					echo "<option value=\"" . $year . "\" " . $checked3 . ">" . $year . "</option>\n";
				}
				else{
					echo "<option value=\"" . $year . "\">" . $year . "</option>\n";
				}
				$year++;
			}
			
			echo "</select></td></tr>";
			
			if ($sexe == "male"){
				$checked4 = "checked=\"checked\"";
			}
			else if ($sexe == "female"){
				$checked5 = "checked=\"checked\"";
			}
			else{
				$checked4 = "";
				$checked5 = "";
			}
			
			echo "<tr><td style=\"width: 30%;\" align=\"left\"><b> " . _SEXE . " :</b></td><td style=\"width: 70%;\" align=\"left\"><input type=\"radio\" class=\"checkbox\" name=\"sexe\" value=\"male\" " . $checked4 . " /> " . _MALE . " <input type=\"radio\" class=\"checkbox\" name=\"sexe\" value=\"female\" " . $checked5 . " /> " . _FEMALE . "</td></tr>\n"
			. "<tr><td style=\"width: 30%;\" align=\"left\"><b> " . _CITY . " :</b></td><td style=\"width: 70%;\" align=\"left\"><input type=\"text\" name=\"ville\" value=\"" . $ville . "\" size=\"20\" /></td></tr>\n";
			
			
			if ($nuked['avatar_upload'] == "on" || $nuked['avatar_url'] == "on"){
				echo "<tr><td><b>" . _PHOTO . " (1Mo max) : </b></td>\n";
				
				if($nuked['avatar_url'] != "on") $disable = "DISABLED=\"DISABLED\"";
				else $disable = "";
				
				echo"<td align=\"left\"><input type=\"text\" id=\"photo\" name=\"photo\" size=\"40\" maxlength=\"150\" value=\"" . $photo . "\" " . $disable . " /></td></tr>\n";
				
				if ($nuked['avatar_upload'] == "on"){
					echo "<tr><td style=\"width: 30%;\">&nbsp;</td><td style=\"width: 70%;\" align=\"left\"><input type=\"file\" name=\"fichiernom\" /></td></tr>\n";
				}
				
			}
			echo '</table></div></div><div class="block-widget"><div class="block-widget-header">' . _HARDCONFIG . '</div><div class="block-widget-content">
			<table class="table table-striped table-condensed">';
			echo "<tr><td style=\"width: 30%;\" align=\"left\"><b> " . _MOTHERBOARD . " :</b></td><td style=\"width: 70%;\" align=\"left\"><input type=\"text\" name=\"motherboard\" value=\"" . $motherboard . "\" size=\"25\" /></td></tr>\n"
			. "<tr><td style=\"width: 30%;\" align=\"left\"><b> " . _PROCESSOR . " :</b></td><td style=\"width: 70%;\" align=\"left\"><input type=\"text\" name=\"cpu\" value=\"" . $cpu . "\" size=\"25\" /></td></tr>\n"
			. "<tr><td style=\"width: 30%;\" align=\"left\"><b> " . _MEMORY . " :</b></td><td style=\"width: 70%;\" align=\"left\"><select name=\"ram\"><option>" . $ram . "</option>\n"
			. "<option>- 512 Mo</option>\n"
			. "<option>1 Go</option>\n"
			. "<option>1,5 Go</option>\n"
			. "<option>2 Go</option>\n"
			. "<option>2,5 Go</option>\n"
			. "<option>3 Go</option>\n"
			. "<option>4 Go</option>\n"
			. "<option>8 Go</option>\n"
			. "<option>+ 8 Go</option>\n"
			. "</select></td></tr>\n"
			. "<tr><td style=\"width: 30%;\" align=\"left\"><b> " . _VIDEOCARD . " :</b></td><td style=\"width: 70%;\" align=\"left\"><input type=\"text\" name=\"video\" value=\"" . $video . "\" size=\"25\" /></td></tr>\n"
			. "<tr><td style=\"width: 30%;\" align=\"left\"><b> " . _RESOLUTION . " :</b></td><td style=\"width: 70%;\" align=\"left\"><select name=\"resolution\"><option>" . $resolution . "</option>\n"
			. "<option>640/480</option>\n"
			. "<option>800/600</option>\n"
			. "<option>1024/768</option>\n"
			. "<option>1152/864</option>\n"
			. "<option>1280/1024</option>\n"
			. "<option>1440/900 </option>\n"        
			. "<option>1600/1200</option>\n"
			. "<option>1680/1050</option>\n"
			. "<option>1920/1080</option>\n"
			. "<option>1920/1200</option>\n"
			. "<option>2048/1536</option>\n"
			. "<option>2560/1600</option></select></td></tr>\n"
			. "<tr><td style=\"width: 30%;\" align=\"left\"><b> " . _SOUNDCARD . " : </b></td><td style=\"width: 70%;\" align=\"left\"><input type=\"text\" name=\"sons\" value=\"" . $sons . "\" size=\"25\" /></td></tr>\n"
			. "<tr><td style=\"width: 30%;\" align=\"left\"><b> " . _MONITOR . " :</b></td><td style=\"width: 70%;\" align=\"left\"><input type=\"text\" name=\"ecran\" value=\"" . $ecran . "\" size=\"25\" /></td></tr>\n"
			. "<tr><td style=\"width: 30%;\" align=\"left\"><b> " . _MOUSE . " :</b></td><td style=\"width: 70%;\" align=\"left\"><input type=\"text\" name=\"souris\" value=\"" . $souris . "\" size=\"25\" /></td></tr>\n"
			. "<tr><td style=\"width: 30%;\" align=\"left\"><b> " . _KEYBOARD . " :</b></td><td style=\"width: 70%;\" align=\"left\"><input type=\"text\" name=\"clavier\" value=\"" . $clavier . "\" size=\"25\" /></td></tr>\n"
			. "<tr><td style=\"width: 30%;\" align=\"left\"><b> " . _CONNECT . " :</b></td><td style=\"width: 70%;\" align=\"left\"><select name=\"connexion\"><option>" . $connexion . "</option>\n"
			. "<option>Modem 56K</option>\n"
			. "<option>Modem 128K</option>\n"
			. "<option>ADSL 128K</option>\n"
			. "<option>ADSL 512K</option>\n"
			. "<option>ADSL 1024K</option>\n"
			. "<option>ADSL 2048K</option>\n"
			. "<option>ADSL 3M</option>\n"
			. "<option>ADSL 4M</option>\n"
			. "<option>ADSL 5M</option>\n"
			. "<option>ADSL 8M</option>\n"
			. "<option>ADSL 20M +</option>\n"
			. "<option>Cable 128K</option>\n"
			. "<option>Cable 512K</option>\n"
			. "<option>Cable 1024K</option>\n"
			. "<option>Cable 2048K</option>\n"
			. "<option>Cable 8M</option>\n"
			. "<option>Cable 20M +</option>\n"
			. "<option>T1 1,5M</option>\n"
			. "<option>T2 6M</option>\n"
			. "<option>T3 45M</option>\n"
			. "<option>Fiber 50M</option>\n"
			. "<option>Fiber 100M</option>\n"
			. "<option>" . _OTHER . "</option></select></td></tr>\n"
			. "<tr><td style=\"width: 30%;\" align=\"left\"><b> " . _SYSTEMOS . " :</b></td><td style=\"width: 70%;\" align=\"left\"><select name=\"osystem\">\n";
			
			$list_os = array(
            'Windows 7',
            'Windows Vista',
            'Windows XP',
            'Windows 2000',
            'Linux',
            'Mac OS X',
            'Autre',
			);
			
			$detected_os = getOS();
			
			foreach( $list_os as $os ) {
				echo "    <option" . (($os == $osystem OR $os == $detected_os) ? ' selected="selected"' : '') . ">" . $os . "</option>\n";
			}
			
			echo "</select></td></tr>\n";
			echo "</table></div></div><div style=\"text-align: center;\"><br /><input class=\"btn\" type=\"submit\" value=\"" . _MODIFPREF . "\" /></div></form><br />\n";
		}
		else{
			echo "<br /><br /><div style=\"text-align: center;\">" . _USERENTRANCE . "</div><br /><br />";
			redirect("index.php?file=User&op=login_screen", 2);
		}
	}
	
	function login_screen(){
		global $nuked, $user;
		
		if ($user){
			redirect("index.php?file=User", 0);
		}
		else{
			opentable();
			
			if ($_REQUEST['error'] == 1){
				$erreur = "<br /><div style=\"text-align: center;\">" . _NOFIELD . "</div><br />\n";
			}
			else if ($_REQUEST['error'] == 2){
				$erreur = "<br /><div style=\"text-align: center;\">" . _BADLOG . "</div><br />\n";
			}
			else{
				$erreur = "";
			}
			
			echo $erreur . "<br /><div style=\"text-align: center;\"><big><b>" . _LOGINUSER . "</b></big></div><br /><br />\n"
			. "<form action=\"index.php?file=User&amp;nuked_nude=index&amp;op=login\" method=\"post\">\n"
			. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\">\n"
			. "<tr><td><b>" . _NICK . " :</b></td><td><input type=\"text\" name=\"pseudo\" size=\"15\" maxlength=\"180\" /></td></tr>\n"
			. "<tr><td><b>" . _PASSWORD . " :</b></td><td><input type=\"password\" name=\"pass\" size=\"15\" maxlength=\"15\" /></td></tr>\n"
			. "<input type=\"hidden\" name=\"erreurr\" value=\"".$error."\" size=\"15\" maxlength=\"15\" />\n";
			
			if ($_REQUEST['captcha'] == 'true') create_captcha(1);
			
			echo "<tr><td colspan=\"2\"><input type=\"checkbox\" class=\"checkbox\" name=\"remember_me\" value=\"ok\" checked=\"checked\" /><small>&nbsp;" . _REMEMBERME . "</small></td></tr>\n"
			. "<tr><td colspan=\"2\" align=\"center\"><input type=\"submit\" value=\"" . _TOLOG . "\" /></td></tr><tr><td colspan=\"2\">&nbsp;</td></tr>\n"
			. "<tr><td colspan=\"2\"><b><a href=\"index.php?file=User&amp;op=reg_screen\">" . _USERREGISTER . "</a> | <a href=\"index.php?file=User&amp;op=oubli_pass\">" . _LOSTPASS . "</a></b></td></tr></table></form><br />\n";
			
			closetable();
		}
	}
	
	function reg($pseudo, $mail, $email, $pass_reg, $pass_conf, $game, $country){
		global $nuked, $captcha, $cookie_forum, $user_ip;
		
		// Verification code captcha
		if (!ValidCaptchaCode($_REQUEST['code_confirm'])){
			echo "<br /><br /><div style=\"text-align: center;\">" . _BADCODECONFIRM . "<br /><br /><a href=\"javascript:history.back()\">[ <b>" . _BACK . "</b> ]</a></div><br /><br />";
			closetable();
			footer();
			exit();
		}
		
		$pseudo = htmlentities($pseudo, ENT_QUOTES);
		
		$pseudo = verif_pseudo($pseudo);
		
		$mail = mysql_real_escape_string(stripslashes($mail));
		$mail = htmlentities($mail);
		
		if ($pseudo == "error1"){
			echo "<br /><br /><div style=\"text-align: center;\">" . _BADUSERNAME . "</div><br /><br />";
			redirect("index.php?file=User&op=reg_screen", 2);
			closetable();
			footer();
			exit();
		}
		
		if ($pseudo == "error2"){
			echo "<br /><br /><div style=\"text-align: center;\">" . _NICKINUSE . "</div><br /><br />";
			redirect("index.php?file=User&op=reg_screen", 2);
			closetable();
			footer();
			exit();
		}
		
		if ($pseudo == "error3"){
			echo "<br /><br /><div style=\"text-align: center;\">" . _NICKBANNED . "</div><br /><br />";
			redirect("index.php?file=User&op=reg_screen", 2);
			closetable();
			footer();
			exit();
		}
		
		if (strlen($pseudo) > 30){
			echo "<br /><br /><div style=\"text-align: center;\">" . _NICKTOLONG . "</div><br /><br />";
			redirect("index.php?file=User&op=reg_screen", 2);
			closetable();
			footer();
			exit();
		}
		
		$sql2 = mysql_query("SELECT mail FROM " . USER_TABLE . " WHERE mail = '" . $mail . "'");
		$reserved_email = mysql_num_rows($sql2);
		
		$sql3 = mysql_query("SELECT email FROM " . BANNED_TABLE . " WHERE email = '" . $mail . "'");
		$banned_email = mysql_num_rows($sql3);
		
		if ($reserved_email > 0){
			echo "<br /><br /><div style=\"text-align: center;\">" . _MAILINUSE . "</div><br /><br />";
			redirect("index.php?file=User&op=reg_screen", 2);
			closetable();
			footer();
			exit();
		}
		
		
		if ($banned_email > 0){
			echo "<br /><br /><div style=\"text-align: center;\">" . _MAILBANNED . "</div><br /><br />";
			redirect("index.php?file=User&op=reg_screen", 2);
			closetable();
			footer();
			exit();
		}
		
		
		if ($nuked['inscription'] == "mail"){
			$lettres = "abCdefGhijklmNopqrstUvwXyz0123456789";
			srand(time());
			for ($i = 0;$i < 5;$i++){
				$rand_pass .= substr($lettres, (rand() % (strlen($lettres))), 1);
			}
			$pass_reg = $rand_pass;
			$pass_conf = $rand_pass;
		}
		
		if ($pass_reg != $pass_conf){
			echo "<br /><br /><div style=\"text-align: center;\">" . stripslashes(_PASSFAILED) . "</div><br /><br />";
			redirect("index.php?file=User&op=reg_screen", 1);
			closetable();
			footer();
			exit();
		}
		
		$date = time();
		$cryptpass = nk_hash($pass_reg);
		
		do{
			$user_id = substr(sha1(uniqid()), 0, 20);
			$sql = mysql_query('SELECT * FROM ' . USER_TABLE . ' WHERE id=\'' . $user_id . '\'');
		} while (mysql_num_rows($sql) != 0);
		
		$email = mysql_real_escape_string(stripslashes($email));
		$email = htmlentities($email);
		
		if ($nuked['validation'] == "auto"){
			$niveau = 1;
		}
		else{
			$niveau = 0;
		}
		if (!(file_exists("images/flags/".basename($country).""))){
			$country = "France.gif";
		}
		$date2 = nkDate(time());
		$add = mysql_query("INSERT INTO " . USER_TABLE . " ( `id` , `team` , `team2` , `team3` , `rang` , `ordre` , `pseudo` , `mail` , `email` , `icq` , `msn` , `aim` , `yim` , `url` , `pass` , `niveau` , `date` , `avatar` , `signature` , `user_theme` , `user_langue` , `game` , `country` , `count`, `xfire`, `facebook`, `origin`, `steam`, `twitter`, `skype` ) VALUES ( '" . $user_id . "' , '' , '' , '' , '' , '' , '" . $pseudo . "' , '" . $mail . "' , '" . $email . "' , '' , '' , '' , '' , '' , '" . $cryptpass . "' , '" . $niveau . "' , '" . $date . "' , '' , '' , '' , '' , '" . $game . "' , '" . $country . "' , '', '" . $xfire . "', '" . $facebook . "', '" . $origin . "', '" . $steam . "', '" . $twitter . "', '" . $skype . "'
		)");
		
		// Mark read all topics in the forum
		$_COOKIE['cookie_forum'] = '';
		$req = 'UPDATE ' . SESSIONS_TABLE . ' SET last_used = date WHERE user_id = "' . $user_id . '"';
		$sql = mysql_query($req);
		
		$del = mysql_query('DELETE FROM ' . FORUM_READ_TABLE . ' WHERE user_id = "' . $user_id . '"');
		
		$result = mysql_query('SELECT id, forum_id FROM ' . FORUM_THREADS_TABLE);
		$nbtopics = mysql_num_rows($result);
		
		if ($nbtopics > 0) {
			while (list($thread_id, $forum_id) = mysql_fetch_row($result)) {
				$sql = mysql_query("INSERT INTO " . FORUM_READ_TABLE . " ( `id` , `user_id` , `thread_id` , `forum_id` ) VALUES ( '' , '" . $user_id . "' , '" . $thread_id . "' , '" . $forum_id . "' )");
			}
		}
		// End
		
		if ($nuked['validation'] == "mail" && $nuked['inscription'] == "on"){
			$subject = _USERREGISTER . ", " . $date2;
			$corps = _USERVALID . "\r\n" . $nuked['url'] . "/index.php?file=User&op=validation&id_user=" . $user_id . "\r\n\r\n" . _USERMAIL . "\r\n" . _NICK . " : " . $pseudo . "\r\n" . _PASSWORD . " : " . $pass_reg . "\r\n\r\n\r\n" . $nuked['name'] . " - " . $nuked['slogan'];
			$from = "From: " . $nuked['name'] . " <" . $nuked['mail'] . ">\r\nReply-To: " . $nuked['mail'];
			
			$subject = @html_entity_decode($subject);
			$corps = @html_entity_decode($corps);
			$from = @html_entity_decode($from);
			$s_mail = @html_entity_decode($mail);
			
			mail($s_mail, $subject, $corps, $from);
		}
		else{
			if ($nuked['inscription'] == "mail" || ($nuked['inscription_mail'] != "" && $nuked['validation'] == "auto")){
				if ($nuked['inscription_mail'] != ""){
					$inscription_mail = $nuked['inscription_mail'];
				}
				else{
					$inscription_mail = _USERMAIL;
				}
				
				$subject = _USERREGISTER . ", " .$date2;
				$corps = $inscription_mail . "<br /><br />" . _NICK . " : " . $pseudo . "<br /><br />" . _PASSWORD . " : " . $pass_reg . "<br /><br /><br /><br />" . $nuked['name'] . " - " . $nuked['slogan'];
				$from = "From: " . $nuked['name'] . " <" . $nuked['mail'] . ">\r\nReply-To: " . $nuked['mail'];
				$from .= "\r\n" . 'MIME-Version: 1.0' . "\r\n";
				$from .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				
				$subject = @html_entity_decode($subject);
				$corps = @html_entity_decode($corps);
				$from = @html_entity_decode($from);
				$s_mail = @html_entity_decode($mail);
				
				mail($s_mail, $subject, $corps, $from);
			}
		}
		
		if ($nuked['inscription_avert'] == "on" || $nuked['validation'] == "admin"){
			$subject = _NEWUSER . " : " . $pseudo . ", " .$date2;
			$corps =  $pseudo . " (IP : " . $user_ip . ") " . _NEWREGISTRATION . " " . $nuked['name'] . " " . _NEWREGSUITE . "\r\n\r\n\r\n" . $nuked['name'] . " - " . $nuked['slogan'];
			$from = "From: " . $nuked['name'] . " <" . $nuked['mail'] . ">\r\nReply-To: " . $nuked['mail'];
			
			$subject = @html_entity_decode($subject);
			$corps = @html_entity_decode($corps);
			$from = @html_entity_decode($from);
			
			mail($nuked['mail'], $subject, $corps, $from);
		}
		
		if ($nuked['validation'] == "mail" && $nuked['inscription'] == "on"){
			echo "<br /><br /><div style=\"text-align: center;\">" . _VALIDMAILSUCCES . "&nbsp;" . $mail . "</div><br /><br />";
			redirect("index.php?file=User&op=login_screen", 5);
		}
		else if ($nuked['validation'] == "admin" && $nuked['inscription'] == "on"){
			echo "<br /><br /><div style=\"text-align: center;\">" . _VALIDADMIN . "</div><br /><br />";
			redirect("index.php", 5);
		}
		else if ($nuked['inscription'] == "mail"){
			echo "<br /><br /><div style=\"text-align: center;\">" . _USERMAILSUCCES . "&nbsp;" . $mail . "</div><br /><br />";
			redirect("index.php?file=User&op=login_screen", 5);
		}
		else{
			echo "<br /><br /><div style=\"text-align: center;\">" . _REGISTERSUCCES . "</div><br /><br />";
			redirect("index.php?file=User&nuked_nude=index&op=login&pseudo=" . urlencode($pseudo) . "&pass=" . urlencode($pass_reg) . "&remember_me=ok", 2);
		}
	}
	
	function login($pseudo, $pass, $remember_me){
		global $captcha, $bgcolor3, $bgcolor2, $bgcolor1, $nuked, $theme, $cookie_theme, $cookie_langue, $timelimit;
		$cookiename = $nuked['cookiename'];
		
		$sql = mysql_query("SELECT id, pass, user_theme, user_langue, niveau, erreur FROM " . USER_TABLE . " WHERE pseudo = '" . htmlentities($pseudo, ENT_QUOTES) . "'");
		$check = mysql_num_rows($sql);
		
		if($check > 0){
			list($id_user, $dbpass, $usertheme, $userlang, $niveau, $count) = mysql_fetch_array($sql);
			
			// Verification code captcha
			if (!ValidCaptchaCode($_REQUEST['code_confirm']) && $count >= 3){
				if (empty($_REQUEST['code_confirm'])) $msg_error = _MSGCAPTCHA;
				else $msg_error = _BADCODECONFIRM;
				
				echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n"
				. "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"fr\">\n"
				. "<head><title>" . $nuked['name'] . " :: " . $nuked['slogan'] . " ::</title>\n"
				. "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />\n"
				. "<meta http-equiv=\"content-style-type\" content=\"text/css\" />\n"
				. "<link title=\"style\" type=\"text/css\" rel=\"stylesheet\" href=\"themes/" . $theme . "/style.css\" /></head>\n"
				. "<body style=\"background: " . $bgcolor2 . ";\"><div><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /></div>\n"
				. "<table width=\"400\" style=\"margin-left: auto;margin-right: auto;text-align: left;background: " . $bgcolor3 . ";\" cellspacing=\"1\" cellpadding=\"20\">\n"
				. "<tr><td style=\"background: " . $bgcolor1 . ";\" align=\"center\"><big><b>" . $msg_error . "</td></tr></table></body></html>";
				
				$url = "index.php?file=User&op=login_screen&captcha=true";
				$captcha = '&captcha=true';
				redirect($url, 2);
				exit();
			}
			else{
				$captcha = '';
			}
			if ($pseudo == "" || $pass == ""){
				$error = 1;
				$url = "index.php?file=User&op=login_screen&error=" . $error . $captcha;
				redirect($url, 0);
			}
			
			if ($niveau > 0){
				if (!Check_Hash($pass, $dbpass)){
					$error = 2;
					$sql = 'UPDATE ' . USER_TABLE . ' SET erreur = ' . ($count + 1) . ' WHERE pseudo = \'' . htmlentities($pseudo, ENT_QUOTES) . '\'';
					$req = mysql_query($sql);
					$url = "index.php?file=User&op=login_screen&error=" . $error . $captcha;
					redirect($url, 0);
				}
				else{
					$sql = 'UPDATE ' . USER_TABLE . ' SET erreur = 0 WHERE pseudo = \'' . htmlentities($pseudo, ENT_QUOTES) . '\'';
					$req = mysql_query($sql);
					session_new($id_user, $remember_me);
					
					if ($usertheme != ""){
						setcookie($cookie_theme, $usertheme, $timelimit);
					}
					
					if ($userlang != ""){
						setcookie($cookie_langue, $userlang, $timelimit);
					}
					
					$referer = $_SERVER['HTTP_REFERER'];
					
					if (!empty($referer) && !strpos($referer, 'User&op=reg')){
						list($url_ref, $redirect) = explode('?', $referer);
						if(!empty($redirect)) $redirect = '&referer=' . urlencode($redirect);
					}
					else $redirect = '';
					
					$_SESSION['admin'] = false;
					$url = "index.php?file=User&nuked_nude=index&op=login_message&uid=" . $id_user . $redirect;
					redirect($url, 0);
				}
			}
			else{
				echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n"
				. "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"fr\">\n"
				. "<head><title>" . $nuked['name'] . " :: " . $nuked['slogan'] . " ::</title>\n"
				. "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />\n"
				. "<meta http-equiv=\"content-style-type\" content=\"text/css\" />\n"
				. "<link title=\"style\" type=\"text/css\" rel=\"stylesheet\" href=\"themes/" . $theme . "/style.css\" /></head>\n"
				. "<body style=\"background: " . $bgcolor2 . ";\"><div><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /></div>\n"
				. "<table width=\"400\" style=\"margin-left: auto;margin-right: auto;text-align: left;background: " . $bgcolor3 . ";\" cellspacing=\"1\" cellpadding=\"20\">\n"
				. "<tr><td style=\"background: " . $bgcolor1 . ";\" align=\"center\"><big><b>" . _NOVALIDUSER . "</td></tr></table></body></html>";
				
				redirect("index.php", 2);
			}
		}
		else{
			echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n"
			. "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"fr\">\n"
			. "<head><title>" . $nuked['name'] . " :: " . $nuked['slogan'] . " ::</title>\n"
			. "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />\n"
			. "<meta http-equiv=\"content-style-type\" content=\"text/css\" />\n"
			. "<link title=\"style\" type=\"text/css\" rel=\"stylesheet\" href=\"themes/" . $theme . "/style.css\" /></head>\n"
			. "<body style=\"background: " . $bgcolor2 . ";\"><div><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /></div>\n"
			. "<table width=\"400\" style=\"margin-left: auto;margin-right: auto;text-align: left;background: " . $bgcolor3 . ";\" cellspacing=\"1\" cellpadding=\"20\">\n"
			. "<tr><td style=\"background: " . $bgcolor1 . ";\" align=\"center\"><big><b>" . _UNKNOWNUSER . "</td></tr></table></body></html>";
			
			redirect("index.php", 2);
		}
	}
	
	function login_message(){
		global $nuked, $theme,  $bgcolor1, $bgcolor2, $bgcolor3, $cookie_session, $sessionlimit, $referer, $user_ip, $uid;
		
		if (isset($_COOKIE[$cookie_session]) && $_COOKIE[$cookie_session] != ""){
			$test_cookie = $_COOKIE[$cookie_session];
		}
		else{
			$test_cookie = "";
		}
		
		$referer = urldecode($_REQUEST['referer']);
		$referer = str_replace('&amp;', '&', $referer);
		
		if (!empty($referer) && !stripos($referer, 'User&op=reg')){
			$url = "index.php?" . $referer;
		}
		else{
			$url = "index.php";
		}
		
		if ($test_cookie != ""){
			echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n"
			. "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"fr\">\n"
			. "<head><title>" . $nuked['name'] . " :: " . $nuked['slogan'] . " ::</title>\n"
			. "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />\n"
			. "<meta http-equiv=\"content-style-type\" content=\"text/css\" />\n"
			. "<link title=\"style\" type=\"text/css\" rel=\"stylesheet\" href=\"themes/" . $theme . "/style.css\" /></head>\n"
			. "<body style=\"background: " . $bgcolor2 . ";\"><div><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /></div>\n"
			. "<table width=\"400\" style=\"margin-left: auto;margin-right: auto;text-align: left;background: " . $bgcolor3 . ";\" cellspacing=\"1\" cellpadding=\"20\">\n"
			. "<tr><td style=\"background: " . $bgcolor1 . ";\" align=\"center\"><big><b>" . _LOGINPROGRESS . "</b></big></td></tr></table></body></html>";
			
			redirect($url, 2);
		}
		else{
			if ($nuked['sess_inactivemins'] > 0 && $user_ip != "" && $user_ip != "127.0.0.1"){
				$login_text = _LOGINPROGRESS . "<br /><br />" . _SESSIONIPOPEN . "<br /><br />" . _ERRORCOOKIE;
			}
			else{
				$login_text = _ERRORCOOKIE;
			}
			
			echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n"
			. "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"fr\">\n"
			. "<head><title>" . $nuked['name'] . " :: " . $nuked['slogan'] . " ::</title>\n"
			. "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />\n"
			. "<meta http-equiv=\"content-style-type\" content=\"text/css\" />\n"
			. "<link title=\"style\" type=\"text/css\" rel=\"stylesheet\" href=\"themes/" . $theme . "/style.css\" /></head>\n"
			. "<body style=\"background: " . $bgcolor2 . ";\"><div><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /></div>\n"
			. "<table width=\"80%\" style=\"margin-left: auto;margin-right: auto;text-align: left;background: " . $bgcolor3 . ";\" cellspacing=\"1\" cellpadding=\"20\">\n"
			. "<tr><td style=\"background: " . $bgcolor1 . ";\" align=\"center\"><big><b>" . $login_text . "</b></big></td></tr></table></body></html>";
			
			redirect($url, 10);
		}
	}
	
	function update($nick, $pass, $mail, $email, $url, $pass_reg, $pass_conf, $pass_old, $icq, $msn, $aim, $yim, $avatar, $fichiernom, $signature, $country, $remove, $xfire, $facebook ,$origin, $steam, $twitter, $skype){
		global $nuked, $user;
		
		if ($remove == "ok" && $nuked['user_delete'] == "on"){
			echo "<br /><form action=\"index.php?file=User&amp;op=del_account\" method=\"post\">\n"
			. "<div style=\"text-align: center;\"><big><b>" . _DELMYACCOUNT . "</b></big></div><br />\n"
			. "<table align=\"center\" border=\"0\">\n"
			. "<tr><td align=\"center\">" . _REMOVECONFIRM . "</td></tr>\n"
			. "<tr><td><b>" . _USERPASSWORD . " :</b> <input type=\"password\" name=\"pass\" size=\"10\" maxlength=\"15\" /></td></tr>\n"
			. "<tr><td>&nbsp;</td></tr><tr><td align=\"center\"><input type=\"submit\" value=\"" . _SEND . "\" />&nbsp;"
			."<input type=\"button\" value=\"" . _CANCEL . "\" onclick=\"document.location='index.php?file=User&amp;op=edit_account'\" /></td></tr></table></form><br />\n";
		}
		else{
			$nick = htmlentities($nick, ENT_QUOTES);
			
			$mail = mysql_real_escape_string(stripslashes($mail));
			$mail = htmlentities($mail);
			
			$sql = mysql_query("SELECT pseudo, mail, pass FROM " . USER_TABLE . " WHERE id = '" . $user[0] . "'");
			list($old_pseudo, $old_mail, $old_pass) = mysql_fetch_array($sql);
			
			if ($nick != $old_pseudo){
				$sql1 = mysql_query("SELECT pseudo FROM " . BANNED_TABLE . " WHERE pseudo = '" . $nick . "'");
				$banned_nick = mysql_num_rows($sql1);
				
				$sql2 = mysql_query("SELECT pseudo FROM " . USER_TABLE . " WHERE pseudo = '" . $nick . "' AND id != '" . $user[0] . "'");
				$reserved_name = mysql_num_rows($sql2);
				
				if (!$nick || ($nick == "") || (preg_match("`[\$\^\(\)'\"?%#<>,;:]`", $nick))){
					echo "<br /><br /><div style=\"text-align: center;\">" . _BADUSERNAME . "</div><br /><br />";
					redirect("index.php?file=User&op=edit_account", 2);
					closetable();
					footer();
					exit();
				}
				else if (strlen($nick) > 30){
					echo "<br /><br /><div style=\"text-align: center;\">" . _NICKTOLONG . "</div><br /><br />";
					redirect("index.php?file=User&op=reg_screen", 2);
					closetable();
					footer();
					exit();
				}
				else if ($reserved_name > 0){
					echo "<br /><br /><div style=\"text-align: center;\">" . _NICKINUSE . "</div><br /><br />";
					redirect("index.php?file=User&op=edit_account", 2);
					closetable();
					footer();
					exit();
				}
				else if ($banned_nick > 0){
					echo "<br /><br /><div style=\"text-align: center;\">" . _NICKBANNED . "</div><br /><br />";
					redirect("index.php?file=User&op=edit_account", 2);
					closetable();
					footer();
					exit();
				}
				else if (!Check_Hash($pass_old, $old_pass) || !$pass_old){
					echo "<br /><br /><div style=\"text-align: center;\">" . _BADOLDPASS . "</div><br /><br />";
					redirect("index.php?file=User&op=edit_account", 2);
					closetable();
					footer();
					exit();
				}
				else{
					$upd = mysql_query("UPDATE " . USER_TABLE . " SET pseudo = '" . $nick . "' WHERE id = '" . $user[0] . "'");
				}
			}
			
			if ($mail != $old_mail){
				$sql3 = mysql_query("SELECT mail FROM " . USER_TABLE . " WHERE mail = '" . $mail . "' AND id != '" .$user[0] . "'");
				$reserved_email = mysql_num_rows($sql3);
				
				$sql4 = mysql_query("SELECT email FROM " . BANNED_TABLE . " WHERE email = '" . $mail . "'");
				$banned_email = mysql_num_rows($sql4);
				
				if ($reserved_email > 0){
					echo "<br /><br /><div style=\"text-align: center;\">" . _MAILINUSE . "</div><br /><br />";
					redirect("index.php?file=User&op=edit_account", 2);
					closetable();
					footer();
					exit();
				}
				
				if ($banned_email > 0){
					echo "<br /><br /><div style=\"text-align: center;\">" . _MAILBANNED . "</div><br /><br />";
					redirect("index.php?file=User&op=edit_account", 2);
					closetable();
					footer();
					exit();
				}
				else if (!Check_Hash($pass_old, $old_pass) || !$pass_old){
					echo "<br /><br /><div style=\"text-align: center;\">" . _BADOLDPASS . "</div><br /><br />";
					redirect("index.php?file=User&op=edit_account", 2);
					closetable();
					footer();
					exit();
				}
				else{
					$upd1 = mysql_query("UPDATE " . USER_TABLE . " SET mail = '" . $mail . "' WHERE id = '" . $user[0] . "'");
				}
			}
			
			if ($pass_reg != "" || $pass_conf != ""){
				if ($pass_reg != $pass_conf){
					echo "<br /><br /><div style=\"text-align: center;\">" . stripslashes(_PASSFAILED) . "</div><br /><br />";
					redirect("index.php?file=User&op=edit_account", 2);
					closetable();
					footer();
					exit();
				}
				else if (!Check_Hash($pass_old, $old_pass) || !$pass_old){
					echo "<br /><br /><div style=\"text-align: center;\">" . _BADOLDPASS . "</div><br /><br />";
					redirect("index.php?file=User&op=edit_account", 2);
					closetable();
					footer();
					exit();
				}
				else{
					$cryptpass = nk_hash($pass_reg);
					$upd2 = mysql_query("UPDATE " . USER_TABLE . " SET pass = '" . $cryptpass . "' WHERE id = '" . $user[0] . "'");
				}
			}
			
			$signature = secu_html(html_entity_decode($signature));
			$signature = mysql_real_escape_string(stripslashes($signature));
			$email = mysql_real_escape_string(stripslashes($email));
			$icq = mysql_real_escape_string(stripslashes($icq));
			$msn = mysql_real_escape_string(stripslashes($msn));
			$aim = mysql_real_escape_string(stripslashes($aim));
			$yim = mysql_real_escape_string(stripslashes($yim));
			$xfire = mysql_real_escape_string(stripslashes($xfire));
			$facebook = mysql_real_escape_string(stripslashes($facebook));
			$steam = mysql_real_escape_string(stripslashes($steam));
			$origin = mysql_real_escape_string(stripslashes($origin));
			$twitter = mysql_real_escape_string(stripslashes($twitter));
			$skype = mysql_real_escape_string(stripslashes($skype));
			$url = mysql_real_escape_string(stripslashes($url));
			$country = mysql_real_escape_string(stripslashes($country));
			$avatar = mysql_real_escape_string(stripslashes($avatar));
			
			$email = htmlentities($email);
			$icq = htmlentities($icq);
			$msn = htmlentities($msn);
			$aim = htmlentities($aim);
			$yim = htmlentities($yim);
			$xfire = htmlentities($xfire);
			$facebook = htmlentities($facebook);
			$steam = htmlentities($steam);
			$origin = htmlentities($origin);
			$twitter = htmlentities($twitter);
			$skype = htmlentities($skype);        
			$url = htmlentities($url);
			$country = htmlentities($country);
			$avatar = htmlentities($avatar);
			
			if (!empty($url) && !is_int(stripos($url, 'http://'))){
				$url = "http://" . $url;
			}
			
			$filename = $_FILES['fichiernom']['name'];
			$filesize = $_FILES['fichiernom']['size'];
			
			if ($filename != "" && $filesize <= 100000){
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if ($ext == "jpg" || $ext == "jpeg" || $ext == "JPG" || $ext == "JPEG" || $ext == "gif" || $ext == "GIF" || $ext == "png" || $ext == "PNG"){
					$url_avatar = "upload/User/" . time() . "." . $ext;
					move_uploaded_file($_FILES['fichiernom']['tmp_name'], $url_avatar) or die ("<br /><br /><div style=\"text-align: center;\"><b>Upload file failed !!!</b></div><br /><br />");
					@chmod ($url_avatar, 0644);
				}
				else{
					echo "<br /><br /><div style=\"text-align: center;\">" . _BADFILEFORMAT . "</div><br /><br />";
					redirect("index.php?file=User&op=edit_account", 5);
					closetable();
					footer();
					exit();
				}
			}
			else if ($filename != ""){
				echo "<br /><br /><div style=\"text-align: center;\">" . _FILETOOBIG . "</div><br /><br />";
				redirect("index.php?file=User&op=edit_account", 5);
				closetable();
				footer();
				exit();
			}
			else if ($avatar != ""){
				$ext = strrchr($avatar, '.');
				$ext = substr($ext, 1);
				
				if (!preg_match("`.php`i", $avatar) && !preg_match("`.htm`i", $avatar) && (preg_match("`jpg`i", $ext) || preg_match("`jpeg`i", $ext) || preg_match("`gif`i", $ext) || preg_match("`png`i", $ext))){
					$url_avatar = $avatar;
				}
				else{
					echo "<br /><br /><div style=\"text-align: center;\">" . _BADFILEFORMAT . "</div><br /><br />";
					redirect("index.php?file=User&op=edit_account", 5);
					closetable();
					footer();
					exit();
				}
			}
			else{
				$url_avatar = '';
			}
			
			if (!(file_exists("images/flags/".$country.""))){
				$country = "France.gif";
			}
			$upd3 = mysql_query("UPDATE " . USER_TABLE . " SET icq = '" . $icq . "', msn = '" . $msn . "', aim = '" . $aim . "', yim = '" . $yim . "', email = '" . $email . "', url = '" . $url . "', avatar = '" . $url_avatar . "', signature = '" . $signature . "', country = '" . $country . "', xfire = '" . $xfire . "', facebook = '" . $facebook . "', origin = '" . $origin . "', steam = '" . $steam . "', twitter = '" . $twitter . "', skype = '" . $skype . "' WHERE id = '" . $user[0] . "'");
			echo "<br /><br /><div style=\"text-align: center;\">" . _INFOMODIF . "</div><br /><br />";
			redirect("index.php?file=User", 1);
		}
	}
	
	function update_pref($prenom, $jour, $mois, $an, $sexe, $ville, $motherboard, $cpu, $ram, $video, $resolution, $sons, $ecran, $souris, $clavier, $connexion, $osystem, $photo, $fichiernom){
		global $nuked, $user;
		
		$prenom = htmlentities($prenom);
		$ville = htmlentities($ville);
		$motherboard = htmlentities($motherboard);
		$cpu = htmlentities($cpu);
		$ram = htmlentities($ram);
		$video = htmlentities($video);
		$resolution = htmlentities($resolution);
		$sons = htmlentities($sons);
		$ecran = htmlentities($ecran);
		$souris = htmlentities($souris);
		$clavier = htmlentities($clavier);
		$connexion = htmlentities($connexion);
		$osystem = htmlentities($osystem);
		$photo = htmlentities($photo);
		
		$prenom = mysql_real_escape_string(stripslashes($prenom));
		$ville = mysql_real_escape_string(stripslashes($ville));
		$motherboard = mysql_real_escape_string(stripslashes($motherboard));
		$cpu = mysql_real_escape_string(stripslashes($cpu));
		$ram = mysql_real_escape_string(stripslashes($ram));
		$video = mysql_real_escape_string(stripslashes($video));
		$resolution = mysql_real_escape_string(stripslashes($resolution));
		$sons = mysql_real_escape_string(stripslashes($sons));
		$ecran = mysql_real_escape_string(stripslashes($ecran));
		$souris = mysql_real_escape_string(stripslashes($souris));
		$clavier = mysql_real_escape_string(stripslashes($clavier));
		$connexion = mysql_real_escape_string(stripslashes ($connexion));
		$osystem = mysql_real_escape_string(stripslashes($osystem));
		$photo = mysql_real_escape_string(stripslashes($photo));
		
		$filename = $_FILES['fichiernom']['name'];
		$filesize = $_FILES['fichiernom']['size'];
		
		if ($filename != "" && $filesize <= 1000000){
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			
			if ($ext == "jpg" || $ext == "jpeg" || $ext == "JPG" || $ext == "JPEG" || $ext == "gif" || $ext == "GIF" || $ext == "png" || $ext == "PNG"){
				$url_photo = "upload/User/" . time() . "." . $ext;
				move_uploaded_file($_FILES['fichiernom']['tmp_name'], $url_photo) or die ("<br /><br /><div style=\"text-align: center;\"><b>Upload file failed !!!</b></div><br /><br />");
				@chmod ($url_photo, 0644);
			}
			else{
				echo "<br /><br /><div style=\"text-align: center;\">" . _BADFILEFORMAT . "</div><br /><br />";
				redirect("index.php?file=User&op=edit_pref", 5);
				closetable();
				footer();
				exit();
			}
		}
		else if ($photo != ""){
			$ext = strrchr($photo, '.');
			$ext = substr($ext, 1);
			
			if (!preg_match("`.php`i", $photo) && !preg_match("`.htm`i", $photo) && (preg_match("`jpg`i", $ext) || preg_match("`jpeg`i", $ext) || preg_match("`gif`i", $ext) || preg_match("`png`i", $ext))){
				$url_photo = $photo;
			}
			else{
				echo "<br /><br /><div style=\"text-align: center;\">" . _BADFILEFORMAT . "</div><br /><br />";
				redirect("index.php?file=User&op=edit_pref", 5);
				closetable();
				footer();
				exit();
			}
		}
		else{
			$url_photo = "";
		}
		
		if ($an < date("Y")){
			$age = $jour . "/" . $mois . "/" . $an;
		}
		else{
			$age = "";
		}
		
		$verif = mysql_query("SELECT user_id FROM " . USER_DETAIL_TABLE . " WHERE user_id = '" . $user[0] . "'");
		$res = mysql_num_rows($verif);
		
		if ($res > 0){
			$upd = mysql_query("UPDATE " . USER_DETAIL_TABLE . " SET prenom = '" . $prenom . "', age = '" . $age . "', sexe = '" . $sexe . "', ville = '" . $ville . "', motherboard = '" . $motherboard . "', cpu = '" . $cpu . "', ram = '" . $ram . "', video = '" . $video . "', resolution = '" . $resolution . "', son = '" . $sons . "', ecran = '" . $ecran . "', souris = '" . $souris . "', clavier = '" . $clavier . "', connexion = '" . $connexion . "', system = '" . $osystem . "', photo = '" . $url_photo . "' WHERE user_id = '" . $user[0] . "'");
		}
		else{
			$sql = mysql_query("INSERT INTO " . USER_DETAIL_TABLE . " ( `user_id` , `prenom` , `age` , `sexe` , `ville` , `photo` , `motherboard` , `cpu` , `ram` , `video` , `resolution` , `son` , `ecran` , `souris` , `clavier` , `connexion` , `system` , `pref_1` , `pref_2` , `pref_3` , `pref_4` , `pref_5` ) VALUES( '" . $user[0] . "' , '" . $prenom . "' , '" . $age . "' , '" . $sexe . "' , '" . $ville . "' , '" . $url_photo . "' , '" . $motherboard . "' , '" . $cpu . "' , '" . $ram . "' , '" . $video . "' , '" . $resolution . "' , '" . $sons . "' , '" . $ecran . "' , '" . $souris . "' , '" . $clavier . "' , '" . $connexion . "' , '" . $osystem . "' , '' , '' , '' , '' , '' )");
		}
		
		echo "<br /><br /><div style=\"text-align: center;\">" . _PREFMODIF . "</div><br /><br />";
		redirect("index.php?file=User", 2);
	}
	
	function logout(){
		global $nuked, $user, $cookie_theme, $cookie_langue, $cookie_session, $cookie_userid, $cookie_forum;
		
		$del = mysql_query("UPDATE " . SESSIONS_TABLE . " SET ip = '' WHERE user_id = '" . $user[0] . "'");
		
		setcookie($cookie_session, "");
		setcookie($cookie_userid, "");
		setcookie($cookie_theme, "");
		setcookie($cookie_langue, "");
		setcookie($cookie_forum, "");
		
		$_SESSION['admin'] = false;
		
		header("location:index.php");
	}
	
	function oubli_pass(){
		echo "<br /><form action=\"index.php?file=User&amp;op=envoi_mail\" method=\"post\">\n"
		. "<div style=\"text-align: center;\"><big><b>" . _LOSTPASSWORD . "</b></big></div>\n"
		. "<div style=\"width: 70%;margin-left: auto;margin-right: auto;text-align: left;\"><br />" . _LOSTPASSTXT . "<br /><br /></div>\n"
		. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n"
		. "<tr><td><b>" . _MAIL . " :</b></td><td><input type=\"text\" name=\"email\" size=\"30\" maxlength=\"80\" /></td></tr>\n"
		. "<tr><td colspan=\"2\">&nbsp;</td></tr><tr><td colspan=\"2\" align=\"center\"><input type=\"submit\" value=\"" . _SEND . "\" /></td></tr></table></form><br />\n";
	}
	
	function envoi_mail($email){
		global $nuked;
		
		$pattern = '#^[a-z0-9]+[a-z0-9._-]*@[a-z0-9.-]+.[a-z0-9]{2,3}$#';
		if(!preg_match($pattern, $email)){
			echo '<div style="text-align:center;margin:30px;">'._WRONGMAIL.'</div>';
			redirect("index.php?file=User&op=oubli_pass", 3);
			closetable();
			footer();
			exit();
		}
		
		$sql = mysql_query('SELECT pseudo, token, token_time FROM '.USER_TABLE.' WHERE mail = \''.$email.'\' ');
		$count = mysql_num_rows($sql);
		$data = mysql_fetch_assoc($sql);
		
		if($count > 0){
			if($data['token'] != null && (time() - $data['token_time']) < 3600){
				echo '<div style="text-align:center;margin:30px;">'._LINKALWAYSACTIVE.'</div>';
				redirect("index.php", 3);
				closetable();
				footer();
				exit();
			}
			elseif($data['token'] == null || ($data['token'] != null && (time() - $data['token_time']) > 3600)){
				$new_token = uniqid();
				mysql_query('UPDATE '.USER_TABLE.' SET token = \''.$new_token.'\', token_time = \''.time().'\' WHERE mail = \''.mysql_real_escape_string($email).'\' ');
				
				$link = '<a href="'.$nuked['url'].'/index.php?file=User&op=envoi_pass&email='.$email.'&token='.$new_token.'">'.$nuked['url'].'/index.php?file=User&op=envoi_pass&email='.$email.'&token='.$new_token.'</a>';
				
				$message = "<html><body><p>"._HI." ".$data['pseudo'].",<br/><br/>"._LINKTONEWPASSWORD." : <br/><br/>".$link."<br/><br/>"._LINKTIME."</p><p>".$nuked['name']." - ".$nuked['slogan']."</p></body></html>";
				$headers ='From: '.$nuked['name'].' <'.$nuked['mail'].'>'."\n";
				$headers .='Reply-To: '.$nuked['mail']."\n";
				$headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
				$headers .='Content-Transfer-Encoding: 8bit'; 
				
				$message = @html_entity_decode($message);
				
				mail($email, _LOSTPASSWORD, $message, $headers);
				
				echo '<div style="text-align:center;margin:30px;">'._MAILSEND.'</div>';
				redirect("index.php", 3);
			}
		}
		else{
			echo '<div style="text-align:center;margin:30px;">'._MAILNOEXIST.'</div>';
			redirect("index.php?file=User&op=oubli_pass", 3);
		}    
	}
	
	function envoi_pass($email, $token){
		global $nuked;
		
		$pattern = '#^[a-z0-9]+[a-z0-9._-]*@[a-z0-9.-]+.[a-z0-9]{2,3}$#';
		if(!preg_match($pattern, $email)){
			echo '<div style="text-align:center;margin:30px;">'._WRONGMAIL.'</div>';
			redirect("index.php", 3);
			closetable();
			footer();
			exit();
		}
		
		$pattern = '#^[a-z0-9]{13}$#';
		if(!preg_match($pattern, $token)){
			echo '<div style="text-align:center;margin:30px;">'._WRONGTOKEN.'</div>';
			redirect("index.php", 3);
			closetable();
			footer();
			exit();
		}
		
		$sql = mysql_query('SELECT pseudo, token, token_time FROM '.USER_TABLE.' WHERE mail = \''.$email.'\' ');
		$count = mysql_num_rows($sql);
		$data = mysql_fetch_assoc($sql);
		
		if($count > 0){
			if($data['token'] != null && (time() - $data['token_time']) < 3600){
				if($token == $data['token']){
					$new_pass = makePass();
					
					$message = "<html><body><p>"._HI." ".$data['pseudo'].",<br/><br/>"._NEWPASSWORD." : <br/><br/><strong>".$new_pass."</strong><br/></p><p>".$nuked['name']." - ".$nuked['slogan']."</p></body></html>";
					$headers ='From: '.$nuked['name'].' <'.$nuked['mail'].'>'."\n";
					$headers .='Reply-To: '.$nuked['mail']."\n";
					$headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
					$headers .='Content-Transfer-Encoding: 8bit'; 
					
					$message = @html_entity_decode($message);
					
					mail($email, _YOURNEWPASSWORD, $message, $headers);
					
					$new_pass = nk_hash($new_pass);
					
					mysql_query('UPDATE '.USER_TABLE.' SET pass = \''.$new_pass.'\', token = \'null\', token_time = \'0\' WHERE mail = \''.mysql_real_escape_string($email).'\' ');
					
					echo '<div style="text-align:center;margin:30px;">'._NEWPASSSEND.'</div>';
					redirect("index.php?file=User&op=login_screen", 3);
				}
				else{
					echo '<div style="text-align:center;margin:30px;">'._WRONGTOKEN.'</div>';
					redirect("index.php", 3);
					closetable();
					footer();
					exit();
				}
			}
			elseif($data['token'] == null || ($data['token'] != null && (time() - $data['token_time']) > 3600)){
				echo '<div style="text-align:center;margin:30px;">'._LINKNOACTIVE.'</div>';
				redirect("index.php?file=User&op=oubli_pass", 3);
				closetable();
				footer();
				exit();
			}
		}
		else{
			echo '<div style="text-align:center;margin:30px;">'._MAILNOEXIST.'</div>';
			redirect("index.php?file=User&op=oubli_pass", 3);
		}
	}
	
	function makePass(){
		$makepass = "";
		$syllables = "er,in,tia,wol,fe,pre,vet,jo,nes,al,len,son,cha,ir,ler,bo,ok,tio,nar,sim,ple,bla,ten,toe,cho,co,lat,spe,ak,er,po,co,lor,pen,cil,li,ght,wh,at,the,he,ck,is,mam,bo,no,fi,ve,any,way,pol,iti,cs,ra,dio,sou,rce,sea,rch,pa,per,com,bo,sp,eak,st,fi,rst,gr,oup,boy,ea,gle,tr,ail,bi,ble,brb,pri,dee,kay,en,be,se";
		$syllable_array = explode(",", $syllables);
		srand((double)microtime() * 1000000);
		for ($count = 1;$count <= 4;$count++){
			if (rand() % 10 == 1){
				$makepass .= sprintf("%0.0f", (rand() % 50) + 1);
			}
			else{
				$makepass .= sprintf("%s", $syllable_array[rand() % 62]);
			}
		}
		return($makepass);
	}
	
	function show_avatar(){
		global $bgcolor2, $theme;
		
		echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n"
		. "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"fr\">\n"
		. "<head><title>" . _AVATARLIST . "</title>\n"
		. "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />\n"
		. "<meta http-equiv=\"content-style-type\" content=\"text/css\" />\n"
		. "<link title=\"style\" type=\"text/css\" rel=\"stylesheet\" href=\"themes/" . $theme . "/style.css\" /></head>\n"
		. "<body style=\"background: " . $bgcolor2 . ";\">\n"
		. "<table width=\"100%\"><tr><td align=\"center\"><b>" . _CLICAVATAR . "</b></td></tr>\n"
		. "<tr><td>&nbsp;</td></tr><tr><td align=\"center\">\n";
		
		echo "<script type=\"text/javascript\">\n"
		."<!--\n"
		."\n"
		."function go(img) {\n"
		."opener.document.getElementById('edit_avatar').value=img;\n"
		."}\n"
		."\n"
		. "// -->\n"
		. "</script>\n";
		
		if ($dir = @opendir("modules/Forum/images/avatar/")){
			while (false !== ($f = readdir($dir))){
				if ($f != "." && $f != ".." && $f != "index.html" && $f != "Thumbs.db"){
					$avatar = "modules/Forum/images/avatar/" . $f . "";
					echo " <a href=\"#\" onclick=\"javascript:go('" . $avatar . "');\"><img style=\"border: 0;\" src=\"modules/Forum/images/avatar/" . $f . "\" alt=\"\" title=\"" . $f . "\" /></a>";
				}
			}
			closedir($dir);
		}
		echo "</td></tr><tr><td>&nbsp;</td></tr>\n"
		. "<tr><td align=\"center\"><b>[ <a href=\"#\" onclick=\"self.close()\">" . _CLOSEWINDOWS . "</a> ]</b></td></tr>\n"
		. "<tr><td>&nbsp;</td></tr></table></body></html>";
	}
	
	function change_theme(){
		global $user, $nuked, $cookie_theme;
		
		$cookietheme = $_COOKIE[$cookie_theme];
		
		echo '<div id="User">';
		leftpannel();
		echo '<div class="profiledroit"><div class="block-widget"><div class="block-widget-header">' . _SELECTTHEME . '</div><div class="block-widget-content">
		<form method="post" action="index.php?file=User&amp;nuked_nude=index&amp;op=modif_theme">
        <table class="table table-striped">
        <tr><td><select name="user_theme">';
		
		if ($cookietheme != ""){
			$mod = $cookietheme;
		}
		else{
			$mod = $nuked['theme'];
		}
		
		$handle = opendir('themes');
		while (false !== ($f = readdir($handle))){
			if ($f != "." && $f != ".." && $f != "CVS" && $f != "index.html" && !preg_match("`[.]`", $f)){
				if ($mod == $f){
					$checked = "selected=\"selected\"";
				}
				else{
					$checked = "";
				}
				echo "<option value=\"" . $f . "\" " . $checked . ">" . $f . "</option>\n";
			}
		}
		
		closedir($handle);
		echo "</select></td></tr><tr><td align=\"center\"><input class=\"btn\" type=\"submit\" value=\"" . _CHANGETHEME . "\" /></td></tr></table></form></div></div>\n";
	}
	
	function modif_theme(){
		global $user, $nuked, $cookie_theme, $timelimit;
		
		$dir = "themes/" . $_REQUEST['user_theme'];
		
		if (is_dir($dir) && $_REQUEST['user_theme']){
			setcookie($cookie_theme, $_REQUEST['user_theme'], $timelimit);
			
			if ($user){
				$upd = mysql_query("UPDATE " . USER_TABLE . " SET user_theme = '" . $_REQUEST['user_theme'] . "' WHERE id = '" . $user[0] . "'");
			}
		}
		
		header("Location:index.php");
	}
	
	function modif_langue(){
		global $user, $nuked, $cookie_langue, $timelimit;
		
		if ($_REQUEST['user_langue'] != ""){
			setcookie($cookie_langue, $_REQUEST['user_langue'], $timelimit);
			
			if ($user){
				$upd = mysql_query("UPDATE " . USER_TABLE . " SET user_langue = '" . $_REQUEST['user_langue'] . "' WHERE id = '" . $user[0] . "'");
			}
		}
		
		header("Location:index.php");
	}
	
	function validation() {
		global $user, $nuked;
		
		if ($nuked['validation'] == 'mail') {
			$sql = mysql_query('SELECT niveau FROM ' . USER_TABLE . ' WHERE id = "' . $_REQUEST['id_user'] . '"');
			list($niveau) = mysql_fetch_array($sql);
			
			if ($niveau > 0) {
				echo '<br /><br /><div style="text-align: center">' . _ALREADYVALID . '</div><br /><br />';
				redirect('index.php?file=User', 3);
			}
			else {
				$upd = mysql_query('UPDATE ' . USER_TABLE . ' SET niveau = 1 WHERE id = "' . $_REQUEST['id_user'] . '"');
				
				echo '<br /><br /><div style="text-align: center">' . _VALIDUSER . '</div><br /><br />';
				redirect('index.php?file=User&op=login_screen', 3);
			}
		}
		else {
			echo '<br /><br /><div style="text-align: center">' . _NOENTRANCE . '</div><br /><br />';
			redirect('index.php?file=User&op=login_screen', 2);
		}
	}
	
	/**
		* Delete moderator from FORUM_TABLE with a user ID
		* @param integer $idUser : a user ID
		* @return bool : true if delete success, false if not
	*/
	function delModerator($idUser)
	{
		$resultQuery = mysql_query("SELECT id,moderateurs FROM " . FORUM_TABLE . " WHERE moderateurs LIKE '%" . $idUser . "%'");
		while (list($forumID, $listModos) = mysql_fetch_row($resultQuery))
		{
			if (is_int(strpos($listModos, '|'))) //Multiple moderators in this category
			{
				var_dump($listModos);
				$tmpListModos = explode('|', $listModos);
				$tmpKey = array_search($idUser, $tmpListModos);
				if ($tmpKey !== false)
				{
					unset($tmpListModos[$tmpKey]);
					$tmpListModos = implode('|', $tmpListModos);
					$updateQuery = mysql_query("UPDATE " . FORUM_TABLE . " SET moderateurs = '" . $tmpListModos . "' WHERE id = '" . $forumID . "'");
				}
			}
			else
			{
				if ($idUser == $listModos) // Only one moderator in this category
				{
					$updateQuery = mysql_query("UPDATE " . FORUM_TABLE . " SET moderateurs = '' WHERE id = '" . $forumID . "'");
				}
				// Else, no moderator in this category
			}
		}
		if ($resultQuery)
        return true;
		else
        return false;
	}
    
	
	function del_account($pass){
		global $user, $nuked;
		
		if ($pass != "" && $nuked[user_delete] == "on"){
			$sql = mysql_query("SELECT pass FROM " . USER_TABLE . " WHERE id = '" . $user[0] . "'");
			$dbpass = mysql_fetch_row($sql);
			if (Check_Hash($pass, $dbpass[0])){
				$del1 = delModerator($user[0]);
				$del2 = mysql_query("DELETE FROM " . SESSIONS_TABLE . " WHERE user_id = '" . $user[0] . "'");
				$del3 = mysql_query("DELETE FROM " . USER_TABLE . " WHERE id = '" . $user[0] . "'");
				echo "<br /><br /><div style=\"text-align: center;\">" . _ACCOUNTDELETE . "</div><br /><br />";
				redirect("index.php", 2);
			}
			else{
				echo "<br /><br /><div style=\"text-align: center;\">" . _BADPASSWORD . "</div><br /><br />";
				redirect("index.php?file=User&op=edit_account", 2);
			}
		}
		else{
			echo "<br /><br /><div style=\"text-align: center;\">" . stripslashes(_NOPASSWORD) . "</div><br /><br />";
			redirect("index.php?file=User&op=edit_account", 2);
		}
	}
	function edit_games() {
		global $user, $nuked;
		echo '<div id="User">';
		leftpannel();
		
		function show_game_list() {
			global $user, $nuked;
			echo '<div class="profiledroit">';
			echo '<div class="block-widget"><div class="block-widget-header">' . _PREFGAMES . '</div><div class="block-widget-content"><div class="showgamelist">
			<table class="table table-striped"><thead><tr><td>' . _NAME . '</td><td>' . _EDIT. '</td><td>' . _SUPPR . '</td></tr></thead><tbody>';
			$sql = mysql_query("SELECT game FROM " . GAMES_PREFS_TABLE . " WHERE user_id = '" . $user[0] . "'");
			$check = mysql_num_rows($sql);
			if($check > 0) {
			while (list($games) = mysql_fetch_array($sql)){
			$sql1 = mysql_query("SELECT name FROM " . GAMES_TABLE . " WHERE id = '" . $games . "'");
			while (list($nom) = mysql_fetch_array($sql1)){
			echo '<tr><td>' . $nom . '</td><td><a href="index.php?file=User&op=edit_games&action=edit_games_list&game=' . $games .'"><i class="icon-pencil"></i></a></td>
			<td><a href="index.php?file=User&op=edit_games&action=remove_game&game=' . $games .'"><i class="icon-remove"></i></a></td></tr>';
			}
			}
			}
			else {
				echo '<tr><td colspan="3">' . _NOGAMESINLIST .'</td></tr>';
			}
			echo '</tbody><tfoot><tr><td colspan="3">
			<a class="btn btn-small btn-primary" href="index.php?file=User&op=edit_games&action=edit_games_list"><i class="icon-th-list icon-white"></i> ' . _ADDGAME . '</a>
			</td></tr></tfoot></table></div></div></div></div></div>';
		}
		
		function edit_games_list() {
			global $user, $nuked;
			echo '<div class="profiledroit">';
			echo '<div class="block-widget"><div class="block-widget-header">' . _ADDGAME . ' : </div><div class="block-widget-content"><div class="editgameslist">';
			if(isset($_REQUEST['game'])) {
				$sql = mysql_query("SELECT titre, description, icon, pref_1, pref_2, pref_3, pref_4, pref_5 FROM " . GAMES_TABLE . " WHERE id = '" . $_REQUEST['game'] . "'");
				$check = mysql_num_rows($sql);
				if($check == 0)
				{
					echo '<div style="text-align: center">' . _NOENTRANCE . '</div>';
					redirect('index.php?file=User&op=edit_games', 2);
				}
				else {
					list($titre, $description, $icon, $gpref1, $gpref2, $gpref3, $gpref4, $gpref5) = mysql_fetch_array($sql);
					$sql2 = mysql_query("SELECT pref_1, pref_2, pref_3, pref_4, pref_5 FROM " . GAMES_PREFS_TABLE . " WHERE game = '" . $_REQUEST['game'] . "' AND user_id = '" . $user[0] . "'");
					$check2 = mysql_num_rows($sql2);
					if ($check2 > 0){
						list($pref1, $pref2, $pref3, $pref4, $pref5) = mysql_fetch_array($sql2);
						$pref1 = $pref1;
						$pref2 = $pref2;
						$pref3 = $pref3;
						$pref4 = $pref4;
						$pref5 = $pref5;
					}
					$description = html_entity_decode($description);
					echo '<form method="post" action="index.php?file=User&op=edit_games&action=update_game"><table class="table table-striped table-condensed"><thead>';
					if ($icon != '' && $description != '') {
						echo '<tr><td><img class="img-polaroid" src="' . $icon . '"></td><td>' . $description .'</td></tr></thead>';
					}
					else if ($description != '')
					{
						echo '<tr><td colspan="2">' . $description .'</td></tr></thead>';
					}
					echo '<tbody><tr><td colspan="2">' . $titre . '</td>
					<input type="hidden" name="game" value="' . $_REQUEST['game'] . '">
					<tr><td>' . $gpref1 . '</td><td><input type="text" name="pref1" value="' . $pref1 . '"/></td></tr>
					<tr><td>' . $gpref2 . '</td><td><input type="text" name="pref2" value="' . $pref2 . '"/></td></tr>
					<tr><td>' . $gpref3 . '</td><td><input type="text" name="pref3" value="' . $pref3 . '"/></td></tr>
					<tr><td>' . $gpref4 . '</td><td><input type="text" name="pref4" value="' . $pref4 . '"/></td></tr>
					<tr><td>' . $gpref5 . '</td><td><input type="text" name="pref5" value="' . $pref5 . '"/></td></tr>
					</tbody><tfoot><tr><td colspan="2"><input class="btn" type="submit" name="Submit" value="' . _CONFIRM . '"/></td></table></form>';
				}
			}
			else {
				$sql = mysql_query("SELECT id, name FROM " . GAMES_TABLE . " ORDER BY name");
				$check = mysql_num_rows($sql);
				if($check > 0)
				{
					echo '<form method="post" action="index.php?file=User&op=edit_games&action=edit_games_list">
					<select name="game">';
					while (list($game_id, $nom) = mysql_fetch_array($sql)){
					$sql_verif = mysql_query("SELECT * FROM " . GAMES_PREFS_TABLE . " WHERE user_id = '" . $user[0] . "' AND game = '" . $game_id . "'");
					$check = mysql_num_rows($sql_verif);
					if($check == 0)
					echo '<option value="' . $game_id . '">' . $nom . '</option>';
					}
					echo '</select><input class="btn" type="submit" name="Submit" value="' . _ADD . '"/></form>';
				}
				else {
					echo _NOGAMES;
				}
			}
			echo '</div></div></div></div></div>';
		}
		function update_game($game, $pref1, $pref2, $pref3, $pref4, $pref5) 
		{
		global $user, $nuked;
		echo '<div class="profiledroit">';
		echo '</div>';
		$pref1 = htmlentities($pref1);
        $pref2 = htmlentities($pref2);
        $pref3 = htmlentities($pref3);
        $pref4 = htmlentities($pref4);
        $pref5 = htmlentities($pref5);
		$pref1 = mysql_real_escape_string(stripslashes($pref1));
        $pref2 = mysql_real_escape_string(stripslashes($pref2));
        $pref3 = mysql_real_escape_string(stripslashes($pref3));
        $pref4 = mysql_real_escape_string(stripslashes($pref4));
        $pref5 = mysql_real_escape_string(stripslashes($pref5));
		
		$sql = mysql_query("SELECT * FROM " . GAMES_PREFS_TABLE . " WHERE user_id = '" . $user[0] . "' AND game = '" . $_REQUEST['game'] . "'");
        $check = mysql_num_rows($sql);
        if ($check > 0){
        $update = mysql_query("UPDATE " . GAMES_PREFS_TABLE . " SET pref_1 = '" . $pref1 . "', pref_2 = '" . $pref2 . "', pref_3 = '" . $pref3 . "', pref_4 = '" . $pref4 . "', pref_5 = '" . $pref5 . "' WHERE user_id = '" . $user[0] . "' AND game = '" . $_REQUEST['game'] . "'");
		}
        else{
        $create = mysql_query("INSERT INTO " . GAMES_PREFS_TABLE . " ( `id` , `game` , `user_id` , `pref_1` , `pref_2` , `pref_3` , `pref_4` , `pref_5` ) VALUES( '' , '" . $_REQUEST['game'] . "' , '" . $user[0] . "' , '" . $pref1 . "' , '" . $pref2 . "' , '" . $pref3 . "' , '" . $pref4 . "' , '" . $pref5 . "' )");
		}
		redirect("index.php?file=User&op=edit_games", 1);
		}
		
		function remove_game($game) {
		echo '<div class="profiledroit">';
		echo '</div>';
		global $user, $nuked;
		$delete = mysql_query("DELETE FROM " . GAMES_PREFS_TABLE . " WHERE user_id = '" . $user[0] . "' AND game = '" . $game . "'");
		redirect("index.php?file=User&op=edit_games", 1);
		}
		
		switch ($_REQUEST['action']) {
		case"edit_games_list":
		edit_games_list($_REQUEST['game']);
		break;
		case"update_game":
		update_game($_REQUEST['game'],$_REQUEST['pref1'],$_REQUEST['pref2'],$_REQUEST['pref3'],$_REQUEST['pref4'],$_REQUEST['pref5']);
		break;
		case"remove_game":
		remove_game($_REQUEST['game']);
		break;
		default:
		show_game_list();
		break;
		}
		}
		
		switch ($_REQUEST['op']){
		case"edit_account":
        opentable();
        edit_account();
        closetable();
        break;
		case"edit_pref":
        opentable();
        edit_pref();
        closetable();
        break;
		case"index":
        index();
        break;
		case"reg_screen":
        opentable();
        reg_screen();
        closetable();
        break;
		case"login_screen":
        login_screen();
        break;
		case"reg":
        opentable();
        reg($_REQUEST['pseudo'], $_REQUEST['mail'], $_REQUEST['email'], $_REQUEST['pass_reg'], $_REQUEST['pass_conf'], $_REQUEST['game'], $_REQUEST['country']);
        closetable();
        break;
		case"login":
        login($_REQUEST['pseudo'], $_REQUEST['pass'], $_REQUEST['remember_me']);
        break;
		case"login_message":
        login_message();
        break;
		case"update":
        opentable();
        update($_REQUEST['nick'], $_REQUEST['pass'], $_REQUEST['mail'], $_REQUEST['email'], $_REQUEST['url'], $_REQUEST['pass_reg'], $_REQUEST['pass_conf'], $_REQUEST['pass_old'], $_REQUEST['icq'], $_REQUEST['msn'], $_REQUEST['aim'], $_REQUEST['yim'], $_REQUEST['avatar'], $_REQUEST['fichiernom'], $_REQUEST['signature'], $_REQUEST['game'], $_REQUEST['country'], $_REQUEST['remove'], $_REQUEST['xfire'], $_REQUEST['facebook'], $_REQUEST['origin'], $_REQUEST['steam'], $_REQUEST['twitter'], $_REQUEST['skype']);
        closetable();
        break;
		case"update_pref":
        opentable();
        update_pref($_REQUEST['prenom'], $_REQUEST['jour'], $_REQUEST['mois'], $_REQUEST['an'], $_REQUEST['sexe'], $_REQUEST['ville'], $_REQUEST['motherboard'], $_REQUEST['cpu'], $_REQUEST['ram'], $_REQUEST['video'], $_REQUEST['resolution'], $_REQUEST['sons'], $_REQUEST['ecran'], $_REQUEST['souris'], $_REQUEST['clavier'], $_REQUEST['connexion'], $_REQUEST['osystem'], $_REQUEST['photo'], $_REQUEST['fichiernom']);
        closetable();
        break;
		case"logout":
        logout();
        break;
		case"oubli_pass":
        opentable();
        oubli_pass();
        closetable();
        break;
		case"envoi_pass":
        opentable();
        envoi_pass($_REQUEST['email'], $_REQUEST['token']);
        closetable();
        break;
		case"show_avatar":
        show_avatar();
        break;
		case"change_theme":
        opentable();
        change_theme();
        closetable();
        break;
		case"modif_theme":
        modif_theme($_REQUEST);
        break;
		case"modif_langue":
        modif_langue($_REQUEST);
        break;
		case"validation":
        opentable();
        validation();
        closetable();
        break;
		case"del_account":
        opentable();
        del_account($_REQUEST['pass']);
        closetable();
        break;
		case"envoi_mail":
        opentable();
        envoi_mail($_REQUEST['email']);
        closetable();
        break;
		case"edit_games":
		opentable();
		edit_games();
		closetable();
		break;
		default:
        index();
        break;
		}
		?>
