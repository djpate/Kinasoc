<?
foreach($questions as $question):
	?>
	<div class="question">
		<div class="left_container">
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
			<div style="clear:both"></div>
		</div>
		
		<div class="right_container">
			<h1><a href="<?=\kinaf\routes::url_to("question","view",$question);?>" title="<?=substr($question->content,0,250);?>..."><?=$question->title;?></a></h1>
			<div class="tags">
				<?
				foreach($question->getTags() as $tag):
					?>
					<a href="<?=\kinaf\routes::url_to("tags","filter",$tag);?>"><span class="tag"><?=$tag;?></span></a>
					<?
				endforeach;
				?>
				<?=$question->ago();?> par <span class="user"><a href="<?=\kinaf\routes::url_to("user","fiche",$question->user);?>"><?=$question->user;?></a></span> <span class="user_points"><?=sprintf(ngettext("%s point","%s points",$question->user->getPoints()),$question->user->getPoints());?></span>
			</div>
			<div style="clear:both"></div>
		</div>
		
		<div style="clear:both"></div>
		
	</div>
	<?
endforeach;
