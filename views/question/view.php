<div class="question_view <? if( $connected && $question->user->id == $connected_user->id ) { echo "deletable"; }?>">
<span class="deletable_handle" type="question"></span>
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
	
		<?=Markdown($question->content);?>
		
	</div>
	
	<div style="clear:both"></div>
	
	<span class="user_bar_info">
		<div class="img">
			<img src="<?=$question->user->get_gravatar("40");?>" />
		</div>
		<div class="user">
			<div style="margin-bottom:8px;">
				<?=$question->user;?>
			</div>
			<span class="user_points">
				<?=sprintf(ngettext("%s point","%s points",$question->user->getPoints()),$question->user->getPoints());?>
			</span>
		</div>
	</span>
	
	<div style="clear:both"></div>
	
	<?
		foreach($question->getComments() as $comment):
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
	
	<? if ( $connected ) : ?>
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
	
	<? else: ?>
	
	<div style="text-align:center;font-size:14px">
		<a href="<?=\kinaf\routes::url_to("user","login");?>">
			<?=_("Pour ajouter un commentaire vous devez être connecté");?>
		</a>
	</div>
	
	<? endif; ?>
	
</div>

<div class="answer_container">
	
</div>

<? if( !$question->isAnswered() ): ?>

	<span class="separator"><?=_("Ajouter votre réponse");?></span>

	<? if( $connected ): ?>

	<form class="answer_form" onsubmit="return false">
		
		<div id="wmd-editor" class="wmd-panel">
			<div id="wmd-button-bar"></div>
			<textarea id="wmd-input" name="answer_content"></textarea>
		</div>
		<span class="separator"><?=_("Prévisualisation");?></span>
		<div id="wmd-preview" class="wmd-panel"></div>

		<div class="buttonHolder"><button type="submit" class="primaryAction"><?=_("Ajouter ma réponse");?></button></div>
	</form>

	<? else: ?>
	
		<div style="text-align:center;font-size:14px">
			<a href="<?=\kinaf\routes::url_to("user","login");?>">
				<?=_("Pour ajouter votre réponse vous devez être connecté");?>
			</a>
		</div>

	<? endif;?>

<? endif; ?>

<div id="dialog" title="Modification">
	<textarea id="editPop" style="width: 100%"></textarea>
</div>

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
		$.post("<?=\kinaf\routes::url_to("answer","vote");?>",{"id":$(this).attr('id'),"type":$(this).attr('rel')},function(data){
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
		$.post("<?=\kinaf\routes::url_to("answer","accept");?>",{'id':$(this).attr('rel')});
	});
	
<? else: ?>

	$(".questionVote").click(function(){
		displayError("<?=_("Vous devez être connecté pour voter pour une question");?>");
	});

<? endif; ?>

function reloadAnswers(){
	$(".answer_container").load("<?=\kinaf\routes::url_to("answer","list",$question);?>");
}

reloadAnswers();

$(".primaryAction").click(function(){
	$.post("<?=\kinaf\routes::url_to("answer","new",$question);?>",$(".answer_form").serialize(),function(data){
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

$("#dialog").dialog({
	autoOpen: false,
	modal: true,
	width: 600,
	height: 400
	
});

$(".editAnswer").live('click',function(){
	$("#dialog").dialog('open');
});


$(".deletable_handle").live('click',function(){
	switch($(this).attr('type')){
		case 'question':
			$.post("<?=\kinaf\routes::url_to("question","delete",$question);?>",function(data){
				location.href = "<?=\kinaf\routes::url_to("home","index");?>";
			});
		break;
		case 'answer':
			$.post("<?=\kinaf\routes::url_to("answer","delete");?>",{'id':$(this).attr('rel')},function(data){
				reloadAnswers();
			});
		break;
	}
});

</script>

<?
if($connected && !$question->isAnswered() ){
	?>
	<script type="text/javascript" src="/js/jquery.wmd.min.js"></script>
	<?
}
?>
