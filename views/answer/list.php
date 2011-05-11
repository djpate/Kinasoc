<?
if(count($answers)>0):
	?>
	<span class="separator"><?=sprintf(ngettext("1 réponse","%s réponses",count($answers)),count($answers));?></span>
	<?
	foreach($answers as $id => $answer):
		?>
		<div id="answer<?=$answer->id;?>" class="answer_row <?if($id==0){echo "noborder ";}?> <?if($answer->isAccepted()){echo "accepted";}?>">
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
				<br />
				<? 
				if( $connected && $answer->isEditable($connected_user) ):
					?>
					<img title="<?=_("Editer cette réponse");?>" src="/images/edit.png" class="link editAnswer" id="<?=$answer->id;?>" />
					<br />
					<?
				endif;
				?>
				<? 
				if( $connected && $answer->isDeletable($connected_user) ):
					?>
					<img title="<?=_("Supprimer cette réponse");?>" src="/images/delete_bug.png" class="link deletable_handle" type="answer" rel="<?=$answer->id;?>" />
					<?
				endif;
				?>
			</div>
			<div class="answer_content">
				<div class="view_<?=$answer->id;?>">
					<?=Markdown($answer->content);?>
				</div>
			</div>
			<div style="clear:both"></div>
			<span class="user_bar_info">
				<div class="img">
					<a href="<?=\kinaf\routes::url_to("user","fiche",$answer->user);?>">
						<img src="<?=$answer->user->get_gravatar("40");?>" />
					</a>
				</div>
				<div class="user">
					<div style="margin-bottom:8px;">
						<a href="<?=\kinaf\routes::url_to("user","fiche",$answer->user);?>">
							<?=$answer->user;?>
						</a>
					</div>
					<span class="user_points">
						<?=sprintf(ngettext("%s point","%s points",$answer->user->getPoints()),$answer->user->getPoints());?>
					</span>
				</div>
			</span>
			<div style="clear:both"></div>
			
			<?
			foreach($answer->getComments() as $comment):
				?>
				<div class="comment">
					<span class="deletable">
						<?=$comment->content;?> - <span class="user"><?=$comment->user->login;?></span>
						<span class="deletable_handle"></span>
					</span>
				</div>
				<?
			endforeach;
			?>
			
			<? if($connected): ?>
			
			<div class="comment">
				<span class="ask_add link bold" rel="answer_<?=$answer->id;?>">
					<img src="/images/comment.png" align="absmiddle"/>
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
			
			<? else: ?>
			
			<div style="text-align:center;font-size:12px;margin:10px 0;">
				<a href="<?=\kinaf\routes::url_to("user","login");?>">
					<?=_("Pour ajouter un commentaire vous devez être connecté");?>
				</a>
			</div>
			
			<? endif; ?>
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
