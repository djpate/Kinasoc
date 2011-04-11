<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="imagetoolbar" content="no" />
<title>Administration</title>
<link media="screen" rel="stylesheet" type="text/css" href="/css/admin/login.css"  />
<link media="screen" rel="stylesheet" type="text/css" href="/css/admin/login-blue.css"  />
</head>

<body>
	<!--[if !IE]>start wrapper<![endif]-->
	<div id="wrapper">
	<div id="wrapper2">
	<div id="wrapper3">
	<div id="wrapper4">
	<span id="login_wrapper_bg"></span>
	
	<div id="stripes">
	
		
		
		
		
		<!--[if !IE]>start login wrapper<![endif]-->
		<div id="login_wrapper">
			
			
			<? if(isset($error)){ ?>
			
			<div class="error">
				<div class="error_inner">
					<strong>Accès refusé</strong> | <span>Mauvaise combinaison</span>
				</div>
			</div>

			<? } ?>
			
			
			
			<!--[if !IE]>start login<![endif]-->
			<form method="post" action="<?=\kinaf\routes::url_to("admin","login");?>">
				<fieldset>
					
					<h1>Connexion</h1>
					<div class="formular">
						<span class="formular_top"></span>
						
						<div class="formular_inner">
						
						<label>
							<strong>Login :</strong>

							<span class="input_wrapper">
								<input name="login" type="text" />
							</span>
						</label>
						<label>
							<strong>Mot de passe :</strong>
							<span class="input_wrapper">
								<input name="password" type="password" />

							</span>
						</label>
						
						<ul class="form_menu">
							<li><span class="button"><span><span><em>Login</em></span></span><input type="submit" name=""/></span></li>
							<li><span class="button"><span><span><a href="http://www.application.com">Retour au site</a></span></span></span></li>
						</ul>
						
						</div>
						
						<span class="formular_bottom"></span>
						
					</div>
				</fieldset>
			</form>
			<!--[if !IE]>end login<![endif]-->
			
			<!--[if !IE]>start reflect<![endif]-->
			<span class="reflect"></span>
			<span class="lock"></span>
			<!--[if !IE]>end reflect<![endif]-->
			
			
		</div>

		<!--[if !IE]>end login wrapper<![endif]-->
	    </div>
		</div>
     	</div>
		</div>	
	</div>
	<!--[if !IE]>end wrapper<![endif]-->
</body>
</html>
