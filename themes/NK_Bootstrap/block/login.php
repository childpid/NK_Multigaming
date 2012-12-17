<?php
global $nuked, $user, $config;
    // Si le visiteur est déconnecté
    if( !$user ) {
?>
<div class="btn-group">
<a href="index.php?file=User&op=login_screen" class="btn">Connexion</a>
<a href="index.php?file=User&op=reg_screen" class="btn btn-success">Inscription</a>
</div>
<?php 
}
else { 
?>
<html lang="fr">
<head>
</head>
<body>
<div class="btn-group small">
  <button class="btn btn-primary"><i class="icon-user icon-white"></i><?php echo ' ' . $user[2] . ' ' ?></button>
  <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span> </button>
  <ul class="dropdown-menu">
    <li><a href="?file=User"><i class="icon-cog"></i>Votre compte</a></li>
    <li><a href="?file=Userbox"><i class="icon-envelope"></i>Vos messages</a></li>
    <li><a href="?file=Calendar"><i class="icon-calendar"></i>Calendrier</a></li>
	<li><a href="?file=User&amp;nuked_nude=index&amp;op=logout"><i class="icon-off"></i>Déconnexion</a></li>
	<?php if ($user[1] >= 6) echo '<li class="divider"></li><li><a href="?file=Admin" title="Administration"><i class="icon-list-alt"></i>Administration</a></li>' ?>
  </ul>
</div>
</body>
</html>
<?php
}
?>