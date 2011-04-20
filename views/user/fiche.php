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

	<div class="info">
		<img src="<?=$user->get_gravatar(225);?>" />
	</div>

	<div class="reputation">
		reput
	</div>

	<div class="questions">
		question
	</div>

	<div class="answers">
		answers
	</div>

	<div class="favorites">
		favorites
	</div>

</div>

<script>
	$(".tabs").click(function(){
		$(".tabs_content div:visible").animate({marginLeft:'-650px'},'slow',function(){
			$(".tabs_content div:visible").hide();
		});
		$("."+$(this).attr('rel')).css('marginLeft','650');
		$("."+$(this).attr('rel')).show()
		$("."+$(this).attr('rel')).animate({marginLeft:'0px'});
	});
</script>
