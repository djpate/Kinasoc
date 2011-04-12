<div class="question_view">

	<div class="vote">
		<img src="/images/thumbs_up.png" class="link questionVote" rel="up"/>
		<span id="question_vote_value">
			<?=$question->getVote();?>
		</span>
		<img src="/images/thumbs_down.png" class="link questionVote" rel="down"/>
	</div>
	
	<div class="title">
		<h1><?=$question->title;?></h1>
	</div>
	
	<div style="clear:both"></div>
	
	<span class="separator"></span>
	
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
		<?=$parser->transform($answer->content);?>
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

<script>
<? if($connected): ?>
	$(".questionVote").click(function(){
		$.post("<?=\kinaf\routes::url_to("question","vote",$question);?>",{"type":$(this).attr('rel')},function(data){
			if(data=="ok"){
				$("#question_vote_value").load("<?=\kinaf\routes::url_to("question","current_vote",$question);?>");
			} else {
				switch(data){
					case 'err_1':
						var msg = "<?=_("Vous n'êtes pas connecté");?>";
					break;
					case 'err_2':
						var msg = "<?=_("Vous ne pouvez pas voter pour votre propre question");?>";
					break;
					case 'err_3':
						var msg = "<?=_("Vous avez déjà voté pour cette question");?>";
					break;
				}
				displayError(msg);
			}
		})
	});
<? else: ?>

<? endif; ?>
</script>
