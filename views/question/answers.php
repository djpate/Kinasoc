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
			
			<?
			foreach($answer->getComments() as $comment):
				?>
				<div class="comment">
					<span>
						<?=$comment->content;?> - <span class="user"><?=$comment->user->login;?></span>
					</span>
				</div>
				<?
			endforeach;
			?>
			
			<div class="comment">
				<span class="ask_add link bold" rel="answer_<?=$answer->id;?>">
					<?=_("Ajouter un commentaire");?>
				</span>
				<form class="commentform" onsubmit="return false" id="answer_<?=$answer->id;?>">
					<input type="hidden" name="answer" value="<?=$answer->id?>" />
					<input type="hidden" name="type" value="answer" />
					<div style="width:80%;float:left">
						<textarea name="content" class="required" minlength="<?=$params['minComment'];?>"></textarea>
					</div>
					<div style="width:20%;float:left;">
						<div style="padding-left:10px">
							<input type="submit" value="<?=_("Commenter");?>">
						</div>
					</div>
					<div style="clear:both"></div>
				</form>
			</div>
			
			<span class="separator"></span>
		</div>
		<?
	endforeach;
endif;
?>
<script>

	
	$(".commentform").each(function() {
		$(this).validate({
			submitHandler: function(form){
				$.post("<?=\kinaf\routes::url_to("comments","add");?>",$(form).serialize(),function(data){
					if(data == "ok"){
						$("<div class='comment'><span>"+$(form).find("textarea").val()+" - <span class='user'><?=$connected_user->login;?></span></span></div>").insertBefore($(form).parent()).effect("highlight", {}, 3000);
						$("form").hide();
						$("form").prev().show();
						form.reset();
					}
				});
			}
		});
	});
	
</script>
