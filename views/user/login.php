<h1><?=_("Connexion a votre compte");?></h1>

<form action="/user/openid" method="get" id="openid_form">
	<input type="hidden" name="action" value="verify" />
	<fieldset>
		<legend>Sign-in or Create New Account</legend>
		<div id="openid_choice">
			<p>Please click your account provider:</p>
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
	</fieldset>
</form>

	<script type="text/javascript">
		$(document).ready(function() {
			openid.init('openid_identifier');
		});
	</script>
