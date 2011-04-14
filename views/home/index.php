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
			<div style="width:100px;float:right;background-color:#E7EBF7;height:auto;margin-top:-11px;padding:1px">
				<span style="margin-right:10px;">
					<img style="float:left;margin-right:5px" src="<?=$question->user->get_gravatar("30");?>" />
					<?=$question->user->login;?><br />
					<?=$question->user->getPoints();?>
				</span>
			</div>
		</div>
	</div>
	<?
endforeach;
?>
