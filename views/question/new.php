<form action="/add" method="post" class="uniForm">
  <fieldset class="inlineLabels">
	<legend><?=_("Poser une question");?></legend>
    <div class="ctrlHolder">
      <label for="title"><?=_("Titre de votre question");?></label>
      <input id="" name="title" size="35" class="textInput required" type="text">
      <p class="formHint"><?=_("Titre de votre question");?></p>
    </div>
  
    <div class="ctrlHolder">
      <label for="question"><?=_("Votre question");?></label>
      <textarea class="required" name="content" rows="35" cols="25"></textarea>
      <p class="formHint"><?=_("Soyez précis");?></p>
    </div>
  
    <div class="ctrlHolder">
      <label for=""><?=_("Mot clés");?></label>
      <input id="" name="" value="" size="35" class="textInput required" type="text">
      <p class="formHint"><?=_("Minimum 1 mot clé");?></p>
    </div>
    
    <div class="buttonHolder"><button type="submit" class="primaryAction"><?=_("Ajouter votre question");?></button></div>
    
  </fieldset>
</form>
