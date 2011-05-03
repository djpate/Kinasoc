<div class="tabs_container">
	<h2 class="tab_title"><?=$user->login;?></h2>
	<ul>
		<li class="tabs selected" rel="info" index="1"><?=_("Information");?></li>
		<li class="tabs" rel="reputation" index="2"><?=_("Réputation");?></li>
		<li class="tabs" rel="questions" index="3"><?=_("Questions");?></li>
		<li class="tabs" rel="answers" index="4"><?=_("Réponses");?></li>
		<?/*<li class="tabs" rel="favorites" index="5">favorites</li>*/?>
	</ul>
	<div style="clear:both"></div>
</div>

<div class="tabs_content_container">

	<div class="tabs_content">

		<div class="info tcontent">
			<div class="avatar_big">
				<img src="<?=$user->get_gravatar(225);?>" />
			</div>
			<div class="user_info">
				
				<div class="info_row">
					<div class="title"><?=_("Login");?></div>
					<div class="value"><?=$user->login;?></div>
					<div style="clear:both"></div>
				</div>	
				
				<div class="info_row">
					<div class="title"><?=_("Inscription");?></div>
					<div class="value"><?=\application\helper::ago(datetime_fr_to_en($user->creationDate));?></div>
					<div style="clear:both"></div>
				</div>
				
				<div class="info_row">
					<div class="title"><?=_("A posé");?></div>
					<div class="value"><?=sprintf(ngettext("%s question","%s questions",$user->nbQuestions()),$user->nbQuestions());?></div>
					<div style="clear:both"></div>
				</div>
				
				<div class="info_row">
					<div class="title"><?=_("A Répondu à");?></div>
					<div class="value"><?=sprintf(ngettext("%s question","%s questions",$user->nbAnswers()),$user->nbAnswers());?></div>
					<div style="clear:both"></div>
				</div>
				
				<div class="info_row">
					<div class="title"><?=_("Dernière connexion");?></div>
					<div class="value"><?=\application\helper::ago(datetime_fr_to_en($user->lastLogin));?></div>
					<div style="clear:both"></div>
				</div>
				
				<div class="info_row">
					<div class="title"><?=_("Site web");?></div>
					<div class="value"><a href="<?=$user->website;?>"><?=$user->website;?></a></div>
					<div style="clear:both"></div>
				</div>
				
				<div class="info_row">
					<div class="title"><?=_("Réputation");?></div>
					<div class="value"><?=$user->getPoints();?></div>
					<div style="clear:both"></div>
				</div>
				
			</div>
			<div style="clear:both"></div>
		</div>

		<div class="reputation tcontent">
			<?
			foreach($points as $point){ 
				$event = $point['event'];
				?>
				<div class="reputation_row">
					<?
					if( $event->points > 0){ ?>
						<span class="powerup">+ <?=$event->points;?></span>
					<? } else { ?>
						<span class="powerdown">- <?=$event->points;?></span>
					<? } ?>
					<span class="labelpoint"><?=$event->label;?></span>
				</div>
			<? } ?>
		</div>

		<div class="questions tcontent">
			<div class="questions_content"></div>
		</div>

		<div class="answers tcontent">
		
		</div>

		<?/*<div class="favorites tcontent">
			<img src="<?=$user->get_gravatar(225);?>" />
		</div>*/?>
		
		<p class="spacer"></p>

	</div>

</div>

<script>
	
	$(".tabs_content div:first").show();
	
	$(".questions_content").load("<?=\kinaf\routes::url_to("user","ficheQuestionAjax",$user);?>");
	
	$(".answers").load("<?=\kinaf\routes::url_to("user","ficheAnswerAjax",$user);?>");
	
	$(".tabs").click(function(){
		
		if(!$(this).hasClass("selected")){
		
			var cur_index = $(".tabs.selected").attr('index');
			var new_index = $(this).attr('index');
		
			$(".tabs.selected").removeClass("selected");
			$(this).addClass("selected");
			
			if(cur_index < new_index){
			
				$(".tabs_content .tcontent:visible").animate({marginLeft:'-650px'},'slow',function(){
					$(this).hide();
				});
				
				$("."+$(this).attr('rel')).css('marginLeft','650px');
			
			} else {
				
				$(".tabs_content .tcontent:visible").animate({marginLeft:'650px'},'slow',function(){
					$(this).hide();
				});
				
				$("."+$(this).attr('rel')).css('marginLeft','-650px');
				
			}
			
			$("."+$(this).attr('rel')).show();
			$("."+$(this).attr('rel')).animate({marginLeft:'0'});
		
		}
		
	});
</script>
