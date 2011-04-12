<?
if(count($answers)>0):
	?>
	<span class="separator"><?=sprintf(ngettext("1 réponse","%s réponses",count($answers)),count($answers));?></span>
	<?
	foreach($answers as $answer):
		?>
		<div class="answer_row <?if($answer->isAccepted()){echo "accepted";}?>">
			<div class="answer_vote">
				<?
				if($answer->isAccepted()):
					?>
					<img src="/images/accepted.png" class="link accept" rel="<?=$answer->id;?>">
					<?
				elseif($answer->question->user == $connected_user):
					?>
					<img src="/images/not_accepted.png" class="link accept" rel="<?=$answer->id;?>">
					<?
				endif;
				?>
				<img src="/images/thumbs_up.png" class="link answerVote" rel="up" id="<?=$answer->id;?>" />
				<br />
				<span id="answer_count_<?=$answer->id;?>">
					<?=$answer->getVote();?>
				</span>
				<br />
				<img src="/images/thumbs_down.png" class="link answerVote" rel="down" id="<?=$answer->id;?>" />
			</div>
			<div class="answer_content">
				<?=$answer->content;?>
			</div>
			<div style="clear:both"></div>
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
		</div>
		<?
	endforeach;
endif;
?>
