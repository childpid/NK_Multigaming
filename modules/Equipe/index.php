<?php 
// ***********************************************
// Nuked-KlaN - PHP Portal
// Php by MasterCat
// Msn : admin@mastercat-gloup.com
// http://mastercat-gloup.com
// ----------------------------------------------------------------------
// Mis à jour pour la nk1.7.9 par YurtY
// www.overlord.power-heberg.com
// bribri.dlf@gmail.com
// ----------------------------------------------------------------------
// Module Staff
// Page index.php
// Faite pour Mx-Design
// ***********************************************
if (!defined("INDEX_CHECK"))
{
    die ("<div style=\"text-align: center;\">You cannot open this page directly</div>");
} 

global $language, $user;
translate("modules/Equipe/lang/" . $language . ".lang.php");
$visiteur = (!$user) ? 0 : $user[1];

$ModName = basename(dirname(__FILE__));
$level_access = nivo_mod($ModName);
if ($visiteur >= $level_access && $level_access > -1)
{

    function index() {
	 global $theme, $nuked, $cid, $user, $visiteur;
	
			$sql_config = mysql_query("SELECT mail, icq, msn, aim, yim, xfire, facebook, originea, steam, twiter, skype, nivoreq FROM ". $nuked['prefix'] ."_users_config");
		list($c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $c10, $c11, $nivoreq) = mysql_fetch_array($sql_config);
	
    opentable();
	  echo '<div id="Equipe">';

	  $sql1=mysql_query('SELECT * FROM '.$nuked['prefix'].'_staff_cat ORDER BY ordre ASC');
	  while($req1 = mysql_fetch_object($sql1))
	  {	
	  	if ($req1->img != 'non') $img_url = '<a href="index.php?file=Equipe&amp;op=view_cat&amp;cat_id='.$req1->id.'"><img src="'.$req1->img.'" alt="" style="border:none;" title="Afficher uniquement les '.$req1->nom.'" /></a>';
		else $img_url = '<a href="index.php?file=Equipe&op=view_cat&cat_id=' .$req1->id. '">' .$req1->nom. '</a>';
	  			
		echo '<div class="equipe"><div class="equipetitre">' . $img_url . '</div><div class="equipeliste">';
		$ii=1;
		
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
   echo '<td>' . _RANK . '</td></tr></thead><tbody>';
		
		  $sql2=mysql_query('SELECT * FROM '.$nuked['prefix'].'_staff WHERE categorie_id="'.$req1->id.'"');
		  while($req2 = mysql_fetch_object($sql2))
		  {
		    $sql3=mysql_query('SELECT * FROM '.$nuked['prefix'].'_users WHERE id="'.$req2->membre_id.'"');
		    $req3 = mysql_fetch_object($sql3);
			
			$sql4=mysql_query('SELECT * FROM '.$nuked['prefix'].'_users_detail WHERE user_id="'.$req2->membre_id.'"');
		    $req4 = mysql_fetch_object($sql4);
			
			$sql5=mysql_query('SELECT * FROM '.$nuked['prefix'].'_staff_status WHERE id="'.$req2->status_id.'"');
		    $req5 = mysql_fetch_object($sql5);
			
			$sql6=mysql_query('SELECT * FROM '.$nuked['prefix'].'_staff_rang WHERE id="'.$req2->rang_id.'"');
		    $req6 = mysql_fetch_object($sql6);
						
		   $img = "images/user/email.png";


			
			list ($pays, $ext) = split ('[.]', $country);
			
                        echo '<tr>'
                        . '<td><img src="images/flags/' . $req3->country . '" alt="" />&nbsp;&nbsp;<a href="index.php?file=Members&amp;op=detail&amp;autor='.urlencode($req3->pseudo).'"><b>'.stripslashes($req1->tag).''.stripslashes($req3->pseudo).''.stripslashes($req1->tag2).'</a></td>';
                        
                        if ($c1 == 'on')
                  {
                        echo '<td>';

                        if ($req3->email != "" && $visiteur >= $nivoreq)
                        {
                            echo '<a href="mailto' . $req3->email . '"><img src="' . $img . '" alt="" title="' . $req3->email . '" /></a></td>';
                        } 
                        else
                        {
                            echo '<img src="images/user/emailna.png" alt=""/></td>';
                        } 
                  }
                        if ($c2 == 'on')
                  {
                        echo '<td>';

                        if ($req3->icq != "" && $visiteur >= $nivoreq)
                        {
                            echo '<a href="http://web.icq.com/whitepages/add_me?uin=' . $req3->icq . '&amp;action=add"><img src="images/user/icq.png" alt="" title="' . $req3->icq . '" /></a></td>';
                        } 
                        else{
                        echo '<img src="images/user/icqna.png" alt=""/></td>';
                        } 
                  }
                        if ($c3 == 'on')
                  {
                        echo '<td>';

                        if ($req3->msn != "" && $visiteur >= $nivoreq)
                        {
                            echo '<a href="mailto:' . $req3->msn . '"><img src="images/user/msn.png" alt="" title="' . $msn . '" /></a></td>';
                        } 
                        else{
                            echo '<img src="images/user/msnna.png" alt=""/></td>';
                        } 
                  }
                        if ($c4 == 'on')
                  {
                        echo '<td>';

                        if ($req3->aim != "" && $visiteur >= $nivoreq)
                        {
                            echo '<a href="aim:goim?screenname=' . $req3->aim . '&amp;message=Hi+' . $req3->aim . '+Are+you+there+?"><img src="images/user/aim.png" alt="" title="' . $req3->aim . '" /></a></td>';
                        } 
                        else{
                            echo '<img src="images/user/aimna.png" alt=""/></td>';
                        } 
                  }
                        if ($c5 == 'on')
                  {
                        echo '<td>';

                        if ($req3->yim != "" && $visiteur >= $nivoreq)
                        {
                            echo '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $req3->yim . '&amp;.src=pg"><img src="images/user/yahoo.png" alt="" title="' . $req3->yim . '" /></a></td>';
                        } 
                        else{
                            echo '<img src="images/user/yahoona.png" alt=""/></td>';
                        } 
                  }
                        if ($c6 == 'on')
                  {
                        echo '<td>';

                        if ($req3->xfire != "" && $visiteur >= $nivoreq)
                        {
                            echo '<a href="xfire:add_friend?user=' . $req3->xfire . '"><img src="images/user/xfire.png" alt="" title="' . $req3->xfire . '" /></a></td>';
                        } 
                        else{
                            echo '<img src="images/user/xfirena.png" alt=""/></td>';
                        } 
                  }
                        if ($c7 == 'on')
                  {
                        echo '<td>';

                        if ($req3->facebook != "" && $visiteur >= $nivoreq)
                        {
                            echo '<a href="http://www.facebook.com/' . $req3->facebook . '"><img src="images/user/facebook.png" alt="" title="' . $req3->facebook . '" /></a></td>';
                        } 
                        else{
                            echo '<img src="images/user/facebookna.png" alt=""/></td>';
                        } 
                  }
                        if ($c8 == 'on')
                  {
                        echo '<td>';

                        if ($req3->origin != "" && $visiteur >= $nivoreq)
                        {
                            echo '<img src="images/user/origin.png" alt="" title="' . $req3->origin . '" /></td>';
                        } 
                        else{
                            echo '<img src="images/user/originna.png" alt=""/></td>';
                        } 
                  }
                        if ($c9 == 'on')
                  {
                        echo '<td>';

                        if ($req3->steam != "" && $visiteur >= $nivoreq)
                        {
                            echo '<a href="http://steamcommunity.com/actions/AddFriend/' . $req3->steam . '"><img src="images/user/steam.png" alt="" title="' . $req3->steam . '" /></a></td>';
                        } 
                        else{
                            echo '<img src="images/user/steamna.png" alt=""/></td>';
                        } 
                  }
                        if ($c10 == 'on')
                  {
                        echo '<td>';

                        if ($req3->twitter != "" && $visiteur >= $nivoreq)
                        {
                            echo '<a href="http://twitter.com/#!/' . $req3->twitter . '"><img src="images/user/twitter.png" alt="" title="' . $req3->twitter . '" /></a></td>';
                        } 
                        else{
                            echo '<img src="images/user/twitterna.png" alt="" /></td>';
                        } 
                  }
                        if ($c11 == 'on')
                  {
                        echo '<td>';

                        if ($req3->skype != "" && $visiteur >= $nivoreq)
                        {
                            echo '<a href="skype:' . $req3->skype . '?call"><img src="images/user/skype.png" alt="" title="' . $req3->skype . '"/></a></td>';
                        } 
                        else{
                            echo '<img src="images/user/skypena.png" alt=""/></td>';
                        } 
                  }
                  						
						echo '<td>';
						
						$nom = $req6->nom;
						$nom = stripslashes($nom);
						if ($req6->nom != "" && $req6->ordre >= 0)
                        {
                        echo $nom;
						} 
                        else
                        {
                            echo 'N/A';
                        } 
                     } 
                

                echo '</td></tr></tbody></table></div></div>';
                $j = 0;
            }
		echo '</div>';
        closetable();
    } 
	
	function view_cat($cat_id) {
	global $bgcolor1, $bgcolor2, $bgcolor3, $theme, $nuked;
	
    opentable();
	echo '<div id="Equipe">';
	  $sql1=mysql_query('SELECT * FROM '.$nuked['prefix'].'_staff_cat WHERE id="'.$cat_id.'"');
	  while($req1 = mysql_fetch_object($sql1))
	  {
	    if ($req1->img != 'non') $img_url = '<img src="'.$req1->img.'" alt="" style="border:none;" title="'.$req1->nom.'" />';
		else $img_url = ''.$req1->nom.'';
		
		  echo '<div classe="equipe"><div class="equipetitre"><h3>' . $img_url . '</h3></div><div class="equipelistecat"><div class="row-fluid">';
		  $cpt = 0;
		  $sql2=mysql_query('SELECT * FROM '.$nuked['prefix'].'_staff WHERE categorie_id="'.$req1->id.'"');
		  while($req2 = mysql_fetch_object($sql2))
		  {
		    $sql3=mysql_query('SELECT * FROM '.$nuked['prefix'].'_users WHERE id="'.$req2->membre_id.'"');
		    $req3 = mysql_fetch_object($sql3);
			
			$sql4=mysql_query('SELECT * FROM '.$nuked['prefix'].'_users_detail WHERE user_id="'.$req2->membre_id.'"');
		    $req4 = mysql_fetch_object($sql4);
			
			$sql5=mysql_query('SELECT * FROM '.$nuked['prefix'].'_staff_status WHERE id="'.$req2->status_id.'"');
		    $req5 = mysql_fetch_object($sql5);
			
			$sql6=mysql_query('SELECT * FROM '.$nuked['prefix'].'_staff_rang WHERE id="'.$req2->rang_id.'"');
		    $req6 = mysql_fetch_object($sql6);
				
	        $age1=$req4->age;
            $age = explode('/', $age);
            if($req4->photo == "")
			{
			$photos_membre = 'modules/User/images/noavatar.png';
			}
			else 
			{
			$photos_membre = $req4->photo;
			}
            if ($age1 != "")
            {
                list ($jour, $mois, $an) = split ('[/]', $age1);
                $age = date("Y") - $an;
                if (date("m") < $mois)
                {
                    $age = $age-1;
                } 
                if (date("d") < $jour && date("m") == $mois)
                {
                    $age = $age - 1;
                } 
            } 
            else
            {
                $age = "N/A";
            } 
			
			$age = ($age != 'N/A') ? $age.' ans' : 'N/A';
			$membre_ville = ($req4->ville != '') ? $req4->ville : 'N/A';
			
			$prenom = ($req4->prenom != '') ? $req4->prenom : 'N/A';
			if($cpt==6)
			{
			echo '</div><div class="row-fluid">';
			$cpt=0;
			}
			echo '
			<div class="span2 widget">
			<div class="block-widget-header">
			<h2><a href="index.php?file=Members&amp;op=detail&amp;autor='.urlencode($req3->pseudo).'">'.stripslashes($req1->tag).''.stripslashes($req3->pseudo).''.stripslashes($req1->tag2).'</a></h2>
			</div>
			<div class="block-widget-content">
			<img class="img-polaroid" data-src="' . $photos_membre . '" alt="' . $req3->pseudo . '" src="' . $photos_membre . '">
			<ul>
			<li>Prenom : <b>'.stripslashes($prenom).'</b></li>
			<li>Age : <b>'.$age.'</b></li>
			<li>Ville : <b>'. $membre_ville.'</b></li>
			<li>Status : <b>'.$req5->nom.'</b></li>
			<li>Rang : <b>'.$req6->nom.'</b></li>
			</ul>
			<a class="btn" href="index.php?file=Members&amp;op=detail&amp;autor='.urlencode($req3->pseudo).'">Voir le profil</a>
			</div>
			</div>';
			$cpt++;
		  }
		  
		echo'</div></div><div style="text-align: center;"><br />[ <a href="index.php?file=Equipe"><b>Retour</b></a> ]</div>';
	  }

    closetable();
	}

    switch($_REQUEST['op'])
    {
        case"index":
            index();
            break;

        case"view_cat":
            view_cat($_REQUEST['cat_id']);
            break;

        default:
            index();
    } 

} 
else if ($level_access == -1)
{
    opentable();
    echo "<br /><br /><div style=\"text-align: center;\">" . _MODULEOFF . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />";
    closetable();
} 
else if ($level_access == 1 && $visiteur == 0)
{
    opentable();
    echo "<br /><br /><div style=\"text-align: center;\">" . _USERENTRANCE . "<br /><br /><b><a href=\"index.php?file=User&amp;op=login_screen\">" . _LOGINUSER . "</a> | "
    . "<a href=\"index.php?file=User&amp;op=reg_screen\">" . _REGISTERUSER . "</a></b></div><br /><br />";
    closetable();
} 
else
{
    opentable();
    echo "<br /><br /><div style=\"text-align: center;\">" . _NOENTRANCE . "<br /><br /><a href=\"javascript:history.back()\"><b>" . _BACK . "</b></a></div><br /><br />";
    closetable();
} 

?>