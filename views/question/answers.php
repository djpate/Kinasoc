<?
if(count($answers)>0):
	?>
	<span class="separator"><?=sprintf(ngettext("1 réponse","%s réponses",count($answers)),count($answers));?></span>
	<?
	foreach($answers as $answer):
		?>
		<div class="answer_vote">
			<img src="/images/thumbs_up.png" class="link answerVote" rel="up" id="<?=$answer->id;?>" />
			<br />
			<?=$answer->getVote();?>
			<br />
			<img src="/images/thumbs_down.png" class="link answerVote" rel="down" id="<?=$answer->id;?>" />
		</div>
		<div class="answer_content">
			<?=$parser->transform($answer->content);?>
		</div>
		<span class="user_bar_info">
			<div class="img">
				<img src="<?=$answer->user->get_gravatar("30");?>" />
			</div>
			<div class="user">
				<?=$answer->user;?><br />
				<?=$answer->user->getPoints();?>
			</div>
		</span>
		<div style="clear:both"></div>
		<span class="separator"></span>
		<?
	endforeach;
endif;
?>
