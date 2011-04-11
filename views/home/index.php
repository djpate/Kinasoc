<?
foreach($questions as $question):
	?>
	<div class="question">
		<div class="votes">
			<span class="number">
				<?=$question->getVote();?>
			</span>
			<span class="label">
				<?=_("Votes");?>
			</span>
		</div>
		
		<div class="answers">
			<span class="number">
				<?=$question->getNbAnswers();?>
			</span>
			<span class="label">
				<?=_("Answers");?>
			</span>
		</div>
		
		<div class="views">
			<span class="number">
				<?=$question->views;?>
			</span>
			<span class="label">
				<?=_("Views");?>
			</span>
		</div>
		
		<div class="right_container">
			<h1><a href="<?=\kinaf\routes::url_to("question","view",$question);?>"><?=$question->title;?></a></h1>
		</div>
	</div>
	<?
endforeach;
?>
