<?
include(dirname(__FILE__)."/../home/question_ajax.php");
if(count($questions)==0){
	echo _("Aucune question trouvé");
}
?>
<div class="paginationContent">
<?
echo $pagination->display();
?>
</div>
<script>
	$(".page").click(function(){
		$(".question:first").parent().load("<?=$route;?>",{ 'page' : $(this).attr('rel') });
	});
</script>
