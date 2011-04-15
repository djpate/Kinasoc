<h2 class="title"><?=_("Connexion à votre compte");?></h1>

<h3 class="register"><?=_("Si vous avez un compte sur l'un des sites ci-dessous cliquer sur le logo pour vous connecter");?></h3>

<form action="/user/openid" method="get" id="openid_form">
	<input type="hidden" name="action" value="verify" />
	<div id="openid_choice">
		<div id="openid_btns"></div>
	</div>
	<div id="openid_input_area">
		<input id="openid_identifier" name="openid_identifier" type="text" value="http://" />
		<input id="openid_submit" type="submit" value="Sign-In"/>
	</div>
	<noscript>
		<p>OpenID is service that allows you to log-on to many different websites using a single indentity.
		Find out <a href="http://openid.net/what/">more about OpenID</a> and <a href="http://openid.net/get/">how to get an OpenID enabled account</a>.</p>
	</noscript>
</form>

<h3 class="register"><?=_("Si vous n'avez pas de compte sur un des ces site");?></h3>

	<a href="<?=\kinaf\routes::url_to("user","register");?>" class="register"><?=_("Créer un compte");?></a>
	
<h3 class="register"><?=_("Si vous avez oublier votre mot de passe");?></h3>

	<a href="<?=\kinaf\routes::url_to("user","forgot_pwd");?>" class="register"><?=_("Recupérer votre mot de passe");?></a>

	<script type="text/javascript">
		$(document).ready(function() {
			openid.init('openid_identifier');
		});
		
		function kinasoc_click(){
			location.href = "<?=\kinaf\routes::url_to("user","local_login");?>";
		}
	</script>
