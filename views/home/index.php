<div id="questions">

</div>
<div id="scrollDetector">
	<div class="loading">
		<p><?=_("Chargement")?></p>
		<img src="/images/loading_bar.gif" />
	</div>
</div>
<script>

var loading = 0;
var current_page = 1;
var question_type = '<?=$question_type;?>';
var max_page = <?=$maxPage;?>;

function isScrolledIntoView(elem){
    var docViewTop = $(window).scrollTop();
    var docViewBottom = docViewTop + $(window).height();

    var elemTop = $(elem).offset().top;
    var elemBottom = elemTop + $(elem).height();

    return ((elemBottom >= docViewTop) && (elemTop <= docViewBottom));
}

	$(window).scroll(function(){
		if(isScrolledIntoView($("#scrollDetector")) && loading == 0 && current_page < max_page ){
			loading = 1;
			current_page = current_page + 1;
			$("#scrollDetector").find(".loading").show();
			$.get("<?=\kinaf\routes::url_to("home","question_ajax");?>",{'questionType':question_type,<?if(isset($tag)){echo "'tag':".$tag->id.",";}?>'currentPage': current_page},function(data){
				loading = 0;
				$("#scrollDetector").find(".loading").hide();
				$("#questions").append(data);
			});
		}
	});
	
$(document).ready(function(){
	$("#questions").load("<?=\kinaf\routes::url_to("home","question_ajax");?>",{'questionType':question_type<?if(isset($tag)){echo ",'tag':".$tag->id.",";}?>});
});
</script>
