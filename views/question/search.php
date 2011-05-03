<h3 class="title"><?=sprintf(_("Recherche : %s"),strip_tags(htmlentities($_REQUEST['q'])));?></h3>
<div id="container">

</div>

<script>
	$(document).ready(function(){
		$("#container").load("<?=\kinaf\routes::url_to("question","search_ajax");?>",{'q':'<?=strip_tags(htmlentities($_REQUEST['q'],ENT_QUOTES));?>'});
	});
</script>
