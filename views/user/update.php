<h2 class="title"><?=_("Gestion de votre compte");?></h2>
<form class="uniForm" id="updateAccount" onsubmit="return false">
  <fieldset class="inlineLabels">
    <div class="ctrlHolder">
      <label for=""><?=_("Adresse de votre Blog/Site")?></label>
      <input id="" name="website" value="<?=$connected_user->website;?>" size="35" class="textInput url" type="text">
      <p class="formHint"></p>
    </div>
  
    <div class="ctrlHolder">
      <p class="label"><?=_("Notifications")?></p>
      <ul class="blockLabels">
        <li><label for=""><input id=""  name="notificationAnswer" type="checkbox" <?if($connected_user->notificationAnswer==1){ echo "checked";}?>><?=_("Recevoir un email pour chaque réponse");?></label></li>
        <li><label for=""><input id=""  name="notificationQuestion" type="checkbox" <?if($connected_user->notificationQuestion==1){ echo "checked";}?>><?=_("Recevoir les nouvelles questions par email");?></label></li>
         <li><label for=""><input id="" name="newsletter" type="checkbox" <?if($connected_user->newsletter==1){ echo "checked";}?>><?=_("Recevoir notre newsletter");?></label></li>
      </ul>
    </div>
    
    <div class="ctrlHolder">
      <p class="label"><?=_("Cloture");?></p>
      <a href="#" class="closeAccount"><?=_("Je souhaite cloturer mon compte");?></a>
    </div>
    
    <div class="buttonHolder"><button type="submit" class="primaryAction"><?=_("Enregister");?></button></div>
  </fieldset>
</form>

<script>
	$("#updateAccount").validate({
		errorPlacement: function(error, element) {
			error.appendTo( element.next() );
		},
		submitHandler: function(){
			$.post("<?=\kinaf\routes::url_to("user","save");?>",$("#updateAccount").serialize(),function(data){
				if(data=="ok"){
					displayConfirmation("<?=_("Votre compte a bien été mise à jour");?>");
				}
			});
		}
	});
	
	$(".closeAccount").click(function(){
		if(confirm("<?=_("Vous êtes sur le point de cloturer definitivement votre compte. Êtes-vous sur de vouloir continuer ?");?>")){
			location.href = "<?=\kinaf\routes::url_to("user","close");?>";
		}
	});
</script>
          
