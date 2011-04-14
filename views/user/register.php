<h2 class="title"><?=_("Créer votre compte");?></h2>
<form action="#" id="register" class="uniForm">
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
    
    <div class="buttonHolder"><button type="submit" class="primaryAction"><?=_("Creer mon compte");?></button></div>
  
  </fieldset>
</form>
<script>
	$(document).ready(function(){
		$("#register").validate({
			errorPlacement: function(error, element) {
				error.appendTo( element.next() );
			},
			rules: {
				email: {
					remote: "<?=\kinaf\routes::url_to("user","register_helper");?>"
				},
				login: {
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
