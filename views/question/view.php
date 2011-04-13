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
	
	<div style="clear:both"></div>
	
	<span class="user_bar_info">
		<div class="img">
			<img src="<?=$question->user->get_gravatar("30");?>" />
		</div>
		<div class="user">
			<?=$question->user;?><br />
			<?=$question->user->getPoints();?>
		</div>
	</span>
	
	<div style="clear:both"></div>
	
	<?
		foreach($question->getComments() as $comment):
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
		<span class="ask_add link bold" rel="question_comm">
			<?=("Ajouter un commentaire");?>
		</span>
		<form class="commentform" onsubmit="return false" id="question_comm">
			<input type="hidden" name="question" value="<?=$question->id?>" />
			<input type="hidden" name="type" value="question" />
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
	
</div>

<div class="answer_container">
	
</div>

<? if(!$question->isAnswered()): ?>

<span class="separator"><?=_("Ajouter votre réponse");?></span>

<form class="answer_form" onsubmit="return false">
	<textarea id="answer_content" name="answer_content"></textarea>
	<div class="buttonHolder"><button type="submit" class="primaryAction"><?=_("Ajouter ma réponse");?></button></div>
</form>

<? endif; ?>

<script>
<? if($connected): ?>
	$(".questionVote").click(function(){
		$.post("<?=\kinaf\routes::url_to("question","vote",$question);?>",{"type":$(this).attr('rel')},function(data){
			if(is_int(data)){
				$("#question_vote_value").html(data);
			} else {
				switch(data){
					case 'err_1':
						var msg = "<?=_("Vous devez être connecté pour voter pour une question");?>";
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
	
	$(".answerVote").live('click',function(){
		zhis = $(this);
		$.post("<?=\kinaf\routes::url_to("question","vote_answer");?>",{"id":$(this).attr('id'),"type":$(this).attr('rel')},function(data){
			if(is_int(data)){
				$("#answer_count_"+zhis.attr('id')).html(data);
			} else {
				switch(data){
					case 'err_1':
						var msg = "<?=_("Vous devez être connecté pour voter pour une réponse");?>";
					break;
					case 'err_2':
						var msg = "<?=_("Vous ne pouvez pas voter pour votre propre réponse");?>";
					break;
					case 'err_3':
						var msg = "<?=_("Vous avez déjà voté pour cette réponse");?>";
					break;
				}
				displayError(msg);
			}
		});
	});
	
	$(".accept").live('click',function(){
		if($(this).parent().parent().hasClass("accepted")){
			//allready accepted so we choose to un-accept it
			$(this).parent().parent().removeClass("accepted");
			$(this).attr('src','/images/not_accepted.png');
		} else {
			$(".accept").attr('src','/images/not_accepted.png');
			$(".accepted").removeClass("accepted");
			$(this).parent().parent().addClass("accepted");
			$(this).attr('src','/images/accepted.png');
		}
		$.post("<?=\kinaf\routes::url_to("question","accept_answer");?>",{'id':$(this).attr('rel')});
	});
	
<? else: ?>

<? endif; ?>

function reloadAnswers(){
	$(".answer_container").load("<?=\kinaf\routes::url_to("question","answers",$question);?>");
}

reloadAnswers();

$("#answer_content").wysiwyg({
	initialContent: "",
	autoGrow: true
});

$(".primaryAction").click(function(){
	$.post("<?=\kinaf\routes::url_to("question","new_answer",$question);?>",$(".answer_form").serialize(),function(data){
		if(data == "ok"){
			$(".answer_form")[0].reset();
			reloadAnswers();
		} else {
			switch(data){
				case 'err_1':
					var msg = "<?=_("Votre réponse est trop courte");?>";
				break;
				case 'err_1':
					var msg = "<?=_("Votre devez être connecté pour proposer une réponse");?>";
				break;
			}
			displayError(msg);
		}
	})
});

$(".ask_add").live('click',function(){
	$(this).hide();
	$("#"+$(this).attr('rel')).slideDown();
});

</script>
