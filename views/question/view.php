<div class="question_view">

	<h1><?=$question->title;?></h1>
	
	<div class="content">
	
		<?=$question->content;?>
		
	</div>

</div>

<?
if(count($answers)>0):
	?>
	<span class="separator"><?=sprintf(ngettext("1 réponse","%s réponses",count($answers)),count($answers));?></span>
	<?
	foreach($answers as $answer):
		?>
		<?=$answer->content;?>
		<?
	endforeach;
endif;
?>


<? if(!$question->isAnswered()): ?>

<span class="separator"><?=_("Ajouter votre réponse");?></span>

<form class="uniForm">
	<fieldset>
		<textarea style="width:99%"></textarea>
		<div class="buttonHolder"><button type="submit" class="primaryAction"><?=_("Ajouter ma réponse");?></button></div>
	</fieldset>
</form>

<? endif; ?>
