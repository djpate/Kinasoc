<h2 class="title"><?=_("Créer votre compte");?></h2>
<form action="<?=\kinaf\routes::url_to("user","create");?>" onsubmit="return false" method="post" id="register" class="uniForm">
  <fieldset class="inlineLabels">
    <div class="ctrlHolder">
      <label for=""><?=_("Pseudo");?></label>
      <input id="" name="login" value="" size="35" class="textInput required" minlength="<?=$params['minLengthLogin'];?>" type="text">
      <p class="formHint"></p>
    </div>
  
    <div class="ctrlHolder">
      <label for=""><?=_("Mot de passe");?></label>
      <input id="password" name="password" value="" size="35" class="textInput required" minlength="<?=$params['minLengthPass'];?>" type="password">
      <p class="formHint"></p>
    </div>
  
    <div class="ctrlHolder">
      <label for=""><?=_("Confirmation mot de passe");?></label>
      <input id="" name="password_confirm" value="" size="35" class="textInput required" type="password">
      <p class="formHint"></p>
    </div>
  
    <div class="ctrlHolder">
      <label for=""><?=_("Email");?></label>
      <input id="" name="email" value="" size="35" class="textInput required email" type="text">
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
	
    <div class="buttonHolder"><button type="submit" class="primaryAction"><?=_("Creer mon compte");?></button></div>
  
  </fieldset>
</form>
<script>
	$(document).ready(function(){
		$("#register").validate({
			submitHandler: function(form){
				$.post("<?=\kinaf\routes::url_to("user","create");?>",$("#register").serialize(),function(data){
					if(data == "ok"){
						location.href = "<?=\kinaf\routes::url_to("home","index");?>";
					} else {
						switch(data){
							case 'err_1':
								displayError("<?=_("Le code de verification est vide");?>");
							break;
							case 'err_2':
								displayError("<?=_("Le pseudo est trop court");?>");
							break;
							case 'err_3':
								displayError("<?=_("Le mot de passe est trop court");?>");
							break;
							case 'err_4':
								displayError("<?=_("Le code de vérification est erroné");?>");
							break;
							case 'err_5':
								displayError("<?=_("L'adresse email est invalide");?>");
							break;
							case 'err_6':
								displayError("<?=_("L'adresse email est déjà utilisé");?>");
							break;
							case 'err_7':
								displayError("<?=_("Le pseudo est déjà utilisé");?>");
							break;
						}
					}
				});
			},
			errorPlacement: function(error, element) {
				error.appendTo( element.next() );
			},
			rules: {
				email: {
					remote: "<?=\kinaf\routes::url_to("user","register_helper");?>"
				},
				login: {
					validlogin: true,
					remote: "<?=\kinaf\routes::url_to("user","register_helper");?>"
				},
				password_confirm: {
					equalTo: "#password"
				}
			},
			messages: {
				email: {
					remote: "<?=_("Cet email existe déjà dans notre base de donnée");?>"
				},
				login: {
					remote: "<?=_("Cet login existe déjà");?>"
				},
			}
		});
	});
</script>
