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

global $language, $user;
translate("modules/Forum/lang/" . $language . ".lang.php");
define('FORUM_PRIMAIRE_TABLE', $nuked['prefix'] . '_forums_primaire');
include("modules/Admin/design.php");
admintop();

if (!$user)
{
    $visiteur = 0;
}
else
{
    $visiteur = $user[1];
}
$ModName = basename(dirname(__FILE__));
$level_admin = admin_mod($ModName);
if ($visiteur >= $level_admin && $level_admin > -1)
{
    function main_cat()
    {
        global $nuked, $language;

        echo "<script type=\"text/javascript\">\n"
			."<!--\n"
			."\n"
			. "function delcat(titre, id)\n"
			. "{\n"
			. "if (confirm('" . _DELETEFORUM . " '+titre+' ! " . _CONFIRM . "'))\n"
			. "{document.location.href = 'index.php?file=Forum&page=admin&op=del_cat&cid='+id;}\n"
			. "}\n"
			. "\n"
			. "// -->\n"
			. "</script>\n";

    echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
			. "<div class=\"content-box-header\"><h3>" . _ADMINFORUMCAT . "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Forum.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div>\n"
			. "</div>\n"
			. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\"><b><a href=\"index.php?file=Forum&amp;page=admin\">" . _FORUM . "</a></b> | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=add_forum\">" . _ADDFORUM . "</a></b> | ";
      if ($nuked['forum_cat_prim'] == "on")
{ 
			echo "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_cat_primaire\">" . _CATPRIMAIREMANAGEMENT . "</a></b> | ";
}
			echo "" . _CATMANAGEMENT . " | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_rank\">" . _RANKMANAGEMENT . "</a></b> | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=prune\">" . _PRUNE . "</a></b> | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=skin\">" . _SKINS . "</a></b> | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_pref\">" . _PREFS . "</a></b></div><br />\n"
			. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" width=\"70%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
			. "<tr>\n"
			. "<td style=\"width: 20%; text-align: center;\" align=\"center\"><b>" . _CATSECONDAIRE . "</b></td>\n"
			. "<td style=\"width: 20%; text-align: center;\" align=\"center\"><b>" . _CATAPPARTENANCE . "</b></td>\n"
			. "<td style=\"width: 20%; text-align: center;\" align=\"center\"><b>" . _CATPRIMAIRE . "</b></td>\n"
			. "<td style=\"width: 8%; text-align: center;\" align=\"center\"><b>" . _LEVELACCES . "</b></td>\n"
			. "<td style=\"width: 8%; text-align: center;\" align=\"center\"><b>" . _LEVELPOST . "</b></td>\n"
			. "<td style=\"width: 8%; text-align: center;\" align=\"center\"><b>" . _ORDER . "</b></td>\n"
			. "<td style=\"width: 8%; text-align: center;\" align=\"center\"><b>" . _EDIT . "</b></td>\n"
			. "<td style=\"width: 8%; text-align: center;\" align=\"center\"><b>" . _DEL . "</b></td></tr>\n";

	    $sql = mysql_query("SELECT A.id, A.cat_primaire, A.nom, A.level, A.ordre, A.niveau, B.nom FROM " . FORUM_CAT_TABLE . " AS A LEFT JOIN " . FORUM_PRIMAIRE_TABLE . " AS B ON B.id = A.cat_primaire ORDER BY B.ordre, B.nom, A.ordre, A.nom");
        while (list($cid, $cat_primaire, $nom, $level, $ordre, $niveau, $cat_name) = mysql_fetch_row($sql))
        {
           $nom = printSecuTags($nom);
           $cat_name = printSecuTags($cat_name);
		   
		   if($cat_name) $cat_name = $cat_name; else $cat_name = _CATNONE;
           
            echo "<tr>\n"
            . "<td style=\"width: 20%; text-align: center;\" align=\"center\">" . $nom . "</td>\n"
            . "<td style=\"width: 20%; text-align: center;\" align=\"center\"><img style=\"border: 0;\" src=\"modules/Forum/images/fl.gif\" alt=\"\" title=\"\" />&nbsp;&nbsp;" . _CATFL . "&nbsp;&nbsp;<img style=\"border: 0;\" src=\"modules/Forum/images/fl.gif\" alt=\"\" title=\"\" /></td>\n"
            . "<td style=\"width: 20%; text-align: center;\" align=\"center\">" . $cat_name . "</td>\n"
            . "<td style=\"width: 8%; text-align: center;\" align=\"center\">" . $niveau . "</td>\n"
            . "<td style=\"width: 8%; text-align: center;\" align=\"center\">" . $level . "</td>\n"
            . "<td style=\"width: 8%; text-align: center;\" align=\"center\">" . $ordre . "</td>\n"
            . "<td style=\"width: 8%; text-align: center;\" align=\"center\"><a href=\"index.php?file=Forum&amp;page=admin&amp;op=edit_cat&amp;cid=" . $cid . "\"><img style=\"border: 0;\" src=\"images/edit.gif\" alt=\"\" title=\"" . _EDITTHISCAT . "\" /></a></td>\n"
            . "<td style=\"width: 8%; text-align: center;\" align=\"center\"><a href=\"javascript:delcat('" . mysql_real_escape_string(stripslashes($nom)) . "', '" . $cid . "');\"><img style=\"border: 0;\" src=\"images/del.gif\" alt=\"\" title=\"" . _DELTHISCAT . "\" /></a></td></tr>\n";
        }

        echo "</table><br /><div style=\"text-align: center;\">[ <a href=\"index.php?file=Forum&amp;page=admin&amp;op=add_cat\"><b>" . _ADDCAT . "</b></a> ]</div>\n"
			. "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Forum&amp;page=admin\"><b>" . _BACK . "</b></a> ]</div><br /></div></div>\n";
    }

    function add_cat()
    {
        global $nuked, $language;

       echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
			. "<div class=\"content-box-header\"><h3>" . _ADMINFORUMCATADD . "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Forum.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div>\n"
			. "</div>\n"
//message top    
    . "<div style=\"padding: 20px 20px 0 20px;\">\n"
    . "<div class=\"notification attention png_bg\" >\n"
    ."<a href=\"#\" class=\"close\"><img src=\"modules/Admin/images/icons/cross_grey_small.png\" title=\"Fermer la notification\" alt=\"close\" /></a>\n"
		. "<div>\n"
		. "" . _CATIMAGESIZE . "\n"
		. "</div>\n"
		. "</div>\n"
		. "</div>\n"	
//end top message  			
			. "<div class=\"tab-content\" id=\"tab2\"><form method=\"post\" action=\"index.php?file=Forum&amp;page=admin&amp;op=send_cat\" enctype=\"multipart/form-data\">\n"
			. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" cellspacing=\"1\" cellpadding=\"2\" border=\"0\">\n"
			. "<tr><td><b>" . _NAME . " :</b> <input type=\"text\" name=\"nom\" size=\"30\" /></td></tr>\n";
			if($nuked['forum_cat_prim'] == "on")
      {
			echo "<tr><td><b>" . _CATPRIMAIRE . " :</b> <select name=\"cat\">\n";
				select_forum_pri();

      echo"</select></td></tr>\n";
      }
			echo "<tr><td align=\"left\"><b>" . _DESCR . " : </b><br /><textarea class=\"editor\" name=\"description\" rows=\"10\" cols=\"69\"></textarea></td></tr>\n"
      . "<tr><td><b>" . _MAINIMAGE . " :</b> <input type=\"text\" name=\"urlimage\" size=\"42\" /></td></tr>\n"
      . "<tr><td><b>" . _UPLOADMAINIMAGE . " :</b> <input type=\"file\" name=\"upimage\" /></td></tr>\n";
      if ($nuked['forum_cat_prim'] == "on")
{ 
    echo "<tr><td><b>" . _IMAGEMINI . " :</b> <input type=\"text\" name=\"urlimagemini\" size=\"42\" /></td></tr>\n"
      . "<tr><td><b>" . _UPLOADIMAGEMINI . " :</b> <input type=\"file\" name=\"upimagemini\" /></td></tr>\n";
}    		
			echo "<tr><td><b>" . _LEVELACCES . " :</b> <select name=\"niveau\">\n"
			. "<option>0</option>\n"
			. "<option>1</option>\n"
			. "<option>2</option>\n"
			. "<option>3</option>\n"
			. "<option>4</option>\n"
			. "<option>5</option>\n"
			. "<option>6</option>\n"
			. "<option>7</option>\n"
			. "<option>8</option>\n"
			. "<option>9</option></select>"
			. "&nbsp;<b>" . _LEVELPOST . " :</b> <select name=\"level\">\n"
			. "<option>0</option>\n"
			. "<option>1</option>\n"
			. "<option>2</option>\n"
			. "<option>3</option>\n"
			. "<option>4</option>\n"
			. "<option>5</option>\n"
			. "<option>6</option>\n"
			. "<option>7</option>\n"
			. "<option>8</option>\n"
			. "<option>9</option></select>\n"
			. "&nbsp;<b>" . _ORDER . " :</b> <input type=\"text\" name=\"ordre\" value=\"0\" size=\"2\" /></td></tr>\n"
			. "<tr><td><b>" . _MODERATEUR . " :</b> <select name=\"modo\"><option value=\"\">" . _NONE . "</option>\n";

				$sql = mysql_query("SELECT id, pseudo FROM " . USER_TABLE . " WHERE niveau > 0 ORDER BY niveau DESC, pseudo");
				while (list($id_user, $pseudo) = mysql_fetch_row($sql))
				{

					echo "<option value=\"" . $id_user . "\">" . $pseudo . "</option>\n";
				}

			echo "</select></td></tr></table>\n"
			. "<div style=\"text-align: center;\"><br /><input type=\"submit\" value=\"" . _CREATECAT . "\" /></div>"
			. "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_cat\"><b>" . _BACK . "</b></a> ]</div></form><br /></div></div>\n";
    }

    function send_cat($nom, $cat, $description, $niveau, $level, $ordre, $modo, $urlimage, $upimage, $urlimagemini, $upimagemini)
    {
        global $nuked, $user;

        $nom = mysql_real_escape_string(stripslashes($nom));
        $description = html_entity_decode($description);
        $description = mysql_real_escape_string(stripslashes($description));

        $filename = $_FILES['upimage']['name'];
        if ($filename != "") {
          $ext = pathinfo($filename, PATHINFO_EXTENSION);

          if ($ext == "jpg" || $ext == "jpeg" || $ext == "JPG" || $ext == "JPEG" || $ext == "gif" || $ext == "GIF" || $ext == "png" || $ext == "PNG") {
            $url_image = "upload/Forum/cat/" . $filename;
            move_uploaded_file($_FILES['upimage']['tmp_name'], $url_image) or die ("<br /><br /><div style=\"text-align: center;\"><b>Upload file failed !!!</b></div><br /><br />");
            @chmod ($url_image, 0644);
          } else {
            echo "<div class=\"notification error png_bg\">\n"
               . "<div>\n"
               . "No image file !"
               . "</div>\n"
               . "</div>\n";
            redirect("index.php?file=News&page=admin", 2);
            adminfoot();
            footer();
            die;
          }
        } else {
          $url_image = $urlimage;
        }

        $filename2 = $_FILES['upimagemini']['name'];
        if ($filename2 != "") {
          $ext2 = pathinfo($filename2, PATHINFO_EXTENSION);

          if ($ext2 == "jpg" || $ext2 == "jpeg" || $ext2 == "JPG" || $ext2 == "JPEG" || $ext2 == "gif" || $ext2 == "GIF" || $ext2 == "png" || $ext2 == "PNG") {
            $url_imagemini = "upload/Forum/cat/" . $filename2;
            move_uploaded_file($_FILES['upimagemini']['tmp_name'], $url_imagemini) or die ("<br /><br /><div style=\"text-align: center;\"><b>Upload file failed !!!</b></div><br /><br />");
            @chmod ($url_imagemini, 0644);
          } else {
            echo "<div class=\"notification error png_bg\">\n"
               . "<div>\n"
               . "No image file !"
               . "</div>\n"
               . "</div>\n";
            redirect("index.php?file=News&page=admin", 2);
            adminfoot();
            footer();
            die;
          }
        } else {
          $url_imagemini = $urlimagemini;
        }


		if(!$cat && $nuked['forum_cat_prim'] == "on")
		{
        echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. "" . _CATNOTADD . "\n"
			. "</div>\n"
			. "</div>\n"
			. "<div style=\"text-align: center;\"><br />[ <a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a> ]</div>\n";
		}else{
		
			$sql = mysql_query("INSERT INTO " . FORUM_CAT_TABLE . " ( `id`, `cat_primaire` , `nom` , `level` , `ordre` , `niveau` , `moderateurs` , `comment` , `image`, `imagemini` ) VALUES ( '' , '" . $cat . "' , '" . $nom . "' , '" . $level. "' , '" . $ordre . "' , '" . $niveau . "' , '" . $modo . "' , '" . $description . "' , '" . $url_image . "' , '" . $url_imagemini . "' )");
			
			// Action
			$texteaction = "". _ACTIONADDCATFO .": ".$nom."";
			$acdate = time();
			$sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
			//Fin action
			
			echo "<div class=\"notification success png_bg\">\n"
				. "<div>\n"
				. "" . _CATADD . "\n"
				. "</div>\n"
				. "</div>\n";
			echo "<script>\n"
				."setTimeout('screen()','3000');\n"
				."function screen() { \n"
				."screenon('index.php?file=Forum', 'index.php?file=Forum&page=admin&op=main_cat');\n"
				."}\n"
				."</script>\n";
		}
    }

    function del_cat($cid)
    {
        global $nuked, $user;
        
        $sql2 = mysql_query("SELECT nom FROM " . FORUM_CAT_TABLE . " WHERE id = '" . $cid . "'");
        list($nom) = mysql_fetch_array($sql2);
		
        $nom = mysql_real_escape_string($nom);
        $sql = mysql_query("DELETE FROM " . FORUM_CAT_TABLE . " WHERE id = '" . $cid . "'");
		
        // Action
        $texteaction = "". _ACTIONDELCATFO .": ".$nom."";
        $acdate = time();
        $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
        //Fin action		
        echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. "" . _CATDEL . "\n"
			. "</div>\n"
			. "</div>\n";
        echo "<script>\n"
            ."setTimeout('screen()','3000');\n"
            ."function screen() { \n"
            ."screenon('index.php?file=Forum', 'index.php?file=Forum&page=admin&op=main_cat');\n"
            ."}\n"
            ."</script>\n";
    }

    function edit_cat($cid)
    {
        global $nuked, $language;

        $sql = mysql_query("SELECT id, nom, cat_primaire, comment, moderateurs, niveau, level, ordre, image, imagemini FROM " . FORUM_CAT_TABLE . " WHERE id = '" . $cid . "'");
        list($id, $titre, $cat, $description, $modo, $niveau, $level, $ordre, $cat_image, $cat_imagemini) = mysql_fetch_array($sql);
		
        $categorie = mysql_query("select nom FROM " . FORUM_PRIMAIRE_TABLE . " WHERE id = '" . $cat . "'");		
        list($cat_name) = mysql_fetch_array($categorie);
		
		if ($modo != "")
        {
            $moderateurs = explode('|', $modo);
            for ($i = 0;$i < count($moderateurs);$i++)
            {
                if ($i > 0) $sep = ', ';
                $sql2 = mysql_query("SELECT id, pseudo FROM " . USER_TABLE . " WHERE id = '" . $moderateurs[$i] . "'");
                list($id_user, $modo_pseudo) = mysql_fetch_row($sql2);
                $modos .= $sep . $modo_pseudo . "&nbsp;(<a href=\"index.php?file=Forum&amp;page=admin&amp;op=del_modocat&amp;uid=" . $id_user . "&amp;cat_id=" . $id . "\"><img width=\"7\" style=\"border: 0;\" src=\"modules/Forum/images/del.gif\" alt=\"\" title=\"" . _DELTHISMODO . "\" /></a>)";
            }
        }
        else
        {
            $modos = _NONE;
        }		
		
		echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
			. "<div class=\"content-box-header\"><h3>" . _ADMINFORUMCATEDIT. "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Forum.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div>\n"
			. "</div>\n"
//message top    
    . "<div style=\"padding: 20px 20px 0 20px;\">\n"
    . "<div class=\"notification attention png_bg\" >\n"
    ."<a href=\"#\" class=\"close\"><img src=\"modules/Admin/images/icons/cross_grey_small.png\" title=\"Fermer la notification\" alt=\"close\" /></a>\n"
		. "<div>\n"
		. "" . _CATIMAGESIZE . "\n"
		. "</div>\n"
		. "</div>\n"
		. "</div>\n"	
//end top message  			
			. "<div class=\"tab-content\" id=\"tab2\"><form method=\"post\" action=\"index.php?file=Forum&amp;page=admin&amp;op=modif_cat\" enctype=\"multipart/form-data\">\n"
			. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" cellspacing=\"1\" cellpadding=\"2\" border=\"0\">\n"
			. "<tr><td><b>" . _NAME . " :</b> <input type=\"text\" name=\"nom\" size=\"30\" value=\"" . $titre . "\" /></td></tr>\n";
			if($nuked['forum_cat_prim'] == "on")
      {
			echo "<tr><td><b>" . _CATPRIMAIRE . " :</b> <select name=\"cat\">\n"
			. "<option value=\"" . $cat . "\">" . $cat_name . "</option>\n";
				select_forum_pri();

      echo"</select></td></tr>\n";
      }
			echo "<tr><td align=\"left\"><b>" . _DESCR . " : </b><br /><textarea class=\"editor\" name=\"description\" rows=\"10\" cols=\"69\">" . $description . "</textarea></td></tr>\n"
      . "<tr><td><b>" . _MAINIMAGE . " :</b> <input type=\"text\" name=\"urlimage\" size=\"42\" value=\"" . $cat_image . "\"/></td></tr>\n"
      . "<tr><td><b>" . _UPLOADMAINIMAGE . " :</b> <input type=\"file\" name=\"upimage\" /></td></tr>\n";
      if ($nuked['forum_cat_prim'] == "on")
{ 
      echo "<tr><td><b>" . _IMAGEMINI . " :</b> <input type=\"text\" name=\"urlimagemini\" size=\"42\" value=\"" . $cat_imagemini . "\"/></td></tr>\n"
      . "<tr><td><b>" . _UPLOADIMAGEMINI . " :</b> <input type=\"file\" name=\"upimagemini\" /></td></tr>\n";
}	      			
			echo "<tr><td><b>" . _LEVELACCES . " :</b> <select name=\"niveau\"><option>" . $niveau . "</option>\n"
			. "<option>0</option>\n"
			. "<option>1</option>\n"
			. "<option>2</option>\n"
			. "<option>3</option>\n"
			. "<option>4</option>\n"
			. "<option>5</option>\n"
			. "<option>6</option>\n"
			. "<option>7</option>\n"
			. "<option>8</option>\n"
			. "<option>9</option></select>"
			. "&nbsp;<b>" . _LEVELPOST . " :</b> <select name=\"level\"><option>" . $level . "</option>\n"
			. "<option>0</option>\n"
			. "<option>1</option>\n"
			. "<option>2</option>\n"
			. "<option>3</option>\n"
			. "<option>4</option>\n"
			. "<option>5</option>\n"
			. "<option>6</option>\n"
			. "<option>7</option>\n"
			. "<option>8</option>\n"
			. "<option>9</option></select>\n"
			. "&nbsp;<b>" . _ORDER . " :</b> <input type=\"text\" name=\"ordre\" value=\"" . $ordre . "\" size=\"2\" /></td></tr>\n"
			. "<tr><td><b>" . _MODO . " :</b> " . $modos . "</td></tr>\n"
			. "<tr><td><b>" . _ADDMODO . " :</b> <select name=\"modo\"><option value=\"\">" . _NONE . "</option>\n";

				$sql = mysql_query("SELECT id, pseudo FROM " . USER_TABLE . " WHERE niveau > 0 ORDER BY niveau DESC, pseudo");
				while (list($id_user, $pseudo) = mysql_fetch_row($sql))
				{
					if (!is_int(strpos($modos, $id_user)))
					{
						echo "<option value=\"" . $id_user . "\">" . $pseudo . "</option>\n";
					}
				}

		echo "</select></td></tr></table>\n"
			. "<div style=\"text-align: center;\"><br /><input type=\"hidden\" name=\"cid\" value=\"" . $cid . "\" /><input type=\"submit\" value=\"" . _MODIFTHISCAT . "\" /></div>"
			. "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_cat\"><b>" . _BACK . "</b></a> ]</div></form><br /></div></div>";
    }

    function modif_cat($cid, $nom, $cat, $description, $niveau, $level, $ordre, $modo, $urlimage, $upimage, $urlimagemini, $upimagemini)
    {
        global $nuked, $user;

		if(!$cat)
		{
			echo "<div class=\"notification error png_bg\">\n"
				. "<div>\n"
				. "" . _CATNOTADD . "\n"
				. "</div>\n"
				. "</div>\n"
				. "<div style=\"text-align: center;\"><br />[ <a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a> ]</div>\n";
		}else{
		
			$nom = mysql_real_escape_string(stripslashes($nom));
			$description = html_entity_decode($description);
			$description = mysql_real_escape_string(stripslashes($description));

        $filename = $_FILES['upimage']['name'];
        if ($filename != "") {
          $ext = pathinfo($filename, PATHINFO_EXTENSION);

          if ($ext == "jpg" || $ext == "jpeg" || $ext == "JPG" || $ext == "JPEG" || $ext == "gif" || $ext == "GIF" || $ext == "png" || $ext == "PNG") {
            $url_image = "upload/Forum/cat/" . $filename;
            move_uploaded_file($_FILES['upimage']['tmp_name'], $url_image) or die ("<br /><br /><div style=\"text-align: center;\"><b>Upload file failed !!!</b></div><br /><br />");
            @chmod ($url_image, 0644);
          } else {
            echo "<div class=\"notification error png_bg\">\n"
               . "<div>\n"
               . "No image file !"
               . "</div>\n"
               . "</div>\n";
            redirect("index.php?file=News&page=admin", 2);
            adminfoot();
            footer();
            die;
          }
        } else {
          $url_image = $urlimage;
        }

        $filename2 = $_FILES['upimagemini']['name'];
        if ($filename2 != "") {
          $ext2 = pathinfo($filename2, PATHINFO_EXTENSION);

          if ($ext2 == "jpg" || $ext2 == "jpeg" || $ext2 == "JPG" || $ext2 == "JPEG" || $ext2 == "gif" || $ext2 == "GIF" || $ext2 == "png" || $ext2 == "PNG") {
            $url_imagemini = "upload/Forum/cat/" . $filename2;
            move_uploaded_file($_FILES['upimagemini']['tmp_name'], $url_imagemini) or die ("<br /><br /><div style=\"text-align: center;\"><b>Upload file failed !!!</b></div><br /><br />");
            @chmod ($url_imagemini, 0644);
          } else {
            echo "<div class=\"notification error png_bg\">\n"
               . "<div>\n"
               . "No image file !"
               . "</div>\n"
               . "</div>\n";
            redirect("index.php?file=News&page=admin", 2);
            adminfoot();
            footer();
            die;
          }
        } else {
          $url_imagemini = $urlimagemini;
        }

        // Correction ajout / edition des modérateurs
        if ($modo != "")
        {
        	// update sur les catégories
            $sql = mysql_query("SELECT moderateurs FROM " . FORUM_CAT_TABLE . " WHERE id = '" . $cid . "'");
            list($listmodo) = mysql_fetch_row($sql);

            if ($listmodo != "") $modos = $listmodo . "|" . $modo;
            else $modos = $modo;

            $upd_modo = mysql_query("UPDATE " . FORUM_CAT_TABLE . " SET moderateurs = '" . $modos . "' WHERE id = '" . $cid . "'");

            // update sur le forum
            $sqls = mysql_query("SELECT moderateurs FROM " . FORUM_TABLE . " WHERE cat = '" . $cid . "'");
            list($slistmodo) = mysql_fetch_row($sqls);

            if ($slistmodo != "") $smodos = $slistmodo . "|" . $modo;
            else $smodos = $modo;
			$upd_modo = mysql_query("UPDATE " . FORUM_TABLE . " SET moderateurs = '" . $smodo . "' WHERE cat = '" . $cid . "'");
        }
        //////////////////////////////////////////////

			$sql = mysql_query("UPDATE " . FORUM_CAT_TABLE . " SET nom = '" . $nom . "', cat_primaire = '" . $cat . "', comment = '" . $description . "', niveau = '" . $niveau . "', level = '" . $level . "', ordre = '" . $ordre . "', image = '" . $url_image . "', imagemini = '" . $url_imagemini . "' WHERE id = '" . $cid . "'");
			$sql_forum = mysql_query("UPDATE " . FORUM_TABLE . " SET niveau = '" . $niveau . "' WHERE cat = '" . $cid . "'");

			
			// Action
			$texteaction = "". _ACTIONMODIFCATFO .": ".$nom."";
			$acdate = time();
			$sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
			//Fin action
			echo "<div class=\"notification success png_bg\">\n"
				. "<div>\n"
				. "" . _CATMODIF . "\n"
				. "</div>\n"
				. "</div>\n";
			echo "<script>\n"
				."setTimeout('screen()','3000');\n"
				."function screen() { \n"
				."screenon('index.php?file=Forum', 'index.php?file=Forum&page=admin&op=main_cat');\n"
				."}\n"
				."</script>\n";
		}
    }

    function select_forum_cat()
    {
        global $nuked;

        $sql = mysql_query("SELECT id, nom FROM " . FORUM_CAT_TABLE . " ORDER BY ordre, nom");
        while (list($cid, $nom) = mysql_fetch_row($sql))
        {
            $nom = printSecuTags($nom);

            echo "<option value=\"" . $cid . "\">" . $nom . "</option>\n";
        }
    }

    function add_forum()
    {
        global $nuked, $language;

       echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
			. "<div class=\"content-box-header\"><h3>" . _ADMINFORUMADD . "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Forum.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div>\n"
			. "</div>\n"
			. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\"><b><a href=\"index.php?file=Forum&amp;page=admin\">" . _FORUM . "</a></b> | "
			. "" . _ADDFORUM . " | ";
      if ($nuked['forum_cat_prim'] == "on")
{ 
			echo "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_cat_primaire\">" . _CATPRIMAIREMANAGEMENT . "</a></b> | ";
}
			echo "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_cat\">" . _CATMANAGEMENT . "</a></b> | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_rank\">" . _RANKMANAGEMENT . "</a></b> | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=prune\">" . _PRUNE . "</a></b> | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=skin\">" . _SKINS . "</a></b> | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_pref\">" . _PREFS . "</a></b></div><br />\n"
			. "<form method=\"post\" action=\"index.php?file=Forum&amp;page=admin&amp;op=send_forum\" enctype=\"multipart/form-data\">\n"
			. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" cellspacing=\"1\" cellpadding=\"2\" border=\"0\">\n"
			. "<tr><td><b>" . _NAME . " :</b> <input type=\"text\" name=\"titre\" size=\"30\" /></td></tr>\n"
			. "<tr><td><b>" . _CATSECONDAIRE . " :</b> <select name=\"cat\">\n";

        select_forum_cat();

        echo"</select></td></tr>\n"
			. "<tr><td align=\"left\"><b>" . _DESCR . " : </b><br /><textarea class=\"editor\" name=\"description\" rows=\"10\" cols=\"69\"></textarea></td></tr>\n"
      . "<tr><td><b>" . _IMAGE . " :</b> <input type=\"text\" name=\"urlimage\" size=\"42\" /></td></tr>\n"
      . "<tr><td><b>" . _UPLOADIMAGE . " :</b> <input type=\"file\" name=\"upimage\" /></td></tr>\n"			
			. "<tr><td><b>" . _LEVELACCES . " :</b> <select name=\"niveau\">\n"
			. "<option>0</option>\n"
			. "<option>1</option>\n"
			. "<option>2</option>\n"
			. "<option>3</option>\n"
			. "<option>4</option>\n"
			. "<option>5</option>\n"
			. "<option>6</option>\n"
			. "<option>7</option>\n"
			. "<option>8</option>\n"
			. "<option>9</option></select>\n"
			. "&nbsp;<b>" . _LEVELPOST . " :</b> <select name=\"level\">\n"
			. "<option>0</option>\n"
			. "<option>1</option>\n"
			. "<option>2</option>\n"
			. "<option>3</option>\n"
			. "<option>4</option>\n"
			. "<option>5</option>\n"
			. "<option>6</option>\n"
			. "<option>7</option>\n"
			. "<option>8</option>\n"
			. "<option>9</option></select>\n"
			. "&nbsp;<b>" . _ORDER . " :</b> <input type=\"text\" name=\"ordre\" size=\"2\" value=\"0\" /></td></tr>\n"
			. "<tr><td><b>" . _LEVELPOLL . " :</b> <select name=\"level_poll\">\n"
			. "<option>0</option>\n"
			. "<option>1</option>\n"
			. "<option>2</option>\n"
			. "<option>3</option>\n"
			. "<option>4</option>\n"
			. "<option>5</option>\n"
			. "<option>6</option>\n"
			. "<option>7</option>\n"
			. "<option>8</option>\n"
			. "<option>9</option></select>\n"
			. "&nbsp;<b>" . _LEVELVOTE . " :</b> <select name=\"level_vote\">\n"
			. "<option>0</option>\n"
			. "<option>1</option>\n"
			. "<option>2</option>\n"
			. "<option>3</option>\n"
			. "<option>4</option>\n"
			. "<option>5</option>\n"
			. "<option>6</option>\n"
			. "<option>7</option>\n"
			. "<option>8</option>\n"
			. "<option>9</option></select></td></tr>\n"
			. "<tr><td><b>" . _MODERATEUR . " :</b> <select name=\"modo\">\n"
			. "<option value=\"\">" . _NONE . "</option>\n";

				$sql = mysql_query("SELECT id, pseudo FROM " . USER_TABLE . " WHERE niveau > 0 ORDER BY niveau DESC, pseudo");
				while (list($id_user, $pseudo) = mysql_fetch_row($sql))
				{

					echo "<option value=\"" . $id_user . "\">" . $pseudo . "</option>\n";
				}

			echo "</select></td></tr></table>\n"
			. "<div style=\"text-align: center;\"><br /><input type=\"submit\" value=\"" . _ADDTHISFORUM . "\" /></div>\n"
			. "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Forum&amp;page=admin\"><b>" . _BACK . "</b></a> ]</div></form><br /></div>\n";
    }

    function send_forum($titre, $description, $cat, $modo, $niveau, $level, $ordre, $level_poll, $level_vote, $urlimage, $upimage)
    {
        global $nuked, $user;

        $description = html_entity_decode($description);
        $titre = mysql_real_escape_string(stripslashes($titre));
        $description = mysql_real_escape_string(stripslashes($description));

        $filename = $_FILES['upimage']['name'];
        if ($filename != "") {
          $ext = pathinfo($filename, PATHINFO_EXTENSION);

          if ($ext == "jpg" || $ext == "jpeg" || $ext == "JPG" || $ext == "JPEG" || $ext == "gif" || $ext == "GIF" || $ext == "png" || $ext == "PNG") {
            $url_image = "upload/Forum/Forums/" . $filename;
            move_uploaded_file($_FILES['upimage']['tmp_name'], $url_image) or die ("<br /><br /><div style=\"text-align: center;\"><b>Upload file failed !!!</b></div><br /><br />");
            @chmod ($url_image, 0644);
          } else {
            echo "<div class=\"notification error png_bg\">\n"
               . "<div>\n"
               . "No image file !"
               . "</div>\n"
               . "</div>\n";
            redirect("index.php?file=News&page=admin", 2);
            adminfoot();
            footer();
            die;
          }
        } else {
          $url_image = $urlimage;
        }


        $sql = mysql_query("INSERT INTO " . FORUM_TABLE . " ( `id` , `cat` , `nom` , `comment` , `moderateurs` , `niveau` , `level` , `ordre` , `level_poll` , `level_vote` , `image`  ) VALUES ( '' , '" . $cat . "' , '" . $titre . "' , '" . $description . "' , '" . $modo . "' , '" . $niveau . "' , '" . $level . "' , '" . $ordre . "' , '" . $level_poll . "' , '" . $level_vote . "' , '" . $url_image . "' )");
        // Action
        $texteaction = "". _ACTIONADDFO .": ".$titre."";
        $acdate = time();
        $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
        //Fin action
        echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. "" . _FORUMADD . "\n"
			. "</div>\n"
			. "</div>\n";
        echo "<script>\n"
            ."setTimeout('screen()','3000');\n"
            ."function screen() { \n"
            ."screenon('index.php?file=Forum', 'index.php?file=Forum&page=admin&op=main');\n"
            ."}\n"
            ."</script>\n";
    }

    function del_forum($id)
    {
        global $nuked, $user;

        $sqls = mysql_query("SELECT nom FROM " . FORUM_TABLE . " WHERE id = '" . $id . "'");
        list($titre) = mysql_fetch_array($sqls);
        $titre= mysql_real_escape_string($titre);
        $sql = mysql_query("SELECT id, sondage FROM " . FORUM_THREADS_TABLE . " WHERE forum_id = '" . $id . "'");
        while (list($thread_id, $sondage) = mysql_fetch_row($sql))
        {
            if ($sondage == 1)
            {
                $sql_poll = mysql_query("SELECT id FROM " . FORUM_POLL_TABLE . " WHERE thread_id = '" . $thread_id . "'");
                list($poll_id) = mysql_fetch_row($sql_poll);

                $sup1 = mysql_query("DELETE FROM " . FORUM_POLL_TABLE . " WHERE id = '" . $poll_id . "'");
                $sup2 = mysql_query("DELETE FROM " . FORUM_OPTIONS_TABLE . " WHERE poll_id = '" . $poll_id . "'");
                $sup3 = mysql_query("DELETE FROM " . FORUM_VOTE_TABLE . " WHERE poll_id = '" . $poll_id . "'");
            }
        }

        mysql_query("DELETE FROM " . FORUM_TABLE . " WHERE id = '" . $id . "'");
        mysql_query("DELETE FROM " . FORUM_THREADS_TABLE . " WHERE forum_id = '" . $id . "'");
        mysql_query("DELETE FROM " . FORUM_MESSAGES_TABLE . " WHERE forum_id = '" . $id . "'");
        // Action
        $texteaction = "". _ACTIONDELFO .": ".$titre."";
        $acdate = time();
        $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
        //Fin action
        echo "<div class=\"notification success png_bg\">\n"
        . "<div>\n"
        . "" . _FORUMDEL . "\n"
        . "</div>\n"
        . "</div>\n";
        echo "<script>\n"
            ."setTimeout('screen()','3000');\n"
            ."function screen() { \n"
            ."screenon('index.php?file=Forum', 'index.php?file=Forum&page=admin&op=main');\n"
            ."}\n"
            ."</script>\n";
    }

    function edit_forum($id)
    {
        global $nuked, $language;

        $sql = mysql_query("SELECT nom, comment, cat, moderateurs, niveau, level, ordre, level_poll, level_vote, image FROM " . FORUM_TABLE . " WHERE id = '" . $id . "'");
        list($titre, $description, $cat, $modo, $niveau, $level, $ordre, $level_poll, $level_vote, $forum_image) = mysql_fetch_array($sql);

        $categorie = mysql_query("select nom FROM " . FORUM_CAT_TABLE . " WHERE id = '" . $cat . "'");
        list($cat_name) = mysql_fetch_array($categorie);
        $cat_name = printSecuTags($cat_name);

        if ($modo != "")
        {
            $moderateurs = explode('|', $modo);
            for ($i = 0;$i < count($moderateurs);$i++)
            {
                if ($i > 0) $sep = ', ';
                $sql2 = mysql_query("SELECT id, pseudo FROM " . USER_TABLE . " WHERE id = '" . $moderateurs[$i] . "'");
                list($id_user, $modo_pseudo) = mysql_fetch_row($sql2);
                $modos .= $sep . $modo_pseudo . "&nbsp;(<a href=\"index.php?file=Forum&amp;page=admin&amp;op=del_modo&amp;uid=" . $id_user . "&amp;forum_id=" . $id . "\"><img width=\"7\" style=\"border: 0;\" src=\"modules/Forum/images/del.gif\" alt=\"\" title=\"" . _DELTHISMODO . "\" /></a>)";
            }
        }
        else
        {
            $modos = _NONE;
        }

        echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
        . "<div class=\"content-box-header\"><h3>" . _ADMINFORUMEDIT . "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Forum.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div>\n"
			. "</div>\n"
    . "<div class=\"tab-content\" id=\"tab2\"><form method=\"post\" action=\"index.php?file=Forum&amp;page=admin&amp;op=modif_forum\" enctype=\"multipart/form-data\">\n"
    . "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" cellspacing=\"1\" cellpadding=\"2\" border=\"0\">\n"
    . "<tr><td><b>" . _NAME . " :</b> <input type=\"text\" name=\"titre\" size=\"30\" value=\"" . $titre . "\" /></td></tr>\n"
    . "<tr><td><b>" . _CATSECONDAIRE . " :</b> <select name=\"cat\"><option value=\"" . $cat . "\">" . $cat_name . "</option>\n";

        select_forum_cat();

        echo"</select></td></tr>\n"
    . "<tr><td align=\"left\"><b>" . _DESCR . " : </b><br /><textarea class=\"editor\" name=\"description\" rows=\"10\" cols=\"69\">" . $description . "</textarea></td></tr>\n"
    . "<tr><td><b>" . _IMAGE . " :</b> <input type=\"text\" name=\"urlimage\" size=\"42\" value=\"" . $forum_image . "\"/></td></tr>\n"
    . "<tr><td><b>" . _UPLOADIMAGE . " :</b> <input type=\"file\" name=\"upimage\" /></td></tr>\n"    
    . "<tr><td><b>" . _LEVELACCES . " :</b> <select name=\"niveau\"><option>" . $niveau . "</option>\n"
    . "<option>0</option>\n"
    . "<option>1</option>\n"
    . "<option>2</option>\n"
    . "<option>3</option>\n"
    . "<option>4</option>\n"
    . "<option>5</option>\n"
    . "<option>6</option>\n"
    . "<option>7</option>\n"
    . "<option>8</option>\n"
    . "<option>9</option></select>\n"
	. "&nbsp;<b>" . _LEVELPOST . " :</b> <select name=\"level\"><option>" . $level . "</option>\n"
    . "<option>0</option>\n"
    . "<option>1</option>\n"
    . "<option>2</option>\n"
    . "<option>3</option>\n"
    . "<option>4</option>\n"
    . "<option>5</option>\n"
    . "<option>6</option>\n"
    . "<option>7</option>\n"
    . "<option>8</option>\n"
    . "<option>9</option></select>\n"
	. "&nbsp;<b>" . _ORDER . " :</b> <input type=\"text\" name=\"ordre\" size=\"2\" value=\"" . $ordre . "\" /></td></tr>\n"
    . "<tr><td><b>" . _LEVELPOLL . " :</b> <select name=\"level_poll\"><option>" . $level_poll . "</option>\n"
    . "<option>0</option>\n"
    . "<option>1</option>\n"
    . "<option>2</option>\n"
    . "<option>3</option>\n"
    . "<option>4</option>\n"
    . "<option>5</option>\n"
    . "<option>6</option>\n"
    . "<option>7</option>\n"
    . "<option>8</option>\n"
    . "<option>9</option></select>\n"
	. "&nbsp;<b>" . _LEVELVOTE . " :</b> <select name=\"level_vote\"><option>$level_vote</option>\n"
    . "<option>0</option>\n"
    . "<option>1</option>\n"
    . "<option>2</option>\n"
    . "<option>3</option>\n"
    . "<option>4</option>\n"
    . "<option>5</option>\n"
    . "<option>6</option>\n"
    . "<option>7</option>\n"
    . "<option>8</option>\n"
    . "<option>9</option></select></td></tr>\n"
    . "<tr><td><b>" . _MODO . " :</b> " . $modos . "</td></tr>\n"
    . "<tr><td><b>" . _ADDMODO . " :</b> <select name=\"modo\"><option value=\"\">" . _NONE . "</option>\n";

        $sql = mysql_query("SELECT id, pseudo FROM " . USER_TABLE . " WHERE niveau > 0 ORDER BY niveau DESC, pseudo");
        while (list($id_user, $pseudo) = mysql_fetch_row($sql))
        {
            if (!is_int(strpos($modos, $id_user)))
            {
                echo "<option value=\"" . $id_user . "\">" . $pseudo . "</option>\n";
            }
        }

    echo "</select><input type=\"hidden\" name=\"id\" value=\"" . $id . "\" /></td></tr></table>\n"
    . "<div style=\"text-align: center;\"><br /><input type=\"submit\" value=\"" . _MODIFTHISFORUM . "\" /></div>\n"
    . "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Forum&amp;page=admin\"><b>" . _BACK . "</b></a> ]</div></form><br /></div></div>\n";
    }

    function modif_forum($id, $titre, $cat, $description, $niveau, $level, $ordre, $level_poll, $level_vote, $modo, $urlimage, $upimage)
    {
        global $nuked, $user;

        $description = html_entity_decode($description);
        $titre = mysql_real_escape_string(stripslashes($titre));
        $description = mysql_real_escape_string(stripslashes($description));

        $filename = $_FILES['upimage']['name'];
        if ($filename != "") {
          $ext = pathinfo($filename, PATHINFO_EXTENSION);

          if ($ext == "jpg" || $ext == "jpeg" || $ext == "JPG" || $ext == "JPEG" || $ext == "gif" || $ext == "GIF" || $ext == "png" || $ext == "PNG") {
            $url_image = "upload/Forum/Forums/" . $filename;
            move_uploaded_file($_FILES['upimage']['tmp_name'], $url_image) or die ("<br /><br /><div style=\"text-align: center;\"><b>Upload file failed !!!</b></div><br /><br />");
            @chmod ($url_image, 0644);
          } else {
            echo "<div class=\"notification error png_bg\">\n"
               . "<div>\n"
               . "No image file !"
               . "</div>\n"
               . "</div>\n";
            redirect("index.php?file=News&page=admin", 2);
            adminfoot();
            footer();
            die;
          }
        } else {
          $url_image = $urlimage;
        }

        if ($modo != "")
        {
            $sql = mysql_query("SELECT moderateurs FROM " . FORUM_TABLE . " WHERE id = '" . $id . "'");
            list($listmodo) = mysql_fetch_row($sql);

            if ($listmodo != "") $modos = $listmodo . "|" . $modo;
            else $modos = $modo;

            $upd_modo = mysql_query("UPDATE " . FORUM_TABLE . " SET moderateurs = '" . $modos . "' WHERE id = '" . $id . "'");
        }

        $upd = mysql_query("UPDATE " . FORUM_TABLE . " SET nom = '" . $titre . "', comment = '" . $description . "', cat = '" . $cat . "', niveau = '" . $niveau . "', level = '" . $level . "', ordre = '" . $ordre . "', level_poll = '" . $level_poll . "', level_vote = '" . $level_vote . "', image = '" . $url_image . "'  WHERE id = '" . $id . "'");
        // Action
        $texteaction = "". _ACTIONMODIFFO .": ".$titre."";
        $acdate = time();
        $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
        //Fin action
        echo "<div class=\"notification success png_bg\">\n"
        . "<div>\n"
        . "" . _FORUMMODIF . "\n"
        . "</div>\n"
        . "</div>\n";
        echo "<script>\n"
            ."setTimeout('screen()','3000');\n"
            ."function screen() { \n"
            ."screenon('index.php?file=Forum', 'index.php?file=Forum&page=admin');\n"
            ."}\n"
            ."</script>\n";
    }

    function del_modo($uid, $forum_id)
    {
        global $nuked, $user;
        
        $sql = mysql_query("SELECT moderateurs FROM " . FORUM_TABLE . " WHERE id = '" . $forum_id . "'");
        list($listmodo) = mysql_fetch_row($sql);
        $list = explode("|", $listmodo);
        for($i = 0; $i <= count($list)-1;$i++)
        {
            if ($i == 0 || ($i == 1 && $list[0] == $uid))
            {
                $sep = "";
            }
            else
            {
                $sep = "|";
            }

            if ($list[$i] != $uid)
            {
                $modos .= $sep . $list[$i];
            }
        }

        $upd = mysql_query("UPDATE " . FORUM_TABLE . " SET moderateurs = '" . $modos . "' WHERE id = '" . $forum_id . "'");
        
        $sql = mysql_query("SELECT pseudo FROM " . USER_TABLE . " WHERE id = '".$uid."'");
        list($pseudo) = mysql_fetch_array($sql);
        $pseudo = mysql_real_escape_string($pseudo);
        // Action
        $texteaction = "". _ACTIONDELMODOFO .": ".$pseudo."";
        $acdate = time();
        $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
        //Fin action
        echo "<div class=\"notification success png_bg\">\n"
        . "<div>\n"
        . "" . _MODODEL . "\n"
        . "</div>\n"
        . "</div>\n";
        
        $url = "index.php?file=Forum&page=admin&op=edit_forum&id=" . $forum_id;
        redirect($url, 2);
    }

    function main()
    {
        global $nuked, $language;

        echo "<script type=\"text/javascript\">\n"
			."<!--\n"
			."\n"
			. "function delforum(nom, id)\n"
			. "{\n"
			. "if (confirm('" . _DELETEFORUM . " '+nom+' ! " . _CONFIRM . "'))\n"
			. "{document.location.href = 'index.php?file=Forum&page=admin&op=del_forum&id='+id;}\n"
			. "}\n"
				. "\n"
			. "// -->\n"
			. "</script>\n";

        echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
        . "<div class=\"content-box-header\"><h3>" . _ADMINFORUM . "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Forum.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div>\n"
			. "</div>\n"
		. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\">" . _FORUM . " | "
		. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=add_forum\">" . _ADDFORUM . "</a></b> | ";
      if ($nuked['forum_cat_prim'] == "on")
{ 
		echo "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_cat_primaire\">" . _CATPRIMAIREMANAGEMENT . "</a></b> | ";
}
		echo "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_cat\">" . _CATMANAGEMENT . "</a></b> | "
		. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_rank\">" . _RANKMANAGEMENT . "</a></b> | "
		. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=prune\">" . _PRUNE . "</a></b> | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=skin\">" . _SKINS . "</a></b> | "
		. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_pref\">" . _PREFS . "</a></b></div><br />\n"
		. "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
		. "<tr>\n"
		. "<td style=\"width: 20%;\" align=\"center\"><b>" . _NAME . "</b></td>\n"
		. "<td style=\"width: 20%;\" align=\"center\"><b>" . _CATAPPARTENANCE . "</b></td>\n"
		. "<td style=\"width: 20%;\" align=\"center\"><b>" . _CATSECONDAIRE . "</b></td>\n"
		. "<td style=\"width: 8%; text-align: center;\" align=\"center\"><b>" . _LEVELACCES . "</b></td>\n"
		. "<td style=\"width: 8%; text-align: center;\" align=\"center\"><b>" . _LEVELPOST . "</b></td>\n"
		. "<td style=\"width: 8%; text-align: center;\" align=\"center\"><b>" . _ORDER . "</b></td>\n"
		. "<td style=\"width: 8%; text-align: center;\" align=\"center\"><b>" . _EDIT . "</b></td>\n"
		. "<td style=\"width: 8%; text-align: center;\" align=\"center\"><b>" . _DEL . "</b></td></tr>\n";

        $sql = mysql_query("SELECT A.id, A.nom, A.niveau, A.level, A.ordre, A.cat, B.nom FROM " . FORUM_TABLE . " AS A LEFT JOIN " . FORUM_CAT_TABLE . " AS B ON B.id = A.cat ORDER BY B.ordre, B.nom, A.ordre, A.nom");
        while (list($id, $titre, $niveau, $level, $ordre, $cat, $cat_name) = mysql_fetch_row($sql))
        {

            $titre = printSecuTags($titre);
            $cat_name = printSecuTags($cat_name);

            echo "<tr>\n"
            . "<td style=\"width: 20%;\">" . $titre . "</td>\n"
            . "<td style=\"width: 20%;\" align=\"center\"><img style=\"border: 0;\" src=\"modules/Forum/images/fl.gif\" alt=\"\" title=\"\" />&nbsp;&nbsp;" . _CATFL . "&nbsp;&nbsp;<img style=\"border: 0;\" src=\"modules/Forum/images/fl.gif\" alt=\"\" title=\"\" /></td>\n"
            . "<td style=\"width: 20%;\" align=\"center\">" . $cat_name . "</td>\n"
            . "<td style=\"width: 8%; text-align: center;\" align=\"center\">" . $niveau . "</td>\n"
            . "<td style=\"width: 8%; text-align: center;\" align=\"center\">" . $level . "</td>\n"
            . "<td style=\"width: 8%; text-align: center;\" align=\"center\">" . $ordre . "</td>\n"
            . "<td style=\"width: 8%; text-align: center;\" align=\"center\"><a href=\"index.php?file=Forum&amp;page=admin&amp;op=edit_forum&amp;id=" . $id . "\"><img style=\"border: 0;\" src=\"images/edit.gif\" alt=\"\" title=\"" . _EDITTHISFORUM . "\" /></a></td>\n"
            . "<td style=\"width: 8%; text-align: center;\" align=\"center\"><a href=\"javascript:delforum('" . mysql_real_escape_string(stripslashes($titre)) . "', '" . $id . "');\"><img style=\"border: 0;\" src=\"images/del.gif\" alt=\"\" title=\"" . _DELTHISFORUM . "\" /></a></td></tr>\n";
        }
        echo "</table><div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Admin\"><b>" . _BACK . "</b></a> ]</div><br /></div></div>\n";
    }

    function main_rank()
    {
        global $nuked, $language;

        echo "<script type=\"text/javascript\">\n"
			."<!--\n"
			."\n"
			. "function delrank(titre, id)\n"
			. "{\n"
			. "if (confirm('" . _DELETEFORUM . " '+titre+' ! " . _CONFIRM . "'))\n"
			. "{document.location.href = 'index.php?file=Forum&page=admin&op=del_rank&rid='+id;}\n"
			. "}\n"
				. "\n"
			. "// -->\n"
			. "</script>\n";

        echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
			. "<div class=\"content-box-header\"><h3>" . _ADMINFORUMRANK . "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Forum.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div>\n"
			. "</div>\n"
			. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\"><b><a href=\"index.php?file=Forum&amp;page=admin\">" . _FORUM . "</a></b> | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=add_forum\">" . _ADDFORUM . "</a></b> | ";
      if ($nuked['forum_cat_prim'] == "on")
{ 			
			echo "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_cat_primaire\">" . _CATPRIMAIREMANAGEMENT . "</a></b> | ";
}
			echo "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_cat\">" . _CATMANAGEMENT . "</a></b> | "
			. "" . _RANKMANAGEMENT . " | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=prune\">" . _PRUNE . "</a></b> | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=skin\">" . _SKINS . "</a></b> | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_pref\">" . _PREFS . "</a></b></div><br />\n"
			. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" width=\"80%\" cellpadding=\"2\" cellspacing=\"1\">\n"
			. "<tr>\n"
			. "<td style=\"width: 25%;\" align=\"center\"><b>" . _NAME . "</b></td>\n"
			. "<td style=\"width: 25%;\"align=\"center\"><b>" . _TYPE . "</b></td>\n"
			. "<td style=\"width: 20%;\" align=\"center\"><b>" . _MESSAGES . "</b></td>\n"
			. "<td style=\"width: 15%;\" align=\"center\"><b>" . _EDIT . "</b></td>\n"
			. "<td style=\"width: 15%;\" align=\"center\"><b>" . _DEL . "</b></td></tr>\n";

        $sql = mysql_query("SELECT id, nom, type, post FROM " . FORUM_RANK_TABLE . " ORDER by type DESC, post");
        while (list($rid, $nom, $type, $nbpost) = mysql_fetch_row($sql))
        {
            $nom = printSecuTags($nom);

            if ($type == 1)
            {
                $name = "<b>" . $nom . "</b>";
                $type_name = _MODERATEUR;
                $nb_post = "-";
                $del = "-";
            }
            else if ($type == 2)
            {
                $name = "<b>" . $nom . "</b>";
                $type_name = _ADMINISTRATOR;
                $nb_post = "-";
                $del = "-";
            }
            else
            {
                $name = $nom;
                $type_name = _MEMBER;
                $nb_post = $nbpost;
                $del = "<a href=\"javascript:delrank('" . mysql_real_escape_string(stripslashes($nom)) . "', '" . $rid . "');\"><img style=\"border: 0;\" src=\"images/del.gif\" alt=\"\" title=\"" . _DELTHISRANK . "\" /></a>";
            }

        echo "<tr>\n"
            . "<td style=\"width: 25%;\" align=\"center\">" . $name . "</td>\n"
            . "<td style=\"width: 25%;\" align=\"center\">" . $type_name . "</td>\n"
            . "<td style=\"width: 20%;\" align=\"center\">" . $nb_post . "</td>\n"
            . "<td style=\"width: 15%;\" align=\"center\"><a href=\"index.php?file=Forum&amp;page=admin&amp;op=edit_rank&amp;rid=" . $rid . "\"><img style=\"border: 0;\" src=\"images/edit.gif\" alt=\"\" title=\"" . _EDITTHISRANK . "\" /></a></td>\n"
            . "<td style=\"width: 15%;\" align=\"center\">" . $del . "</td></tr>\n";
        }

        echo "</table><br /><div style=\"text-align: center;\">[ <a href=\"index.php?file=Forum&amp;page=admin&amp;op=add_rank\"><b>" . _ADDRANK . "</b></a> ]</div>\n"
    . "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Forum&amp;page=admin\"><b>" . _BACK . "</b></a> ]</div><br /></div></div>\n";
    }

    function add_rank()
    {
        global $language;

        echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
			. "<div class=\"content-box-header\"><h3>" . _ADMINFORUM . "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Forum.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div>\n"
			. "</div>\n"
			. "<div class=\"tab-content\" id=\"tab2\"><form method=\"post\" action=\"index.php?file=Forum&amp;page=admin&amp;op=send_rank\">\n"
			. "<table  style=\"margin-left: auto;margin-right: auto;text-align: left;\"  border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n"
			. "<tr><td><b>" . _NAME . " : </b> <input type=\"text\" name=\"nom\" size=\"30\" /></td></tr>\n"
			. "<tr><td><b>" . _IMAGE . " :</b> <input type=\"text\" name=\"image\" value=\"http://\" size=\"38\" maxlength=\"200\" /></td></tr>\n"
			. "<tr><td><b>" . _MESSAGES . " :</b> <input type=\"text\" name=\"post\" size=\"4\" value=\"0\" maxlength=\"5\" /></td></tr>\n"
			. "<tr><td>&nbsp;<input type=\"hidden\" name=\"type\" value=\"0\" /></td></tr></table>\n"
			. "<div style=\"text-align: center;\"><input type=\"submit\" value=\"" . _CREATERANK . "\" /></div>\n"
			. "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_rank\"><b>" . _BACK . "</b></a> ]</div></form><br /></div></div>\n";
    }

    function send_rank($nom, $type, $post, $image)
    {
        global $nuked, $user;

        $nom = mysql_real_escape_string(stripslashes($nom));

        $sql = mysql_query("INSERT INTO " . FORUM_RANK_TABLE . " ( `id` , `nom` , `type` , `post` , `image` ) VALUES ( '' , '" . $nom . "' , '" . $type . "' , '" . $post . "' , '" . $image . "' )");
        // Action
        $texteaction = "". _ACTIONADDRANKFO .": ".$nom."";
        $acdate = time();
        $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
        //Fin action
        echo "<div class=\"notification success png_bg\">\n"
        . "<div>\n"
        . "" . _RANKADD . "\n"
        . "</div>\n"
        . "</div>\n";
        redirect("index.php?file=Forum&page=admin&op=main_rank", 2);
    }

    function del_rank($rid)
    {
        global $nuked, $user;

		$sqlr = mysql_query("SELECT nom FROM " . FORUM_RANK_TABLE . " WHERE id = '" . $rid . "'");
		list($nom) = mysql_fetch_array($sqlr);
		$nom = mysql_real_escape_string($nom);
		
		$sql = mysql_query("DELETE FROM " . FORUM_RANK_TABLE . " WHERE id = '" . $rid . "'");
			// Action
			$texteaction = "". _ACTIONDELRANKFO .": ".$nom."";
			$acdate = time();
			$sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
			//Fin action
		echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. "" . _RANKDEL . "\n"
			. "</div>\n"
			. "</div>\n";
			redirect("index.php?file=Forum&page=admin&op=main_rank", 2);
    }

    function edit_rank($rid)
    {
        global $language, $nuked;

        $sql = mysql_query("SELECT nom, type, post, image FROM " . FORUM_RANK_TABLE . " WHERE id = '" . $rid . "'");
        list($nom, $type, $post, $image) = mysql_fetch_array($sql);

        echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
			. "<div class=\"content-box-header\"><h3>" . _ADMINFORUM . "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Forum.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div>\n"
			. "</div>\n"
			. "<div class=\"tab-content\" id=\"tab2\"><form method=\"post\" action=\"index.php?file=Forum&amp;page=admin&amp;op=modif_rank\">\n"
			. "<table  style=\"margin-left: auto;margin-right: auto;text-align: left;\"  border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n"
			. "<tr><td><b>" . _NAME . " : </b> <input type=\"text\" name=\"nom\" size=\"30\" value=\"" . $nom . "\" /></td></tr>\n"
			. "<tr><td><b>" . _IMAGE . " :</b> <input type=\"text\" name=\"image\" value=\"" . $image . "\" size=\"38\" maxlength=\"200\" />";

        if ($type == 0)
        {
            echo "</td></tr><tr><td><b>" . _MESSAGES . " :</b> <input type=\"text\" name=\"post\" size=\"4\" value=\"" . $post . "\" maxlength=\"5\" /></td></tr>\n";
		}
		else
		{
				echo "<input type=\"hidden\" name=\"post\" value=\"" . $post . "\" /></td></tr>\n";
		}

		echo "<tr><td>&nbsp;<input type=\"hidden\" name=\"type\" value=\"" . $type . "\" /><input type=\"hidden\" name=\"rid\" value=\"" . $rid . "\" /></td></tr></table>\n"
			. "<div style=\"text-align: center;\"><input type=\"submit\" value=\"" . _MODIFTHISRANK . "\" /></div>\n"
			. "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_rank\"><b>" . _BACK . "</b></a> ]</div></form><br /></div></div>\n";
    }

    function modif_rank($rid, $nom, $type, $post, $image)
    {
        global $nuked, $user;

        $nom = mysql_real_escape_string(stripslashes($nom));

        $sql = mysql_query("UPDATE " . FORUM_RANK_TABLE . " SET nom = '" . $nom . "', type = '" . $type . "', post = '" . $post . "', image = '" . $image . "' WHERE id = '" . $rid . "'");
        
        // Action
        $texteaction = "". _ACTIONMODIFRANKFO .": ".$nom."";
        $acdate = time();
        $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
        //Fin action
        echo "<div class=\"notification success png_bg\">\n"
        . "<div>\n"
        . "" . _RANKMODIF . "\n"
        . "</div>\n"
        . "</div>\n";
        redirect("index.php?file=Forum&page=admin&op=main_rank", 2);
    }

    function prune()
    {
        global $nuked, $language;

        echo "<script type=\"text/javascript\">\n"
			."<!--\n"
			."\n"
			. "function verifchamps()\n"
			. "{\n"
			. "if (document.getElementById('prune_day').value.length == 0)\n"
			. "{\n"
			. "alert('" . _NODAY . "');\n"
			. "return false;\n"
			. "}\n"
			. "return true;\n"
			. "}\n"
			. "\n"
			. "// -->\n"
			. "</script>\n";

        echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
			. "<div class=\"content-box-header\"><h3>" . _ADMINFORUM . "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Forum.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div>\n"
			. "</div>\n"
			. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\"><b><a href=\"index.php?file=Forum&amp;page=admin\">" . _FORUM . "</a></b> | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=add_forum\">" . _ADDFORUM . "</a></b> | ";
      if ($nuked['forum_cat_prim'] == "on")
{ 			
			echo "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_cat_primaire\">" . _CATPRIMAIREMANAGEMENT . "</a></b> | ";
}			
			echo "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_cat\">" . _CATMANAGEMENT . "</a></b> | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_rank\">" . _RANKMANAGEMENT . "</a></b> | "
			. "" . _PRUNE . " | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=skin\">" . _SKINS . "</a></b> | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_pref\">" . _PREFS . "</a></b></div><br />\n"
			. "<form method=\"post\" action=\"index.php?file=Forum&amp;page=admin&amp;op=do_prune\" onsubmit=\"return verifchamps();\">\n"
			. "<table  style=\"margin-left: auto;margin-right: auto;text-align: left;\"  border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
			. "<tr><td>" . _DELOLDMESSAGES . "</td></tr>\n"
			. "<tr><td><b>" . _NUMBEROFDAY . " :</b> <input id=\"prune_day\" type=\"text\" name=\"day\" size=\"3\" maxlength=\"3\" /></td></tr>\n"
			. "<tr><td><b>" . _FORUM . " :</b> <select name=\"forum_id\"><option value=\"\">" . _ALL . "</option>\n";

				$sql_cat = mysql_query("SELECT id, nom FROM " . FORUM_CAT_TABLE . " ORDER BY ordre, nom");
				while (list($cat, $cat_name) = mysql_fetch_row($sql_cat))
				{
					$cat_name = printSecuTags($cat_name);

					echo "<option value=\"cat_" . $cat . "\">* " . $cat_name . "</option>\n";

					$sql_forum = mysql_query("SELECT nom, id FROM " . FORUM_TABLE . " WHERE cat = '" . $cat . "' ORDER BY ordre, nom");
					while (list($forum_name, $fid) = mysql_fetch_row($sql_forum))
					{
						$forum_name = printSecuTags($forum_name);

						echo "<option value=\"" . $fid . "\">&nbsp;&nbsp;&nbsp;" . $forum_name . "</option>\n";
					}
				}

        echo "</select></td></tr></table>\n"
			. "<div style=\"text-align: center;\"><br /><input type=\"submit\" value=\"" . _SEND . "\" /></div>\n"
			. "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Forum&amp;page=admin\"><b>" . _BACK . "</b></a> ]</div></form><br /></div></div>\n";
    }

    function do_prune($day, $forum_id)
    {
        global $nuked, $user;

        
        $sql_forum = mysql_query("SELECT nom FROM " . FORUM_TABLE . " WHERE id = '" . $forum_id . "'");
        list($nom) = mysql_fetch_array($sql_forum);
        
        $prunedate = time() - (86400 * $day);

        if (strpos("cat_", $forum_id))
        {
                $cat = preg_replace("`cat_`i", "", $forum_id);
                $and = "AND cat = '" . $cat . "'";
        }
        else if ($forum_id != "")
        {
            $and = "AND forum_id = '" . $forum_id . "'";
        }
        else
        {
                $and = "";
        }

        $sql = mysql_query("SELECT id, sondage FROM " . FORUM_THREADS_TABLE . " WHERE " . $prunedate . " >= last_post AND annonce = 0 " . $and);
        while (list($thread_id, $sondage) = mysql_fetch_row($sql))
        {
            if ($sondage == 1)
            {
                $sql_poll = mysql_query("SELECT id FROM " . FORUM_POLL_TABLE . " WHERE thread_id = '" . $thread_id . "'");
                list($poll_id) = mysql_fetch_row($sql_poll);
                $del1 = mysql_query("DELETE FROM " . FORUM_POLL_TABLE . " WHERE id = '" . $poll_id . "'");
                $del2 = mysql_query("DELETE FROM " . FORUM_OPTIONS_TABLE . " WHERE poll_id = '" . $poll_id . "'");
                $del3 = mysql_query("DELETE FROM " . FORUM_VOTE_TABLE . " WHERE poll_id = '" . $poll_id . "'");
            }

            mysql_query("DELETE FROM " . FORUM_MESSAGES_TABLE . " WHERE thread_id = '" . $thread_id . "'");
            mysql_query("DELETE FROM " . FORUM_THREADS_TABLE . " WHERE id = '" . $thread_id . "'");
        }
        // Action
        $texteaction = "". _ACTIONPRUNEFO .": ".$nom."";
        $acdate = time();
        $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
        //Fin action
        echo "<div class=\"notification success png_bg\">\n"
        . "<div>\n"
        . "" .  _FORUMPRUNE . "\n"
        . "</div>\n"
        . "</div>\n";
        redirect("index.php?file=Forum&page=admin", 2);
    }

    function main_pref()
    {
        global $nuked, $language;

        if ($nuked['forum_file'] == "on") $checked1 = "checked=\"checked\"";
        if ($nuked['forum_rank_team'] == "on") $checked2 = "checked=\"checked\"";
        if ($nuked['image_forums'] == "on") $checked3 = "checked=\"checked\"";
        if ($nuked['birthday_forum'] == "on") $checked4 = "checked=\"checked\"";                  
        if ($nuked['gamer_details'] == "on") $checked5 = "checked=\"checked\"";  
        if ($nuked['profil_details'] == "on") $checked6 = "checked=\"checked\"";
        if ($nuked['image_cat_mini'] == "on") $checked7 = "checked=\"checked\"";
        if ($nuked['forum_cat_prim'] == "on") $checked8 = "checked=\"checked\"";                 

        echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
			. "<div class=\"content-box-header\"><h3>" . _ADMINFORUM . "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Forum.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div>\n"
			. "</div>\n"
			. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\"><b><a href=\"index.php?file=Forum&amp;page=admin\">" . _FORUM . "</a></b> | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=add_forum\">" . _ADDFORUM . "</a></b> | ";
      if ($nuked['forum_cat_prim'] == "on")
{ 			
			echo "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_cat_primaire\">" . _CATPRIMAIREMANAGEMENT . "</a></b> | ";
}
			echo "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_cat\">" . _CATMANAGEMENT . "</a></b> | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_rank\">" . _RANKMANAGEMENT . "</a></b> | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=prune\">" . _PRUNE . "</a></b> | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=skin\">" . _SKINS . "</a></b> | "
			. "" . _PREFS . "</div><br />\n"
			. "<form method=\"post\" action=\"index.php?file=Forum&amp;page=admin&amp;op=change_pref\">\n"
			. "<table  style=\"margin-left: auto;margin-right: auto;text-align: left;\"  border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
			. "<tr><td align=\"center\" colspan=\"2\"><big>" . _PREFS . "</big></td></tr>\n"
			. "<tr><td colspan=\"2\"><b>" . _FORUMTITLE . " :</b> <input type=\"text\" name=\"forum_title\" size=\"40\" value=\"" . $nuked['forum_title'] . "\" /></td></tr>\n"
			. "<tr><td colspan=\"2\"><b>" . _FORUMDESC . " :</b><br /><textarea name=\"forum_desc\" cols=\"55\" rows=\"5\">" . $nuked['forum_desc'] . "</textarea></td></tr>\n"
			. "<tr><td colspan=\"2\">&nbsp;</td></tr>\n"
      . "<tr><td>" . _ACTIVECATPRIM . " :</td><td><input class=\"checkbox\" type=\"checkbox\" name=\"forum_cat_prim\" value=\"on\" " . $checked8 . " /></td></tr>\n";
      if ($nuked['forum_cat_prim'] == "on")
{ 			
      echo "<tr><td>" . _SHOWIMAGECATMINI . " :</td><td><input class=\"checkbox\" type=\"checkbox\" name=\"image_cat_mini\" value=\"on\" " . $checked7 . " /></td></tr>\n";
}      			
      echo "<tr><td>" . _IMAGEFORUM . " :</td><td><input class=\"checkbox\" type=\"checkbox\" name=\"image_forums\" value=\"on\" " . $checked3 . " /></td></tr>\n"
      . "<tr><td>" . _BIRTHDAYFORUM . " :</td><td><input class=\"checkbox\" type=\"checkbox\" name=\"birthday_forum\" value=\"on\" " . $checked4 . " /></td></tr>\n" 			
			. "<tr><td>" . _USERANKTEAM . " :</td><td><input class=\"checkbox\" type=\"checkbox\" name=\"forum_rank_team\" value=\"on\" " . $checked2 . " /></td></tr>\n"
      . "<tr><td>" . _PROFILDETAILS . " :</td><td><input class=\"checkbox\" type=\"checkbox\" name=\"profil_details\" value=\"on\" " . $checked6 . " /></td></tr>\n" 
      . "<tr><td>" . _GAMERDETAILS . " :</td><td><input class=\"checkbox\" type=\"checkbox\" name=\"gamer_details\" value=\"on\" " . $checked5 . " /></td></tr>\n" 			
			. "<tr><td>" . _NUMBERTHREAD . " :</td><td><input type=\"text\" name=\"thread_forum_page\" size=\"2\" value=\"" . $nuked['thread_forum_page'] . "\" /></td></tr>\n"
			. "<tr><td>" . _NUMBERPOST . " :</td><td><input type=\"text\" name=\"mess_forum_page\" size=\"2\" value=\"" . $nuked['mess_forum_page'] . "\" /></td></tr>\n"
			. "<tr><td>" . _TOPICHOT . " :</td><td><input type=\"text\" name=\"hot_topic\" size=\"2\" value=\"" . $nuked['hot_topic'] . "\" /></td></tr>\n"
			. "<tr><td>" . _POSTFLOOD . " :</td><td><input type=\"text\" name=\"post_flood\" size=\"2\" value=\"" . $nuked['post_flood'] . "\" /></td></tr>\n"
			. "<tr><td>" . _MAXFIELD . " :</td><td><input type=\"text\" name=\"forum_field_max\" size=\"2\" value=\"" . $nuked['forum_field_max'] . "\" /></td></tr>\n"
			. "<tr><td>" . _ATTACHFILES . " :</td><td><input class=\"checkbox\" type=\"checkbox\" name=\"forum_file\" value=\"on\" " . $checked1 . " /></td></tr>\n"
			. "<tr><td>" . _FILELEVEL . " :</td><td><select name=\"forum_file_level\"><option>" . $nuked['forum_file_level'] . "</option>\n"
			. "<option>0</option>\n"
			. "<option>1</option>\n"
			. "<option>2</option>\n"
			. "<option>3</option>\n"
			. "<option>4</option>\n"
			. "<option>5</option>\n"
			. "<option>6</option>\n"
			. "<option>7</option>\n"
			." <option>8</option>\n"
			. "<option>9</option></select></td></tr>"
			. "<tr><td>" . _MAXSIZEFILE . " :</td><td><input type=\"text\" name=\"forum_file_maxsize\" size=\"6\" value=\"" . $nuked['forum_file_maxsize'] . "\" /></td></tr>\n"
			. "</table><div style=\"text-align: center;\"><br /><input type=\"submit\" value=\"" . _SEND . "\" /></div>\n"
			. "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Forum&amp;page=admin\"><b>" . _BACK . "</b></a> ]</div></form><br /></div></div>\n";
    }

    function change_pref($forum_title, $forum_desc, $forum_rank_team, $thread_forum_page, $mess_forum_page, $hot_topic, $post_flood, $forum_field_max, $forum_file, $forum_file_level, $forum_file_maxsize, $forum_cat_prim, $image_cat_mini, $image_forums, $birthday_forum, $gamer_details, $profil_details)
    {
        global $nuked, $user;

        if ($forum_file != "on")
        {
            $forum_file = "off";
        }

        if ($forum_rank_team != "on")
        {
            $forum_rank_team = "off";
        }
        
        if ($forum_cat_prim != "on")
        {
            $forum_cat_prim = "off";
        }

        if ($image_cat_mini != "on")
        {
            $image_cat_mini = "off";
        }
        
        if ($image_forums != "on")
        {
            $image_forums = "off";
        }        

        if ($birthday_forum != "on")
        {
            $birthday_forum = "off";
        }

        if ($gamer_details != "on")
        {
            $gamer_details = "off";
        }                

        if ($profil_details != "on")
        {
            $profil_details = "off";
        }


        $forum_title = mysql_real_escape_string(stripslashes($forum_title));
        $forum_desc = mysql_real_escape_string(stripslashes($forum_desc));

        $upd1 = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $forum_title . "' WHERE name = 'forum_title'");
        $upd2 = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $forum_desc . "' WHERE name = 'forum_desc'");
        $upd3 = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $forum_rank_team . "' WHERE name = 'forum_rank_team'");
        $upd4 = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $thread_forum_page . "' WHERE name = 'thread_forum_page'");
        $upd5 = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $mess_forum_page . "' WHERE name = 'mess_forum_page'");
        $upd6 = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $hot_topic . "' WHERE name = 'hot_topic'");
        $upd7 = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $post_flood . "' WHERE name = 'post_flood'");
        $upd8 = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $forum_field_max . "' WHERE name = 'forum_field_max'");
        $upd9 = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $forum_file . "' WHERE name = 'forum_file'");
        $upd10 = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $forum_file_level . "' WHERE name = 'forum_file_level'");
        $upd11 = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $forum_file_maxsize . "' WHERE name = 'forum_file_maxsize'");
        $upd12 = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $image_forums . "' WHERE name = 'image_forums'");
        $upd13 = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $birthday_forum . "' WHERE name = 'birthday_forum'");
        $upd14 = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $gamer_details . "' WHERE name = 'gamer_details'");
        $upd15 = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $profil_details . "' WHERE name = 'profil_details'");
        $upd16 = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $image_cat_mini . "' WHERE name = 'image_cat_mini'");
        $upd17 = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $forum_cat_prim . "' WHERE name = 'forum_cat_prim'");        
        
        // Action
        $texteaction = "". _ACTIONPREFFO .".";
        $acdate = time();
        $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
        //Fin action
        echo "<div class=\"notification success png_bg\">\n"
        . "<div>\n"
        . "" . _PREFUPDATED . "\n"
        . "</div>\n"
        . "</div>\n";
        redirect("index.php?file=Forum&page=admin", 2);
    }
	
	/**************************/
	/***** Patch Catégorie ****/
	/**************************/
	    function select_forum_pri()
    {
        global $nuked; 

        $sqlpri = mysql_query("SELECT id, nom FROM " . FORUM_PRIMAIRE_TABLE . " ORDER BY ordre, nom");
        while (list($cid, $nom) = mysql_fetch_row($sqlpri))
        {
            $nom = printSecuTags($nom);

            echo "<option value=\"" . $cid . "\">" . $nom . "</option>\n";
        }
    }
	
    function main_cat_primaire()
    {
        global $nuked, $language;

        echo "<script type=\"text/javascript\">\n"
			."<!--\n"
			."\n"
			. "function delcat_primaire(titre, id)\n"
			. "{\n"
			. "if (confirm('" . _DELETEFORUM . " '+titre+' ! " . _CONFIRM . "'))\n"
			. "{document.location.href = 'index.php?file=Forum&page=admin&op=del_cat_primaire&cid='+id;}\n"
			. "}\n"
			. "\n"
			. "// -->\n"
			. "</script>\n";

		echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
			. "<div class=\"content-box-header\"><h3>" . _ADMINCATPRIMAIRE . "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Forum.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div>\n"
			. "</div>\n"
			. "<div class=\"tab-content\" id=\"tab2\"><div style=\"text-align: center;\"><b><a href=\"index.php?file=Forum&amp;page=admin\">" . _FORUM . "</a></b> | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=add_forum\">" . _ADDFORUM . "</a></b> | "
			. "" . _CATPRIMAIREMANAGEMENT . " | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_cat\">" . _CATMANAGEMENT . "</a></b> | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_rank\">" . _RANKMANAGEMENT . "</a></b> | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=prune\">" . _PRUNE . "</a></b> | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=skin\">" . _SKINS . "</a></b> | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_pref\">" . _PREFS . "</a></b></div><br />\n"
			. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" width=\"70%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\">\n"
			. "<tr>\n"
			. "<td style=\"width: 30%;\" align=\"center\"><b>" . _CATPRIMAIRE . "</b></td>\n"
			. "<td style=\"width: 20%; text-align: center;\" align=\"center\"><b>" . _LEVELACCES . "</b></td>\n"
			. "<td style=\"width: 20%; text-align: center;\" align=\"center\"><b>" . _ORDER . "</b></td>\n"
			. "<td style=\"width: 15%; text-align: center;\" align=\"center\"><b>" . _EDIT . "</b></td>\n"
			. "<td style=\"width: 15%; text-align: center;\" align=\"center\"><b>" . _DEL . "</b></td></tr>\n";

	
        $sql = mysql_query("SELECT id, nom, ordre, niveau FROM " . FORUM_PRIMAIRE_TABLE . " ORDER BY ordre, nom");
        while (list($cid, $nom, $ordre, $niveau) = mysql_fetch_row($sql))
        {
            $nom = printSecuTags($nom);
			
            echo "<tr>\n"
            . "<td style=\"width: 30%;\" align=\"center\">" . $nom . "</td>\n"
            . "<td style=\"width: 20%; text-align: center;\" align=\"center\">" . $niveau . "</td>\n"
            . "<td style=\"width: 20%; text-align: center;\" align=\"center\">" . $ordre . "</td>\n"
            . "<td style=\"width: 15%; text-align: center;\" align=\"center\"><a href=\"index.php?file=Forum&amp;page=admin&amp;op=edit_cat_primaire&amp;cid=" . $cid . "\"><img style=\"border: 0;\" src=\"images/edit.gif\" alt=\"\" title=\"" . _EDITTHISCATPRIMAIRE . "\" /></a></td>\n"
            . "<td style=\"width: 15%; text-align: center;\" align=\"center\"><a href=\"javascript:delcat_primaire('" . mysql_real_escape_string(stripslashes($nom)) . "', '" . $cid . "');\"><img style=\"border: 0;\" src=\"images/del.gif\" alt=\"\" title=\"" . _DELTHISCATPRIMAIRE . "\" /></a></td></tr>\n";
        }

        echo "</table><br /><div style=\"text-align: center;\">[ <a href=\"index.php?file=Forum&amp;page=admin&amp;op=add_cat_primaire\"><b>" . _ADDCATPRIMAIRE . "</b></a> ]</div>\n"
		. "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Forum&amp;page=admin\"><b>" . _BACK . "</b></a> ]</div><br /></div></div>\n";
    }

    function add_cat_primaire()
    {
        global $language;

       echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
			. "<div class=\"content-box-header\"><h3>" . _ADMINCATPRIMAIREADD . "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Forum.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div>\n"
			. "</div>\n"
//message top    
      . "<div style=\"padding: 20px 20px 0 20px;\">\n"
      . "<div class=\"notification attention png_bg\" >\n"
      ."<a href=\"#\" class=\"close\"><img src=\"modules/Admin/images/icons/cross_grey_small.png\" title=\"Fermer la notification\" alt=\"close\" /></a>\n"
      . "<div>\n"
      . "" . _CATIMAGESIZE . "\n"
      . "</div>\n"
      . "</div>\n"
      . "</div>\n"	
//end top message			
			. "<div class=\"tab-content\" id=\"tab2\"><form method=\"post\" action=\"index.php?file=Forum&amp;page=admin&amp;op=send_cat_primaire\" enctype=\"multipart/form-data\">\n"
			. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" cellspacing=\"1\" cellpadding=\"2\" border=\"0\">\n"
			. "<tr><td><b>" . _NAME . " :</b> <input type=\"text\" name=\"nom\" size=\"30\" /></td></tr>\n"
      . "<tr><td><b>" . _IMAGE . " :</b> <input type=\"text\" name=\"urlimage\" size=\"42\" /></td></tr>\n"
      . "<tr><td><b>" . _UPLOADIMAGE . " :</b> <input type=\"file\" name=\"upimage\" /></td></tr>\n"			
			. "<tr><td><b>" . _LEVELACCES . " :</b> <select name=\"niveau\">\n"
			. "<option>0</option>\n"
			. "<option>1</option>\n"
			. "<option>2</option>\n"
			. "<option>3</option>\n"
			. "<option>4</option>\n"
			. "<option>5</option>\n"
			. "<option>6</option>\n"
			. "<option>7</option>\n"
			. "<option>8</option>\n"
			. "<option>9</option></select>\n"
			. "&nbsp;<b>" . _ORDER . " :</b> <input type=\"text\" name=\"ordre\" value=\"0\" size=\"2\" /></td></tr></table>\n"
			. "<div style=\"text-align: center;\"><br /><input type=\"submit\" value=\"" . _CREATECATPRIMAIRE . "\" /></div>"
			. "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_cat_primaire\"><b>" . _BACK . "</b></a> ]</div></form><br /></div></div>\n";
    }

    function send_cat_primaire($nom, $niveau, $ordre, $urlimage, $upimage)
    {
        global $nuked, $user;

        $nom = mysql_real_escape_string(stripslashes($nom));

        $filename = $_FILES['upimage']['name'];
        if ($filename != "") {
          $ext = pathinfo($filename, PATHINFO_EXTENSION);

          if ($ext == "jpg" || $ext == "jpeg" || $ext == "JPG" || $ext == "JPEG" || $ext == "gif" || $ext == "GIF" || $ext == "png" || $ext == "PNG") {
            $url_image = "upload/Forum/cat/" . $filename;
            move_uploaded_file($_FILES['upimage']['tmp_name'], $url_image) or die ("<br /><br /><div style=\"text-align: center;\"><b>Upload file failed !!!</b></div><br /><br />");
            @chmod ($url_image, 0644);
          } else {
            echo "<div class=\"notification error png_bg\">\n"
               . "<div>\n"
               . "No image file !"
               . "</div>\n"
               . "</div>\n";
            redirect("index.php?file=News&page=admin", 2);
            adminfoot();
            footer();
            die;
          }
        } else {
          $url_image = $urlimage;
        }

        $sql = mysql_query("INSERT INTO " . FORUM_PRIMAIRE_TABLE . " ( `id` , `nom` , `ordre` , `niveau`, `image` ) VALUES ( '' , '" . $nom . "' , '" . $ordre . "' , '" . $niveau . "' , '" . $url_image . "' )");
        // Action
        $texteaction = "". _ACTIONADDCATFO .": ".$nom."";
        $acdate = time();
        $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
        //Fin action
        echo "<div class=\"notification success png_bg\">\n"
        . "<div>\n"
        . "" . _CATPRIMAIREADD . "\n"
        . "</div>\n"
        . "</div>\n";
        echo "<script>\n"
            ."setTimeout('screen()','3000');\n"
            ."function screen() { \n"
            ."screenon('index.php?file=Forum', 'index.php?file=Forum&page=admin&op=main_cat_primaire');\n"
            ."}\n"
            ."</script>\n";
    }	

    function edit_cat_primaire($cid)
    {
        global $nuked, $language;
		
        $sql = mysql_query("SELECT nom, niveau, ordre, image FROM " . FORUM_PRIMAIRE_TABLE . " WHERE id = '" . $cid . "'");
        list($nom, $niveau, $ordre, $catprimaire_image) = mysql_fetch_array($sql);

        echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
			. "<div class=\"content-box-header\"><h3>" . _ADMINCATPRIMAIREEDIT . "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Forum.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div>\n"
			. "</div>\n"
//message top    
      . "<div style=\"padding: 20px 20px 0 20px;\">\n"
      . "<div class=\"notification attention png_bg\" >\n"
      ."<a href=\"#\" class=\"close\"><img src=\"modules/Admin/images/icons/cross_grey_small.png\" title=\"Fermer la notification\" alt=\"close\" /></a>\n"
      . "<div>\n"
      . "" . _CATIMAGESIZE . "\n"
      . "</div>\n"
      . "</div>\n"
      . "</div>\n"	
//end top message			
			. "<div class=\"tab-content\" id=\"tab2\"><form method=\"post\" action=\"index.php?file=Forum&amp;page=admin&amp;op=modif_cat_primaire\" enctype=\"multipart/form-data\">\n"
			. "<table style=\"margin-left: auto;margin-right: auto;text-align: left;\" cellspacing=\"1\" cellpadding=\"2\" border=\"0\">\n"
			. "<tr><td><b>" . _NAME . " :</b> <input type=\"text\" name=\"nom\" size=\"30\" value=\"" . $nom . "\" /></td></tr>\n"
      . "<tr><td><b>" . _IMAGE . " :</b> <input type=\"text\" name=\"urlimage\" size=\"42\" value=\"" . $catprimaire_image . "\"/></td></tr>\n"
      . "<tr><td><b>" . _UPLOADIMAGE . " :</b> <input type=\"file\" name=\"upimage\" /></td></tr>\n"			
			. "<tr><td><b>" . _LEVELACCES . " :</b> <select name=\"niveau\"><option>" . $niveau . "</option>\n"
			. "<option>0</option>\n"
			. "<option>1</option>\n"
			. "<option>2</option>\n"
			. "<option>3</option>\n"
			. "<option>4</option>\n"
			. "<option>5</option>\n"
			. "<option>6</option>\n"
			. "<option>7</option>\n"
			. "<option>8</option>\n"
			. "<option>9</option></select>&nbsp;<b>" . _ORDER . " :</b> <input type=\"text\" name=\"ordre\" size=\"2\" value=\"" . $ordre . "\" /></td></tr>\n";

		echo "</select></td></tr></table>\n"
			. "<div style=\"text-align: center;\"><br /><input type=\"hidden\" name=\"cid\" value=\"" . $cid . "\" /><input type=\"submit\" value=\"" . _MODIFTHISCAT . "\" /></div>"
			. "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_cat_primaire\"><b>" . _BACK . "</b></a> ]</div></form><br /></div></div>";
    }

    function modif_cat_primaire($cid, $nom, $niveau, $ordre, $urlimage, $upimage)
    {
        global $nuked, $user;

        $nom = mysql_real_escape_string(stripslashes($nom));
        
        $filename = $_FILES['upimage']['name'];
        if ($filename != "") {
          $ext = pathinfo($filename, PATHINFO_EXTENSION);

          if ($ext == "jpg" || $ext == "jpeg" || $ext == "JPG" || $ext == "JPEG" || $ext == "gif" || $ext == "GIF" || $ext == "png" || $ext == "PNG") {
            $url_image = "upload/Forum/cat/" . $filename;
            move_uploaded_file($_FILES['upimage']['tmp_name'], $url_image) or die ("<br /><br /><div style=\"text-align: center;\"><b>Upload file failed !!!</b></div><br /><br />");
            @chmod ($url_image, 0644);
          } else {
            echo "<div class=\"notification error png_bg\">\n"
               . "<div>\n"
               . "No image file !"
               . "</div>\n"
               . "</div>\n";
            redirect("index.php?file=News&page=admin", 2);
            adminfoot();
            footer();
            die;
          }
        } else {
          $url_image = $urlimage;
        }        
        		
		$sql2 = mysql_query("SELECT id FROM " . FORUM_CAT_TABLE . " WHERE id = '" . $cid . "'");
        list($id) = mysql_fetch_array($sql2);

        $sql = mysql_query("UPDATE " . FORUM_PRIMAIRE_TABLE . " SET nom = '" . $nom . "', ordre = '" . $ordre . "', niveau = '" . $niveau . "' , image = '" . $url_image . "' WHERE id = '" . $cid . "'");		
        $sql_cat = mysql_query("UPDATE " . FORUM_CAT_TABLE . " SET niveau = '" . $niveau . "' WHERE cat_primaire = '" . $cid . "'");
        $sql_forum = mysql_query("UPDATE " . FORUM_TABLE . " SET niveau = '" . $niveau . "' WHERE cat = '" . $id . "'");
		
		
        // Action
        $texteaction = "". _ACTIONMODIFCATFO .": ".$nom."";
        $acdate = time();
        $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
        //Fin action
        echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. "" . _CATPRIMAIREMODIF . "\n"
			. "</div>\n"
			. "</div>\n";
        echo "<script>\n"
            ."setTimeout('screen()','3000');\n"
            ."function screen() { \n"
            ."screenon('index.php?file=Forum', 'index.php?file=Forum&page=admin&op=main_cat_primaire');\n"
            ."}\n"
            ."</script>\n";
    }

    function del_cat_primaire($cid)
    {
        global $nuked, $user;
        
        $sql2 = mysql_query("SELECT nom FROM " . FORUM_PRIMAIRE_TABLE . " WHERE id = '" . $cid . "'");
        list($nom) = mysql_fetch_array($sql2);
        $nom = mysql_real_escape_string($nom);
        $sql = mysql_query("DELETE FROM " . FORUM_PRIMAIRE_TABLE . " WHERE id = '" . $cid . "'");
		
        // Action
        $texteaction = "". _ACTIONDELCATFO .": ".$nom."";
        $acdate = time();
        $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
        //Fin action
        echo "<div class=\"notification success png_bg\">\n"
			. "<div>\n"
			. "" . _CATDEL . "\n"
			. "</div>\n"
			. "</div>\n";
        echo "<script>\n"
            ."setTimeout('screen()','3000');\n"
            ."function screen() { \n"
            ."screenon('index.php?file=Forum', 'index.php?file=Forum&page=admin&op=main_cat');\n"
            ."}\n"
            ."</script>\n";
    }

    function del_modocat($uid, $cat_id)
    {
        global $nuked, $user;
        
        $sql = mysql_query("SELECT moderateurs FROM " . FORUM_CAT_TABLE . " WHERE id = '" . $cat_id . "'");
        list($listmodo) = mysql_fetch_row($sql);
        $list = explode("|", $listmodo);
        for($i = 0; $i <= count($list)-1;$i++)
        {
            if ($i == 0 || ($i == 1 && $list[0] == $uid))
            {
                $sep = "";
            }
            else
            {
                $sep = "|";
            }

            if ($list[$i] != $uid)
            {
                $modos .= $sep . $list[$i];
            }
        }

        $upd = mysql_query("UPDATE " . FORUM_CAT_TABLE . " SET moderateurs = '" . $modos . "' WHERE id = '" . $cat_id . "'");
        
        $sql = mysql_query("SELECT pseudo FROM " . USER_TABLE . " WHERE id = '".$uid."'");
        list($pseudo) = mysql_fetch_array($sql);
        $pseudo = mysql_real_escape_string($pseudo);
        // Action
        $texteaction = "". _ACTIONDELMODOFO .": ".$pseudo."";
        $acdate = time();
        $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')");
        //Fin action
        echo "<div class=\"notification success png_bg\">\n"
        . "<div>\n"
        . "" . _MODODEL . "\n"
        . "</div>\n"
        . "</div>\n";
        
        $url = "index.php?file=Forum&page=admin&op=edit_cat&cid=" . $cat_id;
        redirect($url, 2);
    }
	

    function skin()
    {
        global $language, $nuked, $bgcolor2, $bgcolor3;
		
			echo '<script type="text/javascript"><!--'."\n"
			. 'document.write(\'<link rel="stylesheet" type="text/css" href="media/shadowbox/shadowbox.css">\');'."\n"
			. '--></script>'."\n"
			. '<script type="text/javascript" src="media/shadowbox/shadowbox.js"></script>'."\n"
			. '<script type="text/javascript">'."\n"
			. 'Shadowbox.init({overlayOpacity: 0.8,});'."\n"
			. '</script>'."\n";
			
    echo"<script type=\"text/javascript\">
			function lien() 
			{
				var adress = 'modules/Forum/Skin/';
				var prev = '/images/template/preview.jpg';			
				var image = document.getElementById('skin').options[document.getElementById('skin').selectedIndex].value;
				
				lienshadow.href = adress+image+prev;
				Shadowbox.setup(lienshadow);
				document.getElementById('lienshadow').href=adress+image+prev;
				document.getElementById('lienshadow').style.display='inline';
				document.getElementById('apercu').src=adress+image+prev;
				document.getElementById('apercu').style.border='1px solid $bgcolor3';
			}
		</script>";
				
		echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
			. "<div class=\"content-box-header\"><h3>" . _ADMIN . " - " . _SKINS . "</h3>\n"
			. "<div style=\"text-align:right;\"><a href=\"help/" . $language . "/Forum.php\" rel=\"modal\">\n"
			. "<img style=\"border: 0;\" src=\"help/help.gif\" alt=\"\" title=\"" . _HELP . "\" /></a>\n"
			. "</div>\n"
			. "</div>\n"
			. "<div class=\"tab-content\" id=\"tab2\">\n"
			. "<div style=\"text-align: center;\"><b><a href=\"index.php?file=Forum&amp;page=admin\">" . _FORUM . "</a></b> | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=add_forum\">" . _ADDFORUM . "</a></b> | ";
      if ($nuked['forum_cat_prim'] == "on")
{ 			
			echo "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_cat_primaire\">" . _CATPRIMAIREMANAGEMENT . "</a></b> | ";
}			
			echo "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_cat\">" . _CATMANAGEMENT . "</a></b> | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_rank\">" . _RANKMANAGEMENT . "</a></b> | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=prune\">" . _PRUNE . "</a></b> | "
			. "" . _SKINS . " | "
			. "<b><a href=\"index.php?file=Forum&amp;page=admin&amp;op=main_pref\">" . _PREFS . "</a></b></div><br />\n"
			. "<form method=\"post\" action=\"index.php?file=Forum&amp;page=admin&amp;op=send_skin\" id=\"tagada\">\n"
			. "<table style=\"margin: auto;\" cellspacing=\"1\" cellpadding=\"2\" border=\"0\">\n"
			. "<tr><td style=\"text-align: right; width: 50%;\"><b>" . _SKIN . " :</b> <select name=\"skin\" id=\"skin\" onchange=\"lien();\" >\n"
			. "<option value=\"" . $nuked['forum_skin'] . "\">" . $nuked['forum_skin'] . "</option>\n";
			
					$rep = "modules/Forum/Skin/";
					$dir = opendir($rep);
			 
					while ($f = readdir($dir))
					{
						if ($f != "." && $f != "..")
						{
							if(is_dir($rep . "/" . $f)) 
							{
								echo"<option value=\"" . $f . "\">" . $f . "</option>";
							}
						} 
					}
					closedir($dir);
			
			echo "</select></td>\n"
			
				/* Apercu avec un lien */
				. "<td><a href=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/template/preview.jpg\" id=\"lienshadow\" rel=\"shadowbox\" style=\"display: none;\">Voir l'aperçu</a>\n"
				/* Apercu avec image */
				//. "<td><a href=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/template/preview.jpg\" id=\"lienshadow\" rel=\"shadowbox\" style=\"display: none;\"><img src=\"modules/Forum/Skin/" . $nuked['forum_skin'] . "/preview.jpg\" id=\"apercu\" width=\"70\" style=\"border: 1px dotted $bgcolor2\" /></a></td>\n"

				. "</td></tr></table>\n"
				. "<div style=\"text-align: center; margin-bottom: 15px;\" colspan=\"2\"><br /><input type=\"submit\" value=\"" . _SENDSKIN . "\" /></div></form></div></div>\n";			

			if($nuked['forum_who_primaire'] == "oui") $checkprim = "checked=\"checked\"";
			if($nuked['forum_who_secondaire'] == "oui") $checkseco = "checked=\"checked\"";
			if($nuked['forum_who_viewforum'] == "oui") $checkforu = "checked=\"checked\"";
			if($nuked['forum_who_viewtopic'] == "oui") $checktopi = "checked=\"checked\"";
			
			if($nuked['forum_name_primaire'] == "oui") $checknameprim = "checked=\"checked\"";
			if($nuked['forum_name_secondaire'] == "oui") $checknameseco = "checked=\"checked\"";
			if($nuked['forum_name_viewforum'] == "oui") $checknameforu = "checked=\"checked\"";
			if($nuked['forum_name_viewtopic'] == "oui") $checknametopi = "checked=\"checked\"";
						
			if($nuked['forum_search_primaire'] == "oui") $checksearchprim = "checked=\"checked\"";
			if($nuked['forum_search_secondaire'] == "oui") $checksearchseco = "checked=\"checked\"";
			if($nuked['forum_search_viewforum'] == "oui") $checksearchforu = "checked=\"checked\"";
			if($nuked['forum_search_viewtopic'] == "oui") $checksearchtopi = "checked=\"checked\"";
			
			if($nuked['forum_quick_edit'] == "oui")
			{
				$checkquicks = "true";
				$checkquickchecked = "checked=\"checked\"";
			}
			else{
				$quickmododisable = "disabled=\"disabled\"";			
				$quickuserdisable = "disabled=\"disabled\"";
			}
			
			
			if($nuked['forum_quick_modo'] == "oui" && $nuked['forum_quick_user'] == "oui")
			{
				$checkquickchecked = "checked=\"checked\"";				
				$quickmodochecked = "checked=\"checked\"";	
				$quickuserchecked = "checked=\"checked\"";	
				$quickmododisable = "disabled=\"disabled\"";	
			}
			else if($nuked['forum_quick_modo'] == "oui")
			{
				$quickmodochecked = "checked=\"checked\"";
				$checkquickusers = "true";
			}
			else if($nuked['forum_quick_modo'] != "oui" && $nuked['forum_quick_user'] != "oui" )
			{
				$checkquickusers = "false";
			}
			else 
			{			
				$quickmododisable = "disabled=\"disabled\"";			
				$quickuserdisable = "disabled=\"disabled\"";
			}
			?>
			<script type="text/javascript">			
			function cocher(etat)
			{
				var quickmodo = document.getElementById('quickmodo');
				var quickusers = document.getElementById('quickuser');
				
				casesTab = new Array('quickmodo', 'quickuser');

				for ( i = 0 ; i < casesTab.length ; i++ )
				{
					document.getElementById(casesTab[i]).checked = etat;
				}
				
				if ( etat == true )
				{
					nvelEtat = false;
					quickmodo.disabled = true;
				}	
				else
				{
					nvelEtat = true;
					quickmodo.checked = true;
					quickmodo.disabled = false;
				}
				document.getElementById('quickuser').onclick = function(){ cocher(eval(nvelEtat)); }
			}
			
			function activer(etats, etat)
			{
				var quickmodos = document.getElementById('quickmodo');
				var quickusers = document.getElementById('quickuser');
				
				casesTabs = new Array('quickmodo', 'quickuser');

				for ( i = 0 ; i < casesTabs.length ; i++ )
				{
					document.getElementById(casesTabs[i]).checked = etats;
				}
				
				if ( etats == true )
				{
					nvelEtats = false;
					quickmodos.checked = false;
					quickusers.checked = false;
					quickusers.disabled = true;
					quickmodos.disabled = true;
				}	
				else
				{
					quickmodos.checked = true;
					quickusers.checked = true;
					quickmodos.disabled = true;
					quickusers.disabled = false;
					nvelEtats = true;
				}	
				document.getElementById('quick').onclick = function(){ activer(eval(nvelEtats)); }
				document.getElementById('quickuser').value = nveauValue;
			}
			</script>
			<?php
			
			echo "<div class=\"content-box\">\n" //<!-- Start Content Box -->
			. "<div class=\"content-box-header\"><h3>" . _ADMIN . " - " . _SKINS . " - " . _SKINSOPT . "</h3>\n"
			. "<div style=\"text-align:right;\">\n"
			. "<a href=\"modules/Forum/help/" . $language . "/help.php\" rel=\"modal\"><img style=\"border: 0;\" src=\"modules/Forum/help/help.png\" alt=\"\" title=\"" . _HELPTEMPLATE . "\" /></a>\n"
			. "</div>\n"
			. "</div>\n"
		. "<form method=\"post\" action=\"index.php?file=Forum&amp;page=admin&amp;op=send_skin_pref\">\n"
		. "<table style=\"margin: auto;\" cellspacing=\"1\" cellpadding=\"2\" border=\"0\">\n"
		. "<tr>\n"
		. "<td>\n"		
			. "<table style=\"margin: auto;\" cellspacing=\"1\" cellpadding=\"2\" border=\"0\">\n"
			. "<tr>\n"
			. "<td style=\"margin: auto; text-align: center;\" colspan=\"2\"><b>" . _SEEOPT . " :</b> </td>\n"
			. "</tr>\n"
			. "<tr>\n"
			. "<td style=\"text-align: right; width: 70%;\"><b>" . _PRIM . " :</b> </td>\n"
			. "<td style=\"text-align: left;\"><input type=\"checkbox\" name=\"primaire\" value=\"oui\" " . $checkprim . " ></td>\n"
			. "</tr>\n"
			. "<tr>\n"
			. "<td style=\"text-align: right; width: 70%;\"><b>" . _SECO . " :</b> </td>\n"
			. "<td style=\"text-align: left;\"><input type=\"checkbox\" name=\"secondaire\" value=\"oui\" " . $checkseco . " ></td>\n"
			. "</tr>\n"
			. "<tr>\n"
			. "<td style=\"text-align: right; width: 70%;\"><b>" . _FORU . " :</b> </td>\n"
			. "<td style=\"text-align: left;\"><input type=\"checkbox\" name=\"viewforum\" value=\"oui\" " . $checkforu . " ></td>\n"
			. "</tr>\n"
			. "<tr>\n"
			. "<td style=\"text-align: right; width: 70%;\"><b>" . _TOPI . " :</b> </td>\n"
			. "<td style=\"text-align: left;\"><input type=\"checkbox\" name=\"viewtopic\" value=\"oui\" " . $checktopi . " ></td>\n"			
			. "</tr></table>\n"			
		. "</td>\n"
		. "<td>\n"		
			. "<table style=\"margin: auto;\" cellspacing=\"1\" cellpadding=\"2\" border=\"0\">\n"
			. "<tr>\n"
			. "<td style=\"margin: auto; text-align: center;\" colspan=\"2\"><b>" . _SEEOPT2 . " :</b> </td>\n"
			. "</tr>\n"
			. "<tr>\n"
			. "<td style=\"text-align: right; width: 70%;\"><b>" . _PRIM . " :</b> </td>\n"
			. "<td style=\"text-align: left;\"><input type=\"checkbox\" name=\"nameprim\" value=\"oui\" " . $checknameprim . " ></td>\n"
			. "</tr>\n"
			. "<tr>\n"
			. "<td style=\"text-align: right; width: 70%;\"><b>" . _SECO . " :</b> </td>\n"
			. "<td style=\"text-align: left;\"><input type=\"checkbox\" name=\"nameseco\" value=\"oui\" " . $checknameseco . " ></td>\n"
			. "</tr>\n"
			. "<tr>\n"
			. "<td style=\"text-align: right; width: 70%;\"><b>" . _FORU . " :</b> </td>\n"
			. "<td style=\"text-align: left;\"><input type=\"checkbox\" name=\"nameforu\" value=\"oui\" " . $checknameforu . " ></td>\n"
			. "</tr>\n"
			. "<tr>\n"
			. "<td style=\"text-align: right; width: 70%;\"><b>" . _TOPI . " :</b> </td>\n"
			. "<td style=\"text-align: left;\"><input type=\"checkbox\" name=\"nametopi\" value=\"oui\" " . $checknametopi . " ></td>\n"			
			. "</tr></table>\n"			
		. "</td>\n"
		. "<td>\n"				
			. "<table style=\"margin: auto;\" cellspacing=\"1\" cellpadding=\"2\" border=\"0\">\n"
			. "<tr>\n"
			. "<td style=\"margin: auto; text-align: center;\" colspan=\"2\"><b>" . _SEEOPT3 . " :</b> </td>\n"
			. "</tr>\n"
			. "<tr>\n"
			. "<td style=\"text-align: right; width: 70%;\"><b>" . _PRIM . " :</b> </td>\n"
			. "<td style=\"text-align: left;\"><input type=\"checkbox\" name=\"searchprim\" value=\"oui\" " . $checksearchprim . " ></td>\n"
			. "</tr>\n"
			. "<tr>\n"
			. "<td style=\"text-align: right; width: 70%;\"><b>" . _SECO . " :</b> </td>\n"
			. "<td style=\"text-align: left;\"><input type=\"checkbox\" name=\"searchseco\" value=\"oui\" " . $checksearchseco . " ></td>\n"
			. "</tr>\n"
			. "<tr>\n"
			. "<td style=\"text-align: right; width: 70%;\"><b>" . _FORU . " :</b> </td>\n"
			. "<td style=\"text-align: left;\"><input type=\"checkbox\" name=\"searchforu\" value=\"oui\" " . $checksearchforu . " ></td>\n"
			. "</tr>\n"
			. "<tr>\n"
			. "<td style=\"text-align: right; width: 70%;\"><b>" . _TOPI . " :</b> </td>\n"
			. "<td style=\"text-align: left;\"><input type=\"checkbox\" name=\"searchtopi\" value=\"oui\" " . $checksearchtopi . " ></td>\n"		
			. "</tr></table>\n"			
		. "</td>\n"
		. "<td>\n"				
			. "<table style=\"margin: auto;\" cellspacing=\"1\" cellpadding=\"2\" border=\"0\">\n"
			. "<tr>\n"
			. "<td style=\"margin: auto; text-align: center;\" colspan=\"2\"><b>" . _SEEOPT4 . " :</b> </td>\n"
			. "</tr>\n"
			. "<tr>\n"
			. "<td style=\"text-align: right; width: 70%;\"><b>" . _ACTIVEQUICK . " :</b> </td>\n"
			. "<td style=\"text-align: left;\"><input type=\"checkbox\" id=\"quick\" name=\"quick\" onclick=\"activer(" . $checkquicks . ");\" value=\"oui\" " . $checkquickchecked . " ></td>\n"
			. "</tr>\n"
			. "<tr>\n"
			. "<td style=\"text-align: right; width: 70%;\"><b>" . _ACTIVEQUICKMODO . " :</b> </td>\n"
			. "<td style=\"text-align: left;\"><input type=\"checkbox\" id=\"quickmodo\" name=\"quickmodo\" value=\"oui\" ". $quickmododisable . " " .$quickmodochecked . " ></td>\n"
			. "</tr>\n"
			. "<tr>\n"
			. "<td style=\"text-align: right; width: 70%;\"><b>" . _ACTIVEQUICKUSER . " :</b> </td>\n"
			. "<td style=\"text-align: left;\"><input type=\"checkbox\" id=\"quickuser\" name=\"quickuser\" onclick=\"cocher(" . $checkquickusers . ");\" value=\"oui\" ". $quickuserdisable . " " . $quickuserchecked . " ></td>\n"		
			. "</tr></table>\n"			
		. "</td>\n"
		. "</tr>\n"
		. "</table>\n"
			. "<div style=\"text-align: center; margin-bottom: 15px;\" colspan=\"3\"><br /><input type=\"submit\" value=\"" . _SENDSKIN . "\" /></div></form></div>";
			
			echo "<div style=\"text-align: center;\"><br />[ <a href=\"index.php?file=Forum&amp;page=admin\"><b>" . _BACK . "</b></a> ]</div><br />\n";
    }

    function send_skin($skin)
    {
        global $nuked, $user;

        $skin = mysql_real_escape_string(stripslashes($skin));
		
		$sql = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $skin . "' WHERE name = 'forum_skin' ");
		$sql = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = 'oui' WHERE name = 'forum_who_primaire' ");
		$sql = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = 'oui' WHERE name = 'forum_who_secondaire' ");
		$sql = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = 'oui' WHERE name = 'forum_who_viewforum' ");
		$sql = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = 'oui' WHERE name = 'forum_who_viewtopic' ");				
		
        // Action
        $texteaction = mysql_real_escape_string(_ACTIONSKINMOD . ": " . $skin);
        $acdate = time();
        $sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action  (`date`, `pseudo`, `action`)  VALUES ('".$acdate."', '".$user[0]."', '".$texteaction."')") or die (mysql_error());
        //Fin action
        echo "<div class=\"notification success png_bg\">\n"
        . "<div>\n"
        . "" . _SKINADD . "\n"
        . "</div>\n"
        . "</div>\n";
        echo "<script>\n"
            ."setTimeout('screen()','3000');\n"
            ."function screen() { \n"
            ."screenon('index.php?file=Forum', 'index.php?file=Forum&page=admin&op=skin');\n"
            ."}\n"
            ."</script>\n";
    }

    function send_skin_pref($primaire, $secondaire, $viewforum, $viewtopic, $nameprim, $nameseco, $nameforu, $nametopi, $searchprim, $searchseco, $searchforu, $searchtopi, $quick, $quickmodo, $quickuser)
    {
        global $nuked, $user, $language;

		if($quick != "oui") $quick = "non";
		if($quickmodo != "oui") $quickmodo = "non";
		if($quickuser != "oui") $quickuser = "non";
		if($quickuser == "oui") $quickmodo = "oui";
							
		$sql = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $primaire . "' WHERE name = 'forum_who_primaire' ");
		$sql = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $secondaire . "' WHERE name = 'forum_who_secondaire' ");
		$sql = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $viewforum . "' WHERE name = 'forum_who_viewforum' ");
		$sql = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $viewtopic . "' WHERE name = 'forum_who_viewtopic' ");

		$sql = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $nameprim . "' WHERE name = 'forum_name_primaire' ");
		$sql = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $nameseco . "' WHERE name = 'forum_name_secondaire' ");
		$sql = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $nameforu . "' WHERE name = 'forum_name_viewforum' ");
		$sql = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $nametopi . "' WHERE name = 'forum_name_viewtopic' ");	

		$sql = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $searchprim . "' WHERE name = 'forum_search_primaire' ");
		$sql = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $searchseco . "' WHERE name = 'forum_search_secondaire' ");
		$sql = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $searchforu . "' WHERE name = 'forum_search_viewforum' ");
		$sql = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $searchtopi . "' WHERE name = 'forum_search_viewtopic' ");

		$sql = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $quick . "' WHERE name = 'forum_quick_edit' ");
		$sql = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $quickmodo . "' WHERE name = 'forum_quick_modo' ");
		$sql = mysql_query("UPDATE " . CONFIG_TABLE . " SET value = '" . $quickuser . "' WHERE name = 'forum_quick_user' ");
		
        // Action
		if($quick == "oui")
		{
			$acdate = time();
			$texteaction1  = mysql_real_escape_string(_ACTIONQUICK . ": " . _QEDIT);
			$sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action (`date`, `pseudo`, `action`) VALUES ('".$acdate."', '".$user[0]."', '".$texteaction1."')") or die (mysql_error());
		}
		else
		{
			$acdate = time();
			$texteaction2  = mysql_real_escape_string(_ACTIONQUICK . ": " . _QEDIT);
			$sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action (`date`, `pseudo`, `action`) VALUES ('".$acdate."', '".$user[0]."', '".$texteaction2."')") or die (mysql_error());
		}
		
		if($quickmodo == "oui")
		{
			$acdate = time();
			$texteaction3  = mysql_real_escape_string(_ACTIONQUICK . ": " . _QEDITMODO);
			$sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action (`date`, `pseudo`, `action`) VALUES ('".$acdate."', '".$user[0]."', '".$texteaction3."')") or die (mysql_error());
		}
		else
		{
			$acdate = time();
			$texteaction4  = mysql_real_escape_string(_ACTIONQUICK . ": " . _QEDITMODO);
			$sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action (`date`, `pseudo`, `action`) VALUES ('".$acdate."', '".$user[0]."', '".$texteaction4."')") or die (mysql_error());
		}
		
		if($quickuser == "oui")
		{
			$acdate = time();
			$texteaction5  = mysql_real_escape_string(_ACTIONQUICK . ": " . _QEDITUSER);
			$sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action (`date`, `pseudo`, `action`) VALUES ('".$acdate."', '".$user[0]."', '".$texteaction5."')") or die (mysql_error());
		}
		else
		{
			$acdate = time();
			$texteaction6  = mysql_real_escape_string(_ACTIONQUICK . ": " . _QEDITUSER);
			$sqlaction = mysql_query("INSERT INTO ". $nuked['prefix'] ."_action (`date`, `pseudo`, `action`) VALUES ('".$acdate."', '".$user[0]."', '".$texteaction6."')") or die (mysql_error());
		}
		
        //Fin action
        echo "<div class=\"notification success png_bg\">\n"
        . "<div>\n"
        . "" . _SKINOPTADD . "\n"
        . "</div>\n"
        . "</div>\n";
        echo "<script>\n"
            ."setTimeout('screen()','3000');\n"
            ."function screen() { \n"
            ."screenon('index.php?file=Forum', 'index.php?file=Forum&page=admin&op=skin');\n"
            ."}\n"
            ."</script>\n";
    }	
	

    switch ($_REQUEST['op'])
    {
        case "edit_forum":
            edit_forum($_REQUEST['id']);
            break;

        case "modif_forum":
            modif_forum($_REQUEST['id'], $_REQUEST['titre'], $_REQUEST['cat'], $_REQUEST['description'], $_REQUEST['niveau'], $_REQUEST['level'], $_REQUEST['ordre'], $_REQUEST['level_poll'], $_REQUEST['level_vote'], $_REQUEST['modo'], $_REQUEST['urlimage'], $_REQUEST['upimage']);
            break;

        case "add_forum":
            add_forum();
            break;

        case "del_modo":
            del_modo($_REQUEST['uid'], $_REQUEST['forum_id']);
            break;

        case "send_cat":
            send_cat($_REQUEST['nom'], $_REQUEST['cat'], $_REQUEST['description'], $_REQUEST['niveau'], $_REQUEST['level'], $_REQUEST['ordre'], $_REQUEST['modo'], $_REQUEST['urlimage'], $_REQUEST['upimage'], $_REQUEST['urlimagemini'], $_REQUEST['upimagemini']);
            break;

        case "add_cat":
            add_cat();
            break;

        case "main_cat":
            main_cat();
            break;

        case "edit_cat":
            edit_cat($_REQUEST['cid']);
            break;

        case "modif_cat":
            modif_cat($_REQUEST['cid'], $_REQUEST['nom'], $_REQUEST['cat'], $_REQUEST['description'], $_REQUEST['niveau'], $_REQUEST['level'], $_REQUEST['ordre'], $_REQUEST['modo'], $_REQUEST['urlimage'], $_REQUEST['upimage'], $_REQUEST['urlimagemini'], $_REQUEST['upimagemini']);
            break;

        case "del_cat":
            del_cat($_REQUEST['cid']);
            break;

        case "del_forum":
            del_forum($_REQUEST['id']);
            break;

        case "send_forum":
            send_forum($_REQUEST['titre'], $_REQUEST['description'], $_REQUEST['cat'], $_REQUEST['modo'], $_REQUEST['niveau'], $_REQUEST['level'], $_REQUEST['ordre'], $_REQUEST['level_poll'], $_REQUEST['level_vote'], $_REQUEST['urlimage'], $_REQUEST['upimage']);
            break;

        case "main_rank":
            main_rank();
            break;

        case "add_rank":
            add_rank();
            break;

        case "send_rank":
            send_rank($_REQUEST['nom'], $_REQUEST['type'], $_REQUEST['post'], $_REQUEST['image']);
            break;

        case "del_rank":
            del_rank($_REQUEST['rid']);
            break;

        case "edit_rank":
            edit_rank($_REQUEST['rid']);
            break;

        case "modif_rank":
            modif_rank($_REQUEST['rid'], $_REQUEST['nom'], $_REQUEST['type'], $_REQUEST['post'], $_REQUEST['image']);
            break;

        case "prune":
            prune();
            break;

        case "do_prune":
            do_prune($_REQUEST['day'], $_REQUEST['forum_id']);
            break;

        case "main_pref":
            main_pref();
            break;

        case "change_pref":
            change_pref($_REQUEST['forum_title'], $_REQUEST['forum_desc'], $_REQUEST['forum_rank_team'], $_REQUEST['thread_forum_page'], $_REQUEST['mess_forum_page'], $_REQUEST['hot_topic'], $_REQUEST['post_flood'], $_REQUEST['forum_field_max'], $_REQUEST['forum_file'], $_REQUEST['forum_file_level'], $_REQUEST['forum_file_maxsize'], $_REQUEST['forum_cat_prim'], $_REQUEST['image_cat_mini'], $_REQUEST['image_forums'], $_REQUEST['birthday_forum'], $_REQUEST['gamer_details'], $_REQUEST['profil_details']);
            break;

        default:
            main();
            break;	
			
		/**************************/
		/***** Patch Catégorie ****/
		/**************************/		
        case "del_modocat":
            del_modocat($_REQUEST['uid'], $_REQUEST['cat_id']);
            break;

		case "main_cat_primaire":
            main_cat_primaire();
            break;

        case "add_cat_primaire":
            add_cat_primaire();
            break;

        case "send_cat_primaire":
            send_cat_primaire($_REQUEST['nom'], $_REQUEST['niveau'], $_REQUEST['ordre'], $_REQUEST['urlimage'], $_REQUEST['upimage']);
            break;

        case "edit_cat_primaire":
            edit_cat_primaire($_REQUEST['cid']);
            break;

        case "modif_cat_primaire":
            modif_cat_primaire($_REQUEST['cid'], $_REQUEST['nom'], $_REQUEST['niveau'], $_REQUEST['ordre'], $_REQUEST['urlimage'], $_REQUEST['upimage']);
            break;

        case "del_cat_primaire":
            del_cat_primaire($_REQUEST['cid']);
            break;

        case "skin":
            skin();
            break;

        case "send_skin":
            send_skin($_REQUEST['skin']);
            break;

        case "send_skin_pref":																																													
            send_skin_pref($_REQUEST['primaire'], $_REQUEST['secondaire'], $_REQUEST['viewforum'], $_REQUEST['viewtopic'], $_REQUEST['nameprim'], $_REQUEST['nameseco'], $_REQUEST['nameforu'], $_REQUEST['nametopi'], $_REQUEST['searchprim'], $_REQUEST['searchseco'], $_REQUEST['searchforu'], $_REQUEST['searchtopi'], $_REQUEST['quick'], $_REQUEST['quickmodo'], $_REQUEST['quickuser']);
            break;
    }

}
else if ($level_admin == -1)
{
    echo "<div class=\"notification error png_bg\">\n"
    . "<div>\n"
    . "<br /><br /><div style=\"text-align: center;\">" . _MODULEOFF . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />"
    . "</div>\n"
    . "</div>\n";
}
else if ($visiteur > 1)
{
    echo "<div class=\"notification error png_bg\">\n"
    . "<div>\n"
    . "<br /><br /><div style=\"text-align: center;\">" . _NOENTRANCE . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />"
    . "</div>\n"
    . "</div>\n";
}
else
{
    echo "<div class=\"notification error png_bg\">\n"
    . "<div>\n"
    . "<br /><br /><div style=\"text-align: center;\">" . _ZONEADMIN . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />"
    . "</div>\n"
    . "</div>\n";
}

adminfoot();

?>