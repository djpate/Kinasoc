<div id="container"></div>

<script>
	$(document).ready(function(){
		$("#container").load("/admin/listing/<?=$current_category;?>/<?=$current_module;?>");
		
		$(".list_pg").live('click',function(){
			$("#current_page").val($(this).attr('rel'));
			updateListing();
		});
		
		$(".filter_btn").live('click',function(){
			$("#container").load("/admin/listing/<?=$current_category;?>/<?=$current_module;?>",$("#formFilter").serialize());
		});
		
		$(".sortable").live('click',function(){
			
			if(!$(this).hasClass("currentSort")){
				$(".currentSort").removeClass("sortAsc");
				$(".currentSort").removeClass("sortDesc");
				$(".currentSort").removeClass("currentSort");
				$(this).addClass("currentSort");
				$("#current_order").val($(this).attr('rel'));
			}
			
			
			if($(this).hasClass("sortAsc")){
				$(this).removeClass("sortAsc");
				$(this).addClass("sortDesc");
				$("#current_order_sens").val("desc");
			} else {
				$(this).removeClass("sortDesc");
				$(this).addClass("sortAsc");
				$("#current_order_sens").val("asc");
			}
			
			updateListing();
			
		});
		
		$(".link_fiche").live('click',function(){
			location.href = '/admin/<?=$current_category;?>/<?=$current_module;?>/' + $(this).attr('rel');
		});
		
		$(".mass_operation").live('click',function(){
			if($(".mass_checkbox:checked").length>0){
				$.post("/admin/mass_operation",{'object':'<?=$current_module;?>','method':$(this).attr('rel'),'collection':$(".mass_checkbox:checked").serialize()},function(){
					$("#container").load("/admin/listing/<?=$current_category;?>/<?=$current_module;?>");
				});
			} else {
				alert("Vous n'avez rien selectionné");
			}
		});
		
		$(".mass_selector").live('change',function(){
			if($(this).is(":checked")){
				$(".mass_checkbox").attr('checked',true);
			} else {
				$(".mass_checkbox").attr('checked',false);
			}
		});
	});
	
	function updateListing(){
		$("#container").load("/admin/listing/<?=$current_category;?>/<?=$current_module;?>",$("#currentPageInfo").serialize()+"&"+$("#formFilter").serialize());
	}
</script>
