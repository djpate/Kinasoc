<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="imagetoolbar" content="no" />
<title>Administration FITIZZY</title>
<link media="screen" rel="stylesheet" type="text/css" href="/css/admin/admin.css"  />
<link media="screen" rel="stylesheet" type="text/css" href="/css/admin/admin-blue.css"  />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://jquery-ui.googlecode.com/svn/trunk/ui/i18n/jquery.ui.datepicker-fr.js"></script>
<script type="text/javascript" src="/js/jquery.validate.pack.js"></script>
<script type="text/javascript" src="/js/pate.admin.msg.js"></script>
<link media="screen" rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/excite-bike/jquery-ui.css" />
</head>

<body>

	<!--[if !IE]>start wrapper<![endif]-->
	<div id="wrapper">
		
		
		<!--[if !IE]>start header main menu<![endif]-->
		
		<div id="header_main_menu">
		<span id="header_main_menu_bg"></span>
		
		<!--[if !IE]>start header<![endif]-->
		<div id="header">
			<div class="inner">
				<h1 id="logo"><a href="#">websitename <span>Administration Panel</span></a></h1>
				
				<!--[if !IE]>start user details<![endif]-->
				<div id="user_details">
					<ul id="user_details_menu">
						<li class="welcome">Welcome <strong>Administrator (<a class="new_messages" href="#">1 new message</a>)</strong></li>
						
						<li>
							<ul id="user_access">
								<li class="first"><a href="#">My account</a></li>
								<li class="last"><a href="/admin/logout">Log out</a></li>
							</ul>
						</li>
						
						
					</ul>
					
					<div id="server_details">
						<dl>
							<dt>Server time :</dt>
							<dd>9:22 AM | 03/04/2009</dd>
						</dl>
						<dl>
							<dt>Last login ip :</dt>
							<dd>192.168.0.25</dd>
						</dl>
					</div>
					
				</div>
				
				<!--[if !IE]>end user details<![endif]-->
			</div>
		</div>
		<!--[if !IE]>end header<![endif]-->
		
		<!--[if !IE]>start main menu<![endif]-->
		<div id="main_menu">
			<div class="inner">
			<ul>
				<?
				foreach($config['categories'] as $id => $category){
					?>
					<li>
						<a href="/admin/<?=$id;?>" <? if($current_category == $id) { echo 'class="selected_lk"'; } ?> ><span class="l"><span></span></span><span class="m"><em><?=$category['title'];?></em><span></span></span><span class="r"><span></span></span></a>
						<?
						if($id == $current_category){ ?>
							<ul>
								<? foreach($category['modules'] as $id => $val){ ?>
									<li><a href="/admin/<?=$current_category;?>/<?=$id;?>" <? if ($current_module == $id){ echo 'class="selected_lk"'; } ?> ><span class="l"><span></span></span><span class="m"><em><?=$val['title'];?></em><span></span></span><span class="r"><span></span></span></a></li>
								<? } ?>
							</ul>
						<? } ?>
					</li>
					<?
				}
				?>
			</ul>
			</div>
			<span class="sub_bg"></span>
		</div>
		<!--[if !IE]>end main menu<![endif]-->
		
		</div>
		
		<!--[if !IE]>end header main menu<![endif]-->
		
		
		<!--[if !IE]>start content<![endif]-->
		<div id="content">
			<div class="inner">
				<ul class="system_messages">
					<li class="red error"><span class="ico"></span><strong class="system_title"></strong> <a class="close" href="#">FERMER</a></li>
					<li class="blue info"><span class="ico"></span><strong class="system_title"></strong> <a class="close" href="#">FERMER</a></li>
					<li class="green valid"><span class="ico"></span><strong class="system_title"></strong> <a class="close" href="#">FERMER</a></li>
				</ul>
