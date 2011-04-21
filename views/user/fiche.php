<div class="tabs_container">
	<h2 class="tab_title"><?=$user->login;?></h2>
	<ul>
		<li class="tabs selected" rel="info">info</li>
		<li class="tabs" rel="reputation">reputation</li>
		<li class="tabs" rel="questions">questions</li>
		<li class="tabs" rel="answers">answers</li>
		<li class="tabs" rel="favorites">favorites</li>
	</ul>
	<div style="clear:both"></div>
</div>

<div class="tabs_content">

	<div class="info tcontent">
		<img src="<?=$user->get_gravatar(225);?>" />
	</div>

	<div class="reputation tcontent">
		<img src="<?=$user->get_gravatar(225);?>" />
		<br />
		<img src="<?=$user->get_gravatar(225);?>" />
	</div>

	<div class="questions tcontent">
		<img src="<?=$user->get_gravatar(225);?>" />
	</div>

	<div class="answers tcontent">
		<img src="<?=$user->get_gravatar(225);?>" />
	</div>

	<div class="favorites tcontent">
		<img src="<?=$user->get_gravatar(225);?>" />
	</div>
	
	<p class="spacer"></p>

</div>

<script>
	
	$(".tabs_content").height($(".tabs_content div:visible").height());
	
	$(".tabs").click(function(){
		
		if(!$(this).hasClass("selected")){
		
			$(".tabs.selected").removeClass("selected");
			$(this).addClass("selected");
			
			$(".tabs_content div:visible").animate({left:'-650px'},'slow',function(){
				$(this).hide();
			});
			
			$(".tabs_content").height($("."+$(this).attr('rel')).height());
			
			$("."+$(this).attr('rel')).css('left','650px');
			$("."+$(this).attr('rel')).show();
			$("."+$(this).attr('rel')).animate({left:'0'});
		
		}
		
	});
</script>
