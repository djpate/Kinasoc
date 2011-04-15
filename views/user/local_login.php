<h2 class="title">Connexion à votre compte</h2>
<form action="" method="post" class="uniForm" id="login">
  <fieldset class="">
    <div class="ctrlHolder">
      <label for=""><?=_("Login");?></label>
      <input name="login" value="<?=$login;?>" size="35" class="textInput required" type="text">
      <p class="formHint"></p>
    </div>
  
    <div class="ctrlHolder">
      <label for=""><?=_("Mot de passe");?></label>
      <input name="password" value="" size="35" class="textInput required" type="password">
      <p class="formHint"></p>
    </div>
  
    <div class="buttonHolder"><button type="submit" class="primaryAction"><?=_("Connexion");?></button></div>
  </fieldset>
</form>
<script>
	$("#login").validate({
		errorPlacement: function(error, element) {
			error.appendTo( element.next() );
		}
	});
</script>
