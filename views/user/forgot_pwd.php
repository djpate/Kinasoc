<h2 class="title"><?=_("Récuperation de votre mot de passe");?></h2>

<p><?=("Merci de renseigner votre adresse email dans le formulaire ci-dessous afin de recevoir votre nouveau mot de passe");?></p>

<form onsubmit="return false" id="forgotpwd" class="uniForm">
  <fieldset class="inlineLabels">
    
    <div class="ctrlHolder">
      <label for=""><?=_("Votre adresse email");?></label>
      <input name="email" size="35" class="textInput required email" type="text">
      <p class="formHint"></p>
    </div>
    
    <div class="ctrlHolder">
		<label for=""><?=_("Code de validation");?></label>
		<script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=<?=$params['reCaptcha_public'];?>"></script>
		<noscript>
			 <iframe src="http://www.google.com/recaptcha/api/noscript?k=<?=$params['reCaptcha_public'];?>"
					 height="300" width="500" frameborder="0"></iframe><br>
			 <textarea name="recaptcha_challenge_field" rows="3" cols="40">
			 </textarea>
			 <input type="hidden" name="recaptcha_response_field"
					 value="manual_challenge">
		</noscript>
		
	</div>
  
    <div class="buttonHolder"><button type="submit" class="primaryAction"><?=_("Envoyer");?></button></div>
  </fieldset>
</form>

<script>
	$("#forgotpwd").validate({
		errorPlacement: function(error, element) {
			error.appendTo( element.next() );
		},
		submitHandler: function(form){
			$.post("<?=\kinaf\routes::url_to("user","forgot_pwd");?>",$("#forgotpwd").serialize(),function(data){
				if(data == "ok"){
					displayConfirmation("<?=_("Un email contenant votre nouveau mot de passe vient de vous être envoyé");?>");
					$("#forgotpwd")[0].reset();
				} else if( data == "err_1"){
					displayError("<?=_("Le code de vérification est erroné");?>");
					Recaptcha.reload();
				} else if( data == "err_2"){
					Recaptcha.reload();
					displayError("<?=_("L'adresse email saisie ne correspond à aucun compte");?>");
				}
			});
		}
	});
</script>
