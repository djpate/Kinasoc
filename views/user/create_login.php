<h2 class="title"><?=_("Choix de votre login");?></h2>
<form action="<?=\kinaf\routes::url_to("user","save_login");?>" onsubmit="return false" method="post" id="register" class="uniForm">
  <fieldset class="inlineLabels">
    
    <div class="ctrlHolder">
      <label for=""><?=_("Pseudo");?></label>
      <input id="" name="login" value="" size="35" class="textInput required" minlength="<?=$params['minLengthLogin'];?>" type="text">
      <p class="formHint"></p>
    </div>
	
    <div class="buttonHolder"><button type="submit" class="primaryAction"><?=_("Creer mon compte");?></button></div>
  
  </fieldset>
</form>
<script>
	$(document).ready(function(){
		$("#register").validate({
			submitHandler: function(form){
				$.post("<?=\kinaf\routes::url_to("user","save_login");?>",$("#register").serialize(),function(data){
					if(data=="ok"){
						location.href = "<?=$_SESSION['loginCallback'];?>";
					}
				});
			},
			errorPlacement: function(error, element) {
				error.appendTo( element.next() );
			},
			rules: {
				login: {
					validlogin: true,
					remote: "<?=\kinaf\routes::url_to("user","register_helper");?>"
				}
			},
			messages: {
				login: {
					remote: "<?=_("Ce login existe déjà");?>"
				},
			}
		});
	});
</script>
