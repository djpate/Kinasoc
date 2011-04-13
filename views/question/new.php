<form action="/add" method="post" class="uniForm new">
  <fieldset class="inlineLabels">
	<legend><?=_("Poser une question");?></legend>
    <div class="ctrlHolder">
      <label for="title"><?=_("Titre de votre question");?></label>
      <input id="" name="title" size="35" class="textInput required" minlength="<?=$params['minQuestionTitle'];?>" type="text">
      <p class="formHint"></p>
    </div>
  
    <div class="ctrlHolder forceLeftDiv">
      <label for="question"><?=_("Votre question");?></label>
      <textarea class="required" name="content" rows="35" cols="25" minlength="<?=$params['minQuestionContent'];?>"></textarea>
      <p class="formHint"></p>
    </div>
  
    <div class="ctrlHolder">
      <label for=""><?=_("Mot clés");?></label>
      <ul id="tags">
      </ul>
      <p class="formHint"></p>
    </div>
    
    <div class="buttonHolder"><button type="submit" class="primaryAction"><?=_("Ajouter votre question");?></button></div>
    
  </fieldset>
</form>
<script>
	$(document).ready(function(){
		$("textarea").wysiwyg({
			'initialContent': '',
			'autoGrow': true
		});
		
		$(".new").validate({
			submitHandler: function(form){
				if($("input[name='tags[]']").length < <?=$params['minTagsPerQuestion'];?>){
					displayError("<?=sprintf(ngettext("Vous devez choisir au moins %s tag","Vous devez choisir au moins %s tags",$params['minTagsPerQuestion']),$params['minTagsPerQuestion']);?>"); 
				} else if($("input[name='tags[]']").length > <?=$params['maxTagsPerQuestion'];?>){
					displayError("<?=sprintf(_("Vous devez choisir au maximum %s tags"),$params['maxTagsPerQuestion']);?>"); 
				} else {
					form.submit();
				}
			},
			errorPlacement: function(error, element) {
				error.appendTo( element.next() );
			}
		});
	
		$("#tags").tagit({
			availableTags: "<?=\kinaf\routes::url_to("tags","json");?>",
			canCreateTags: <?=$params['canCreateTags'];?>,
			deleteOnBackspace: false,
			failedToCreate: function(val){
				if(val.length>0){
					displayError("Vous ne pouvez pas creer le tag "+val);
				}
			}
		});
	
	});
</script>
