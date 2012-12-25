<?php
	/************************************************
		*	Thème Nk_Bootstrap pour Nuked Klan	       *
	************************************************/
	defined("INDEX_CHECK") or die ("<div style=\"text-align: center;\">Access deny</div>");
	
	if ($user[1] < 9){
		echo '<div style="text-align: center;margin:30px 0;">Access deny</div>';
	}
	else{
		function index() {
		?>
		<div style="text-align: center;margin:20px 0;">
			<a style="display:block;" href="index.php?file=Admin&amp;page=theme&amp;sub=menu">
			Gestion Menu
			</a>
		</div>
		<?php
		}
		
		function menu_dropdown(){
			$nbr_menu = 5;
			
			if($_GET['action'] == 'save'){		
				$ecriretexte = '<?php';
				$nbr = 1;
				while ($nbr <= $nbr_menu){		
					$ecriretexte .= "\n".'$menu['.$nbr.'] = "'.$_POST['menu'.$nbr].'";'."\n".'$menu1['.$nbr.'] = "'.$_POST['menu1'.$nbr].'";';
					$nbr++;
				}
				
				$fichier = 'themes/NK_Bootstrap/admin/menu.php';
				$ecrire = fopen($fichier, "w+");
				fwrite($ecrire, $ecriretexte."\n?>");
				fclose($ecrire);
				
				echo '<div style="text-align: center;margin:20px 0;">'. _INSAVEMOD .'</div>';
				redirect ("index.php?file=Admin&page=theme".$iframe, 2);
				
			}
			else{
				include('themes/NK_Bootstrap/admin/menu.php');
			?>
			<div style="text-align: center;margin:20px 0;">
				<h3>Gestion du Menu</h3>
				<form method="post" action="index.php?file=Admin&amp;page=theme&amp;sub=menu&amp;action=save<?php echo $iframe ;?>">
					<fieldset>
						<?php
							$nbr = 1;
							while ($nbr <= $nbr_menu){
							?>		
							<p style="font-weight: bold; text-decoration: underline;">Menu n°<?php echo $nbr ;?></p>
							<div style="margin-bottom:10px;">
								<label for="lmenu<?php echo $nbr; ?>">
									Titre : 
									<input type="text" id="lmenu<?php echo $nbr ;?>" name="menu<?php echo $nbr ;?>" value="<?php echo stripslashes($menu[$nbr]) ;?>" />
								</label>
								<label for="lmenu1<?php echo $nbr; ?>">
									Url :
									<input type="text" id="lmenu1<?php echo $nbr ;?>" name="menu1<?php echo $nbr ;?>" value="<?php echo stripslashes($menu1[$nbr]) ;?>" />
								</label>		
							</div>
							<?php
								$nbr++;
							}
						?>
						<input type="submit" value="<?php echo _INSAVEMOD; ?>" />
					</fieldset>
				</form>
			</div>
			<?php
			}		
			echo '<div style="text-align: center;margin:10px 0;">[ <a href="index.php?file=Admin&amp;page=theme&amp;sub=menu"><b>' . _BACK . '</b></a> ]</div>';
		}
		
		switch ($_REQUEST['sub']){
			case"index":
			index();
			break;
			case"menu":
			menu();
			break;
			case"menudropdown":
			menu_dropdown();
			break;
			default:
			index();
		    break;
	}
}
?>