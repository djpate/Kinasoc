<?
include(dirname(__FILE__)."/../home/question_ajax.php");
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
