<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 2.5 License

Name       : Regeneracy   
Description: A two-column, fixed-width design with dark color scheme.
Version    : 1.0
Released   : 20100529

-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Kinasoc</title>
	<link href="/css/style.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="/css/uni-form/uni-form.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="/css/uni-form/default.uni-form.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="/css/jquery.showMessage.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="/css/tag-it.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/themes/start/jquery-ui.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="/css/jquery.wysiwyg.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="/css/openid.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="/css/openid-shadow.css" rel="stylesheet" type="text/css" media="screen" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>
	<script type="text/javascript" src="/js/uni-form.jquery.min.js"></script>
	<script type="text/javascript" src="/js/jquery.showMessage.min.js"></script>
	<script type="text/javascript" src="/js/jquery.wysiwyg.js"></script>
	<script type="text/javascript" src="/js/jquery.validate.pack.js"></script>
	<script type="text/javascript" src="/js/tag-it.js"></script>
	<script type="text/javascript" src="/js/openid-jquery.js"></script>
	<script type="text/javascript" src="/js/openid-en.js"></script>
	<script type="text/javascript" src="/js/kinasoc.js"></script>
</head>
<body>
<div id="wrapper">
	<div id="header-wrapper">
		
		<div id="header">
			
			<div class="accountBar">
				<div style="padding:6px">
					<?
					if($connected):
						?>
						<img src="/images/account.png" />
						<a href="<?=\kinaf\routes::url_to("user","account");?>"><?=_("Votre compte");?></a>
						<img src="/images/logout.png" />
						<a href="<?=\kinaf\routes::url_to("user","logout");?>"><?=_("Se deconnecter");?></a>
						<?
					else:
						?>
						<img src="/images/login.png" />
						<a href="<?=\kinaf\routes::url_to("user","login");?>"><?=_("Connexion / Inscription");?></a>
						<?
					endif;
					?>
				</div>
			</div>

			<div id="logo">
				<h1><a href="/">Kinasoc</a></h1>
				<p>Kinasoc Is Not Another Stack Overflow Clone</p>
			</div>
			<div id="menu">
				<ul>
					<li class="current_page_item"><a href="/"><?=_("Questions");?></a></li>
					
					<li><a href="<?=\kinaf\routes::url_to("question","new");?>"><?=_("Posez une question");?></a></li>
					
					<li><a href="#"><?=_("Tags");?></a></li>
					<li><a href="#"><?=_("A propos");?></a></li>
				</ul>

			</div>
		</div>
	</div>
	<!-- end #header -->
	<div id="page">
		<div id="page-bgtop">
			<div id="page-bgbtm">
				<div id="content">
