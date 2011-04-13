<?
foreach($questions as $question):
	?>
	<div class="question">
		<div class="votes">
			<span class="number">
				<?=$question->getVote();?>
			</span>
			<span class="label">
				<?=ngettext("Vote","Votes",$question->getVote());?>
			</span>
		</div>
		
		<div class="answers">
			<span class="number">
				<?=$question->getNbAnswers();?>
			</span>
			<span class="label">
				<?=ngettext("Réponse","Réponses",$question->getNbAnswers());?>
			</span>
		</div>
		
		<div class="views">
			<span class="number">
				<?=$question->views;?>
			</span>
			<span class="label">
				<?=ngettext("Vue","Vues",$question->views);?>
			</span>
		</div>
		
		<div class="right_container">
			<h1><a href="<?=\kinaf\routes::url_to("question","view",$question);?>"><?=$question->title;?></a></h1>
			<span class="tags">
				<?
				foreach($question->getTags() as $tag):
					?>
					<a href="<?=\kinaf\routes::url_to("tags","filter",$tag);?>"><span class="tag"><?=$tag;?></span></a>
					<?
				endforeach;
				?>
			</span>
		</div>
	</div>
	<?
endforeach;
?>
