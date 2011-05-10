<form action="/add" method="post" class="uniForm new">
  <fieldset class="inlineLabels">
	<legend><?=_("Poser une question");?></legend>
    <div class="ctrlHolder">
      <label for="title"><?=_("Titre de votre question");?></label>
      <input id="" name="title" size="35" class="textInput required" minlength="<?=$params['minQuestionTitle'];?>" type="text">
      <p class="formHint"></p>
    </div>
  
    <div class="wmd-container">
		<div id="wmd-editor" class="wmd-panel">
			<div id="wmd-button-bar"></div>
			<textarea id="wmd-input" name="content" class="required" minlength="<?=$params['minQuestionContent'];?>"></textarea>
			 <p class="formHint"></p>
		</div>
		<span class="separator"><?=_("Prévisualisation de votre question");?></span>
		<div id="wmd-preview" class="wmd-panel"></div>
		
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
<script type="text/javascript" src="/js/jquery.wmd.min.js"></script>
