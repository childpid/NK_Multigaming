<?php 
	
	/*Configuration du template*/
	defined("INDEX_CHECK") or die ("<div style=\"text-align: center;\">Accès interdit</div>");
	$config['full'] = 0;
	
    if($_REQUEST['file'] != 'News'){
        $config['full'] = 1;
	}
	
	/* ----------------------- */
	function top(){
        global $nuked, $user,$theme, $language, $config;
	?>
	<!DOCTYPE html>
	<html lang="fr"><head>
		<meta charset="iso-8859-1" />
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
		<title><?php echo $nuked['name'] ?> - <?php echo $nuked['slogan'] ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<link href="media/css/bootstrap.css" rel="stylesheet">
		<link href="media/css/bootstrap-responsive.css" rel="stylesheet">
		<link href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" rel="stylesheet">
		<link href="themes/<?php echo $theme ?>/css/style.css" rel="stylesheet">
		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<!-- Fav and touch icons -->
		<link rel="shortcut icon" href="http://twitter.github.com/bootstrap/assets/ico/favicon.ico">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="http://twitter.github.com/bootstrap/assets/ico/apple-touch-icon-57-precomposed.png">
	</head>
	
	<body>
		<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
		<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
		<script src="media/js/bootstrap.js"></script>
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container-fluid">
					<a class="brand" href="index.php"><?php echo $nuked['name'] ?></a>
					<div class="nav-collapse collapse">
						<ul class="nav" role="navigation">
							<li class="dropdown">
								<a id="drop1" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
								<ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
									<li><a tabindex="-1" href="http://google.com">Action</a></li>
									<li><a tabindex="-1" href="#anotherAction">Another action</a></li>
									<li><a tabindex="-1" href="#">Something else here</a></li>
								</ul>
							</li>
							<li class="dropdown">
								<a href="#" id="drop2" role="button" class="dropdown-toggle" data-toggle="dropdown">Dropdown 2 <b class="caret"></b></a>
								<ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
									<li><a tabindex="-1" href="#">Action</a></li>
									<li><a tabindex="-1" href="#">Another action</a></li>
									<li><a tabindex="-1" href="#">Something else here</a></li>
								</ul>
							</li>
						</ul>
						<ul class="nav pull-right"><li>
							<?php include_once('themes/' . $theme . '/block/login.php'); ?>
						</li></ul>
					</div><!--/.nav-collapse -->
				</div>
			</div>
		</div>
		<div id="wrap">
			<!-- Begin page content -->
			<div class="container-fluid">
				<div class="row-fluid">
					<?php if($config['full'] != 1) { ?>
						<div class="span3">
							<?php get_blok('gauche'); ?>
						</div>
						<div class="span6 well-white">
							<div class="row-fluid">
								<?php get_blok('centre'); ?>
							</div>
							<div class="row-fluid">
								<?php } else { ?>
								<div class="span12 well-white">
									
									<?php }} function footer() { 
									global $theme, $config;
								?>
							</div>
							<div class="row-fluid">
								<?php get_blok('bas'); ?>
							</div>
						</div>
						<?php if($config['full'] != 1) { ?>
							<div class="span3">
								<?php get_blok('droite'); ?>
							</div>
						<?php } ?>
					</div>
				</div>
				<div id="push"></div>
			</div>
			
		<div id="footer">
		<div class="container-fluid">
		<p class="muted credit">Codé par <a href="http://www.the-servants.fr">PepinKr</a> propulsé par <a href="http://www.nuked-klan.org/">Nuked-Klan</a>.</p>
		</div>
		</div>
		</body>
		</html>
		<?php
		}
		
		function news($data){
		$posted = _NEWSPOSTBY . "&nbsp;<a href=\"index.php?file=Members&amp;op=detail&amp;autor=" . urlencode($data['auteur']) . "\">" . $data['auteur'] . "</a>&nbsp;" . _THE . "&nbsp;". $data['date'];
        $comment = "<a href=\"index.php?file=News&amp;op=index_comment&amp;news_id=" . $data['id'] . "\">" . _NEWSCOMMENT . "</a>&nbsp;(" . $data['nb_comment'] . ")";
		?>
		<div class="widget-news">
		<div class="widget-header-news">
		<h2><?php echo $data['titre']; ?></h2>
		</div>
		<div class="widget-content-news">
		<div class="widget-text-news">
		<div class="widget-img-news"><?php echo $data['image']; ?></div>
		<?php echo $data['texte']; ?>
		</div>
		<div class="widget-bottom-news">
		<?php echo $comment; ?> - Publiée dans
		<a href="index.php?file=News&amp;op=categorie&amp;cat_id=<?php echo $data['catid']; ?>">
		<?php echo $data['cat']; ?>
		</a>
		<div class="pull-right">
		<?php echo $posted; ?>
		</div>
		</div>
		</div>
		</div>
		<?php
		}
		
		function block_centre($block){
		global $theme;
		?>
		<div class="widget">
		<div class="widget-header">
		<h2><?php echo $block['titre']; ?></h2>
		</div>
		<div class="well-bright">
		<div class="widget-text">
		<?php echo $block['content']; ?>
		</div>
		</div>
		</div>
		<?php
		}
		
		function block_bas($block){
		?>
		<div class="widget">
		<div class="widget-header">
		<h2><?php echo $block['titre']; ?></h2>
		</div>
		<div class="well-bright">
		<div class="widget-text">
		<?php echo $block['content']; ?>
		</div>
		</div>
		</div>
		<?php
		}
		
		function block_gauche($block){
		?>
		<div class="widget">
		<div class="widget-header">
		<a data-toggle="collapse" data-target="#gauche<?php echo $block['bid']; ?>"><h2><?php echo $block['titre']; ?>
		</h2></a>
		</div>
		<div id="gauche<?php echo $block['bid']; ?>" class="well-bright collapse in">
		<div class="widget-text">
		<?php echo $block['content']; ?>
		</div>
		</div>
		</div>
		<?php
		}
		
		function block_droite($block){
		?>
		<div class="widget">
		<div class="widget-header">
		<a data-toggle="collapse" data-target="#gauche<?php echo $block['bid']; ?>"><h2><?php echo $block['titre']; ?>
		</h2></a>
		</div>
		<div id="gauche<?php echo $block['bid']; ?>" class="well-bright collapse in">
		<div class="widget-text">
		<?php echo $block['content']; ?>
		</div>
		</div>
		</div>
		<?php
		}
		
		function opentable(){}
		function closetable(){}
		?>				